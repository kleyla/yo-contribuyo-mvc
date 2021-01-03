<?php

class Roles extends Controlador
{
    public function __construct()
    {
        parent::__construct();
    }
    public function roles()
    {
        $data["page_id"] = 3;
        $data["page_tag"] = "Role usuario";
        $data["page_name"] = "rol_usuario";
        $data["page_title"] = "Roles usuario";
        $this->views->getView($this, "roles", $data);
    }

    public function getRoles()
    {
        $arrData = $this->model->selectRoles();
        // dep($arrData);
        // foreach ($arrData as $data){
        for ($i = 0; $i < count($arrData); $i++) {
            if ($arrData[$i]["status"] == 1) {
                $arrData[$i]["status"] = '<span class="badge badge-success">Activo</span>';
            } else {
                $arrData[$i]["status"] = '<span class="badge badge-danger">Inactivo</span>';
            }
            $arrData[$i]["options"] = '<div class="text-center">
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

    public function getRol(int $id)
    {
        $intIdRol = intval(strClean($id));
        if ($intIdRol > 0) {
            $arrData = $this->model->selectRol($intIdRol);
            if (empty($arrData)) {
                $arrResponse = array('status' => false, 'msg' => "Datos no encontrados.");
            } else {
                $arrResponse = array('status' => true, 'data' => $arrData);
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function setRol()
    {
        $intIdRol = intval($_POST['idRol']);
        $strRol = strClean($_POST["txtNombre"]);
        $strDescripcion = strClean($_POST["txtDescripcion"]);
        $intStatus = strClean($_POST["listStatus"]);
        if ($intIdRol == 0) {
            // Crear
            $request_rol = $this->model->insertRol($strRol, $strDescripcion, $intStatus);
            $option = 1;
        } else {
            // Update
            $request_rol = $this->model->updateRol($intIdRol, $strRol, $strDescripcion, $intStatus);
            $option = 2;
        }
        // dep($_POST);
        if ($request_rol === "exist") {
            $arrResponse = array('status' => false, 'msg' => "Atencion! El rol ya existe");
        } else if ($request_rol > 0) {
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
    public function delRol()
    {
        if ($_POST) {
            $intIdRol = intval($_POST["idrol"]);
            $requestDelete = $this->model->deleteRol($intIdRol);
            if ($requestDelete === "ok") {
                $arrResponse = array('status' => true, 'msg' => "Se ha eliminado el Rol");
            } else if ($requestDelete === "exist") {
                $arrResponse = array('status' => false, 'msg' => "No es posible eliminar un rol asociado a un usuario.");
            } else {
                $arrResponse = array('status' => false, 'msg' => "Error al eliminar el Rol.");
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }
}
