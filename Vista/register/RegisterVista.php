<?php

class RegisterVista extends Vista
{
    public function __construct()
    {
        parent::__construct();
    }
    public function index()
    {
        // echo "Desde la vista register";
        // echo "mensaje desde el controlador";
        $data["page_tag"] = "Registro - Yo Contribuyo";
        $data["page_title"] = "Registro";
        $data["page_name"] = "registro";
        $data["script"] = "register.js";
        $this->getView("register/register", $data);
    }
}
