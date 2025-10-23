<?php

namespace App\Http\Controllers;

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
        // Mock featured tours data for home page
        $featuredTours = [
            [
                'id' => 1,
                'title' => 'Discover Japan',
                'slug' => 'discover-japan',
                'image' => '/images/tours/japan.jpg',
                'duration' => '10 Days',
                'price' => 2499,
                'type' => 'international',
                'location' => 'Tokyo, Kyoto, Osaka'
            ],
            [
                'id' => 2,
                'title' => 'Northern Pakistan',
                'slug' => 'northern-pakistan',
                'image' => '/images/tours/pakistan.jpg',
                'duration' => '7 Days',
                'price' => 899,
                'type' => 'domestic',
                'location' => 'Hunza, Skardu, Fairy Meadows'
            ],
            [
                'id' => 3,
                'title' => 'European Highlights',
                'slug' => 'european-highlights',
                'image' => '/images/tours/europe.jpg',
                'duration' => '14 Days',
                'price' => 3299,
                'type' => 'international',
                'location' => 'Paris, Rome, Barcelona'
            ],
            [
                'id' => 4,
                'title' => 'Coastal Pakistan Escape',
                'slug' => 'coastal-pakistan-escape',
                'image' => '/images/tours/coast.jpg',
                'duration' => '5 Days',
                'price' => 599,
                'type' => 'domestic',
                'location' => 'Karachi, Gwadar, Ormara'
            ],
        ];

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
        // Mock all tours data
        $allTours = [
            [
                'id' => 1,
                'title' => 'Discover Japan',
                'slug' => 'discover-japan',
                'image' => '/images/tours/japan.jpg',
                'duration' => '10 Days',
                'price' => 2499,
                'type' => 'international',
                'location' => 'Tokyo, Kyoto, Osaka',
                'month' => 'April'
            ],
            [
                'id' => 2,
                'title' => 'Northern Pakistan',
                'slug' => 'northern-pakistan',
                'image' => '/images/tours/pakistan.jpg',
                'duration' => '7 Days',
                'price' => 899,
                'type' => 'domestic',
                'location' => 'Hunza, Skardu, Fairy Meadows',
                'month' => 'June'
            ],
            [
                'id' => 3,
                'title' => 'European Highlights',
                'slug' => 'european-highlights',
                'image' => '/images/tours/europe.jpg',
                'duration' => '14 Days',
                'price' => 3299,
                'type' => 'international',
                'location' => 'Paris, Rome, Barcelona',
                'month' => 'May'
            ],
            [
                'id' => 4,
                'title' => 'Coastal Pakistan Escape',
                'slug' => 'coastal-pakistan-escape',
                'image' => '/images/tours/coast.jpg',
                'duration' => '5 Days',
                'price' => 599,
                'type' => 'domestic',
                'location' => 'Karachi, Gwadar, Ormara',
                'month' => 'November'
            ],
            [
                'id' => 5,
                'title' => 'Dubai Extravaganza',
                'slug' => 'dubai-extravaganza',
                'image' => '/images/tours/dubai.jpg',
                'duration' => '5 Days',
                'price' => 1299,
                'type' => 'international',
                'location' => 'Dubai, Abu Dhabi',
                'month' => 'December'
            ],
            [
                'id' => 6,
                'title' => 'Lahore Heritage Tour',
                'slug' => 'lahore-heritage-tour',
                'image' => '/images/tours/lahore.jpg',
                'duration' => '3 Days',
                'price' => 399,
                'type' => 'domestic',
                'location' => 'Lahore',
                'month' => 'March'
            ],
            [
                'id' => 7,
                'title' => 'Thailand Paradise',
                'slug' => 'thailand-beach-paradise',
                'image' => '/images/tours/thailand.jpg',
                'duration' => '8 Days',
                'price' => 1799,
                'type' => 'international',
                'location' => 'Phuket, Bangkok, Krabi',
                'month' => 'February'
            ],
            [
                'id' => 8,
                'title' => 'Swat Valley Discovery',
                'slug' => 'swat-valley-discovery',
                'image' => '/images/tours/swat.jpg',
                'duration' => '4 Days',
                'price' => 499,
                'type' => 'domestic',
                'location' => 'Swat, Kalam, Mahodand',
                'month' => 'July'
            ],
        ];

        // Get filter type from request (default to 'all')
        $filterType = $request->get('type', 'all');

        // Filter tours based on type
        if ($filterType !== 'all') {
            $tours = array_filter($allTours, function($tour) use ($filterType) {
                return $tour['type'] === $filterType;
            });
        } else {
            $tours = $allTours;
        }

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
        // Mock detailed tour data with itineraries
        $tours = [
            'discover-japan' => [
                'title' => 'Discover Japan',
                'slug' => 'discover-japan',
                'image' => '/images/tours/japan.jpg',
                'duration' => '10 Days / 9 Nights',
                'price' => 2499,
                'type' => 'international',
                'location' => 'Tokyo, Kyoto, Osaka',
                'overview' => 'Experience the perfect blend of ancient traditions and modern innovation in Japan. This comprehensive tour takes you through bustling Tokyo, historic Kyoto, and vibrant Osaka.',
                'highlights' => [
                    'Visit iconic Tokyo Tower and Shibuya Crossing',
                    'Explore ancient temples in Kyoto',
                    'Traditional tea ceremony experience',
                    'Mount Fuji day trip',
                    'Osaka street food tour',
                    'Cherry blossom viewing (seasonal)'
                ],
                'itinerary' => [
                    ['day' => 1, 'title' => 'Arrival in Tokyo', 'description' => 'Arrive at Narita Airport, transfer to hotel, evening orientation walk in Shibuya'],
                    ['day' => 2, 'title' => 'Tokyo City Tour', 'description' => 'Visit Senso-ji Temple, Tokyo Tower, Imperial Palace, and Akihabara district'],
                    ['day' => 3, 'title' => 'Mount Fuji Day Trip', 'description' => 'Full day excursion to Mount Fuji and Hakone hot springs'],
                    ['day' => 4, 'title' => 'Tokyo to Kyoto', 'description' => 'Bullet train to Kyoto, check-in, evening stroll in Gion district'],
                    ['day' => 5, 'title' => 'Kyoto Temples', 'description' => 'Visit Kinkaku-ji (Golden Pavilion), Fushimi Inari, and Kiyomizu-dera'],
                    ['day' => 6, 'title' => 'Kyoto Cultural Experience', 'description' => 'Traditional tea ceremony, bamboo forest walk in Arashiyama'],
                    ['day' => 7, 'title' => 'Kyoto to Osaka', 'description' => 'Transfer to Osaka, visit Osaka Castle, Dotonbori district'],
                    ['day' => 8, 'title' => 'Osaka Exploration', 'description' => 'Universal Studios Japan or Nara day trip to see deer and temples'],
                    ['day' => 9, 'title' => 'Osaka Free Day', 'description' => 'Shopping in Shinsaibashi, street food tour, optional activities'],
                    ['day' => 10, 'title' => 'Departure', 'description' => 'Transfer to Kansai Airport for departure flight']
                ],
                'gallery' => [
                    '/images/tours/japan-1.jpg',
                    '/images/tours/japan-2.jpg',
                    '/images/tours/japan-3.jpg',
                    '/images/tours/japan-4.jpg',
                ]
            ],
            'northern-pakistan' => [
                'title' => 'Northern Pakistan',
                'slug' => 'northern-pakistan',
                'image' => '/images/tours/pakistan.jpg',
                'duration' => '7 Days / 6 Nights',
                'price' => 899,
                'type' => 'domestic',
                'location' => 'Hunza, Skardu, Fairy Meadows',
                'overview' => 'Embark on an unforgettable journey through the majestic mountains of Northern Pakistan. Experience breathtaking landscapes, warm hospitality, and adventure of a lifetime.',
                'highlights' => [
                    'Visit Hunza Valley and Baltit Fort',
                    'Explore Skardu and Shangrila Resort',
                    'Trek to Fairy Meadows with Nanga Parbat views',
                    'Experience local culture and cuisine',
                    'Visit Attabad Lake',
                    'Professional mountain guides'
                ],
                'itinerary' => [
                    ['day' => 1, 'title' => 'Islamabad to Hunza', 'description' => 'Drive via Karakoram Highway, stop at scenic viewpoints, reach Hunza in evening'],
                    ['day' => 2, 'title' => 'Hunza Valley Exploration', 'description' => 'Visit Baltit Fort, Altit Fort, Eagles Nest viewpoint, Karimabad bazaar'],
                    ['day' => 3, 'title' => 'Attabad Lake & Passu', 'description' => 'Boat ride in Attabad Lake, visit Passu Cones, suspension bridge walk'],
                    ['day' => 4, 'title' => 'Hunza to Skardu', 'description' => 'Scenic drive to Skardu via Deosai Plains (summer) or main route'],
                    ['day' => 5, 'title' => 'Skardu Sightseeing', 'description' => 'Visit Shangrila Resort, Kachura Lake, Skardu Fort, local bazaars'],
                    ['day' => 6, 'title' => 'Fairy Meadows Trek', 'description' => 'Drive to Raikot Bridge, jeep ride and trek to Fairy Meadows, Nanga Parbat views'],
                    ['day' => 7, 'title' => 'Return to Islamabad', 'description' => 'Morning at Fairy Meadows, return journey to Islamabad']
                ],
                'gallery' => [
                    '/images/tours/pakistan-1.jpg',
                    '/images/tours/pakistan-2.jpg',
                    '/images/tours/pakistan-3.jpg',
                    '/images/tours/pakistan-4.jpg',
                ]
            ],
            'european-highlights' => [
                'title' => 'European Highlights',
                'slug' => 'european-highlights',
                'image' => '/images/tours/europe.jpg',
                'duration' => '14 Days / 13 Nights',
                'price' => 3299,
                'type' => 'international',
                'location' => 'Paris, Rome, Barcelona',
                'overview' => 'Discover the best of Europe in this comprehensive tour covering three iconic cities. Experience world-class art, architecture, cuisine, and culture.',
                'highlights' => [
                    'Eiffel Tower and Louvre Museum in Paris',
                    'Colosseum and Vatican City in Rome',
                    'Sagrada Familia and Park Güell in Barcelona',
                    'High-speed train experiences',
                    'Guided city tours with local experts',
                    'Free time for personal exploration'
                ],
                'itinerary' => [
                    ['day' => 1, 'title' => 'Arrival in Paris', 'description' => 'Airport pickup, hotel check-in, evening Seine River cruise'],
                    ['day' => 2, 'title' => 'Paris City Tour', 'description' => 'Visit Eiffel Tower, Arc de Triomphe, Champs-Élysées'],
                    ['day' => 3, 'title' => 'Louvre & Versailles', 'description' => 'Morning at Louvre Museum, afternoon Palace of Versailles'],
                    ['day' => 4, 'title' => 'Paris Free Day', 'description' => 'Optional: Disneyland Paris or Montmartre exploration'],
                    ['day' => 5, 'title' => 'Paris to Rome', 'description' => 'High-speed train or flight to Rome, evening Trastevere district'],
                    ['day' => 6, 'title' => 'Ancient Rome', 'description' => 'Colosseum, Roman Forum, Palatine Hill guided tour'],
                    ['day' => 7, 'title' => 'Vatican City', 'description' => 'St. Peters Basilica, Vatican Museums, Sistine Chapel'],
                    ['day' => 8, 'title' => 'Rome Exploration', 'description' => 'Trevi Fountain, Spanish Steps, Pantheon, gelato tasting'],
                    ['day' => 9, 'title' => 'Rome Free Day', 'description' => 'Optional: Pompeii day trip or shopping in Via Condotti'],
                    ['day' => 10, 'title' => 'Rome to Barcelona', 'description' => 'Flight to Barcelona, evening Las Ramblas walk'],
                    ['day' => 11, 'title' => 'Gaudí Architecture', 'description' => 'Sagrada Familia, Park Güell, Casa Batlló'],
                    ['day' => 12, 'title' => 'Barcelona Culture', 'description' => 'Gothic Quarter, La Boqueria Market, Barcelona Cathedral'],
                    ['day' => 13, 'title' => 'Beach & Montjuïc', 'description' => 'Barceloneta Beach, Montjuïc Castle, Magic Fountain show'],
                    ['day' => 14, 'title' => 'Departure', 'description' => 'Last-minute shopping, airport transfer']
                ],
                'gallery' => [
                    '/images/tours/europe-1.jpg',
                    '/images/tours/europe-2.jpg',
                    '/images/tours/europe-3.jpg',
                    '/images/tours/europe-4.jpg',
                ]
            ],
            'coastal-pakistan-escape' => [
                'title' => 'Coastal Pakistan Escape',
                'slug' => 'coastal-pakistan-escape',
                'image' => '/images/tours/coast.jpg',
                'duration' => '5 Days / 4 Nights',
                'price' => 599,
                'type' => 'domestic',
                'location' => 'Karachi, Gwadar, Ormara',
                'overview' => 'Explore the stunning coastline of Pakistan from Karachi to Gwadar. Pristine beaches, fresh seafood, and unique coastal culture await you.',
                'highlights' => [
                    'Visit Hawks Bay and Sandspit Beach',
                    'Explore Gwadar Port and beaches',
                    'Ormara Turtle Beach experience',
                    'Fresh seafood dining',
                    'Coastal highway scenic drive',
                    'Hingol National Park visit'
                ],
                'itinerary' => [
                    ['day' => 1, 'title' => 'Karachi Coastal Tour', 'description' => 'Hawks Bay, Sandspit Beach, Manora Island, evening at Do Darya'],
                    ['day' => 2, 'title' => 'Karachi to Ormara', 'description' => 'Scenic coastal drive, stop at Hingol National Park, Princess of Hope rock'],
                    ['day' => 3, 'title' => 'Ormara Beach Day', 'description' => 'Turtle Beach, swimming, beach activities, fresh seafood lunch'],
                    ['day' => 4, 'title' => 'Ormara to Gwadar', 'description' => 'Coastal highway drive, Gwadar Port visit, sunset at Gwadar beach'],
                    ['day' => 5, 'title' => 'Gwadar & Return', 'description' => 'Hammerhead viewpoint, Gwadar city tour, return to Karachi']
                ],
                'gallery' => [
                    '/images/tours/coast-1.jpg',
                    '/images/tours/coast-2.jpg',
                    '/images/tours/coast-3.jpg',
                    '/images/tours/coast-4.jpg',
                ]
            ],
        ];

        // Get tour data or return 404
        $tour = $tours[$slug] ?? abort(404);

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

