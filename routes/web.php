<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/cv', function () {
    $filename = Str::slug(config('portfolio.developer.name')) . '-cv.html';

    return response()
        ->view('cv')
        ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
})->name('cv');
