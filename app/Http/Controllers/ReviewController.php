<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\Order;
use App\Models\ProductionCompany;
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
        // For now, this is a placeholder since reviews aren't fully implemented
        $order = Order::where('order_id', $orderId)
            ->where('user_id', Auth::id())
            ->firstOrFail();
            
        return view('customer.review.create', compact('order'));
    }

    /**
     * Store a new review for a production company.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeReview(Request $request)
    {
        // Validate the request
        $request->validate([
            'order_id' => 'required|exists:orders,order_id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|min:10|max:500',
        ]);
        
        // Get the order and verify it belongs to the current user
        $order = Order::where('order_id', $request->order_id)
            ->where('user_id', Auth::id())
            ->firstOrFail();
            
        $productionCompany = $order->productionCompany;
        
        // Check if a review already exists for this order
        $existingReview = Review::where('order_id', $order->order_id)->first();
        
        if ($existingReview) {
            $this->toast('You have already submitted a review for this order.', 'error');
            return redirect()->route('customer.profile.orders');
        }
        
        // Create the review
        $review = Review::create([
            'order_id' => $order->order_id,
            'user_id' => Auth::id(),
            'production_company_id' => $productionCompany->id,
            'rating' => $request->rating,
            'comment' => $request->comment,
            'is_visible' => true,
        ]);
        
        // Update the production company's average rating
        $productionCompany->updateAverageRating();
        
        // Create notification for the production company about the new review
        Notification::create([
            'user_id' => $productionCompany->user_id,
            'message' => 'New review received for order #' . $order->order_id,
            'is_read' => false,
            'order_id' => $order->order_id,
        ]);
        
        $this->toast('Thank you for your review!', 'success');
        return redirect()->route('customer.profile.orders');
    }
}