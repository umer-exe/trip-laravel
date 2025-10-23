{{--
    Hero Section Component
    Large banner with call-to-action for home page
    Props: $title, $subtitle, $buttons (optional)
--}}

<section class="relative bg-gradient-to-r from-indigo-600 to-purple-600 text-white">
    <div class="absolute inset-0 bg-black opacity-20"></div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 md:py-32">
        <div class="text-center">
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-6">
                {{ $title ?? 'Discover Your Next Adventure' }}
            </h1>
            <p class="text-xl md:text-2xl mb-8 text-indigo-100 max-w-3xl mx-auto">
                {{ $subtitle ?? 'Explore breathtaking destinations with our curated international and domestic tours' }}
            </p>

            {{-- Category Buttons --}}
            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                <a href="{{ route('tours.index') }}?type=international" class="bg-white text-indigo-600 px-8 py-4 rounded-lg font-semibold text-lg hover:bg-indigo-50 transition transform hover:scale-105 w-full sm:w-auto">
                    International Tours
                </a>
                <a href="{{ route('tours.index') }}?type=domestic" class="bg-indigo-800 text-white px-8 py-4 rounded-lg font-semibold text-lg hover:bg-indigo-900 transition transform hover:scale-105 w-full sm:w-auto border-2 border-white">
                    Domestic Tours
                </a>
            </div>
        </div>
    </div>
</section>
