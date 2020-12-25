<?php

class Proyectos extends Controllers
{
    public function __construct()
    {
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
            } else {
                $arrData[$i]["estado"] = '<span class="badge badge-danger">Inactivo</span>';
            }
            $arrData[$i]["opciones"] = '<div class="text-center">
                <button class="btn btn-primary btn-sm btnEditProyecto" rl="' . $arrData[$i]['id'] . '" title="Editar" ><i class="fa fa-pencil"></i></button>
                <button class="btn btn-danger btn-sm btnDelProyecto" rl="' . $arrData[$i]['id'] . '" title="Eliminar" ><i class="fa fa-trash"></i></button>
            </div>';
        }
        // dep($arrData);
        // FORMATO JSON
        echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        die();
    }
}
