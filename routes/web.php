<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryPickerController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/category-picker', [CategoryPickerController::class, 'index'])->name('category-picker');
