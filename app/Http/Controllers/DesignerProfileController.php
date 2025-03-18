<?php

namespace App\Http\Controllers;

use App\Models\Designer;
use App\Models\ProductionCompany;
use App\Models\User;
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

        // Different validation rules based on designer status
        if ($designer->production_company_id || $request->is_freelancer == 0) {
            // Company-affiliated designers only need basic info
            $request->validate([
                'name' => 'required|string|max:255',
                'phone' => 'nullable|string|max:20',
                'designer_description' => 'nullable|string|max:1000',
                'is_freelancer' => 'required|boolean',
                'production_company_id' => 'nullable|exists:production_companies,id',
            ]);
        } else {
            // Freelancers need service info as well
            $request->validate([
                'name' => 'required|string|max:255',
                'phone' => 'nullable|string|max:20',
                'designer_description' => 'nullable|string|max:1000',
                'talent_fee' => 'required|numeric|min:0',
                'max_free_revisions' => 'required|integer|min:0',
                'addtl_revision_fee' => 'required|numeric|min:0',
                'is_freelancer' => 'required|boolean',
                'production_company_id' => 'nullable|exists:production_companies,id',
            ]);
        }

        // We removed the profile picture upload functionality

        // Update user information
        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->save();

        // Update designer information
        $designer->designer_description = $request->designer_description;
        $designer->talent_fee = $request->talent_fee;
        $designer->max_free_revisions = $request->max_free_revisions;
        $designer->addtl_revision_fee = $request->addtl_revision_fee;
        $designer->is_freelancer = $request->is_freelancer;
        $designer->is_available = $request->has('is_available');

        // Only update production_company_id if designer doesn't already have one
        // Once assigned to a company, this can only be changed by an admin
        if (!$designer->production_company_id && !$designer->is_freelancer) {
            $designer->production_company_id = $request->production_company_id;
        }

        $designer->save();

        $this->toast('Profile updated successfully!', 'success');
        return redirect()->route('partner.designer.profile.basics');
    }
}