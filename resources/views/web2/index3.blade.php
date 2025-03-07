<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shalom - Servicio de Envíos</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background-color: #f5f5f5;
        }

        .header {
            background-color: #00ac3d;
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            color: white;
            font-weight: bold;
            font-size: 24px;
            text-transform: uppercase;
        }

        .nav-menu {
            display: flex;
            justify-content: center;
            gap: 20px;
            flex-wrap: wrap;
        }

        .nav-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            color: white;
            text-decoration: none;
            font-size: 14px;
            transition: color 0.3s ease;
        }

        .nav-item:hover {
            color: #ffcc00;
        }

        .nav-icon {
            font-size: 20px;
            margin-bottom: 5px;
        }

        .content {
            display: flex;
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .sidebar {
            width: 250px;
            margin-right: 20px;
        }

        .sidebar-item {
            padding: 15px 10px;
            display: flex;
            align-items: center;
            border-bottom: 1px solid #e0e0e0;
        }

        .sidebar-icon {
            margin-right: 10px;
            color: #00ac3d;
        }

        .main-content {
            flex: 1;
        }

        .promo-cards {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 15px;
            margin-bottom: 30px;
        }

        .promo-card {
            background-color: #fff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            height: 200px;
        }

        .promo-card img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .banner-container {
            display: flex;
            gap: 20px;
            margin-bottom: 30px;
        }

        .banner {
            flex: 1;
            background-color: #00ac3d;
            color: white;
            padding: 25px;
            border-radius: 10px;
            position: relative;
            overflow: hidden;
            min-height: 300px;
        }

        .banner.urgent {
            background-color: white;
            color: #333;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .banner-title {
            font-size: 24px;
            margin-bottom: 15px;
        }

        .banner-content {
            width: 60%;
        }

        .banner-image {
            position: absolute;
            right: 0;
            bottom: 0;
            width: 40%;
            height: 90%;
        }

        .banner-button {
            background-color: white;
            color: #00ac3d;
            padding: 8px 15px;
            border-radius: 20px;
            display: inline-block;
            margin-top: 15px;
            text-decoration: none;
        }

        .banner.urgent .banner-button {
            background-color: #00ac3d;
            color: white;
        }

        .footer {
            background-color: #f5f5f5;
            padding: 20px;
            text-align: center;
            border-top: 1px solid #e0e0e0;
        }

        .social-icons {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-top: 15px;
        }

        .social-icon {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background-color: #00ac3d;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .service-links {
            margin-top: 30px;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .service-link {
            color: #666;
            text-decoration: none;
            padding: 5px 0;
        }

        .chat-button {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background-color: #00ac3d;
            color: white;
            padding: 10px 20px;
            border-radius: 30px;
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.2);
        }

        .nuevo-badge {
            background-color: #00ac3d;
            color: white;
            font-size: 12px;
            padding: 2px 8px;
            border-radius: 10px;
            display: inline-block;
            margin-left: 10px;
        }

        .plus-icon,
        .arrow-icon {
            font-size: 18px;
            margin-left: auto;
        }
    </style>
</head>

<body>
    <!-- Header -->
    <div class="header">
        <div class="logo">Shalom</div>
        <div class="nav-menu">
            <a href="#" class="nav-item">
                <span class="nav-icon">
                    <svg width="20" height="20" fill="currentColor" class="bi bi-house-door" viewBox="0 0 16 16">
                        <path
                            d="M8.354 1.146a.5.5 0 0 0-.708 0l-6 6a.5.5 0 0 0 .708.708L2 7.207V13.5A1.5 1.5 0 0 0 3.5 15h9a1.5 1.5 0 0 0 1.5-1.5V7.207l.646.647a.5.5 0 0 0 .708-.708l-6-6zM13 13.5a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5V6.5h10v7z" />
                        <path d="M7.5 10.5v-3h1v3h-1z" />
                    </svg>
                </span>
                Inicio
            </a>
            <a href="#" class="nav-item">
                <span class="nav-icon">
                    <svg width="20" height="20" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                        <path
                            d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001a1 1 0 0 0 .198.196l3.85 3.85a1 1 0 0 0 1.415-1.415l-3.85-3.85a1 1 0 0 0-.196-.198zm-5.44 1.397a5.5 5.5 0 1 1 7.78-7.78 5.5 5.5 0 0 1-7.78 7.78z" />
                    </svg>
                </span>
                Rastrea
            </a>
            <a href="#" class="nav-item">
                <span class="nav-icon">
                    <svg width="20" height="20" fill="currentColor" class="bi bi-credit-card" viewBox="0 0 16 16">
                        <path
                            d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v1H0V4zM0 7v5a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7H0zm2 3a1 1 0 1 1 0-2 1 1 0 0 1 0 2z" />
                    </svg>
                </span>
                Págalo
            </a>
            <a href="#" class="nav-item">
                <span class="nav-icon">
                    <svg width="20" height="20" fill="currentColor" class="bi bi-geo-alt" viewBox="0 0 16 16">
                        <path
                            d="M12.166 8.94c-.26.35-.578.75-.93 1.17-.7.84-1.52 1.75-2.236 2.57-.716-.82-1.536-1.73-2.236-2.57-.352-.42-.67-.82-.93-1.17C4.78 7.92 4 6.68 4 5.5 4 3.57 5.57 2 7.5 2S11 3.57 11 5.5c0 1.18-.78 2.42-1.834 3.44zM7.5 1a4.5 4.5 0 0 0-4.5 4.5c0 1.68 1.1 3.18 2.166 4.44.26.35.578.75.93 1.17.7.84 1.52 1.75 2.236 2.57.716-.82 1.536-1.73 2.236-2.57.352-.42.67-.82.93-1.17C12.9 8.68 14 7.18 14 5.5A4.5 4.5 0 0 0 7.5 1z" />
                        <path d="M7.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3z" />
                    </svg>
                </span>
                Agencias
            </a>
            <a href="#" class="nav-item">
                <span class="nav-icon">
                    <svg width="20" height="20" fill="currentColor" class="bi bi-tag" viewBox="0 0 16 16">
                        <path d="M3 2a1 1 0 0 0-1 1v2.586l7 7L13.586 9l-7-7H3zm1 1h1.586l7 7L11 11.586l-7-7V3z" />
                        <path
                            d="M1 1a2 2 0 0 1 2-2h2.586a2 2 0 0 1 1.414.586l7 7a2 2 0 0 1 0 2.828l-4.586 4.586a2 2 0 0 1-2.828 0l-7-7A2 2 0 0 1 1 3.586V1z" />
                        <path d="M5.5 3a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z" />
                    </svg>
                </span>
                Tarifas
            </a>
        </div>
        <div class="nav-menu">
            <a href="#" class="nav-item">
                <span class="nav-icon">
                    <svg width="20" height="20" fill="currentColor" class="bi bi-cart" viewBox="0 0 16 16">
                        <path
                            d="M0 1a1 1 0 0 1 1-1h1.5a1 1 0 0 1 .98.804L3.89 4H14.5a1 1 0 0 1 .98 1.196l-1.5 8A1 1 0 0 1 13 14H4a1 1 0 0 1-.98-.804L1.61 2H1a1 1 0 0 1-1-1zm4.5 12a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3zm7 0a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3z" />
                    </svg>
                </span>
            </a>
            <a href="#" class="nav-item">
                <span class="nav-icon">
                    <svg width="20" height="20" fill="currentColor" class="bi bi-person" viewBox="0 0 16 16">
                        <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zM8 9a5 5 0 0 0-5 5v1h10v-1a5 5 0 0 0-5-5z" />
                    </svg>
                </span>
            </a>
        </div>
    </div>

    <!-- Content -->
    <div class="content">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="sidebar-item">
                <span class="sidebar-icon">🚚</span>
                <div>
                    Flota Shalom
                    <span class="nuevo-badge">NUEVO</span>
                </div>
            </div>
            <div class="sidebar-item">
                <span class="sidebar-icon">🔧</span>
                <div>Servicios</div>
                <span class="plus-icon">+</span>
            </div>
            <div class="sidebar-item">
                <span class="sidebar-icon">📦</span>
                <div>Envía</div>
                <span class="plus-icon">+</span>
            </div>
            <div class="sidebar-item">
                <span class="sidebar-icon">📋</span>
                <div>Shalom Informa</div>
                <span class="arrow-icon">›</span>
            </div>
            <div class="sidebar-item">
                <span class="sidebar-icon">❓</span>
                <div>Ayuda</div>
                <span class="plus-icon">+</span>
            </div>
            <div class="sidebar-item">
                <span class="sidebar-icon">📞</span>
                <div>Comunícate</div>
                <span class="plus-icon">+</span>
            </div>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Promotional Cards -->
            <div class="promo-cards">
                <div class="promo-card">
                    <img src="https://placehold.co/200x200/00ac3d/FFFFFF/png?text=Registrar+envío"
                        alt="Registrar envío">
                </div>
                <div class="promo-card">
                    <img src="https://placehold.co/200x200/00ac3d/FFFFFF/png?text=Autogestiones" alt="Autogestiones">
                </div>
                <div class="promo-card">
                    <img src="https://placehold.co/200x200/00ac3d/FFFFFF/png?text=Tips+para+envíos"
                        alt="Tips para envíos">
                </div>
                <div class="promo-card">
                    <img src="https://placehold.co/200x200/00ac3d/FFFFFF/png?text=Fraudes" alt="Fraudes">
                </div>
                <div class="promo-card">
                    <img src="https://placehold.co/200x200/00ac3d/FFFFFF/png?text=Controla+tus+envíos"
                        alt="Controla tus envíos">
                </div>
            </div>

            <!-- Banners -->
            <div class="banner-container">
                <div class="banner">
                    <div class="banner-content">
                        <div class="banner-title">Ahora puedes consultar el tiempo de llegada de un envío desde:</div>
                        <div>tarifas.shalom.pe</div>
                        <a href="#" class="banner-button">→</a>
                    </div>
                    <img src="https://placehold.co/150x280/00ac3d/FFFFFF/png?text=App+móvil" alt="App móvil"
                        class="banner-image">
                </div>
                <div class="banner urgent">
                    <div class="banner-content">
                        <div class="banner-title">¿Tienes envíos urgentes?</div>
                        <div>Registra aquí tus envíos aéreos</div>
                        <a href="#" class="banner-button">→</a>
                    </div>
                    <img src="https://placehold.co/150x280/FFFFFF/00ac3d/png?text=Mujer+con+paquetes"
                        alt="Mujer con paquetes" class="banner-image">
                </div>
            </div>




























</html>
</body> <a href="#" class="chat-button">Chat Shalom <span>💬</span></a> <!-- Chat Button -->
</div>
</div> <a href="#" class="social-icon">w</a> <a href="#" class="social-icon">t</a> <a href="#" class="social-icon">y</a>
<a href="#" class="social-icon">i</a> <a href="#" class="social-icon">f</a>
<div class="social-icons">
    <div>Proyecto Overskill © 2025</div>
    <div class="footer">
        <!-- Footer -->
    </div>
</div>
</div> <a href="#" class="service-link">Libro de reclamaciones</a> <a href="#" class="service-link">Términos y
    condiciones</a> <a href="#" class="service-link">Protege tus envíos</a> <a href="#" class="service-link">Destinos
    aéreos</a> <a href="#" class="service-link">Embalaje</a>
<div class="service-links">
    <!-- Service Links -->