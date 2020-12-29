<?php

class Comentarios extends Controllers
{
    public function __construct()
    {
        session_start();
        if (empty($_SESSION['login'])) {
            header('Location: ' . base_url() . 'login');
        }
        parent::__construct();
    }
    public function setComentario()
    {
        try {
            $intIdProyecto = intval($_POST["idProyecto"]);
            $strComentario = strClean($_POST["txtComentario"]);
            if ($intIdProyecto != '' && $strComentario != '') {
                $request = $this->model->insertComentario($intIdProyecto, $strComentario);
                // dep($request);
                if ($request > 0) {
                    $arrResponse = array('status' => true, 'msg' => "Datos guardados correctamente");
                } else {
                    $arrResponse = array('status' => false, 'msg' => "No es posible almacenar datos");
                }
            } else {
                $arrResponse = array('status' => false, 'msg' => "Datos incompletos!");
            }
            // dep($arrResponse);
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            die();
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}
