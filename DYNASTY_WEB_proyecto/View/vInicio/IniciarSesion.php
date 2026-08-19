<?php
/* ============================================================
 * Proyecto : Dynasty - Sistema de gestion de rutinas
 * Curso    : Ambiente Web Cliente/Servidor (SC-502)
 * Archivo  : IniciarSesion.php
 * Proposito: Vista de ingreso. Formulario de inicio de sesion.
 * ============================================================ */

    include_once $_SERVER['DOCUMENT_ROOT'] . '/Dynasty/DYNASTY_WEB_proyecto/Controller/InicioController.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/Dynasty/DYNASTY_WEB_proyecto/View/LayoutExterno.php';

    // Si ya hay sesión activa se redirige al panel
    if(isset($_SESSION["IdUsuario"]))
    {
        header("Location: Principal.php");
        exit();
    }
?>
<!DOCTYPE html>
<html lang="es">

<?php ImportCSS(); ?>

<body>

    <?php
        HeaderExterno();
        BreadcrumbExterno("Iniciar sesión");
    ?>

    <section class="contact-section spad auth-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6 col-md-8">
                    <div class="section-title contact-title">
                        <span>Bienvenido a Dynasty</span>
                        <h2>Iniciar sesión</h2>
                    </div>
                    <div class="auth-card">
                        <p>Ingrese su identificación o correo electrónico y su contraseña para acceder al sistema.</p>

                        <?php
                            Alertas([
                                "salida"   => "Ha cerrado sesión correctamente.",
                                "registro" => "Su cuenta se creó correctamente. Ya puede iniciar sesión."
                            ]);
                        ?>

                        <form action="" method="post" id="formIniciarSesion">
                            <input type="text" name="credencial" placeholder="Identificación o correo electrónico" required>
                            <div class="campo-password">
                                <input type="password" name="contrasena" placeholder="Contraseña" required>
                                <i class="fa fa-eye ojito" onclick="alternarContrasena(this);"></i>
                            </div>
                            <button type="submit" name="btnIniciarSesion" class="site-btn">Ingresar</button>
                        </form>

                        <div class="auth-links">
                            <a href="Registrarse.php">¿No tiene cuenta? Regístrese</a>
                            <a href="RecuperarAcceso.php">¿Olvidó su contraseña?</a>
                            <a href="/Dynasty/DYNASTY_WEB_proyecto/Inicio.php">Volver al inicio</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php FooterExterno(); ?>

    <?php ImportJS(); ?>

</body>
</html>
