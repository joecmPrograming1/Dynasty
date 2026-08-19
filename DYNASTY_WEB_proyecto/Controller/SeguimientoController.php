<?php
/* ============================================================
 * Proyecto : Dynasty - Sistema de gestion de rutinas
 * Curso    : Ambiente Web Cliente/Servidor (SC-502)
 * Archivo  : SeguimientoController.php
 * Proposito: Controlador de seguimiento. Consulta del progreso reportado y retroalimentacion del entrenador.
 * Requerim.: RF08
 * ============================================================ */

    include_once $_SERVER['DOCUMENT_ROOT'] . '/Dynasty/DYNASTY_WEB_proyecto/Controller/UtilitarioController.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/Dynasty/DYNASTY_WEB_proyecto/Model/ProgresoModel.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/Dynasty/DYNASTY_WEB_proyecto/Model/AsignacionModel.php';

    ValidarSesion("ADMINISTRADOR");

    // ------------------------------------------------------------
    // Retroalimentacion del administrador (RF08).
    // Solo agrega o actualiza el comentario, no modifica los datos
    // reportados por el cliente.
    // ------------------------------------------------------------
    if(isset($_POST["btnRetroalimentacion"]))
    {
        $idProgreso = trim($_POST["idProgreso"]);
        $comentario = trim($_POST["comentarioAdmin"]);

        if($idProgreso == "" || $comentario == "")
        {
            $_POST["Mensaje"] = "Debe escribir un comentario para la retroalimentacion.";
        }
        else
        {
            $resultado = RegistrarRetroalimentacionModel($idProgreso, $comentario);

            if($resultado)
            {
                header("Location: ../vAsignacion/Seguimiento.php?exito=retroalimentacion" . ArmarFiltros());
                exit();
            }

            $_POST["Mensaje"] = "No se pudo guardar la retroalimentacion. Intente de nuevo.";
        }
    }

    /**
     * Conserva los filtros aplicados al redireccionar.
     */
    function ArmarFiltros()
    {
        $filtros = "";

        if(isset($_POST["filtroCliente"]) && $_POST["filtroCliente"] != "")
        {
            $filtros .= "&filtroCliente=" . urlencode($_POST["filtroCliente"]);
        }
        if(isset($_POST["filtroInicio"]) && $_POST["filtroInicio"] != "")
        {
            $filtros .= "&filtroInicio=" . urlencode($_POST["filtroInicio"]);
        }
        if(isset($_POST["filtroFin"]) && $_POST["filtroFin"] != "")
        {
            $filtros .= "&filtroFin=" . urlencode($_POST["filtroFin"]);
        }

        return $filtros;
    }

    // ------------------------------------------------------------
    // Funciones que utiliza la vista.
    // ------------------------------------------------------------

    /**
     * Consulta el progreso aplicando los filtros por cliente y fechas.
     */
    function ConsultarSeguimiento()
    {
        $idCliente   = isset($_GET["filtroCliente"]) ? $_GET["filtroCliente"] : "";
        $fechaInicio = isset($_GET["filtroInicio"])  ? $_GET["filtroInicio"]  : "";
        $fechaFin    = isset($_GET["filtroFin"])     ? $_GET["filtroFin"]     : "";

        return ConsultarProgresoGeneralModel($idCliente, $fechaInicio, $fechaFin);
    }

    function ConsultarClientesSeguimiento()
    {
        return ConsultarClientesActivosModel();
    }
