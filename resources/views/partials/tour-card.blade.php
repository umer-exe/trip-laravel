{{--
    Tour Card Component
    Reusable card for displaying tour information
    Props: $tour (array with id, title, slug, image, duration, price, location, type)
--}}

<div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition transform hover:-translate-y-1 flex flex-col h-full">
    {{-- Tour Image with Type Badge --}}
    <div class="relative h-48 bg-gray-300 flex-shrink-0">
        {{-- Tour Image --}}
        <img src="{{ $tour['image'] }}" alt="{{ $tour['title'] }}" class="absolute inset-0 w-full h-full object-cover">

        {{-- Fallback gradient if image fails to load --}}
        <div class="absolute inset-0 bg-gradient-to-br from-indigo-400 to-purple-500 -z-10"></div>

        {{-- Type Badge --}}
        <div class="absolute top-3 right-3">
            <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $tour['type'] === 'international' ? 'bg-blue-500 text-white' : 'bg-green-500 text-white' }}">
                {{ ucfirst($tour['type']) }}
            </span>
        </div>
    </div>

    {{-- Tour Details --}}
    <div class="p-5 flex flex-col flex-grow">
        <h3 class="text-xl font-bold text-gray-900 mb-1 h-14 line-clamp-2">
            {{ $tour['title'] }}
        </h3>

        <div class="flex items-start text-gray-600 text-sm mb-auto h-10">
            <svg class="w-4 h-4 mr-1 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
            </svg>
            <span class="line-clamp-2">{{ $tour['location'] }}</span>
        </div>

        <div class="flex items-start justify-between mb-3 h-16">
            <div class="flex items-center text-gray-600 text-sm">
                <svg class="w-4 h-4 mr-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span>{{ $tour['duration'] }}</span>
            </div>

            <div class="text-right">
                <span class="text-sm text-gray-500">From</span>
                <div class="text-2xl font-bold text-indigo-600">
                    ${{ number_format($tour['price']) }}
                </div>
            </div>
        </div>

        <a href="{{ route('tours.show', $tour['slug']) }}" class="block w-full bg-indigo-600 text-white text-center py-2 rounded-lg hover:bg-indigo-700 transition font-medium">
            View Details
        </a>
    </div>
</div>
