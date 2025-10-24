{{--
    Footer Component
    Contains company information, quick links, and social media
--}}

<footer class="bg-dark text-light py-5">
    <div class="container">
        <div class="row g-4">
            {{-- Company Info --}}
            <div class="col-12 col-md-4">
                <div class="d-flex align-items-center mb-3">
                    <i class="bi bi-globe2 text-primary fs-3 me-2"></i>
                    <span class="fs-4 fw-bold">Atlas Tours</span>
                </div>
                <p class="small mb-3">Your trusted travel partner for domestic and international adventures. Creating unforgettable memories since 2020.</p>
                <div class="d-flex gap-3">
                    <a href="#" class="text-secondary text-decoration-none">
                        <i class="bi bi-facebook fs-4"></i>
                    </a>
                    <a href="#" class="text-secondary text-decoration-none">
                        <i class="bi bi-instagram fs-4"></i>
                    </a>
                    <a href="#" class="text-secondary text-decoration-none">
                        <i class="bi bi-twitter fs-4"></i>
                    </a>
                </div>
            </div>

            {{-- Quick Links --}}
            <div class="col-12 col-md-4">
                <h5 class="text-white fw-semibold mb-3">Quick Links</h5>
                <ul class="list-unstyled">
                    <li class="mb-2"><a href="{{ route('home') }}" class="text-light text-decoration-none">Home</a></li>
                    <li class="mb-2"><a href="{{ route('tours.index') }}" class="text-light text-decoration-none">All Tours</a></li>
                    <li class="mb-2"><a href="{{ route('contact') }}" class="text-light text-decoration-none">Contact Us</a></li>
                </ul>
            </div>

            {{-- Contact Info --}}
            <div class="col-12 col-md-4">
                <h5 class="text-white fw-semibold mb-3">Contact</h5>
                <ul class="list-unstyled small">
                    <li class="d-flex mb-2">
                        <i class="bi bi-geo-alt-fill me-2 text-primary"></i>
                        <span>Trade Tower, Karachi</span>
                    </li>
                    <li class="d-flex mb-2">
                        <i class="bi bi-telephone-fill me-2 text-primary"></i>
                        <span>+92-21-35205678</span>
                    </li>
                    <li class="d-flex mb-2">
                        <i class="bi bi-envelope-fill me-2 text-primary"></i>
                        <span>info@atlastours.pk</span>
                    </li>
                </ul>
            </div>
        </div>

        {{-- Bottom Bar --}}
        <div class="border-top border-secondary mt-4 pt-4 text-center small">
            <p class="mb-0">&copy; {{ date('Y') }} Atlas Tours & Travel. All rights reserved.</p>
        </div>
    </div>
</footer>
