<?php

class Usuarios extends Controllers
{

    function __construct()
    {
        parent::__construct();
    }
    public function usuarios()
    {
        // echo "Usuarios";
        $data["page_id"] = 1;
        $data["page_tag"] = "Usuarios";
        $data["page_title"] = "Usuarios - Yo contribuyo";
        $data["page_name"] = "usuarios";
        $data["script"] = "js/functions_usuarios.js";
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
                <button class="btn btn-secondary btn-sm btnPermisosRol" rl="' . $arrData[$i]['id_usuario'] . '" title="Permisos" ><i class="fa fa-key"></i></button>
                <button class="btn btn-primary btn-sm btnEditUsuario" rl="' . $arrData[$i]['id_usuario'] . '" title="Editar" ><i class="fa fa-pencil"></i></button>
                <button class="btn btn-danger btn-sm btnDelUsuario" rl="' . $arrData[$i]['id_usuario'] . '" title="Eliminar" ><i class="fa fa-trash"></i></button>
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
            $request_usuario = $this->model->updateUsuario($intIdUsuario, $strNick, $strEmail, $strPass, $intEstado, $strRol);
            $option = 2;
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
    public function getUsuario(int $id)
    {
        $intIdUsuario = intval(strClean($id));
        if ($intIdUsuario > 0) {
            $arrData = $this->model->selectUsuario($intIdUsuario);
            if (empty($arrData)) {
                $arrResponse = array('status' => false, 'msg' => "Datos no encontrados.");
            } else {
                $arrResponse = array('status' => true, 'data' => $arrData);
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }
    public function deleteUsuario()
    {
        if ($_POST) {
            $intIdUsuario = intval($_POST["idusuario"]);
            $requestDelete = $this->model->disableUsuario($intIdUsuario);
            if ($requestDelete === "ok") {
                $arrResponse = array('status' => true, 'msg' => "Se ha eliminado el Usuario");
            } else {
                $arrResponse = array('status' => false, 'msg' => "Error al eliminar el Usuario.");
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }
}
