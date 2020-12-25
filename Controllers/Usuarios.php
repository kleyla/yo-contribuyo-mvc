<?php

class Usuarios extends Controllers
{

    function __construct()
    {
        parent::__construct();
    }
    public function usuarios()
    {
        echo "Usuarios";
        $data["page_id"] = 1;
        $data["page_tag"] = "Usuarios";
        $data["page_title"] = "Usuarios - Yo contribuyo";
        $data["page_name"] = "usuarios";
        $this->views->getView($this, "usuarios", $data);
    }
    public function getUsuarios()
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
                <button class="btn btn-secondary btn-sm btnPermisosRol" rl="' . $arrData[$i]['id'] . '" title="Permisos" ><i class="fa fa-key"></i></button>
                <button class="btn btn-primary btn-sm btnEditRol" rl="' . $arrData[$i]['id'] . '" title="Editar" ><i class="fa fa-pencil"></i></button>
                <button class="btn btn-danger btn-sm btnDelRol" rl="' . $arrData[$i]['id'] . '" title="Eliminar" ><i class="fa fa-trash"></i></button>
            </div>';
        }
        // dep($arrData);
        // FORMATO JSON
        echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function setUsuario()
    {
        $intIdUsuario = intval($_POST['idUsuario']);
        $strNick = strClean($_POST["txtNick"]);
        $strEmail = strClean($_POST["txtEmail"]);
        $strPass = strClean($_POST["txtPass"]);
        $intEstado = strClean($_POST["listaEstado"]);
        $strRol = strClean($_POST["listaRol"]);

        if ($intIdUsuario == 0) {
            // Crear
            $request_usuario = $this->model->insertUsuario($strNick, $strEmail, $strPass, $intEstado, $strRol);
            $option = 1;
            // echo json_encode($request_usuario);
        } else {
            // Update
            // $request_usuario = $this->model->updateRol($intIdRol, $strRol, $strDescripcion, $intStatus);
            // $option = 2;
        }
        // dep($_POST);
        if ($request_usuario === "exist") {
            $arrResponse = array('status' => false, 'msg' => "Atencion! El usuario ya existe");
        } else if ($request_usuario > 0) {
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
}
