<?php

namespace App\Http\Controllers;

use App\Models\Tour;
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

        try {
            $order = \App\Models\Order::create([
                'order_number' => 'ATL-' . strtoupper(uniqid()),
                'user_id' => auth()->id(), // Associate with logged-in user if available
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
                'city' => $request->city,
                'country' => $request->country,
                'total_amount' => $total,
                'payment_method' => $request->payment_method,
                'status' => 'pending',
                'special_requests' => $request->special_requests,
            ]);

            foreach ($cartItems as $item) {
                \App\Models\OrderItem::create([
                    'order_id' => $order->id,
                    'tour_id' => $item['id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'subtotal' => $item['price'] * $item['quantity'],
                    'travel_date' => $item['selected_date'],
                ]);
            }
            
            // Store order data in session for success page
            session(['order' => $order]);
            
            // Clear cart
            session()->forget('cart');
            
            return redirect()->route('shoppingcart.success');
            
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to place order: ' . $e->getMessage())->withInput();
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
        $validated = $request->validate([
            'tour_id' => 'required|integer|exists:tours,id',
            'quantity' => 'required|integer|min:1',
            'selected_date' => 'required|string',
        ]);

        $tour = Tour::query()
            ->where('status', 'active')
            ->find($validated['tour_id']);

        if (!$tour) {
            return redirect()->back()->with('error', 'Tour not available.');
        }

        $availableDates = $tour->available_dates ?? [];

        if (!array_key_exists($validated['selected_date'], $availableDates)) {
            return redirect()->back()->with('error', 'Invalid date selected.');
        }

        $cart = session('cart', []);
        
        // Check if tour with same date already exists in cart
        $existingIndex = collect($cart)->search(function ($item) use ($validated) {
            return $item['id'] == $validated['tour_id'] && $item['selected_date'] == $validated['selected_date'];
        });

        if ($existingIndex !== false) {
            // Update quantity for existing tour with same date
            $cart[$existingIndex]['quantity'] += $validated['quantity'];
        } else {
            // Add new item with selected date
            $cart[] = [
                'id' => $tour->id,
                'title' => $tour->title,
                'slug' => $tour->slug,
                'image' => $tour->thumbnail_image ?? $tour->banner_image,
                'duration' => $tour->duration,
                'price' => (float) $tour->price,
                'type' => $tour->type,
                'location' => $tour->location,
                'quantity' => $validated['quantity'],
                'selected_date' => $validated['selected_date'],
                'selected_date_label' => $availableDates[$validated['selected_date']] ?? $validated['selected_date'],
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

    // helper methods removed; all tour data now comes from the database
}



