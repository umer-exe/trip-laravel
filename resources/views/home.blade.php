{{-- Home Page --}}
@extends('layouts.app')

@section('content')

    {{-- Hero Section --}}
    @include('partials.hero', [
        'title' => 'Discover Your Next Adventure',
        'subtitle' => 'Explore breathtaking destinations with our curated international and domestic tours'
    ])

    {{-- Featured Tours Section --}}
    <section class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Featured Tours</h2>
                <p class="text-lg text-gray-600">Handpicked adventures for unforgettable experiences</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($featuredTours as $tour)
                    @include('partials.tour-card', ['tour' => $tour])
                @endforeach
            </div>

            <div class="text-center mt-10">
                <a href="{{ route('tours.index') }}" class="inline-block bg-indigo-600 text-white px-8 py-3 rounded-lg hover:bg-indigo-700 transition font-semibold">
                    View All Tours
                </a>
            </div>
        </div>
    </section>

    {{-- Top Destinations Section --}}
    @include('partials.top-destinations')

    {{-- Testimonials Section --}}
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">What Our Travelers Say</h2>
                <p class="text-lg text-gray-600">Real experiences from real people</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @foreach($testimonials as $testimonial)
                    <div class="bg-gray-50 rounded-lg p-6 shadow-sm">
                        <div class="flex items-center mb-4">
                            <div class="w-12 h-12 rounded-full bg-gradient-to-br from-indigo-400 to-purple-500 flex items-center justify-center text-white font-bold text-lg">
                                {{ substr($testimonial['name'], 0, 1) }}
                            </div>
                            <div class="ml-3">
                                <h4 class="font-semibold text-gray-900">{{ $testimonial['name'] }}</h4>
                                <p class="text-sm text-gray-600">{{ $testimonial['location'] }}</p>
                            </div>
                        </div>

                        <div class="flex mb-3">
                            @for($i = 0; $i < $testimonial['rating']; $i++)
                                <svg class="w-5 h-5 text-yellow-400 fill-current" viewBox="0 0 24 24">
                                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                </svg>
                            @endfor
                        </div>

                        <p class="text-gray-700 italic">"{{ $testimonial['comment'] }}"</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Contact CTA Strip --}}
    @include('partials.contact-strip')

@endsection
