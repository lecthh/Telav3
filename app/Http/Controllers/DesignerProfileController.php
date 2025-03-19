<?php

namespace App\Http\Controllers;

use App\Models\Designer;
use App\Models\ProductionCompany;
use App\Models\User;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Traits\Toastable;

class DesignerProfileController extends Controller
{
    use Toastable;

    public function basics()
    {
        $user = Auth::user();
        $designer = Designer::where('user_id', $user->user_id)->firstOrFail();
        $productionCompanies = ProductionCompany::all();

        return view('partner.designer.profile.basics', compact('designer', 'productionCompanies'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $designer = Designer::where('user_id', $user->user_id)->firstOrFail();

        if ($designer->production_company_id || $request->is_freelancer == 0) {
            $request->validate([
                'name' => 'required|string|max:255',
                'designer_description' => 'nullable|string|max:1000',
                'is_freelancer' => 'required|boolean',
                'production_company_id' => 'nullable|exists:production_companies,id',
            ]);
        } else {
            $request->validate([
                'name' => 'required|string|max:255',
                'designer_description' => 'nullable|string|max:1000',
                'talent_fee' => 'required|numeric|min:0',
                'max_free_revisions' => 'required|integer|min:0',
                'addtl_revision_fee' => 'required|numeric|min:0',
                'is_freelancer' => 'required|boolean',
                'production_company_id' => 'nullable|exists:production_companies,id',
            ]);
        }


        $user->name = $request->name;
        $user->save();

        $designer->designer_description = $request->designer_description;
        $designer->talent_fee = $request->talent_fee;
        $designer->max_free_revisions = $request->max_free_revisions;
        $designer->addtl_revision_fee = $request->addtl_revision_fee;
        $designer->is_freelancer = $request->is_freelancer;
        $designer->is_available = $request->has('is_available');

        if (!$designer->production_company_id && !$designer->is_freelancer) {
            $designer->production_company_id = $request->production_company_id;
        }

        $designer->save();

        $this->toast('Profile updated successfully!', 'success');
        return redirect()->route('partner.designer.profile.basics');
    }

    public function reviews()
    {
        $user = Auth::user();
        $designer = Designer::where('user_id', $user->user_id)->firstOrFail();
        
        $designerReviews = Review::where('designer_id', $designer->designer_id)
                               ->where('review_type', 'designer')
                               ->get();
        
        $avgRating = $designerReviews->avg('rating') ?: 0;
        $reviewCount = $designerReviews->count();
        
        $ratingDistribution = [
            5 => Review::where('designer_id', $designer->designer_id)
                      ->where('review_type', 'designer')
                      ->where('rating', 5)
                      ->count(),
            4 => Review::where('designer_id', $designer->designer_id)
                      ->where('review_type', 'designer')
                      ->where('rating', 4)
                      ->count(),
            3 => Review::where('designer_id', $designer->designer_id)
                      ->where('review_type', 'designer')
                      ->where('rating', 3)
                      ->count(),
            2 => Review::where('designer_id', $designer->designer_id)
                      ->where('review_type', 'designer')
                      ->where('rating', 2)
                      ->count(),
            1 => Review::where('designer_id', $designer->designer_id)
                      ->where('review_type', 'designer')
                      ->where('rating', 1)
                      ->count(),
        ];
        
        return view('partner.designer.profile.reviews', compact(
            'designer', 
            'avgRating', 
            'reviewCount', 
            'ratingDistribution'
        ));
    }
}