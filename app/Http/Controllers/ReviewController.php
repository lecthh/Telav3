<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\Order;
use App\Models\ProductionCompany;
use App\Models\Designer;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Traits\Toastable;

class ReviewController extends Controller
{
    use Toastable;

    /**
     * Show the review form for a specific order.
     *
     * @param string $orderId
     * @return \Illuminate\View\View
     */
    public function showReviewForm($orderId)
    {
        $order = Order::where('order_id', $orderId)
            ->where('user_id', Auth::id())
            ->firstOrFail();
            
        return view('customer.review.create', compact('order'));
    }

    /**
     * Store reviews for both production company and designer.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeReview(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,order_id',
            'company_rating' => 'required|integer|min:1|max:5',
            'company_comment' => 'required|string|min:10|max:500',
            'designer_rating' => 'nullable|integer|min:1|max:5',
            'designer_comment' => 'nullable|string|min:10|max:500',
        ]);
        
        $order = Order::where('order_id', $request->order_id)
            ->where('user_id', Auth::id())
            ->firstOrFail();
            
        $productionCompany = $order->productionCompany;
        
        $existingCompanyReview = Review::where('order_id', $order->order_id)
            ->where('production_company_id', $productionCompany->id)
            ->where('review_type', 'company')
            ->first();
        
        if (!$existingCompanyReview) {
            $companyReview = Review::create([
                'order_id' => $order->order_id,
                'user_id' => Auth::id(),
                'production_company_id' => $productionCompany->id,
                'rating' => $request->company_rating,
                'comment' => $request->company_comment,
                'is_visible' => true,
                'review_type' => 'company',
            ]);
            
            $productionCompany->updateAverageRating();
            
            // Only send notification to production company, not to customer
            if ($productionCompany->user_id != Auth::id()) {
                Notification::create([
                    'user_id' => $productionCompany->user_id,
                    'message' => 'New review received for order #' . $order->order_id,
                    'is_read' => false,
                    'order_id' => $order->order_id,
                ]);
            }
        }
        
        if ($request->has('designer_rating') && $request->has('designer_comment') && $order->assigned_designer_id) {
            $existingDesignerReview = Review::where('order_id', $order->order_id)
                ->where('designer_id', $order->assigned_designer_id)
                ->where('review_type', 'designer')
                ->first();
                
            if (!$existingDesignerReview) {
                $designerReview = Review::create([
                    'order_id' => $order->order_id,
                    'user_id' => Auth::id(),
                    'designer_id' => $order->assigned_designer_id,
                    'rating' => $request->designer_rating,
                    'comment' => $request->designer_comment,
                    'is_visible' => true,
                    'review_type' => 'designer',
                ]);
                
                if ($order->designer && method_exists($order->designer, 'updateAverageRating')) {
                    $order->designer->updateAverageRating();
                }
                
                if ($order->designer && $order->designer->user) {
                    // Only send notification if the designer isn't the same as the reviewer
                    if ($order->designer->user->user_id != Auth::id()) {
                        Notification::create([
                            'user_id' => $order->designer->user->user_id,
                            'message' => 'New review received for order #' . $order->order_id,
                            'is_read' => false,
                            'order_id' => $order->order_id,
                        ]);
                    }
                }
            }
        }
        
        $this->toast('Thank you for your review!', 'success');
        return redirect()->route('customer.profile.orders');
    }
}