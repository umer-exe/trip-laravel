{{-- Tours Index Page - Displays all tours with filters --}}
@extends('layouts.app')

@section('content')

    {{-- Page Header --}}
    <section class="bg-primary-gradient text-white py-5">
        <div class="container">
            <h1 class="display-4 fw-bold mb-3">Explore Our Tours</h1>
            <p class="lead">
                @if($filterType === 'international')
                    Discover amazing international destinations around the world
                @elseif($filterType === 'domestic')
                    Explore the beauty of Pakistan with our domestic tours
                @else
                    Browse our complete collection of travel packages
                @endif
            </p>
        </div>
    </section>

    {{-- Filter Bar --}}
    @include('partials.filter-bar', ['filterType' => $filterType])

    {{-- Tours Grid --}}
    <section class="py-5 bg-light">
        <div class="container">
            {{-- Results Count --}}
            <div class="mb-4">
                <p class="text-muted">
                    Showing <span class="fw-semibold">{{ count($tours) }}</span>
                    {{ $filterType === 'all' ? '' : $filterType }}
                    {{ count($tours) === 1 ? 'tour' : 'tours' }}
                </p>
            </div>

            @if(count($tours) > 0)
                <div class="row g-4">
                    @foreach($tours as $tour)
                        <div class="col-12 col-md-6 col-lg-4">
                            @include('partials.tour-card', ['tour' => $tour])
                        </div>
                    @endforeach
                </div>
            @else
                {{-- No Tours Found --}}
                <div class="text-center py-5">
                    <i class="bi bi-emoji-frown fs-1 text-muted mb-3 d-block"></i>
                    <h3 class="fw-semibold mb-2">No tours found</h3>
                    <p class="text-muted mb-4">Try adjusting your filters or browse all tours</p>
                    <a href="{{ route('tours.index') }}" class="btn btn-primary">
                        View All Tours
                    </a>
                </div>
            @endif
        </div>
    </section>

    {{-- Contact CTA --}}
    @include('partials.contact-strip')

@endsection
