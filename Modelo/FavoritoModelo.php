<?php

class FavoritoModelo extends Mysql
{
    private $intAccionId;

    public function __construct()
    {
        parent::__construct();
        // echo "mensaje desde el modelo home!";
    }
    public function setAccionId(int $id)
    {
        $this->intAccionId = $id;
    }
    public function all()
    {
        $idUsuario = intval($_SESSION['idUser']);
        $sql = "SELECT p.*, u.nick FROM proyectos p, acciones a, favoritos f, usuarios u
                WHERE p.id_proyecto = a.proyecto_id AND u.id_usuario = p.usuario_id AND a.id_accion = f.accion_id AND a.usuario_id = $idUsuario";
        $arrData = $this->select_all($sql);
        for ($i = 0; $i < count($arrData); $i++) {
            $arrData[$i]["opciones"] = '<div class="text-center">
                        <a class="btn btn-secondary btn-sm" href="' . base_url() . 'home/verProyecto/' . $arrData[$i]['id_proyecto'] . '" target="_blank" title="Ver" ><i class="fa fa-eye"></i></a>
                    </div>';
        }

        return $arrData;
    }
    public function insertFavorito()
    {
        try {
            // FAVORITO
            $query_insert = "INSERT INTO favoritos(accion_id) VALUES (?)";
            $arrData = array($this->intAccionId);
            $request_fav = $this->insert($query_insert, $arrData);
            return $this->intAccionId;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
    public function existeFavorito(int $idProyecto)
    {
        $idUsuario = intval($_SESSION['idUser']);
        $query = "SELECT a.id_accion FROM acciones a, favoritos f
                WHERE a.id_accion = f.accion_id AND a.usuario_id = $idUsuario AND a.proyecto_id = $idProyecto";
        $request_acciones = $this->select($query);
        if (!empty($request_acciones)) {
            return $request_acciones['id_accion'];
        } else {
            return 0;
        }
    }
    public function deleteFavorito()
    {
        $sqlDel = "DELETE FROM favoritos WHERE accion_id = '$this->intAccionId'";
        $request_del = $this->delete($sqlDel);
        return 1;
    }
}
