<?php
    include_once $_SERVER['DOCUMENT_ROOT'] . '/Dynasty/DYNASTY_WEB_proyecto/Model/UtilitarioModel.php';

    function ConsultarNivelesModel()
    {
        try
        {
            $conn = OpenDB();

            $sql = "CALL spConsultarNiveles()";
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
            AddError($e, 'ConsultarNivelesModel');
            return [];
        }
    }
