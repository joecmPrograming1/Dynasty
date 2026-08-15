<?php
    include_once $_SERVER['DOCUMENT_ROOT'] . '/Dynasty/DYNASTY_WEB_proyecto/Controller/InicioController.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/Dynasty/DYNASTY_WEB_proyecto/View/LayoutExterno.php';

    // Si ya hay sesión activa se redirige al panel
    if(isset($_SESSION["IdUsuario"]))
    {
        header("Location: Principal.php");
        exit();
    }

    // Conserva lo digitado si el registro falla
    $v = isset($_POST["Datos"]) ? $_POST["Datos"] : [];
    function old($v, $k) { return isset($v[$k]) ? htmlspecialchars($v[$k]) : ""; }

    // Los niveles se consultan a la base de datos por medio del controlador
    $niveles = ConsultarNivelesRegistro();
?>
<!DOCTYPE html>
<html lang="es">

<?php ImportCSS(); ?>

<body>

    <?php
        HeaderExterno();
        BreadcrumbExterno("Crear cuenta");
    ?>

    <section class="contact-section spad auth-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 col-md-10">
                    <div class="section-title contact-title">
                        <span>Bienvenido a Dynasty</span>
                        <h2>Crear cuenta</h2>
                    </div>
                    <div class="auth-card">
                        <p>Regístrese con sus datos para acceder a sus rutinas y registrar su progreso. Su cuenta se crea automáticamente como cliente.</p>

                        <?php
                            if(isset($_POST["Mensaje"]))
                            {
                                echo '<div class="alerta alerta-error">' . $_POST["Mensaje"] . '</div>';
                            }
                        ?>

                        <form action="" method="post" id="formRegistrarse">
                            <div class="form-registro">
                                <div class="campo">
                                    <label>Identificación *</label>
                                    <input type="text" name="identificacion" maxlength="25" value="<?= old($v,'identificacion') ?>" required>
                                </div>
                                <div class="campo">
                                    <label>Nombre *</label>
                                    <input type="text" name="nombre" maxlength="80" value="<?= old($v,'nombre') ?>" required>
                                </div>
                                <div class="campo">
                                    <label>Apellidos *</label>
                                    <input type="text" name="apellidos" maxlength="120" value="<?= old($v,'apellidos') ?>" required>
                                </div>
                                <div class="campo">
                                    <label>Correo electrónico *</label>
                                    <input type="email" name="correo" maxlength="150" value="<?= old($v,'correo') ?>" required>
                                </div>
                                <div class="campo">
                                    <label>Teléfono</label>
                                    <input type="text" name="telefono" maxlength="20" value="<?= old($v,'telefono') ?>">
                                </div>
                                <div class="campo">
                                    <label>Contraseña *</label>
                                    <div class="campo-password">
                                        <input type="password" name="contrasena" minlength="6" required>
                                        <i class="fa fa-eye ojito" onclick="alternarContrasena(this);"></i>
                                    </div>
                                </div>
                                <div class="campo">
                                    <label>Objetivo principal *</label>
                                    <input type="text" name="objetivo" maxlength="180" value="<?= old($v,'objetivo') ?>" placeholder="Ej: Bajar de peso" required>
                                </div>
                                <div class="campo">
                                    <label>Nivel *</label>
                                    <select name="nivel" required>
                                        <?php foreach($niveles as $n): ?>
                                            <option value="<?= $n['codigo_nivel'] ?>" <?= old($v,'nivel')==$n['codigo_nivel']?'selected':'' ?>><?= $n['descripcion'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="campo">
                                    <label>Disponibilidad semanal *</label>
                                    <input type="text" name="disponibilidad" maxlength="120" value="<?= old($v,'disponibilidad') ?>" placeholder="Ej: 3 días por semana" required>
                                </div>
                                <div class="campo col-full">
                                    <label>Observaciones</label>
                                    <textarea name="observaciones" maxlength="500"><?= old($v,'observaciones') ?></textarea>
                                </div>
                            </div>

                            <button type="submit" name="btnRegistrarse" class="site-btn">Crear cuenta</button>
                        </form>

                        <div class="auth-links">
                            <a href="IniciarSesion.php">¿Ya tiene cuenta? Inicie sesión</a>
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
