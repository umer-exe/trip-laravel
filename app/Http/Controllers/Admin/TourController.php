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
        Tour::create($data);

        return redirect()->route('admin.tours.index')->with('success', 'Tour created successfully.');
    }

    public function edit(Tour $tour)
    {
        return view('admin.tours.edit', compact('tour'));
    }

    public function update(Request $request, Tour $tour)
    {
        $tour->update($this->validatedData($request, $tour));

        return redirect()->route('admin.tours.index')->with('success', 'Tour updated successfully.');
    }

    public function destroy(Tour $tour)
    {
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
            'thumbnail_image' => 'nullable|string|max:255',
            'banner_image' => 'nullable|string|max:255',
            'gallery_images' => 'nullable|array',
            'gallery_images.*' => 'nullable|string|max:255',
        ]);

        $validated['status'] = $validated['status'] ?? 'active';

        return $validated;
    }

    private function preparePayload(Request $request): void
    {
        $request->merge([
            'highlights' => $this->stringListToArray($request->input('highlights')),
            'gallery_images' => $this->stringListToArray($request->input('gallery_images')),
            'available_dates' => $this->keyValueListToArray($request->input('available_dates')),
            'itinerary' => $this->itineraryListToArray($request->input('itinerary')),
            'is_featured' => $request->boolean('is_featured'),
            'slug' => $request->filled('slug')
                ? Str::slug($request->input('slug'))
                : Str::slug($request->input('title')),
        ]);
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
}



