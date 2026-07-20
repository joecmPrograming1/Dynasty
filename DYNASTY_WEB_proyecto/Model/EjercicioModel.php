<?php
    include_once $_SERVER['DOCUMENT_ROOT'] . '/Dynasty/DYNASTY_WEB_proyecto/Model/UtilitarioModel.php';

    function RegistrarEjercicioModel($nombre, $categoria, $descripcion, $equipo)
    {
        try
        {
            $conn = OpenDB();

            $stmt = $conn -> prepare("CALL spRegistrarEjercicio(?,?,?,?)");
            $stmt -> bind_param("ssss", $nombre, $categoria, $descripcion, $equipo);
            $response = $stmt -> execute();
            $stmt -> close();

            CloseDB($conn);
            return $response;
        }
        catch(Exception $e)
        {
            AddError($e, 'RegistrarEjercicioModel');
            return false;
        }
    }

    function ConsultarEjerciciosModel()
    {
        try
        {
            $conn = OpenDB();

            $sql = "CALL spConsultarEjercicios()";
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
            AddError($e, 'ConsultarEjerciciosModel');
            return [];
        }
    }

    function ActualizarEjercicioModel($idEjercicio, $nombre, $categoria, $descripcion, $equipo)
    {
        try
        {
            $conn = OpenDB();

            $stmt = $conn -> prepare("CALL spActualizarEjercicio(?,?,?,?,?)");
            $stmt -> bind_param("issss", $idEjercicio, $nombre, $categoria, $descripcion, $equipo);
            $response = $stmt -> execute();
            $stmt -> close();

            CloseDB($conn);
            return $response;
        }
        catch(Exception $e)
        {
            AddError($e, 'ActualizarEjercicioModel');
            return false;
        }
    }

    function CambiarEstadoEjercicioModel($idEjercicio, $estado)
    {
        try
        {
            $conn = OpenDB();

            $stmt = $conn -> prepare("CALL spCambiarEstadoEjercicio(?,?)");
            $stmt -> bind_param("ii", $idEjercicio, $estado);
            $response = $stmt -> execute();
            $stmt -> close();

            CloseDB($conn);
            return $response;
        }
        catch(Exception $e)
        {
            AddError($e, 'CambiarEstadoEjercicioModel');
            return false;
        }
    }
