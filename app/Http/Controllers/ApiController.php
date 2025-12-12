<?php

namespace App\Http\Controllers;

use App\Models\Tour;
use Illuminate\Http\JsonResponse;

/**
 * API Controller for Tours
 * Provides JSON endpoints for external consumption
 */
class ApiController extends Controller
{
    /**
     * Get all active tours
     * Returns JSON list of all active tours with key fields
     *
     * @return JsonResponse
     */
    public function tours(): JsonResponse
    {
        $tours = Tour::query()
            ->where('status', 'active')
            ->orderBy('created_at', 'desc')
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

        // Transform featured_image to full URL
        $tours->transform(function ($tour) {
            if ($tour->featured_image) {
                $tour->featured_image = asset('storage/' . $tour->featured_image);
            } elseif ($tour->thumbnail_image) {
                $tour->thumbnail_image = asset($tour->thumbnail_image);
            }
            return $tour;
        });

        return response()->json([
            'success' => true,
            'count' => $tours->count(),
            'data' => $tours,
        ]);
    }

    /**
     * Get single tour by ID
     * Returns JSON object with complete tour details
     *
     * @param int $id
     * @return JsonResponse
     */
    public function tour(int $id): JsonResponse
    {
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

        if (!$tour) {
            return response()->json([
                'success' => false,
                'message' => 'Tour not found',
            ], 404);
        }

        // Transform image URLs to full paths
        if ($tour->featured_image) {
            $tour->featured_image = asset('storage/' . $tour->featured_image);
        }
        if ($tour->thumbnail_image) {
            $tour->thumbnail_image = asset($tour->thumbnail_image);
        }
        if ($tour->banner_image) {
            $tour->banner_image = asset($tour->banner_image);
        }

        return response()->json([
            'success' => true,
            'data' => $tour,
        ]);
    }
}
