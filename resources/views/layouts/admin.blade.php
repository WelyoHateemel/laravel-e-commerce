
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Admin Dashboard') - {{ config('app.name', 'Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')
</head>

<body class="font-sans antialiased bg-[#f0f4f5] text-gray-800">

    <div class="flex h-screen overflow-hidden">

        <div id="sidebar-overlay"
             class="fixed inset-0 bg-black/50 z-40 hidden lg:hidden"></div>

        <aside id="sidebar"
               class="fixed inset-y-0 left-0 z-50 w-48 bg-[#075985] text-white flex flex-col transform -translate-x-full transition-transform duration-300 lg:translate-x-0">

            <div class="h-[52px] px-4 flex items-center gap-2 border-b border-white/10 bg-[#0872a5]">
                <div class="w-8 h-8 shrink-0 rounded-full bg-white flex items-center justify-center overflow-hidden">
                    <img src="{{ asset('assets/images/logo-w.png') }}"
                         alt="Logo"
                         class="w-full h-full object-contain">
                </div>

                <span class="text-[11px] font-bold leading-tight">
                    {{ config('app.name', 'E-Commerce Admin') }}
                </span>

                <button id="close-sidebar"
                        type="button"
                        class="ml-auto lg:hidden"
                        aria-label="Tutup sidebar">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <nav class="flex-1 overflow-y-auto px-2 py-5 text-sm">

                <a href="{{ url('/admin') }}"
                   class="nav-link flex items-center gap-3 px-3 py-3 rounded-md hover:bg-[#0369a1] transition">
                    <i class="fa-solid fa-gauge-high w-4 text-center"></i>
                    <span>Dashboard</span>
                </a>

                <p class="text-[10px] font-semibold uppercase tracking-wide text-sky-200 mt-5 mb-2 px-2">
                    Management
                </p>

                <a href="{{ url('/admin/products') }}"
                   class="nav-link flex items-center gap-3 px-3 py-3 rounded-md hover:bg-[#0369a1] transition">
                    <i class="fa-solid fa-box w-4 text-center"></i>
                    <span>Products</span>
                </a>

                <a href="{{ url('/admin/categories') }}"
                   class="nav-link flex items-center gap-3 px-3 py-3 rounded-md hover:bg-[#0369a1] transition">
                    <i class="fa-solid fa-layer-group w-4 text-center"></i>
                    <span>Categories</span>
                </a>

                <a href="{{ route('admin.brands') }}"
                   class="nav-link flex items-center gap-3 px-3 py-3 rounded-md hover:bg-[#0369a1] transition">
                    <i class="fa-solid fa-tags w-4 text-center"></i>
                    <span>Brands</span>
                </a>

                <a href="{{ url('admin.orders') }}"
                   class="nav-link flex items-center gap-3 px-3 py-3 rounded-md hover:bg-[#0369a1] transition">
                    <i class="fa-solid fa-cart-shopping w-4 text-center"></i>
                    <span>Orders</span>
                </a>

                <a href="{{ url('admin.customers') }}"
                   class="nav-link flex items-center gap-3 px-3 py-3 rounded-md hover:bg-[#0369a1] transition">
                    <i class="fa-solid fa-users w-4 text-center"></i>
                    <span>Customers</span>
                </a>

                <a href="{{ url('/admin/reviews') }}"
                   class="nav-link flex items-center gap-3 px-3 py-3 rounded-md hover:bg-[#0369a1] transition">
                    <i class="fa-regular fa-star w-4 text-center"></i>
                    <span>Reviews</span>
                </a>

                <p class="text-[10px] font-semibold uppercase tracking-wide text-sky-200 mt-5 mb-2 px-2">
                    Settings
                </p>

                <a href="{{ url('/admin/settings') }}"
                   class="nav-link flex items-center gap-3 px-3 py-3 rounded-md hover:bg-[#0369a1] transition">
                    <i class="fa-solid fa-gear w-4 text-center"></i>
                    <span>General Settings</span>
                </a>

            </nav>

            <div class="border-t border-white/10 p-2">
                <form id="logout-form" method="POST" action="{{ ('logout') }}">
                    @csrf

                    <button type="submit"
                            class="w-full flex items-center gap-3 px-3 py-3 text-sm rounded-md hover:bg-red-600 transition">
                        <i class="fa-solid fa-right-from-bracket w-4 text-center"></i>
                        <span>Logout</span>
                    </button>
                </form>
            </div>

        </aside>

        <div class="flex-1 min-w-0 flex flex-col overflow-hidden lg:ml-48">

            <header class="h-[52px] shrink-0 bg-white flex items-center justify-between px-4 md:px-6 shadow-sm z-30">

                <div class="flex items-center gap-3 flex-1">

                    <button id="open-sidebar"
                            type="button"
                            class="lg:hidden text-gray-500"
                            aria-label="Buka sidebar">
                        <i class="fa-solid fa-bars text-xl"></i>
                    </button>

                    <div class="hidden sm:flex items-center bg-[#f0f2f4] rounded-md px-3 py-2 w-full max-w-[310px]">
                        <i class="fa-solid fa-magnifying-glass text-gray-400 text-sm"></i>

                        <input type="text"
                               placeholder="Search categories..."
                               class="bg-transparent border-0 outline-none focus:ring-0 ml-2 text-xs w-full">
                    </div>

                </div>

                <div class="flex items-center gap-4 md:gap-6 ml-3">

                    <button type="button"
                            class="relative text-gray-500 hover:text-sky-700"
                            aria-label="Notifikasi">
                        <i class="fa-regular fa-bell text-lg"></i>
                    </button>

                    <div class="flex items-center gap-2">
                        <div class="text-right">
                            <p class="text-xs font-semibold text-gray-800">
                                {{ Auth::user()->name ?? 'Admin User' }}
                            </p>

                            <p class="text-[10px] text-gray-500">
                                Super Admin
                            </p>
                        </div>

                        <img src="{{ asset('assets/images/iyawak.jpg') }}"
                             alt="Admin Profile"
                             class="w-8 h-8 rounded-full object-cover">
                    </div>

                </div>

            </header>

            <main class="flex-1 overflow-y-auto bg-[#f0f4f5]">

                <div class="px-4 py-2">
                    <h1 class="text-sm font-medium text-gray-800">
                        @yield('page-heading', 'Admin Dashboard')
                    </h1>
                </div>

                @if (session('success'))
                    <div class="mx-4 mb-4 rounded-md bg-green-100 border border-green-200 text-green-800 px-4 py-3 text-sm">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="mx-4 mb-4 rounded-md bg-red-100 border border-red-200 text-red-800 px-4 py-3 text-sm">
                        {{ session('error') }}
                    </div>
                @endif

                @yield('content')

            </main>

        </div>

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            const openButton = document.getElementById('open-sidebar');
            const closeButton = document.getElementById('close-sidebar');

            function openSidebar() {
                sidebar.classList.remove('-translate-x-full');
                overlay.classList.remove('hidden');
            }

            function closeSidebar() {
                sidebar.classList.add('-translate-x-full');
                overlay.classList.add('hidden');
            }

            if (openButton) {
                openButton.addEventListener('click', openSidebar);
            }

            if (closeButton) {
                closeButton.addEventListener('click', closeSidebar);
            }

            overlay.addEventListener('click', closeSidebar);

            document.addEventListener('keydown', function (event) {
                if (event.key === 'Escape') {
                    closeSidebar();
                }
            });

            const currentPath = window.location.pathname.replace(/\/+$/, '') || '/';

            document.querySelectorAll('.nav-link').forEach(function (link) {
                const linkPath = new URL(link.href).pathname.replace(/\/+$/, '') || '/';

                if (currentPath === linkPath) {
                    link.classList.add('bg-[#0369a1]', 'font-semibold');
                }
            });
        });
    </script>

    @stack('scripts')

</body>
</html>
