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

        // Mock testimonials data
        $testimonials = [
            [
                'name' => 'Umer Malik',
                'location' => 'Karachi, Pakistan',
                'rating' => 5,
                'comment' => 'Atlas Tours made our Japan trip unforgettable! Every detail was perfectly planned.',
                'image' => '/images/testimonials/avatar1.jpg'
            ],
            [
                'name' => 'John Smith',
                'location' => 'London, UK',
                'rating' => 5,
                'comment' => 'Professional service and amazing tour guides. Highly recommended for Pakistan tours!',
                'image' => '/images/testimonials/avatar2.jpg'
            ],
            [
                'name' => 'Zain Niazi',
                'location' => 'Lahore, Pakistan',
                'rating' => 5,
                'comment' => 'The Northern Pakistan tour was breathtaking. Thank you Atlas Tours!',
                'image' => '/images/testimonials/avatar3.jpg'
            ],
        ];

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
            ->where('status', 'active')
            ->orderBy('title');

        if ($filterType !== 'all') {
            $toursQuery->where('type', $filterType);
        }

        $tours = $toursQuery->get();

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
}

