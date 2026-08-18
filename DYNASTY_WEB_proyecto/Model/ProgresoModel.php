<?php
    include_once $_SERVER['DOCUMENT_ROOT'] . '/Dynasty/DYNASTY_WEB_proyecto/Model/UtilitarioModel.php';

    /**
     * Verifica que una asignacion pertenezca al cliente indicado.
     * Impide que un cliente registre progreso de otra persona (RF07).
     */
    function ValidarAsignacionClienteModel($idAsignacion, $idCliente)
    {
        try
        {
            $conn = OpenDB();

            $stmt = $conn -> prepare("CALL spValidarAsignacionCliente(?,?)");
            $stmt -> bind_param("ii", $idAsignacion, $idCliente);
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
            AddError($e, 'ValidarAsignacionClienteModel');
            return null;
        }
    }

    /**
     * Busca un registro de progreso por asignacion y fecha.
     * Evita duplicados del mismo entrenamiento en un dia (RF07).
     */
    function ConsultarProgresoFechaModel($idAsignacion, $fechaEntrenamiento)
    {
        try
        {
            $conn = OpenDB();

            $stmt = $conn -> prepare("CALL spConsultarProgresoFecha(?,?)");
            $stmt -> bind_param("is", $idAsignacion, $fechaEntrenamiento);
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
            AddError($e, 'ConsultarProgresoFechaModel');
            return null;
        }
    }

    /**
     * Registra un entrenamiento del cliente (RF07).
     * El procedimiento cambia la asignacion a EN_PROCESO en el primer registro.
     */
    function RegistrarProgresoModel($idAsignacion, $fechaEntrenamiento, $cumplimiento, $esfuerzo, $duracion, $comentario)
    {
        try
        {
            $conn = OpenDB();

            $stmt = $conn -> prepare("CALL spRegistrarProgreso(?,?,?,?,?,?)");
            $stmt -> bind_param("issiis", $idAsignacion, $fechaEntrenamiento, $cumplimiento, $esfuerzo, $duracion, $comentario);
            $response = $stmt -> execute();
            $stmt -> close();

            CloseDB($conn);
            return $response;
        }
        catch(Exception $e)
        {
            AddError($e, 'RegistrarProgresoModel');
            return false;
        }
    }

    /**
     * Actualiza un registro de progreso existente (RF07).
     */
    function ActualizarProgresoModel($idProgreso, $cumplimiento, $esfuerzo, $duracion, $comentario)
    {
        try
        {
            $conn = OpenDB();

            $stmt = $conn -> prepare("CALL spActualizarProgreso(?,?,?,?,?)");
            $stmt -> bind_param("isiis", $idProgreso, $cumplimiento, $esfuerzo, $duracion, $comentario);
            $response = $stmt -> execute();
            $stmt -> close();

            CloseDB($conn);
            return $response;
        }
        catch(Exception $e)
        {
            AddError($e, 'ActualizarProgresoModel');
            return false;
        }
    }

    /**
     * Historial de entrenamientos de un cliente (RF07).
     */
    function ConsultarProgresoClienteModel($idCliente)
    {
        try
        {
            $conn = OpenDB();

            $stmt = $conn -> prepare("CALL spConsultarProgresoCliente(?)");
            $stmt -> bind_param("i", $idCliente);
            $stmt -> execute();
            $response = $stmt -> get_result();

            $datos = [];
            while($fila = $response -> fetch_assoc())
            {
                $datos[] = $fila;
            }

            $stmt -> close();
            CloseDB($conn);
            return $datos;
        }
        catch(Exception $e)
        {
            AddError($e, 'ConsultarProgresoClienteModel');
            return [];
        }
    }

    /**
     * Seguimiento general del progreso con filtros opcionales (RF08).
     */
    function ConsultarProgresoGeneralModel($idCliente, $fechaInicio, $fechaFin)
    {
        try
        {
            $conn = OpenDB();

            $idCliente   = ($idCliente == "" || $idCliente == 0) ? null : $idCliente;
            $fechaInicio = ($fechaInicio == "") ? null : $fechaInicio;
            $fechaFin    = ($fechaFin == "") ? null : $fechaFin;

            $stmt = $conn -> prepare("CALL spConsultarProgresoGeneral(?,?,?)");
            $stmt -> bind_param("iss", $idCliente, $fechaInicio, $fechaFin);
            $stmt -> execute();
            $response = $stmt -> get_result();

            $datos = [];
            while($fila = $response -> fetch_assoc())
            {
                $datos[] = $fila;
            }

            $stmt -> close();
            CloseDB($conn);
            return $datos;
        }
        catch(Exception $e)
        {
            AddError($e, 'ConsultarProgresoGeneralModel');
            return [];
        }
    }

    /**
     * Guarda la retroalimentacion del administrador (RF08).
     */
    function RegistrarRetroalimentacionModel($idProgreso, $comentarioAdmin)
    {
        try
        {
            $conn = OpenDB();

            $stmt = $conn -> prepare("CALL spRegistrarRetroalimentacion(?,?)");
            $stmt -> bind_param("is", $idProgreso, $comentarioAdmin);
            $response = $stmt -> execute();
            $stmt -> close();

            CloseDB($conn);
            return $response;
        }
        catch(Exception $e)
        {
            AddError($e, 'RegistrarRetroalimentacionModel');
            return false;
        }
    }
