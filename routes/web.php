<?php

use App\Http\Controllers\Admin\TourController as AdminTourController;
use App\Http\Controllers\ShoppingCartController;
use App\Http\Controllers\SiteController;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

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

// AJAX search endpoint for live tour search
Route::get('/tours/search/ajax', [SiteController::class, 'searchTours'])->name('tours.search');

// Individual tour detail page - displays full itinerary and booking form
Route::get('/tours/{slug}', [SiteController::class, 'toursShow'])->name('tours.show');

// Contact page - displays contact information and enquiry form
Route::get('/contact', [SiteController::class, 'contact'])->name('contact');

// Contact form submission
Route::post('/contact', [SiteController::class, 'submitContact'])->name('contact.submit');

// Cart routes (for adding items)
Route::post('/cart/add', [ShoppingCartController::class, 'add'])->name('cart.add');
Route::post('/cart/update', [ShoppingCartController::class, 'update'])->name('cart.update');
Route::post('/cart/remove', [ShoppingCartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/clear', [ShoppingCartController::class, 'clear'])->name('cart.clear');

// Shopping Cart routes (merged cart and checkout)
Route::get('/shopping-cart', [ShoppingCartController::class, 'index'])->name('shoppingcart.index');
Route::post('/shopping-cart/process', [ShoppingCartController::class, 'store'])->name('shoppingcart.store');
Route::get('/shopping-cart/success', [ShoppingCartController::class, 'success'])->name('shoppingcart.success');

// // TEMP: create a test user (REMOVE this route after using once)
// Route::get('/make-user', function () {
//     $user = User::firstOrCreate(
//         ['email' => ''],
//         [
//             'name' => '',
//             'password' => Hash::make(),
//         ]
//     );

//     return 'User created: ' . $user->email;
// });

// Admin tour management (protected by Breeze auth)
Route::middleware(['auth'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::resource('tours', AdminTourController::class)->except(['show']);
        Route::resource('contact-messages', \App\Http\Controllers\Admin\ContactMessageController::class)
            ->only(['index', 'show', 'edit', 'update', 'destroy']);
        Route::resource('reviews', \App\Http\Controllers\Admin\ReviewController::class)
            ->except(['show']);
    });

// Keep Breeze authentication routes
require __DIR__ . '/auth.php';
