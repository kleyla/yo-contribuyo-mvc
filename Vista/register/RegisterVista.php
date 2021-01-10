<?php

class RegisterVista extends Vista
{
    public function __construct()
    {
        // parent::__construct();
        // echo "Desde la vista Login";
    }
    public function index()
    {
        $data["page_tag"] = "Registro - Yo Contribuyo";
        $data["page_title"] = "Registro";
        $data["page_name"] = "registro";
        $data["script"] = "register/register.js";
        $this->getView("register/register", $data);
    }
}
