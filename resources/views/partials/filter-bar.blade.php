{{--
    Filter Bar Component
    Filter controls for tours page (static UI for Phase 1)
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

        {{-- Additional Filters (Static UI for Phase 1) --}}
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            {{-- Duration Filter --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Duration</label>
                <select class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" disabled>
                    <option>Any Duration</option>
                    <option>1-5 Days</option>
                    <option>6-10 Days</option>
                    <option>10+ Days</option>
                </select>
            </div>

            {{-- Budget Filter --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Budget</label>
                <select class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" disabled>
                    <option>Any Budget</option>
                    <option>Under $500</option>
                    <option>$500 - $1500</option>
                    <option>$1500 - $3000</option>
                    <option>$3000+</option>
                </select>
            </div>

            {{-- Month Filter --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Month</label>
                <select class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" disabled>
                    <option>Any Month</option>
                    <option>January - March</option>
                    <option>April - June</option>
                    <option>July - September</option>
                    <option>October - December</option>
                </select>
            </div>

            {{-- Search --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                <input type="text" placeholder="Search tours..." class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" disabled>
            </div>
        </div>

        <p class="text-xs text-gray-500 mt-2">
            <span class="inline-flex items-center">
                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                </svg>
                Advanced filters will be functional in Phase 2
            </span>
        </p>
    </div>
</div>
