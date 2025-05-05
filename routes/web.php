<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('landingpage');
});
use App\Http\Controllers\SalesController;

Route::get('/sales-form', [SalesController::class, 'create'])->name('sales.create');
Route::post('/sales-form', [SalesController::class, 'store'])->name('sales.store');
