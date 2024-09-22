<?php

use App\Http\Controllers\SelectAparrelController;
use App\Http\Controllers\SelectProductionCompanyController;
use App\Http\Controllers\SelectProductionTypeController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/select-apparel', function () {
    return view('customer.place-order.select-apparel');
});

Route::get('/select-production-type', function () {
    return view('customer.place-order.select-production-type');
});

Route::get('/select-production-company', function () {
    return view('customer.place-order.select-production-company');
});

// Route::get('/select-apparel', [SelectAparrelController::class, 'selectApparel'])->name('select-apparel');
// Route::post('/select-apparel', [SelectAparrelController::class, 'selectApparelPost'])->name('select-apparel-post');

// Route::get('/select-production-type/{apparel}', [SelectProductionTypeController::class, 'selectProductionType'])->name('select-production-type');
// Route::post('/select-production-type', [SelectProductionTypeController::class, 'selectProductionTypePost'])->name('select-production-type-post');

// Route::get('/select-production-company/{apparel}/{productionType}', [SelectProductionCompanyController::class, 'selectProductionCompany'])->name('select-production-company');
// Route::post('/select-production-company', [SelectProductionCompanyController::class, 'selectProductionCompanyPost'])->name('select-production-company-post');
