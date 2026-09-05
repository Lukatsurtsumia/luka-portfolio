<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

Route::get('/', fn () => view('welcome'))->name('home');

Route::get('/about', fn () => view('about'))->name('about');

Route::get('/work/{slug}', function (string $slug) {
    $project = collect(config('portfolio.projects'))->firstWhere('slug', $slug);

    abort_if($project === null, 404);

    return view('work.show', [
        'project' => $project,
        'others' => collect(config('portfolio.projects'))
            ->where('slug', '!=', $slug)
            ->values(),
    ]);
})->name('work.show');

Route::get('/cv', function () {
    $filename = Str::slug(config('portfolio.developer.name')) . '-cv.html';

    return response()
        ->view('cv')
        ->header('Content-Disposition', 'inline; filename="' . $filename . '"');
})->name('cv');

// Language switch. Public so the site can be read in French before any contact.
Route::post('/locale', function (Request $request) {
    $locale = $request->input('locale');

    if (in_array($locale, ['en', 'fr'], true)) {
        session(['locale' => $locale]);
    }

    return redirect()->to($request->input('redirect') ?: route('home'));
})->name('locale.set');
