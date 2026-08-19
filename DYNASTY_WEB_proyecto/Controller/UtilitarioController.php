<?php
/* ============================================================
 * Proyecto : Dynasty - Sistema de gestion de rutinas
 * Curso    : Ambiente Web Cliente/Servidor (SC-502)
 * Archivo  : UtilitarioController.php
 * Proposito: Utilitarios del sistema. Control de sesion, autorizacion por rol y envio de correo.
 * Requerim.: RF01, RNF01
 * ============================================================ */

    if(session_status() == PHP_SESSION_NONE)
    {
        session_start();
    }

    // Expiración de sesión: 30 minutos de inactividad (RNF01)
    define('TIEMPO_SESION', 1800);

    function ValidarSesion($rolRequerido = null)
    {
        if(!isset($_SESSION["IdUsuario"]))
        {
            header("Location: /Dynasty/DYNASTY_WEB_proyecto/View/vInicio/IniciarSesion.php");
            exit();
        }

        // Control de inactividad
        if(isset($_SESSION["UltimaActividad"]) && (time() - $_SESSION["UltimaActividad"]) > TIEMPO_SESION)
        {
            CerrarSesion();
        }
        $_SESSION["UltimaActividad"] = time();

        // Autorización por rol: las rutas administrativas rechazan a un cliente (RF01)
        if($rolRequerido !== null && $_SESSION["Rol"] !== $rolRequerido)
        {
            header("Location: /Dynasty/DYNASTY_WEB_proyecto/View/vInicio/Principal.php");
            exit();
        }
    }

    function CerrarSesion()
    {
        session_unset();
        session_destroy();
        header("Location: /Dynasty/DYNASTY_WEB_proyecto/View/vInicio/IniciarSesion.php?exito=salida");
        exit();
    }

    function GenerarContrasena()
    {
        $caracteres = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $contrasena = '';
        $max = strlen($caracteres) - 1;

        for($i = 0; $i < 8; $i++)
        {
            $contrasena .= $caracteres[random_int(0, $max)];
        }

        return $contrasena;
    }

    function EnviarCorreo($asunto, $contenido, $destinatario)
    {
        try
        {
            require_once $_SERVER['DOCUMENT_ROOT'] . '/Dynasty/DYNASTY_WEB_proyecto/Controller/PHPMailer/src/PHPMailer.php';
            require_once $_SERVER['DOCUMENT_ROOT'] . '/Dynasty/DYNASTY_WEB_proyecto/Controller/PHPMailer/src/SMTP.php';

            $correoSalida = "dynasty.notificaciones@gmail.com";
            $contrasenaSalida = "";

            if($contrasenaSalida == "")
            {
                return true; // Simulación de envío exitoso mientras no se configure la cuenta SMTP
            }

            $mail = new PHPMailer\PHPMailer\PHPMailer();
            $mail->CharSet = 'UTF-8';

            $mail->IsSMTP();
            $mail->IsHTML(true);
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;
            $mail->SMTPAuth = true;
            $mail->Username = $correoSalida;
            $mail->Password = $contrasenaSalida;

            $mail->SetFrom($correoSalida);
            $mail->Subject = $asunto;
            $mail->MsgHTML($contenido);
            $mail->AddAddress($destinatario);
            $mail->send();
            return true;
        }
        catch(Exception $e)
        {
            AddError($e, 'EnviarCorreo');
            return false;
        }
    }

    if(isset($_GET["accion"]) && $_GET["accion"] == "salir")
    {
        CerrarSesion();
    }
