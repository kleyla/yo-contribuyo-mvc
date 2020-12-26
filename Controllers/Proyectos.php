<?php

class Proyectos extends Controllers
{
    public function __construct()
    {
        session_start();
        if (empty($_SESSION['login'])) {
            header('Location: ' . base_url() . 'login');
        }
        parent::__construct();
    }

    public function proyectos()
    {
        // echo "mensaje desde el controlador";
        $data["page_id"] = 1;
        $data["page_tag"] = "Proyectos";
        $data["page_title"] = "Proyectos - Yo contribuyo";
        $data["page_name"] = "proyectos";
        $data["script"] = "js/functions_proyectos.js";
        $this->views->getView($this, "proyectos", $data);
    }
    public function getProyectos()
    {
        $arrData = $this->model->all();
        // dep($arrData);
        for ($i = 0; $i < count($arrData); $i++) {
            if ($arrData[$i]["estado"] == 1) {
                $arrData[$i]["estado"] = '<span class="badge badge-success">Activo</span>';
                $arrData[$i]["opciones"] = '<div class="text-center">
                        <button class="btn btn-secondary btn-sm btnShowProyecto" rl="' . $arrData[$i]['id_proyecto'] . '" title="Permisos" ><i class="fa fa-eye"></i></button>
                        <a class="btn btn-primary btn-sm" href="' . base_url() . 'proyectos/form/' . $arrData[$i]['id_proyecto'] . '" rl="" title="Editar" ><i class="fa fa-pencil"></i></a>
                        <button class="btn btn-danger btn-sm btnDelProyecto" rl="' . $arrData[$i]['id_proyecto'] . '" title="Eliminar" ><i class="fa fa-trash"></i></button>
                    </div>';
            } else {
                $arrData[$i]["estado"] = '<span class="badge badge-danger">Inactivo</span>';
                $arrData[$i]["opciones"] = '<div class="text-center">
                        <button class="btn btn-secondary btn-sm btnShowProyecto" rl="' . $arrData[$i]['id_proyecto'] . '" title="Permisos" ><i class="fa fa-eye"></i></button>
                        <a class="btn btn-primary btn-sm" href="' . base_url() . 'proyectos/form/' . $arrData[$i]['id_proyecto'] . '" rl="" title="Editar" ><i class="fa fa-pencil"></i></a>
                        <button class="btn btn-warning btn-sm btnEnableProyecto" rl="' . $arrData[$i]['id_proyecto'] . '" title="Habilitar" ><i class="fa fa-unlock"></i></button>
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
        $data["page_tag"] = "Proyectos";
        $data["page_title"] = "Proyectos - Formulario";
        $data["page_name"] = "proyectos";
        $data["script"] = "js/functions_proyectos_nuevo.js";
        $lenguajes = $this->model->allActive();
        $data["lenguajes"] = $lenguajes;
        $data["id_proyecto"] = $id;
        // dep($lenguajes);
        $this->views->getView($this, "form", $data);
    }
    public function setProyecto()
    {
        $intIdProyecto = intval($_POST['idProyecto']);
        $strNombre = strClean($_POST["txtNombre"]);
        $strDescripcion = strClean($_POST["txtDescripcion"]);
        $strRepositorio = strClean($_POST["txtRepositorio"]);
        $strTags = strClean($_POST["txtTags"]);
        $arrayLenguajes = $_POST["lenguajes"];

        if ($intIdProyecto == 0) {
            // Crear
            $request_proyecto = $this->model->insertProyecto($strNombre, $strDescripcion, $strRepositorio, $arrayLenguajes, $strTags);
            $option = 1;
            // echo json_encode($request_proyecto);
        } else {
            // Update
            $request_proyecto = $this->model->updateProyecto($intIdProyecto, $strNombre, $strDescripcion, $strRepositorio, $arrayLenguajes, $strTags);
            $option = 2;
        }
        // dep($_POST);
        if ($request_proyecto === "exist") {
            $arrResponse = array('status' => false, 'msg' => "Atencion! El proyecto ya existe");
        } else if (intval($request_proyecto) > 0) {
            if ($option == 1) {
                $arrResponse = array('status' => true, 'msg' => "Datos guardados correctamente");
            } else {
                $arrResponse = array('status' => true, 'msg' => "Datos actualizados correctamente");
            }
        } else {
            // $arrResponse = array('status' => false, 'msg' => "No es posible almacenar datos");
            $arrResponse = array('status' => false, 'msg' => $request_proyecto);
        }
        echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function getProyecto(int $id)
    {
        $intId = intval(strClean($id));
        if ($intId > 0) {
            $arrData = $this->model->selectProyecto($intId);
            if (empty($arrData)) {
                $arrResponse = array('status' => false, 'msg' => "Datos no encontrados.");
            } else {
                $arrResponse = array('status' => true, 'data' => $arrData);
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }
    public function deleteProyecto()
    {
        if ($_POST) {
            $intId = intval($_POST["idProyecto"]);
            $requestDelete = $this->model->disableProyecto($intId);
            if ($requestDelete === "ok") {
                $arrResponse = array('status' => true, 'msg' => "Se ha eliminado el Proyecto");
            } else {
                $arrResponse = array('status' => false, 'msg' => "Error al eliminar el Proyecto.");
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }
    public function habilitarProyecto()
    {
        if ($_POST) {
            $intId = intval($_POST["idProyecto"]);
            $requestDelete = $this->model->enableProyecto($intId);
            if ($requestDelete === "ok") {
                $arrResponse = array('status' => true, 'msg' => "Se ha habilitado el Proyecto");
            } else {
                $arrResponse = array('status' => false, 'msg' => "Error al habilitado el Proyecto.");
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }
}
