<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tour;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

/**
 * TourController - Admin CRUD Controller for Tour Management
 * 
 * This controller handles all admin operations for tours including:
 * - Listing tours with pagination
 * - Creating new tours with image uploads
 * - Editing existing tours
 * - Deleting tours and associated images
 * - Image upload handling (featured, thumbnail, banner, gallery)
 * - Data validation and transformation
 */
class TourController extends Controller
{
    /**
     * Display paginated list of all tours (newest first)
     * 
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Fetch tours ordered by creation date, 10 per page
        $tours = Tour::orderByDesc('created_at')->paginate(10);

        return view('admin.tours.index', compact('tours'));
    }

    /**
     * Show form to create a new tour
     * Sets default values for status (active) and type (domestic)
     * 
     * @return \Illuminate\View\View
     */
    public function create()
    {
        // Create empty tour model with sensible defaults
        $tour = new Tour([
            'status' => 'active',
            'type' => 'domestic',
        ]);

        return view('admin.tours.create', compact('tour'));
    }

    /**
     * Store a newly created tour in database
     * Handles multiple image uploads (featured, thumbnail, banner, gallery)
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validate and transform input data
        $data = $this->validatedData($request);
        
        // Handle featured image upload (main tour image, max 1MB)
        if ($request->hasFile('featured_image')) {
            $data['featured_image'] = $this->handleImageUpload($request->file('featured_image'));
        }
        
        // Handle thumbnail image upload (for cards/listings, max 1MB)
        if ($request->hasFile('thumbnail_image')) {
            $data['thumbnail_image'] = $this->handleImageUpload($request->file('thumbnail_image'));
        }
        
        // Handle banner image upload (for hero sections, max 1MB)
        if ($request->hasFile('banner_image')) {
            $data['banner_image'] = $this->handleImageUpload($request->file('banner_image'));
        }
        
        // Handle gallery images upload (up to 4 images, 1MB each)
        if ($request->hasFile('gallery_images')) {
            $galleryPaths = [];
            // Loop through each uploaded gallery image
            foreach ($request->file('gallery_images') as $image) {
                $galleryPaths[] = $this->handleImageUpload($image);
            }
            // Store array of image paths in database (as JSON)
            $data['gallery_images'] = $galleryPaths;
        }
        
        // Create tour record in database
        Tour::create($data);

        // Redirect to tours list with success message
        return redirect()->route('admin.tours.index')->with('success', 'Tour created successfully.');
    }

    /**
     * Show form to edit an existing tour
     * Uses route model binding to automatically fetch tour by ID
     * 
     * @param \App\Models\Tour $tour
     * @return \Illuminate\View\View
     */
    public function edit(Tour $tour)
    {
        return view('admin.tours.edit', compact('tour'));
    }

    /**
     * Update an existing tour in database
     * Handles image replacement (deletes old images before uploading new ones)
     * 
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Tour $tour
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Tour $tour)
    {
        // Validate and transform input data (with unique slug check excluding current tour)
        $data = $this->validatedData($request, $tour);
        
        // Handle featured image replacement
        if ($request->hasFile('featured_image')) {
            // Delete old featured image if it exists
            if ($tour->featured_image && \Storage::disk('public')->exists($tour->featured_image)) {
                \Storage::disk('public')->delete($tour->featured_image);
            }
            // Upload and store new featured image
            $data['featured_image'] = $this->handleImageUpload($request->file('featured_image'));
        }
        
        // Handle thumbnail image replacement
        if ($request->hasFile('thumbnail_image')) {
            // Delete old thumbnail if it exists
            if ($tour->thumbnail_image && \Storage::disk('public')->exists($tour->thumbnail_image)) {
                \Storage::disk('public')->delete($tour->thumbnail_image);
            }
            // Upload and store new thumbnail
            $data['thumbnail_image'] = $this->handleImageUpload($request->file('thumbnail_image'));
        }
        
        // Handle banner image replacement
        if ($request->hasFile('banner_image')) {
            // Delete old banner if it exists
            if ($tour->banner_image && \Storage::disk('public')->exists($tour->banner_image)) {
                \Storage::disk('public')->delete($tour->banner_image);
            }
            // Upload and store new banner
            $data['banner_image'] = $this->handleImageUpload($request->file('banner_image'));
        }
        
        // Handle gallery images replacement (replaces ALL gallery images)
        if ($request->hasFile('gallery_images')) {
            // Delete all old gallery images if they exist
            if ($tour->gallery_images && is_array($tour->gallery_images)) {
                foreach ($tour->gallery_images as $oldImage) {
                    if (\Storage::disk('public')->exists($oldImage)) {
                        \Storage::disk('public')->delete($oldImage);
                    }
                }
            }
            
            // Upload new gallery images
            $galleryPaths = [];
            foreach ($request->file('gallery_images') as $image) {
                $galleryPaths[] = $this->handleImageUpload($image);
            }
            $data['gallery_images'] = $galleryPaths;
        }
        
        // Update tour record in database
        $tour->update($data);

        // Redirect to tours list with success message
        return redirect()->route('admin.tours.index')->with('success', 'Tour updated successfully.');
    }

    /**
     * Delete a tour and all associated images from storage
     * Ensures no orphaned files remain after deletion
     * 
     * @param \App\Models\Tour $tour
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Tour $tour)
    {
        // Delete featured image from storage if it exists
        if ($tour->featured_image && \Storage::disk('public')->exists($tour->featured_image)) {
            \Storage::disk('public')->delete($tour->featured_image);
        }
        
        // Delete thumbnail image from storage if it exists
        if ($tour->thumbnail_image && \Storage::disk('public')->exists($tour->thumbnail_image)) {
            \Storage::disk('public')->delete($tour->thumbnail_image);
        }
        
        // Delete banner image from storage if it exists
        if ($tour->banner_image && \Storage::disk('public')->exists($tour->banner_image)) {
            \Storage::disk('public')->delete($tour->banner_image);
        }
        
        // Delete all gallery images from storage if they exist
        if ($tour->gallery_images && is_array($tour->gallery_images)) {
            foreach ($tour->gallery_images as $image) {
                if (\Storage::disk('public')->exists($image)) {
                    \Storage::disk('public')->delete($image);
                }
            }
        }
        
        // Delete tour record from database
        $tour->delete();

        // Redirect to tours list with success message
        return redirect()->route('admin.tours.index')->with('success', 'Tour deleted successfully.');
    }

    /**
     * Validate and prepare tour data from request
     * Handles complex validation rules for all tour fields
     * 
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Tour|null $tour - Existing tour for update (null for create)
     * @return array Validated data
     */
    private function validatedData(Request $request, ?Tour $tour = null): array
    {
        // Transform textarea inputs into arrays before validation
        $this->preparePayload($request);

        // Validate all tour fields with specific rules
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => [
                'required',
                'string',
                'max:255',
                // Ensure slug is unique, but ignore current tour when updating
                Rule::unique('tours', 'slug')->ignore($tour),
            ],
            'overview' => 'required|string',
            'location' => 'required|string|max:255',
            'duration' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'type' => ['required', Rule::in(['domestic', 'international'])],
            
            // Highlights: array of strings (from textarea)
            'highlights' => 'nullable|array',
            'highlights.*' => 'nullable|string|max:255',
            
            // Itinerary: array of day objects with day, title, description
            'itinerary' => 'nullable|array',
            'itinerary.*.day' => 'required_with:itinerary|integer|min:1',
            'itinerary.*.title' => 'required_with:itinerary|string|max:255',
            'itinerary.*.description' => 'nullable|string',
            
            // Available dates: key-value pairs (date => label)
            'available_dates' => 'nullable|array',
            'available_dates.*' => 'nullable|string|max:255',
            
            'status' => 'nullable|string|max:50',
            'is_featured' => 'boolean',
            
            // Image validation: JPEG, PNG, JPG, WEBP only, max 1MB each
            'thumbnail_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:1024',
            'banner_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:1024',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:1024',
            
            // Gallery: max 4 images, 1MB each
            'gallery_images' => 'nullable|array|max:4',
            'gallery_images.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:1024',
        ]);

        // Set default status if not provided
        $validated['status'] = $validated['status'] ?? 'active';

        return $validated;
    }

    /**
     * Transform textarea inputs into arrays before validation
     * Converts user-friendly text formats into structured data
     * 
     * @param \Illuminate\Http\Request $request
     * @return void
     */
    private function preparePayload(Request $request): void
    {
        $mergeData = [
            // Convert newline-separated highlights into array
            'highlights' => $this->stringListToArray($request->input('highlights')),
            
            // Convert "key=value" pairs into associative array for dates
            'available_dates' => $this->keyValueListToArray($request->input('available_dates')),
            
            // Convert pipe-separated itinerary into structured array
            'itinerary' => $this->itineraryListToArray($request->input('itinerary')),
            
            // Convert checkbox to boolean
            'is_featured' => $request->boolean('is_featured'),
            
            // Auto-generate slug from title if not provided
            'slug' => $request->filled('slug')
                ? Str::slug($request->input('slug'))
                : Str::slug($request->input('title')),
        ];
        
        // Only process gallery_images text input if no files are being uploaded
        // (Prevents overwriting file uploads with text input)
        if (!$request->hasFile('gallery_images')) {
            $mergeData['gallery_images'] = $this->stringListToArray($request->input('gallery_images'));
        }
        
        // Merge transformed data back into request
        $request->merge($mergeData);
    }

    /**
     * Convert newline-separated string into array
     * Example: "Item 1\nItem 2\nItem 3" => ["Item 1", "Item 2", "Item 3"]
     * 
     * @param string|null $value
     * @return array
     */
    private function stringListToArray(?string $value): array
    {
        return collect(preg_split('/\r\n|\r|\n/', (string) $value))
            ->map(fn ($line) => trim($line))  // Remove whitespace
            ->filter()                         // Remove empty lines
            ->values()                         // Reset array keys
            ->all();
    }

    /**
     * Convert "key=value" pairs into associative array
     * Example: "2024-03-15=March 15\n2024-04-10=April 10" 
     *       => ["2024-03-15" => "March 15", "2024-04-10" => "April 10"]
     * 
     * @param string|null $value
     * @return array
     */
    private function keyValueListToArray(?string $value): array
    {
        $pairs = [];

        foreach ($this->stringListToArray($value) as $line) {
            // Split on first "=" only
            [$key, $label] = array_pad(explode('=', $line, 2), 2, null);
            $key = trim((string) $key);
            $label = trim((string) $label);

            // Only add if both key and value exist
            if ($key && $label) {
                $pairs[$key] = $label;
            }
        }

        return $pairs;
    }

    /**
     * Convert pipe-separated itinerary into structured array
     * Supports two formats:
     * - With day number: "1|Arrival|Check-in and welcome dinner"
     * - Without day number: "Arrival|Check-in and welcome dinner" (auto-numbered)
     * 
     * @param string|null $value
     * @return array Array of ['day' => int, 'title' => string, 'description' => string]
     */
    private function itineraryListToArray(?string $value): array
    {
        $itinerary = [];
        $dayCounter = 1;

        foreach ($this->stringListToArray($value) as $line) {
            // Split line by pipe character
            $parts = array_map('trim', explode('|', $line));

            // Check if first part is a day number
            $hasDay = isset($parts[0]) && is_numeric($parts[0]);
            $day = $hasDay ? (int) $parts[0] : $dayCounter;
            
            // Determine which parts are title and description based on format
            $titleIndex = $hasDay ? 1 : 0;
            $descriptionIndex = $hasDay ? 2 : 1;

            $title = $parts[$titleIndex] ?? "Day {$day}";
            $description = $parts[$descriptionIndex] ?? '';

            $itinerary[] = [
                'day' => $day,
                'title' => $title,
                'description' => $description,
            ];

            // Increment day counter for next iteration
            $dayCounter = $day + 1;
        }

        return $itinerary;
    }

    /**
     * Handle image upload to Laravel's public storage disk
     * Stores images in storage/app/public/tours/ directory
     * Laravel automatically creates directory if it doesn't exist
     * 
     * @param \Illuminate\Http\UploadedFile $file
     * @return string Relative path to stored file (e.g., "tours/abc123.jpg")
     */
    private function handleImageUpload($file): string
    {
        // Store file in 'tours' directory on 'public' disk
        // Returns path like: "tours/randomfilename.jpg"
        $path = $file->store('tours', 'public');
        
        return $path;
    }
}
