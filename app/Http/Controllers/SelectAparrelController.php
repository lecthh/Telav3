<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SelectAparrelController extends Controller
{
    public function selectApparel()
    {
        return view('select-apparel');
    }

    public function selectApparelPost(Request $request)
    {
        $apparel = $request->input('selected_apparel');
        return redirect()->route('select-production-type', ['apparel' => $apparel]);
    }
}
