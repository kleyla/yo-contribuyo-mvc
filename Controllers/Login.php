<?php

class Login extends Controllers
{
    private $usuario;

    public function __construct()
    {
        session_start();
        if (isset($_SESSION['login'])) {
            header('Location: ' . base_url() . 'dashboard');
        }
        parent::__construct();
        require_once("Models/UsuariosModel.php");
        $this->usuario = new UsuariosModel();
        // echo "Desde el controlador";
    }

    public function login()
    {
        // echo "mensaje desde el metodo";
        $data["page_tag"] = "Login - Yo Contribuyo";
        $data["page_title"] = "Login";
        $data["page_name"] = "login";
        $data["script"] = "js/functions_login.js";
        $this->views->getView($this, "login", $data);
    }
    public function loginUser()
    {
        // dep($_POST);
        if ($_POST) {
            if (empty($_POST["txtEmail"]) || empty($_POST["txtPass"])) {
                $arrResponse = array('status' => false, 'msg' => "Error de datos");
            } else {
                $strEmail = strtolower(strClean($_POST['txtEmail']));
                $strPass = hash("SHA256", $_POST['txtPass']);

                $this->usuario->setEmail($strEmail);
                $this->usuario->setPassword($strPass);
                $requestUser = $this->usuario->loginUser();
                // dep($requestUser);
                if (empty($requestUser)) {
                    $arrResponse = array('status' => false, 'msg' => "El usuario o la contrasena es incorrecto");
                } else {
                    $arrData = $requestUser;
                    if ($arrData['estado'] == 1) {
                        $_SESSION['idUser'] = $arrData['id_usuario'];
                        $_SESSION['login'] = true;

                        $this->usuario->setId($_SESSION['idUser']);
                        $arrData = $this->usuario->sessionLogin();
                        $_SESSION['userData'] = $arrData;
                        $arrResponse = array('status' => true, 'msg' => "ok");
                    } else {
                        $arrResponse = array('status' => false, 'msg' => "Usuario inactivo");
                    }
                }
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }
}
