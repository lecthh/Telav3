<?php

use App\Http\Controllers\SelectAparrelController;
use App\Http\Controllers\SelectProductionTypeController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/select-apparel', [SelectAparrelController::class, 'selectApparel'])->name('select-apparel');
Route::post('/select-apparel', [SelectAparrelController::class, 'selectApparelPost'])->name('select-apparel-post');

Route::get('/select-production-type/{apparel}', [SelectProductionTypeController::class, 'selectProductionType'])->name('select-production-type');
