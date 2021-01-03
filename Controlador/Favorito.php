<?php

class Favorito extends Controlador
{
    private $accion;
    public function __construct()
    {
        session_start();
        if (empty($_SESSION['login'])) {
            header('Location: ' . base_url() . 'login');
        }
        parent::__construct();
        require_once("Modelo/AccionModelo.php");
        $this->accion = new AccionModelo();
    }
    public function favorito()
    {
        $data["page_id"] = 1;
        $data["page_tag"] = "Favoritos";
        $data["page_title"] = "Favoritos - Yo contribuyo";
        $data["page_name"] = "favoritos";
        $data["nav_favoritos"] = "active";
        $data["script"] = "favorito.js";
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
    public function setFavorito()
    {
        try {
            $intIdProyecto = intval($_POST["idProyecto"]);
            $intFavorito = strClean($_POST["favorito"]);
            if ($intIdProyecto != '' && $intFavorito != '') {
                if (intval($intFavorito) == 1) {
                    // ACCION
                    $this->accion->setUsuarioId($_SESSION['idUser']);
                    $this->accion->setProyectoId($intIdProyecto);
                    $accionId = $this->accion->insertAccion();
                    // FAVORITO
                    $this->model->setAccionId($accionId);
                    $request = $this->model->insertFavorito();
                } else {
                    $accion_id = $this->model->existeFavorito($intIdProyecto);
                    if ($accion_id > 0) {
                        // FAVORITO
                        $this->model->setAccionId($accion_id);
                        $request_delete = $this->model->deleteFavorito();
                        // ACCION
                        $this->accion->setId($accion_id);
                        $request_delete = $this->accion->deleteAccion();
                        $request = $accion_id;
                    } else {
                        $request = 0;
                    }
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
