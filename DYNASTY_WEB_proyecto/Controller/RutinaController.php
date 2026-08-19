<?php
/* ============================================================
 * Proyecto : Dynasty - Sistema de gestion de rutinas
 * Curso    : Ambiente Web Cliente/Servidor (SC-502)
 * Archivo  : RutinaController.php
 * Proposito: Controlador de rutinas. Creacion y edicion de rutinas con su detalle de ejercicios.
 * Requerim.: RF04
 * ============================================================ */

    include_once $_SERVER['DOCUMENT_ROOT'] . '/Dynasty/DYNASTY_WEB_proyecto/Controller/UtilitarioController.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/Dynasty/DYNASTY_WEB_proyecto/Model/RutinaModel.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/Dynasty/DYNASTY_WEB_proyecto/Model/NivelModel.php';

    ValidarSesion("ADMINISTRADOR");

    /**
     * Arma el detalle de ejercicios recibido del formulario y lo valida.
     * Cada rutina debe tener al menos un ejercicio, series validas y
     * al menos un valor positivo entre repeticiones y duracion (RF04).
     *
     * @return array [ejercicios, mensajeError]
     */
    function ArmarDetalleRutina()
    {
        $ejercicios = [];
        $ordenes    = [];

        if(!isset($_POST["idEjercicio"]) || !is_array($_POST["idEjercicio"]))
        {
            return [[], "La rutina debe tener al menos un ejercicio."];
        }

        $total = count($_POST["idEjercicio"]);

        for($i = 0; $i < $total; $i++)
        {
            $idEjercicio = trim($_POST["idEjercicio"][$i]);

            // Las filas vacias simplemente se omiten
            if($idEjercicio == "")
            {
                continue;
            }

            $series       = trim($_POST["series"][$i]);
            $repeticiones = trim($_POST["repeticiones"][$i]);
            $duracion     = trim($_POST["duracion"][$i]);
            $descanso     = trim($_POST["descanso"][$i]);
            $indicaciones = trim($_POST["indicaciones"][$i]);
            $orden        = trim($_POST["orden"][$i]);

            if($series == "" || !is_numeric($series) || $series < 1 || $series > 20)
            {
                return [[], "Cada ejercicio debe tener una cantidad de series entre 1 y 20."];
            }

            $tieneRepeticiones = ($repeticiones != "" && is_numeric($repeticiones) && $repeticiones > 0);
            $tieneDuracion     = ($duracion != "" && is_numeric($duracion) && $duracion > 0);

            if(!$tieneRepeticiones && !$tieneDuracion)
            {
                return [[], "Cada ejercicio debe indicar repeticiones o duracion en segundos."];
            }

            if($orden == "" || !is_numeric($orden) || $orden < 1)
            {
                return [[], "Cada ejercicio debe tener un orden valido."];
            }

            if(in_array($orden, $ordenes))
            {
                return [[], "El orden de los ejercicios no puede repetirse dentro de la misma rutina."];
            }

            $ordenes[] = $orden;

            $ejercicios[] = [
                "idEjercicio"  => $idEjercicio,
                "series"       => $series,
                "repeticiones" => $tieneRepeticiones ? $repeticiones : null,
                "duracion"     => $tieneDuracion ? $duracion : null,
                "descanso"     => ($descanso == "" || !is_numeric($descanso)) ? 0 : $descanso,
                "indicaciones" => $indicaciones,
                "orden"        => $orden
            ];
        }

        if(count($ejercicios) == 0)
        {
            return [[], "La rutina debe tener al menos un ejercicio."];
        }

        return [$ejercicios, ""];
    }

    // ------------------------------------------------------------
    // Registro de una rutina nueva (RF04)
    // ------------------------------------------------------------
    if(isset($_POST["btnRegistrarRutina"]))
    {
        $nombre      = trim($_POST["nombre"]);
        $objetivo    = trim($_POST["objetivo"]);
        $nivel       = $_POST["nivel"];
        $descripcion = trim($_POST["descripcion"]);

        list($ejercicios, $error) = ArmarDetalleRutina();

        if($nombre == "" || $objetivo == "" || $nivel == "")
        {
            $_POST["Mensaje"] = "El nombre, el objetivo y el nivel son obligatorios.";
        }
        else if($error != "")
        {
            $_POST["Mensaje"] = $error;
        }
        else
        {
            // El encabezado y el detalle se guardan dentro de una transaccion
            $resultado = RegistrarRutinaModel($nombre, $objetivo, $nivel, $descripcion, $ejercicios);

            if($resultado)
            {
                header("Location: ../vRutina/GestionRutinas.php?exito=registro");
                exit();
            }

            $_POST["Mensaje"] = "No se pudo registrar la rutina. Verifique que el nombre no este duplicado.";
        }
    }

    // ------------------------------------------------------------
    // Actualizacion de una rutina existente (RF04)
    // ------------------------------------------------------------
    if(isset($_POST["btnActualizarRutina"]))
    {
        $idRutina    = $_POST["idRutina"];
        $nombre      = trim($_POST["nombre"]);
        $objetivo    = trim($_POST["objetivo"]);
        $nivel       = $_POST["nivel"];
        $descripcion = trim($_POST["descripcion"]);
        $estado      = isset($_POST["estado"]) ? $_POST["estado"] : 1;

        list($ejercicios, $error) = ArmarDetalleRutina();

        if($nombre == "" || $objetivo == "" || $nivel == "")
        {
            $_POST["Mensaje"] = "El nombre, el objetivo y el nivel son obligatorios.";
        }
        else if($error != "")
        {
            $_POST["Mensaje"] = $error;
        }
        else
        {
            $resultado = ActualizarRutinaModel($idRutina, $nombre, $objetivo, $nivel, $descripcion, $estado, $ejercicios);

            if($resultado)
            {
                header("Location: ../vRutina/GestionRutinas.php?exito=actualizacion");
                exit();
            }

            $_POST["Mensaje"] = "No se pudo actualizar la rutina. Intente de nuevo.";
        }
    }

    // ------------------------------------------------------------
    // Activar o desactivar una rutina (llamado asincrono)
    // ------------------------------------------------------------
    if(isset($_POST["CambiarEstadoRutina"]))
    {
        $resultado = CambiarEstadoRutinaModel($_POST["idRutina"], $_POST["estado"]);

        echo json_encode(["status" => $resultado ? "Ok" : "Error"]);
        exit();
    }

    // ------------------------------------------------------------
    // Detalle de una rutina para cargarla en el formulario (AJAX)
    // ------------------------------------------------------------
    if(isset($_POST["ConsultarDetalleRutina"]))
    {
        $idRutina = $_POST["idRutina"];

        $rutina  = ConsultarRutinaModel($idRutina);
        $detalle = ConsultarDetalleRutinaModel($idRutina);
        $asignada = ContarAsignacionesRutinaModel($idRutina);

        echo json_encode([
            "status"   => $rutina ? "Ok" : "Error",
            "rutina"   => $rutina,
            "detalle"  => $detalle,
            "asignada" => ($asignada > 0)
        ]);
        exit();
    }

    // ------------------------------------------------------------
    // Funciones que utiliza la vista.
    // La vista solicita la informacion al controlador.
    // ------------------------------------------------------------

    function ConsultarRutinas()
    {
        return ConsultarRutinasModel();
    }

    function ConsultarEjerciciosActivos()
    {
        return ConsultarEjerciciosActivosModel();
    }

    function ConsultarNivelesRutina()
    {
        return ConsultarNivelesModel();
    }
