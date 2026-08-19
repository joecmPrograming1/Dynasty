<?php
/* ============================================================
 * Proyecto : Dynasty - Sistema de gestion de rutinas
 * Curso    : Ambiente Web Cliente/Servidor (SC-502)
 * Archivo  : RecuperarAcceso.php
 * Proposito: Vista de recuperacion. Solicitud de contrasena temporal por correo.
 * ============================================================ */

    include_once $_SERVER['DOCUMENT_ROOT'] . '/Dynasty/DYNASTY_WEB_proyecto/Controller/InicioController.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/Dynasty/DYNASTY_WEB_proyecto/View/LayoutExterno.php';
?>
<!DOCTYPE html>
<html lang="es">

<?php ImportCSS(); ?>

<body>

    <?php
        HeaderExterno();
        BreadcrumbExterno("Recuperar acceso");
    ?>

    <section class="contact-section spad auth-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6 col-md-8">
                    <div class="section-title contact-title">
                        <span>Dynasty</span>
                        <h2>Recuperar acceso</h2>
                    </div>
                    <div class="auth-card">
                        <p>Ingrese el correo electrónico de su cuenta. Le enviaremos una contraseña temporal para que pueda ingresar de nuevo.</p>

                        <?php Alertas(); ?>

                        <form action="" method="post">
                            <input type="email" name="correo" placeholder="Correo electrónico" required>
                            <button type="submit" name="btnRecuperarAcceso" class="site-btn">Enviar contraseña temporal</button>
                        </form>

                        <div class="auth-links">
                            <a href="IniciarSesion.php">Volver a iniciar sesión</a>
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
