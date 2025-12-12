<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tour extends Model
{
    protected $fillable = [
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
        'status',
        'is_featured',
        'thumbnail_image',
        'banner_image',
        'featured_image', // File upload field
        'gallery_images',
    ];

    protected $casts = [
        'highlights' => 'array',
        'itinerary' => 'array',
        'available_dates' => 'array',
        'gallery_images' => 'array',
        'is_featured' => 'boolean',
        'price' => 'decimal:2',
    ];
}
