<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\Order;
use App\Models\OrderImages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Log;
use App\Traits\Toastable;

class DesignerOrderController extends Controller
{
    use Toastable;
    public function dashboard()
    {
        try {
            $designer = $this->getOrCreateDesignerSession();
            
            if (!$designer) {
                Log::error('Designer session not found and could not be recovered');
                return redirect()->route('login')->with('error', 'Designer session not found');
            }
            
            Log::info('Designer dashboard rendered successfully', [
                'designer_id' => $designer->designer_id ?? null,
                'user_id' => auth()->id()
            ]);
    
            $assignedOrdersCount = Order::where('assigned_designer_id', $designer->designer_id)
                ->where('status_id', '>=', 2)
                ->where('status_id', '!=', 7)
                ->count();
    
            $completedOrdersCount = Order::where('assigned_designer_id', $designer->designer_id)
                ->where('status_id', 7)
                ->count();
                
            $recentOrders = Order::where('assigned_designer_id', $designer->designer_id)
                ->where('status_id', '>=', 2)
                ->where('status_id', '!=', 7)
                ->orderBy('created_at', 'desc')
                ->take(3)
                ->get();
                
            $totalOrdersHandled = $assignedOrdersCount + $completedOrdersCount;
            
            //monthly assigned and completed orders for last 6 months
            $monthlyAssigned = [];
            $monthlyCompleted = [];
            $monthlyLabels = [];
            
            for ($i = 5; $i >= 0; $i--) {
                $month = now()->subMonths($i);
                $startOfMonth = $month->copy()->startOfMonth();
                $endOfMonth = $month->copy()->endOfMonth();
                
                $assignedCount = Order::where('assigned_designer_id', $designer->designer_id)
                    ->where('status_id', '>=', 2)
                    ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
                    ->count();
                    
                $completedCount = Order::where('assigned_designer_id', $designer->designer_id)
                    ->where('status_id', 7)
                    ->whereBetween('updated_at', [$startOfMonth, $endOfMonth])
                    ->count();
                    
                $monthlyAssigned[] = $assignedCount;
                $monthlyCompleted[] = $completedCount;
                $monthlyLabels[] = $month->format('M');
            }
            
            $monthlyAssignedJSON = json_encode($monthlyAssigned);
            $monthlyCompletedJSON = json_encode($monthlyCompleted);
            $monthlyLabelsJSON = json_encode($monthlyLabels);
    
            return view('partner.designer.dashboard', compact(
                'designer', 
                'assignedOrdersCount', 
                'completedOrdersCount',
                'recentOrders',
                'totalOrdersHandled',
                'monthlyAssignedJSON',
                'monthlyCompletedJSON',
                'monthlyLabelsJSON'
            ));
        } catch (\Exception $e) {
            Log::error('Error in designer dashboard: ' . $e->getMessage(), [
                'exception' => $e
            ]);
            return redirect()->route('login')->with('error', 'An error occurred loading the dashboard');
        }
    }

    public function cancelDesignAssignment($order_id)
    {
        try {
            $order = Order::findOrFail($order_id);
            $order->assigned_designer_id = null;
            $order->status_id = 1;
            $order->save();

            $this->toast('Design assignment cancelled successfully!', 'success');
            return redirect()->route('designer-dashboard');
        } catch (\Exception $e) {
            Log::error('Cancel Design Assignment Error: ' . $e->getMessage());
            $this->toast('An error occurred while canceling the design assignment.', 'error');
            return redirect()->back();
        }
    }



    public function index()
    {
        $designer = $this->getOrCreateDesignerSession();
        
        if (!$designer) {
            Log::error('Designer session not found in index method');
            return redirect()->route('login')->with('error', 'Designer session not found');
        }
        
        $assignedOrders = Order::where('assigned_designer_id', $designer->designer_id)
            ->where('status_id', '>=', 2)
            ->where('status_id', '!=', 7)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('partner.designer.orders', compact('assignedOrders'));
    }

    public function assignedOrder($order_id)
    {
        $designer = $this->getOrCreateDesignerSession();
        
        if (!$designer) {
            return redirect()->route('login')->with('error', 'Designer session not found');
        }
        
        $order = Order::find($order_id);
        return view('partner.designer.order', compact('order', 'designer'));
    }

    public function assignedOrderPost(Request $request, $order_id)
    {
        try {
            $request->validate([
                'vacancyImageFiles' => 'required',
                'vacancyImageFiles.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:102400',
            ]);

            $order = Order::findOrFail($order_id);

            if ($request->hasFile('vacancyImageFiles')) {
                foreach ($request->file('vacancyImageFiles') as $file) {
                    $filePath = $file->store('order_images', 'public');
                    OrderImages::create([
                        'order_id' => $order->order_id,
                        'image' => $filePath,
                        'status_id' => 2,
                    ]);
                }
            }

            $order->status_id = 3;
            $order->save();

            $user_id = $order->user->user_id;

            // Notification for customer to finalize order
            Notification::create([
                'user_id' => $user_id,
                'message' => 'Finalize Order',
                'is_read' => false,
                'order_id' => $order->order_id,
            ]);

            // Second notification for customer about confirmation link
            Notification::create([
                'user_id' => $user_id,
                'message' => 'A confirmation link has been sent to your email. Please confirm your order.',
                'is_read' => false,
                'order_id' => $order->order_id,
            ]);
            
            // Notification for production company/printer that design is completed
            Notification::create([
                'user_id' => $order->productionCompany->user_id,
                'message' => 'Design completed for order #' . $order->order_id,
                'is_read' => false,
                'order_id' => $order->order_id,
            ]);

            $designer = $order->designer->user->name;
            $token = uniqid();
            $user = $order->user;
            $url = null;

            // Generate the appropriate URL based on order type
            if ($order->is_bulk_order) {
                if (!$order->is_customized) {
                    // Bulk order with standard sizes
                    $url = URL::temporarySignedRoute(
                        'confirm-bulk',
                        now()->addMinutes(60),
                        ['token' => $token, 'email' => $user->email, 'order_id' => $order->order_id]
                    );
                } else if ($order->is_customized && $order->apparelType->id != 1) {
                    // Bulk order with customization (non-jersey)
                    $url = URL::temporarySignedRoute(
                        'confirm-bulk-custom',
                        now()->addMinutes(60),
                        ['token' => $token, 'email' => $user->email, 'order_id' => $order->order_id]
                    );
                } else if ($order->is_customized && $order->apparelType->id == 1) {
                    // Bulk order with jersey customization
                    $url = URL::temporarySignedRoute(
                        'confirm-jerseybulk-custom',
                        now()->addMinutes(60),
                        ['token' => $token, 'email' => $user->email, 'order_id' => $order->order_id]
                    );
                }
            } else {
                // Single orders with customization
                if ($order->is_customized) {
                    Log::info('Single customized order confirmation');
                    $url = URL::temporarySignedRoute(
                        'confirm-single-custom',
                        now()->addMinutes(60),
                        ['token' => $token, 'email' => $user->email, 'order_id' => $order->order_id]
                    );
                } else {
                    // Single orders with standard sizes
                    $url = URL::temporarySignedRoute(
                        'confirm-single',
                        now()->addMinutes(60),
                        ['token' => $token, 'email' => $user->email, 'order_id' => $order->order_id]
                    );
                }
            }

            $name = $user->name;
            $order->update(['token' => $token]);
            $order->save();

            Log::info('Sending confirmation email', [
                'order_id' => $order->order_id,
                'user_email' => $user->email,
                'is_bulk' => $order->is_bulk_order,
                'is_customized' => $order->is_customized,
                'apparel_type_id' => $order->apparelType->id,
                'url' => $url,
            ]);

            // Send email only if we have a URL
            if ($url) {
                Mail::send('mail.confirmationLink', ['url' => $url, 'name' => $name, 'Designer' => $designer], function ($message) use ($user) {
                    $message->to($user->email);
                    $message->subject('Order Is Confirmed');
                });
            } else {
                Log::error('No confirmation URL generated for order', [
                    'order_id' => $order->order_id,
                    'is_bulk' => $order->is_bulk_order,
                    'is_customized' => $order->is_customized
                ]);
            }

            $this->toast('Designs uploaded and order finalized successfully!', 'success');
            return redirect()->route('partner.designer.orders');
        } catch (\Exception $e) {
            Log::error('Assigned Order Processing Error: ' . $e->getMessage());
            $this->toast('An error occurred while processing the order.', 'error');
            return redirect()->back();
        }
    }

    public function complete()
    {
        $designer = $this->getOrCreateDesignerSession();
        
        if (!$designer) {
            return redirect()->route('login')->with('error', 'Designer session not found');
        }
        
        $orders = Order::where('assigned_designer_id', $designer->designer_id)
            ->where('status_id', '=', 7)
            ->orderBy('created_at', 'desc') // Order by newest first
            ->get();
        return view('partner.designer.complete.orders-complete', compact('orders'));
    }

    public function completeOrder($order_id)
    {
        $designer = $this->getOrCreateDesignerSession();
        
        if (!$designer) {
            return redirect()->route('login')->with('error', 'Designer session not found');
        }
        
        $order = Order::find($order_id);
        return view('partner.designer.complete.order', compact('order', 'designer'));
    }
    
    /**
     * Get designer data from session or create it if needed
     * 
     * @return \App\Models\Designer|null
     */
    private function getOrCreateDesignerSession()
    {
        $designer = session('admin');
        
        Log::info('Designer session check', [
            'session_has_admin' => session()->has('admin'),
            'designer' => $designer ? (is_object($designer) ? get_class($designer) : gettype($designer)) : null,
            'auth_id' => auth()->id(),
            'user_role' => auth()->user()->role_type_id ?? 'none'
        ]);
        
        // If session admin is missing, try to recover it from the database
        if ((empty($designer) || !($designer instanceof \App\Models\Designer)) && auth()->check() && auth()->user()->role_type_id == 3) {
            $designer = \App\Models\Designer::where('user_id', auth()->id())->first();
            if ($designer) {
                session(['admin' => $designer]);
                Log::info('Created or restored designer session data', [
                    'designer_id' => $designer->designer_id,
                    'user_id' => auth()->id()
                ]);
            } else {
                Log::error('Could not find designer record for authenticated user', [
                    'user_id' => auth()->id(),
                    'email' => auth()->user()->email
                ]);
            }
        }
        
        return $designer;
    }
}
