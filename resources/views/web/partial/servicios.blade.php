<div class="container mx-auto px-4 py-12">
    <h1 class="text-4xl font-bold text-center text-gray-800 mb-12 animate__animated animate__fadeIn">Nuestros Servicios
    </h1>

    <!-- Servicio de Transporte de Carga -->
    <div class="flex flex-col md:flex-row items-center justify-between gap-8 mb-16">
        <div class="w-full md:w-1/2 animate__animated animate__fadeInLeft">
            <img src="{{ asset('img/servicios/transporte-carga.jpg') }}" alt="Transporte de carga"
                class="w-full h-auto rounded-lg shadow-lg" loading="lazy">
        </div>

        <div class="w-full md:w-1/2 animate__animated animate__fadeInRight">
            <h2 class="text-2xl font-semibold text-gray-800 mb-4">Transporte de Carga</h2>
            <p class="text-gray-600 mb-4 leading-relaxed">
                Ofrecemos soluciones integrales para el transporte de mercancías a nivel nacional. Nuestra moderna flota 
                de camiones está equipada con la última tecnología para garantizar que su carga llegue a destino de 
                manera segura y puntual.
            </p>
            <p class="text-gray-600 leading-relaxed">
                Manejamos todo tipo de carga: general, pesada, frágil y especializada, adaptándonos a las necesidades 
                específicas de cada cliente y sector.
            </p>
            <div class="mt-6">
                <a href="#contacto" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-6 rounded-lg transition duration-300 inline-flex items-center">
                    <i class="fas fa-truck mr-2"></i> Solicitar servicio
                </a>
            </div>
        </div>
    </div>

    <!-- Servicio de Logística -->
    <div class="flex flex-col md:flex-row-reverse items-center justify-between gap-8 mb-16">
        <div class="w-full md:w-1/2 animate__animated animate__fadeInRight">
            <img src="{{ asset('img/servicios/logistica.jpg') }}" alt="Servicios de logística"
                class="w-full h-auto rounded-lg shadow-lg" loading="lazy">
        </div>

        <div class="w-full md:w-1/2 animate__animated animate__fadeInLeft">
            <h2 class="text-2xl font-semibold text-gray-800 mb-4">Logística Integral</h2>
            <p class="text-gray-600 mb-4 leading-relaxed">
                Más allá del transporte, ofrecemos soluciones logísticas completas que incluyen almacenamiento, 
                gestión de inventario, preparación de pedidos y distribución. Optimizamos cada etapa de la 
                cadena de suministro para maximizar la eficiencia.
            </p>
            <p class="text-gray-600 leading-relaxed">
                Nuestro sistema de gestión permite el seguimiento en tiempo real de sus mercancías, brindándole 
                total visibilidad y control sobre sus operaciones.
            </p>
            <div class="mt-6">
                <a href="#contacto" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-6 rounded-lg transition duration-300 inline-flex items-center">
                    <i class="fas fa-boxes mr-2"></i> Conocer más
                </a>
            </div>
        </div>
    </div>

    <!-- Servicio de Distribución Urbana -->
    <div class="flex flex-col md:flex-row items-center justify-between gap-8 mb-16">
        <div class="w-full md:w-1/2 animate__animated animate__fadeInLeft">
            <img src="{{ asset('img/servicios/distribucion-urbana.jpg') }}" alt="Distribución urbana"
                class="w-full h-auto rounded-lg shadow-lg" loading="lazy">
        </div>

        <div class="w-full md:w-1/2 animate__animated animate__fadeInRight">
            <h2 class="text-2xl font-semibold text-gray-800 mb-4">Distribución Urbana</h2>
            <p class="text-gray-600 mb-4 leading-relaxed">
                Contamos con una flota especializada para la distribución de última milla en entornos urbanos. 
                Nuestros vehículos de menor tamaño están optimizados para navegar eficientemente por las ciudades, 
                garantizando entregas rápidas incluso en zonas de difícil acceso.
            </p>
            <p class="text-gray-600 leading-relaxed">
                Ideal para comercio electrónico, retail y cualquier negocio que requiera distribución frecuente 
                en áreas metropolitanas.
            </p>
            <div class="mt-6">
                <a href="#contacto" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-6 rounded-lg transition duration-300 inline-flex items-center">
                    <i class="fas fa-city mr-2"></i> Solicitar servicio
                </a>
            </div>
        </div>
    </div>

    <!-- Características de nuestros servicios -->
    <div class="mb-16">
        <h2 class="text-3xl font-semibold text-center text-gray-800 mb-10 animate__animated animate__fadeIn">¿Por qué elegirnos?</h2>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300 animate__animated animate__fadeIn">
                <div class="text-center mb-4">
                    <i class="fas fa-map-marked-alt text-4xl text-blue-600"></i>
                </div>
                <h3 class="text-xl font-semibold text-center text-gray-800 mb-3">Cobertura Nacional</h3>
                <p class="text-gray-600 text-center">
                    Llegamos a todos los rincones del país con nuestra extensa red logística y puntos de distribución estratégicos.
                </p>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300 animate__animated animate__fadeIn animate__delay-1s">
                <div class="text-center mb-4">
                    <i class="fas fa-truck-loading text-4xl text-blue-600"></i>
                </div>
                <h3 class="text-xl font-semibold text-center text-gray-800 mb-3">Flota Especializada</h3>
                <p class="text-gray-600 text-center">
                    Disponemos de vehículos adaptados a cada tipo de carga: refrigerados, plataformas, cisternas y más.
                </p>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300 animate__animated animate__fadeIn animate__delay-2s">
                <div class="text-center mb-4">
                    <i class="fas fa-satellite-dish text-4xl text-blue-600"></i>
                </div>
                <h3 class="text-xl font-semibold text-center text-gray-800 mb-3">Seguimiento en Tiempo Real</h3>
                <p class="text-gray-600 text-center">
                    Monitoree sus envíos en cualquier momento a través de nuestra plataforma digital y aplicación móvil.
                </p>
            </div>
        </div>
    </div>

    <!-- Llamado a la acción -->
    <div class="bg-blue-50 p-8 rounded-xl shadow-md animate__animated animate__fadeIn">
        <div class="text-center">
            <h2 class="text-3xl font-semibold text-gray-800 mb-4">¿Listo para optimizar su logística?</h2>
            <p class="text-gray-600 mb-6 max-w-3xl mx-auto">
                Nuestro equipo de expertos está preparado para diseñar una solución personalizada que se adapte 
                perfectamente a las necesidades de su negocio.
            </p>
            <a href="#contacto" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-lg transition duration-300 inline-flex items-center text-lg">
                <i class="fas fa-paper-plane mr-2"></i> Solicitar cotización
            </a>
        </div>
    </div>
</div>