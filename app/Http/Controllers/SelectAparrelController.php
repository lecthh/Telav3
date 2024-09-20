<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SelectAparrelController extends Controller
{
    //
    public function selectApparel(){
        return view('select-apparel');
    }
}
