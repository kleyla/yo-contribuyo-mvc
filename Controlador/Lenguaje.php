<?php

class Lenguaje extends Controlador
{
    public function __construct()
    {
        session_start();
        if (empty($_SESSION['login'])) {
            header('Location: ' . base_url() . 'login');
        }
        parent::__construct();
    }

    public function index()
    {
        // echo "mensaje desde el controlador";
        if ($_SESSION['userData']['rol'] == "Administrador") {
            $this->vista->index();
        } else {
            header('Location: ' . base_url() . 'dashboard');
        }
    }
    public function getLenguajes()
    {
        $arrData = $this->model->all();
        // dep($arrData);
        // FORMATO JSON
        echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function setLenguaje()
    {
        $intIdLenguaje = intval($_POST['idLenguaje']);
        $strNombre = strClean($_POST["txtNombre"]);
        $strLink = strClean($_POST["txtLink"]);
        $this->model->setNombre($strNombre);
        $this->model->setLink($strLink);

        if ($intIdLenguaje == 0) {
            // Crear
            $request_lenguaje = $this->model->insertLenguaje();
            $option = 1;
            // echo json_encode($request_lenguaje);
        } else {
            // Update
            $this->model->setId($intIdLenguaje);
            $request_lenguaje = $this->model->updateLenguaje();
            $option = 2;
        }
        // dep($_POST);
        if ($request_lenguaje === "exist") {
            $arrResponse = array('status' => false, 'msg' => "Atencion! El lenguaje ya existe");
        } else if ($request_lenguaje > 0) {
            if ($option == 1) {
                $arrResponse = array('status' => true, 'msg' => "Datos guardados correctamente");
            } else {
                $arrResponse = array('status' => true, 'msg' => "Datos actualizados correctamente");
            }
        } else {
            $arrResponse = array('status' => false, 'msg' => "No es posible almacenar datos");
        }
        echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function getLenguaje(int $id)
    {
        $intIdLenguaje = intval(strClean($id));
        if ($intIdLenguaje > 0) {
            $this->model->setId($intIdLenguaje);
            $arrData = $this->model->selectLenguaje();
            if (empty($arrData)) {
                $arrResponse = array('status' => false, 'msg' => "Datos no encontrados.");
            } else {
                $arrResponse = array('status' => true, 'data' => $arrData);
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }
    public function deleteLenguaje()
    {
        if ($_POST) {
            $intId = intval($_POST["idlenguaje"]);
            $this->model->setId($intId);
            $requestDelete = $this->model->disableLenguaje();
            if ($requestDelete === "ok") {
                $arrResponse = array('status' => true, 'msg' => "Se ha eliminado el Lenguaje");
            } else {
                $arrResponse = array('status' => false, 'msg' => "Error al eliminar el Lenguaje.");
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }
    public function habilitarLenguaje()
    {
        if ($_POST) {
            $intId = intval($_POST["idlenguaje"]);
            $this->model->setId($intId);
            $requestDelete = $this->model->enableLenguaje();
            if ($requestDelete === "ok") {
                $arrResponse = array('status' => true, 'msg' => "Se ha habilitado el Lenguaje");
            } else {
                $arrResponse = array('status' => false, 'msg' => "Error al habilitar el Lenguaje.");
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }
}
