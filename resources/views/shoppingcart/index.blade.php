{{-- 
    Shopping Cart & Checkout Page
    
    This view serves as a combined Shopping Cart and Checkout page.
    It displays:
    1. Customer Information Form (Name, Email, Phone, Address)
    2. Payment Method Selection (Cash/Card on Delivery)
    3. Cart Summary (List of selected tours with ability to update quantities or remove items)
    
    It submits to 'shoppingcart.store' for order processing.
--}}
{{-- Shopping Cart Page - Combined cart and checkout --}}
@extends('layouts.app')

@section('content')

    {{-- Page Header --}}
    <section class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Shopping Cart</h1>
            <p class="text-xl text-indigo-100">Review your tours and complete your booking</p>
        </div>
    </section>

    {{-- Shopping Cart Content --}}
    <section class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto px-6 md:px-10">
            
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                {{-- Customer Information Form --}}
                <div class="lg:col-span-2">
                    <form action="{{ route('shoppingcart.store') }}" method="POST">
                        @csrf
                    <div class="bg-white rounded-lg shadow-sm p-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-6">Customer Information</h2>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            {{-- First Name --}}
                            <div>
                                <label for="first_name" class="block text-sm font-medium text-gray-700 mb-2">First Name *</label>
                                <input type="text" id="first_name" name="first_name" required 
                                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                       value="{{ old('first_name') }}">
                                @error('first_name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Last Name --}}
                            <div>
                                <label for="last_name" class="block text-sm font-medium text-gray-700 mb-2">Last Name *</label>
                                <input type="text" id="last_name" name="last_name" required 
                                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                       value="{{ old('last_name') }}">
                                @error('last_name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Email --}}
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email Address *</label>
                                <input type="email" id="email" name="email" required 
                                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                       value="{{ old('email') }}">
                                @error('email')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Phone --}}
                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Phone Number *</label>
                                <input type="tel" id="phone" name="phone" required 
                                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                       placeholder="+92 300 1234567"
                                       value="{{ old('phone') }}">
                                @error('phone')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Address --}}
                            <div class="md:col-span-2">
                                <label for="address" class="block text-sm font-medium text-gray-700 mb-2">Address *</label>
                                <textarea id="address" name="address" rows="3" required 
                                          class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                          placeholder="Enter your complete address">{{ old('address') }}</textarea>
                                @error('address')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- City --}}
                            <div>
                                <label for="city" class="block text-sm font-medium text-gray-700 mb-2">City *</label>
                                <input type="text" id="city" name="city" required 
                                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                       value="{{ old('city') }}">
                                @error('city')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Country --}}
                            <div>
                                <label for="country" class="block text-sm font-medium text-gray-700 mb-2">Country *</label>
                                <select id="country" name="country" required 
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                    <option value="">Select Country</option>
                                    <option value="Pakistan" {{ old('country') == 'Pakistan' ? 'selected' : '' }}>Pakistan</option>
                                    <option value="United States" {{ old('country') == 'United States' ? 'selected' : '' }}>United States</option>
                                    <option value="United Kingdom" {{ old('country') == 'United Kingdom' ? 'selected' : '' }}>United Kingdom</option>
                                    <option value="Canada" {{ old('country') == 'Canada' ? 'selected' : '' }}>Canada</option>
                                    <option value="Australia" {{ old('country') == 'Australia' ? 'selected' : '' }}>Australia</option>
                                    <option value="Germany" {{ old('country') == 'Germany' ? 'selected' : '' }}>Germany</option>
                                    <option value="France" {{ old('country') == 'France' ? 'selected' : '' }}>France</option>
                                    <option value="Other" {{ old('country') == 'Other' ? 'selected' : '' }}>Other</option>
                                </select>
                                @error('country')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>


                        {{-- Payment Method --}}
                        <div class="mt-8">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Payment Method</h3>
                            <div class="space-y-3">
                                <div class="flex items-center">
                                    <input type="radio" id="cash_on_delivery" name="payment_method" value="cash_on_delivery" 
                                           class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300"
                                           {{ old('payment_method', 'cash_on_delivery') == 'cash_on_delivery' ? 'checked' : '' }}>
                                    <label for="cash_on_delivery" class="ml-3 text-sm font-medium text-gray-700">
                                        Cash on Delivery
                                    </label>
                                </div>
                                <div class="flex items-center">
                                    <input type="radio" id="card_on_delivery" name="payment_method" value="card_on_delivery" 
                                           class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300"
                                           {{ old('payment_method') == 'card_on_delivery' ? 'checked' : '' }}>
                                    <label for="card_on_delivery" class="ml-3 text-sm font-medium text-gray-700">
                                        Card on Delivery
                                    </label>
                                </div>
                            </div>
                            @error('payment_method')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        {{-- Confirm Booking Button --}}
                        <div class="mt-8">
                            <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-md py-2.5 transition">
                                Confirm Booking
                            </button>
                        </div>
                    </div>
                    </form>
                </div>

                {{-- Order Summary / Cart --}}
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-lg shadow-sm p-6 sticky top-24">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Order Summary</h3>
                        
                        {{-- Cart Items with Quantity Controls --}}
                        <div class="space-y-4 mb-6">
                            @foreach($cartItems as $item)
                                @php
                                    $imageUrl = isset($item['image']) ? asset($item['image']) : 'https://placehold.co/160x120?text=Tour';
                                @endphp
                                <div class="border border-gray-200 rounded-lg p-4">
                                    <div class="flex items-start gap-4 mb-4">
                                        <div class="w-20 h-20 rounded-lg overflow-hidden bg-gray-100 flex-shrink-0">
                                            <img src="{{ $imageUrl }}" alt="{{ $item['title'] }}" class="w-full h-full object-cover">
                                        </div>
                                        <div class="flex-1">
                                            <div class="flex justify-between items-start">
                                                <div>
                                                    <h4 class="font-medium text-gray-900">{{ $item['title'] }}</h4>
                                                    <p class="text-sm text-gray-600">{{ $item['duration'] }}</p>
                                                    @if(isset($item['selected_date_label']))
                                                        <p class="text-sm text-indigo-600 font-medium">Departure: {{ $item['selected_date_label'] }}</p>
                                                    @endif
                                                </div>
                                                <form action="{{ route('cart.remove') }}" method="POST" class="inline">
                                                    @csrf
                                                    <input type="hidden" name="tour_id" value="{{ $item['id'] }}">
                                                    @if(isset($item['selected_date']))
                                                        <input type="hidden" name="selected_date" value="{{ $item['selected_date'] }}">
                                                    @endif
                                                    <button type="submit" class="text-red-600 hover:text-red-800 text-sm p-1 rounded hover:bg-red-50 transition" title="Remove tour">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                        </svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center space-x-2">
                                            <form action="{{ route('cart.update') }}" method="POST" class="inline">
                                                @csrf
                                                <input type="hidden" name="tour_id" value="{{ $item['id'] }}">
                                                @if(isset($item['selected_date']))
                                                    <input type="hidden" name="selected_date" value="{{ $item['selected_date'] }}">
                                                @endif
                                                <input type="hidden" name="quantity" value="{{ max(1, $item['quantity'] - 1) }}">
                                                <button type="submit" class="w-6 h-6 rounded-full border border-gray-300 flex items-center justify-center hover:bg-gray-50 disabled:opacity-50" {{ $item['quantity'] <= 1 ? 'disabled' : '' }}>
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                                                    </svg>
                                                </button>
                                            </form>

                                            <span class="w-6 text-center font-medium">{{ $item['quantity'] }}</span>

                                            <form action="{{ route('cart.update') }}" method="POST" class="inline">
                                                @csrf
                                                <input type="hidden" name="tour_id" value="{{ $item['id'] }}">
                                                @if(isset($item['selected_date']))
                                                    <input type="hidden" name="selected_date" value="{{ $item['selected_date'] }}">
                                                @endif
                                                <input type="hidden" name="quantity" value="{{ min(20, $item['quantity'] + 1) }}">
                                                <button type="submit" class="w-6 h-6 rounded-full border border-gray-300 flex items-center justify-center hover:bg-gray-50 disabled:opacity-50" {{ $item['quantity'] >= 20 ? 'disabled' : '' }}>
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>

                                        <div class="text-right">
                                            <div class="font-semibold text-gray-900">${{ number_format($item['price'] * $item['quantity']) }}</div>
                                            <div class="text-xs text-gray-500">${{ number_format($item['price']) }} each</div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        {{-- Total --}}
                        <div class="border-t border-gray-200 pt-4 mb-6">
                            <div class="flex justify-between items-center">
                                <span class="text-lg font-semibold text-gray-900">Total</span>
                                <span class="text-2xl font-bold text-indigo-600">${{ number_format($total) }}</span>
                            </div>
                        </div>


                        {{-- Continue Shopping Link --}}
                        <div class="text-center">
                            <a href="{{ route('tours.index') }}" class="text-indigo-600 hover:text-indigo-700 underline-offset-2 hover:underline transition">
                                Continue Shopping
                            </a>
                        </div>

                        {{-- Terms and Conditions --}}
                        <div class="mt-6 pt-6 border-t border-gray-200">
                            <p class="text-xs text-gray-500 text-center">
                                By completing this booking, you agree to our 
                                <a href="#" class="text-indigo-600 hover:text-indigo-800">Terms & Conditions</a> 
                                and <a href="#" class="text-indigo-600 hover:text-indigo-800">Privacy Policy</a>.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection



