<div class="flex flex-col md:flex-row items-center justify-center gap-8">

    <div class="w-full md:w-1/2 max-w-lg p-8 bg-white rounded-lg shadow-md animate__animated animate__fadeIn">
        <h2 class="text-center text-2xl text-gray-800 mb-6">Rastrear Encomienda</h2>

        <form action="{{ route('tracking.search') }}" method="POST" class="animate__animated animate__fadeInUp">
            @csrf
            <div class="mb-6">
                <label for="tracking_number" class="block text-gray-700 mb-2">Número de Guía</label>
                <input type="text"
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                    id="tracking_number" name="tracking_number" placeholder="Ingrese su número de guía" required>
            </div>

            <div class="mb-6">
                <label for="security_code" class="block text-gray-700 mb-2">Código de Seguridad</label>
                <input type="text"
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                    id="security_code" name="security_code" placeholder="Ingrese el código de seguridad" required>
            </div>

            <div class="text-center">
                <button type="submit"
                    class="px-8 py-3 text-lg bg-blue-600 text-white rounded-md hover:bg-blue-700 transform hover:-translate-y-0.5 transition-all duration-300 hover:shadow-lg animate__animated animate__pulse animate__infinite">
                    <i class="fas fa-search mr-2"></i>
                    Rastrear
                </button>
            </div>
        </form>
    </div>

    <!-- Image Section -->
    <div class="w-full md:w-1/2 max-w-lg animate__animated animate__fadeIn">
        <img src="/images/tracking-illustration.svg" alt="Tracking Illustration"
            class="w-full h-auto object-cover rounded-lg shadow-md" loading="lazy">
    </div>
</div>
