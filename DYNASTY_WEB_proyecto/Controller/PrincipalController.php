<?php
/* ============================================================
 * Proyecto : Dynasty - Sistema de gestion de rutinas
 * Curso    : Ambiente Web Cliente/Servidor (SC-502)
 * Archivo  : PrincipalController.php
 * Proposito: Controlador del panel principal. Prepara el resumen que muestra la pantalla de inicio de cada rol.
 * Requerim.: RF01
 * ============================================================ */

    include_once $_SERVER['DOCUMENT_ROOT'] . '/Dynasty/DYNASTY_WEB_proyecto/Controller/UtilitarioController.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/Dynasty/DYNASTY_WEB_proyecto/Model/ResumenModel.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/Dynasty/DYNASTY_WEB_proyecto/Model/AsignacionModel.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/Dynasty/DYNASTY_WEB_proyecto/Model/ProgresoModel.php';

    ValidarSesion();

    /**
     * Resumen del panel administrativo.
     * El controlador coordina; el acceso a datos vive en el modelo (RNF06).
     */
    function ConsultarResumenPanel()
    {
        if($_SESSION["Rol"] != "ADMINISTRADOR")
        {
            return ["clientes" => 0, "ejercicios" => 0, "rutinas" => 0, "asignaciones" => 0];
        }

        return ConsultarResumenModel();
    }

    /**
     * Resumen del cliente: su rutina vigente y la cantidad de entrenamientos.
     */
    function ConsultarResumenCliente()
    {
        $resumen = ["rutina" => null, "entrenamientos" => 0];

        if($_SESSION["Rol"] == "ADMINISTRADOR")
        {
            return $resumen;
        }

        $cliente = ConsultarClientePorUsuarioModel($_SESSION["IdUsuario"]);

        if(!$cliente)
        {
            return $resumen;
        }

        $resumen["rutina"]         = ConsultarAsignacionActivaClienteModel($cliente["id_cliente"]);
        $resumen["entrenamientos"] = count(ConsultarProgresoClienteModel($cliente["id_cliente"]));

        return $resumen;
    }
