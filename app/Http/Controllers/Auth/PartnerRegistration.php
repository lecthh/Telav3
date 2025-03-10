<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PartnerRegistration extends Controller
{
    public function partnerRegistrationForm()
    {
        return view('partner.partner-registration');
    }


    public function partnerConfirmation()
    {
        return view('partner.partner-confirmation');
    }
}
