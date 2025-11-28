<?php

namespace App\Http\Controllers;

use App\Models\Tour;
use Illuminate\Http\Request;

class SiteController extends Controller
{
    /**
     * Display the home page with featured tours and testimonials
     *
     * @return \Illuminate\View\View
     */
    public function home()
    {
        $featuredTours = Tour::query()
            ->where('status', 'active')
            ->where('is_featured', true)
            ->orderByDesc('updated_at')
            ->take(4)
            ->get();

        // Get active reviews from database
        $testimonials = \App\Models\Review::where('is_active', true)
            ->orderByDesc('created_at')
            ->take(3)
            ->get()
            ->toArray();

        return view('home', compact('featuredTours', 'testimonials'));
    }

    /**
     * Display all tours with filtering options
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function toursIndex(Request $request)
    {
        $filterType = $request->get('type', 'all');
        $toursQuery = Tour::query()
            ->where('status', 'active');

        // Apply type filter
        if ($filterType !== 'all') {
            $toursQuery->where('type', $filterType);
        }

        // Apply destination search (search in title and location)
        if ($request->filled('destination')) {
            $search = $request->destination;
            $toursQuery->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%");
            });
        }

        // Apply min price filter
        if ($request->filled('min_price')) {
            $toursQuery->where('price', '>=', $request->min_price);
        }

        // Apply max price filter
        if ($request->filled('max_price')) {
            $toursQuery->where('price', '<=', $request->max_price);
        }

        $tours = $toursQuery->orderBy('created_at', 'desc')->get();

        return view('tours.index', compact('tours', 'filterType'));
    }

    /**
     * Display individual tour details with full itinerary
     *
     * @param string $slug
     * @return \Illuminate\View\View
     */
    public function toursShow($slug)
    {
        $tour = Tour::query()
            ->where('slug', $slug)
            ->where('status', 'active')
            ->firstOrFail();

        return view('tours.show', compact('tour'));
    }


    /**
     * Display contact page with company information
     *
     * @return \Illuminate\View\View
     */
    public function contact()
    {
        // Company contact information
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
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function submitContact(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:50',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|min:10',
        ]);

        \App\Models\ContactMessage::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'subject' => $validated['subject'],
            'message' => $validated['message'],
            'status' => 'new',
        ]);

        return redirect()->route('contact')->with('success', 'Your message has been sent. We will get back to you soon.');
    }
}

