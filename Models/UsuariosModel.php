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
        $return = "";
        $this->strNick = $nick;
        $this->strEmail = $email;
        $this->strPassword = $pass;
        $this->intStatus = $estado;
        $this->strRol = $rol;
        $sql = "SELECT * FROM usuarios WHERE nick = '$this->strNick' OR email = '$this->strEmail'";
        $request = $this->select_all($sql);
        if (empty($request)) {
            $query_insert = "INSERT INTO usuarios(nick, email, pass, estado, rol, fecha) VALUES (?,?,?,?,?, now())";
            $arrData = array($this->strNick, $this->strEmail, $this->strPassword, $this->intStatus, $this->strRol);
            $request_insert = $this->insert($query_insert, $arrData);
            $return = $request_insert;
        } else {
            $return = "exist";
        }
        return $return;
    }
}
