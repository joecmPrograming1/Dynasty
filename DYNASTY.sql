CREATE DATABASE  IF NOT EXISTS `dynasty` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;
USE `dynasty`;
-- MySQL dump 10.13  Distrib 8.0.46, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: dynasty
-- ------------------------------------------------------
-- Server version	5.5.5-10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `asignacion_rutina`
--

DROP TABLE IF EXISTS `asignacion_rutina`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `asignacion_rutina` (
  `id_asignacion` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_cliente` int(10) unsigned NOT NULL,
  `id_rutina` int(10) unsigned NOT NULL,
  `fecha_asignacion` date NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date DEFAULT NULL,
  `estado` varchar(20) NOT NULL DEFAULT 'PENDIENTE',
  `observacion_admin` varchar(300) DEFAULT NULL,
  PRIMARY KEY (`id_asignacion`),
  KEY `FK_asig_cliente` (`id_cliente`),
  KEY `FK_asig_rutina` (`id_rutina`),
  CONSTRAINT `FK_asig_cliente` FOREIGN KEY (`id_cliente`) REFERENCES `cliente` (`id_cliente`),
  CONSTRAINT `FK_asig_rutina` FOREIGN KEY (`id_rutina`) REFERENCES `rutina` (`id_rutina`),
  CONSTRAINT `CHK_asig_estado` CHECK (`estado` in ('PENDIENTE','EN_PROCESO','FINALIZADA','CANCELADA')),
  CONSTRAINT `CHK_asig_fechas` CHECK (`fecha_fin` is null or `fecha_fin` >= `fecha_inicio`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `asignacion_rutina`
--

LOCK TABLES `asignacion_rutina` WRITE;
/*!40000 ALTER TABLE `asignacion_rutina` DISABLE KEYS */;
/*!40000 ALTER TABLE `asignacion_rutina` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cliente`
--

DROP TABLE IF EXISTS `cliente`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cliente` (
  `id_cliente` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_usuario` int(10) unsigned NOT NULL,
  `objetivo_principal` varchar(180) NOT NULL,
  `nivel_actual` varchar(20) NOT NULL,
  `disponibilidad_semanal` varchar(120) NOT NULL,
  `observaciones` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`id_cliente`),
  UNIQUE KEY `UQ_cliente_usuario` (`id_usuario`),
  CONSTRAINT `FK_cliente_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`) ON UPDATE CASCADE,
  CONSTRAINT `CHK_cliente_nivel` CHECK (`nivel_actual` in ('PRINCIPIANTE','INTERMEDIO','AVANZADO'))
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cliente`
--

LOCK TABLES `cliente` WRITE;
/*!40000 ALTER TABLE `cliente` DISABLE KEYS */;
INSERT INTO `cliente` VALUES (1,2,'Bajar de peso','PRINCIPIANTE','3 dias por semana','Prefiere entrenar en las mananas.'),(2,3,'Ganar masa muscular','INTERMEDIO','5 dias por semana','Molestia antigua en el hombro derecho.'),(3,4,'Mejorar resistencia cardiovascular','PRINCIPIANTE','4 dias por semana','Retoma el ejercicio despues de un ano.'),(4,5,'Tonificar y ganar fuerza','AVANZADO','6 dias por semana','Compite en carreras recreativas.');
/*!40000 ALTER TABLE `cliente` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ejercicio`
--

DROP TABLE IF EXISTS `ejercicio`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ejercicio` (
  `id_ejercicio` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nombre_ejercicio` varchar(120) NOT NULL,
  `categoria` varchar(50) NOT NULL,
  `descripcion` varchar(500) NOT NULL,
  `equipo_requerido` varchar(150) DEFAULT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id_ejercicio`),
  UNIQUE KEY `UQ_ejercicio_nombre` (`nombre_ejercicio`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ejercicio`
--

LOCK TABLES `ejercicio` WRITE;
/*!40000 ALTER TABLE `ejercicio` DISABLE KEYS */;
INSERT INTO `ejercicio` VALUES (1,'Sentadilla con barra','Fuerza','Flexion de rodillas y cadera bajando el tronco con la espalda recta, con la barra sobre los hombros.','Barra y discos',1),(2,'Press de banca','Fuerza','Acostado en banca, empuja la barra desde el pecho hasta extender los brazos.','Barra, banca y discos',1),(3,'Plancha abdominal','Core','Cuerpo recto apoyado en antebrazos y punta de pies, activando el abdomen.','Peso corporal',1),(4,'Burpees','Cardio','Combinacion continua de sentadilla, plancha y salto vertical.','Peso corporal',1),(5,'Remo con mancuerna','Fuerza','Con el torso inclinado, jala la mancuerna hacia la cadera contrayendo la espalda.','Mancuerna y banco',1),(6,'Saltar la cuerda','Cardio','Saltos continuos pasando la cuerda bajo los pies a ritmo constante.','Cuerda para saltar',1);
/*!40000 ALTER TABLE `ejercicio` ENABLE KEYS */;
UNLOCK TABLES;


--
-- Table structure for table `nivel`
--

DROP TABLE IF EXISTS `nivel`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `nivel` (
  `id_nivel`     smallint unsigned NOT NULL AUTO_INCREMENT,
  `codigo_nivel` varchar(20) NOT NULL,
  `descripcion`  varchar(50) NOT NULL,
  `orden`        smallint unsigned NOT NULL,
  `estado`       tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id_nivel`),
  UNIQUE KEY `UQ_nivel_codigo` (`codigo_nivel`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nivel`
--

LOCK TABLES `nivel` WRITE;
INSERT INTO `nivel` VALUES (1,'PRINCIPIANTE','Principiante',1,1),(2,'INTERMEDIO','Intermedio',2,1),(3,'AVANZADO','Avanzado',3,1);
UNLOCK TABLES;

--
-- Procedure `spConsultarNiveles`
--

DROP PROCEDURE IF EXISTS `spConsultarNiveles`;
DELIMITER ;;
CREATE PROCEDURE `spConsultarNiveles`()
BEGIN
    SELECT id_nivel, codigo_nivel, descripcion
    FROM nivel
    WHERE estado = 1
    ORDER BY orden;
END ;;
DELIMITER ;

--
-- Table structure for table `registro_progreso`
--

DROP TABLE IF EXISTS `registro_progreso`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `registro_progreso` (
  `id_progreso` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_asignacion` int(10) unsigned NOT NULL,
  `fecha_entrenamiento` date NOT NULL,
  `fecha_registro` datetime NOT NULL DEFAULT current_timestamp(),
  `estado_cumplimiento` varchar(20) NOT NULL,
  `percepcion_esfuerzo` tinyint(3) unsigned NOT NULL,
  `duracion_minutos` smallint(5) unsigned DEFAULT NULL,
  `comentario_cliente` varchar(500) DEFAULT NULL,
  `comentario_admin` varchar(500) DEFAULT NULL,
  `fecha_retroalimentacion` datetime DEFAULT NULL,
  PRIMARY KEY (`id_progreso`),
  UNIQUE KEY `UQ_prog_asig_fecha` (`id_asignacion`,`fecha_entrenamiento`),
  CONSTRAINT `FK_prog_asignacion` FOREIGN KEY (`id_asignacion`) REFERENCES `asignacion_rutina` (`id_asignacion`),
  CONSTRAINT `CHK_prog_cumplimiento` CHECK (`estado_cumplimiento` in ('COMPLETO','PARCIAL','NO_REALIZADO')),
  CONSTRAINT `CHK_prog_esfuerzo` CHECK (`percepcion_esfuerzo` between 1 and 10)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `registro_progreso`
--

LOCK TABLES `registro_progreso` WRITE;
/*!40000 ALTER TABLE `registro_progreso` DISABLE KEYS */;
/*!40000 ALTER TABLE `registro_progreso` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rol`
--

DROP TABLE IF EXISTS `rol`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `rol` (
  `id_rol` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `nombre_rol` varchar(30) NOT NULL,
  `descripcion` varchar(120) DEFAULT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id_rol`),
  UNIQUE KEY `UQ_rol_nombre` (`nombre_rol`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rol`
--

LOCK TABLES `rol` WRITE;
/*!40000 ALTER TABLE `rol` DISABLE KEYS */;
INSERT INTO `rol` VALUES (1,'ADMINISTRADOR','Entrenador responsable del sistema.',1),(2,'CLIENTE','Usuario que recibe y ejecuta rutinas.',1);
/*!40000 ALTER TABLE `rol` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rutina`
--

DROP TABLE IF EXISTS `rutina`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `rutina` (
  `id_rutina` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nombre_rutina` varchar(120) NOT NULL,
  `objetivo` varchar(180) NOT NULL,
  `nivel` varchar(20) NOT NULL,
  `descripcion_general` varchar(500) DEFAULT NULL,
  `fecha_creacion` datetime NOT NULL DEFAULT current_timestamp(),
  `estado` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id_rutina`),
  CONSTRAINT `CHK_rutina_nivel` CHECK (`nivel` in ('PRINCIPIANTE','INTERMEDIO','AVANZADO'))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rutina`
--

LOCK TABLES `rutina` WRITE;
/*!40000 ALTER TABLE `rutina` DISABLE KEYS */;
/*!40000 ALTER TABLE `rutina` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rutina_ejercicio`
--

DROP TABLE IF EXISTS `rutina_ejercicio`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `rutina_ejercicio` (
  `id_rutina_ejercicio` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_rutina` int(10) unsigned NOT NULL,
  `id_ejercicio` int(10) unsigned NOT NULL,
  `series` tinyint(3) unsigned NOT NULL,
  `repeticiones` smallint(5) unsigned DEFAULT NULL,
  `duracion_segundos` smallint(5) unsigned DEFAULT NULL,
  `descanso_segundos` smallint(5) unsigned NOT NULL DEFAULT 0,
  `indicaciones` varchar(300) DEFAULT NULL,
  `orden` smallint(5) unsigned NOT NULL,
  PRIMARY KEY (`id_rutina_ejercicio`),
  UNIQUE KEY `UQ_rutina_orden` (`id_rutina`,`orden`),
  KEY `FK_re_ejercicio` (`id_ejercicio`),
  CONSTRAINT `FK_re_ejercicio` FOREIGN KEY (`id_ejercicio`) REFERENCES `ejercicio` (`id_ejercicio`),
  CONSTRAINT `FK_re_rutina` FOREIGN KEY (`id_rutina`) REFERENCES `rutina` (`id_rutina`) ON DELETE CASCADE,
  CONSTRAINT `CHK_re_series` CHECK (`series` between 1 and 20),
  CONSTRAINT `CHK_re_medida` CHECK (`repeticiones` > 0 or `duracion_segundos` > 0)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rutina_ejercicio`
--

LOCK TABLES `rutina_ejercicio` WRITE;
/*!40000 ALTER TABLE `rutina_ejercicio` DISABLE KEYS */;
/*!40000 ALTER TABLE `rutina_ejercicio` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_error`
--

DROP TABLE IF EXISTS `tb_error`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tb_error` (
  `Consecutivo` int(11) NOT NULL AUTO_INCREMENT,
  `Mensaje` varchar(8000) NOT NULL,
  `FechaHora` datetime NOT NULL,
  `Accion` varchar(100) NOT NULL,
  `ConsecutivoUsuario` int(11) NOT NULL,
  PRIMARY KEY (`Consecutivo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_error`
--

LOCK TABLES `tb_error` WRITE;
/*!40000 ALTER TABLE `tb_error` DISABLE KEYS */;
/*!40000 ALTER TABLE `tb_error` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuario`
--

DROP TABLE IF EXISTS `usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usuario` (
  `id_usuario` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_rol` smallint(5) unsigned NOT NULL,
  `identificacion` varchar(25) NOT NULL,
  `nombre` varchar(80) NOT NULL,
  `apellidos` varchar(120) NOT NULL,
  `correo` varchar(150) NOT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `contrasena_hash` varchar(255) NOT NULL,
  `fecha_registro` datetime NOT NULL DEFAULT current_timestamp(),
  `estado` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id_usuario`),
  UNIQUE KEY `UQ_usuario_identificacion` (`identificacion`),
  UNIQUE KEY `UQ_usuario_correo` (`correo`),
  KEY `FK_usuario_rol` (`id_rol`),
  CONSTRAINT `FK_usuario_rol` FOREIGN KEY (`id_rol`) REFERENCES `rol` (`id_rol`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuario`
--

LOCK TABLES `usuario` WRITE;
/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
INSERT INTO `usuario` VALUES (1,1,'119564317','Administrador','Dynasty','admin@dynasty.com','','$2y$10$/mYutOLvgpIaUlYsM564c.kQc0MLRyXYqPTR4M2XlaDcufYGNEeZe','2026-07-21 20:12:16',1),(2,2,'118820456','Ana','Jimenez Rojas','ana.jimenez@gmail.com','88012345','$2y$10$xBKHHfjFo219gSzP4m13..FmKVBJ/evl9hlZtwgJP2y5POQHxFePe','2026-07-21 20:12:16',1),(3,2,'205430876','Carlos','Mora Vargas','carlos.mora@gmail.com','87654321','$2y$10$xBKHHfjFo219gSzP4m13..FmKVBJ/evl9hlZtwgJP2y5POQHxFePe','2026-07-21 20:12:16',1),(4,2,'113450987','Maria','Solis Campos','maria.solis@gmail.com','86009988','$2y$10$xBKHHfjFo219gSzP4m13..FmKVBJ/evl9hlZtwgJP2y5POQHxFePe','2026-07-21 20:12:16',1),(5,2,'304560123','Diego','Herrera Nunez','diego.herrera@gmail.com','83221100','$2y$10$xBKHHfjFo219gSzP4m13..FmKVBJ/evl9hlZtwgJP2y5POQHxFePe','2026-07-21 20:12:16',1);
/*!40000 ALTER TABLE `usuario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'dynasty'
--
/*!50003 DROP PROCEDURE IF EXISTS `spActualizarCliente` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `spActualizarCliente`(
    pIdCliente             int unsigned,
    pIdentificacion        varchar(25),
    pNombre                varchar(80),
    pApellidos             varchar(120),
    pCorreo                varchar(150),
    pTelefono              varchar(20),
    pObjetivoPrincipal     varchar(180),
    pNivelActual           varchar(20),
    pDisponibilidadSemanal varchar(120),
    pObservaciones         varchar(500)
)
BEGIN
    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        ROLLBACK;
        RESIGNAL;
    END;

    START TRANSACTION;

    UPDATE usuario u
    INNER JOIN cliente c ON u.id_usuario = c.id_usuario
    SET u.identificacion = pIdentificacion,
        u.nombre         = pNombre,
        u.apellidos      = pApellidos,
        u.correo         = pCorreo,
        u.telefono       = pTelefono
    WHERE c.id_cliente = pIdCliente;

    UPDATE cliente
    SET objetivo_principal     = pObjetivoPrincipal,
        nivel_actual           = pNivelActual,
        disponibilidad_semanal = pDisponibilidadSemanal,
        observaciones          = pObservaciones
    WHERE id_cliente = pIdCliente;

    COMMIT;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `spActualizarContrasena` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `spActualizarContrasena`(
    pIdUsuario      int unsigned,
    pContrasenaHash varchar(255)
)
BEGIN
    UPDATE usuario
    SET contrasena_hash = pContrasenaHash
    WHERE id_usuario = pIdUsuario;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `spActualizarEjercicio` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `spActualizarEjercicio`(
    pIdEjercicio     int unsigned,
    pNombreEjercicio varchar(120),
    pCategoria       varchar(50),
    pDescripcion     varchar(500),
    pEquipoRequerido varchar(150)
)
BEGIN
    UPDATE ejercicio
    SET nombre_ejercicio = pNombreEjercicio,
        categoria        = pCategoria,
        descripcion      = pDescripcion,
        equipo_requerido = pEquipoRequerido
    WHERE id_ejercicio = pIdEjercicio;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `spActualizarPerfil` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `spActualizarPerfil`(
    pIdUsuario      int unsigned,
    pIdentificacion varchar(25),
    pNombre         varchar(80),
    pApellidos      varchar(120),
    pCorreo         varchar(150),
    pTelefono       varchar(20)
)
BEGIN
    UPDATE usuario
    SET identificacion = pIdentificacion,
        nombre         = pNombre,
        apellidos      = pApellidos,
        correo         = pCorreo,
        telefono       = pTelefono
    WHERE id_usuario = pIdUsuario;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `spActualizarRutina` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `spActualizarRutina`(
    pIdRutina           int unsigned,
    pNombreRutina       varchar(120),
    pObjetivo           varchar(180),
    pNivel              varchar(20),
    pDescripcionGeneral varchar(500),
    pEstado             tinyint
)
BEGIN
    UPDATE rutina
    SET nombre_rutina       = pNombreRutina,
        objetivo            = pObjetivo,
        nivel               = pNivel,
        descripcion_general = pDescripcionGeneral,
        estado              = pEstado
    WHERE id_rutina = pIdRutina;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `spAgregarEjercicioRutina` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `spAgregarEjercicioRutina`(
    pIdRutina         int unsigned,
    pIdEjercicio      int unsigned,
    pSeries           tinyint unsigned,
    pRepeticiones     smallint unsigned,
    pDuracionSegundos smallint unsigned,
    pDescansoSegundos smallint unsigned,
    pIndicaciones     varchar(300),
    pOrden            smallint unsigned
)
BEGIN
    INSERT INTO rutina_ejercicio (id_rutina, id_ejercicio, series, repeticiones, duracion_segundos, descanso_segundos, indicaciones, orden)
    VALUES (pIdRutina, pIdEjercicio, pSeries, pRepeticiones, pDuracionSegundos, pDescansoSegundos, pIndicaciones, pOrden);
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `spAsignarRutina` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `spAsignarRutina`(
    pIdCliente        int unsigned,
    pIdRutina         int unsigned,
    pFechaInicio      date,
    pFechaFin         date,
    pObservacionAdmin varchar(300)
)
BEGIN
    INSERT INTO asignacion_rutina (id_cliente, id_rutina, fecha_asignacion, fecha_inicio, fecha_fin, estado, observacion_admin)
    VALUES (pIdCliente, pIdRutina, CURDATE(), pFechaInicio, pFechaFin, 'PENDIENTE', pObservacionAdmin);
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `spCambiarEstadoAsignacion` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `spCambiarEstadoAsignacion`(
    pIdAsignacion int unsigned,
    pEstado       varchar(20)
)
BEGIN
    UPDATE asignacion_rutina
    SET estado = pEstado
    WHERE id_asignacion = pIdAsignacion;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `spCambiarEstadoCliente` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `spCambiarEstadoCliente`(
    pIdCliente int unsigned,
    pEstado    tinyint
)
BEGIN
    UPDATE usuario u
    INNER JOIN cliente c ON u.id_usuario = c.id_usuario
    SET u.estado = pEstado
    WHERE c.id_cliente = pIdCliente;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `spCambiarEstadoEjercicio` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `spCambiarEstadoEjercicio`(
    pIdEjercicio int unsigned,
    pEstado      tinyint
)
BEGIN
    UPDATE ejercicio
    SET estado = pEstado
    WHERE id_ejercicio = pIdEjercicio;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `spConsultarAsignacionActivaCliente` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarAsignacionActivaCliente`(
    pIdCliente int unsigned
)
BEGIN
    -- Valida que un cliente solo tenga una asignación vigente
    SELECT  a.id_asignacion,
            r.id_rutina,
            r.nombre_rutina,
            r.objetivo,
            r.nivel,
            r.descripcion_general,
            a.fecha_asignacion,
            a.fecha_inicio,
            a.fecha_fin,
            a.estado,
            a.observacion_admin
    FROM    asignacion_rutina a
    INNER JOIN rutina r ON a.id_rutina = r.id_rutina
    WHERE   a.id_cliente = pIdCliente
        AND a.estado IN ('PENDIENTE', 'EN_PROCESO');
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `spConsultarAsignaciones` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarAsignaciones`()
BEGIN
    SELECT  a.id_asignacion,
            CONCAT(u.nombre, ' ', u.apellidos) AS cliente,
            u.identificacion,
            r.nombre_rutina,
            a.fecha_asignacion,
            a.fecha_inicio,
            a.fecha_fin,
            a.estado,
            a.observacion_admin
    FROM    asignacion_rutina a
    INNER JOIN cliente c ON a.id_cliente = c.id_cliente
    INNER JOIN usuario u ON c.id_usuario = u.id_usuario
    INNER JOIN rutina r ON a.id_rutina = r.id_rutina
    ORDER BY a.fecha_asignacion DESC;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `spConsultarClientes` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarClientes`()
BEGIN
    SELECT  c.id_cliente,
            u.id_usuario,
            u.identificacion,
            u.nombre,
            u.apellidos,
            u.correo,
            u.telefono,
            c.objetivo_principal,
            c.nivel_actual,
            c.disponibilidad_semanal,
            c.observaciones,
            u.estado
    FROM    cliente c
    INNER JOIN usuario u ON c.id_usuario = u.id_usuario
    ORDER BY u.nombre, u.apellidos;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `spConsultarDetalleRutina` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarDetalleRutina`(
    pIdRutina int unsigned
)
BEGIN
    SELECT  re.id_rutina_ejercicio,
            re.orden,
            e.nombre_ejercicio,
            e.categoria,
            re.series,
            re.repeticiones,
            re.duracion_segundos,
            re.descanso_segundos,
            re.indicaciones
    FROM    rutina_ejercicio re
    INNER JOIN ejercicio e ON re.id_ejercicio = e.id_ejercicio
    WHERE   re.id_rutina = pIdRutina
    ORDER BY re.orden;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `spConsultarEjercicios` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarEjercicios`()
BEGIN
    SELECT id_ejercicio, nombre_ejercicio, categoria, descripcion, equipo_requerido, estado
    FROM ejercicio
    ORDER BY nombre_ejercicio;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `spConsultarProgresoAsignacion` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarProgresoAsignacion`(
    pIdAsignacion int unsigned
)
BEGIN
    SELECT  id_progreso,
            fecha_entrenamiento,
            fecha_registro,
            estado_cumplimiento,
            percepcion_esfuerzo,
            duracion_minutos,
            comentario_cliente,
            comentario_admin,
            fecha_retroalimentacion
    FROM    registro_progreso
    WHERE   id_asignacion = pIdAsignacion
    ORDER BY fecha_entrenamiento DESC;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `spConsultarRutinas` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarRutinas`()
BEGIN
    SELECT  r.id_rutina,
            r.nombre_rutina,
            r.objetivo,
            r.nivel,
            r.descripcion_general,
            r.fecha_creacion,
            r.estado,
            COUNT(re.id_rutina_ejercicio) AS total_ejercicios
    FROM    rutina r
    LEFT JOIN rutina_ejercicio re ON r.id_rutina = re.id_rutina
    GROUP BY r.id_rutina
    ORDER BY r.fecha_creacion DESC;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `spConsultarUsuario` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarUsuario`(
    pIdUsuario int unsigned
)
BEGIN
    SELECT id_usuario, identificacion, nombre, apellidos, correo, telefono
    FROM usuario
    WHERE id_usuario = pIdUsuario;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `spIniciarSesion` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `spIniciarSesion`(
    pCredencial varchar(150)
)
BEGIN
    -- Devuelve el hash; la verificación se hace en PHP con password_verify
    SELECT  u.id_usuario,
            u.id_rol,
            r.nombre_rol,
            u.identificacion,
            u.nombre,
            u.apellidos,
            u.correo,
            u.contrasena_hash,
            u.estado
    FROM    usuario u
    INNER JOIN rol r ON u.id_rol = r.id_rol
    WHERE   (u.identificacion = pCredencial OR u.correo = pCredencial)
        AND u.estado = 1
        AND r.estado = 1;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `spLimpiarDetalleRutina` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `spLimpiarDetalleRutina`(
    pIdRutina int unsigned
)
BEGIN
    -- Solo se usa al editar una rutina que aún no ha sido asignada
    DELETE FROM rutina_ejercicio
    WHERE id_rutina = pIdRutina;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `spRegistrarCliente` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `spRegistrarCliente`(
    pIdentificacion        varchar(25),
    pNombre                varchar(80),
    pApellidos             varchar(120),
    pCorreo                varchar(150),
    pTelefono              varchar(20),
    pContrasenaHash        varchar(255),
    pObjetivoPrincipal     varchar(180),
    pNivelActual           varchar(20),
    pDisponibilidadSemanal varchar(120),
    pObservaciones         varchar(500)
)
BEGIN
    DECLARE vIdUsuario int unsigned;
    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        ROLLBACK;
        RESIGNAL;
    END;

    START TRANSACTION;

    INSERT INTO usuario (id_rol, identificacion, nombre, apellidos, correo, telefono, contrasena_hash, estado)
    VALUES (2, pIdentificacion, pNombre, pApellidos, pCorreo, pTelefono, pContrasenaHash, 1);

    SET vIdUsuario = LAST_INSERT_ID();

    INSERT INTO cliente (id_usuario, objetivo_principal, nivel_actual, disponibilidad_semanal, observaciones)
    VALUES (vIdUsuario, pObjetivoPrincipal, pNivelActual, pDisponibilidadSemanal, pObservaciones);

    COMMIT;

    SELECT vIdUsuario AS id_usuario, LAST_INSERT_ID() AS id_cliente;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `spRegistrarEjercicio` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `spRegistrarEjercicio`(
    pNombreEjercicio varchar(120),
    pCategoria       varchar(50),
    pDescripcion     varchar(500),
    pEquipoRequerido varchar(150)
)
BEGIN
    INSERT INTO ejercicio (nombre_ejercicio, categoria, descripcion, equipo_requerido, estado)
    VALUES (pNombreEjercicio, pCategoria, pDescripcion, pEquipoRequerido, 1);
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `spRegistrarError` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `spRegistrarError`(
    pMensaje            varchar(8000),
    pAccion             varchar(100),
    pConsecutivoUsuario int(11)
)
BEGIN
    INSERT INTO tb_error (Mensaje, FechaHora, Accion, ConsecutivoUsuario)
    VALUES (pMensaje, NOW(), pAccion, pConsecutivoUsuario);
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `spRegistrarProgreso` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `spRegistrarProgreso`(
    pIdAsignacion        int unsigned,
    pFechaEntrenamiento  date,
    pEstadoCumplimiento  varchar(20),
    pPercepcionEsfuerzo  tinyint unsigned,
    pDuracionMinutos     smallint unsigned,
    pComentarioCliente   varchar(500)
)
BEGIN
    INSERT INTO registro_progreso (id_asignacion, fecha_entrenamiento, estado_cumplimiento, percepcion_esfuerzo, duracion_minutos, comentario_cliente)
    VALUES (pIdAsignacion, pFechaEntrenamiento, pEstadoCumplimiento, pPercepcionEsfuerzo, pDuracionMinutos, pComentarioCliente);

    -- La primera actividad reportada cambia la asignación a EN_PROCESO
    UPDATE asignacion_rutina
    SET estado = 'EN_PROCESO'
    WHERE id_asignacion = pIdAsignacion
      AND estado = 'PENDIENTE';
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `spRegistrarRetroalimentacion` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `spRegistrarRetroalimentacion`(
    pIdProgreso      int unsigned,
    pComentarioAdmin varchar(500)
)
BEGIN
    UPDATE registro_progreso
    SET comentario_admin        = pComentarioAdmin,
        fecha_retroalimentacion = NOW()
    WHERE id_progreso = pIdProgreso;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `spRegistrarRutina` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `spRegistrarRutina`(
    pNombreRutina       varchar(120),
    pObjetivo           varchar(180),
    pNivel              varchar(20),
    pDescripcionGeneral varchar(500)
)
BEGIN
    INSERT INTO rutina (nombre_rutina, objetivo, nivel, descripcion_general, estado)
    VALUES (pNombreRutina, pObjetivo, pNivel, pDescripcionGeneral, 1);

    SELECT LAST_INSERT_ID() AS id_rutina;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `spValidarCorreo` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `spValidarCorreo`(
    pCorreo varchar(150)
)
BEGIN
    SELECT id_usuario, nombre, apellidos, correo
    FROM usuario
    WHERE correo = pCorreo
      AND estado = 1;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-07-21 20:52:46


-- ============================================================
-- PROCEDIMIENTOS DE RUTINAS, ASIGNACIONES Y PROGRESO
-- (RF04 a RF08)
-- ============================================================

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
