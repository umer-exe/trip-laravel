{{--
    Hero Section Component
    Large banner with call-to-action for home page
    Props: $title, $subtitle, $buttons (optional)
--}}

<section class="hero-section text-white py-5">
    <div class="container position-relative py-5">
        <div class="text-center">
            <h1 class="display-3 fw-bold mb-4">
                {{ $title ?? 'Discover Your Next Adventure' }}
            </h1>
            <p class="lead mb-5 mx-auto" style="max-width: 800px; opacity: 0.95;">
                {{ $subtitle ?? 'Explore breathtaking destinations with our curated international and domestic tours' }}
            </p>

            {{-- Category Buttons --}}
            <div class="d-flex flex-column flex-sm-row gap-3 justify-content-center">
                <a href="{{ route('tours.index') }}?type=international" class="btn btn-light btn-lg fw-semibold px-5 py-3">
                    International Tours
                </a>
                <a href="{{ route('tours.index') }}?type=domestic" class="btn btn-outline-light btn-lg fw-semibold px-5 py-3">
                    Domestic Tours
                </a>
            </div>
        </div>
    </div>
</section>
