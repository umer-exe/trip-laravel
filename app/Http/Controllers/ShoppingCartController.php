<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ShoppingCartController extends Controller
{
    /**
     * Display the shopping cart page
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $cartItems = session('cart', []);
        
        if (empty($cartItems)) {
            return redirect()->route('tours.index')->with('error', 'Your cart is empty.');
        }

        $total = 0;
        foreach ($cartItems as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        return view('shoppingcart.index', compact('cartItems', 'total'));
    }

    /**
     * Process the shopping cart booking
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:500',
            'city' => 'required|string|max:100',
            'country' => 'required|string|max:100',
            'payment_method' => 'required|in:credit_card,bank_transfer,cash_on_delivery',
            'special_requests' => 'nullable|string|max:1000',
        ]);

        $cartItems = session('cart', []);
        
        if (empty($cartItems)) {
            return redirect()->route('shoppingcart.index')->with('error', 'Your cart is empty.');
        }

        // Calculate total
        $total = 0;
        foreach ($cartItems as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        // Store order data in session (in a real app, this would be saved to database)
        $orderData = [
            'order_number' => 'ATL-' . strtoupper(uniqid()),
            'customer' => [
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
                'city' => $request->city,
                'country' => $request->country,
            ],
            'items' => $cartItems,
            'total' => $total,
            'payment_method' => $request->payment_method,
            'special_requests' => $request->special_requests,
            'created_at' => now()->format('Y-m-d H:i:s'),
            'demo_mode' => true, // Flag to indicate this is demo mode
        ];

        try {
            // In a real application, you would save to database here
            // $order = Order::create($orderData);
            // For now, we'll just store in session for demo purposes
            
            session(['order' => $orderData]);
            
            // Clear cart
            session()->forget('cart');
            
            return redirect()->route('shoppingcart.success');
            
        } catch (\Exception $e) {
            // If database operations fail, still show demo mode
            session(['order' => $orderData]);
            session()->forget('cart');
            
            return redirect()->route('shoppingcart.success')->with('demo_mode', 'Shopping cart demo mode: run php artisan migrate to enable saving orders.');
        }
    }

    /**
     * Add a tour to the cart
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function add(Request $request)
    {
        $request->validate([
            'tour_id' => 'required|integer',
            'quantity' => 'required|integer|min:1',
            'selected_date' => 'required|string',
        ]);

        $tourId = $request->tour_id;
        $quantity = $request->quantity;
        $selectedDate = $request->selected_date;

        // Get tour data from SiteController
        $allTours = $this->getAllTours();
        $tour = collect($allTours)->firstWhere('id', $tourId);
        
        if (!$tour) {
            return redirect()->back()->with('error', 'Tour not found.');
        }

        // Get available dates for this tour
        $tourWithDates = $this->getTourWithDates($tourId);
        $availableDates = $tourWithDates['available_dates'] ?? [];
        
        // Validate selected date
        if (!array_key_exists($selectedDate, $availableDates)) {
            return redirect()->back()->with('error', 'Invalid date selected.');
        }

        $cart = session('cart', []);
        
        // Check if tour with same date already exists in cart
        $existingIndex = collect($cart)->search(function ($item) use ($tourId, $selectedDate) {
            return $item['id'] == $tourId && $item['selected_date'] == $selectedDate;
        });

        if ($existingIndex !== false) {
            // Update quantity for existing tour with same date
            $cart[$existingIndex]['quantity'] += $quantity;
        } else {
            // Add new item with selected date
            $cart[] = [
                'id' => $tour['id'],
                'title' => $tour['title'],
                'slug' => $tour['slug'],
                'image' => $tour['image'],
                'duration' => $tour['duration'],
                'price' => $tour['price'],
                'type' => $tour['type'],
                'location' => $tour['location'],
                'quantity' => $quantity,
                'selected_date' => $selectedDate,
                'selected_date_label' => $availableDates[$selectedDate],
            ];
        }

        session(['cart' => $cart]);

        return redirect()->route('shoppingcart.index')->with('success', 'Tour added to cart successfully!');
    }

    /**
     * Update cart item quantity
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $request->validate([
            'tour_id' => 'required|integer',
            'quantity' => 'required|integer|min:1',
            'selected_date' => 'required|string',
        ]);

        $tourId = $request->tour_id;
        $quantity = $request->quantity;
        $selectedDate = $request->selected_date;

        $cart = session('cart', []);
        
        $index = collect($cart)->search(function ($item) use ($tourId, $selectedDate) {
            return $item['id'] == $tourId && $item['selected_date'] == $selectedDate;
        });

        if ($index !== false) {
            $cart[$index]['quantity'] = $quantity;
            session(['cart' => $cart]);
        }

        return redirect()->route('shoppingcart.index');
    }

    /**
     * Remove item from cart
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove(Request $request)
    {
        $request->validate([
            'tour_id' => 'required|integer',
            'selected_date' => 'required|string',
        ]);

        $tourId = $request->tour_id;
        $selectedDate = $request->selected_date;
        $cart = session('cart', []);
        
        // Only remove the specific tour with the specific date
        $cart = collect($cart)->reject(function ($item) use ($tourId, $selectedDate) {
            return $item['id'] == $tourId && $item['selected_date'] == $selectedDate;
        })->values()->toArray();

        session(['cart' => $cart]);

        // If cart is now empty, redirect to tours page
        if (empty($cart)) {
            return redirect()->route('tours.index')->with('success', 'Tour removed from cart. Your cart is now empty.');
        }

        return redirect()->route('shoppingcart.index')->with('success', 'Tour removed from cart.');
    }

    /**
     * Clear the entire cart
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function clear()
    {
        session()->forget('cart');
        return redirect()->route('tours.index')->with('success', 'Cart cleared successfully.');
    }

    /**
     * Display order success page
     *
     * @return \Illuminate\View\View
     */
    public function success()
    {
        $order = session('order');
        
        if (!$order) {
            return redirect()->route('home');
        }

        return view('shoppingcart.success', compact('order'));
    }

    /**
     * Get tour data with available dates
     *
     * @param int $tourId
     * @return array
     */
    private function getTourWithDates($tourId)
    {
        $tours = [
            1 => [
                'available_dates' => [
                    '2024-03-15' => 'March 15, 2024',
                    '2024-04-10' => 'April 10, 2024',
                    '2024-05-05' => 'May 5, 2024',
                    '2024-06-20' => 'June 20, 2024',
                ]
            ],
            2 => [
                'available_dates' => [
                    '2024-06-01' => 'June 1, 2024',
                    '2024-07-15' => 'July 15, 2024',
                    '2024-08-10' => 'August 10, 2024',
                    '2024-09-05' => 'September 5, 2024',
                ]
            ],
            3 => [
                'available_dates' => [
                    '2024-05-01' => 'May 1, 2024',
                    '2024-06-15' => 'June 15, 2024',
                    '2024-07-20' => 'July 20, 2024',
                    '2024-08-25' => 'August 25, 2024',
                ]
            ],
            4 => [
                'available_dates' => [
                    '2024-02-10' => 'February 10, 2024',
                    '2024-03-25' => 'March 25, 2024',
                    '2024-04-15' => 'April 15, 2024',
                    '2024-05-30' => 'May 30, 2024',
                ]
            ],
            5 => [
                'available_dates' => [
                    '2024-12-01' => 'December 1, 2024',
                    '2024-12-15' => 'December 15, 2024',
                    '2025-01-10' => 'January 10, 2025',
                    '2025-02-05' => 'February 5, 2025',
                ]
            ],
            6 => [
                'available_dates' => [
                    '2024-03-01' => 'March 1, 2024',
                    '2024-03-20' => 'March 20, 2024',
                    '2024-04-10' => 'April 10, 2024',
                    '2024-05-01' => 'May 1, 2024',
                ]
            ],
            7 => [
                'available_dates' => [
                    '2024-11-01' => 'November 1, 2024',
                    '2024-11-20' => 'November 20, 2024',
                    '2024-12-10' => 'December 10, 2024',
                    '2025-01-05' => 'January 5, 2025',
                ]
            ],
            8 => [
                'available_dates' => [
                    '2024-07-01' => 'July 1, 2024',
                    '2024-07-20' => 'July 20, 2024',
                    '2024-08-10' => 'August 10, 2024',
                    '2024-08-30' => 'August 30, 2024',
                ]
            ],
        ];

        return $tours[$tourId] ?? ['available_dates' => []];
    }

    /**
     * Get all tours data (helper method)
     *
     * @return array
     */
    private function getAllTours()
    {
        return [
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
    }
}



