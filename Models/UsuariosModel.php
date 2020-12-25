<?php

class UsuariosModel extends Mysql
{
    public $intId;
    public $strNick;
    public $strEmail;
    public $strPassword;
    public $intEstado;
    public $strRol;
    public $fecha;

    public function __construct()
    {
        parent::__construct();
    }

    public function all()
    {
        $sql = "SELECT * FROM usuarios";
        $request = $this->select_all($sql);
        return $request;
    }
    public function insertUsuario(string $nick, string $email, string $pass, int $estado, string $rol)
    {
        try {
            $return = "";
            $this->strNick = $nick;
            $this->strEmail = $email;
            $this->strPassword = $pass;
            $this->intEstado = $estado;
            $this->strRol = $rol;
            $sql = "SELECT * FROM usuarios WHERE nick = '$this->strNick' OR email = '$this->strEmail'";
            $request = $this->select_all($sql);
            if (empty($request)) {
                $query_insert = "INSERT INTO usuarios(nick, email, pass, estado, rol, fecha) VALUES (?,?,?,?,?, now())";
                $arrData = array($this->strNick, $this->strEmail, $this->strPassword, $this->intEstado, $this->strRol);
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
    public function selectUsuario(int $id)
    {
        $this->intId = $id;
        $sql = "SELECT * FROM usuarios WHERE id_usuario = $this->intId";
        $request = $this->select($sql);
        return $request;
    }
    public function updateUsuario(int $id, string $nick, string $email, string $pass, int $estado, string $rol)
    {
        try {
            $this->intId = $id;
            $this->strNick = $nick;
            $this->strEmail = $email;
            $this->strPassword = $pass;
            $this->intEstado = $estado;
            $this->strRol = $rol;
            $sql = "SELECT * FROM usuarios WHERE (nick = '$this->strNick' OR email = '$this->strEmail') AND id_usuario != $this->intId";
            $request = $this->select_all($sql);
            if (empty($request)) {
                $sql = "UPDATE usuarios SET nick = ?, email = ?, pass = ?, estado = ?, rol = ? WHERE id_usuario = $this->intId";
                $arrData = array($this->strNick, $this->strEmail, $this->strPassword, $this->intEstado, $this->strRol);
                $request = $this->update($sql, $arrData);
                return $request;
            } else {
                throw new Exception("error");
            }
        } catch (Exception $e) {
            return  $request = "exist";
        }
    }
    public function disableUsuario(int $id)
    {
        try {
            $this->intId = $id;
            $sql = "UPDATE usuarios SET estado = ? WHERE id_usuario = $this->intId";
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
}
