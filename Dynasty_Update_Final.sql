-- ============================================================
-- DYNASTY - Procedimientos para RF04 a RF08
-- Ejecutar sobre la base existente. No borra datos.
-- ============================================================
USE `dynasty`;

-- ------------------------------------------------------------
-- Obtiene el perfil de cliente a partir del usuario en sesion.
-- Se usa en Mi rutina y Mi progreso (RF06/RF07).
-- ------------------------------------------------------------
DROP PROCEDURE IF EXISTS `spConsultarClientePorUsuario`;
DELIMITER ;;
CREATE PROCEDURE `spConsultarClientePorUsuario`(
    pIdUsuario int unsigned
)
BEGIN
    SELECT  c.id_cliente,
            c.objetivo_principal,
            c.nivel_actual,
            c.disponibilidad_semanal
    FROM    cliente c
    WHERE   c.id_usuario = pIdUsuario;
END ;;
DELIMITER ;

-- ------------------------------------------------------------
-- Consulta una rutina especifica (para cargarla al editar).
-- ------------------------------------------------------------
DROP PROCEDURE IF EXISTS `spConsultarRutina`;
DELIMITER ;;
CREATE PROCEDURE `spConsultarRutina`(
    pIdRutina int unsigned
)
BEGIN
    SELECT  id_rutina,
            nombre_rutina,
            objetivo,
            nivel,
            descripcion_general,
            estado
    FROM    rutina
    WHERE   id_rutina = pIdRutina;
END ;;
DELIMITER ;

-- ------------------------------------------------------------
-- Cambia el estado de una rutina (activar / desactivar).
-- ------------------------------------------------------------
DROP PROCEDURE IF EXISTS `spCambiarEstadoRutina`;
DELIMITER ;;
CREATE PROCEDURE `spCambiarEstadoRutina`(
    pIdRutina int unsigned,
    pEstado   tinyint
)
BEGIN
    UPDATE rutina
    SET estado = pEstado
    WHERE id_rutina = pIdRutina;
END ;;
DELIMITER ;

-- ------------------------------------------------------------
-- Indica si una rutina ya fue asignada a algun cliente.
-- Sirve para saber si su detalle puede reemplazarse.
-- ------------------------------------------------------------
DROP PROCEDURE IF EXISTS `spContarAsignacionesRutina`;
DELIMITER ;;
CREATE PROCEDURE `spContarAsignacionesRutina`(
    pIdRutina int unsigned
)
BEGIN
    SELECT COUNT(*) AS Total
    FROM asignacion_rutina
    WHERE id_rutina = pIdRutina;
END ;;
DELIMITER ;

-- ------------------------------------------------------------
-- Ejercicios activos para construir rutinas (RF03/RF04).
-- ------------------------------------------------------------
DROP PROCEDURE IF EXISTS `spConsultarEjerciciosActivos`;
DELIMITER ;;
CREATE PROCEDURE `spConsultarEjerciciosActivos`()
BEGIN
    SELECT  id_ejercicio,
            nombre_ejercicio,
            categoria
    FROM    ejercicio
    WHERE   estado = 1
    ORDER BY categoria, nombre_ejercicio;
END ;;
DELIMITER ;

-- ------------------------------------------------------------
-- Clientes activos para el panel de asignacion (RF05).
-- ------------------------------------------------------------
DROP PROCEDURE IF EXISTS `spConsultarClientesActivos`;
DELIMITER ;;
CREATE PROCEDURE `spConsultarClientesActivos`()
BEGIN
    SELECT  c.id_cliente,
            u.identificacion,
            CONCAT(u.nombre, ' ', u.apellidos) AS cliente,
            c.nivel_actual
    FROM    cliente c
    INNER JOIN usuario u ON c.id_usuario = u.id_usuario
    WHERE   u.estado = 1
    ORDER BY u.nombre, u.apellidos;
END ;;
DELIMITER ;

-- ------------------------------------------------------------
-- Rutinas activas con al menos un ejercicio (RF05).
-- ------------------------------------------------------------
DROP PROCEDURE IF EXISTS `spConsultarRutinasActivas`;
DELIMITER ;;
CREATE PROCEDURE `spConsultarRutinasActivas`()
BEGIN
    SELECT  r.id_rutina,
            r.nombre_rutina,
            r.nivel
    FROM    rutina r
    INNER JOIN rutina_ejercicio re ON r.id_rutina = re.id_rutina
    WHERE   r.estado = 1
    GROUP BY r.id_rutina
    ORDER BY r.nombre_rutina;
END ;;
DELIMITER ;

-- ------------------------------------------------------------
-- Verifica si un cliente ya tiene una asignacion vigente.
-- Un cliente no puede tener mas de una PENDIENTE o EN_PROCESO.
-- ------------------------------------------------------------
DROP PROCEDURE IF EXISTS `spContarAsignacionesVigentes`;
DELIMITER ;;
CREATE PROCEDURE `spContarAsignacionesVigentes`(
    pIdCliente int unsigned
)
BEGIN
    SELECT COUNT(*) AS Total
    FROM asignacion_rutina
    WHERE id_cliente = pIdCliente
      AND estado IN ('PENDIENTE', 'EN_PROCESO');
END ;;
DELIMITER ;

-- ------------------------------------------------------------
-- Seguimiento general del progreso (RF08).
-- Permite filtrar por cliente y por rango de fechas.
-- Los filtros son opcionales (se envian en null o vacios).
-- ------------------------------------------------------------
DROP PROCEDURE IF EXISTS `spConsultarProgresoGeneral`;
DELIMITER ;;
CREATE PROCEDURE `spConsultarProgresoGeneral`(
    pIdCliente   int unsigned,
    pFechaInicio date,
    pFechaFin    date
)
BEGIN
    SELECT  p.id_progreso,
            p.id_asignacion,
            CONCAT(u.nombre, ' ', u.apellidos) AS cliente,
            c.id_cliente,
            r.nombre_rutina,
            p.fecha_entrenamiento,
            p.estado_cumplimiento,
            p.percepcion_esfuerzo,
            p.duracion_minutos,
            p.comentario_cliente,
            p.comentario_admin,
            p.fecha_retroalimentacion
    FROM    registro_progreso p
    INNER JOIN asignacion_rutina a ON p.id_asignacion = a.id_asignacion
    INNER JOIN cliente c ON a.id_cliente = c.id_cliente
    INNER JOIN usuario u ON c.id_usuario = u.id_usuario
    INNER JOIN rutina r ON a.id_rutina = r.id_rutina
    WHERE   (pIdCliente IS NULL OR pIdCliente = 0 OR c.id_cliente = pIdCliente)
        AND (pFechaInicio IS NULL OR p.fecha_entrenamiento >= pFechaInicio)
        AND (pFechaFin IS NULL OR p.fecha_entrenamiento <= pFechaFin)
    ORDER BY p.fecha_entrenamiento DESC, u.nombre;
END ;;
DELIMITER ;

-- ------------------------------------------------------------
-- Historial de progreso de un cliente (RF07).
-- Se obtiene por id_cliente tomado de la sesion, nunca del formulario.
-- ------------------------------------------------------------
DROP PROCEDURE IF EXISTS `spConsultarProgresoCliente`;
DELIMITER ;;
CREATE PROCEDURE `spConsultarProgresoCliente`(
    pIdCliente int unsigned
)
BEGIN
    SELECT  p.id_progreso,
            r.nombre_rutina,
            p.fecha_entrenamiento,
            p.estado_cumplimiento,
            p.percepcion_esfuerzo,
            p.duracion_minutos,
            p.comentario_cliente,
            p.comentario_admin,
            p.fecha_retroalimentacion
    FROM    registro_progreso p
    INNER JOIN asignacion_rutina a ON p.id_asignacion = a.id_asignacion
    INNER JOIN rutina r ON a.id_rutina = r.id_rutina
    WHERE   a.id_cliente = pIdCliente
    ORDER BY p.fecha_entrenamiento DESC;
END ;;
DELIMITER ;

-- ------------------------------------------------------------
-- Verifica que una asignacion pertenezca a un cliente.
-- Evita que un cliente registre progreso de otra persona (RF07).
-- ------------------------------------------------------------
DROP PROCEDURE IF EXISTS `spValidarAsignacionCliente`;
DELIMITER ;;
CREATE PROCEDURE `spValidarAsignacionCliente`(
    pIdAsignacion int unsigned,
    pIdCliente    int unsigned
)
BEGIN
    SELECT  a.id_asignacion,
            a.fecha_inicio,
            a.estado
    FROM    asignacion_rutina a
    WHERE   a.id_asignacion = pIdAsignacion
        AND a.id_cliente = pIdCliente;
END ;;
DELIMITER ;

-- ------------------------------------------------------------
-- Verifica si ya existe un registro de progreso para una
-- asignacion en una fecha determinada (RF07).
-- ------------------------------------------------------------
DROP PROCEDURE IF EXISTS `spConsultarProgresoFecha`;
DELIMITER ;;
CREATE PROCEDURE `spConsultarProgresoFecha`(
    pIdAsignacion       int unsigned,
    pFechaEntrenamiento date
)
BEGIN
    SELECT id_progreso
    FROM registro_progreso
    WHERE id_asignacion = pIdAsignacion
      AND fecha_entrenamiento = pFechaEntrenamiento;
END ;;
DELIMITER ;

-- ------------------------------------------------------------
-- Actualiza un registro de progreso existente (RF07).
-- ------------------------------------------------------------
DROP PROCEDURE IF EXISTS `spActualizarProgreso`;
DELIMITER ;;
CREATE PROCEDURE `spActualizarProgreso`(
    pIdProgreso         int unsigned,
    pEstadoCumplimiento varchar(20),
    pPercepcionEsfuerzo tinyint unsigned,
    pDuracionMinutos    smallint unsigned,
    pComentarioCliente  varchar(500)
)
BEGIN
    UPDATE registro_progreso
    SET estado_cumplimiento = pEstadoCumplimiento,
        percepcion_esfuerzo = pPercepcionEsfuerzo,
        duracion_minutos    = pDuracionMinutos,
        comentario_cliente  = pComentarioCliente
    WHERE id_progreso = pIdProgreso;
END ;;
DELIMITER ;

-- ------------------------------------------------------------
-- Resumen para el panel administrativo.
-- ------------------------------------------------------------
DROP PROCEDURE IF EXISTS `spConsultarResumen`;
DELIMITER ;;
CREATE PROCEDURE `spConsultarResumen`()
BEGIN
    SELECT
        (SELECT COUNT(*) FROM cliente c
            INNER JOIN usuario u ON c.id_usuario = u.id_usuario
            WHERE u.estado = 1) AS clientes,
        (SELECT COUNT(*) FROM ejercicio WHERE estado = 1) AS ejercicios,
        (SELECT COUNT(*) FROM rutina WHERE estado = 1) AS rutinas,
        (SELECT COUNT(*) FROM asignacion_rutina
            WHERE estado IN ('PENDIENTE','EN_PROCESO')) AS asignaciones;
END ;;
DELIMITER ;
