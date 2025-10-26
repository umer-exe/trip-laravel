{{--
    Hero Section Component
    Large banner with call-to-action for home page
    Props: $title, $subtitle, $buttons (optional)
--}}

<section class="relative bg-gradient-to-r from-indigo-600 to-purple-600 text-white">
    <div class="absolute inset-0 bg-black opacity-20"></div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 md:py-20">
        <div class="text-center">
            <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold mb-4">
                {{ $title ?? 'Discover Your Next Adventure' }}
            </h1>
            <p class="text-lg md:text-xl mb-6 text-indigo-100 max-w-2xl mx-auto">
                {{ $subtitle ?? 'Explore breathtaking destinations with our curated international and domestic tours' }}
            </p>

            {{-- Category Buttons --}}
            <div class="flex flex-col sm:flex-row gap-3 justify-center items-center">
                <a href="{{ route('tours.index') }}?type=international" class="bg-white text-indigo-600 px-6 py-3 rounded-lg font-semibold text-base hover:bg-indigo-50 transition transform hover:scale-105 w-full sm:w-auto">
                    International Tours
                </a>
                <a href="{{ route('tours.index') }}?type=domestic" class="bg-indigo-800 text-white px-6 py-3 rounded-lg font-semibold text-base hover:bg-indigo-900 transition transform hover:scale-105 w-full sm:w-auto border-2 border-white">
                    Domestic Tours
                </a>
            </div>
        </div>
    </div>
</section>