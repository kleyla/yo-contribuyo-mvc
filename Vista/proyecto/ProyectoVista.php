<?php

class ProyectoVista extends Vista
{
    public function __construct()
    {
        parent::__construct();
        // echo "Desde la vista Login";
        require_once("Modelo/LenguajeModelo.php");
        $this->lenguaje = new LenguajeModelo();
    }
    public function index()
    {
        $data["page_id"] = 1;
        $data["page_tag"] = "Proyectos";
        $data["page_title"] = "Proyectos - Yo contribuyo";
        $data["page_name"] = "proyectos";
        $data["nav_proyectos"] = "active";
        $data["script"] = "proyecto/proyectos.js";
        $this->getView("proyecto/proyectos", $data);
    }
    public function form($id)
    {
        $data["page_id"] = 1;
        $data["page_tag"] = "Proyectos";
        $data["page_title"] = "Proyectos - Formulario";
        $data["page_name"] = "proyectos";
        $data["script"] = "proyecto/proyectos.js";
        $lenguajes = $this->lenguaje->getActiveLenguajes();
        $data["lenguajes"] = $lenguajes;
        $data["id_proyecto"] = $id;
        // dep($lenguajes);
        $this->getView("proyecto/form", $data);
    }
}
