<?php
    include_once $_SERVER['DOCUMENT_ROOT'] . '/Dynasty/DYNASTY_WEB_proyecto/Model/UtilitarioModel.php';

    function IniciarSesionModel($credencial)
    {
        try
        {
            $conn = OpenDB();

            $credencial = $conn -> real_escape_string($credencial);
            $sql = "CALL spIniciarSesion('$credencial')";
            $response = $conn -> query($sql);

            $datos = null;
            while($fila = $response -> fetch_assoc())
            {
                $datos = $fila;
            }

            CloseDB($conn);
            return $datos;
        }
        catch(Exception $e)
        {
            AddError($e, 'IniciarSesionModel');
            return null;
        }
    }
