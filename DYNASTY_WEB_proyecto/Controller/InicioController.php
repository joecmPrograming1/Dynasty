<?php
    include_once $_SERVER['DOCUMENT_ROOT'] . '/Dynasty/DYNASTY_WEB_proyecto/Controller/UtilitarioController.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/Dynasty/DYNASTY_WEB_proyecto/Model/InicioModel.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/Dynasty/DYNASTY_WEB_proyecto/Model/UsuarioModel.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/Dynasty/DYNASTY_WEB_proyecto/Model/ClienteModel.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/Dynasty/DYNASTY_WEB_proyecto/Model/NivelModel.php';

    // Registro público: el propio cliente crea su cuenta (RF02).
    // El SP asigna automáticamente el rol CLIENTE y guarda usuario + perfil en una transacción.
    if(isset($_POST["btnRegistrarse"]))
    {
        $identificacion = trim($_POST["identificacion"]);
        $nombre         = trim($_POST["nombre"]);
        $apellidos      = trim($_POST["apellidos"]);
        $correo         = trim($_POST["correo"]);
        $telefono       = trim($_POST["telefono"]);
        $contrasena     = $_POST["contrasena"];
        $objetivo       = trim($_POST["objetivo"]);
        $nivel          = $_POST["nivel"];
        $disponibilidad = trim($_POST["disponibilidad"]);
        $observaciones  = trim($_POST["observaciones"]);

        // Se conserva lo digitado para repoblar el formulario si algo falla
        $_POST["Datos"] = [
            "identificacion" => $identificacion, "nombre" => $nombre, "apellidos" => $apellidos,
            "correo" => $correo, "telefono" => $telefono, "objetivo" => $objetivo,
            "nivel" => $nivel, "disponibilidad" => $disponibilidad, "observaciones" => $observaciones
        ];

        if($identificacion == "" || $nombre == "" || $apellidos == "" || $correo == "" || $contrasena == "" || $objetivo == "" || $disponibilidad == "")
        {
            $_POST["Mensaje"] = "Debe completar todos los campos obligatorios.";
        }
        else if(!filter_var($correo, FILTER_VALIDATE_EMAIL))
        {
            $_POST["Mensaje"] = "El correo electrónico no tiene un formato válido.";
        }
        else if(strlen($contrasena) < 6)
        {
            $_POST["Mensaje"] = "La contraseña debe tener al menos 6 caracteres.";
        }
        else
        {
            // La contraseña nunca se guarda en texto plano (RF01/RNF01)
            $contrasenaHash = password_hash($contrasena, PASSWORD_DEFAULT);

            $resultado = RegistrarClienteModel($identificacion, $nombre, $apellidos, $correo, $telefono, $contrasenaHash, $objetivo, $nivel, $disponibilidad, $observaciones);

            if($resultado)
            {
                header("Location: IniciarSesion.php?registro=1");
                exit();
            }

            $_POST["Mensaje"] = "No se pudo crear la cuenta. Verifique que la identificación y el correo no estén registrados.";
        }
    }

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
                    $plantilla = str_replace("{{TEMPORAL}}", $contrasenaTemporal, $plantilla);

                    EnviarCorreo("Dynasty - Recuperación de acceso", $plantilla, $correo);
                }
            }

            // Mensaje general: no revela si el correo existe o no (seguridad)
            $_POST["MensajeExito"] = "Si el correo está registrado, recibirá una contraseña temporal en su bandeja de entrada.";
        }
    }

    // Funcion que utiliza la vista de registro. La vista nunca llama al modelo directamente.
    function ConsultarNivelesRegistro()
    {
        return ConsultarNivelesModel();
    }
