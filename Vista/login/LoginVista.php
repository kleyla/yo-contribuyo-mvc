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
        $this->getView("login/login", $data);
    }
}
