<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductionCompany;

class EditProducerAccountController extends Controller
{
    public function edit()
    {
        
        $productionCompany = ProductionCompany::where('user_id', auth()->id())->firstOrFail();

        
        return view('partner.printer.profile.basics', compact('productionCompany'));
    }

    public function update(Request $request)
    {
        
        $request->validate([
            'company_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|numeric',
            'address' => 'required|string|max:255',
        ]);

        
        $productionCompany = ProductionCompany::where('user_id', auth()->id())->firstOrFail();

        
        $productionCompany->update([
            'company_name' => $request->input('company_name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'address' => $request->input('address'),
        ]);

        
        return redirect()->route('partner.printer.profile.basics')->with('success', 'Profile updated successfully.');
    }
}