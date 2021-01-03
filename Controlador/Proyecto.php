<?php

class Proyecto extends Controlador
{
    private $proyectoLenguaje;

    public function __construct()
    {
        session_start();
        if (empty($_SESSION['login'])) {
            header('Location: ' . base_url() . 'login');
        }
        parent::__construct();
        require_once("Modelo/ProyectoLenguajeModelo.php");
        $this->proyectoLenguaje = new ProyectoLenguajeModelo();
    }

    public function proyecto()
    {
        // echo "mensaje desde el controlador";
        $data["page_id"] = 1;
        $data["page_tag"] = "Proyectos";
        $data["page_title"] = "Proyectos - Yo contribuyo";
        $data["page_name"] = "proyectos";
        $data["nav_proyectos"] = "active";
        $data["script"] = "proyecto.js";
        $this->views->getView($this, "proyectos", $data);
    }
    public function getProyectos()
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
                        <a class="btn btn-secondary btn-sm" href="' . base_url() . 'home/verProyecto/' . $arrData[$i]['id_proyecto'] . '" target="_blank" title="Ver" ><i class="fa fa-eye"></i></a>
                        <a class="btn btn-primary btn-sm" href="' . base_url() . 'proyecto/form/' . $arrData[$i]['id_proyecto'] . '" rl="" title="Editar" ><i class="fa fa-pencil"></i></a>
                        <button class="btn btn-danger btn-sm btnDelProyecto" rl="' . $arrData[$i]['id_proyecto'] . '" title="Eliminar" ><i class="fa fa-trash"></i></button>
                    </div>';
            } else {
                $arrData[$i]["estado"] = '<span class="badge badge-danger">Inactivo</span>';
                $arrData[$i]["opciones"] = '<div class="text-center">
                        <a class="btn btn-secondary btn-sm" href="' . base_url() . 'home/verProyecto/' . $arrData[$i]['id_proyecto'] . '" target="_blank" title="Ver" ><i class="fa fa-eye"></i></a>
                        <a class="btn btn-primary btn-sm" href="' . base_url() . 'proyecto/form/' . $arrData[$i]['id_proyecto'] . '" rl="" title="Editar" ><i class="fa fa-pencil"></i></a>
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
        $data["script"] = "proyecto_nuevo.js";
        $lenguajes = $this->model->getActiveLenguajes();
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

        $this->model->setNombre($strNombre);
        $this->model->setDescripcion($strDescripcion);
        $this->model->setRepositorio($strRepositorio);
        $this->model->setTags($strTags);
        $this->model->setUsuarioId($_SESSION['idUser']);

        if ($intIdProyecto == 0) {
            // Crear
            $request_proyecto = $this->model->insertProyecto();

            $this->proyectoLenguaje->setProyectoId($request_proyecto);
            foreach ($arrayLenguajes as $lenguaje => $value) {
                $this->proyectoLenguaje->setLenguajeId($value);
                $request_proyecto_lenguaje = $this->proyectoLenguaje->insertProyectoLenguaje();
            }
            $option = 1;
            // echo json_encode($request_proyecto);
        } else {
            // Update
            $this->model->setId($intIdProyecto);
            $request_proyecto = $this->model->updateProyecto();

            $this->proyectoLenguaje->setProyectoId($intIdProyecto);
            $this->proyectoLenguaje->deleteProyectoLenguaje();
            foreach ($arrayLenguajes as $lenguaje => $value) {
                $this->proyectoLenguaje->setLenguajeId($value);
                $request_proyecto_lenguaje = $this->proyectoLenguaje->insertProyectoLenguaje();
            }
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
            $this->model->setId($id);
            $arrData = $this->model->selectProyecto();
            $this->proyectoLenguaje->setProyectoId($id);
            $arrlenguajes = $this->proyectoLenguaje->selectLenguajes();
            $arrData["lenguajes"] = $arrlenguajes;

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
            $this->model->setId($intId);
            $requestDelete = $this->model->disableProyecto();
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
            $this->model->setId($intId);
            $requestDelete = $this->model->enableProyecto();
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
