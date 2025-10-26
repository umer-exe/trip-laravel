{{-- Shopping Cart Success Page - Order confirmation --}}
@extends('layouts.app')

@section('content')

    {{-- Order Details --}}
    <section class="py-12 bg-gray-50 pt-8 md:pt-10">
        <div class="max-w-4xl mx-auto px-6 md:px-10">
            @if(session('demo_mode'))
                <div class="mb-6 bg-yellow-100 border border-yellow-400 text-yellow-800 px-4 py-3 rounded-lg">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                        </svg>
                        <span class="font-medium">{{ session('demo_mode') }}</span>
                    </div>
                </div>
            @endif
            <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                {{-- Order Header --}}
                <div class="bg-gradient-to-r from-indigo-50 to-purple-50 px-6 py-4 border-b border-gray-200">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <h2 class="text-xl font-semibold text-gray-900">Order Confirmation</h2>
                            <p class="text-sm text-gray-600 mt-1">Order #{{ $order['order_number'] }}</p>
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
                            <p class="font-medium text-gray-900">{{ $order['customer']['first_name'] }} {{ $order['customer']['last_name'] }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Email</p>
                            <p class="font-medium text-gray-900">{{ $order['customer']['email'] }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Phone</p>
                            <p class="font-medium text-gray-900">{{ $order['customer']['phone'] }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Payment Method</p>
                            <p class="font-medium text-gray-900">{{ ucwords(str_replace('_', ' ', $order['payment_method'])) }}</p>
                        </div>
                        <div class="md:col-span-2">
                            <p class="text-sm text-gray-600">Address</p>
                            <p class="font-medium text-gray-900">{{ $order['customer']['address'] }}, {{ $order['customer']['city'] }}, {{ $order['customer']['country'] }}</p>
                        </div>
                    </div>
                </div>

                {{-- Tour Details --}}
                <div class="px-6 py-6 border-t border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Tour Details</h3>
                    <div class="space-y-4">
                        @foreach($order['items'] as $item)
                            <div class="flex items-start space-x-4 p-4 bg-gray-50 rounded-lg">
                                <div class="w-20 h-20 rounded-lg overflow-hidden bg-gray-200 flex-shrink-0">
                                    <img src="{{ $item['image'] }}" alt="{{ $item['title'] }}" class="w-full h-full object-cover">
                                </div>
                                <div class="flex-1">
                                    <h4 class="font-semibold text-gray-900">{{ $item['title'] }}</h4>
                                    <p class="text-sm text-gray-600 mt-1">{{ $item['location'] }}</p>
                                    @if(isset($item['selected_date_label']))
                                        <p class="text-sm text-indigo-600 font-medium mt-1">Departure: {{ $item['selected_date_label'] }}</p>
                                    @endif
                                    <div class="flex items-center mt-2 space-x-4 text-sm text-gray-600">
                                        <span>{{ $item['duration'] }}</span>
                                        <span>•</span>
                                        <span>{{ $item['quantity'] }} {{ $item['quantity'] == 1 ? 'person' : 'people' }}</span>
                                        <span>•</span>
                                        <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $item['type'] === 'international' ? 'bg-blue-100 text-blue-700' : 'bg-green-100 text-green-700' }}">
                                            {{ ucfirst($item['type']) }}
                                        </span>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="font-semibold text-gray-900">${{ number_format($item['price'] * $item['quantity']) }}</p>
                                    <p class="text-sm text-gray-600">${{ number_format($item['price']) }} per person</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Order Summary --}}
                <div class="px-6 py-6 bg-gray-50 border-t border-gray-200">
                    <div class="flex justify-between items-center">
                        <span class="text-lg font-semibold text-gray-900">Total Amount</span>
                        <span class="text-2xl font-bold text-indigo-600">${{ number_format($order['total']) }}</span>
                    </div>
                </div>

                {{-- Special Requests --}}
                @if($order['special_requests'])
                    <div class="px-6 py-6 border-t border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Special Requests</h3>
                        <p class="text-gray-700">{{ $order['special_requests'] }}</p>
                    </div>
                @endif

                {{-- Next Steps --}}
                <div class="px-6 py-6 bg-gradient-to-r from-indigo-50 to-purple-50 border-t border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">What's Next?</h3>
                    <div class="space-y-2 text-sm text-gray-700">
                        <p>• You will receive a confirmation email shortly</p>
                        <p>• Our team will contact you within 24 hours to discuss tour details</p>
                        <p>• Payment instructions will be provided based on your selected method</p>
                        <p>• Tour itineraries and travel documents will be sent 7 days before departure</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection




