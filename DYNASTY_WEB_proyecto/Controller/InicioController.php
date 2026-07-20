<?php
    include_once $_SERVER['DOCUMENT_ROOT'] . '/Dynasty/DYNASTY_WEB_proyecto/Controller/UtilitarioController.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/Dynasty/DYNASTY_WEB_proyecto/Model/InicioModel.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/Dynasty/DYNASTY_WEB_proyecto/Model/UsuarioModel.php';

    if(isset($_POST["btnIniciarSesion"]))
    {
        $credencial = trim($_POST["credencial"]);
        $contrasena = $_POST["contrasena"];

        if($credencial == "" || $contrasena == "")
        {
            $_POST["Mensaje"] = "Debe ingresar sus credenciales completas.";
        }
        else
        {
            $datos = IniciarSesionModel($credencial);

            // Mensaje general: no revela cuál dato falló (RF01)
            if($datos && password_verify($contrasena, $datos["contrasena_hash"]))
            {
                $_SESSION["IdUsuario"] = $datos["id_usuario"];
                $_SESSION["Rol"] = $datos["nombre_rol"];
                $_SESSION["NombreUsuario"] = $datos["nombre"] . " " . $datos["apellidos"];
                $_SESSION["CorreoUsuario"] = $datos["correo"];
                $_SESSION["UltimaActividad"] = time();

                header("Location: ../../View/vInicio/Principal.php");
                exit();
            }

            $_POST["Mensaje"] = "Las credenciales ingresadas no son válidas.";
        }
    }

    if(isset($_POST["btnRecuperarAcceso"]))
    {
        $correo = trim($_POST["correo"]);

        if(!filter_var($correo, FILTER_VALIDATE_EMAIL))
        {
            $_POST["Mensaje"] = "Debe ingresar un correo electrónico válido.";
        }
        else
        {
            $usuario = ValidarCorreoModel($correo);

            if($usuario)
            {
                // Se genera una contraseña temporal y se envía por correo (patrón del curso)
                $contrasenaTemporal = generarContrasena();
                $contrasenaHash = password_hash($contrasenaTemporal, PASSWORD_DEFAULT);

                $resultado = ActualizarContrasenaModel($usuario["id_usuario"], $contrasenaHash);

                if($resultado)
                {
                    $plantilla = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/Dynasty/DYNASTY_WEB_proyecto/View/templates/Recuperacion.html');
                    $plantilla = str_replace("{{NOMBRE}}", $usuario["nombre"] . " " . $usuario["apellidos"], $plantilla);
                    $plantilla = str_replace("{{CONTRASENNA}}", $contrasenaTemporal, $plantilla);

                    EnviarCorreo("Dynasty - Recuperación de acceso", $plantilla, $correo);
                }
            }

            // Mensaje general: no revela si el correo existe o no (seguridad)
            $_POST["MensajeExito"] = "Si el correo está registrado, recibirá una contraseña temporal en su bandeja de entrada.";
        }
    }
