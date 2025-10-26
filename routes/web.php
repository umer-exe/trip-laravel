<?php

use App\Http\Controllers\SiteController;
use App\Http\Controllers\ShoppingCartController;
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

// Cart routes (for adding items)
Route::post('/cart/add', [ShoppingCartController::class, 'add'])->name('cart.add');
Route::post('/cart/update', [ShoppingCartController::class, 'update'])->name('cart.update');
Route::post('/cart/remove', [ShoppingCartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/clear', [ShoppingCartController::class, 'clear'])->name('cart.clear');

// Shopping Cart routes (merged cart and checkout)
Route::get('/shopping-cart', [ShoppingCartController::class, 'index'])->name('shoppingcart.index');
Route::post('/shopping-cart/process', [ShoppingCartController::class, 'store'])->name('shoppingcart.store');
Route::get('/shopping-cart/success', [ShoppingCartController::class, 'success'])->name('shoppingcart.success');

// Keep Breeze authentication routes
require __DIR__.'/auth.php';
