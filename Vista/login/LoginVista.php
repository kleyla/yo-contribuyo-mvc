<?php

class LoginVista extends Vista
{
    public function __construct()
    {
        parent::__construct();
        // echo "Desde la vista Login";
    }
    public function index($data = "")
    {
        $view = VIEWS . "login/login.php";
        require_once($view);
    }
}
