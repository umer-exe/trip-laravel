{{-- Tour Detail Page - Shows full tour information and itinerary --}}
@extends('layouts.app')

@section('content')

    {{-- Tour Hero Image --}}
    <section class="relative h-96 bg-gray-900">
        <div class="absolute inset-0 bg-gradient-to-br from-indigo-500 to-purple-600"></div>
        <div class="absolute inset-0 bg-black opacity-40"></div>
        <div class="relative h-full flex items-end">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-12 w-full">
                <div class="flex items-center mb-4">
                <span class="px-3 py-1 rounded-full text-sm font-semibold {{ $tour['type'] === 'international' ? 'bg-blue-500 text-white' : 'bg-green-500 text-white' }}">
                    {{ ucfirst($tour['type']) }} Tour
                </span>
                </div>
                <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">{{ $tour['title'] }}</h1>
                <div class="flex flex-wrap gap-6 text-white">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <span>{{ $tour['location'] }}</span>
                    </div>
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span>{{ $tour['duration'] }}</span>
                    </div>
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span class="text-2xl font-bold">${{ number_format($tour['price']) }}</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Tour Content --}}
    <section class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                {{-- Main Content --}}
                <div class="lg:col-span-2 space-y-8">
                    {{-- Overview --}}
                    <div class="bg-white rounded-lg shadow-sm p-6">
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">Overview</h2>
                        <p class="text-gray-700 leading-relaxed">{{ $tour['overview'] }}</p>
                    </div>

                    {{-- Highlights --}}
                    <div class="bg-white rounded-lg shadow-sm p-6">
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">Tour Highlights</h2>
                        <ul class="space-y-3">
                            @foreach($tour['highlights'] as $highlight)
                                <li class="flex items-start">
                                    <svg class="w-6 h-6 text-green-500 mr-3 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <span class="text-gray-700">{{ $highlight }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    {{-- Itinerary --}}
                    <div class="bg-white rounded-lg shadow-sm p-6">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6">Detailed Itinerary</h2>
                        <div class="space-y-4">
                            @foreach($tour['itinerary'] as $item)
                                <div class="border-l-4 border-indigo-600 pl-4 py-2">
                                    <div class="flex items-center mb-2">
                                    <span class="bg-indigo-600 text-white text-sm font-bold px-3 py-1 rounded-full mr-3">
                                        Day {{ $item['day'] }}
                                    </span>
                                        <h3 class="text-lg font-semibold text-gray-900">{{ $item['title'] }}</h3>
                                    </div>
                                    <p class="text-gray-600">{{ $item['description'] }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Gallery --}}
                    <div class="bg-white rounded-lg shadow-sm p-6">
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">Photo Gallery</h2>
                        <div class="grid grid-cols-2 gap-4">
                            @foreach($tour['gallery'] as $index => $image)
                                <div class="relative h-48 rounded-lg overflow-hidden bg-gradient-to-br {{ $index % 4 === 0 ? 'from-blue-400 to-indigo-500' : ($index % 4 === 1 ? 'from-green-400 to-teal-500' : ($index % 4 === 2 ? 'from-pink-400 to-purple-500' : 'from-yellow-400 to-orange-500')) }}">
                                    {{-- Placeholder gradient images --}}
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- Sidebar --}}
                <div class="lg:col-span-1">
                    {{-- Booking Card --}}
                    <div class="bg-white rounded-lg shadow-lg p-6 sticky top-24">
                        <div class="text-center mb-6">
                            <p class="text-gray-600 text-sm mb-2">Starting from</p>
                            <p class="text-4xl font-bold text-indigo-600">${{ number_format($tour['price']) }}</p>
                            <p class="text-gray-500 text-sm">per person</p>
                        </div>

                        <form action="#" method="POST" class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                                <input type="text" required class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" placeholder="John Doe">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                                <input type="email" required class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" placeholder="john@example.com">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
                                <input type="tel" required class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" placeholder="+92 300 1234567">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Number of Travelers</label>
                                <input type="number" min="1" value="1" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Preferred Date</label>
                                <input type="date" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Message (Optional)</label>
                                <textarea rows="3" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" placeholder="Any special requests?"></textarea>
                            </div>

                            <button type="submit" class="w-full bg-indigo-600 text-white py-3 rounded-lg font-semibold hover:bg-indigo-700 transition">
                                Send Enquiry
                            </button>
                        </form>

                        <p class="text-xs text-gray-500 text-center mt-4">
                            Form submission will be functional in Phase 2
                        </p>

                        <div class="mt-6 pt-6 border-t">
                            <h4 class="font-semibold text-gray-900 mb-3">Need Help?</h4>
                            <div class="space-y-2 text-sm">
                                <a href="tel:+922135205678" class="flex items-center text-gray-600 hover:text-indigo-600">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                    </svg>
                                    +92-21-35205678
                                </a>
                                <a href="https://wa.me/923001234567" class="flex items-center text-gray-600 hover:text-green-600">
                                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                                    </svg>
                                    WhatsApp Us
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
