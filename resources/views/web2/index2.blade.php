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
            font-family: 'Arial', sans-serif;
        }

        body {
            background-color: #f5f5f5;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* Header Styles */
        header {
            background-color: #ee2728;
            padding: 15px 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: white;
            width: 100%;
        }

        .logo-container {
            margin-left: 20px;
        }

        .logo {
            font-weight: bold;
            font-size: 28px;
            color: white;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .nav-container {
            display: flex;
            align-items: center;
            justify-content: space-around;
            width: 70%;
        }

        .nav-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            cursor: pointer;
        }

        .nav-item i {
            font-size: 24px;
            margin-bottom: 5px;
        }

        .nav-item span {
            font-size: 14px;
        }

        .cart-profile {
            display: flex;
            margin-right: 20px;
        }

        .cart, .profile {
            font-size: 24px;
            margin-left: 20px;
            cursor: pointer;
        }

        .profile-count {
            background: #333;
            color: white;
            border-radius: 50%;
            padding: 2px 6px;
            font-size: 12px;
            position: relative;
            top: -10px;
            right: 10px;
        }

        /* Section Layout Styles */
        .section-one {
            display: flex;
            width: 100%;
        }

        .section-two, .section-three {
            width: 100%;
            padding: 20px;
            display: flex;
            justify-content: center;
        }

        /* Sidebar Styles */
        aside.sidebar {
            width: 250px;
            background-color: white;
            padding: 20px;
            position: sticky;
            top: 0;
            height: 100vh;
            overflow-y: auto;
        }

        .sidebar-section {
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #eee;
        }

        .sidebar-icon {
            color: #ee2728;
            font-size: 20px;
            margin-right: 10px;
        }

        .plus-icon {
            color: #999;
            cursor: pointer;
        }

        .new-badge {
            background-color: #ee2728;
            color: white;
            padding: 2px 6px;
            border-radius: 12px;
            font-size: 10px;
            text-transform: uppercase;
            margin-left: 10px;
        }

        /* Main Content Styles - Updated for 20%/80% layout */
        .main-content {
            display: flex;
            flex: 1;
        }

        .main-left {
            width: 20%;
            padding: 20px;
            background-color: #f9f9f9;
        }

        .main-right {
            width: 80%;
            padding: 20px;
        }

        /* Carousel - Updated for 40px x 60px items */
        .carousel {
            display: flex;
            overflow-x: auto;
            gap: 10px;
            padding-bottom: 20px;
            -ms-overflow-style: none;
            scrollbar-width: none;
            width: 100%;
            justify-content: flex-start;
        }

        .carousel::-webkit-scrollbar {
            display: none;
        }

        .carousel-card {
            width: 40px;
            height: 60px;
            background-color: white;
            border-radius: 5px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            position: relative;
        }

        .carousel-card img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .arrow-button {
            position: absolute;
            right: 5px;
            bottom: 5px;
            background-color: #ee2728;
            color: white;
            width: 15px;
            height: 15px;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            cursor: pointer;
            font-size: 8px;
        }

        .feature-boxes {
            display: flex;
            gap: 20px;
            width: 100%;
            justify-content: center;
        }

        .feature-box {
            flex: 1;
            background-color: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            padding: 20px;
            position: relative;
            max-width: 45%;
            min-height: 250px;
        }

        .feature-box.red {
            background-color: #ee2728;
            color: white;
        }

        .feature-box h3 {
            margin-bottom: 15px;
            font-size: 18px;
        }

        .feature-box p {
            font-size: 14px;
            margin-bottom: 10px;
        }

        .feature-box img {
            position: absolute;
            bottom: 0;
            right: 0;
            width: 150px;
            height: auto;
        }

        .app-screenshot {
            width: 50%;
            margin: 0 auto;
            display: block;
        }

        .tarifa-button {
            background-color: white;
            padding: 8px 15px;
            border-radius: 20px;
            display: inline-block;
            margin-top: 10px;
            color: #ee2728;
            text-decoration: none;
            font-weight: bold;
        }

        .footer-links {
            width: 100%;
            text-align: center;
        }

        .footer-links ul {
            list-style: none;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
        }

        .footer-links li {
            margin-bottom: 10px;
        }

        .footer-links a {
            color: #666;
            text-decoration: none;
        }

        .footer {
            text-align: center;
            padding: 20px;
            color: #999;
            font-size: 12px;
            width: 100%;
        }

        .social-icons {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-top: 20px;
        }

        .social-icon {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background-color: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
            color: #ee2728;
            font-size: 16px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .chat-button {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background-color: #ee2728;
            color: white;
            padding: 10px 20px;
            border-radius: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
            box-shadow: 0 2px 4px rgba(0,0,0,0.2);
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <header>
        <div class="logo-container">
            <div class="logo">SHALOM</div>
        </div>
        <div class="nav-container">
            <div class="nav-item">
                <i class="fas fa-home"></i>
                <span>Inicio</span>
            </div>
            <div class="nav-item">
                <i class="fas fa-search"></i>
                <span>Rastrea</span>
            </div>
            <div class="nav-item">
                <i class="fas fa-money-bill"></i>
                <span>Pägalo</span>
            </div>
            <div class="nav-item">
                <i class="fas fa-map-marker-alt"></i>
                <span>Agencias</span>
            </div>
            <div class="nav-item">
                <i class="fas fa-tag"></i>
                <span>Tarifas</span>
            </div>
        </div>
        <div class="cart-profile">
            <div class="cart">
                <i class="fas fa-shopping-cart"></i>
            </div>
            <div class="profile">
                <i class="fas fa-user"></i>
                <span class="profile-count">1</span>
            </div>
        </div>
    </header>

    <!-- Section 1: Contains the sidebar (as an aside) and restructured main-content -->
    <section class="section-one">
        <aside class="sidebar">
            <div class="sidebar-section">
                <div style="display: flex; align-items: center;">
                    <span>Flota Shalom</span>
                    <span class="new-badge">nuevo</span>
                </div>
                <i class="fas fa-chevron-right plus-icon"></i>
            </div>
            <div class="sidebar-section">
                <div style="display: flex; align-items: center;">
                    <i class="fas fa-box sidebar-icon"></i>
                    <span>Servicios</span>
                </div>
                <i class="fas fa-plus plus-icon"></i>
            </div>
            <div class="sidebar-section">
                <div style="display: flex; align-items: center;">
                    <i class="fas fa-paper-plane sidebar-icon"></i>
                    <span>Envía</span>
                </div>
                <i class="fas fa-plus plus-icon"></i>
            </div>
            <div class="sidebar-section">
                <div style="display: flex; align-items: center;">
                    <i class="fas fa-info-circle sidebar-icon"></i>
                    <span>Shalom Informa</span>
                </div>
                <i class="fas fa-chevron-right plus-icon"></i>
            </div>
            <div class="sidebar-section">
                <div style="display: flex; align-items: center;">
                    <i class="fas fa-question-circle sidebar-icon"></i>
                    <span>Ayuda</span>
                </div>
                <i class="fas fa-plus plus-icon"></i>
            </div>
            <div class="sidebar-section">
                <div style="display: flex; align-items: center;">
                    <i class="fas fa-comments sidebar-icon"></i>
                    <span>Comunicate</span>
                </div>
                <i class="fas fa-plus plus-icon"></i>
            </div>
        </aside>

        <div class="main-content">
            <!-- Left part (20%) -->
            <div class="main-left">
                <h3>Información</h3>
                <p>Consulta sobre nuestros servicios de envío y recepción de paquetes.</p>
                <img src="/api/placeholder/100/120" alt="Información de Envíos">
            </div>
            
            <!-- Right part (80%) -->
            <div class="main-right">
                <h2>Servicios Populares</h2>
                <div class="carousel">
                    <!-- 5 carousel items at 40px x 60px -->
                    <div class="carousel-card">
                        <img src="/api/placeholder/40/60" alt="Servicio 1">
                        <div class="arrow-button">
                            <i class="fas fa-arrow-right"></i>
                        </div>
                    </div>
                    <div class="carousel-card">
                        <img src="/api/placeholder/40/60" alt="Servicio 2">
                        <div class="arrow-button">
                            <i class="fas fa-arrow-right"></i>
                        </div>
                    </div>
                    <div class="carousel-card">
                        <img src="/api/placeholder/40/60" alt="Servicio 3">
                        <div class="arrow-button">
                            <i class="fas fa-arrow-right"></i>
                        </div>
                    </div>
                    <div class="carousel-card">
                        <img src="/api/placeholder/40/60" alt="Servicio 4">
                        <div class="arrow-button">
                            <i class="fas fa-arrow-right"></i>
                        </div>
                    </div>
                    <div class="carousel-card">
                        <img src="/api/placeholder/40/60" alt="Servicio 5">
                        <div class="arrow-button">
                            <i class="fas fa-arrow-right"></i>
                        </div>
                    </div>
                </div>
                
                <h2 style="margin-top: 20px;">Noticias y Actualizaciones</h2>
                <p>Manténgase informado sobre nuestros servicios y promociones especiales.</p>
                <img src="/api/placeholder/400/200" alt="Noticias Shalom" style="width: 100%; margin-top: 10px; border-radius: 8px;">
            </div>
        </div>
    </section>

    <!-- Section 2: Contains the feature boxes -->
    <section class="section-two">
        <div class="feature-boxes">
            <div class="feature-box red">
                <h3>Ahora puedes consultar el tiempo de llegada de un envío desde:</h3>
                <a href="#" class="tarifa-button">tarifas.shalom.pe</a>
                <img src="/api/placeholder/150/200" alt="App Screenshot" class="app-screenshot">
                <div class="arrow-button">
                    <i class="fas fa-arrow-right"></i>
                </div>
            </div>
            <div class="feature-box">
                <h3>¿Tienes envíos urgentes?</h3>
                <p>Registra aquí tus envíos aéreos</p>
                <img src="/api/placeholder/150/200" alt="Woman with Packages">
                <div class="arrow-button">
                    <i class="fas fa-arrow-right"></i>
                </div>
            </div>
        </div>
    </section>

    <!-- Section 3: Contains the footer links -->
    <section class="section-three">
        <div class="footer-links">
            <ul>
                <li><a href="#">Embalaje</a></li>
                <li><a href="#">Destinos aéreos</a></li>
                <li><a href="#">Protege tus envíos</a></li>
                <li><a href="#">Términos y condiciones</a></li>
                <li><a href="#">Libro de reclamaciones</a></li>
            </ul>
        </div>
    </section>

    <div class="footer">
        <div class="social-icons">
            <a href="#" class="social-icon"><i class="fab fa-facebook-f"></i></a>
            <a href="#" class="social-icon"><i class="fab fa-instagram"></i></a>
            <a href="#" class="social-icon"><i class="fab fa-youtube"></i></a>
            <a href="#" class="social-icon"><i class="fab fa-tiktok"></i></a>
            <a href="#" class="social-icon"><i class="fab fa-whatsapp"></i></a>
        </div>
        <p>Proyecto Overskill © 2025</p>
    </div>

    <div class="chat-button">
        <i class="fas fa-comments"></i>
        <span>Chat Shalom</span>
    </div>
</body>
</html>