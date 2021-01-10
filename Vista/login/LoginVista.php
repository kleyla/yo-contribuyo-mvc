<?php

class LoginVista extends Vista
{
    public function __construct()
    {
        parent::__construct();
        // echo "Desde la vista Login";
    }
    public function index()
    {
        $data["page_tag"] = "Login - Yo Contribuyo";
        $data["page_title"] = "Login";
        $data["page_name"] = "login";
        $data["script"] = "login/login.js";
        $this->getView("login/login", $data);
    }
}
