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

// ============================================================================
// AUTHENTICATION & PROTECTED ROUTES
// ============================================================================

/**
 * Login Endpoint
 * Issues Access Token for API usage
 */
Route::post('/login', function (Request $request) {
    if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
        $user = Auth::user();
        $token = $user->createToken('API Token')->accessToken;
        
        return response()->json([
            'success' => true,
            'user' => $user,
            'token' => $token
        ]);
    }
    
    return response()->json(['error' => 'Unauthorized'], 401);
});

/**
 * Protected Tour Operations
 * Requires: Authorization: Bearer {token}
 */
Route::middleware('auth:api')->group(function () {
    Route::post('/tours', [ApiController::class, 'store']);
    Route::put('/tours/{id}', [ApiController::class, 'update']);
    Route::delete('/tours/{id}', [ApiController::class, 'destroy']);
    
    // Test endpoint to verify token
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
});
