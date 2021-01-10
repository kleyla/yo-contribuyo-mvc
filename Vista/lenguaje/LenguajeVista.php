<?php

class LenguajeVista extends Vista
{
    public function __construct()
    {
        parent::__construct();
        // echo "Desde la vista Login";
    }
    public function index()
    {
        $data["page_id"] = 1;
        $data["page_tag"] = "Lenguajes";
        $data["page_title"] = "Lenguajes - Yo contribuyo";
        $data["page_name"] = "lenguajes";
        $data["nav_lenguajes"] = "active";
        $data["script"] = "lenguaje/lenguajes.js";
        $this->getView("lenguaje/lenguajes", $data);
    }
}
