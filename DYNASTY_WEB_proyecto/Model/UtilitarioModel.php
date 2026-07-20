<?php

    if(session_status() == PHP_SESSION_NONE){
        session_start();
    }

    function OpenDB()
    {
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        return new mysqli("127.0.0.1:3307", "root", "", "dynasty");
    }

    function CloseDB($conn)
    {
        $conn -> close();
    }

    function AddError($error, $accion)
    {
        try
        {
            $conn = OpenDB();

            $mensaje = $conn -> real_escape_string($error -> getMessage());
            $idUsuario = isset($_SESSION["IdUsuario"]) ? $_SESSION["IdUsuario"] : 0;

            $sql = "CALL spRegistrarError('$mensaje', '$accion', '$idUsuario')";
            $conn -> query($sql);

            CloseDB($conn);
        }
        catch(Exception $e)
        {
            // Si falla el registro del error no se detiene la aplicación
        }
    }
