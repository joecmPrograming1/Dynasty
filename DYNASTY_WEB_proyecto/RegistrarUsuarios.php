<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Plantilla Práctica 1">
    <meta name="keywords" content="HTML, CSS, JS, Bootstrap, PHP">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dynasty | Registro de usuarios</title>

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
    <link rel="stylesheet" href="css/practica1.css" type="text/css">
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
        <div class="canvas-search search-switch">
            <i class="fa fa-search"></i>
        </div>
        <nav class="canvas-menu mobile-menu">
            <ul>
                <li><a href="./Inicio.php">Inicio</a></li>
                <li><a href="./IniciarSesion.php">Iniciar sesión</a></li>
                <li class="active"><a href="./RegistrarUsuarios.php">Registro</a></li>
                <li><a href="./RecuperarAcceso.php">Recuperar acceso</a></li>
            </ul>
        </nav>
        <div id="mobile-menu-wrap"></div>
        <div class="canvas-social">
            <a href="#"><i class="fa fa-facebook"></i></a>
            <a href="#"><i class="fa fa-twitter"></i></a>
            <a href="#"><i class="fa fa-youtube-play"></i></a>
            <a href="#"><i class="fa fa-instagram"></i></a>
        </div>
    </div>
    <!-- Offcanvas Menu Section End -->

    <!-- Header Section Begin -->
    <header class="header-section">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3">
                    <div class="logo">
                        <a href="./Inicio.php" class="logo-text">DYNASTY</a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <nav class="nav-menu">
                        <ul>
                            <li><a href="./Inicio.php">Inicio</a></li>
                            <li><a href="./IniciarSesion.php">Iniciar sesión</a></li>
                            <li class="active"><a href="./RegistrarUsuarios.php">Registro</a></li>
                            <li><a href="./RecuperarAcceso.php">Recuperar acceso</a></li>
                        </ul>
                    </nav>
                </div>
                <div class="col-lg-3">
                    <div class="top-option">
                        <div class="to-search search-switch">
                            <i class="fa fa-search"></i>
                        </div>
                        <div class="to-social">
                            <a href="#"><i class="fa fa-facebook"></i></a>
                            <a href="#"><i class="fa fa-twitter"></i></a>
                            <a href="#"><i class="fa fa-youtube-play"></i></a>
                            <a href="#"><i class="fa fa-instagram"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="canvas-open">
                <i class="fa fa-bars"></i>
            </div>
        </div>
    </header>
    <!-- Header End -->

    <!-- Breadcrumb Section Begin -->
    <section class="breadcrumb-section set-bg" data-setbg="img/breadcrumb-bg.jpg">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="breadcrumb-text">
                        <h2>Registro de usuarios</h2>
                        <div class="bt-option">
                            <a href="./Inicio.php">Inicio</a>
                            <span>Registro de usuarios</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- Form Section Begin -->
    <section class="contact-section spad auth-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6 col-md-8">
                    <div class="section-title contact-title">
                        <span>Lorem ipsum</span>
                        <h2>Registro de usuarios</h2>
                    </div>
                    <div class="auth-card">
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore.</p>
                        <form action="#" method="post" onsubmit="return mostrarMensaje(event);">
                            
                            <input type="text" name="nombre" placeholder="Nombre completo" required>
                            <input type="email" name="correo" placeholder="Correo electrónico" required>
                            <input type="text" name="usuario" placeholder="Usuario" required>
                            <input type="password" name="contrasena" placeholder="Contraseña" required>
                            <input type="password" name="confirmar" placeholder="Confirmar contraseña" required>

                            <button type="submit" class="site-btn">Registrar</button>
                        </form>
                        <div class="auth-links">
                            
                            <a href="./IniciarSesion.php">Ya tengo cuenta</a>
                            <a href="./RecuperarAcceso.php">Recuperar acceso</a>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Form Section End -->

    <!-- Get In Touch Section Begin -->
    <div class="gettouch-section">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <div class="gt-text">
                        <i class="fa fa-map-marker"></i>
                        <p>Lorem ipsum dolor sit amet,<br/> consectetur adipiscing elit.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="gt-text">
                        <i class="fa fa-mobile"></i>
                        <ul>
                            <li>Lorem ipsum</li>
                            <li>Dolor sit amet</li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="gt-text email">
                        <i class="fa fa-envelope"></i>
                        <p>lorem@ipsum.com</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Get In Touch Section End -->

    <!-- Footer Section Begin -->
    <section class="footer-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-4">
                    <div class="fs-about">
                        <a href="./Inicio.php" class="footer-logo-text">DYNASTY</a>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                        <div class="fa-social">
                            <a href="#"><i class="fa fa-facebook"></i></a>
                            <a href="#"><i class="fa fa-twitter"></i></a>
                            <a href="#"><i class="fa fa-youtube-play"></i></a>
                            <a href="#"><i class="fa fa-instagram"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-3 col-sm-6">
                    <div class="fs-widget">
                        <h4>Lorem</h4>
                        <ul>
                            <li><a href="#">Lorem ipsum</a></li>
                            <li><a href="#">Dolor sit</a></li>
                            <li><a href="#">Amet elit</a></li>
                            <li><a href="#">Tempor</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-2 col-md-3 col-sm-6">
                    <div class="fs-widget">
                        <h4>Ipsum</h4>
                        <ul>
                            <li><a href="#">Lorem ipsum</a></li>
                            <li><a href="#">Dolor sit</a></li>
                            <li><a href="#">Amet elit</a></li>
                            <li><a href="#">Tempor</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="fs-widget">
                        <h4>Lorem ipsum</h4>
                        <div class="fw-recent">
                            <h6><a href="#">Lorem ipsum dolor sit amet consectetur.</a></h6>
                            <ul>
                                <li>Lorem</li>
                                <li>Ipsum</li>
                            </ul>
                        </div>
                        <div class="fw-recent">
                            <h6><a href="#">Sed do eiusmod tempor incididunt.</a></h6>
                            <ul>
                                <li>Lorem</li>
                                <li>Ipsum</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="copyright-text">
                        <p>Lorem ipsum &copy;<script>document.write(new Date().getFullYear());</script> Lorem ipsum dolor sit amet.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Footer Section End -->

    <!-- Search model Begin -->
    <div class="search-model">
        <div class="h-100 d-flex align-items-center justify-content-center">
            <div class="search-close-switch">+</div>
            <form class="search-model-form">
                <input type="text" id="search-input" placeholder="Lorem ipsum...">
            </form>
        </div>
    </div>
    <!-- Search model end -->

    <!-- Js Plugins -->
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.magnific-popup.min.js"></script>
    <script src="js/masonry.pkgd.min.js"></script>
    <script src="js/jquery.barfiller.js"></script>
    <script src="js/jquery.slicknav.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/main.js"></script>
    <script src="js/practica1.js"></script>
</body>

</html>
