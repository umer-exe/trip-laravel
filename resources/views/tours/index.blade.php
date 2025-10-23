{{-- Tours Index Page - Displays all tours with filters --}}
@extends('layouts.app')

@section('content')

    {{-- Page Header --}}
    <section class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Explore Our Tours</h1>
            <p class="text-xl text-indigo-100">
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
    <section class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- Results Count --}}
            <div class="mb-6">
                <p class="text-gray-600">
                    Showing <span class="font-semibold">{{ count($tours) }}</span>
                    {{ $filterType === 'all' ? '' : $filterType }}
                    {{ count($tours) === 1 ? 'tour' : 'tours' }}
                </p>
            </div>

            @if(count($tours) > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($tours as $tour)
                        @include('partials.tour-card', ['tour' => $tour])
                    @endforeach
                </div>
            @else
                {{-- No Tours Found --}}
                <div class="text-center py-16">
                    <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">No tours found</h3>
                    <p class="text-gray-600 mb-6">Try adjusting your filters or browse all tours</p>
                    <a href="{{ route('tours.index') }}" class="inline-block bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700 transition">
                        View All Tours
                    </a>
                </div>
            @endif
        </div>
    </section>

    {{-- Contact CTA --}}
    @include('partials.contact-strip')

@endsection
