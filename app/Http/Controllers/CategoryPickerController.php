<?php

namespace App\Http\Controllers;

class CategoryPickerController extends Controller
{
    public function index()
    {
        $categories = [
            'Raad het decennium',
            'Identificeer zangers of bands',
            'Kies het exacte jaar',
            'Bepaal of het voor of na de jaren 2000'
        ];

        return view('category-picker', [
            'categories' => $categories
        ]);
    }
}

