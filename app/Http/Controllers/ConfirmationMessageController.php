<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ConfirmationMessageController extends Controller
{
    public function confirmation()
    {
        return view('cart.confirmation');
    }
}
