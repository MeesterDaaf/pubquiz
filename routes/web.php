<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryPickerController;



Route::get('/', [CategoryPickerController::class, 'index'])->name('category-picker');
