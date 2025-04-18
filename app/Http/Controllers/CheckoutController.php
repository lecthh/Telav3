<?php

namespace App\Http\Controllers;

use App\Models\AddressInformation;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Notification;
use App\Models\Order;
use App\Models\OrderImages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\OrderStatus;
use App\Traits\Toastable;
use Illuminate\Support\Facades\Mail;

class CheckoutController extends Controller
{
    use Toastable;

    public function checkout()
    {
        $cartItems = session()->get('selected_cart_items', []);
        if (!is_object($cartItems) || !method_exists($cartItems, 'isEmpty')) {
            $cartItems = collect($cartItems);
        }

        $user = Auth::user();
        $contactInformation = $user->addressInformation;

        Log::info('Cart items in checkout:', ['items' => $cartItems->toArray()]);
        return view('cart.checkout', compact('cartItems', 'user'));
    }

    public function postCheckout(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'contact_number' => 'required|string',
                'name'           => 'required|string',
                'address'        => 'required|string',
                'state'          => 'required|string',
                'city'           => 'required|string',
                'zip_code'       => 'required|string',
            ]);

            $user = Auth::user();

            // Save address details
            $addressInformation = AddressInformation::updateOrCreate(
                ['user_id' => $user->user_id],
                [
                    'phone_number' => $validatedData['contact_number'],
                    'address'      => $validatedData['address'],
                    'state'        => $validatedData['state'],
                    'city'         => $validatedData['city'],
                    'zip_code'     => $validatedData['zip_code'],
                ]
            );

            // Get selected cart items from session
            $selectedCartItems = session()->get('selected_cart_items', []);
            if (empty($selectedCartItems)) {
                $this->toast('No items selected for checkout.', 'error');
                return back();
            }

            $cartItems = collect($selectedCartItems);

            DB::beginTransaction();

            $createdOrders = [];

            foreach ($cartItems as $cartItemId) {
                $cartItem = CartItem::with([
                    'apparelType', 
                    'productionCompany', 
                    'productionType', 
                    'cartItemImages'
                ])
                ->where('cart_item_id', $cartItemId->cart_item_id)
                ->first();

                if ($cartItem) {
                    $isBulkOrder = ($cartItem->orderType == 'bulk');
                    $isCustomized = ($cartItem->customization == 'personalized');

                    $order = Order::create([
                        'order_id'              => uniqid(),
                        'user_id'               => $user->user_id,
                        'production_company_id' => $cartItem->production_company_id,
                        'assigned_designer_id'  => null,
                        'is_customized'         => $isCustomized,
                        'is_bulk_order'         => $isBulkOrder,
                        'quantity'              => $cartItem->quantity,
                        'status_id'             => OrderStatus::STATUS_ORDER_PLACED,
                        'apparel_type'          => $cartItem->apparel_type_id,
                        'production_type'       => $cartItem->production_type,
                        'downpayment_amount'    => $cartItem->downpayment ?? ($cartItem->price * $cartItem->quantity / 2),
                        'final_price' => $cartItem->total_price ?? ($cartItem->price * $cartItem->quantity),
                        'custom_design_info'    => $cartItem->description,
                        'revision_count'        => 0,
                    ]);

                    $createdOrders[] = [
                        'order' => $order,
                        'cartItem' => $cartItem
                    ];

                    foreach ($cartItem->cartItemImages as $image) {
                        OrderImages::create([
                            'order_id'  => $order->order_id,
                            'image'     => $image->image,
                            'status_id' => 1,
                        ]);
                    }

                    $cartItem->delete();

                    // Notification for customer
                    Notification::create([
                        'user_id'  => $user->user_id,
                        'message'  => 'Your order has been placed successfully.',
                        'is_read'  => false,
                        'order_id' => $order->order_id,
                    ]);
                    
                    // Notification for production company/printer
                    Notification::create([
                        'user_id'  => $cartItem->productionCompany->user_id,
                        'message'  => 'New order received: #' . $order->order_id,
                        'is_read'  => false,
                        'order_id' => $order->order_id,
                    ]);
                }
            }

            session()->forget('selected_cart_items');

            DB::commit();

            // Send receipt email for each order
            foreach ($createdOrders as $orderData) {
                // Reload the order with all relationships to ensure we have complete data
                $order = Order::with(['user', 'productionCompany', 'apparelType', 'productionType'])
                    ->where('order_id', $orderData['order']->order_id)
                    ->first();
                    
                $this->sendOrderReceipt($order ?? $orderData['order'], $orderData['cartItem']);
            }

            $this->toast('Order placed successfully!', 'success');
            return redirect()->route('customer.confirmation');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Order Checkout Error: ' . $e->getMessage());

            $this->toast('An error occurred while processing your order.', 'error');
            return back();
        }
    }

    public function deleteCartItem($cartItemId)
    {
        try {
            $selectedCartItems = session()->get('selected_cart_items', []);

            if (!$cartItemId) {
                $this->toast('Invalid cart item.', 'error');
                return redirect()->route('customer.cart');
            }

            DB::table('cart_items')->where('cart_item_id', $cartItemId)->delete();

            $updatedCartItems = collect($selectedCartItems)->reject(function ($item) use ($cartItemId) {
                return $item->cart_item_id == $cartItemId;
            })->values()->all();

            session()->put('selected_cart_items', $updatedCartItems);

            if (empty($updatedCartItems)) {
                $this->toast('Cart is empty, redirected to cart page.', 'info');
                return redirect()->route('customer.cart');
            }

            $this->toast('Cart item removed successfully.', 'success');
            return redirect()->route('customer.checkout');
        } catch (\Exception $e) {
            Log::error('Cart Item Deletion Error: ' . $e->getMessage());

            $this->toast('An error occurred while removing the item.', 'error');
            return redirect()->route('customer.cart');
        }
    }
    
    /**
     * Send order receipt email to customer
     * 
     * @param Order $order
     * @param CartItem $cartItem
     * @return void
     */
    private function sendOrderReceipt($order, $cartItem)
    {
        try {
            $user = $order->user;
            $productionCompany = $order->productionCompany;
            $receiptNumber = 'RCP-' . date('Ymd') . '-' . substr($order->order_id, -8);
            
            // Get apparel and production type info, falling back to cart item if relationship not loaded yet
            $apparelType = 'N/A';
            if ($order->apparelType) {
                $apparelType = $order->apparelType->name;
            } elseif ($cartItem && $cartItem->apparelType) {
                $apparelType = $cartItem->apparelType->name;
            }
            
            $productionType = 'N/A';
            if ($order->productionType) {
                $productionType = $order->productionType->name;
            } elseif ($cartItem && $cartItem->productionType) {
                $productionType = $cartItem->productionType->name;
            }
            
            $balanceDue = $order->final_price - $order->downpayment_amount;
            
            $receiptData = [
                'receipt_number' => $receiptNumber,
                'date' => now()->format('F d, Y'),
                'customer_name' => $user->name,
                'customer_email' => $user->email,
                'order_id' => $order->order_id,
                'production_company' => $productionCompany->company_name,
                'apparel_type' => $apparelType,
                'production_type' => $productionType,
                'quantity' => $order->quantity,
                'is_bulk' => $order->is_bulk_order,
                'is_customized' => $order->is_customized,
                'downpayment' => $order->downpayment_amount,
                'total_price' => $order->final_price,
                'balance_due' => $balanceDue,
            ];
            
            // Send email with receipt
            Mail::send('customer.payment.checkout-receipt', $receiptData, function ($message) use ($user, $receiptNumber) {
                $message->to($user->email);
                $message->subject('Order Receipt #' . $receiptNumber);
            });
            
            Log::info('Order receipt sent to customer', [
                'order_id' => $order->order_id,
                'receipt_number' => $receiptNumber,
                'email' => $user->email
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to send order receipt: ' . $e->getMessage(), [
                'order_id' => $order->order_id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        }
    }
}
