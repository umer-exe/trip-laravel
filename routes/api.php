<?php

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes - RESTful JSON Endpoints
|--------------------------------------------------------------------------
|
| These routes provide JSON API access to tour data
| All routes are prefixed with /api automatically
| No authentication required for tour endpoints (public API)
|
| Available endpoints:
| - GET /api/tours      → List all active tours
| - GET /api/tours/{id} → Get single tour details
|
*/

/**
 * Authenticated User Endpoint (Sanctum)
 * Returns currently authenticated user data
 * Requires API token authentication
 * 
 * Route: GET /api/user
 * Headers: Authorization: Bearer {token}
 */
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// ============================================================================
// PUBLIC API ENDPOINTS - No authentication required
// ============================================================================

/**
 * List All Tours
 * Returns JSON array of all active tours with essential fields
 * 
 * Route: GET /api/tours
 * Response: { success: true, count: 8, data: [...] }
 */
Route::get('/tours', [ApiController::class, 'tours'])->name('api.tours.index');

/**
 * Get Single Tour
 * Returns complete tour details including itinerary and gallery
 * 
 * Route: GET /api/tours/{id}
 * Response: { success: true, data: {...} }
 * Error: { success: false, message: "Tour not found" } (404)
 */
Route::get('/tours/{id}', [ApiController::class, 'tour'])->name('api.tours.show');
