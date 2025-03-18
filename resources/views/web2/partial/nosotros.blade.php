<h1 class="text-4xl font-bold text-center text-gray-800 mb-12 animate__animated animate__fadeIn">Nuestra Historia
</h1>

<!-- Historia de la empresa - Sección 1 -->
<div class="flex flex-col md:flex-row items-center justify-between gap-8 mb-16">
    <div class="w-full md:w-1/2 animate__animated animate__fadeInLeft">
        <img src="{{ asset('img/nosotros/historia-fundacion.jpg') }}" alt="Fundación de la empresa"
            class="w-full h-auto rounded-lg shadow-lg" loading="lazy">
    </div>

    <div class="w-full md:w-1/2 animate__animated animate__fadeInRight">
        <h2 class="text-2xl font-semibold text-gray-800 mb-4">Nuestros Inicios</h2>
        <p class="text-gray-600 mb-4 leading-relaxed">
            Fundada en 1995, nuestra empresa de transportes comenzó con una pequeña flota de 3 vehículos y un sueño:
            conectar personas y mercancías de manera segura y eficiente a través del país.
        </p>
        <p class="text-gray-600 leading-relaxed">
            Lo que comenzó como un emprendimiento familiar, rápidamente se convirtió en un referente del sector
            gracias a nuestro compromiso con la puntualidad y el servicio al cliente.
        </p>
    </div>
</div>

<!-- Historia de la empresa - Sección 2 -->
<div class="flex flex-col md:flex-row-reverse items-center justify-between gap-8 mb-16">
    <div class="w-full md:w-1/2 animate__animated animate__fadeInRight">
        <img src="{{ asset('img/nosotros/flota-actual.jpg') }}" alt="Nuestra flota moderna"
            class="w-full h-auto rounded-lg shadow-lg" loading="lazy">
    </div>

    <!-- ... existing code ... -->
</div>

<!-- Valores de la empresa -->
<div class="mb-16">
    <!-- ... existing code ... -->
</div>

<!-- Equipo directivo -->
<div>
    <h2 class="text-3xl font-semibold text-center text-gray-800 mb-10 animate__animated animate__fadeIn">Nuestro
        Equipo Directivo</h2>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <div class="bg-white p-6 rounded-lg shadow-md text-center animate__animated animate__fadeIn">
            <img src="{{ asset('img/equipo/director-general.jpg') }}" alt="Director General"
                class="w-40 h-40 object-cover rounded-full mx-auto mb-4 border-4 border-blue-600" loading="lazy">
            <h3 class="text-xl font-semibold text-gray-800 mb-1">Carlos Rodríguez</h3>
            <p class="text-blue-600 mb-3">Director General</p>
            <p class="text-gray-600">
                Con más de 25 años de experiencia en el sector, lidera nuestra visión de crecimiento sostenible.
            </p>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-md text-center animate__animated animate__fadeIn">
            <img src="{{ asset('img/equipo/directora-operaciones.jpg') }}" alt="Directora de Operaciones"
                class="w-40 h-40 object-cover rounded-full mx-auto mb-4 border-4 border-blue-600" loading="lazy">
            <h3 class="text-xl font-semibold text-gray-800 mb-1">Ana Martínez</h3>
            <p class="text-blue-600 mb-3">Directora de Operaciones</p>
            <p class="text-gray-600">
                Responsable de optimizar nuestros procesos logísticos para garantizar un servicio de excelencia.
            </p>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-md text-center animate__animated animate__fadeIn">
            <img src="{{ asset('img/equipo/director-tecnologia.jpg') }}" alt="Director de Tecnología"
                class="w-40 h-40 object-cover rounded-full mx-auto mb-4 border-4 border-blue-600" loading="lazy">
            <h3 class="text-xl font-semibold text-gray-800 mb-1">Miguel Sánchez</h3>
            <p class="text-blue-600 mb-3">Director de Tecnología</p>
            <p class="text-gray-600">
                Impulsa la innovación tecnológica que nos permite ofrecer soluciones modernas de transporte y
                seguimiento.
            </p>
        </div>
    </div>
</div>
