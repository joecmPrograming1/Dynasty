<?php
    include_once $_SERVER['DOCUMENT_ROOT'] . '/Dynasty/DYNASTY_WEB_proyecto/Controller/UsuarioController.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/Dynasty/DYNASTY_WEB_proyecto/View/LayoutInterno.php';

    $usuario = ConsultarUsuario();

    // Respaldo defensivo: si la consulta falla se usan los datos de la sesión
    if(!$usuario)
    {
        $usuario = [
            "identificacion" => "",
            "nombre"         => "",
            "apellidos"      => "",
            "correo"         => isset($_SESSION["CorreoUsuario"]) ? $_SESSION["CorreoUsuario"] : "",
            "telefono"       => ""
        ];
        $_POST["Mensaje"] = "No se pudieron cargar sus datos. Verifique que la base de datos esté actualizada (ejecute Dynasty_Update_Perfil.sql).";
    }
?>
<!DOCTYPE html>
<html lang="es">

<?php ImportCSS(); ?>

<body>

    <?php
        HeaderInterno();
        BreadcrumbInterno("Mi perfil");
    ?>

    <section class="seccion-sistema">
        <div class="container">

            <?php Alertas(); ?>

            <div class="row">
                <div class="col-lg-7">
                    <div class="form-sistema">
                        <h3>Información personal</h3>
                        <form action="" method="post">
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Identificación *</label>
                                    <input type="text" name="identificacion" maxlength="25" value="<?= htmlspecialchars($usuario["identificacion"]) ?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label>Teléfono</label>
                                    <input type="text" name="telefono" maxlength="20" value="<?= htmlspecialchars($usuario["telefono"]) ?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Nombre *</label>
                                    <input type="text" name="nombre" maxlength="80" value="<?= htmlspecialchars($usuario["nombre"]) ?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label>Apellidos *</label>
                                    <input type="text" name="apellidos" maxlength="120" value="<?= htmlspecialchars($usuario["apellidos"]) ?>" required>
                                </div>
                            </div>
                            <label>Correo electrónico *</label>
                            <input type="email" name="correo" maxlength="150" value="<?= htmlspecialchars($usuario["correo"]) ?>" required>
                            <button type="submit" name="btnCambiarPerfil" class="site-btn">Guardar cambios</button>
                        </form>
                    </div>
                </div>

                <div class="col-lg-5">
                    <div class="form-sistema">
                        <h3>Cambiar contraseña</h3>
                        <p class="nota-formulario">
                            Al cambiar su contraseña se cerrará la sesión y deberá ingresar de nuevo.
                        </p>
                        <form action="" method="post">
                            <label>Nueva contraseña *</label>
                            <div class="campo-password">
                                <input type="password" name="nuevaContrasena" minlength="6" required>
                                <i class="fa fa-eye ojito" onclick="alternarContrasena(this);"></i>
                            </div>
                            <label>Confirmar contraseña *</label>
                            <div class="campo-password">
                                <input type="password" name="confirmacion" minlength="6" required>
                                <i class="fa fa-eye ojito" onclick="alternarContrasena(this);"></i>
                            </div>
                            <button type="submit" name="btnCambiarContrasena" class="site-btn">Cambiar contraseña</button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <?php FooterExterno(); ?>

    <?php ImportJS(); ?>

</body>
</html>
