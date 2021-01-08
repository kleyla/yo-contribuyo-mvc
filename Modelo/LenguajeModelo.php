<?php

class LenguajeModelo extends Mysql
{
    private $intId;
    private $strNombre;
    private $strLink;
    private $intEstado;
    private $fecha;

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
    public function setLink(string $link)
    {
        $this->strLink = $link;
    }
    public function all()
    {
        $sql = "SELECT * FROM lenguajes";
        $arrData = $this->select_all($sql);
        for ($i = 0; $i < count($arrData); $i++) {
            if ($arrData[$i]["estado"] == 1) {
                $arrData[$i]["estado"] = '<span class="badge badge-success">Activo</span>';
                $arrData[$i]["opciones"] = '<div class="text-center">
                        <button class="btn btn-primary btn-sm" onclick="editLenguaje(' . $arrData[$i]['id_lenguaje'] . ')" title="Editar" ><i class="fa fa-pencil"></i></button>
                        <button class="btn btn-danger btn-sm" onclick="deleteLenguaje(' . $arrData[$i]['id_lenguaje'] . ')" title="Eliminar" ><i class="fa fa-trash"></i></button>
                    </div>';
            } else {
                $arrData[$i]["estado"] = '<span class="badge badge-danger">Inactivo</span>';
                $arrData[$i]["opciones"] = '<div class="text-center">
                        <button class="btn btn-primary btn-sm" onclick="editLenguaje(' . $arrData[$i]['id_lenguaje'] . ')" title="Editar" ><i class="fa fa-pencil"></i></button>
                        <button class="btn btn-warning btn-sm" onclick="enableLenguaje(' . $arrData[$i]['id_lenguaje'] . ')" title="Habilitar" ><i class="fa fa-unlock"></i></button>
                    </div>';
            }
        }

        return $arrData;
    }
    public function getActiveLenguajes()
    {
        $sql = "SELECT * FROM lenguajes WHERE estado = 1";
        $request = $this->select_all($sql);
        return $request;
    }
    public function insertLenguaje()
    {
        try {
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
    public function selectLenguaje()
    {
        $sql = "SELECT * FROM lenguajes WHERE id_lenguaje = $this->intId";
        $request = $this->select($sql);
        return $request;
    }
    public function updateLenguaje()
    {
        try {
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

    public function disableLenguaje()
    {
        try {
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
    public function enableLenguaje()
    {
        try {
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
