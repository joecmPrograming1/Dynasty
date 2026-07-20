<?php
    include_once $_SERVER['DOCUMENT_ROOT'] . '/Dynasty/DYNASTY_WEB_proyecto/Controller/UtilitarioController.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/Dynasty/DYNASTY_WEB_proyecto/Model/ClienteModel.php';

    ValidarSesion("ADMINISTRADOR");

    if(isset($_POST["btnRegistrarCliente"]))
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

        if($identificacion == "" || $nombre == "" || $apellidos == "" || $correo == "" || $contrasena == "" || $objetivo == "" || $disponibilidad == "")
        {
            $_POST["Mensaje"] = "Debe completar todos los campos obligatorios.";
        }
        else if(!filter_var($correo, FILTER_VALIDATE_EMAIL))
        {
            $_POST["Mensaje"] = "El correo electrónico no tiene un formato válido.";
        }
        else
        {
            // La contraseña nunca se guarda en texto plano (RF01/RNF01)
            $contrasenaHash = password_hash($contrasena, PASSWORD_DEFAULT);

            $resultado = RegistrarClienteModel($identificacion, $nombre, $apellidos, $correo, $telefono, $contrasenaHash, $objetivo, $nivel, $disponibilidad, $observaciones);

            if($resultado)
            {
                header("Location: ../vCliente/GestionClientes.php?exito=registro");
                exit();
            }

            $_POST["Mensaje"] = "No se pudo registrar el cliente. Verifique que la identificación y el correo no estén registrados.";
        }
    }

    if(isset($_POST["btnActualizarCliente"]))
    {
        $idCliente      = $_POST["idCliente"];
        $identificacion = trim($_POST["identificacion"]);
        $nombre         = trim($_POST["nombre"]);
        $apellidos      = trim($_POST["apellidos"]);
        $correo         = trim($_POST["correo"]);
        $telefono       = trim($_POST["telefono"]);
        $objetivo       = trim($_POST["objetivo"]);
        $nivel          = $_POST["nivel"];
        $disponibilidad = trim($_POST["disponibilidad"]);
        $observaciones  = trim($_POST["observaciones"]);

        if($identificacion == "" || $nombre == "" || $apellidos == "" || $correo == "" || $objetivo == "" || $disponibilidad == "")
        {
            $_POST["Mensaje"] = "Debe completar todos los campos obligatorios.";
        }
        else
        {
            $resultado = ActualizarClienteModel($idCliente, $identificacion, $nombre, $apellidos, $correo, $telefono, $objetivo, $nivel, $disponibilidad, $observaciones);

            if($resultado)
            {
                header("Location: ../vCliente/GestionClientes.php?exito=actualizacion");
                exit();
            }

            $_POST["Mensaje"] = "No se pudo actualizar el cliente. Verifique que la identificación y el correo no estén duplicados.";
        }
    }

    if(isset($_POST["btnCambiarEstadoCliente"]))
    {
        $idCliente = $_POST["idCliente"];
        $estado    = $_POST["estado"];

        $resultado = CambiarEstadoClienteModel($idCliente, $estado);

        header("Location: ../vCliente/GestionClientes.php" . ($resultado ? "?exito=estado" : "?error=estado"));
        exit();
    }
