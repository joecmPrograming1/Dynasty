<?php
/* ============================================================
 * Proyecto : Dynasty - Sistema de gestion de rutinas
 * Curso    : Ambiente Web Cliente/Servidor (SC-502)
 * Archivo  : RutinaModel.php
 * Proposito: Modelo de rutinas. Acceso a datos de las rutinas y su detalle de ejercicios.
 * Requerim.: RF04
 * ============================================================ */

    include_once $_SERVER['DOCUMENT_ROOT'] . '/Dynasty/DYNASTY_WEB_proyecto/Model/UtilitarioModel.php';

    /**
     * Consulta todas las rutinas con la cantidad de ejercicios que contienen.
     */
    function ConsultarRutinasModel()
    {
        try
        {
            $conn = OpenDB();

            $sql = "CALL spConsultarRutinas()";
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
            AddError($e, 'ConsultarRutinasModel');
            return [];
        }
    }

    /**
     * Consulta una rutina especifica.
     */
    function ConsultarRutinaModel($idRutina)
    {
        try
        {
            $conn = OpenDB();

            $stmt = $conn -> prepare("CALL spConsultarRutina(?)");
            $stmt -> bind_param("i", $idRutina);
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
            AddError($e, 'ConsultarRutinaModel');
            return null;
        }
    }

    /**
     * Consulta los ejercicios que componen una rutina, en su orden.
     */
    function ConsultarDetalleRutinaModel($idRutina)
    {
        try
        {
            $conn = OpenDB();

            $stmt = $conn -> prepare("CALL spConsultarDetalleRutina(?)");
            $stmt -> bind_param("i", $idRutina);
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
            AddError($e, 'ConsultarDetalleRutinaModel');
            return [];
        }
    }

    /**
     * Registra una rutina junto con su detalle de ejercicios.
     * El encabezado y todos los detalles se guardan dentro de una
     * transaccion: si falla algo, no queda una rutina incompleta.
     *
     * @param array $ejercicios Lista de ejercicios con sus parametros.
     */
    function RegistrarRutinaModel($nombre, $objetivo, $nivel, $descripcion, $ejercicios)
    {
        $conn = null;

        try
        {
            $conn = OpenDB();
            $conn -> begin_transaction();

            // Encabezado de la rutina
            $stmt = $conn -> prepare("CALL spRegistrarRutina(?,?,?,?)");
            $stmt -> bind_param("ssss", $nombre, $objetivo, $nivel, $descripcion);
            $stmt -> execute();
            $response = $stmt -> get_result();

            $idRutina = 0;
            while($fila = $response -> fetch_assoc())
            {
                $idRutina = $fila["id_rutina"];
            }
            $stmt -> close();
            $conn -> next_result();

            if($idRutina == 0)
            {
                $conn -> rollback();
                CloseDB($conn);
                return false;
            }

            // Detalle de ejercicios
            foreach($ejercicios as $ejercicio)
            {
                $stmt = $conn -> prepare("CALL spAgregarEjercicioRutina(?,?,?,?,?,?,?,?)");
                $stmt -> bind_param("iiiiiisi",
                    $idRutina,
                    $ejercicio["idEjercicio"],
                    $ejercicio["series"],
                    $ejercicio["repeticiones"],
                    $ejercicio["duracion"],
                    $ejercicio["descanso"],
                    $ejercicio["indicaciones"],
                    $ejercicio["orden"]
                );
                $stmt -> execute();
                $stmt -> close();
                $conn -> next_result();
            }

            $conn -> commit();
            CloseDB($conn);
            return $idRutina;
        }
        catch(Exception $e)
        {
            if($conn != null)
            {
                $conn -> rollback();
                CloseDB($conn);
            }

            AddError($e, 'RegistrarRutinaModel');
            return false;
        }
    }

    /**
     * Actualiza una rutina y reemplaza su detalle de ejercicios.
     * Todo ocurre dentro de una transaccion.
     */
    function ActualizarRutinaModel($idRutina, $nombre, $objetivo, $nivel, $descripcion, $estado, $ejercicios)
    {
        $conn = null;

        try
        {
            $conn = OpenDB();
            $conn -> begin_transaction();

            // Encabezado
            $stmt = $conn -> prepare("CALL spActualizarRutina(?,?,?,?,?,?)");
            $stmt -> bind_param("issssi", $idRutina, $nombre, $objetivo, $nivel, $descripcion, $estado);
            $stmt -> execute();
            $stmt -> close();
            $conn -> next_result();

            // Se reemplaza el detalle completo
            $stmt = $conn -> prepare("CALL spLimpiarDetalleRutina(?)");
            $stmt -> bind_param("i", $idRutina);
            $stmt -> execute();
            $stmt -> close();
            $conn -> next_result();

            foreach($ejercicios as $ejercicio)
            {
                $stmt = $conn -> prepare("CALL spAgregarEjercicioRutina(?,?,?,?,?,?,?,?)");
                $stmt -> bind_param("iiiiiisi",
                    $idRutina,
                    $ejercicio["idEjercicio"],
                    $ejercicio["series"],
                    $ejercicio["repeticiones"],
                    $ejercicio["duracion"],
                    $ejercicio["descanso"],
                    $ejercicio["indicaciones"],
                    $ejercicio["orden"]
                );
                $stmt -> execute();
                $stmt -> close();
                $conn -> next_result();
            }

            $conn -> commit();
            CloseDB($conn);
            return true;
        }
        catch(Exception $e)
        {
            if($conn != null)
            {
                $conn -> rollback();
                CloseDB($conn);
            }

            AddError($e, 'ActualizarRutinaModel');
            return false;
        }
    }

    /**
     * Activa o desactiva una rutina (no se elimina para conservar el historial).
     */
    function CambiarEstadoRutinaModel($idRutina, $estado)
    {
        try
        {
            $conn = OpenDB();

            $stmt = $conn -> prepare("CALL spCambiarEstadoRutina(?,?)");
            $stmt -> bind_param("ii", $idRutina, $estado);
            $response = $stmt -> execute();
            $stmt -> close();

            CloseDB($conn);
            return $response;
        }
        catch(Exception $e)
        {
            AddError($e, 'CambiarEstadoRutinaModel');
            return false;
        }
    }

    /**
     * Indica cuantas veces ha sido asignada una rutina.
     * Se utiliza para advertir al administrador antes de editarla.
     */
    function ContarAsignacionesRutinaModel($idRutina)
    {
        try
        {
            $conn = OpenDB();

            $stmt = $conn -> prepare("CALL spContarAsignacionesRutina(?)");
            $stmt -> bind_param("i", $idRutina);
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
            AddError($e, 'ContarAsignacionesRutinaModel');
            return 0;
        }
    }

    /**
     * Ejercicios activos disponibles para construir rutinas.
     */
    function ConsultarEjerciciosActivosModel()
    {
        try
        {
            $conn = OpenDB();

            $sql = "CALL spConsultarEjerciciosActivos()";
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
            AddError($e, 'ConsultarEjerciciosActivosModel');
            return [];
        }
    }
