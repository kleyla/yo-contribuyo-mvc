<?php

class RegisterVista extends Vista
{
    public function __construct()
    {
        parent::__construct();
        // echo "Desde la vista Login";
    }
    public function index($data = "")
    {
        $view = VIEWS . "register/register.php";
        require_once($view);
    }
}
