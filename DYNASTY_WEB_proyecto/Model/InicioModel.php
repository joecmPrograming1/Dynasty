<?php
/* ============================================================
 * Proyecto : Dynasty - Sistema de gestion de rutinas
 * Curso    : Ambiente Web Cliente/Servidor (SC-502)
 * Archivo  : InicioModel.php
 * Proposito: Modelo de acceso. Validacion de credenciales y recuperacion de contrasena.
 * Requerim.: RF01
 * ============================================================ */

    include_once $_SERVER['DOCUMENT_ROOT'] . '/Dynasty/DYNASTY_WEB_proyecto/Model/UtilitarioModel.php';

    function IniciarSesionModel($credencial)
    {
        try
        {
            $conn = OpenDB();

            // Consulta parametrizada: evita cualquier riesgo de inyeccion (RNF01)
            $stmt = $conn -> prepare("CALL spIniciarSesion(?)");
            $stmt -> bind_param("s", $credencial);
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
            AddError($e, 'IniciarSesionModel');
            return null;
        }
    }
