<?php
    include_once $_SERVER['DOCUMENT_ROOT'] . '/Dynasty/DYNASTY_WEB_proyecto/Controller/UtilitarioController.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/Dynasty/DYNASTY_WEB_proyecto/Model/ClienteModel.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/Dynasty/DYNASTY_WEB_proyecto/Model/EjercicioModel.php';

    ValidarSesion();

    // Devuelve los totales que muestra el panel administrativo.
    // La vista solicita la informacion al controlador, no al modelo.
    function ConsultarResumenPanel()
    {
        $resumen = ["clientes" => 0, "ejercicios" => 0];

        if($_SESSION["Rol"] != "ADMINISTRADOR")
        {
            return $resumen;
        }

        $clientes = ConsultarClientesModel();
        foreach($clientes as $c)
        {
            if($c["estado"] == 1) { $resumen["clientes"]++; }
        }

        $ejercicios = ConsultarEjerciciosModel();
        foreach($ejercicios as $e)
        {
            if($e["estado"] == 1) { $resumen["ejercicios"]++; }
        }

        return $resumen;
    }
