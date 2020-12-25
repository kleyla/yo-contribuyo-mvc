<?php

class RolesModel extends Mysql
{
    public $intIdRol;
    public $strRol;
    public $strDescripcion;
    public $intStatus;

    public function __construct()
    {
        parent::__construct();
    }

    public function selectRoles()
    {
        $sql = "SELECT * FROM roles";
        $request = $this->select_all($sql);
        return $request;
    }
    public function insertRol(string $rol, string $descripcion, int $status)
    {
        $return = "";
        $this->strRol = $rol;
        $this->strDescripcion = $descripcion;
        $this->intStatus = $status;

        $sql = "SELECT * FROM roles WHERE nombre = '{$this->strRol}'";
        $request = $this->select_all($sql);
        if (empty($request)) {
            $query_insert = "INSERT INTO roles(nombre, descripcion, status) VALUES (?,?,?)";
            $arrData = array($this->strRol, $this->strDescripcion, $this->intStatus);
            $request_insert = $this->insert($query_insert, $arrData);
            $return = $request_insert;
        } else {
            $return = "exist";
        }
        return $return;
    }
    public function selectRol(int $id)
    {
        $this->intIdRol = $id;
        $sql = "SELECT * FROM roles WHERE id = $this->intIdRol";
        $request = $this->select($sql);
        return $request;
    }
    public function updateRol(int $id, string $rol, string $descripcion, int $status)
    {
        $this->intIdRol = $id;
        $this->strRol = $rol;
        $this->strDescripcion = $descripcion;
        $this->intStatus = $status;

        $sql = "SELECT * FROM roles WHERE nombre = '$this->strRol' AND id != $this->intIdRol";
        $request = $this->select_all($sql);
        if (empty($request)) {
            $sql = "UPDATE roles SET nombre = ?, descripcion = ?, status = ? WHERE id = $this->intIdRol";
            $arrData = array($this->strRol, $this->strDescripcion, $this->intStatus);
            $request = $this->update($sql, $arrData);
        } else {
            $request = "exist";
        }
        return $request;
    }
    public function deleteRol(int $id)
    {
        $this->intIdRol = $id;
        $sql = "SELECT * FROM usuarios WHERE id = $this->intIdRol";
        $request = $this->select_all($sql);
        if (empty($request)) {
            $sql = "UPDATE roles SET status = ? WHERE id = $this->intIdRol";
            $arrData = array(0);
            $request = $this->update($sql, $arrData);
            if ($request) {
                $request = "ok";
            } else {
                $request = "error";
            }
        } else {
            $request = "exist";
        }
        return $request;
    }
}
