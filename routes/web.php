<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('landingpage');
});
use App\Http\Controllers\SalesController;


Route::post('/sales-multi-store', [SalesController::class, 'storeMultiple'])->name('sales.multiple.store');
