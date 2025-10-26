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
                'title' => 'Thailand Paradise',
                'slug' => 'thailand-beach-paradise',
                'image' => '/images/tours/thailand.jpg',
                'duration' => '8 Days',
                'price' => 1799,
                'type' => 'international',
                'location' => 'Phuket, Bangkok, Krabi',
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
                'id' => 1,
                'title' => 'Discover Japan',
                'slug' => 'discover-japan',
                'image' => '/images/tours/japan.jpg',
                'duration' => '10 Days / 9 Nights',
                'price' => 2499,
                'type' => 'international',
                'location' => 'Tokyo, Kyoto, Osaka',
                'available_dates' => [
                    '2024-03-15' => 'March 15, 2024',
                    '2024-04-10' => 'April 10, 2024',
                    '2024-05-05' => 'May 5, 2024',
                    '2024-06-20' => 'June 20, 2024',
                ],
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
                    '/images/gallery/japan-1.jpg',
                    '/images/gallery/japan-2.jpg',
                    '/images/gallery/japan-3.jpg',
                    '/images/gallery/japan-4.jpg',
                ]
            ],
            'northern-pakistan' => [
                'id' => 2,
                'title' => 'Northern Pakistan',
                'slug' => 'northern-pakistan',
                'image' => '/images/tours/pakistan.jpg',
                'duration' => '7 Days / 6 Nights',
                'price' => 899,
                'type' => 'domestic',
                'location' => 'Hunza, Skardu, Fairy Meadows',
                'available_dates' => [
                    '2024-06-01' => 'June 1, 2024',
                    '2024-07-15' => 'July 15, 2024',
                    '2024-08-10' => 'August 10, 2024',
                    '2024-09-05' => 'September 5, 2024',
                ],
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
                    '/images/gallery/pakistan-1.jpg',
                    '/images/gallery/pakistan-2.jpg',
                    '/images/gallery/pakistan-3.jpg',
                    '/images/gallery/pakistan-4.jpg',
                ]
            ],
            'european-highlights' => [
                'id' => 3,
                'title' => 'European Highlights',
                'slug' => 'european-highlights',
                'image' => '/images/tours/europe.jpg',
                'duration' => '14 Days / 13 Nights',
                'price' => 3299,
                'type' => 'international',
                'location' => 'Paris, Rome, Barcelona',
                'available_dates' => [
                    '2024-05-01' => 'May 1, 2024',
                    '2024-06-15' => 'June 15, 2024',
                    '2024-07-20' => 'July 20, 2024',
                    '2024-08-25' => 'August 25, 2024',
                ],
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
                    '/images/gallery/europe-1.jpg',
                    '/images/gallery/europe-2.jpg',
                    '/images/gallery/europe-3.jpg',
                    '/images/gallery/europe-4.jpg',
                ]
            ],
            'thailand-beach-paradise' => [
                'id' => 4,
                'title' => 'Thailand Paradise',
                'slug' => 'thailand-beach-paradise',
                'image' => '/images/tours/thailand.jpg',
                'duration' => '8 Days / 7 Nights',
                'price' => 1799,
                'type' => 'international',
                'location' => 'Phuket, Bangkok, Krabi',
                'available_dates' => [
                    '2024-02-10' => 'February 10, 2024',
                    '2024-03-25' => 'March 25, 2024',
                    '2024-04-15' => 'April 15, 2024',
                    '2024-05-30' => 'May 30, 2024',
                ],
                'overview' => 'Sun-kissed beaches, emerald waters, and buzzing city life. From Bangkok\'s temples and markets to Phuket\'s island-hopping and Krabi\'s limestone cliffs, this is Thailand at its best.',
                'highlights' => [
                    'Grand Palace and Wat Pho in Bangkok',
                    'Floating market experience',
                    'Phuket island-hopping (Phi Phi / Maya Bay, weather permitting)',
                    'Krabi Railay Beach and Ao Nang promenade',
                    'Thai cooking class',
                    'Evening street food tours'
                ],
                'itinerary' => [
                    ['day' => 1, 'title' => 'Arrive Bangkok', 'description' => 'Airport pickup, hotel check-in, evening tuk-tuk ride and street food tasting'],
                    ['day' => 2, 'title' => 'Bangkok Temples & Markets', 'description' => 'Grand Palace, Wat Pho, Long-tail boat on canals, Asiatique night market'],
                    ['day' => 3, 'title' => 'Bangkok to Phuket', 'description' => 'Flight to Phuket, beach time, sunset at Promthep Cape'],
                    ['day' => 4, 'title' => 'Phuket Islands', 'description' => 'Full-day speedboat tour to Phi Phi/Maya Bay or James Bond Island (seasonal)'],
                    ['day' => 5, 'title' => 'Phuket to Krabi', 'description' => 'Scenic transfer to Krabi, relax at Ao Nang, optional Thai massage'],
                    ['day' => 6, 'title' => 'Krabi Adventure', 'description' => 'Railay Beach, Phra Nang Cave, kayaking or snorkeling options'],
                    ['day' => 7, 'title' => 'Krabi Free Day', 'description' => 'Optional cooking class, Emerald Pool & Hot Springs excursion'],
                    ['day' => 8, 'title' => 'Departure', 'description' => 'Transfer to Krabi/Phuket airport for onward flight']
                ],
                'gallery' => [
                    '/images/gallery/thailand-1.jpg',
                    '/images/gallery/thailand-2.jpg',
                    '/images/gallery/thailand-3.jpg',
                    '/images/gallery/thailand-4.jpg',
                ]
            ],
            'dubai-extravaganza' => [
                'id' => 5,
                'title' => 'Dubai Extravaganza',
                'slug' => 'dubai-extravaganza',
                'image' => '/images/tours/dubai.jpg',
                'duration' => '5 Days / 4 Nights',
                'price' => 1299,
                'type' => 'international',
                'location' => 'Dubai, Abu Dhabi',
                'available_dates' => [
                    '2024-12-01' => 'December 1, 2024',
                    '2024-12-15' => 'December 15, 2024',
                    '2025-01-10' => 'January 10, 2025',
                    '2025-02-05' => 'February 5, 2025',
                ],
                'overview' => 'A showcase of futuristic architecture, desert adventures, and luxury shopping. Discover Dubai\'s glittering skyline and the cultural gems of Abu Dhabi.',
                'highlights' => [
                    'Burj Khalifa At The Top (non-peak)',
                    'Dubai Marina & Palm Jumeirah photo stops',
                    'Desert safari with dune bashing and BBQ dinner',
                    'Abu Dhabi Sheikh Zayed Grand Mosque',
                    'Old Dubai souks and Dubai Creek',
                    'Dubai Mall fountain show'
                ],
                'itinerary' => [
                    ['day' => 1, 'title' => 'Arrive Dubai', 'description' => 'Airport transfer, check-in, evening Dubai Mall & fountain show'],
                    ['day' => 2, 'title' => 'Modern Dubai', 'description' => 'Marina walk, Palm Jumeirah (The Pointe/Atlantis photo stop), Burj Khalifa entry'],
                    ['day' => 3, 'title' => 'Desert Safari', 'description' => 'Afternoon dune bashing, camel ride, sandboarding, live entertainment, BBQ dinner'],
                    ['day' => 4, 'title' => 'Abu Dhabi Day Trip', 'description' => 'Sheikh Zayed Grand Mosque, Corniche drive, optional Louvre Abu Dhabi (time permitting)'],
                    ['day' => 5, 'title' => 'Old Dubai & Departure', 'description' => 'Gold & Spice Souks, Abra ride on Dubai Creek, airport transfer']
                ],
                'gallery' => [
                    '/images/gallery/dubai-1.jpg',
                    '/images/gallery/dubai-2.jpg',
                    '/images/gallery/dubai-3.jpg',
                    '/images/gallery/dubai-4.jpg',
                ]
            ],
            'lahore-heritage-tour' => [
                'id' => 6,
                'title' => 'Lahore Heritage Tour',
                'slug' => 'lahore-heritage-tour',
                'image' => '/images/tours/lahore.jpg',
                'duration' => '3 Days / 2 Nights',
                'price' => 399,
                'type' => 'domestic',
                'location' => 'Lahore',
                'available_dates' => [
                    '2024-03-01' => 'March 1, 2024',
                    '2024-03-20' => 'March 20, 2024',
                    '2024-04-10' => 'April 10, 2024',
                    '2024-05-01' => 'May 1, 2024',
                ],
                'overview' => 'Dive into the cultural capital of Pakistan. Mughal-era monuments, rich cuisine, and vibrant bazaars make Lahore unforgettable.',
                'highlights' => [
                    'Badshahi Mosque and Lahore Fort (Shahi Qila)',
                    'Walled City heritage walk and Food Street',
                    'Shalimar Gardens and Lahore Museum',
                    'Wagah Border flag-lowering ceremony',
                    'Anarkali & Liberty market shopping'
                ],
                'itinerary' => [
                    ['day' => 1, 'title' => 'Arrival & Old Lahore', 'description' => 'Check-in, visit Badshahi Mosque, Lahore Fort, Shahi Hammam, evening at Food Street'],
                    ['day' => 2, 'title' => 'Gardens & Museums', 'description' => 'Shalimar Gardens, Lahore Museum, Anarkali Bazaar, evening Wagah Border ceremony'],
                    ['day' => 3, 'title' => 'Modern Lahore & Departure', 'description' => 'Liberty Market, MM Alam Road cafés, Souvenir shopping, depart for home']
                ],
                'gallery' => [
                    '/images/gallery/lahore-1.jpg',
                    '/images/gallery/lahore-2.jpg',
                    '/images/gallery/lahore-3.jpg',
                    '/images/gallery/lahore-4.jpg',
                ]
            ],
            'coastal-pakistan-escape' => [
                'id' => 7,
                'title' => 'Coastal Pakistan Escape',
                'slug' => 'coastal-pakistan-escape',
                'image' => '/images/tours/coast.jpg',
                'duration' => '5 Days / 4 Nights',
                'price' => 599,
                'type' => 'domestic',
                'location' => 'Karachi, Gwadar, Ormara',
                'available_dates' => [
                    '2024-11-01' => 'November 1, 2024',
                    '2024-11-20' => 'November 20, 2024',
                    '2024-12-10' => 'December 10, 2024',
                    '2025-01-05' => 'January 5, 2025',
                ],
                'overview' => 'Follow the Makran Coastal Highway to pristine beaches, dramatic cliffs, and starry skies. A laid-back journey across Pakistan\'s south coast.',
                'highlights' => [
                    'Sunset at Ormara Hammerhead',
                    'Kund Malir Beach & Princess of Hope',
                    'Gwadar port city viewpoints',
                    'Hingol National Park landscapes',
                    'Karachi heritage & food tour'
                ],
                'itinerary' => [
                    ['day' => 1, 'title' => 'Karachi Arrival & City Flavor', 'description' => 'Check-in, Clifton & Seaview drive, Burns Road food trail'],
                    ['day' => 2, 'title' => 'Karachi to Ormara', 'description' => 'Drive via Makran Coastal Highway, Kund Malir & Princess of Hope, sunset at Ormara'],
                    ['day' => 3, 'title' => 'Ormara to Gwadar', 'description' => 'Hammerhead viewpoint, Hingol National Park photo stops, arrive Gwadar'],
                    ['day' => 4, 'title' => 'Explore Gwadar', 'description' => 'Gwadar Port view point, Koh-e-Batil, beaches, seafood dinner'],
                    ['day' => 5, 'title' => 'Return to Karachi', 'description' => 'Coastal drive back with scenic stops, drop-off in Karachi']
                ],
                'gallery' => [
                    '/images/gallery/coast-1.jpg',
                    '/images/gallery/coast-2.jpg',
                    '/images/gallery/coast-3.jpg',
                    '/images/gallery/coast-4.jpg',
                ]
            ],
            'swat-valley-discovery' => [
                'id' => 8,
                'title' => 'Swat Valley Discovery',
                'slug' => 'swat-valley-discovery',
                'image' => '/images/tours/swat.jpg',
                'duration' => '4 Days / 3 Nights',
                'price' => 499,
                'type' => 'domestic',
                'location' => 'Swat, Kalam, Mahodand',
                'available_dates' => [
                    '2024-07-01' => 'July 1, 2024',
                    '2024-07-20' => 'July 20, 2024',
                    '2024-08-10' => 'August 10, 2024',
                    '2024-08-30' => 'August 30, 2024',
                ],
                'overview' => 'Lush valleys, rivers, and alpine lakes. Discover Swat\'s beauty from Mingora to Kalam, with an unforgettable trip to Mahodand Lake (seasonal access).',
                'highlights' => [
                    'Malam Jabba chairlift (seasonal)',
                    'Kalam Bazaar and Ushu Forest',
                    'Mahodand Lake jeep excursion',
                    'Swat Museum & Mingora riverfront',
                    'Local trout dinner experience'
                ],
                'itinerary' => [
                    ['day' => 1, 'title' => 'Islamabad to Swat (Mingora)', 'description' => 'Drive to Swat, check-in, river walk and local dinner'],
                    ['day' => 2, 'title' => 'Malam Jabba & Mingora', 'description' => 'Malam Jabba chairlift/zipline (seasonal), Swat Museum, evening café by the river'],
                    ['day' => 3, 'title' => 'Kalam & Ushu Forest', 'description' => 'Transfer to Kalam, explore Ushu Forest, trout lunch, bazaar stroll'],
                    ['day' => 4, 'title' => 'Mahodand Lake & Return', 'description' => 'Jeep to Mahodand Lake (weather permitting), drive back towards Islamabad after noon']
                ],
                'gallery' => [
                    '/images/gallery/swat-1.jpg',
                    '/images/gallery/swat-2.jpg',
                    '/images/gallery/swat-3.jpg',
                    '/images/gallery/swat-4.jpg',
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

