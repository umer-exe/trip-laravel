<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tour;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class TourController extends Controller
{
    public function index()
    {
        $tours = Tour::orderByDesc('created_at')->paginate(10);

        return view('admin.tours.index', compact('tours'));
    }

    public function create()
    {
        $tour = new Tour([
            'status' => 'active',
            'type' => 'domestic',
        ]);

        return view('admin.tours.create', compact('tour'));
    }

    public function store(Request $request)
    {
        $data = $this->validatedData($request);
        
        // Handle featured image upload
        if ($request->hasFile('featured_image')) {
            $data['featured_image'] = $this->handleImageUpload($request->file('featured_image'));
        }
        
        // Handle thumbnail image upload
        if ($request->hasFile('thumbnail_image')) {
            $data['thumbnail_image'] = $this->handleImageUpload($request->file('thumbnail_image'));
        }
        
        // Handle banner image upload
        if ($request->hasFile('banner_image')) {
            $data['banner_image'] = $this->handleImageUpload($request->file('banner_image'));
        }
        
        // Handle gallery images upload (multiple files)
        if ($request->hasFile('gallery_images')) {
            $galleryPaths = [];
            foreach ($request->file('gallery_images') as $image) {
                $galleryPaths[] = $this->handleImageUpload($image);
            }
            $data['gallery_images'] = $galleryPaths;
        }
        
        Tour::create($data);

        return redirect()->route('admin.tours.index')->with('success', 'Tour created successfully.');
    }

    public function edit(Tour $tour)
    {
        return view('admin.tours.edit', compact('tour'));
    }

    public function update(Request $request, Tour $tour)
    {
        $data = $this->validatedData($request, $tour);
        
        // Handle featured image upload and delete old image
        if ($request->hasFile('featured_image')) {
            if ($tour->featured_image && \Storage::disk('public')->exists($tour->featured_image)) {
                \Storage::disk('public')->delete($tour->featured_image);
            }
            $data['featured_image'] = $this->handleImageUpload($request->file('featured_image'));
        }
        
        // Handle thumbnail image upload and delete old image
        if ($request->hasFile('thumbnail_image')) {
            if ($tour->thumbnail_image && \Storage::disk('public')->exists($tour->thumbnail_image)) {
                \Storage::disk('public')->delete($tour->thumbnail_image);
            }
            $data['thumbnail_image'] = $this->handleImageUpload($request->file('thumbnail_image'));
        }
        
        // Handle banner image upload and delete old image
        if ($request->hasFile('banner_image')) {
            if ($tour->banner_image && \Storage::disk('public')->exists($tour->banner_image)) {
                \Storage::disk('public')->delete($tour->banner_image);
            }
            $data['banner_image'] = $this->handleImageUpload($request->file('banner_image'));
        }
        
        // Handle gallery images upload (multiple files)
        if ($request->hasFile('gallery_images')) {
            // Delete old gallery images if they exist
            if ($tour->gallery_images && is_array($tour->gallery_images)) {
                foreach ($tour->gallery_images as $oldImage) {
                    if (\Storage::disk('public')->exists($oldImage)) {
                        \Storage::disk('public')->delete($oldImage);
                    }
                }
            }
            
            $galleryPaths = [];
            foreach ($request->file('gallery_images') as $image) {
                $galleryPaths[] = $this->handleImageUpload($image);
            }
            $data['gallery_images'] = $galleryPaths;
        }
        
        $tour->update($data);

        return redirect()->route('admin.tours.index')->with('success', 'Tour updated successfully.');
    }

    public function destroy(Tour $tour)
    {
        // Delete featured image if exists
        if ($tour->featured_image && \Storage::disk('public')->exists($tour->featured_image)) {
            \Storage::disk('public')->delete($tour->featured_image);
        }
        
        // Delete thumbnail image if exists
        if ($tour->thumbnail_image && \Storage::disk('public')->exists($tour->thumbnail_image)) {
            \Storage::disk('public')->delete($tour->thumbnail_image);
        }
        
        // Delete banner image if exists
        if ($tour->banner_image && \Storage::disk('public')->exists($tour->banner_image)) {
            \Storage::disk('public')->delete($tour->banner_image);
        }
        
        // Delete gallery images if they exist
        if ($tour->gallery_images && is_array($tour->gallery_images)) {
            foreach ($tour->gallery_images as $image) {
                if (\Storage::disk('public')->exists($image)) {
                    \Storage::disk('public')->delete($image);
                }
            }
        }
        
        $tour->delete();

        return redirect()->route('admin.tours.index')->with('success', 'Tour deleted successfully.');
    }

    private function validatedData(Request $request, ?Tour $tour = null): array
    {
        $this->preparePayload($request);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => [
                'required',
                'string',
                'max:255',
                Rule::unique('tours', 'slug')->ignore($tour),
            ],
            'overview' => 'required|string',
            'location' => 'required|string|max:255',
            'duration' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'type' => ['required', Rule::in(['domestic', 'international'])],
            'highlights' => 'nullable|array',
            'highlights.*' => 'nullable|string|max:255',
            'itinerary' => 'nullable|array',
            'itinerary.*.day' => 'required_with:itinerary|integer|min:1',
            'itinerary.*.title' => 'required_with:itinerary|string|max:255',
            'itinerary.*.description' => 'nullable|string',
            'available_dates' => 'nullable|array',
            'available_dates.*' => 'nullable|string|max:255',
            'status' => 'nullable|string|max:50',
            'is_featured' => 'boolean',
            'thumbnail_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:1024', // 1MB limit
            'banner_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:1024', // 1MB limit
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:1024', // 1MB limit
            'gallery_images' => 'nullable|array|max:4', // Maximum 4 gallery images
            'gallery_images.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:1024', // 1MB limit for each gallery image
        ]);

        $validated['status'] = $validated['status'] ?? 'active';

        return $validated;
    }

    private function preparePayload(Request $request): void
    {
        $mergeData = [
            'highlights' => $this->stringListToArray($request->input('highlights')),
            'available_dates' => $this->keyValueListToArray($request->input('available_dates')),
            'itinerary' => $this->itineraryListToArray($request->input('itinerary')),
            'is_featured' => $request->boolean('is_featured'),
            'slug' => $request->filled('slug')
                ? Str::slug($request->input('slug'))
                : Str::slug($request->input('title')),
        ];
        
        // Only merge gallery_images if not uploading files
        if (!$request->hasFile('gallery_images')) {
            $mergeData['gallery_images'] = $this->stringListToArray($request->input('gallery_images'));
        }
        
        $request->merge($mergeData);
    }

    private function stringListToArray(?string $value): array
    {
        return collect(preg_split('/\r\n|\r|\n/', (string) $value))
            ->map(fn ($line) => trim($line))
            ->filter()
            ->values()
            ->all();
    }

    private function keyValueListToArray(?string $value): array
    {
        $pairs = [];

        foreach ($this->stringListToArray($value) as $line) {
            [$key, $label] = array_pad(explode('=', $line, 2), 2, null);
            $key = trim((string) $key);
            $label = trim((string) $label);

            if ($key && $label) {
                $pairs[$key] = $label;
            }
        }

        return $pairs;
    }

    private function itineraryListToArray(?string $value): array
    {
        $itinerary = [];
        $dayCounter = 1;

        foreach ($this->stringListToArray($value) as $line) {
            $parts = array_map('trim', explode('|', $line));

            $hasDay = isset($parts[0]) && is_numeric($parts[0]);
            $day = $hasDay ? (int) $parts[0] : $dayCounter;
            $titleIndex = $hasDay ? 1 : 0;
            $descriptionIndex = $hasDay ? 2 : 1;

            $title = $parts[$titleIndex] ?? "Day {$day}";
            $description = $parts[$descriptionIndex] ?? '';

            $itinerary[] = [
                'day' => $day,
                'title' => $title,
                'description' => $description,
            ];

            $dayCounter = $day + 1;
        }

        return $itinerary;
    }

    /**
     * Handle image upload to public disk
     * 
     * @param \Illuminate\Http\UploadedFile $file
     * @return string Path to stored file
     */
    private function handleImageUpload($file): string
    {
        // Store in public disk under tours directory
        $path = $file->store('tours', 'public');
        
        return $path;
    }
}



