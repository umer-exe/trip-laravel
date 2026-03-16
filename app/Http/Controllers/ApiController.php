<?php

namespace App\Http\Controllers;

use App\Models\Tour;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * ApiController - RESTful API for Tours
 * 
 * Provides JSON endpoints for external consumption or frontend frameworks
 * All endpoints return JSON responses with consistent structure
 * Only returns active tours (status = 'active')
 * 
 * Available endpoints:
 * - GET /api/tours - List all active tours
 * - GET /api/tours/{id} - Get single tour details
 */
class ApiController extends Controller
{
    /**
     * Get all active tours
     * 
     * Returns paginated list of all active tours with essential fields
     * Image paths are converted to full URLs for easy consumption
     * 
     * Endpoint: GET /api/tours
     * 
     * Response format:
     * {
     *   "success": true,
     *   "count": 8,
     *   "data": [...]
     * }
     *
     * @return JsonResponse
     */
    public function tours(): JsonResponse
    {
        // Fetch all active tours with selected fields only
        // Excludes inactive tours from API response
        $tours = Tour::query()
            ->where('status', 'active')
            ->orderBy('created_at', 'desc')  // Newest first
            ->get([
                'id',
                'title',
                'slug',
                'location',
                'duration',
                'price',
                'type',
                'overview',
                'highlights',
                'is_featured',
                'featured_image',
                'thumbnail_image',
            ]);

        // Transform relative image paths to full URLs
        // This makes it easier for API consumers to display images
        $tours->transform(function ($tour) {
            if ($tour->featured_image) {
                // Convert "tours/abc123.jpg" to "http://domain.com/storage/tours/abc123.jpg"
                $tour->featured_image = asset('storage/' . $tour->featured_image);
            } elseif ($tour->thumbnail_image) {
                // Fallback to thumbnail if featured image not available
                $tour->thumbnail_image = asset($tour->thumbnail_image);
            }
            return $tour;
        });

        // Return standardized JSON response
        return response()->json([
            'success' => true,
            'count' => $tours->count(),  // Total number of tours returned
            'data' => $tours,
        ]);
    }

    /**
     * Get single tour by ID
     * 
     * Returns complete tour details including itinerary and gallery
     * Returns 404 error if tour not found or inactive
     * 
     * Endpoint: GET /api/tours/{id}
     * 
     * Success response (200):
     * {
     *   "success": true,
     *   "data": {...}
     * }
     * 
     * Error response (404):
     * {
     *   "success": false,
     *   "message": "Tour not found"
     * }
     *
     * @param int $id - Tour ID
     * @return JsonResponse
     */
    public function tour(int $id): JsonResponse
    {
        // Find tour by ID, only if active
        // Returns null if not found or inactive
        $tour = Tour::query()
            ->where('status', 'active')
            ->find($id, [
                'id',
                'title',
                'slug',
                'overview',
                'location',
                'duration',
                'price',
                'type',
                'highlights',
                'itinerary',
                'available_dates',
                'is_featured',
                'featured_image',
                'thumbnail_image',
                'banner_image',
                'gallery_images',
            ]);

        // Return 404 error if tour not found
        if (!$tour) {
            return response()->json([
                'success' => false,
                'message' => 'Tour not found',
            ], 404);
        }

        // Transform all image URLs to full paths for API consumers
        if ($tour->featured_image) {
            $tour->featured_image = asset('storage/' . $tour->featured_image);
        }
        if ($tour->thumbnail_image) {
            $tour->thumbnail_image = asset($tour->thumbnail_image);
        }
        if ($tour->banner_image) {
            $tour->banner_image = asset($tour->banner_image);
        }

        // Return success response with tour data
        return response()->json([
            'success' => true,
            'data' => $tour,
        ]);
    }
    /**
     * Create a new tour (Protected)
     * 
     * Endpoint: POST /api/tours
     * Requires: Authorization: Bearer {token}
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'duration' => 'required|string|max:255',
            'type' => 'required|in:domestic,international',
            'overview' => 'required|string',
            'status' => 'in:active,inactive'
        ]);

        $tour = new Tour($validated);
        $tour->slug = \Illuminate\Support\Str::slug($validated['title']) . '-' . uniqid(); // Ensure unique slug
        
        // Defaults for required fields if not provided
        $tour->highlights = $request->input('highlights', []);
        $tour->itinerary = $request->input('itinerary', []);
        $tour->available_dates = $request->input('available_dates', []);
        $tour->status = $request->input('status', 'active');
        
        $tour->save();

        return response()->json([
            'success' => true,
            'message' => 'Tour created successfully',
            'data' => $tour
        ], 201);
    }

    /**
     * Update an existing tour (Protected)
     * 
     * Endpoint: PUT /api/tours/{id}
     * Requires: Authorization: Bearer {token}
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $tour = Tour::find($id);

        if (!$tour) {
            return response()->json(['success' => false, 'message' => 'Tour not found'], 404);
        }

        $validated = $request->validate([
            'title' => 'sometimes|string|max:255',
            'location' => 'sometimes|string|max:255',
            'price' => 'sometimes|numeric|min:0',
            'duration' => 'sometimes|string|max:255',
            'type' => 'sometimes|in:domestic,international',
            'overview' => 'sometimes|string',
            'status' => 'sometimes|in:active,inactive'
        ]);

        $tour->fill($validated);
        
        if (isset($validated['title'])) {
             $tour->slug = \Illuminate\Support\Str::slug($validated['title']) . '-' . $tour->id;
        }

        $tour->save();

        return response()->json([
            'success' => true,
            'message' => 'Tour updated successfully',
            'data' => $tour
        ]);
    }

    /**
     * Delete a tour (Protected)
     * 
     * Endpoint: DELETE /api/tours/{id}
     * Requires: Authorization: Bearer {token}
     */
    public function destroy(int $id): JsonResponse
    {
        $tour = Tour::find($id);

        if (!$tour) {
            return response()->json(['success' => false, 'message' => 'Tour not found'], 404);
        }

        $tour->delete();

        return response()->json([
            'success' => true,
            'message' => 'Tour deleted successfully'
        ]);
    }
}
