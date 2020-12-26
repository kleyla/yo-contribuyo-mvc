<?php

class RegisterModel extends Mysql
{
    private $intId;
    private $strEmail;
    private $strNick;
    private $strPassword;
    private $strRol;

    public function __construct()
    {
        parent::__construct();
        // echo "mensaje desde el modelo home!";
    }
    public function registerUser(string $email, string $nick, string $pass)
    {
        try {
            $this->strEmail = $email;
            $this->strNick = $nick;
            $this->strPassword = $pass;
            $this->strRol = "Contribuidor";

            $sql = "SELECT * FROM usuarios WHERE nick = '$this->strNick' OR email = '$this->strEmail'";
            $request = $this->select_all($sql);
            if (empty($request)) {
                $query_insert = "INSERT INTO usuarios(nick, email, pass, rol, estado, fecha) VALUES (?,?,?,?,1, now())";
                $arrData = array($this->strNick, $this->strEmail, $this->strPassword, $this->strRol);
                $request_insert = $this->insert($query_insert, $arrData);
                $return = $request_insert;
                return $return;
            } else {
                throw new Exception("exist");
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    public function sessionLogin(int $idUsuario)
    {
        $this->intId = $idUsuario;
        // BUSCAR ROL
        $sql = "SELECT usuarios.nick, usuarios.email, usuarios.estado, usuarios.rol, usuarios.fecha FROM usuarios
                WHERE id_usuario = $this->intId";
        $request = $this->select($sql);
        return $request;
    }
}
