<?php

use App\Http\Controllers\SiteController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Atlas Tours & Travel - Web Routes
|--------------------------------------------------------------------------
|
| This file defines all public routes for the Atlas Tours website.
| Breeze authentication routes are defined in auth.php
|
*/

// Home page - displays featured tours and testimonials
Route::get('/', [SiteController::class, 'home'])->name('home');

// Tours index - displays all tours with filtering options
Route::get('/tours', [SiteController::class, 'toursIndex'])->name('tours.index');

// Individual tour detail page - displays full itinerary and booking form
Route::get('/tours/{slug}', [SiteController::class, 'toursShow'])->name('tours.show');

// Contact page - displays contact information and enquiry form
Route::get('/contact', [SiteController::class, 'contact'])->name('contact');

// Keep Breeze authentication routes
require __DIR__.'/auth.php';
