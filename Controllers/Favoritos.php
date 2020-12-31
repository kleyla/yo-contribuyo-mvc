<?php

class Favoritos extends Controllers
{
    public function __construct()
    {
        session_start();
        if (empty($_SESSION['login'])) {
            header('Location: ' . base_url() . 'login');
        }
        parent::__construct();
    }
    public function setFavoritos()
    {
        try {
            $intIdProyecto = intval($_POST["idProyecto"]);
            $intFavorito = strClean($_POST["favorito"]);
            if ($intIdProyecto != '' && $intFavorito != '') {
                if (intval($intFavorito) == 1) {
                    $request = $this->model->insertFavorito($intIdProyecto);
                } else {
                    $request = $this->model->deleteFavorito($intIdProyecto);
                }
                // dep($request);
                if (intval($request) > 0) {
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
