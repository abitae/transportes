<!-- Promotional Cards -->
<div class="grid grid-cols-1 gap-1 mb-2 sm:grid-cols-2 md:grid-cols-8">
    <div class="grid grid-cols-1 col-span-6 gap-1 sm:grid-cols-2 md:grid-cols-6">
        <!-- Replace the grid with this carousel structure -->
        <div class="flex gap-4 mb-8">
            <!-- Carousel Container with fixed width -->
            <div class="relative w-full md:w-[700px] mx-auto">
                <div class="overflow-hidden carousel-container">
                    <div class="carousel-track flex space-x-[10px] transition-transform duration-500"
                        id="carouselTrack">
                        <!-- Card 1 -->
                        <div class="flex-none carousel-item w-28">
                            <div
                                class="overflow-hidden transition-shadow duration-300 bg-white rounded-lg shadow h-60 hover:shadow-lg">
                                <img src="https://shalom.com.pe/img/stories/story1.jpg"
                                    alt="Registrar envío" class="object-cover w-full h-full">
                            </div>
                        </div>
                        <!-- Card 2 -->
                        <div class="flex-none carousel-item w-28">
                            <div
                                class="overflow-hidden transition-shadow duration-300 bg-white rounded-lg shadow h-60 hover:shadow-lg">
                                <img src="https://shalom.com.pe/img/stories/PORTADA-shalom-APP.png"
                                    alt="Autogestiones" class="object-cover w-full h-full">
                            </div>
                        </div>
                        <!-- Card 3 -->
                        <div class="flex-none carousel-item w-28">
                            <div
                                class="overflow-hidden transition-shadow duration-300 bg-white rounded-lg shadow h-60 hover:shadow-lg">
                                <img src="https://shalom.com.pe/img/stories/punto_pro.png"
                                    alt="Tips para envíos" class="object-cover w-full h-full">
                            </div>
                        </div>
                        <!-- Card 4 -->
                        <div class="flex-none carousel-item w-28">
                            <div
                                class="overflow-hidden transition-shadow duration-300 bg-white rounded-lg shadow h-60 hover:shadow-lg">
                                <img src="https://shalom.com.pe/img/stories/story2.webp" alt="Fraudes"
                                    class="object-cover w-full h-full">
                            </div>
                        </div>
                        <!-- Card 5 -->
                        <div class="flex-none carousel-item w-28">
                            <div
                                class="overflow-hidden transition-shadow duration-300 bg-white rounded-lg shadow h-60 hover:shadow-lg">
                                <img src="https://shalom.com.pe/img/stories/story3.webp" alt="Envíos"
                                    class="object-cover w-full h-full">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Navigation Buttons -->
                <button
                    class="absolute left-0 z-10 p-2 transform -translate-y-1/2 bg-white rounded-full shadow-lg top-1/2 hover:bg-gray-100 focus:outline-none"
                    onclick="moveCarousel(-1)">
                    <svg class="w-6 h-6 text-abitae-green" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 19l-7-7 7-7"></path>
                    </svg>
                </button>
                <button
                    class="absolute right-0 z-10 p-2 transform -translate-y-1/2 bg-white rounded-full shadow-lg top-1/2 hover:bg-gray-100 focus:outline-none"
                    onclick="moveCarousel(1)">
                    <svg class="w-6 h-6 text-abitae-green" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5l7 7-7 7"></path>
                    </svg>
                </button>
            </div>
        </div>


    </div>

    <div class="w-full col-span-2 overflow-hidden bg-white rounded-lg shadow h-60 md:w-64">
        <img src="https://placehold.co/200x200/00ac3d/FFFFFF/png?text=Fraudes" alt="Fraudes"
            class="object-cover w-full h-full">
    </div>
</div>

<!-- filepath: /c:/Proyectos/transportes/resources/views/web2/index3.blade.php -->
<!-- Banners -->
<div class="flex flex-col gap-5 mb-2 md:flex-row">
    <div class="flex-1 relative overflow-hidden rounded-lg min-h-[300px]">
        <img src="https://shalom.com.pe/img/publications/flayer_tarifas.png" alt="Tarifas"
            class="absolute inset-0 object-cover w-full h-full">
    </div>
    <div class="flex-1 relative overflow-hidden rounded-lg min-h-[300px]">
        <img src="https://shalom.com.pe/img/publications/flayer_tarifas.png" alt="Tarifas"
            class="absolute inset-0 object-cover w-full h-full">
    </div>
</div>

<!-- Features Section -->
<div class="grid grid-cols-1 gap-6 mb-8 md:grid-cols-3">
    <div class="p-6 bg-white rounded-lg shadow">
        <div class="mb-4 text-4xl text-abitae-green">📊</div>
        <h3 class="mb-2 text-xl font-semibold text-gray-800">Seguimiento en tiempo real</h3>
        <p class="text-gray-600">Monitorea tus envíos en cualquier momento desde nuestra plataforma web o
            aplicación móvil.</p>
    </div>
    <div class="p-6 bg-white rounded-lg shadow">
        <div class="mb-4 text-4xl text-abitae-green">🚚</div>
        <h3 class="mb-2 text-xl font-semibold text-gray-800">Entregas programadas</h3>
        <p class="text-gray-600">Programa tus envíos con anticipación y recibe notificaciones sobre su
            estado.</p>
    </div>
    <div class="p-6 bg-white rounded-lg shadow">
        <div class="mb-4 text-4xl text-abitae-green">💰</div>
        <h3 class="mb-2 text-xl font-semibold text-gray-800">Tarifas competitivas</h3>
        <p class="text-gray-600">Ofrecemos las mejores tarifas del mercado para tus envíos nacionales e
            internacionales.</p>
    </div>
</div>
