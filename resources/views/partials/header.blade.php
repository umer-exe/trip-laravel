{{--
    Header Navigation Component
    Responsive header with logo, navigation links, and mobile menu
--}}

<header class="bg-white shadow-sm sticky-top">
    <nav class="navbar navbar-expand-md navbar-light bg-white">
        <div class="container-fluid">
            {{-- Logo --}}
            <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">
                <i class="bi bi-globe2 text-primary fs-3 me-2"></i>
                <span class="fw-bold">Atlas Tours</span>
            </a>

            {{-- Mobile menu toggle --}}
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            {{-- Desktop & Mobile Navigation --}}
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home') ? 'active text-primary fw-semibold' : '' }}" href="{{ route('home') }}">
                            Home
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('tours.*') ? 'active text-primary fw-semibold' : '' }}" href="{{ route('tours.index') }}">
                            Tours
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('contact') ? 'active text-primary fw-semibold' : '' }}" href="{{ route('contact') }}">
                            Contact
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>
