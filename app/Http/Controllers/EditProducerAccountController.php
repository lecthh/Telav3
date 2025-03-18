<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductionCompany;
use App\Models\ProductionCompanyPricing;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Traits\Toastable;

class EditProducerAccountController extends Controller
{
    use Toastable;

    public function index()
    {
        $user = auth()->user();
        if (!$user) {
            return redirect()->route('login')->with('error', 'You must be logged in to access this page.');
        }

        Log::info('Authenticated user:', ['user' => $user]);

        $userId = $user->user_id;
        Log::info('User ID:', ['user_id' => $userId]);

        $productionCompany = ProductionCompany::where('user_id', auth()->id())->firstOrFail();

        if (!$productionCompany) {
            Log::warning('No production company associated with user:', ['user_id' => $userId]);
            return redirect()->route('partner.printer.profile.basics')->with('error', 'You must complete your profile before accessing this page.');
        }

        Log::info('Production company:', ['productionCompany' => $productionCompany]);

        $productionCompanyId = $productionCompany->id;
        $pricingRecords = ProductionCompanyPricing::with(['apparelType', 'productionType'])
            ->where('production_company_id', $productionCompanyId)
            ->get();

        Log::info('Pricing records:', ['pricingRecords' => $pricingRecords]);
        return view('partner.printer.profile.pricing', compact('productionCompany', 'pricingRecords'));
    }

    public function edit()
    {
        $productionCompany = ProductionCompany::where('user_id', auth()->id())->firstOrFail();
        return view('partner.printer.profile.basics', compact('productionCompany'));
    }

    public function update(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'company_name' => 'required|string|max:255',
                'email'        => 'required|email|max:255',
                'phone' => 'required|regex:/^[0-9\+\-\(\)\s]*$/',
                'address'      => 'required|string|max:255',
                'company_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            $productionCompany = ProductionCompany::where('user_id', auth()->id())->firstOrFail();

            // Handle logo upload if present
            if ($request->hasFile('company_logo')) {
                if ($productionCompany->company_logo && $productionCompany->company_logo != 'imgs/companyLogo/placeholder.jpg') {
                    Storage::disk('public')->delete($productionCompany->company_logo);
                }
                
                $logoPath = $request->file('company_logo')->store('company_logos', 'public');
                $validatedData['company_logo'] = $logoPath;
            }

            $productionCompany->update($validatedData);

            session()->forget('_old_input');
            $this->toast('Profile updated successfully!', 'success');

            return redirect()->route('partner.printer.profile.basics');
        } catch (\Exception $e) {
            Log::error('Profile update error: ' . $e->getMessage());

            $this->toast('An error occurred while updating the profile.', 'error');

            return redirect()->back()->withInput();
        }
    }

    public function updatePricing(Request $request)
    {
        try {
            if (!$request->has('selected_records') || count($request->input('selected_records')) === 0) {
                $this->toast('Please select at least one item to update.', 'warning');
                return redirect()->back();
            }
    
            $validatedData = $request->validate([
                'base_price.*' => 'required|numeric|min:0',
                'bulk_price.*' => 'required|numeric|min:0',
            ], [
                'base_price.*.required' => 'The base price field is required.',
                'base_price.*.numeric' => 'The base price must be a number.',
                'base_price.*.min' => 'The base price must be at least 0.',
                'bulk_price.*.required' => 'The bulk price field is required.',
                'bulk_price.*.numeric' => 'The bulk price must be a number.',
                'bulk_price.*.min' => 'The bulk price must be at least 0.',
            ]);
    
            $updatedCount = 0;
    
            foreach ($request->input('selected_records') as $recordId) {
                $pricingRecord = ProductionCompanyPricing::find($recordId);
                
                if ($pricingRecord) {
                    $pricingRecord->update([
                        'base_price' => $request->input("base_price.{$recordId}"),
                        'bulk_price' => $request->input("bulk_price.{$recordId}"),
                    ]);
                    $updatedCount++;
                }
            }
    
            Log::info('Prices updated successfully.', [
                'user_id' => auth()->id(),
                'updated_count' => $updatedCount,
                'selected_records' => $request->input('selected_records')
            ]);
    
            $this->toast("{$updatedCount} price records updated successfully.", 'success');
    
            return redirect()->route('partner.printer.profile.pricing');
        } catch (\Exception $e) {
            Log::error('Pricing update error: ' . $e->getMessage(), [
                'user_id' => auth()->id(),
                'exception' => $e
            ]);
    
            $this->toast('An error occurred while updating pricing: ' . $e->getMessage(), 'error');
    
            return redirect()->back()->withInput();
        }
    }
}
