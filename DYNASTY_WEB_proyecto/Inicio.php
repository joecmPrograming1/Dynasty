<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Dynasty - Sistema web de gestión y seguimiento de rutinas personalizadas">
    <meta name="keywords" content="rutinas, entrenamiento, gimnasio, seguimiento, PHP">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dynasty | Gestión de Rutinas Personalizadas</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css?family=Muli:300,400,500,600,700,800,900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Oswald:300,400,500,600,700&display=swap" rel="stylesheet">

    <!-- Css Styles -->
    <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="css/font-awesome.min.css" type="text/css">
    <link rel="stylesheet" href="css/flaticon.css" type="text/css">
    <link rel="stylesheet" href="css/owl.carousel.min.css" type="text/css">
    <link rel="stylesheet" href="css/barfiller.css" type="text/css">
    <link rel="stylesheet" href="css/magnific-popup.css" type="text/css">
    <link rel="stylesheet" href="css/slicknav.min.css" type="text/css">
    <link rel="stylesheet" href="css/style.css" type="text/css">
    <link rel="stylesheet" href="css/dynasty.css" type="text/css">
</head>

<body>
    <!-- Page Preloder -->
    <div id="preloder">
        <div class="loader"></div>
    </div>

    <!-- Offcanvas Menu Section Begin -->
    <div class="offcanvas-menu-overlay"></div>
    <div class="offcanvas-menu-wrapper">
        <div class="canvas-close">
            <i class="fa fa-close"></i>
        </div>
        <nav class="canvas-menu mobile-menu">
            <ul>
                <li class="active"><a href="/Dynasty/DYNASTY_WEB_proyecto/Inicio.php">Inicio</a></li>
                <li><a href="/Dynasty/DYNASTY_WEB_proyecto/View/vInicio/IniciarSesion.php">Iniciar sesión</a></li>
                <li><a href="/Dynasty/DYNASTY_WEB_proyecto/View/vInicio/RecuperarAcceso.php">Recuperar acceso</a></li>
            </ul>
        </nav>
        <div id="mobile-menu-wrap"></div>
    </div>
    <!-- Offcanvas Menu Section End -->

    <!-- Header Section Begin -->
    <header class="header-section">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3">
                    <div class="logo">
                        <a href="/Dynasty/DYNASTY_WEB_proyecto/Inicio.php" class="logo-text">DYNASTY</a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <nav class="nav-menu">
                        <ul>
                            <li class="active"><a href="/Dynasty/DYNASTY_WEB_proyecto/Inicio.php">Inicio</a></li>
                            <li><a href="/Dynasty/DYNASTY_WEB_proyecto/View/vInicio/IniciarSesion.php">Iniciar sesión</a></li>
                            <li><a href="/Dynasty/DYNASTY_WEB_proyecto/View/vInicio/RecuperarAcceso.php">Recuperar acceso</a></li>
                        </ul>
                    </nav>
                </div>
                <div class="col-lg-3"></div>
            </div>
            <div class="canvas-open">
                <i class="fa fa-bars"></i>
            </div>
        </div>
    </header>
    <!-- Header End -->

    <!-- Hero Section Begin -->
    <section class="hero-section">
        <div class="hs-slider owl-carousel">
            <div class="hs-item set-bg" data-setbg="img/hero/hero-1.jpg">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-6 offset-lg-6">
                            <div class="hi-text">
                                <span>Entrena con propósito</span>
                                <h1>Tu rutina, <strong>tu progreso</strong>, un solo lugar</h1>
                                <a href="/Dynasty/DYNASTY_WEB_proyecto/View/vInicio/IniciarSesion.php" class="primary-btn">Iniciar sesión</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="hs-item set-bg" data-setbg="img/hero/hero-2.jpg">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-6 offset-lg-6">
                            <div class="hi-text">
                                <span>Seguimiento real</span>
                                <h1>Cada entrenamiento <strong>cuenta</strong></h1>
                                <a href="/Dynasty/DYNASTY_WEB_proyecto/View/vInicio/IniciarSesion.php" class="primary-btn">Iniciar sesión</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Hero Section End -->

    <!-- ChoseUs Section Begin -->
    <section class="choseus-section spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title">
                        <span>¿Qué es Dynasty?</span>
                        <h2>Gestión y seguimiento de rutinas personalizadas</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3 col-sm-6">
                    <div class="cs-item">
                        <span class="flaticon-034-stationary-bike"></span>
                        <h4>Clientes organizados</h4>
                        <p>El entrenador registra y administra a cada cliente con su perfil deportivo: objetivo, nivel y disponibilidad.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="cs-item">
                        <span class="flaticon-033-juice"></span>
                        <h4>Catálogo de ejercicios</h4>
                        <p>Ejercicios reutilizables clasificados por categoría, con descripción y equipo requerido para construir rutinas.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="cs-item">
                        <span class="flaticon-002-dumbell"></span>
                        <h4>Rutinas personalizadas</h4>
                        <p>Plantillas de rutina con series, repeticiones, descansos e indicaciones, asignadas a cada cliente según su meta.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="cs-item">
                        <span class="flaticon-014-heart-beat"></span>
                        <h4>Progreso visible</h4>
                        <p>El cliente registra sus entrenamientos y el entrenador da retroalimentación para mantener la motivación.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ChoseUs Section End -->

    <!-- Banner Section Begin -->
    <section class="banner-section set-bg" data-setbg="img/banner-bg.jpg">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="bs-text">
                        <h2>Organice su entrenamiento hoy mismo</h2>
                        <div class="bt-tips">Ingrese al sistema con las credenciales suministradas por su entrenador.</div>
                        <a href="/Dynasty/DYNASTY_WEB_proyecto/View/vInicio/IniciarSesion.php" class="primary-btn btn-normal">Iniciar sesión</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Banner Section End -->

    <!-- Footer Section Begin -->
    <section class="footer-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-4">
                    <div class="fs-about">
                        <a href="/Dynasty/DYNASTY_WEB_proyecto/Inicio.php" class="footer-logo-text">DYNASTY</a>
                        <p>Sistema web para la gestión y el seguimiento de rutinas personalizadas. Proyecto del curso Ambiente Web Cliente Servidor.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="fs-widget">
                        <h4>Accesos</h4>
                        <ul>
                            <li><a href="/Dynasty/DYNASTY_WEB_proyecto/View/vInicio/IniciarSesion.php">Iniciar sesión</a></li>
                            <li><a href="/Dynasty/DYNASTY_WEB_proyecto/View/vInicio/RecuperarAcceso.php">Recuperar acceso</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="fs-widget">
                        <h4>Equipo de desarrollo</h4>
                        <ul>
                            <li>Joseth Cespedes Moya</li>
                            <li>Victor Cespedes Moya</li>
                            <li>Isaac Alfaro Badilla</li>
                            <li>Jocelyn Matamoros</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="copyright-text">
                        <p>Dynasty &copy;<script>document.write(new Date().getFullYear());</script> | Universidad Fidélitas &mdash; Ambiente Web Cliente Servidor</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Footer Section End -->

    <!-- Js Plugins -->
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.magnific-popup.min.js"></script>
    <script src="js/masonry.pkgd.min.js"></script>
    <script src="js/jquery.barfiller.js"></script>
    <script src="js/jquery.slicknav.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/main.js"></script>
</body>

</html>
