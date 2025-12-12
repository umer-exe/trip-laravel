<?php

use App\Http\Controllers\Admin\TourController as AdminTourController;
use App\Http\Controllers\ShoppingCartController;
use App\Http\Controllers\SiteController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Atlas Tours & Travel - Web Routes
|--------------------------------------------------------------------------
|
| This file defines all web routes for the Atlas Tours application.
| Routes are organized into sections:
| - Public routes (homepage, tours, contact)
| - Shopping cart routes
| - Admin routes (protected by authentication)
| - Authentication routes (loaded from auth.php)
|
*/

// ============================================================================
// PUBLIC ROUTES - Accessible to all visitors
// ============================================================================

/**
 * Homepage - Displays featured tours and customer testimonials
 * Route: GET /
 */
Route::get('/', [SiteController::class, 'home'])->name('home');

/**
 * Tours Listing - Shows all tours with filtering options
 * Supports filters: type (domestic/international), destination, price range
 * Route: GET /tours?type=domestic&destination=Tokyo&min_price=1000&max_price=5000
 */
Route::get('/tours', [SiteController::class, 'toursIndex'])->name('tours.index');

/**
 * AJAX Live Search - Returns JSON results for tour search dropdown
 * Used by JavaScript for real-time search as user types
 * Route: GET /tours/search/ajax?q=Tokyo&min_price=1000&max_price=5000
 */
Route::get('/tours/search/ajax', [SiteController::class, 'searchTours'])->name('tours.search');

/**
 * Tour Detail Page - Shows complete tour information with itinerary
 * Uses slug for SEO-friendly URLs
 * Route: GET /tours/{slug} (e.g., /tours/tokyo-adventure)
 */
Route::get('/tours/{slug}', [SiteController::class, 'toursShow'])->name('tours.show');

/**
 * Contact Page - Displays contact information and enquiry form
 * Route: GET /contact
 */
Route::get('/contact', [SiteController::class, 'contact'])->name('contact');

/**
 * Contact Form Submission - Processes contact form and saves to database
 * Route: POST /contact
 */
Route::post('/contact', [SiteController::class, 'submitContact'])->name('contact.submit');

// ============================================================================
// SHOPPING CART ROUTES - Cart management and checkout
// ============================================================================

/**
 * Cart Actions - AJAX endpoints for cart manipulation
 */
Route::post('/cart/add', [ShoppingCartController::class, 'add'])->name('cart.add');
Route::post('/cart/update', [ShoppingCartController::class, 'update'])->name('cart.update');
Route::post('/cart/remove', [ShoppingCartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/clear', [ShoppingCartController::class, 'clear'])->name('cart.clear');

/**
 * Shopping Cart Pages - Cart view and checkout process
 */
Route::get('/shopping-cart', [ShoppingCartController::class, 'index'])->name('shoppingcart.index');
Route::post('/shopping-cart/process', [ShoppingCartController::class, 'store'])->name('shoppingcart.store');
Route::get('/shopping-cart/success', [ShoppingCartController::class, 'success'])->name('shoppingcart.success');

// ============================================================================
// ADMIN ROUTES - Protected by Laravel Breeze authentication
// ============================================================================

/**
 * Admin Panel Routes
 * All routes prefixed with /admin and protected by 'auth' middleware
 * Only authenticated users can access these routes
 * 
 * Available admin modules:
 * - Tours: Full CRUD operations (create, read, update, delete)
 * - Contact Messages: View and manage customer inquiries
 * - Reviews: Manage customer testimonials
 */
Route::middleware(['auth'])
    ->prefix('admin')           // All routes start with /admin
    ->name('admin.')            // All route names start with admin.
    ->group(function () {
        
        /**
         * Tours Management - Full CRUD except show
         * Routes generated:
         * - GET    /admin/tours           → index (list all)
         * - GET    /admin/tours/create    → create (show form)
         * - POST   /admin/tours           → store (save new)
         * - GET    /admin/tours/{id}/edit → edit (show form)
         * - PUT    /admin/tours/{id}      → update (save changes)
         * - DELETE /admin/tours/{id}      → destroy (delete)
         */
        Route::resource('tours', AdminTourController::class)->except(['show']);
        
        /**
         * Contact Messages Management - View and update only
         * Routes generated:
         * - GET    /admin/contact-messages         → index (list all)
         * - GET    /admin/contact-messages/{id}    → show (view details)
         * - GET    /admin/contact-messages/{id}/edit → edit (update status)
         * - PUT    /admin/contact-messages/{id}    → update (save changes)
         * - DELETE /admin/contact-messages/{id}    → destroy (delete)
         */
        Route::resource('contact-messages', \App\Http\Controllers\Admin\ContactMessageController::class)
            ->only(['index', 'show', 'edit', 'update', 'destroy']);
        
        /**
         * Reviews Management - Full CRUD except show
         * Routes generated:
         * - GET    /admin/reviews           → index (list all)
         * - GET    /admin/reviews/create    → create (show form)
         * - POST   /admin/reviews           → store (save new)
         * - GET    /admin/reviews/{id}/edit → edit (show form)
         * - PUT    /admin/reviews/{id}      → update (save changes)
         * - DELETE /admin/reviews/{id}      → destroy (delete)
         */
        Route::resource('reviews', \App\Http\Controllers\Admin\ReviewController::class)
            ->except(['show']);
    });

// ============================================================================
// AUTHENTICATION ROUTES - Laravel Breeze
// ============================================================================

/**
 * Load authentication routes from auth.php
 * Includes: login, register, password reset, email verification
 * All routes are prefixed with /login, /register, etc.
 */
require __DIR__ . '/auth.php';
