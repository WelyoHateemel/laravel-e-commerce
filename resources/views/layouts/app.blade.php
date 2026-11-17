
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans text-gray-600 antialiased">

<header class="hidden lg:block bg-white shadow-sm sticky top-0 z-50">
    <div class="container mx-auto px-4 py-4">
        <div class="flex justify-between items-center">

            <div class="w-1/4">
                <a href="{{ url('/') }}">
                    <img src="{{ asset('assets/images/logo.png') }}" alt="Logo" class="max-w-[200px]">
                </a>
            </div>

            <div class="w-1/2 flex justify-center">
                <nav>
                    <ul class="flex space-x-8 font-medium text-gray-700">
                        <li><a href="{{ url('/') }}" class="hover:text-primary transition">Home</a></li>
                        <li><a href="{{ url('/shop') }}" class="hover:text-primary transition">Shop</a></li>
                        <li><a href="{{ url('/cart') }}" class="hover:text-primary transition">Cart</a></li>
                        <li><a href="{{ url('/wishlist') }}" class="hover:text-primary transition">Wishlist</a></li>
                        <li><a href="{{ url('/contact') }}" class="hover:text-primary transition">Contact</a></li>
                    </ul>
                </nav>
            </div>

            <div class="w-1/4 flex justify-end items-center space-x-6">

                <div class="relative group">
                    <button type="button" class="text-2xl hover:text-primary" aria-label="Search">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </button>

                    <div class="absolute right-0 mt-2 w-64 bg-white border shadow-lg p-3 rounded opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-50">
                        <form action="{{ url('/shop') }}" method="GET" class="flex">
                            <input
                                type="text"
                                name="q"
                                value="{{ request('q') }}"
                                placeholder="Search..."
                                class="w-full border p-2 text-sm outline-none focus:border-primary"
                            >
                            <button type="submit" class="p-2 text-primary" aria-label="Submit search">
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </button>
                        </form>
                    </div>
                </div>

                <a href="{{ url('/wishlist') }}" class="text-2xl hover:text-primary" aria-label="Wishlist">
                    <i class="fa-regular fa-heart"></i>
                </a>

                <a href="{{ url('/cart') }}" class="text-2xl hover:text-primary relative" aria-label="Cart">
                    <i class="fa-solid fa-bag-shopping"></i>
                </a>

                <div class="relative group">
                    <button type="button" class="flex items-center justify-center text-xl hover:text-primary focus:outline-none" aria-label="Account">
                        @auth
                            <span class="flex items-center justify-center w-10 h-10 bg-blue-600 text-white rounded-full font-bold uppercase text-lg shadow-sm">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </span>
                        @else
                            <i class="fa-regular fa-user"></i>
                        @endauth
                    </button>

                    <ul class="absolute right-0 mt-2 w-44 bg-white border shadow-lg py-2 rounded opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-50">
                        @guest
                            <li>
                                <a href="{{ route('login') }}" class="block px-4 py-2 hover:bg-gray-100 text-sm">
                                    Sign In
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('register') }}" class="block px-4 py-2 hover:bg-gray-100 text-sm">
                                    Sign Up
                                </a>
                            </li>
                        @else
                            <li>
                                @if (isset(Auth::user()->utype) && Auth::user()->utype === 'ADM')
                                    <a href="{{ Route::has('admin.index') ? route('admin.index') : url('/admin') }}" class="block px-4 py-2 hover:bg-gray-100 text-sm">
                                        My Account
                                    </a>
                                @else
                                    <a href="{{ Route::has('users.index') ? route('users.index') : url('/account') }}" class="block px-4 py-2 hover:bg-gray-100 text-sm">
                                        My Account
                                    </a>
                                @endif
                            </li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 hover:bg-gray-100 text-sm">
                                        Sign Out
                                    </button>
                                </form>
                            </li>
                        @endguest
                    </ul>
                </div>

            </div>
        </div>
    </div>
</header>

<header class="lg:hidden bg-white shadow-sm sticky top-0 z-50">
    <div class="container mx-auto px-4 py-4">

        <div class="flex justify-between items-center mb-4">
            <button id="mobile-menu-btn" type="button" class="text-2xl focus:outline-none" aria-label="Open menu">
                <i class="fa-solid fa-bars"></i>
            </button>

            <a href="{{ url('/') }}">
                <img src="{{ asset('assets/images/logo.png') }}" alt="Logo" class="max-w-[120px]">
            </a>

            <div class="flex items-center space-x-5">
                <a href="{{ url('/wishlist') }}" class="text-xl hover:text-primary" aria-label="Wishlist">
                    <i class="fa-regular fa-heart"></i>
                </a>

                <a href="{{ url('/cart') }}" class="text-xl hover:text-primary relative" aria-label="Cart">
                    <i class="fa-solid fa-bag-shopping"></i>
                </a>

                <div class="relative">
                    <button id="mobile-avatar-button" type="button" class="flex items-center justify-center text-xl hover:text-primary focus:outline-none" aria-label="Account">
                        @auth
                            <span class="flex items-center justify-center w-8 h-8 bg-blue-600 text-white rounded-full font-bold uppercase text-sm">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </span>
                        @else
                            <i class="fa-regular fa-user"></i>
                        @endauth
                    </button>

                    <ul id="avatar-submenu-mobile" class="absolute right-0 mt-3 w-44 bg-white border border-gray-100 shadow-xl py-2 rounded-lg hidden z-[100]">
                        @guest
                            <li>
                                <a href="{{ route('login') }}" class="block px-4 py-2 hover:bg-gray-100 text-sm text-gray-700">
                                    Sign In
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('register') }}" class="block px-4 py-2 hover:bg-gray-100 text-sm text-gray-700">
                                    Sign Up
                                </a>
                            </li>
                        @else
                            <li>
                                @if (isset(Auth::user()->utype) && Auth::user()->utype === 'ADM')
                                    <a href="{{ Route::has('admin.index') ? route('admin.index') : url('/admin') }}" class="block px-4 py-2 hover:bg-gray-100 text-sm text-gray-700">
                                        My Account
                                    </a>
                                @else
                                    <a href="{{ Route::has('users.index') ? route('users.index') : url('/account') }}" class="block px-4 py-2 hover:bg-gray-100 text-sm text-gray-700">
                                        My Account
                                    </a>
                                @endif
                            </li>
                            <li class="border-t border-gray-100 mt-1">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 hover:bg-gray-100 text-sm text-gray-700">
                                        Sign Out
                                    </button>
                                </form>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </div>

        <div class="pb-2">
            <form action="{{ url('/shop') }}" method="GET" class="relative">
                <input
                    type="text"
                    name="q"
                    value="{{ request('q') }}"
                    placeholder="Search for products..."
                    class="w-full bg-gray-100 border-none px-4 py-2.5 rounded-lg text-sm focus:ring-2 focus:ring-primary focus:bg-white transition-all outline-none"
                >
                <button type="submit" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-primary" aria-label="Search">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>
            </form>
        </div>

    </div>
</header>

<div id="mobile-sidebar" class="fixed inset-y-0 left-0 w-64 bg-white shadow-2xl transform -translate-x-full transition-transform duration-300 z-[60]">
    <div class="p-4 flex justify-between items-center border-b">
        <span class="font-bold text-lg">Menu</span>
        <button id="close-menu-btn" type="button" class="text-xl" aria-label="Close menu">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>

    <nav class="p-4">
        <ul class="space-y-4">
            <li><a href="{{ url('/') }}" class="block hover:text-primary">Home</a></li>
            <li><a href="{{ url('/shop') }}" class="block hover:text-primary">Shop</a></li>
            <li><a href="{{ url('/cart') }}" class="block hover:text-primary">Cart</a></li>
            <li><a href="{{ url('/wishlist') }}" class="block hover:text-primary">Wishlist</a></li>
            <li><a href="{{ url('/contact') }}" class="block hover:text-primary">Contact</a></li>
        </ul>
    </nav>
</div>

<div id="menu-overlay" class="fixed inset-0 bg-black bg-opacity-50 hidden z-[55]"></div>

<main>
    {{ $slot }}
</main>

<footer class="bg-sky-800 text-gray-100 py-16">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">

            <div>
                <img src="{{ asset('assets/images/logo-w.png') }}" alt="Logo" class="mb-6 max-w-[200px]">

                <ul class="space-y-2 text-sm">
                    <li>ABC, Address Here, Country</li>
                    <li>Call Us: <a href="#" class="hover:text-primary transition">+000 000 0000</a></li>
                    <li>Email: <a href="#" class="hover:text-primary transition">info@example.com</a></li>
                </ul>

                <div class="flex space-x-4 mt-6">
                    <a href="#" class="w-8 h-8 rounded-full bg-gray-800 flex items-center justify-center hover:bg-primary transition" aria-label="Twitter">
                        <i class="fa-brands fa-twitter"></i>
                    </a>
                    <a href="#" class="w-8 h-8 rounded-full bg-gray-800 flex items-center justify-center hover:bg-primary transition" aria-label="Facebook">
                        <i class="fa-brands fa-facebook-f"></i>
                    </a>
                    <a href="#" class="w-8 h-8 rounded-full bg-gray-800 flex items-center justify-center hover:bg-primary transition" aria-label="Instagram">
                        <i class="fa-brands fa-instagram"></i>
                    </a>
                </div>
            </div>

            <div>
                <h4 class="text-white font-bold text-lg mb-6">Our Categories</h4>
                <ul class="space-y-2 text-sm">
                    <li><a href="{{ url('/shop') }}" class="hover:text-primary transition">Category 1</a></li>
                    <li><a href="{{ url('/shop') }}" class="hover:text-primary transition">Category 2</a></li>
                    <li><a href="{{ url('/shop') }}" class="hover:text-primary transition">Furniture</a></li>
                    <li><a href="{{ url('/shop') }}" class="hover:text-primary transition">Lighting</a></li>
                </ul>
            </div>

            <div>
                <h4 class="text-white font-bold text-lg mb-6">Information</h4>
                <ul class="space-y-2 text-sm">
                    <li><a href="{{ url('/about') }}" class="hover:text-primary transition">About Us</a></li>
                    <li><a href="{{ url('/shop') }}" class="hover:text-primary transition">How to Shop</a></li>
                    <li><a href="{{ url('/faq') }}" class="hover:text-primary transition">FAQ</a></li>
                    <li><a href="{{ url('/contact') }}" class="hover:text-primary transition">Contact Us</a></li>
                </ul>
            </div>

            <div>
                <h4 class="text-white font-bold text-lg mb-6">My Account</h4>
                <ul class="space-y-2 text-sm">
                    @guest
                        <li><a href="{{ route('login') }}" class="hover:text-primary transition">Sign In</a></li>
                        <li><a href="{{ route('register') }}" class="hover:text-primary transition">Create Account</a></li>
                    @else
                        <li>
                            @if (isset(Auth::user()->utype) && Auth::user()->utype === 'ADM')
                                <a href="{{ Route::has('admin.index') ? route('admin.index') : url('/admin') }}" class="hover:text-primary transition">My Account</a>
                            @else
                                <a href="{{ Route::has('users.index') ? route('users.index') : url('/account') }}" class="hover:text-primary transition">My Account</a>
                            @endif
                        </li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="hover:text-primary transition">Sign Out</button>
                            </form>
                        </li>
                    @endguest

                    <li><a href="{{ url('/cart') }}" class="hover:text-primary transition">View Cart</a></li>
                    <li><a href="{{ url('/wishlist') }}" class="hover:text-primary transition">My Wishlist</a></li>
                </ul>
            </div>

        </div>

        <div class="border-t border-gray-400 mt-12 pt-8 flex flex-col md:flex-row justify-between items-center">
            <p class="text-sm">&copy; {{ date('Y') }} All rights reserved.</p>
            <img src="{{ asset('assets/images/payment.png') }}" alt="Payment" class="mt-4 md:mt-0">
        </div>
    </div>
</footer>

<button id="back-to-top" type="button" class="fixed bottom-8 right-8 bg-primary text-white w-10 h-10 rounded shadow-lg hover:bg-blue-600 transition hidden items-center justify-center z-50" aria-label="Back to top">
    <i class="fa-solid fa-chevron-up text-xl"></i>
</button>

<script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const getElement = (id) => document.getElementById(id);
    const getAll = (selector) => document.querySelectorAll(selector);

    const sidebar = getElement('mobile-sidebar');
    const overlay = getElement('menu-overlay');
    const openMenuButton = getElement('mobile-menu-btn');
    const closeMenuButton = getElement('close-menu-btn');
    const avatarButton = getElement('mobile-avatar-button');
    const avatarMenu = getElement('avatar-submenu-mobile');

    function openSidebar() {
        if (!sidebar || !overlay) return;
        sidebar.classList.remove('-translate-x-full');
        overlay.classList.remove('hidden');
    }

    function closeSidebar() {
        if (!sidebar || !overlay) return;
        sidebar.classList.add('-translate-x-full');
        overlay.classList.add('hidden');
    }

    if (openMenuButton) {
        openMenuButton.addEventListener('click', openSidebar);
    }

    if (closeMenuButton) {
        closeMenuButton.addEventListener('click', closeSidebar);
    }

    if (overlay) {
        overlay.addEventListener('click', closeSidebar);
    }

    if (avatarButton && avatarMenu) {
        avatarButton.addEventListener('click', function (event) {
            event.stopPropagation();
            avatarMenu.classList.toggle('hidden');
        });

        avatarMenu.addEventListener('click', function (event) {
            event.stopPropagation();
        });

        document.addEventListener('click', function (event) {
            if (!avatarMenu.contains(event.target) && !avatarButton.contains(event.target)) {
                avatarMenu.classList.add('hidden');
            }
        });
    }

    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape') {
            closeSidebar();
            if (avatarMenu) avatarMenu.classList.add('hidden');
        }
    });

    const backToTopButton = getElement('back-to-top');

    if (backToTopButton) {
        window.addEventListener('scroll', function () {
            const visible = window.scrollY > 300;
            backToTopButton.classList.toggle('hidden', !visible);
            backToTopButton.classList.toggle('flex', visible);
        });

        backToTopButton.addEventListener('click', function () {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    }

    function initSwiper(selector, options) {
        if (typeof Swiper !== 'undefined' && document.querySelector(selector)) {
            return new Swiper(selector, options);
        }
        return null;
    }

    const productBreakpoints = {
        640: { slidesPerView: 2 },
        768: { slidesPerView: 3 },
        1024: { slidesPerView: 4 }
    };

    initSwiper('.main-slider', {
        loop: true,
        pagination: {
            el: '.main-slider .swiper-pagination',
            clickable: true
        },
        autoplay: {
            delay: 5000
        }
    });

    initSwiper('.category-slider', {
        slidesPerView: 2,
        spaceBetween: 20,
        loop: true,
        breakpoints: {
            ...productBreakpoints,
            1024: { slidesPerView: 6 }
        }
    });

    initSwiper('.brand-slider', {
        slidesPerView: 2,
        spaceBetween: 20,
        loop: true,
        breakpoints: {
            ...productBreakpoints,
            1024: { slidesPerView: 5 }
        }
    });

    initSwiper('.featured-slider', {
        slidesPerView: 1,
        spaceBetween: 20,
        navigation: {
            nextEl: '.feat-next',
            prevEl: '.feat-prev'
        },
        breakpoints: productBreakpoints
    });

    initSwiper('.related-slider', {
        slidesPerView: 1,
        spaceBetween: 20,
        navigation: {
            nextEl: '.related-next',
            prevEl: '.related-prev'
        },
        breakpoints: productBreakpoints
    });

    const galleryThumbs = initSwiper('.gallery-thumbs', {
        spaceBetween: 10,
        slidesPerView: 4,
        freeMode: true,
        watchSlidesProgress: true
    });

    initSwiper('.gallery-top', {
        spaceBetween: 10,
        navigation: {
            nextEl: '.gallery-top .swiper-button-next',
            prevEl: '.gallery-top .swiper-button-prev'
        },
        thumbs: galleryThumbs ? {
            swiper: galleryThumbs
        } : undefined
    });

    getAll('.tab-btn').forEach(function (button) {
        button.addEventListener('click', function () {
            getAll('.tab-btn').forEach(function (item) {
                item.classList.remove('active');
            });

            getAll('.tab-content').forEach(function (content) {
                content.classList.add('hidden');
            });

            button.classList.add('active');

            const targetId = button.getAttribute('data-target');
            const target = targetId ? getElement(targetId) : null;

            if (target) {
                target.classList.remove('hidden');
            }
        });
    });

    const countdownContainer = getElement('countdown-timer');

    if (countdownContainer) {
        const targetDate = new Date('2026-12-31T00:00:00').getTime();

        function updateCountdown() {
            const distance = targetDate - Date.now();

            if (distance <= 0) {
                countdownContainer.textContent = 'EXPIRED';
                return;
            }

            const timeMap = {
                days: Math.floor(distance / 86400000),
                hours: Math.floor((distance % 86400000) / 3600000),
                minutes: Math.floor((distance % 3600000) / 60000),
                seconds: Math.floor((distance % 60000) / 1000)
            };

            Object.keys(timeMap).forEach(function (unit) {
                const element = getElement(unit);

                if (element) {
                    element.textContent = String(timeMap[unit]).padStart(2, '0');
                }
            });
        }

        updateCountdown();
        const timerInterval = setInterval(updateCountdown, 1000);

        if (new Date(targetDate).getTime() <= Date.now()) {
            clearInterval(timerInterval);
        }
    }
});

function updateQty(amount) {
    const input = document.getElementById('qty-input');

    if (!input) return;

    const currentValue = parseInt(input.value, 10) || 1;
    input.value = Math.max(1, currentValue + amount);
}
</script>

</body>
</html>
