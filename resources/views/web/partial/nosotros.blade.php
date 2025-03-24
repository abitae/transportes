<h1 class="mb-12 text-4xl font-bold text-center text-gray-800 animate__animated animate__fadeIn">Nuestra Historia
</h1>

<!-- Historia de la empresa - Sección 1 -->
<div class="flex flex-col items-center justify-between gap-8 mb-16 md:flex-row">
    <div class="w-full md:w-1/2 animate__animated animate__fadeInLeft">
        <img src="{{ asset('img/web/fotografia.jpg') }}" alt="Fundación de la empresa"
            class="w-full h-auto rounded-lg shadow-lg" loading="lazy">
    </div>

    <div class="w-full md:w-1/2 animate__animated animate__fadeInRight">
        <h2 class="mb-4 text-2xl font-semibold text-gray-800">Nuestros Inicios</h2>
        <p class="mb-4 leading-relaxed text-gray-600">
            Fundada en 1995, nuestra empresa de transportes comenzó con una pequeña flota de 3 vehículos y un sueño:
            conectar personas y mercancías de manera segura y eficiente a través del país.
        </p>
        <p class="leading-relaxed text-gray-600">
            Lo que comenzó como un emprendimiento familiar, rápidamente se convirtió en un referente del sector
            gracias a nuestro compromiso con la puntualidad y el servicio al cliente.
        </p>
    </div>
</div>

<!-- Historia de la empresa - Sección 2 -->
<div class="flex flex-col items-center justify-between gap-8 mb-16 md:flex-row-reverse">
    <div class="w-full md:w-1/2 animate__animated animate__fadeInRight">
        <img src="{{ asset('img/web/fotografia2.jpg') }}" alt="Nuestra flota moderna"
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
    <h2 class="mb-10 text-3xl font-semibold text-center text-gray-800 animate__animated animate__fadeIn">Nuestro
        Equipo Directivo</h2>

    <div class="grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-3">
        <div class="p-6 text-center bg-white rounded-lg shadow-md animate__animated animate__fadeIn">
            <img src="{{ asset('img/web/equipo/equipo.png') }}" alt="Director General"
                class="object-cover w-40 h-40 mx-auto mb-4 border-4 border-blue-600 rounded-full" loading="lazy">
            <h3 class="mb-1 text-xl font-semibold text-gray-800">Carlos Rodríguez</h3>
            <p class="mb-3 text-blue-600">Director General</p>
            <p class="text-gray-600">
                Con más de 25 años de experiencia en el sector, lidera nuestra visión de crecimiento sostenible.
            </p>
        </div>

        <div class="p-6 text-center bg-white rounded-lg shadow-md animate__animated animate__fadeIn">
            <img src="{{ asset('img/web/equipo/equipo.png') }}" alt="Directora de Operaciones"
                class="object-cover w-40 h-40 mx-auto mb-4 border-4 border-blue-600 rounded-full" loading="lazy">
            <h3 class="mb-1 text-xl font-semibold text-gray-800">Ana Martínez</h3>
            <p class="mb-3 text-blue-600">Directora de Operaciones</p>
            <p class="text-gray-600">
                Responsable de optimizar nuestros procesos logísticos para garantizar un servicio de excelencia.
            </p>
        </div>

        <div class="p-6 text-center bg-white rounded-lg shadow-md animate__animated animate__fadeIn">
            <img src="{{ asset('img/web/equipo/equipo.png') }}" alt="Director de Tecnología"
                class="object-cover w-40 h-40 mx-auto mb-4 border-4 border-blue-600 rounded-full" loading="lazy">
            <h3 class="mb-1 text-xl font-semibold text-gray-800">Miguel Sánchez</h3>
            <p class="mb-3 text-blue-600">Director de Tecnología</p>
            <p class="text-gray-600">
                Impulsa la innovación tecnológica que nos permite ofrecer soluciones modernas de transporte y
                seguimiento.
            </p>
        </div>
    </div>
</div>
