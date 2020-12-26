<?php

class Register extends Controllers
{
    public function __construct()
    {
        session_start();
        if (isset($_SESSION['login'])) {
            header('Location: ' . base_url() . 'dashboard');
        }
        parent::__construct();
    }

    public function register()
    {
        // echo "mensaje desde el controlador";
        $data["page_tag"] = "Registro - Yo Contribuyo";
        $data["page_title"] = "Registro";
        $data["page_name"] = "registro";
        $data["script"] = "js/functions_register.js";
        $this->views->getView($this, "register", $data);
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
                $requestUser = $this->model->registerUser($strEmail, $strNick, $strPass);
                // dep($requestUser);
                if ($requestUser === "exist") {
                    $arrResponse = array('status' => false, 'msg' => "El email o nick ya existen");
                } else if ($requestUser > 0) {
                    $_SESSION['idUser'] = $requestUser;
                    $_SESSION['login'] = true;
                    $arrData = $this->model->sessionLogin($_SESSION['idUser']);
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
