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

            $mensaje   = $error -> getMessage();
            $idUsuario = isset($_SESSION["IdUsuario"]) ? $_SESSION["IdUsuario"] : 0;

            // Consulta parametrizada (RNF01)
            $stmt = $conn -> prepare("CALL spRegistrarError(?,?,?)");
            $stmt -> bind_param("ssi", $mensaje, $accion, $idUsuario);
            $stmt -> execute();
            $stmt -> close();

            CloseDB($conn);
        }
        catch(Exception $e)
        {
            // Si falla el registro del error no se detiene la aplicación
        }
    }
