<div class="container px-4 py-12 mx-auto">
    <h1 class="mb-12 text-4xl font-bold text-center text-gray-800 animate__animated animate__fadeIn">Nuestros Servicios
    </h1>

    <!-- Servicio de Transporte de Carga -->
    <div class="flex flex-col items-center justify-between gap-8 mb-16 md:flex-row">
        <div class="w-full md:w-1/2 animate__animated animate__fadeInLeft">
            <img src="{{ asset('img/web/servicios/transporte-carga.jpg') }}" alt="Transporte de carga"
                class="w-full h-auto rounded-lg shadow-lg" loading="lazy">
        </div>

        <div class="w-full md:w-1/2 animate__animated animate__fadeInRight">
            <h2 class="mb-4 text-2xl font-semibold text-gray-800">Transporte de Carga</h2>
            <p class="mb-4 leading-relaxed text-gray-600">
                Ofrecemos soluciones integrales para el transporte de mercancías a nivel nacional. Nuestra moderna flota 
                de camiones está equipada con la última tecnología para garantizar que su carga llegue a destino de 
                manera segura y puntual.
            </p>
            <p class="leading-relaxed text-gray-600">
                Manejamos todo tipo de carga: general, pesada, frágil y especializada, adaptándonos a las necesidades 
                específicas de cada cliente y sector.
            </p>
            <div class="mt-6">
                <a href="/cotizar" class="inline-flex items-center px-6 py-2 font-medium text-white transition duration-300 bg-blue-600 rounded-lg hover:bg-blue-700">
                    <i class="mr-2 fas fa-truck"></i> Solicitar servicio
                </a>
            </div>
        </div>
    </div>

    <!-- Servicio de Logística -->
    <div class="flex flex-col items-center justify-between gap-8 mb-16 md:flex-row-reverse">
        <div class="w-full md:w-1/2 animate__animated animate__fadeInRight">
            <img src="{{ asset('img/web/servicios/logistica.jpg') }}" alt="Servicios de logística"
                class="w-full h-auto rounded-lg shadow-lg" loading="lazy">
        </div>

        <div class="w-full md:w-1/2 animate__animated animate__fadeInLeft">
            <h2 class="mb-4 text-2xl font-semibold text-gray-800">Logística Integral</h2>
            <p class="mb-4 leading-relaxed text-gray-600">
                Más allá del transporte, ofrecemos soluciones logísticas completas que incluyen almacenamiento, 
                gestión de inventario, preparación de pedidos y distribución. Optimizamos cada etapa de la 
                cadena de suministro para maximizar la eficiencia.
            </p>
            <p class="leading-relaxed text-gray-600">
                Nuestro sistema de gestión permite el seguimiento en tiempo real de sus mercancías, brindándole 
                total visibilidad y control sobre sus operaciones.
            </p>
            <div class="mt-6">
                <a href="/cotizar" class="inline-flex items-center px-6 py-2 font-medium text-white transition duration-300 bg-blue-600 rounded-lg hover:bg-blue-700">
                    <i class="mr-2 fas fa-boxes"></i> Conocer más
                </a>
            </div>
        </div>
    </div>

    <!-- Servicio de Distribución Urbana -->
    <div class="flex flex-col items-center justify-between gap-8 mb-16 md:flex-row">
        <div class="w-full md:w-1/2 animate__animated animate__fadeInLeft">
            <img src="{{ asset('img/web/servicios/distribucion-urbana.jpg') }}" alt="Distribución urbana"
                class="w-full h-auto rounded-lg shadow-lg" loading="lazy">
        </div>

        <div class="w-full md:w-1/2 animate__animated animate__fadeInRight">
            <h2 class="mb-4 text-2xl font-semibold text-gray-800">Distribución Urbana</h2>
            <p class="mb-4 leading-relaxed text-gray-600">
                Contamos con una flota especializada para la distribución de última milla en entornos urbanos. 
                Nuestros vehículos de menor tamaño están optimizados para navegar eficientemente por las ciudades, 
                garantizando entregas rápidas incluso en zonas de difícil acceso.
            </p>
            <p class="leading-relaxed text-gray-600">
                Ideal para comercio electrónico, retail y cualquier negocio que requiera distribución frecuente 
                en áreas metropolitanas.
            </p>
            <div class="mt-6">
                <a href="/cotizar" class="inline-flex items-center px-6 py-2 font-medium text-white transition duration-300 bg-blue-600 rounded-lg hover:bg-blue-700">
                    <i class="mr-2 fas fa-city"></i> Solicitar servicio
                </a>
            </div>
        </div>
    </div>

    <!-- Características de nuestros servicios -->
    <div class="mb-16">
        <h2 class="mb-10 text-3xl font-semibold text-center text-gray-800 animate__animated animate__fadeIn">¿Por qué elegirnos?</h2>

        <div class="grid grid-cols-1 gap-8 md:grid-cols-3">
            <div class="p-6 transition-shadow duration-300 bg-white rounded-lg shadow-md hover:shadow-xl animate__animated animate__fadeIn">
                <div class="mb-4 text-center">
                    <i class="text-4xl text-blue-600 fas fa-map-marked-alt"></i>
                </div>
                <h3 class="mb-3 text-xl font-semibold text-center text-gray-800">Cobertura Nacional</h3>
                <p class="text-center text-gray-600">
                    Llegamos a todos los rincones del país con nuestra extensa red logística y puntos de distribución estratégicos.
                </p>
            </div>

            <div class="p-6 transition-shadow duration-300 bg-white rounded-lg shadow-md hover:shadow-xl animate__animated animate__fadeIn animate__delay-1s">
                <div class="mb-4 text-center">
                    <i class="text-4xl text-blue-600 fas fa-truck-loading"></i>
                </div>
                <h3 class="mb-3 text-xl font-semibold text-center text-gray-800">Flota Especializada</h3>
                <p class="text-center text-gray-600">
                    Disponemos de vehículos adaptados a cada tipo de carga: refrigerados, plataformas, cisternas y más.
                </p>
            </div>

            <div class="p-6 transition-shadow duration-300 bg-white rounded-lg shadow-md hover:shadow-xl animate__animated animate__fadeIn animate__delay-2s">
                <div class="mb-4 text-center">
                    <i class="text-4xl text-blue-600 fas fa-satellite-dish"></i>
                </div>
                <h3 class="mb-3 text-xl font-semibold text-center text-gray-800">Seguimiento en Tiempo Real</h3>
                <p class="text-center text-gray-600">
                    Monitoree sus envíos en cualquier momento a través de nuestra plataforma digital y aplicación móvil.
                </p>
            </div>
        </div>
    </div>

    <!-- Llamado a la acción -->
    <div class="p-8 shadow-md bg-blue-50 rounded-xl animate__animated animate__fadeIn">
        <div class="text-center">
            <h2 class="mb-4 text-3xl font-semibold text-gray-800">¿Listo para optimizar su logística?</h2>
            <p class="max-w-3xl mx-auto mb-6 text-gray-600">
                Nuestro equipo de expertos está preparado para diseñar una solución personalizada que se adapte 
                perfectamente a las necesidades de su negocio.
            </p>
            <a href="/cotizar" class="inline-flex items-center px-8 py-3 text-lg font-bold text-white transition duration-300 bg-blue-600 rounded-lg hover:bg-blue-700">
                <i class="mr-2 fas fa-paper-plane"></i> Solicitar cotización
            </a>
        </div>
    </div>
</div>