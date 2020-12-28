<?php

class LenguajesModel extends Mysql
{
    public $intId;
    public $strNombre;
    public $strLink;
    public $intEstado;
    public $fecha;

    public function __construct()
    {
        parent::__construct();
        // echo "mensaje desde el modelo home!";
    }
    public function all()
    {
        $sql = "SELECT * FROM lenguajes";
        $request = $this->select_all($sql);
        return $request;
    }
    public function insertLenguaje(string $nombre, string $link)
    {
        try {
            $return = "";
            $this->strNombre = $nombre;
            $this->strLink = $link;
            $sql = "SELECT * FROM lenguajes WHERE nombre = '$this->strNombre'";
            $request = $this->select_all($sql);
            if (empty($request)) {
                $query_insert = "INSERT INTO lenguajes(nombre, link) VALUES (?,?)";
                $arrData = array($this->strNombre, $this->strLink);
                $request_insert = $this->insert($query_insert, $arrData);
                $return = $request_insert;
                return $return;
            } else {
                throw new Exception("error");
            }
        } catch (Exception $e) {
            return $return = "exist";
        }
    }
    public function selectLenguaje(int $id)
    {
        $this->intId = $id;
        $sql = "SELECT * FROM lenguajes WHERE id_lenguaje = $this->intId";
        $request = $this->select($sql);
        return $request;
    }
    public function updateLenguaje(int $id, string $nombre, string $link)
    {
        try {
            $this->intId = $id;
            $this->strNombre = $nombre;
            $this->strLink = $link;
            $sql = "SELECT * FROM lenguajes WHERE nombre = '$this->strNombre' AND id_lenguaje != $this->intId";
            $request = $this->select_all($sql);
            if (empty($request)) {
                $sql = "UPDATE lenguajes SET nombre = ?, link = ? WHERE id_lenguaje = $this->intId";
                $arrData = array($this->strNombre, $this->strLink);
                $request = $this->update($sql, $arrData);
                return $request;
            } else {
                throw new Exception("error");
            }
        } catch (Exception $e) {
            return  $request = "exist";
        }
    }

    public function disableLenguaje(int $id)
    {
        try {
            $this->intId = $id;
            $sql = "UPDATE lenguajes SET estado = ? WHERE id_lenguaje = $this->intId";
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
    public function enableLenguaje(int $id)
    {
        try {
            $this->intId = $id;
            $sql = "UPDATE lenguajes SET estado = ? WHERE id_lenguaje = $this->intId";
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
