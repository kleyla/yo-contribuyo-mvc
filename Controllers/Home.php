<?php

class Home extends Controllers
{
    public function __construct()
    {
        parent::__construct();
    }

    public function home($params)
    {
        session_start();
        // echo "mensaje desde el controlador";
        $data["tag_name"] = "Home";
        $data["page_title"] = "Pagina principal";
        $data["page_name"] = "home";
        $arrData = $this->model->getActiveProyects();
        $data["proyectos"] = $arrData;
        $arrData =$this->model->getActiveArticulos();
        $data["articulos"] = $arrData;
        $this->views->getView($this, "home", $data);
    }
    public function pass(string $pass)
    {
        $dato = hash("SHA256", $pass);
        echo $dato;
    }
    public function proyectos($params)
    {
        $arrData = $this->model->getActiveProyects();
        dep($arrData);
    }
}
