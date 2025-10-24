{{-- Home Page --}}
@extends('layouts.app')

@section('content')

    {{-- Hero Section --}}
    @include('partials.hero', [
        'title' => 'Discover Your Next Adventure',
        'subtitle' => 'Explore breathtaking destinations with our curated international and domestic tours'
    ])

    {{-- Featured Tours Section --}}
    <section class="py-5 bg-light">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="display-5 fw-bold mb-3">Featured Tours</h2>
                <p class="lead text-muted">Handpicked adventures for unforgettable experiences</p>
            </div>

            <div class="row g-4">
                @foreach($featuredTours as $tour)
                    <div class="col-12 col-md-6 col-lg-3">
                        @include('partials.tour-card', ['tour' => $tour])
                    </div>
                @endforeach
            </div>

            <div class="text-center mt-5">
                <a href="{{ route('tours.index') }}" class="btn btn-primary btn-lg px-5">
                    View All Tours
                </a>
            </div>
        </div>
    </section>

    {{-- Top Destinations Section --}}
    @include('partials.top-destinations')

    {{-- Testimonials Section --}}
    <section class="py-5 bg-white">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="display-5 fw-bold mb-3">What Our Travelers Say</h2>
                <p class="lead text-muted">Real experiences from real people</p>
            </div>

            <div class="row g-4">
                @foreach($testimonials as $testimonial)
                    <div class="col-12 col-md-4">
                        <div class="card bg-light border-0 h-100">
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="rounded-circle bg-primary bg-gradient text-white d-flex align-items-center justify-content-center fw-bold fs-5" style="width: 50px; height: 50px;">
                                        {{ substr($testimonial['name'], 0, 1) }}
                                    </div>
                                    <div class="ms-3">
                                        <h5 class="card-title mb-0">{{ $testimonial['name'] }}</h5>
                                        <p class="text-muted small mb-0">{{ $testimonial['location'] }}</p>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    @for($i = 0; $i < $testimonial['rating']; $i++)
                                        <i class="bi bi-star-fill text-warning"></i>
                                    @endfor
                                </div>

                                <p class="card-text fst-italic">"{{ $testimonial['comment'] }}"</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Contact CTA Strip --}}
    @include('partials.contact-strip')

@endsection
