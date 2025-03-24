<x-web-layout>
    <div class="container px-4 py-12 mx-auto">
        <h1 class="mb-8 text-4xl font-bold text-center text-gray-800">Envía tu Paquete</h1>

        <div class="max-w-3xl mx-auto">
            {{-- Formulario de Envío --}}
            <div class="bg-white rounded-xl shadow-lg p-8">
                <form class="space-y-6">
                    {{-- Origen y Destino --}}
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Ciudad de Origen</label>
                            <select class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                                <option>Seleccionar ciudad</option>
                                {{-- Agregar opciones --}}
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Ciudad de Destino</label>
                            <select class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                                <option>Seleccionar ciudad</option>
                                {{-- Agregar opciones --}}
                            </select>
                        </div>
                    </div>

                    {{-- Detalles del Paquete --}}
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Tipo de Envío</label>
                            <select class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                                <option>Seleccionar tipo</option>
                                <option>Documentos</option>
                                <option>Paquetes</option>
                                <option>Carga Pesada</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Peso (kg)</label>
                            <input type="number"
                                class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                        </div>
                    </div>

                    <button type="submit"
                        class="w-full py-3 px-6 text-white bg-blue-600 hover:bg-blue-700 rounded-lg transition-colors duration-200">
                        Calcular Envío
                    </button>
                </form>
            </div>

            {{-- Información Adicional --}}
            <div class="mt-12 grid md:grid-cols-3 gap-6">
                <div class="p-6 bg-blue-50 rounded-xl">
                    <i class="fas fa-truck text-2xl text-blue-600 mb-4"></i>
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">Envío Rápido</h3>
                    <p class="text-gray-600">Entrega en 24-48 horas a principales ciudades</p>
                </div>

                <div class="p-6 bg-blue-50 rounded-xl">
                    <i class="fas fa-shield-alt text-2xl text-blue-600 mb-4"></i>
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">Envío Seguro</h3>
                    <p class="text-gray-600">Seguimiento en tiempo real de tu envío</p>
                </div>

                <div class="p-6 bg-blue-50 rounded-xl">
                    <i class="fas fa-hand-holding-usd text-2xl text-blue-600 mb-4"></i>
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">Mejor Precio</h3>
                    <p class="text-gray-600">Tarifas competitivas garantizadas</p>
                </div>
            </div>
        </div>
    </div>
</x-web-layout>
