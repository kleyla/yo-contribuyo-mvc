<?php

class ArticulosModel extends Mysql
{
    private $intId;
    private $strTitulo;
    private $strContenido;
    private $intEstado;
    private $intUsuarioId;

    public function __construct()
    {
        parent::__construct();
        // echo "mensaje desde el modelo home!";
    }
    public function all()
    {
        $sql = "SELECT articulos.*, usuarios.nick FROM articulos, usuarios WHERE articulos.usuario_id = usuarios.id_usuario";
        $request = $this->select_all($sql);
        return $request;
    }
    public function allByUser()
    {
        $this->intUsuarioId = $_SESSION['idUser'];
        $sql = "SELECT articulos.*, usuarios.nick FROM articulos, usuarios WHERE articulos.usuario_id = usuarios.id_usuario AND usuarios.id_usuario = $this->intUsuarioId";
        $request = $this->select_all($sql);
        return $request;
    }
    public function insertArticulo(string $titulo, string $contenido)
    {
        try {
            $return = "";
            $this->strTitulo = $titulo;
            $this->strContenido = $contenido;
            $this->intUsuarioId = $_SESSION['idUser'];

            $query_insert = "INSERT INTO articulos(titulo, contenido, usuario_id ) VALUES (?,?,?)";
            $arrData = array($this->strTitulo, $this->strContenido, $this->intUsuarioId);
            $request_insert = $this->insert($query_insert, $arrData);
            $return = $request_insert;
            return $return;
        } catch (Exception $e) {
            return $return = $e->getMessage();
        }
    }
    public function selectArticulo(int $id)
    {
        $this->intId = $id;
        $sql = "SELECT *  FROM articulos WHERE id_articulo = $this->intId";
        $request = $this->select($sql);
        return $request;
    }
    public function updateArticulo(int $id, string $titulo, string $contenido)
    {
        try {
            $this->intId = $id;
            $this->strTitulo = $titulo;
            $this->strContenido = $contenido;

            $sql = "UPDATE articulos SET titulo = ?, contenido = ? WHERE id_articulo = $this->intId";
            $arrData = array($this->strTitulo, $this->strContenido);
            $request = $this->update($sql, $arrData);
            return $request;
        } catch (Exception $e) {
            return  $request = $e->getMessage();
        }
    }
    public function disableArticulo(int $id)
    {
        try {
            $this->intId = $id;
            $sql = "UPDATE articulos SET estado = ? WHERE id_articulo = $this->intId";
            $arrData = array(0);
            $request = $this->update($sql, $arrData);
            if ($request) {
                return $request = "ok";
            } else {
                throw new Exception("error");
            }
        } catch (Exception $e) {
            return $request = "error";
        }
    }
    public function enableArticulo(int $id)
    {
        try {
            $this->intId = $id;
            $sql = "UPDATE articulos SET estado = ? WHERE id_articulo = $this->intId";
            $arrData = array(1);
            $request = $this->update($sql, $arrData);
            if ($request) {
                return $request = "ok";
            } else {
                throw new Exception("error");
            }
        } catch (Exception $e) {
            return $request = "error";
        }
    }
}
