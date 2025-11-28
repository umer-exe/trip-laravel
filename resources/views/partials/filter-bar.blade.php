{{--
    Filter Bar Component
    Filter controls for tours page
    Props: $filterType (current selected filter)
--}}

<div class="bg-white shadow-sm border-b sticky top-16 z-40">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
        {{-- Tour Type Selector --}}
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-2">Tour Type</label>
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('tours.index') }}" class="px-4 py-2 rounded-lg font-medium transition {{ $filterType === 'all' ? 'bg-indigo-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                    All Tours
                </a>
                <a href="{{ route('tours.index') }}?type=international" class="px-4 py-2 rounded-lg font-medium transition {{ $filterType === 'international' ? 'bg-indigo-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                    International
                </a>
                <a href="{{ route('tours.index') }}?type=domestic" class="px-4 py-2 rounded-lg font-medium transition {{ $filterType === 'domestic' ? 'bg-indigo-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                    Domestic
                </a>
            </div>
        </div>

        {{-- Additional Filters Form --}}
        <form method="GET" action="{{ route('tours.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            {{-- Preserve type filter --}}
            @if(request('type'))
                <input type="hidden" name="type" value="{{ request('type') }}">
            @endif

            {{-- Destination Search --}}
            <div>
                <label for="destination" class="block text-sm font-medium text-gray-700 mb-1">Destination</label>
                <input type="text" id="destination" name="destination" value="{{ request('destination') }}" placeholder="Search location..." class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
            </div>

            {{-- Min Price --}}
            <div>
                <label for="min_price" class="block text-sm font-medium text-gray-700 mb-1">Min Price ($)</label>
                <input type="number" id="min_price" name="min_price" value="{{ request('min_price') }}" placeholder="0" min="0" step="100" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
            </div>

            {{-- Max Price --}}
            <div>
                <label for="max_price" class="block text-sm font-medium text-gray-700 mb-1">Max Price ($)</label>
                <input type="number" id="max_price" name="max_price" value="{{ request('max_price') }}" placeholder="10000" min="0" step="100" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
            </div>

            {{-- Filter Buttons --}}
            <div class="flex items-end gap-2">
                <button type="submit" class="flex-1 bg-indigo-600 text-white px-4 py-2 rounded-lg font-medium hover:bg-indigo-700 transition">
                    Apply Filters
                </button>
                @if(request()->hasAny(['destination', 'min_price', 'max_price']))
                    <a href="{{ route('tours.index') }}{{ request('type') ? '?type=' . request('type') : '' }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">
                        Clear
                    </a>
                @endif
            </div>
        </form>
    </div>
</div>
