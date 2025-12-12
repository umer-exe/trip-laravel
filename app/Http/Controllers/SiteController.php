<?php

namespace App\Http\Controllers;

use App\Models\Tour;
use Illuminate\Http\Request;

/**
 * SiteController - Public Website Controller
 * 
 * Handles all public-facing pages and features:
 * - Homepage with featured tours and testimonials
 * - Tours listing with filtering (type, destination, price)
 * - Individual tour detail pages
 * - Contact page and form submission
 * - AJAX live search for tours (returns JSON)
 */
class SiteController extends Controller
{
    /**
     * Display the home page with featured tours and testimonials
     * Shows up to 4 featured tours and 3 most recent active reviews
     *
     * @return \Illuminate\View\View
     */
    public function home()
    {
        // Fetch featured tours (marked as featured and active)
        $featuredTours = Tour::query()
            ->where('status', 'active')
            ->where('is_featured', true)
            ->orderByDesc('updated_at')
            ->take(4)  // Limit to 4 tours for homepage
            ->get();

        // Get active reviews from database (most recent first)
        $testimonials = \App\Models\Review::where('is_active', true)
            ->orderByDesc('created_at')
            ->take(3)  // Show 3 testimonials on homepage
            ->get()
            ->toArray();

        return view('home', compact('featuredTours', 'testimonials'));
    }

    /**
     * Display all tours with filtering options
     * Supports filtering by:
     * - Tour type (domestic/international/all)
     * - Destination (searches in title and location)
     * - Price range (min and max)
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function toursIndex(Request $request)
    {
        // Get filter type from query string (default: 'all')
        $filterType = $request->get('type', 'all');
        
        // Start building query for active tours only
        $toursQuery = Tour::query()
            ->where('status', 'active');

        // Apply type filter (domestic/international)
        if ($filterType !== 'all') {
            $toursQuery->where('type', $filterType);
        }

        // Apply destination search (searches in both title and location fields)
        if ($request->filled('destination')) {
            $search = $request->destination;
            $toursQuery->where(function ($q) use ($search) {
                // Use LIKE for partial matching
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%");
            });
        }

        // Apply minimum price filter
        if ($request->filled('min_price')) {
            $toursQuery->where('price', '>=', $request->min_price);
        }

        // Apply maximum price filter
        if ($request->filled('max_price')) {
            $toursQuery->where('price', '<=', $request->max_price);
        }

        // Execute query and get results (newest first)
        $tours = $toursQuery->orderBy('created_at', 'desc')->get();

        return view('tours.index', compact('tours', 'filterType'));
    }

    /**
     * Display individual tour details with full itinerary
     * Uses slug for SEO-friendly URLs
     * Returns 404 if tour not found or inactive
     *
     * @param string $slug - URL-friendly tour identifier
     * @return \Illuminate\View\View
     */
    public function toursShow($slug)
    {
        // Find tour by slug, only if active (throws 404 if not found)
        $tour = Tour::query()
            ->where('slug', $slug)
            ->where('status', 'active')
            ->firstOrFail();

        return view('tours.show', compact('tour'));
    }


    /**
     * Display contact page with company information
     * Shows contact details and contact form
     *
     * @return \Illuminate\View\View
     */
    public function contact()
    {
        // Company contact information (static data)
        $contactInfo = [
            'address' => 'Office 305, 3rd Floor, Trade Tower, Abdullah Haroon Road, Karachi',
            'phone' => '+92-21-12345679',
            'whatsapp' => '+92-300-1234567',
            'email' => 'info@atlastours.pk',
            'hours' => 'Monday - Saturday: 9:00 AM - 6:00 PM',
        ];

        return view('contact', compact('contactInfo'));
    }

    /**
     * Handle contact form submission
     * Validates input and creates new contact message in database
     * Sets status to 'new' for admin review
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function submitContact(Request $request)
    {
        // Validate contact form fields
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:50',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|min:10',  // At least 10 characters
        ]);

        // Create contact message record in database
        \App\Models\ContactMessage::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'subject' => $validated['subject'],
            'message' => $validated['message'],
            'status' => 'new',  // Mark as new for admin review
        ]);

        // Redirect back to contact page with success message
        return redirect()->route('contact')->with('success', 'Your message has been sent. We will get back to you soon.');
    }

    /**
     * AJAX search for tours - Live search functionality
     * 
     * This method powers the live search dropdown on /tours page
     * Returns JSON array of matching tours for instant display
     * 
     * Search criteria:
     * - Searches in tour title and location fields
     * - Optionally filters by min/max price
     * - Returns max 10 results for dropdown
     * - Debounced on frontend (300ms delay)
     * 
     * Request parameters:
     * - q: Search query string (required)
     * - min_price: Minimum price filter (optional)
     * - max_price: Maximum price filter (optional)
     * 
     * Response: JSON array of tour objects with fields:
     * [id, title, location, price, slug, type]
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function searchTours(Request $request)
    {
        // Get search parameters from AJAX request
        $query = $request->get('q', '');
        $minPrice = $request->get('min_price');
        $maxPrice = $request->get('max_price');

        // Return empty array if no search query provided
        if (empty($query)) {
            return response()->json([]);
        }

        // Build query to search active tours
        $toursQuery = Tour::query()
            ->where('status', 'active')
            ->where(function ($q) use ($query) {
                // Search in both title and location fields using LIKE
                // This allows partial matching (e.g., "Tokyo" matches "Tokyo Adventure")
                $q->where('title', 'like', "%{$query}%")
                  ->orWhere('location', 'like', "%{$query}%");
            });

        // Apply minimum price filter if provided
        if ($minPrice !== null && $minPrice !== '') {
            $toursQuery->where('price', '>=', $minPrice);
        }

        // Apply maximum price filter if provided
        if ($maxPrice !== null && $maxPrice !== '') {
            $toursQuery->where('price', '<=', $maxPrice);
        }

        // Get results (limit to 10 for dropdown performance)
        // Only select fields needed for dropdown display
        $tours = $toursQuery
            ->orderBy('title', 'asc')  // Alphabetical order for easy scanning
            ->limit(10)
            ->get(['id', 'title', 'location', 'price', 'slug', 'type']);

        // Return JSON response for AJAX consumption
        // Frontend JavaScript will parse this and display in dropdown
        return response()->json($tours);
    }
}
