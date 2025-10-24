{{--
    Tour Card Component
    Reusable card for displaying tour information
    Props: $tour (array with id, title, slug, image, duration, price, location, type)
--}}

<div class="card tour-card h-100 border-0 shadow-sm">
    {{-- Tour Image with Type Badge --}}
    <div class="position-relative" style="height: 200px;">
        <img src="{{ $tour['image'] }}" alt="{{ $tour['title'] }}" class="card-img-top h-100 w-100" style="object-fit: cover;">

        {{-- Type Badge --}}
        <div class="position-absolute top-0 end-0 m-3">
            <span class="badge {{ $tour['type'] === 'international' ? 'bg-primary' : 'bg-success' }} px-3 py-2">
                {{ ucfirst($tour['type']) }}
            </span>
        </div>
    </div>

    {{-- Tour Details --}}
    <div class="card-body d-flex flex-column">
        <h5 class="card-title fw-bold mb-2" style="min-height: 3rem;">
            {{ $tour['title'] }}
        </h5>

        <div class="d-flex align-items-start text-muted small mb-3" style="min-height: 2.5rem;">
            <i class="bi bi-geo-alt me-1 flex-shrink-0"></i>
            <span>{{ $tour['location'] }}</span>
        </div>

        <div class="d-flex justify-content-between align-items-center mb-3 mt-auto">
            <div class="d-flex align-items-center text-muted small">
                <i class="bi bi-clock me-1"></i>
                <span>{{ $tour['duration'] }}</span>
            </div>

            <div class="text-end">
                <small class="text-muted d-block">From</small>
                <h4 class="text-primary fw-bold mb-0">
                    ${{ number_format($tour['price']) }}
                </h4>
            </div>
        </div>

        <a href="{{ route('tours.show', $tour['slug']) }}" class="btn btn-primary w-100">
            View Details
        </a>
    </div>
</div>
