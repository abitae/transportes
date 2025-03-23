<div class="container terms-container animate__animated animate__fadeIn">
    <h1 class="text-center mb-4 animate__animated animate__slideInDown">Términos y Condiciones del Servicio</h1>

    <div class="terms-section">
        <div class="term-card animate__animated animate__fadeInLeft">
            <h2 class="term-title">1. Aceptación de Términos</h2>
            <p class="term-content">Al utilizar nuestros servicios de transporte, usted acepta estos términos y condiciones en su totalidad. Si no está de acuerdo con estos términos, por favor no utilice nuestros servicios.</p>
        </div>

        <div class="term-card animate__animated animate__fadeInRight">
            <h2 class="term-title">2. Servicio de Transporte</h2>
            <p class="term-content">Nos comprometemos a brindar servicios de transporte seguros y puntuales. Sin embargo, los tiempos de llegada pueden variar debido a condiciones de tráfico y otros factores fuera de nuestro control.</p>
        </div>

        <div class="term-card animate__animated animate__fadeInLeft">
            <h2 class="term-title">3. Reservas y Cancelaciones</h2>
            <ul class="term-list">
                <li>Las reservas deben realizarse con un mínimo de 24 horas de anticipación.</li>
                <li>Las cancelaciones deben notificarse con al menos 12 horas de anticipación.</li>
                <li>Cancelaciones tardías pueden estar sujetas a cargos.</li>
            </ul>
        </div>

        <div class="term-card animate__animated animate__fadeInRight">
            <h2 class="term-title">4. Responsabilidades del Cliente</h2>
            <ul class="term-list">
                <li>Proporcionar información precisa para la reserva.</li>
                <li>Estar presente en el punto de recojo a la hora acordada.</li>
                <li>Mantener un comportamiento adecuado durante el servicio.</li>
                <li>Respetar las normas de seguridad establecidas.</li>
            </ul>
        </div>

        <div class="term-card animate__animated animate__fadeInLeft">
            <h2 class="term-title">5. Equipaje y Pertenencias</h2>
            <p class="term-content">La empresa no se hace responsable por pérdidas o daños de objetos personales dejados en los vehículos. Se recomienda verificar sus pertenencias antes de descender del vehículo.</p>
        </div>

        <div class="term-card animate__animated animate__fadeInRight">
            <h2 class="term-title">6. Tarifas y Pagos</h2>
            <ul class="term-list">
                <li>Las tarifas se establecen según la ruta y tipo de servicio.</li>
                <li>Los precios pueden variar sin previo aviso.</li>
                <li>Se aceptan pagos en efectivo y mediante tarjetas de crédito/débito.</li>
            </ul>
        </div>

        <div class="term-card animate__animated animate__fadeInLeft">
            <h2 class="term-title">7. Modificaciones</h2>
            <p class="term-content">Nos reservamos el derecho de modificar estos términos y condiciones en cualquier momento. Los cambios serán efectivos inmediatamente después de su publicación en nuestra página web.</p>
        </div>

        <div class="term-card animate__animated animate__fadeInRight">
            <h2 class="term-title">8. Contacto</h2>
            <p class="term-content">Para cualquier consulta sobre estos términos y condiciones, puede contactarnos a través de nuestros canales oficiales de atención al cliente.</p>
        </div>
    </div>
</div>

<style>
.terms-container {
    padding: 40px 20px;
    max-width: 1000px;
    margin: 0 auto;
}

.term-card {
    background: #ffffff;
    border-radius: 10px;
    padding: 20px;
    margin-bottom: 30px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease;
}

.term-card:hover {
    transform: translateY(-5px);
}

.term-title {
    color: #333;
    font-size: 1.5rem;
    margin-bottom: 15px;
    border-bottom: 2px solid #007bff;
    padding-bottom: 10px;
}

.term-content {
    color: #666;
    line-height: 1.6;
}

.term-list {
    list-style-type: none;
    padding-left: 0;
}

.term-list li {
    margin-bottom: 10px;
    padding-left: 20px;
    position: relative;
}

.term-list li:before {
    content: "•";
    color: #007bff;
    position: absolute;
    left: 0;
}

@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

.animate__animated {
    animation-duration: 1s;
    animation-fill-mode: both;
}

.animate__fadeIn {
    animation-name: fadeIn;
}

.animate__fadeInLeft {
    animation-name: fadeInLeft;
}

.animate__fadeInRight {
    animation-name: fadeInRight;
}

.animate__slideInDown {
    animation-name: slideInDown;
}

@keyframes fadeInLeft {
    from {
        opacity: 0;
        transform: translate3d(-100%, 0, 0);
    }
    to {
        opacity: 1;
        transform: translate3d(0, 0, 0);
    }
}

@keyframes fadeInRight {
    from {
        opacity: 0;
        transform: translate3d(100%, 0, 0);
    }
    to {
        opacity: 1;
        transform: translate3d(0, 0, 0);
    }
}

@keyframes slideInDown {
    from {
        transform: translate3d(0, -100%, 0);
        visibility: visible;
    }
    to {
        transform: translate3d(0, 0, 0);
    }
}
</style>
