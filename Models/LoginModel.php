<?php

class LoginModel extends Mysql
{
    private $intId;
    private $strEmail;
    private $strPassword;
    private $strToken;

    public function __construct()
    {
        parent::__construct();
        // echo "mensaje desde el modelo home!";
    }
    public function loginUser(string $email, string $pass)
    {
        $this->strEmail = $email;
        $this->strPassword = $pass;
        // echo   $sql = "SELECT id_usuario, estado FROM usuarios 
        //         WHERE email = '$this->strEmail' and pass = '$this->strPassword' and estado = 1";
        // exit;
        $sql = "SELECT id_usuario, estado FROM usuarios 
                WHERE email = '$this->strEmail' and pass = '$this->strPassword'";
        $request = $this->select($sql);
        return $request;
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
