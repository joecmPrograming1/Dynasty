<?php
    include_once $_SERVER['DOCUMENT_ROOT'] . '/Dynasty/DYNASTY_WEB_proyecto/Controller/UtilitarioController.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/Dynasty/DYNASTY_WEB_proyecto/Model/AsignacionModel.php';

    ValidarSesion("ADMINISTRADOR");

    // ------------------------------------------------------------
    // Asignacion de una rutina a un cliente (RF05)
    // ------------------------------------------------------------
    if(isset($_POST["btnAsignarRutina"]))
    {
        $idCliente   = trim($_POST["idCliente"]);
        $idRutina    = trim($_POST["idRutina"]);
        $fechaInicio = trim($_POST["fechaInicio"]);
        $fechaFin    = trim($_POST["fechaFin"]);
        $observacion = trim($_POST["observacion"]);

        if($idCliente == "" || $idRutina == "" || $fechaInicio == "")
        {
            $_POST["Mensaje"] = "Debe seleccionar el cliente, la rutina y la fecha de inicio.";
        }
        else if($fechaFin != "" && $fechaFin < $fechaInicio)
        {
            // La fecha de finalizacion no puede ser anterior a la de inicio
            $_POST["Mensaje"] = "La fecha de finalizacion no puede ser anterior a la fecha de inicio.";
        }
        else
        {
            // Un cliente no puede tener mas de una asignacion PENDIENTE o EN_PROCESO
            $vigentes = ContarAsignacionesVigentesModel($idCliente);

            if($vigentes > 0)
            {
                $_POST["Mensaje"] = "El cliente ya tiene una rutina vigente. Debe finalizarla o cancelarla antes de asignar otra.";
            }
            else
            {
                $fechaFin  = ($fechaFin == "") ? null : $fechaFin;
                $resultado = AsignarRutinaModel($idCliente, $idRutina, $fechaInicio, $fechaFin, $observacion);

                if($resultado)
                {
                    header("Location: ../vAsignacion/Asignaciones.php?exito=asignacion");
                    exit();
                }

                $_POST["Mensaje"] = "No se pudo registrar la asignacion. Verifique que el cliente y la rutina esten activos.";
            }
        }
    }

    // ------------------------------------------------------------
    // Cambio de estado de una asignacion: FINALIZADA o CANCELADA (RF08)
    // ------------------------------------------------------------
    if(isset($_POST["CambiarEstadoAsignacion"]))
    {
        $idAsignacion = $_POST["idAsignacion"];
        $estado       = $_POST["estado"];

        $estadosValidos = ["FINALIZADA", "CANCELADA"];

        if(!in_array($estado, $estadosValidos))
        {
            echo json_encode(["status" => "Error"]);
            exit();
        }

        $resultado = CambiarEstadoAsignacionModel($idAsignacion, $estado);

        echo json_encode(["status" => $resultado ? "Ok" : "Error"]);
        exit();
    }

    // ------------------------------------------------------------
    // Funciones que utiliza la vista.
    // ------------------------------------------------------------

    function ConsultarAsignaciones()
    {
        return ConsultarAsignacionesModel();
    }

    function ConsultarClientesActivos()
    {
        return ConsultarClientesActivosModel();
    }

    function ConsultarRutinasActivas()
    {
        return ConsultarRutinasActivasModel();
    }
