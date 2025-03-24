<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Brayan - Servicio de Envíos</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="//unpkg.com/alpinejs" defer></script>
    <style>
        .nav-link {
            @apply flex flex-col items-center text-green-500 hover:text-yellow-500 transition-colors duration-200;
        }

        .nav-icon {
            @apply w-8 h-8 text-green-500 mb-1;
        }

        .nav-text {
            @apply text-sm font-semibold;
        }

        .user-menu-item {
            @apply block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors duration-200;
        }

        .mobile-nav-link {
            @apply block px-3 py-2 text-base font-medium text-green-500 hover:text-yellow-500 transition-colors duration-200;
        }
    </style>
</head>

<body class="font-sans bg-gray-100">

    <nav class="sticky top-0 z-50 border-b border-gray-200 shadow-sm bg-green-50">
        <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-24">
                <!-- Logo -->
                <div class="flex-shrink-0">
                    <a href="/" class="flex items-center">
                        <img src="{{ asset('img/logo.png') }}" alt="Brayan Brush Logo" class="h-20">
                    </a>
                </div>

                <!-- Mobile menu button -->
                <div class="flex md:hidden">
                    <button id="menu-toggle" class="text-green-500 hover:text-yellow-500 focus:outline-none">
                        <svg id="menu-icon" class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16m-7 6h7"></path>
                        </svg>
                    </button>
                </div>

                <!-- Main Navigation -->
                <div id="menu" class="hidden md:flex md:items-center md:space-x-8">
                    <a href="/"
                        class="flex items-center space-x-2 text-green-500 transition-colors duration-200 hover:text-yellow-500">
                        <x-mary-icon name="o-home" class="w-8 h-8 text-green-500" />
                        <span class="text-xl font-bold">INICIO</span>
                    </a>
                    <a href="/rastrea"
                        class="flex items-center space-x-2 text-green-500 transition-colors duration-200 hover:text-yellow-500">
                        <x-mary-icon name="o-eye" class="w-8 h-8 text-green-500" />
                        <span class="text-xl font-bold">RASTREA</span>
                    </a>
{{--                     <a href="/pay"
                        class="flex items-center space-x-2 text-green-500 transition-colors duration-200 hover:text-yellow-500">
                        <x-mary-icon name="o-currency-dollar" class="w-8 h-8 text-green-500" />
                        <span class="text-xl font-bold">PAGALO</span>
                    </a> --}}
                    <a href="/agencias"
                        class="flex items-center space-x-2 text-green-500 transition-colors duration-200 hover:text-yellow-500">
                        <x-mary-icon name="o-map-pin" class="w-8 h-8 text-green-500" />
                        <span class="text-xl font-bold">AGENCIAS</span>
                    </a>
                    <a href="/rates"
                        class="flex items-center space-x-2 text-green-500 transition-colors duration-200 hover:text-yellow-500">
                        <x-mary-icon name="m-banknotes" class="w-8 h-8 text-green-500" />
                        <span class="text-xl font-bold">TARIFAS</span>
                    </a>
                </div>

                <!-- User Actions -->
                <div class="flex items-center space-x-4">
                    <a href="#" class="text-green-500 transition-colors duration-200 hover:text-yellow-500">
                        <x-mary-icon name="s-shopping-cart" class="w-8 h-8 text-green-500" />
                    </a>
                    <div class="relative">
                        <a href="/login"
                            class="text-green-500 transition-colors duration-200 hover:text-yellow-500">
                            <x-mary-icon name="s-user" class="w-8 h-8 text-green-500" />
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mobile Navigation -->
        <div class="md:hidden">
            <div id="mobile-menu" class="hidden px-2 pt-2 pb-3 space-y-1">
                <a href="/" class="text-xl font-bold text-green-500 mobile-nav-link">INICIO</a>
                <a href="/track" class="text-xl font-bold text-green-500 mobile-nav-link">RASTREA</a>
                <a href="/pay" class="text-xl font-bold text-green-500 mobile-nav-link">PAGALO</a>
                <a href="/agencies" class="text-xl font-bold text-green-500 mobile-nav-link">AGENCIAS</a>
                <a href="/rates" class="text-xl font-bold text-green-500 mobile-nav-link">TARIFAS</a>
            </div>
        </div>
    </nav>
    <main class="min-h-screen bg-gray-50">
        <div class="container px-4 py-8 mx-auto max-w-7xl">
            <div class="flex flex-col gap-8 lg:flex-row">
                <!-- Sidebar Navigation -->
                <aside class="w-full lg:w-64 shrink-0">
                    <div class="overflow-hidden bg-white rounded-lg shadow">
                        <!-- Brand Header -->
                        <div class="p-4 border-b">
                            <h1 class="flex items-center text-xl font-semibold">
                                <a href="/nosotros" class="text-green-500 transition-colors duration-200 hover:text-blue-500">
                                    NOSOTROS
                                </a>
                            </h1>
                        </div>

                        <!-- Navigation Menu -->
                        <nav class="divide-y divide-gray-100">
                            <!-- Services Section -->
                            <div class="menu-section" x-data="{ open: false }">
                                <button @click="open = !open"
                                    class="flex items-center w-full p-4 text-left hover:bg-gray-50 group">
                                    <span class="text-abitae-green">🔧</span>
                                    <span class="ml-3 font-medium text-gray-900">Servicios</span>
                                    <svg class="w-5 h-5 ml-auto text-gray-400 transition-transform"
                                        :class="{ 'rotate-180': open }" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>
                                <div x-show="open" x-transition:enter="transition ease-out duration-200"
                                    x-transition:enter-start="opacity-0 transform -translate-y-2"
                                    x-transition:enter-end="opacity-100 transform translate-y-0"
                                    x-transition:leave="transition ease-in duration-150"
                                    x-transition:leave-start="opacity-100 transform translate-y-0"
                                    x-transition:leave-end="opacity-0 transform -translate-y-2"
                                    class="px-4 py-2 bg-gray-50">
                                    <a href="/servicios"
                                        class="block py-2 pl-8 text-sm text-gray-600 hover:text-abitae-green">Servicio
                                        Nacional</a>
                                    <a href="/servicios"
                                        class="block py-2 pl-8 text-sm text-gray-600 hover:text-abitae-green">Servicio
                                        Internacional</a>
                                    <a href="/servicios"
                                        class="block py-2 pl-8 text-sm text-gray-600 hover:text-abitae-green">Servicio
                                        Express</a>
                                </div>
                            </div>

                            <!-- Shipping Section -->
                            <div class="menu-section" x-data="{ open: false }">
                                <button @click="open = !open"
                                    class="flex items-center w-full p-4 text-left hover:bg-gray-50 group">
                                    <span class="text-abitae-green">📦</span>
                                    <span class="ml-3 font-medium text-gray-900">Ubicanos</span>
                                    <svg class="w-5 h-5 ml-auto text-gray-400 transition-transform"
                                        :class="{ 'rotate-180': open }" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>
                                <div x-show="open" x-transition:enter="transition ease-out duration-200"
                                    x-transition:enter-start="opacity-0 transform -translate-y-2"
                                    x-transition:enter-end="opacity-100 transform translate-y-0"
                                    x-transition:leave="transition ease-in duration-150"
                                    x-transition:leave-start="opacity-100 transform translate-y-0"
                                    x-transition:leave-end="opacity-0 transform -translate-y-2"
                                    class="px-4 py-2 bg-gray-50">
                                    <a href="/reclamaciones"
                                        class="block py-2 pl-8 text-sm text-gray-600 hover:text-abitae-green">Contactanos</a>
                                    <a href="/reclamaciones"
                                        class="block py-2 pl-8 text-sm text-gray-600 hover:text-abitae-green">Libro de
                                        Reclamaciones</a>
                                </div>
                            </div>
                        </nav>
                    </div>
                </aside>
                <!-- Main Content Area -->
                <div class="flex-1">
                    <div class="p-6 bg-white rounded-lg shadow">
                        {{ $slot }}
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="py-10 text-green-500 bg-gray-800">
        <div class="px-5 mx-auto max-w-7xl">
            <div class="grid grid-cols-1 gap-8 md:grid-cols-4">
                <div>
                    <h3 class="mb-4 text-xl font-bold">Brayan</h3>
                    <p class="mb-4 text-gray-400">Tu mejor opción para envíos seguros y confiables en todo el país.</p>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 transition-colors duration-300 hover:text-green-500">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M22.675 0h-21.35c-.732 0-1.325.593-1.325 1.325v21.351c0 .731.593 1.324 1.325 1.324h11.495v-9.294h-3.128v-3.622h3.128v-2.671c0-3.1 1.893-4.788 4.659-4.788 1.325 0 2.463.099 2.795.143v3.24l-1.918.001c-1.504 0-1.795.715-1.795 1.763v2.313h3.587l-.467 3.622h-3.12v9.293h6.116c.73 0 1.323-.593 1.323-1.325v-21.35c0-.732-.593-1.325-1.325-1.325z" />
                            </svg>
                        </a>
                        <a href="#" class="text-gray-400 transition-colors duration-300 hover:text-green-500">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723 10.054 10.054 0 01-3.127 1.184 4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z" />
                            </svg>
                        </a>
                        <a href="#" class="text-gray-400 transition-colors duration-300 hover:text-green-500">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M12 0C8.74 0 8.333.015 7.053.072 5.775.132 4.905.333 4.14.63c-.789.306-1.459.717-2.126 1.384S.935 3.35.63 4.14C.333 4.905.131 5.775.072 7.053.012 8.333 0 8.74 0 12s.015 3.667.072 4.947c.06 1.277.261 2.148.558 2.913.306.788.717 1.459 1.384 2.126.667.666 1.336 1.079 2.126 1.384.766.296 1.636.499 2.913.558C8.333 23.988 8.74 24 12 24s3.667-.015 4.947-.072c1.277-.06 2.148-.262 2.913-.558.788-.306 1.459-.718 2.126-1.384.666-.667 1.079-1.335 1.384-2.126.296-.765.499-1.636.558-2.913.06-1.28.072-1.687.072-4.947s-.015-3.667-.072-4.947c-.06-1.277-.262-2.149-.558-2.913-.306-.789-.718-1.459-1.384-2.126C21.319 1.347 20.651.935 19.86.63c-.765-.297-1.636-.499-2.913-.558C15.667.012 15.26 0 12 0zm0 2.16c3.203 0 3.585.016 4.85.071 1.17.055 1.805.249 2.227.415.562.217.96.477 1.382.896.419.42.679.819.896 1.381.164.422.36 1.057.413 2.227.057 1.266.07 1.646.07 4.85s-.015 3.585-.074 4.85c-.061 1.17-.256 1.805-.421 2.227-.224.562-.479.96-.899 1.382-.419.419-.824.679-1.38.896-.42.164-1.065.36-2.235.413-1.274.057-1.649.07-4.859.07-3.211 0-3.586-.015-4.859-.074-1.171-.061-1.816-.256-2.236-.421-.569-.224-.96-.479-1.379-.899-.421-.419-.69-.824-.9-1.38-.165-.42-.359-1.065-.42-2.235-.045-1.26-.061-1.649-.061-4.844 0-3.196.016-3.586.061-4.861.061-1.17.255-1.814.42-2.234.21-.57.479-.96.9-1.381.419-.419.81-.689 1.379-.898.42-.166 1.051-.361 2.221-.421 1.275-.045 1.65-.06 4.859-.06l.045.03zm0 3.678c-3.405 0-6.162 2.76-6.162 6.162 0 3.405 2.76 6.162 6.162 6.162 3.405 0 6.162-2.76 6.162-6.162 0-3.405-2.76-6.162-6.162-6.162zM12 16c-2.21 0-4-1.79-4-4s1.79-4 4-4 4 1.79 4 4-1.79 4-4 4zm7.846-10.405c0 .795-.646 1.44-1.44 1.44-.795 0-1.44-.646-1.44-1.44 0-.794.646-1.439 1.44-1.439.793-.001 1.44.645 1.44 1.439z" />
                            </svg>
                        </a>
                    </div>
                </div>
                <div>
                    <h3 class="mb-4 text-lg font-semibold">Enlaces rápidos</h3>
                    <ul class="space-y-2">
                        <li><a href="#"
                                class="text-gray-400 transition-colors duration-300 hover:text-green-500">Inicio</a>
                        </li>
                        <li><a href="#"
                                class="text-gray-400 transition-colors duration-300 hover:text-green-500">Servicios</a>
                        </li>
                        <li><a href="#"
                                class="text-gray-400 transition-colors duration-300 hover:text-green-500">Tarifas</a></li>
                        <li><a href="#"
                                class="text-gray-400 transition-colors duration-300 hover:text-green-500">Agencias</a></li>
                        <li><a href="#"
                                class="text-gray-400 transition-colors duration-300 hover:text-green-500">Contacto</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="mb-4 text-lg font-semibold">Servicios</h3>
                    <ul class="space-y-2">
                        <li><a href="#"
                                class="text-gray-400 transition-colors duration-300 hover:text-green-500">Envíos
                                nacionales</a></li>
                        <li><a href="#"
                                class="text-gray-400 transition-colors duration-300 hover:text-green-500">Envíos
                                internacionales</a></li>
                        <li><a href="#"
                                class="text-gray-400 transition-colors duration-300 hover:text-green-500">Paquetería</a>
                        </li>
                        <li><a href="#"
                                class="text-gray-400 transition-colors duration-300 hover:text-green-500">Carga
                                pesada</a></li>
                        <li><a href="#"
                                class="text-gray-400 transition-colors duration-300 hover:text-green-500">Logística
                                integral</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="mb-4 text-lg font-semibold">Contacto</h3>
                    <ul class="space-y-2 text-gray-400">
                        <li class="flex items-start">
                            <svg class="w-5 h-5 mr-2 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M10 0C4.477 0 0 4.477 0 10c0 5.523 4.477 10 10 10s10-4.477 10-10C20 4.477 15.523 0 10 0zm0 18.75c-4.832 0-8.75-3.918-8.75-8.75S5.168 1.25 10 1.25 18.75 5.168 18.75 10 14.832 18.75 10 18.75zm0-15.357c-2.475 0-4.5 2.025-4.5 4.5 0 3.75 4.5 9.107 4.5 9.107s4.5-5.357 4.5-9.107c0-2.475-2.025-4.5-4.5-4.5zm0 6.107c-.966 0-1.75-.784-1.75-1.75s.784-1.75 1.75-1.75 1.75.784 1.75 1.75-.784 1.75-1.75 1.75z" />
                            </svg>
                            <span>Av. Principal 123, Lima, Perú</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-5 h-5 mr-2 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M17.924 2.617a.997.997 0 00-.215-.322l-.004-.004A.997.997 0 0017 2h-4a1 1 0 100 2h1.586l-3.293 3.293a1 1 0 001.414 1.414L16 5.414V7a1 1 0 102 0V3a.997.997 0 00-.076-.383z" />
                                <path
                                    d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" />
                            </svg>
                            <span>+51 123 456 789</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-5 h-5 mr-2 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                            </svg>
                            <span>contacto@Brayan.pe</span>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="pt-8 mt-8 text-center text-gray-400 border-t border-gray-700">
                <p>&copy; 2023 Brayan. Todos los derechos reservados.</p>
            </div>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const track = document.getElementById('carouselTrack');
            const items = track.querySelectorAll('.carousel-item');
            const itemWidth = 122; // 112px (w-28) + 10px spacing
            const visibleItems = 5;
            let currentIndex = 0;

            // Clone first 5 items and append them to the end
            for (let i = 0; i < visibleItems; i++) {
                const clone = items[i].cloneNode(true);
                track.appendChild(clone);
            }

            window.moveCarousel = function(direction) {
                currentIndex += direction;
                track.style.transition = 'transform 500ms ease-in-out';
                track.style.transform = `translateX(-${currentIndex * itemWidth}px)`;

                // Reset position when reaching the end
                if (currentIndex >= items.length || currentIndex < 0) {
                    setTimeout(() => {
                        track.style.transition = 'none';
                        currentIndex = direction > 0 ? 0 : items.length - 1;
                        track.style.transform = `translateX(-${currentIndex * itemWidth}px)`;
                    }, 500);
                }
            }

            // Auto-play functionality
            let autoPlayInterval = setInterval(() => moveCarousel(1), 3000);

            // Pause on hover
            track.addEventListener('mouseenter', () => clearInterval(autoPlayInterval));
            track.addEventListener('mouseleave', () => {
                autoPlayInterval = setInterval(() => moveCarousel(1), 3000);
            });

            // Touch support
            let touchStartX = 0;
            let touchEndX = 0;

            track.addEventListener('touchstart', e => {
                touchStartX = e.changedTouches[0].screenX;
                clearInterval(autoPlayInterval);
            });

            track.addEventListener('touchend', e => {
                touchEndX = e.changedTouches[0].screenX;
                const swipeDistance = touchEndX - touchStartX;

                if (Math.abs(swipeDistance) > 50) {
                    moveCarousel(swipeDistance > 0 ? -1 : 1);
                }

                autoPlayInterval = setInterval(() => moveCarousel(1), 3000);
            });
        });
    </script>
</body>

</html>
