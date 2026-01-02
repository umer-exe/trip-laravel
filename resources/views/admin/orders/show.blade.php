@extends('layouts.admin')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-6 flex justify-between items-center">
                <a href="{{ route('admin.orders.index') }}" class="text-indigo-600 hover:text-indigo-900 font-semibold">
                    &larr; Back to Orders
                </a>
            </div>

            <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                {{-- Order Header --}}
                <div class="bg-gradient-to-r from-indigo-50 to-purple-50 px-6 py-4 border-b border-gray-200">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <h2 class="text-xl font-semibold text-gray-900">Order Invoice</h2>
                            <p class="text-sm text-gray-600 mt-1">Order #{{ $order->order_number }}</p>
                        </div>
                        <div class="mt-2 sm:mt-0">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-700">
                                Confirmed
                            </span>
                        </div>
                    </div>
                </div>

                {{-- Customer Information --}}
                <div class="px-6 py-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Customer Information</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-600">Name</p>
                            <p class="font-medium text-gray-900">{{ $order->first_name }} {{ $order->last_name }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Email</p>
                            <p class="font-medium text-gray-900">{{ $order->email }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Phone</p>
                            <p class="font-medium text-gray-900">{{ $order->phone }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Payment Method</p>
                            <p class="font-medium text-gray-900">{{ ucwords(str_replace('_', ' ', $order->payment_method)) }}</p>
                        </div>
                        <div class="md:col-span-2">
                            <p class="text-sm text-gray-600">Address</p>
                            <p class="font-medium text-gray-900">{{ $order->address }}, {{ $order->city }}, {{ $order->country }}</p>
                        </div>
                    </div>
                </div>

                {{-- Tour Details --}}
                <div class="px-6 py-6 border-t border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Tour Details</h3>
                    <div class="space-y-4">
                        @foreach($order->items as $item)
                            @php
                                $tour = $item->tour;
                                $imageUrl = $tour->thumbnail_image ? asset('storage/' . $tour->thumbnail_image) : ($tour->banner_image ? asset($tour->banner_image) : 'https://placehold.co/160x120?text=Tour');
                            @endphp
                            <div class="flex items-start space-x-4 p-4 bg-gray-50 rounded-lg">
                                <div class="w-20 h-20 rounded-lg overflow-hidden bg-gray-200 flex-shrink-0">
                                    <img src="{{ $imageUrl }}" alt="{{ $tour->title }}" class="w-full h-full object-cover">
                                </div>
                                <div class="flex-1">
                                    <h4 class="font-semibold text-gray-900">{{ $tour->title }}</h4>
                                    <p class="text-sm text-gray-600 mt-1">{{ $tour->location }}</p>
                                    @if($item->travel_date)
                                        <p class="text-sm text-indigo-600 font-medium mt-1">Departure: {{ $item->travel_date }}</p>
                                    @endif
                                    <div class="flex items-center mt-2 space-x-4 text-sm text-gray-600">
                                        <span>{{ $tour->duration }}</span>
                                        <span>•</span>
                                        <span>{{ $item->quantity }} {{ $item->quantity == 1 ? 'person' : 'people' }}</span>
                                        <span>•</span>
                                        <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $tour->type === 'international' ? 'bg-blue-100 text-blue-700' : 'bg-green-100 text-green-700' }}">
                                            {{ ucfirst($tour->type) }}
                                        </span>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="font-semibold text-gray-900">${{ number_format($item->subtotal) }}</p>
                                    <p class="text-sm text-gray-600">${{ number_format($item->price) }} per person</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Order Summary --}}
                <div class="px-6 py-6 bg-gray-50 border-t border-gray-200">
                    <div class="flex justify-between items-center">
                        <span class="text-lg font-semibold text-gray-900">Total Amount</span>
                        <span class="text-2xl font-bold text-indigo-600">${{ number_format($order->total_amount) }}</span>
                    </div>
                </div>

                {{-- Special Requests --}}
                @if($order->special_requests)
                    <div class="px-6 py-6 border-t border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Special Requests</h3>
                        <p class="text-gray-700">{{ $order->special_requests }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
