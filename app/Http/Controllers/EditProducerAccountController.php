<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductionCompany;
use App\Models\ProductionCompanyPricing;
use Illuminate\Support\Facades\Log;
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
                'phone'        => 'required|numeric',
                'address'      => 'required|string|max:255',
            ]);

            $productionCompany = ProductionCompany::where('user_id', auth()->id())->firstOrFail();

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
            $validatedData = $request->validate([
                'base_price.*' => 'required|numeric',
                'bulk_price.*' => 'required|numeric',
            ]);

            foreach ($request->input('selected_records', []) as $recordId) {
                $pricingRecord = ProductionCompanyPricing::findOrFail($recordId);
                $pricingRecord->update([
                    'base_price' => $validatedData["base_price"][$recordId],
                    'bulk_price' => $validatedData["bulk_price"][$recordId],
                ]);
            }

            $this->toast('Prices updated successfully.', 'success');

            return redirect()->route('partner.printer.profile.pricing');
        } catch (\Exception $e) {
            Log::error('Pricing update error: ' . $e->getMessage());

            $this->toast('An error occurred while updating pricing.', 'error');

            return redirect()->back()->withInput();
        }
    }
}
