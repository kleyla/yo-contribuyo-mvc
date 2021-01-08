<?php

class Articulo extends Controlador
{
    public function __construct()
    {
        session_start();
        if (empty($_SESSION['login'])) {
            header('Location: ' . base_url() . 'login');
        }
        parent::__construct();
    }

    public function articulos()
    {
        // echo "mensaje desde el controlador";
        $data["page_id"] = 1;
        $data["page_tag"] = "Articulos";
        $data["page_title"] = "Articulos - Yo contribuyo";
        $data["page_name"] = "articulos";
        $data["nav_articulos"] = "active";
        $data["script"] = "articulo/ArticuloVista.js";
        $this->vista->getView($this, "articulos", $data);
    }
    public function getArticulos()
    {
        if ($_SESSION['userData']['rol'] == "Administrador") {
            $arrData = $this->model->all();
        } else {
            $arrData = $this->model->allByUser();
        }
        // dep($arrData);
        // FORMATO JSON
        echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function form($id = 0)
    {
        $data["page_id"] = 1;
        $data["page_tag"] = "Articulos";
        $data["page_title"] = "Articulos - Formulario";
        $data["page_name"] = "articulos";
        $data["nav_articulos"] = "active";
        $data["script"] = "articulo/ArticuloVista.js";
        $data["id_articulo"] = $id;
        $this->vista->getView($this, "form", $data);
    }
    public function setArticulo()
    {
        $intIdArticulo = intval($_POST['idArticulo']);
        $strTitulo = strClean($_POST["txtTitulo"]);
        $strContenido = $_POST["txtContenido"];
        $intStatus = strClean($_POST["listStatus"]);
        $this->model->setTitulo($strTitulo);
        $this->model->setContenido($strContenido);
        $this->model->setUsuarioId($_SESSION['idUser']);
        $this->model->setEstado($intStatus);

        if ($intIdArticulo == 0) {
            // Crear
            $request_articulos = $this->model->insertArticulo();
            $option = 1;
            // echo json_encode($request_articulos);
        } else {
            // Update
            $this->model->setId($intIdArticulo);
            $request_articulos = $this->model->updateArticulo();
            $option = 2;
        }
        // dep($_POST);
        if ($request_articulos === "exist") {
            $arrResponse = array('status' => false, 'msg' => "Atencion! El Articulo existe");
        } else if (intval($request_articulos) > 0) {
            if ($option == 1) {
                $arrResponse = array('status' => true, 'msg' => "Datos guardados correctamente");
            } else {
                $arrResponse = array('status' => true, 'msg' => "Datos actualizados correctamente");
            }
        } else {
            // $arrResponse = array('status' => false, 'msg' => "No es posible almacenar datos");
            $arrResponse = array('status' => false, 'msg' => $request_articulos);
        }
        echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function getArticulo(int $id)
    {
        $intId = intval(strClean($id));
        if ($intId > 0) {
            $this->model->setId($intId);
            $arrData = $this->model->selectArticulo();
            if (empty($arrData)) {
                $arrResponse = array('status' => false, 'msg' => "Datos no encontrados.");
            } else {
                $arrResponse = array('status' => true, 'data' => $arrData);
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }
    public function deleteArticulo()
    {
        if ($_POST) {
            $intId = intval($_POST["idArticulo"]);
            $this->model->setId($intId);
            $requestDelete = $this->model->disableArticulo();
            if ($requestDelete === "ok") {
                $arrResponse = array('status' => true, 'msg' => "Se ha eliminado el Articulo");
            } else {
                $arrResponse = array('status' => false, 'msg' => "Error al eliminar el Articulo.");
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }
    public function habilitarArticulo()
    {
        if ($_POST) {
            $intId = intval($_POST["idArticulo"]);
            $this->model->setId($intId);
            $requestDelete = $this->model->enableArticulo();
            if ($requestDelete === "ok") {
                $arrResponse = array('status' => true, 'msg' => "Se ha habilitado el Articulo");
            } else {
                $arrResponse = array('status' => false, 'msg' => "Error al habilitado el Articulo.");
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }
}
