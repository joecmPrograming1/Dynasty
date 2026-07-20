<?php
    include_once $_SERVER['DOCUMENT_ROOT'] . '/Dynasty/DYNASTY_WEB_proyecto/Model/UtilitarioModel.php';

    function RegistrarClienteModel($identificacion, $nombre, $apellidos, $correo, $telefono, $contrasenaHash, $objetivo, $nivel, $disponibilidad, $observaciones)
    {
        try
        {
            $conn = OpenDB();

            $stmt = $conn -> prepare("CALL spRegistrarCliente(?,?,?,?,?,?,?,?,?,?)");
            $stmt -> bind_param("ssssssssss", $identificacion, $nombre, $apellidos, $correo, $telefono, $contrasenaHash, $objetivo, $nivel, $disponibilidad, $observaciones);
            $response = $stmt -> execute();
            $stmt -> close();

            CloseDB($conn);
            return $response;
        }
        catch(Exception $e)
        {
            AddError($e, 'RegistrarClienteModel');
            return false;
        }
    }

    function ConsultarClientesModel()
    {
        try
        {
            $conn = OpenDB();

            $sql = "CALL spConsultarClientes()";
            $response = $conn -> query($sql);

            $datos = [];
            while($fila = $response -> fetch_assoc())
            {
                $datos[] = $fila;
            }

            CloseDB($conn);
            return $datos;
        }
        catch(Exception $e)
        {
            AddError($e, 'ConsultarClientesModel');
            return [];
        }
    }

    function ActualizarClienteModel($idCliente, $identificacion, $nombre, $apellidos, $correo, $telefono, $objetivo, $nivel, $disponibilidad, $observaciones)
    {
        try
        {
            $conn = OpenDB();

            $stmt = $conn -> prepare("CALL spActualizarCliente(?,?,?,?,?,?,?,?,?,?)");
            $stmt -> bind_param("isssssssss", $idCliente, $identificacion, $nombre, $apellidos, $correo, $telefono, $objetivo, $nivel, $disponibilidad, $observaciones);
            $response = $stmt -> execute();
            $stmt -> close();

            CloseDB($conn);
            return $response;
        }
        catch(Exception $e)
        {
            AddError($e, 'ActualizarClienteModel');
            return false;
        }
    }

    function CambiarEstadoClienteModel($idCliente, $estado)
    {
        try
        {
            $conn = OpenDB();

            $stmt = $conn -> prepare("CALL spCambiarEstadoCliente(?,?)");
            $stmt -> bind_param("ii", $idCliente, $estado);
            $response = $stmt -> execute();
            $stmt -> close();

            CloseDB($conn);
            return $response;
        }
        catch(Exception $e)
        {
            AddError($e, 'CambiarEstadoClienteModel');
            return false;
        }
    }
