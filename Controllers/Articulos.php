<?php

class Articulos extends Controllers
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
        $data["script"] = "js/functions_articulos.js";
        $this->views->getView($this, "articulos", $data);
    }
    public function getArticulos()
    {
        if ($_SESSION['userData']['rol'] == "Administrador") {
            $arrData = $this->model->all();
        } else {
            $arrData = $this->model->allByUser();
        }
        // dep($arrData);
        for ($i = 0; $i < count($arrData); $i++) {
            if ($arrData[$i]["estado"] == 1) {
                $arrData[$i]["estado"] = '<span class="badge badge-success">Activo</span>';
                $arrData[$i]["opciones"] = '<div class="text-center">
                        <button class="btn btn-secondary btn-sm btnShowArticulo" rl="' . $arrData[$i]['id_articulo'] . '" title="Permisos" ><i class="fa fa-eye"></i></button>
                        <a class="btn btn-primary btn-sm" href="' . base_url() . 'articulos/form/' . $arrData[$i]['id_articulo'] . '" rl="" title="Editar" ><i class="fa fa-pencil"></i></a>
                        <button class="btn btn-danger btn-sm btnDelArticulo" rl="' . $arrData[$i]['id_articulo'] . '" title="Eliminar" ><i class="fa fa-trash"></i></button>
                    </div>';
            } else {
                $arrData[$i]["estado"] = '<span class="badge badge-danger">Inactivo</span>';
                $arrData[$i]["opciones"] = '<div class="text-center">
                        <button class="btn btn-secondary btn-sm btnShowArticulo" rl="' . $arrData[$i]['id_articulo'] . '" title="Permisos" ><i class="fa fa-eye"></i></button>
                        <a class="btn btn-primary btn-sm" href="' . base_url() . 'articulos/form/' . $arrData[$i]['id_articulo'] . '" rl="" title="Editar" ><i class="fa fa-pencil"></i></a>
                        <button class="btn btn-warning btn-sm btnEnableArticulo" rl="' . $arrData[$i]['id_articulo'] . '" title="Eliminar" ><i class="fa fa-unlock"></i></button>
                    </div>';
            }
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
        $data["script"] = "js/functions_articulos_nuevo.js";
        $data["id_articulo"] = $id;
        // dep($lenguajes);
        $this->views->getView($this, "form", $data);
    }
    public function setArticulo()
    {
        $intIdArticulo = intval($_POST['idArticulo']);
        $strTitulo = strClean($_POST["txtTitulo"]);
        $strContenido = strClean($_POST["txtContenido"]);

        if ($intIdArticulo == 0) {
            // Crear
            $request_articulos = $this->model->insertArticulo($strTitulo, $strContenido);
            $option = 1;
            // echo json_encode($request_articulos);
        } else {
            // Update
            $request_articulos = $this->model->updateArticulo($intIdArticulo, $strTitulo, $strContenido);
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
            $arrData = $this->model->selectArticulo($intId);
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
            $requestDelete = $this->model->disableArticulo($intId);
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
            $requestDelete = $this->model->enableArticulo($intId);
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
