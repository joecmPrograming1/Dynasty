<?php
    include_once $_SERVER['DOCUMENT_ROOT'] . '/Dynasty/DYNASTY_WEB_proyecto/View/LayoutExterno.php';

function HeaderInterno()
{
    $rol = isset($_SESSION["Rol"]) ? $_SESSION["Rol"] : "";
    $nombre = isset($_SESSION["NombreUsuario"]) ? $_SESSION["NombreUsuario"] : "";

    $menu = '<li><a href="/Dynasty/DYNASTY_WEB_proyecto/View/vInicio/Principal.php">Principal</a></li>';

    if($rol == "ADMINISTRADOR")
    {
        $menu .= '<li><a href="/Dynasty/DYNASTY_WEB_proyecto/View/vCliente/GestionClientes.php">Clientes</a></li>';
        $menu .= '<li><a href="/Dynasty/DYNASTY_WEB_proyecto/View/vEjercicio/GestionEjercicios.php">Ejercicios</a></li>';
    }

    $menu .= '<li><a href="/Dynasty/DYNASTY_WEB_proyecto/View/vUsuario/MiPerfil.php">Mi perfil</a></li>';

    echo '
        <header class="header-section">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-3">
                        <div class="logo">
                            <a href="/Dynasty/DYNASTY_WEB_proyecto/View/vInicio/Principal.php" class="logo-text">DYNASTY</a>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <nav class="nav-menu">
                            <ul>' . $menu . '</ul>
                        </nav>
                    </div>
                    <div class="col-lg-3">
                        <div class="top-option">
                            <div class="usuario-sesion">
                                <span class="usuario-nombre"><i class="fa fa-user"></i> ' . htmlspecialchars($nombre) . '</span>
                                <a class="cerrar-sesion" href="/Dynasty/DYNASTY_WEB_proyecto/Controller/UtilitarioController.php?accion=salir">Cerrar sesión</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>
    ';
}

function BreadcrumbInterno($titulo)
{
    echo '
        <section class="breadcrumb-section set-bg breadcrumb-interno" style="background-image: url(/Dynasty/DYNASTY_WEB_proyecto/img/breadcrumb-bg.jpg); position: relative;">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <div class="breadcrumb-text">
                            <h2>' . $titulo . '</h2>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    ';
}
