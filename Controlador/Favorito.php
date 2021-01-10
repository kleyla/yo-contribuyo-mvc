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
    public function favoritos()
    {
        $this->vista->index();
    }
    public function getFavoritos()
    {
        $arrData = $this->model->all();
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
