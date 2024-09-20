<?php

use App\Http\Controllers\SelectAparrelController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/select-apparel', [SelectAparrelController::class, 'selectApparel']);
