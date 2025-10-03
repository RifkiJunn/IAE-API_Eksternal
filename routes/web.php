<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StockController;

Route::get('/', function () {
    return view('welcome');
});

// Route for the stock search functionality
Route::get('/stocks', [StockController::class, 'index']);
