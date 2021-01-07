<?php

class Register extends Controlador
{
    private $usuario;
    public function __construct()
    {
        session_start();
        if (isset($_SESSION['login'])) {
            header('Location: ' . base_url() . 'dashboard');
        }
        parent::__construct();
        require_once("Modelo/UsuarioModelo.php");
        $this->usuario = new UsuarioModelo();
    }

    public function register()
    {
        $this->vista->index();
    }
    public function registerUser()
    {
        // dep($_POST);
        if ($_POST) {
            if (empty($_POST["txtEmail"]) || empty($_POST["txtPass"]) || empty($_POST['txtNick'])) {
                $arrResponse = array('status' => false, 'msg' => "Error de datos");
            } else {
                $strEmail = strtolower(strClean($_POST['txtEmail']));
                $strNick = strClean($_POST['txtNick']);
                $strPass = hash("SHA256", $_POST['txtPass']);
                $this->usuario->setEmail($strEmail);
                $this->usuario->setNick($strNick);
                $this->usuario->setPassword($strPass);
                $this->usuario->setRol("Contribuidor");

                $requestUser = $this->usuario->insertUsuario();
                // dep($requestUser);
                if ($requestUser === "exist") {
                    $arrResponse = array('status' => false, 'msg' => "El email o nick ya existen");
                } else if ($requestUser > 0) {
                    $_SESSION['idUser'] = $requestUser;
                    $_SESSION['login'] = true;
                    $this->usuario->setId($_SESSION['idUser']);
                    $arrData = $this->usuario->sessionLogin();
                    $_SESSION['userData'] = $arrData;
                    $arrResponse = array('status' => true, 'msg' => "ok");
                } else {
                    $arrResponse = array('status' => false, 'msg' => $requestUser);
                }
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }
}
