<?php

class Lenguajes extends Controllers
{
    public function __construct()
    {
        session_start();
        if (empty($_SESSION['login'])) {
            header('Location: ' . base_url() . 'login');
        }
        parent::__construct();
    }

    public function lenguajes()
    {
        if ($_SESSION['userData']['rol'] == "Administrador") {
            // echo "mensaje desde el controlador";
            $data["page_id"] = 1;
            $data["page_tag"] = "Lenguajes";
            $data["page_title"] = "Lenguajes - Yo contribuyo";
            $data["page_name"] = "lenguajes";
            $data["script"] = "js/functions_lenguajes.js";
            $this->views->getView($this, "lenguajes", $data);
        } else {
            header('Location: ' . base_url() . 'dashboard');
        }
    }
    public function getLenguajes()
    {
        $arrData = $this->model->all();
        // dep($arrData);
        for ($i = 0; $i < count($arrData); $i++) {
            if ($arrData[$i]["estado"] == 1) {
                $arrData[$i]["estado"] = '<span class="badge badge-success">Activo</span>';
                $arrData[$i]["opciones"] = '<div class="text-center">
                        <button class="btn btn-secondary btn-sm btnPermisosRol" rl="' . $arrData[$i]['id_lenguaje'] . '" title="Permisos" ><i class="fa fa-key"></i></button>
                        <button class="btn btn-primary btn-sm btnEditLenguaje" rl="' . $arrData[$i]['id_lenguaje'] . '" title="Editar" ><i class="fa fa-pencil"></i></button>
                        <button class="btn btn-danger btn-sm btnDelLenguaje" rl="' . $arrData[$i]['id_lenguaje'] . '" title="Eliminar" ><i class="fa fa-trash"></i></button>
                    </div>';
            } else {
                $arrData[$i]["estado"] = '<span class="badge badge-danger">Inactivo</span>';
                $arrData[$i]["opciones"] = '<div class="text-center">
                        <button class="btn btn-secondary btn-sm btnPermisosRol" rl="' . $arrData[$i]['id_lenguaje'] . '" title="Permisos" ><i class="fa fa-key"></i></button>
                        <button class="btn btn-primary btn-sm btnEditLenguaje" rl="' . $arrData[$i]['id_lenguaje'] . '" title="Editar" ><i class="fa fa-pencil"></i></button>
                        <button class="btn btn-warning btn-sm btnEnableLenguaje" rl="' . $arrData[$i]['id_lenguaje'] . '" title="Habilitar" ><i class="fa fa-unlock"></i></button>
                    </div>';
            }
        }
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
        $intEstado = strClean($_POST["listaEstado"]);

        if ($intIdLenguaje == 0) {
            // Crear
            $request_lenguaje = $this->model->insertLenguaje($strNombre, $strLink, $intEstado);
            $option = 1;
            // echo json_encode($request_lenguaje);
        } else {
            // Update
            $request_lenguaje = $this->model->updateLenguaje($intIdLenguaje, $strNombre, $strLink, $intEstado);
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
            $arrData = $this->model->selectLenguaje($intIdLenguaje);
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
            $requestDelete = $this->model->disableLenguaje($intId);
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
            $requestDelete = $this->model->enableLenguaje($intId);
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
