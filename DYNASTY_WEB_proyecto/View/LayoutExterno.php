<?php

function ImportCSS()
{
    echo '
        <head>
        <meta charset="UTF-8">
        <meta name="description" content="Dynasty - Sistema de gestión de rutinas">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Dynasty | Gestión de Rutinas</title>
        <link href="https://fonts.googleapis.com/css?family=Muli:300,400,500,600,700,800,900&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Oswald:300,400,500,600,700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="/Dynasty/DYNASTY_WEB_proyecto/css/bootstrap.min.css" type="text/css">
        <link rel="stylesheet" href="/Dynasty/DYNASTY_WEB_proyecto/css/font-awesome.min.css" type="text/css">
        <link rel="stylesheet" href="/Dynasty/DYNASTY_WEB_proyecto/css/style.css" type="text/css">
        <link rel="stylesheet" href="/Dynasty/DYNASTY_WEB_proyecto/css/practica1.css" type="text/css">
        <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.min.css">
        <link rel="stylesheet" href="/Dynasty/DYNASTY_WEB_proyecto/css/dynasty.css" type="text/css">
        </head>
    ';
}

function ImportJS()
{
    echo '
        <script src="/Dynasty/DYNASTY_WEB_proyecto/js/jquery-3.3.1.min.js"></script>
        <script src="/Dynasty/DYNASTY_WEB_proyecto/js/bootstrap.min.js"></script>
        <script src="https://cdn.datatables.net/2.1.8/js/dataTables.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="/Dynasty/DYNASTY_WEB_proyecto/js/dynasty.js"></script>
    ';
}

function HeaderExterno()
{
    echo '
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
                                <li><a href="/Dynasty/DYNASTY_WEB_proyecto/Inicio.php">Inicio</a></li>
                                <li class="active"><a href="/Dynasty/DYNASTY_WEB_proyecto/View/vInicio/IniciarSesion.php">Iniciar sesión</a></li>
                                <li><a href="/Dynasty/DYNASTY_WEB_proyecto/View/vInicio/RecuperarAcceso.php">Recuperar acceso</a></li>
                            </ul>
                        </nav>
                    </div>
                    <div class="col-lg-3"></div>
                </div>
            </div>
        </header>
    ';
}

function BreadcrumbExterno($titulo)
{
    echo '
        <section class="breadcrumb-section set-bg" data-setbg="/Dynasty/DYNASTY_WEB_proyecto/img/breadcrumb-bg.jpg" style="background-image: url(/Dynasty/DYNASTY_WEB_proyecto/img/breadcrumb-bg.jpg);">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <div class="breadcrumb-text">
                            <h2>' . $titulo . '</h2>
                            <div class="bt-option">
                                <a href="/Dynasty/DYNASTY_WEB_proyecto/Inicio.php">Inicio</a>
                                <span>' . $titulo . '</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    ';
}

function FooterExterno()
{
    echo '
        <section class="footer-section" style="padding: 30px 0;">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <div class="copyright-text">
                            <p>Dynasty &copy;<script>document.write(new Date().getFullYear());</script> | Universidad Fidélitas - Ambiente Web Cliente Servidor</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    ';
}

/**
 * Muestra los mensajes de exito o error de forma centralizada.
 * Evita repetir el mismo bloque de codigo en cada vista.
 *
 * @param array $exitos  Diccionario de codigos de exito y su mensaje.
 */
function Alertas($exitos = [])
{
    if(isset($_GET["exito"]))
    {
        $codigo  = $_GET["exito"];
        $mensaje = isset($exitos[$codigo]) ? $exitos[$codigo] : "Operacion realizada correctamente.";
        echo '<div class="alerta alerta-exito">' . $mensaje . '</div>';
    }

    if(isset($_GET["error"]))
    {
        echo '<div class="alerta alerta-error">No se pudo completar la operacion. Intente de nuevo.</div>';
    }

    if(isset($_POST["MensajeExito"]))
    {
        echo '<div class="alerta alerta-exito">' . $_POST["MensajeExito"] . '</div>';
    }

    if(isset($_POST["Mensaje"]))
    {
        echo '<div class="alerta alerta-error">' . $_POST["Mensaje"] . '</div>';
    }
}
