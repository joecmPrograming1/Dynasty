<?php
/* ============================================================
 * Proyecto : Dynasty - Sistema de gestion de rutinas
 * Curso    : Ambiente Web Cliente/Servidor (SC-502)
 * Archivo  : EjercicioController.php
 * Proposito: Controlador de ejercicios. Mantenimiento del catalogo de ejercicios del gimnasio.
 * Requerim.: RF03
 * ============================================================ */

    include_once $_SERVER['DOCUMENT_ROOT'] . '/Dynasty/DYNASTY_WEB_proyecto/Controller/UtilitarioController.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/Dynasty/DYNASTY_WEB_proyecto/Model/EjercicioModel.php';

    ValidarSesion("ADMINISTRADOR");

    if(isset($_POST["btnRegistrarEjercicio"]))
    {
        $nombre      = trim($_POST["nombre"]);
        $categoria   = trim($_POST["categoria"]);
        $descripcion = trim($_POST["descripcion"]);
        $equipo      = trim($_POST["equipo"]);

        if($nombre == "" || $categoria == "" || $descripcion == "")
        {
            $_POST["Mensaje"] = "El nombre, la categoría y la descripción son obligatorios.";
        }
        else
        {
            $resultado = RegistrarEjercicioModel($nombre, $categoria, $descripcion, $equipo);

            if($resultado)
            {
                header("Location: ../vEjercicio/GestionEjercicios.php?exito=registro");
                exit();
            }

            $_POST["Mensaje"] = "No se pudo registrar el ejercicio. Verifique que el nombre no esté duplicado.";
        }
    }

    if(isset($_POST["btnActualizarEjercicio"]))
    {
        $idEjercicio = $_POST["idEjercicio"];
        $nombre      = trim($_POST["nombre"]);
        $categoria   = trim($_POST["categoria"]);
        $descripcion = trim($_POST["descripcion"]);
        $equipo      = trim($_POST["equipo"]);

        if($nombre == "" || $categoria == "" || $descripcion == "")
        {
            $_POST["Mensaje"] = "El nombre, la categoría y la descripción son obligatorios.";
        }
        else
        {
            $resultado = ActualizarEjercicioModel($idEjercicio, $nombre, $categoria, $descripcion, $equipo);

            if($resultado)
            {
                header("Location: ../vEjercicio/GestionEjercicios.php?exito=actualizacion");
                exit();
            }

            $_POST["Mensaje"] = "No se pudo actualizar el ejercicio. Verifique que el nombre no esté duplicado.";
        }
    }

    if(isset($_POST["btnCambiarEstadoEjercicio"]))
    {
        $idEjercicio = $_POST["idEjercicio"];
        $estado      = $_POST["estado"];

        $resultado = CambiarEstadoEjercicioModel($idEjercicio, $estado);

        header("Location: ../vEjercicio/GestionEjercicios.php" . ($resultado ? "?exito=estado" : "?error=estado"));
        exit();
    }

    // Funciones que utiliza la vista. La vista nunca llama al modelo directamente.
    function ConsultarEjercicios()
    {
        return ConsultarEjerciciosModel();
    }
