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
    public function favoritos()
    {
        $data["page_id"] = 1;
        $data["page_tag"] = "Favoritos";
        $data["page_title"] = "Favoritos - Yo contribuyo";
        $data["page_name"] = "favoritos";
        $data["nav_favoritos"] = "active";
        $data["script"] = "js/functions_favoritos.js";
        $this->views->getView($this, "favoritos", $data);
    }
    public function getFavoritos()
    {
        $arrData = $this->model->all();
        for ($i = 0; $i < count($arrData); $i++) {
            $arrData[$i]["opciones"] = '<div class="text-center">
                        <a class="btn btn-secondary btn-sm" href="' . base_url() . 'home/verProyecto/' . $arrData[$i]['id_proyecto'] . '" target="_blank" title="Ver" ><i class="fa fa-eye"></i></a>
                    </div>';
        }
        echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        die();
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
