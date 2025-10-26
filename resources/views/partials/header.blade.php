{{--
    Header Navigation Component
    Responsive header with logo, navigation links, and mobile menu
--}}

<header class="bg-white shadow-sm sticky top-0 z-50">
    <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            {{-- Logo --}}
            <div class="flex-shrink-0">
                <a href="{{ route('home') }}" class="flex items-center space-x-2">
                    <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="text-xl font-bold text-gray-900">Atlas Tours</span>
                </a>
            </div>

            {{-- Desktop Navigation --}}
            <div class="hidden md:flex md:items-center md:space-x-8">
                <a href="{{ route('home') }}" class="text-gray-700 hover:text-indigo-600 px-3 py-2 text-sm font-medium transition {{ request()->routeIs('home') ? 'text-indigo-600 border-b-2 border-indigo-600' : '' }}">
                    Home
                </a>
                <a href="{{ route('tours.index') }}" class="text-gray-700 hover:text-indigo-600 px-3 py-2 text-sm font-medium transition {{ request()->routeIs('tours.*') ? 'text-indigo-600 border-b-2 border-indigo-600' : '' }}">
                    Tours
                </a>
                <a href="{{ route('contact') }}" class="text-gray-700 hover:text-indigo-600 px-3 py-2 text-sm font-medium transition {{ request()->routeIs('contact') ? 'text-indigo-600 border-b-2 border-indigo-600' : '' }}">
                    Contact
                </a>
                
                {{-- Cart Link with Count --}}
                <a href="{{ route('shoppingcart.index') }}" class="relative text-gray-700 hover:text-indigo-600 px-3 py-2 text-sm font-medium transition {{ request()->routeIs('shoppingcart.*') ? 'text-indigo-600 border-b-2 border-indigo-600' : '' }}">
                    <svg class="w-5 h-5 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5M7 13l2.5 5m6-5v6a2 2 0 01-2 2H9a2 2 0 01-2-2v-6m8 0V9a2 2 0 00-2-2H9a2 2 0 00-2 2v4.01"></path>
                    </svg>
                    Cart
                    @php
                        $cartCount = collect(session('cart', []))->sum('quantity');
                    @endphp
                    @if($cartCount > 0)
                        <span class="absolute -top-1 -right-1 bg-indigo-600 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center font-semibold">
                            {{ $cartCount }}
                        </span>
                    @endif
                </a>
            </div>

            {{-- Mobile menu button --}}
            <div class="md:hidden">
                <button type="button" id="mobile-menu-button" class="text-gray-700 hover:text-indigo-600 focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </div>

        {{-- Mobile Navigation Menu --}}
        <div id="mobile-menu" class="hidden md:hidden pb-4">
            <a href="{{ route('home') }}" class="block text-gray-700 hover:text-indigo-600 hover:bg-gray-50 px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('home') ? 'text-indigo-600 bg-indigo-50' : '' }}">
                Home
            </a>
            <a href="{{ route('tours.index') }}" class="block text-gray-700 hover:text-indigo-600 hover:bg-gray-50 px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('tours.*') ? 'text-indigo-600 bg-indigo-50' : '' }}">
                Tours
            </a>
            <a href="{{ route('contact') }}" class="block text-gray-700 hover:text-indigo-600 hover:bg-gray-50 px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('contact') ? 'text-indigo-600 bg-indigo-50' : '' }}">
                Contact
            </a>
            <a href="{{ route('shoppingcart.index') }}" class="block text-gray-700 hover:text-indigo-600 hover:bg-gray-50 px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('shoppingcart.*') ? 'text-indigo-600 bg-indigo-50' : '' }}">
                <div class="flex items-center justify-between">
                    <span>Cart</span>
                    @php
                        $cartCount = collect(session('cart', []))->sum('quantity');
                    @endphp
                    @if($cartCount > 0)
                        <span class="bg-indigo-600 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center font-semibold">
                            {{ $cartCount }}
                        </span>
                    @endif
                </div>
            </a>
        </div>
    </nav>
</header>

{{-- Mobile menu toggle script --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const menuButton = document.getElementById('mobile-menu-button');
        const mobileMenu = document.getElementById('mobile-menu');

        if (menuButton && mobileMenu) {
            menuButton.addEventListener('click', function() {
                mobileMenu.classList.toggle('hidden');
            });
        }
    });
</script>
