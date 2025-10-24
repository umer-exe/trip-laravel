{{-- Contact Page --}}
@extends('layouts.app')

@section('content')

    {{-- Page Header --}}
    <section class="bg-primary-gradient text-white py-5">
        <div class="container">
            <h1 class="display-4 fw-bold mb-3">Get In Touch</h1>
            <p class="lead">We're here to help plan your perfect journey</p>
        </div>
    </section>

    {{-- Contact Section --}}
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row g-4">
                {{-- Contact Form --}}
                <div class="col-lg-7">
                    <div class="card border-0 shadow-lg">
                        <div class="card-body p-4 p-lg-5">
                            <h2 class="h3 fw-bold mb-4">Send Us a Message</h2>
                            <form action="#" method="POST">
                                <div class="row g-3 mb-3">
                                    <div class="col-md-6">
                                        <label for="first_name" class="form-label fw-semibold">First Name *</label>
                                        <input type="text" class="form-control" id="first_name" placeholder="John" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="last_name" class="form-label fw-semibold">Last Name *</label>
                                        <input type="text" class="form-control" id="last_name" placeholder="Doe" required>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="email" class="form-label fw-semibold">Email Address *</label>
                                    <input type="email" class="form-control" id="email" placeholder="john.doe@example.com" required>
                                </div>

                                <div class="mb-3">
                                    <label for="phone" class="form-label fw-semibold">Phone Number *</label>
                                    <input type="tel" class="form-control" id="phone" placeholder="+92 300 1234567" required>
                                </div>

                                <div class="mb-3">
                                    <label for="subject" class="form-label fw-semibold">Subject *</label>
                                    <select class="form-select" id="subject" required>
                                        <option value="">Select a subject</option>
                                        <option value="booking">Tour Booking Inquiry</option>
                                        <option value="custom">Custom Tour Request</option>
                                        <option value="general">General Information</option>
                                        <option value="feedback">Feedback</option>
                                        <option value="other">Other</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="message" class="form-label fw-semibold">Message *</label>
                                    <textarea class="form-control" id="message" rows="6" placeholder="Tell us about your travel plans..." required></textarea>
                                </div>

                                <button type="submit" class="btn btn-primary w-100 py-3 fw-semibold">
                                    Send Message
                                </button>

                                <p class="text-muted text-center small mt-3 mb-0">
                                    <i class="bi bi-info-circle"></i> Form submission will be functional in Phase 2
                                </p>
                            </form>
                        </div>
                    </div>
                </div>

                {{-- Contact Information --}}
                <div class="col-lg-5">
                    <div class="mb-4">
                        {{-- Office Info Card --}}
                        <div class="card border-0 shadow-lg mb-4">
                            <div class="card-body p-4">
                                <h2 class="h4 fw-bold mb-4">Contact Information</h2>

                                <div class="d-flex mb-4">
                                    <div class="bg-primary bg-opacity-10 rounded p-3 me-3">
                                        <i class="bi bi-geo-alt-fill text-primary fs-4"></i>
                                    </div>
                                    <div>
                                        <h5 class="fw-semibold mb-1">Office Address</h5>
                                        <p class="text-muted mb-0 small">{{ $contactInfo['address'] }}</p>
                                    </div>
                                </div>

                                <div class="d-flex mb-4">
                                    <div class="bg-primary bg-opacity-10 rounded p-3 me-3">
                                        <i class="bi bi-telephone-fill text-primary fs-4"></i>
                                    </div>
                                    <div>
                                        <h5 class="fw-semibold mb-1">Phone</h5>
                                        <a href="tel:{{ $contactInfo['phone'] }}" class="text-primary text-decoration-none">
                                            {{ $contactInfo['phone'] }}
                                        </a>
                                    </div>
                                </div>

                                <div class="d-flex mb-4">
                                    <div class="bg-success bg-opacity-10 rounded p-3 me-3">
                                        <i class="bi bi-whatsapp text-success fs-4"></i>
                                    </div>
                                    <div>
                                        <h5 class="fw-semibold mb-1">WhatsApp</h5>
                                        <a href="https://wa.me/{{ str_replace(['+', '-', ' '], '', $contactInfo['whatsapp']) }}" class="text-success text-decoration-none">
                                            {{ $contactInfo['whatsapp'] }}
                                        </a>
                                    </div>
                                </div>

                                <div class="d-flex mb-4">
                                    <div class="bg-primary bg-opacity-10 rounded p-3 me-3">
                                        <i class="bi bi-envelope-fill text-primary fs-4"></i>
                                    </div>
                                    <div>
                                        <h5 class="fw-semibold mb-1">Email</h5>
                                        <a href="mailto:{{ $contactInfo['email'] }}" class="text-primary text-decoration-none">
                                            {{ $contactInfo['email'] }}
                                        </a>
                                    </div>
                                </div>

                                <div class="d-flex">
                                    <div class="bg-primary bg-opacity-10 rounded p-3 me-3">
                                        <i class="bi bi-clock-fill text-primary fs-4"></i>
                                    </div>
                                    <div>
                                        <h5 class="fw-semibold mb-1">Office Hours</h5>
                                        <p class="text-muted mb-0 small">{{ $contactInfo['hours'] }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Map Placeholder --}}
                        <div class="card border-0 shadow-lg overflow-hidden mb-4">
                            <div class="bg-primary bg-gradient d-flex align-items-center justify-content-center text-white" style="height: 250px;">
                                <div class="text-center">
                                    <i class="bi bi-map fs-1 mb-3 d-block opacity-75"></i>
                                    <p class="fs-5 fw-semibold mb-1">Interactive Map</p>
                                    <p class="small opacity-75">Coming in Phase 2</p>
                                </div>
                            </div>
                        </div>

                        {{-- Quick Links Card --}}
                        <div class="card border-0 shadow-lg bg-primary text-white">
                            <div class="card-body p-4">
                                <h4 class="fw-bold mb-3">Quick Links</h4>
                                <div class="d-flex flex-column gap-2">
                                    <a href="{{ route('tours.index') }}" class="text-white text-decoration-none">
                                        <i class="bi bi-arrow-right me-2"></i>Browse All Tours
                                    </a>
                                    <a href="{{ route('tours.index') }}?type=international" class="text-white text-decoration-none">
                                        <i class="bi bi-arrow-right me-2"></i>International Tours
                                    </a>
                                    <a href="{{ route('tours.index') }}?type=domestic" class="text-white text-decoration-none">
                                        <i class="bi bi-arrow-right me-2"></i>Domestic Tours
                                    </a>
                                    <a href="{{ route('home') }}" class="text-white text-decoration-none">
                                        <i class="bi bi-arrow-right me-2"></i>Back to Home
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- FAQ Section --}}
    <section class="py-5 bg-white">
        <div class="container" style="max-width: 800px;">
            <div class="text-center mb-5">
                <h2 class="display-6 fw-bold mb-3">Frequently Asked Questions</h2>
                <p class="lead text-muted">Find answers to common questions</p>
            </div>

            <div class="accordion" id="faqAccordion">
                <div class="accordion-item border mb-3">
                    <h3 class="accordion-header">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                            How do I book a tour?
                        </button>
                    </h3>
                    <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            You can book a tour by filling out the enquiry form on any tour detail page, calling us directly, or sending us a WhatsApp message. Our team will get back to you within 24 hours.
                        </div>
                    </div>
                </div>

                <div class="accordion-item border mb-3">
                    <h3 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                            What is included in the tour price?
                        </button>
                    </h3>
                    <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            Tour prices typically include accommodation, transportation, guided tours, and some meals. Specific inclusions vary by tour and are detailed on each tour page.
                        </div>
                    </div>
                </div>

                <div class="accordion-item border mb-3">
                    <h3 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                            Can I customize a tour?
                        </button>
                    </h3>
                    <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            Absolutely! We offer custom tour packages tailored to your preferences. Contact us with your requirements, and we'll create a personalized itinerary for you.
                        </div>
                    </div>
                </div>

                <div class="accordion-item border">
                    <h3 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq4">
                            What is your cancellation policy?
                        </button>
                    </h3>
                    <div id="faq4" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            Our cancellation policy varies depending on the tour and booking date. Generally, cancellations made 30+ days before departure receive a full refund minus processing fees. Contact us for specific details.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
