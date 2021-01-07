<?php

class Denuncia extends Controlador
{
    public function __construct()
    {
        session_start();
        if (empty($_SESSION['login'])) {
            header('Location: ' . base_url() . 'login');
        }
        parent::__construct();
    }
    public function setDenuncia()
    {
        try {
            $intIdArticulo = intval($_POST["idArticulo"]);
            $strRazones = strClean($_POST["txtRazones"]);
            if ($intIdArticulo != '' && $strRazones != '') {

                $this->model->setArticuloId($intIdArticulo);
                $this->model->setUsuarioId($_SESSION['idUser']);
                $this->model->setRazones($strRazones);

                $request = $this->model->insertDenuncia();
                // dep($request);
                if ($request == 0) {
                    $arrResponse = array('status' => true, 'msg' => "Datos guardados correctamente");
                } elseif ($request === 'existe') {
                    $arrResponse = array('status' => false, 'msg' => "Ya realizo la denuncia");
                } else {
                    $arrResponse = array('status' => false, 'msg' => $request);
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
    public function verDenuncias(int $idArticulo)
    {
        $this->vista->verDenuncias($idArticulo);
    }
    public function getDenuncias(int $idArticulo)
    {
        if ($idArticulo > 0) {
            $this->model->setArticuloId($idArticulo);
            $arrResponse =  $this->model->getDenunciasByArticulo();
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }
    public function deleteDenuncia()
    {
        if ($_POST) {
            $intIdArticulo = intval($_POST["idArticulo"]);
            $intIdUsuario = intval($_POST["idUsuario"]);
            $this->model->setArticuloId($intIdArticulo);
            $this->model->setUsuarioId($intIdUsuario);
            $requestDelete = $this->model->disableDenuncia();
            if ($requestDelete === "ok") {
                $arrResponse = array('status' => true, 'msg' => "Se ha eliminado la denuncia");
            } else {
                $arrResponse = array('status' => false, 'msg' => "Error al eliminar la denuncia.");
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }
}
