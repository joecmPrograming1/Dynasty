<?php
    include_once $_SERVER['DOCUMENT_ROOT'] . '/Dynasty/DYNASTY_WEB_proyecto/Model/UtilitarioModel.php';

    function ConsultarUsuarioModel($idUsuario)
    {
        try
        {
            $conn = OpenDB();

            $stmt = $conn -> prepare("CALL spConsultarUsuario(?)");
            $stmt -> bind_param("i", $idUsuario);
            $stmt -> execute();
            $response = $stmt -> get_result();

            $datos = null;
            while($fila = $response -> fetch_assoc())
            {
                $datos = $fila;
            }

            $stmt -> close();
            CloseDB($conn);
            return $datos;
        }
        catch(Exception $e)
        {
            AddError($e, 'ConsultarUsuarioModel');
            return null;
        }
    }

    function ActualizarPerfilModel($idUsuario, $identificacion, $nombre, $apellidos, $correo, $telefono)
    {
        try
        {
            $conn = OpenDB();

            $stmt = $conn -> prepare("CALL spActualizarPerfil(?,?,?,?,?,?)");
            $stmt -> bind_param("isssss", $idUsuario, $identificacion, $nombre, $apellidos, $correo, $telefono);
            $response = $stmt -> execute();
            $stmt -> close();

            CloseDB($conn);
            return $response;
        }
        catch(Exception $e)
        {
            AddError($e, 'ActualizarPerfilModel');
            return false;
        }
    }

    function ActualizarContrasenaModel($idUsuario, $contrasenaHash)
    {
        try
        {
            $conn = OpenDB();

            $stmt = $conn -> prepare("CALL spActualizarContrasena(?,?)");
            $stmt -> bind_param("is", $idUsuario, $contrasenaHash);
            $response = $stmt -> execute();
            $stmt -> close();

            CloseDB($conn);
            return $response;
        }
        catch(Exception $e)
        {
            AddError($e, 'ActualizarContrasenaModel');
            return false;
        }
    }

    function ValidarCorreoModel($correo)
    {
        try
        {
            $conn = OpenDB();

            $stmt = $conn -> prepare("CALL spValidarCorreo(?)");
            $stmt -> bind_param("s", $correo);
            $stmt -> execute();
            $response = $stmt -> get_result();

            $datos = null;
            while($fila = $response -> fetch_assoc())
            {
                $datos = $fila;
            }

            $stmt -> close();
            CloseDB($conn);
            return $datos;
        }
        catch(Exception $e)
        {
            AddError($e, 'ValidarCorreoModel');
            return null;
        }
    }
