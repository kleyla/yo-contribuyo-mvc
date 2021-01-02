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
        $arrData = $this->model->getActiveArticulos();
        $data["articulos"] = $arrData;
        $this->views->getView($this, "home", $data);
    }
    public function pass(string $pass)
    {
        $dato = hash("SHA256", $pass);
        echo $dato;
    }
    public function proyectos()
    {
        session_start();
        $data["tag_name"] = "Proyectos";
        $data["page_title"] = "Ver Proyectos";
        $data["page_name"] = "proyectos";
        $arrData = $this->model->getActiveProyects();
        $data["proyectos"] = $arrData;
        $this->views->getView($this, "proyectos/verProyectos", $data);
    }

    public function articulos()
    {
        session_start();
        // echo "mensaje desde el controlador";
        $data["tag_name"] = "Articulos";
        $data["page_title"] = "Ver Articulos";
        $data["page_name"] = "articulos";
        $arrData = $this->model->getActiveArticulos();
        $data["articulos"] = $arrData;
        $this->views->getView($this, "articulos/verArticulos", $data);
    }
    public function verArticulo($id)
    {
        if (intval($id) > 0) {
            session_start();
            $data["tag_name"] = "Articulo";
            $data["page_title"] = "Ver Articulo";
            $data["page_name"] = "articulo";
            $data['script'] = 'js/functions_denuncias.js';
            $arrData = $this->model->getArticulo($id);
            $data["articulo"] = $arrData;
            $this->views->getView($this, "articulos/verArticulo", $data);
        }
    }
    public function verProyecto($id)
    {
        if (intval($id) > 0) {
            session_start();
            $data["tag_name"] = "Proyecto";
            $data["page_title"] = "Ver Proyecto";
            $data["page_name"] = "proyectos";
            $data['script'] = 'js/functions_acciones.js';
            $arrData = $this->model->getProyecto($id);
            $data["proyecto"] = $arrData;
            // dep($data);
            $this->views->getView($this, "proyectos/verProyecto", $data);
        }
    }
}
