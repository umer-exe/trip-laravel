{{-- Tour Detail Page - Shows full tour information and itinerary --}}
@extends('layouts.app')

@section('content')

    {{-- Tour Hero Image --}}
    <section class="position-relative" style="height: 400px; background: linear-gradient(to right, #4f46e5, #7c3aed);">
        <div class="position-absolute top-0 start-0 w-100 h-100" style="background: rgba(0,0,0,0.4);"></div>
        <div class="position-relative h-100 d-flex align-items-end">
            <div class="container pb-5">
                <div class="mb-3">
                <span class="badge {{ $tour['type'] === 'international' ? 'bg-primary' : 'bg-success' }} px-3 py-2">
                    {{ ucfirst($tour['type']) }} Tour
                </span>
                </div>
                <h1 class="display-3 fw-bold text-white mb-3">{{ $tour['title'] }}</h1>
                <div class="d-flex flex-wrap gap-4 text-white">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-geo-alt me-2"></i>
                        <span>{{ $tour['location'] }}</span>
                    </div>
                    <div class="d-flex align-items-center">
                        <i class="bi bi-clock me-2"></i>
                        <span>{{ $tour['duration'] }}</span>
                    </div>
                    <div class="d-flex align-items-center">
                        <i class="bi bi-currency-dollar me-2"></i>
                        <span class="fs-4 fw-bold">${{ number_format($tour['price']) }}</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Tour Content --}}
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row g-4">
                {{-- Main Content --}}
                <div class="col-lg-8">
                    {{-- Overview --}}
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body p-4">
                            <h2 class="h3 fw-bold mb-3">Overview</h2>
                            <p class="text-muted">{{ $tour['overview'] }}</p>
                        </div>
                    </div>

                    {{-- Highlights --}}
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body p-4">
                            <h2 class="h3 fw-bold mb-4">Tour Highlights</h2>
                            <ul class="list-unstyled">
                                @foreach($tour['highlights'] as $highlight)
                                    <li class="d-flex mb-3">
                                        <i class="bi bi-check-circle-fill text-success me-3 fs-5 flex-shrink-0"></i>
                                        <span>{{ $highlight }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    {{-- Itinerary --}}
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body p-4">
                            <h2 class="h3 fw-bold mb-4">Detailed Itinerary</h2>
                            <div class="accordion" id="itineraryAccordion">
                                @foreach($tour['itinerary'] as $index => $item)
                                    <div class="accordion-item border-start border-4 border-primary mb-3">
                                        <h3 class="accordion-header">
                                            <button class="accordion-button {{ $index > 0 ? 'collapsed' : '' }}" type="button" data-bs-toggle="collapse" data-bs-target="#day{{ $item['day'] }}">
                                                <span class="badge bg-primary me-3">Day {{ $item['day'] }}</span>
                                                <span class="fw-semibold">{{ $item['title'] }}</span>
                                            </button>
                                        </h3>
                                        <div id="day{{ $item['day'] }}" class="accordion-collapse collapse {{ $index === 0 ? 'show' : '' }}" data-bs-parent="#itineraryAccordion">
                                            <div class="accordion-body">
                                                {{ $item['description'] }}
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    {{-- Gallery --}}
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-4">
                            <h2 class="h3 fw-bold mb-4">Photo Gallery</h2>
                            <div class="row g-3">
                                @foreach($tour['gallery'] as $index => $image)
                                    <div class="col-6">
                                        <div class="ratio ratio-4x3 rounded overflow-hidden">
                                            <img src="{{ $image }}" alt="{{ $tour['title'] }} Gallery {{ $index + 1 }}" class="w-100 h-100" style="object-fit: cover; transition: transform 0.3s;">
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Sidebar --}}
                <div class="col-lg-4">
                    {{-- Booking Card --}}
                    <div class="card border-0 shadow-lg sticky-top" style="top: 80px;">
                        <div class="card-body p-4">
                            <div class="text-center mb-4">
                                <p class="text-muted small mb-2">Starting from</p>
                                <h3 class="display-5 text-primary fw-bold mb-0">${{ number_format($tour['price']) }}</h3>
                                <p class="text-muted small">per person</p>
                            </div>

                            <form action="#" method="POST">
                                <div class="mb-3">
                                    <label class="form-label small fw-semibold">Full Name</label>
                                    <input type="text" class="form-control" placeholder="John Doe" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label small fw-semibold">Email</label>
                                    <input type="email" class="form-control" placeholder="john@example.com" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label small fw-semibold">Phone</label>
                                    <input type="tel" class="form-control" placeholder="+92 300 1234567" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label small fw-semibold">Number of Travelers</label>
                                    <input type="number" class="form-control" min="1" value="1">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label small fw-semibold">Preferred Date</label>
                                    <input type="date" class="form-control">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label small fw-semibold">Message (Optional)</label>
                                    <textarea class="form-control" rows="3" placeholder="Any special requests?"></textarea>
                                </div>

                                <button type="submit" class="btn btn-primary w-100 py-3 fw-semibold">
                                    Send Enquiry
                                </button>
                            </form>

                            <p class="text-muted text-center small mt-3 mb-0">
                                <i class="bi bi-info-circle"></i> Form submission will be functional in Phase 2
                            </p>

                            <hr class="my-4">

                            <div>
                                <h5 class="fw-semibold mb-3">Need Help?</h5>
                                <div class="d-flex flex-column gap-2 small">
                                    <a href="tel:+922135205678" class="text-decoration-none text-dark d-flex align-items-center">
                                        <i class="bi bi-telephone-fill text-primary me-2"></i>
                                        +92-21-35205678
                                    </a>
                                    <a href="https://wa.me/923001234567" class="text-decoration-none text-success d-flex align-items-center">
                                        <i class="bi bi-whatsapp me-2"></i>
                                        WhatsApp Us
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
