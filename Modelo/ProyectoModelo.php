<?php

class ProyectoModelo extends Mysql
{
    private $intId;
    private $strNombre;
    private $strDescripcion;
    private $strRepositorio;
    private $intEstado;
    private $strTags;
    // private $arrayLenguajes;
    private $intUsuarioId;

    public function __construct()
    {
        parent::__construct();
        // echo "mensaje desde el modelo home!";
    }
    public function setId(int $id)
    {
        $this->intId = $id;
    }
    public function setNombre(string $nombre)
    {
        $this->strNombre = $nombre;
    }
    public function setDescripcion(string $descripcion)
    {
        $this->strDescripcion = $descripcion;
    }
    public function setRepositorio(string $repositorio)
    {
        $this->strRepositorio = $repositorio;
    }
    public function setTags(string $tags)
    {
        $this->strTags = $tags;
    }
    public function setUsuarioId(int $id)
    {
        $this->intUsuarioId = $id;
    }
    public function all()
    {
        $sql = "SELECT proyectos.*, usuarios.nick FROM proyectos, usuarios WHERE proyectos.usuario_id = usuarios.id_usuario";
        $request = $this->select_all($sql);
        return $request;
    }
    public function allByUser()
    {
        $this->intUsuarioId = $_SESSION['idUser'];
        $sql = "SELECT proyectos.*, usuarios.nick FROM proyectos, usuarios WHERE proyectos.usuario_id = usuarios.id_usuario AND usuarios.id_usuario = $this->intUsuarioId";
        $request = $this->select_all($sql);
        return $request;
    }
    public function insertProyecto()
    {
        try {
            $sql = "SELECT * FROM proyectos WHERE repositorio = '$this->strRepositorio'";
            $request = $this->select_all($sql);
            if (empty($request)) {
                $query_insert = "INSERT INTO proyectos(nombre, descripcion, repositorio, tags, usuario_id) VALUES (?,?,?,?,?)";
                $arrData = array($this->strNombre, $this->strDescripcion, $this->strRepositorio, $this->strTags, $this->intUsuarioId);
                $request_insert = $this->insert($query_insert, $arrData);
                return $request_insert;
            } else {
                throw new Exception("exist");
            }
        } catch (Exception $e) {
            return $return = $e->getMessage();
        }
    }
    public function selectProyecto()
    {
        $sql = "SELECT *  FROM proyectos WHERE id_proyecto = $this->intId";
        $request = $this->select($sql);
        $sql = "SELECT lenguajes.*  FROM proyectos, lenguajes, proyecto_lenguaje WHERE id_proyecto = $this->intId AND proyecto_lenguaje.proyecto_id = proyectos.id_proyecto AND proyecto_lenguaje.lenguaje_id = lenguajes.id_lenguaje";
        $request_lenguajes = $this->select_all($sql);
        $request["lenguajes"] = $request_lenguajes;
        return $request;
    }
    public function updateProyecto()
    {
        try {
            $sql = "SELECT * FROM proyectos WHERE repositorio = '$this->strRepositorio' AND id_proyecto != $this->intId";
            $request = $this->select_all($sql);
            if (empty($request)) {
                $sql = "UPDATE proyectos SET nombre = ?, descripcion = ?, repositorio = ?, tags = ? WHERE id_proyecto = $this->intId";
                $arrData = array($this->strNombre, $this->strDescripcion, $this->strRepositorio, $this->strTags);
                $request = $this->update($sql, $arrData);
                return $request;
            } else {
                throw new Exception("exist");
            }
        } catch (Exception $e) {
            return  $request = $e->getMessage();
        }
    }
    public function disableProyecto()
    {
        try {
            $sql = "UPDATE proyectos SET estado = ? WHERE id_proyecto = $this->intId";
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
    public function enableProyecto()
    {
        try {
            $sql = "UPDATE proyectos SET estado = ? WHERE id_proyecto = $this->intId";
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
