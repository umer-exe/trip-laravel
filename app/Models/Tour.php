<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Tour Model - Represents tour packages in the system
 * 
 * This model handles all tour-related data including:
 * - Basic tour information (title, location, price, duration)
 * - Tour content (overview, highlights, itinerary)
 * - Images (featured, thumbnail, banner, gallery)
 * - Booking information (available dates, status)
 * - Tour classification (type: domestic/international, featured status)
 * 
 * Database table: tours
 * 
 * JSON fields (automatically cast to arrays):
 * - highlights: Array of tour highlight strings
 * - itinerary: Array of day objects [{day, title, description}]
 * - available_dates: Key-value pairs {date => label}
 * - gallery_images: Array of image paths
 */
class Tour extends Model
{
    /**
     * Mass assignable attributes
     * These fields can be filled using create() or fill() methods
     */
    protected $fillable = [
        'title',              // Tour name (e.g., "Tokyo Adventure")
        'slug',               // URL-friendly identifier (e.g., "tokyo-adventure")
        'overview',           // Detailed tour description
        'location',           // Destination (e.g., "Tokyo, Japan")
        'duration',           // Trip length (e.g., "7 Days / 6 Nights")
        'price',              // Tour cost (decimal)
        'type',               // Tour type: 'domestic' or 'international'
        'highlights',         // JSON array of tour highlights
        'itinerary',          // JSON array of daily itinerary
        'available_dates',    // JSON object of available departure dates
        'status',             // Tour status: 'active' or 'inactive'
        'is_featured',        // Boolean: show on homepage featured section
        'thumbnail_image',    // Legacy: thumbnail image path
        'banner_image',       // Legacy: banner image path
        'featured_image',     // Uploaded featured image path (from admin panel)
        'gallery_images',     // JSON array of gallery image paths (max 4)
    ];

    /**
     * Attribute casting
     * Automatically converts database values to specified types
     * 
     * JSON fields are automatically decoded to arrays when accessed
     * and encoded to JSON when saved to database
     */
    protected $casts = [
        'highlights' => 'array',        // JSON → PHP array
        'itinerary' => 'array',         // JSON → PHP array
        'available_dates' => 'array',   // JSON → PHP array
        'gallery_images' => 'array',    // JSON → PHP array
        'is_featured' => 'boolean',     // 0/1 → true/false
        'price' => 'decimal:2',         // Ensures 2 decimal places
    ];
}
