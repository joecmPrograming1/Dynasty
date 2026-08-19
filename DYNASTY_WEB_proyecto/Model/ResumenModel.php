<?php
/* ============================================================
 * Proyecto : Dynasty - Sistema de gestion de rutinas
 * Curso    : Ambiente Web Cliente/Servidor (SC-502)
 * Archivo  : ResumenModel.php
 * Proposito: Modelo de resumen. Totales que muestra el panel administrativo.
 * Requerim.: RNF06
 * ============================================================ */

    include_once $_SERVER['DOCUMENT_ROOT'] . '/Dynasty/DYNASTY_WEB_proyecto/Model/UtilitarioModel.php';

    /**
     * Totales que muestra el panel administrativo.
     * Toda la logica de acceso a datos permanece en el modelo (RNF06).
     */
    function ConsultarResumenModel()
    {
        try
        {
            $conn = OpenDB();

            $sql = "CALL spConsultarResumen()";
            $response = $conn -> query($sql);

            $datos = ["clientes" => 0, "ejercicios" => 0, "rutinas" => 0, "asignaciones" => 0];

            while($fila = $response -> fetch_assoc())
            {
                $datos = [
                    "clientes"     => $fila["clientes"],
                    "ejercicios"   => $fila["ejercicios"],
                    "rutinas"      => $fila["rutinas"],
                    "asignaciones" => $fila["asignaciones"]
                ];
            }

            CloseDB($conn);
            return $datos;
        }
        catch(Exception $e)
        {
            AddError($e, 'ConsultarResumenModel');
            return ["clientes" => 0, "ejercicios" => 0, "rutinas" => 0, "asignaciones" => 0];
        }
    }
