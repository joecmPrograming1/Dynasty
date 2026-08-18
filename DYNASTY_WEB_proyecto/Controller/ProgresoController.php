<?php
    include_once $_SERVER['DOCUMENT_ROOT'] . '/Dynasty/DYNASTY_WEB_proyecto/Controller/UtilitarioController.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/Dynasty/DYNASTY_WEB_proyecto/Model/ProgresoModel.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/Dynasty/DYNASTY_WEB_proyecto/Model/AsignacionModel.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/Dynasty/DYNASTY_WEB_proyecto/Model/RutinaModel.php';

    ValidarSesion("CLIENTE");

    /**
     * Obtiene el perfil de cliente a partir del usuario en sesion.
     * El id_cliente nunca se recibe desde el formulario (RF06/RF07).
     */
    function ObtenerClienteSesion()
    {
        return ConsultarClientePorUsuarioModel($_SESSION["IdUsuario"]);
    }

    // ------------------------------------------------------------
    // Registro del entrenamiento del cliente (RF07)
    // ------------------------------------------------------------
    if(isset($_POST["btnRegistrarProgreso"]))
    {
        $cliente = ObtenerClienteSesion();

        if(!$cliente)
        {
            $_POST["Mensaje"] = "No se encontro el perfil del cliente.";
        }
        else
        {
            $idAsignacion = trim($_POST["idAsignacion"]);
            $fecha        = trim($_POST["fechaEntrenamiento"]);
            $cumplimiento = trim($_POST["cumplimiento"]);
            $esfuerzo     = trim($_POST["esfuerzo"]);
            $duracion     = trim($_POST["duracion"]);
            $comentario   = trim($_POST["comentario"]);

            // La asignacion debe pertenecer al cliente autenticado
            $asignacion = ValidarAsignacionClienteModel($idAsignacion, $cliente["id_cliente"]);

            $estadosValidos = ["COMPLETO", "PARCIAL", "NO_REALIZADO"];

            if(!$asignacion)
            {
                $_POST["Mensaje"] = "La rutina indicada no le pertenece.";
            }
            else if($fecha == "")
            {
                $_POST["Mensaje"] = "Debe indicar la fecha del entrenamiento.";
            }
            else if($fecha < $asignacion["fecha_inicio"])
            {
                $_POST["Mensaje"] = "La fecha no puede ser anterior al inicio de la rutina (" . date("d/m/Y", strtotime($asignacion["fecha_inicio"])) . ").";
            }
            else if($fecha > date("Y-m-d"))
            {
                $_POST["Mensaje"] = "La fecha del entrenamiento no puede ser posterior al dia de hoy.";
            }
            else if(!in_array($cumplimiento, $estadosValidos))
            {
                $_POST["Mensaje"] = "Debe indicar el estado de cumplimiento del entrenamiento.";
            }
            else if($esfuerzo == "" || !is_numeric($esfuerzo) || $esfuerzo < 1 || $esfuerzo > 10)
            {
                $_POST["Mensaje"] = "La percepcion de esfuerzo es obligatoria y debe estar entre 1 y 10.";
            }
            else if($duracion != "" && (!is_numeric($duracion) || $duracion < 0))
            {
                $_POST["Mensaje"] = "La duracion debe ser un numero valido.";
            }
            else
            {
                $duracion = ($duracion == "") ? null : $duracion;

                // Si ya existe un registro para esa fecha se actualiza en lugar de duplicar
                $existente = ConsultarProgresoFechaModel($idAsignacion, $fecha);

                if($existente)
                {
                    $resultado = ActualizarProgresoModel($existente["id_progreso"], $cumplimiento, $esfuerzo, $duracion, $comentario);
                    $exito = "actualizacion";
                }
                else
                {
                    $resultado = RegistrarProgresoModel($idAsignacion, $fecha, $cumplimiento, $esfuerzo, $duracion, $comentario);
                    $exito = "registro";
                }

                if($resultado)
                {
                    header("Location: ../vProgreso/MiProgreso.php?exito=" . $exito);
                    exit();
                }

                $_POST["Mensaje"] = "No se pudo guardar el entrenamiento. Intente de nuevo.";
            }
        }
    }

    // ------------------------------------------------------------
    // Funciones que utilizan las vistas del cliente.
    // ------------------------------------------------------------

    function ConsultarMiRutina()
    {
        $cliente = ObtenerClienteSesion();

        if(!$cliente)
        {
            return null;
        }

        $asignacion = ConsultarAsignacionActivaClienteModel($cliente["id_cliente"]);

        if(!$asignacion)
        {
            return null;
        }

        // Los ejercicios se muestran en el orden definido por el entrenador
        $asignacion["ejercicios"] = ConsultarDetalleRutinaModel($asignacion["id_rutina"]);

        return $asignacion;
    }

    function ConsultarMiProgreso()
    {
        $cliente = ObtenerClienteSesion();

        if(!$cliente)
        {
            return [];
        }

        return ConsultarProgresoClienteModel($cliente["id_cliente"]);
    }
