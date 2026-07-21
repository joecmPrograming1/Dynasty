<?php
    include_once $_SERVER['DOCUMENT_ROOT'] . '/Dynasty/DYNASTY_WEB_proyecto/Controller/UtilitarioController.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/Dynasty/DYNASTY_WEB_proyecto/Model/ClienteModel.php';

    ValidarSesion("ADMINISTRADOR");

    // El registro de clientes ahora es de auto-servicio (ver InicioController -> btnRegistrarse).
    // El administrador solo consulta, edita y activa/desactiva.
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
