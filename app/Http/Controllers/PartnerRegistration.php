<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PartnerRegistration extends Controller
{
    public function partnerRegistration()
    {
        return view('partner.partner-registration');
    }


    public function partnerConfirmation()
    {
        return view('partner.partner-confirmation');
    }
}
