<?php
/* ============================================================
 * Proyecto : Dynasty - Sistema de gestion de rutinas
 * Curso    : Ambiente Web Cliente/Servidor (SC-502)
 * Archivo  : AsignacionModel.php
 * Proposito: Modelo de asignaciones. Acceso a datos de las asignaciones de rutinas.
 * Requerim.: RF05, RF06, RF08
 * ============================================================ */

    include_once $_SERVER['DOCUMENT_ROOT'] . '/Dynasty/DYNASTY_WEB_proyecto/Model/UtilitarioModel.php';

    /**
     * Clientes activos disponibles para recibir una rutina (RF05).
     */
    function ConsultarClientesActivosModel()
    {
        try
        {
            $conn = OpenDB();

            $sql = "CALL spConsultarClientesActivos()";
            $response = $conn -> query($sql);

            $datos = [];
            while($fila = $response -> fetch_assoc())
            {
                $datos[] = $fila;
            }

            CloseDB($conn);
            return $datos;
        }
        catch(Exception $e)
        {
            AddError($e, 'ConsultarClientesActivosModel');
            return [];
        }
    }

    /**
     * Rutinas activas que ya tienen al menos un ejercicio (RF05).
     */
    function ConsultarRutinasActivasModel()
    {
        try
        {
            $conn = OpenDB();

            $sql = "CALL spConsultarRutinasActivas()";
            $response = $conn -> query($sql);

            $datos = [];
            while($fila = $response -> fetch_assoc())
            {
                $datos[] = $fila;
            }

            CloseDB($conn);
            return $datos;
        }
        catch(Exception $e)
        {
            AddError($e, 'ConsultarRutinasActivasModel');
            return [];
        }
    }

    /**
     * Cantidad de asignaciones vigentes de un cliente.
     * Un cliente no puede tener mas de una PENDIENTE o EN_PROCESO (RF05).
     */
    function ContarAsignacionesVigentesModel($idCliente)
    {
        try
        {
            $conn = OpenDB();

            $stmt = $conn -> prepare("CALL spContarAsignacionesVigentes(?)");
            $stmt -> bind_param("i", $idCliente);
            $stmt -> execute();
            $response = $stmt -> get_result();

            $total = 0;
            while($fila = $response -> fetch_assoc())
            {
                $total = $fila["Total"];
            }

            $stmt -> close();
            CloseDB($conn);
            return $total;
        }
        catch(Exception $e)
        {
            AddError($e, 'ContarAsignacionesVigentesModel');
            return 0;
        }
    }

    /**
     * Registra la asignacion de una rutina a un cliente (RF05).
     */
    function AsignarRutinaModel($idCliente, $idRutina, $fechaInicio, $fechaFin, $observacion)
    {
        try
        {
            $conn = OpenDB();

            $stmt = $conn -> prepare("CALL spAsignarRutina(?,?,?,?,?)");
            $stmt -> bind_param("iisss", $idCliente, $idRutina, $fechaInicio, $fechaFin, $observacion);
            $response = $stmt -> execute();
            $stmt -> close();

            CloseDB($conn);
            return $response;
        }
        catch(Exception $e)
        {
            AddError($e, 'AsignarRutinaModel');
            return false;
        }
    }

    /**
     * Listado completo de asignaciones (RF05).
     */
    function ConsultarAsignacionesModel()
    {
        try
        {
            $conn = OpenDB();

            $sql = "CALL spConsultarAsignaciones()";
            $response = $conn -> query($sql);

            $datos = [];
            while($fila = $response -> fetch_assoc())
            {
                $datos[] = $fila;
            }

            CloseDB($conn);
            return $datos;
        }
        catch(Exception $e)
        {
            AddError($e, 'ConsultarAsignacionesModel');
            return [];
        }
    }

    /**
     * Asignacion vigente de un cliente (RF06).
     */
    function ConsultarAsignacionActivaClienteModel($idCliente)
    {
        try
        {
            $conn = OpenDB();

            $stmt = $conn -> prepare("CALL spConsultarAsignacionActivaCliente(?)");
            $stmt -> bind_param("i", $idCliente);
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
            AddError($e, 'ConsultarAsignacionActivaClienteModel');
            return null;
        }
    }

    /**
     * Cambia el estado de una asignacion: FINALIZADA o CANCELADA (RF08).
     */
    function CambiarEstadoAsignacionModel($idAsignacion, $estado)
    {
        try
        {
            $conn = OpenDB();

            $stmt = $conn -> prepare("CALL spCambiarEstadoAsignacion(?,?)");
            $stmt -> bind_param("is", $idAsignacion, $estado);
            $response = $stmt -> execute();
            $stmt -> close();

            CloseDB($conn);
            return $response;
        }
        catch(Exception $e)
        {
            AddError($e, 'CambiarEstadoAsignacionModel');
            return false;
        }
    }

    /**
     * Obtiene el perfil de cliente a partir del usuario en sesion (RF06/RF07).
     */
    function ConsultarClientePorUsuarioModel($idUsuario)
    {
        try
        {
            $conn = OpenDB();

            $stmt = $conn -> prepare("CALL spConsultarClientePorUsuario(?)");
            $stmt -> bind_param("i", $idUsuario);
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
            AddError($e, 'ConsultarClientePorUsuarioModel');
            return null;
        }
    }
