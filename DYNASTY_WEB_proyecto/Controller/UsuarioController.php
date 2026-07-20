<?php
    include_once $_SERVER['DOCUMENT_ROOT'] . '/Dynasty/DYNASTY_WEB_proyecto/Controller/UtilitarioController.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/Dynasty/DYNASTY_WEB_proyecto/Model/UsuarioModel.php';

    ValidarSesion();

    if(isset($_POST["btnCambiarPerfil"]))
    {
        $idUsuario      = $_SESSION["IdUsuario"];
        $identificacion = trim($_POST["identificacion"]);
        $nombre         = trim($_POST["nombre"]);
        $apellidos      = trim($_POST["apellidos"]);
        $correo         = trim($_POST["correo"]);
        $telefono       = trim($_POST["telefono"]);

        if($identificacion == "" || $nombre == "" || $apellidos == "" || $correo == "")
        {
            $_POST["Mensaje"] = "Debe completar todos los campos obligatorios.";
        }
        else if(!filter_var($correo, FILTER_VALIDATE_EMAIL))
        {
            $_POST["Mensaje"] = "El correo electrónico no tiene un formato válido.";
        }
        else
        {
            $resultado = ActualizarPerfilModel($idUsuario, $identificacion, $nombre, $apellidos, $correo, $telefono);

            if($resultado)
            {
                $_SESSION["NombreUsuario"] = $nombre . " " . $apellidos;
                $_SESSION["CorreoUsuario"] = $correo;

                $_POST["MensajeExito"] = "Su información personal se actualizó correctamente.";
            }
            else
            {
                $_POST["Mensaje"] = "No se pudo actualizar su información. Verifique que la identificación y el correo no estén en uso.";
            }
        }
    }

    if(isset($_POST["btnCambiarContrasena"]))
    {
        $idUsuario       = $_SESSION["IdUsuario"];
        $nuevaContrasena = $_POST["nuevaContrasena"];
        $confirmacion    = $_POST["confirmacion"];

        if(strlen($nuevaContrasena) < 6)
        {
            $_POST["Mensaje"] = "La contraseña debe tener al menos 6 caracteres.";
        }
        else if($nuevaContrasena !== $confirmacion)
        {
            $_POST["Mensaje"] = "Las contraseñas no coinciden.";
        }
        else
        {
            $contrasenaHash = password_hash($nuevaContrasena, PASSWORD_DEFAULT);
            $resultado = ActualizarContrasenaModel($idUsuario, $contrasenaHash);

            if($resultado)
            {
                // Se notifica por correo y se cierra la sesión (patrón del curso)
                $plantilla = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/Dynasty/DYNASTY_WEB_proyecto/View/templates/CambioContrasenna.html');
                $plantilla = str_replace("{{NOMBRE}}", $_SESSION["NombreUsuario"], $plantilla);
                date_default_timezone_set('America/Costa_Rica');
                $plantilla = str_replace("{{FECHA}}", date('d/m/Y h:i A'), $plantilla);

                EnviarCorreo("Dynasty - Cambio de contraseña", $plantilla, $_SESSION["CorreoUsuario"]);
                CerrarSesion();
            }

            $_POST["Mensaje"] = "No se pudo cambiar la contraseña. Intente de nuevo.";
        }
    }

    function ConsultarUsuario()
    {
        return ConsultarUsuarioModel($_SESSION["IdUsuario"]);
    }
