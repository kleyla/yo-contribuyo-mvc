<?php

class FavoritosModel extends Mysql
{
    private $accion;

    public function __construct()
    {
        parent::__construct();
        // echo "mensaje desde el modelo home!";
    }
    public function all()
    {
        $idUsuario = intval($_SESSION['idUser']);
        $sql = "SELECT p.*, u.nick FROM proyectos p, acciones a, favoritos f, usuarios u
                WHERE p.id_proyecto = a.proyecto_id AND u.id_usuario = p.usuario_id AND a.id_accion = f.accion_id AND a.usuario_id = $idUsuario";
        $request = $this->select_all($sql);
        return $request;
    }
    public function insertFavorito(int $idProyecto)
    {
        try {
            // $this->accion = new AccionesModel();
            $idUsuario = intval($_SESSION['idUser']);
            // ACCION
            $query_insert = "INSERT INTO acciones(usuario_id, proyecto_id) VALUES (?,?)";
            $arrData = array($idUsuario, $idProyecto);
            $request_accion = $this->insert($query_insert, $arrData);
            // $request_accion = $this->accion->insertAccion($idUsuario, $idProyecto);
            // FAVORITO
            $query_insert = "INSERT INTO favoritos(accion_id) VALUES (?)";
            $arrData = array($request_accion);
            $request_fav = $this->insert($query_insert, $arrData);
            return $request_accion;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
    public function deleteFavorito(int $idProyecto)
    {
        try {
            // $this->accion = new AccionesModel();
            $idUsuario = intval($_SESSION['idUser']);
            // ACCION
            $query = "SELECT a.id_accion FROM acciones a, favoritos f
                WHERE a.id_accion = f.accion_id AND a.usuario_id = $idUsuario AND a.proyecto_id = $idProyecto";
            $request_acciones = $this->select($query);
            if (!empty($request_acciones)) {
                $id_accion = $request_acciones['id_accion'];
                // FAVORITO
                $sqlDel = "DELETE FROM favoritos WHERE accion_id = $id_accion";
                $request_del = $this->delete($sqlDel);
                // ACCION
                $sqlDel = "DELETE FROM acciones WHERE id_accion = $id_accion";
                $request_del = $this->delete($sqlDel);
                return 1;
            } else {
                throw new Exception('no existe');
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}
