<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Review Model - Customer testimonials and reviews
 * 
 * Stores customer feedback and ratings for tours
 * Used to display testimonials on homepage and reviews in admin panel
 * 
 * Database table: reviews
 * 
 * Fields:
 * - name: Customer name
 * - location: Customer location (e.g., "Karachi, Pakistan")
 * - rating: Star rating (1-5)
 * - comment: Review text
 * - image: Optional customer avatar/photo path
 * - is_active: Whether to display review publicly
 */
class Review extends Model
{
    /**
     * Mass assignable attributes
     */
    protected $fillable = [
        'name',        // Customer name
        'location',    // Customer location
        'rating',      // Star rating (1-5)
        'comment',     // Review text
        'image',       // Optional customer photo path
        'is_active',   // Display status (true/false)
    ];

    /**
     * Attribute casting
     * Converts database values to appropriate PHP types
     */
    protected $casts = [
        'is_active' => 'boolean',  // 0/1 → true/false
        'rating' => 'integer',     // Ensure integer type
    ];
}
