<?php

class HomeVista extends Vista
{
    public function __construct()
    {
        parent::__construct();
        // echo "Desde la vista Login";
        require_once("Modelo/ProyectoModelo.php");
        $this->proyecto = new ProyectoModelo();
        require_once("Modelo/ArticuloModelo.php");
        $this->articulo = new ArticuloModelo();
    }
    public function index()
    {
        $data["tag_name"] = "Home";
        $data["page_title"] = "Pagina principal";
        $data["page_name"] = "home";
        $arrData = $this->proyecto->getActiveProyectos();
        $data["proyectos"] = $arrData;
        $arrData = $this->articulo->getActiveArticulos();
        $data["articulos"] = $arrData;
        $this->getView("home/home", $data);
    }
    public function proyectos()
    {
        $data["tag_name"] = "Proyectos";
        $data["page_title"] = "Ver Proyectos";
        $data["page_name"] = "proyectos";
        $arrData = $this->proyecto->getActiveProyectos();
        $data["proyectos"] = $arrData;
        $this->getView("proyecto/verProyectos", $data);
    }
    public function articulos()
    {
        $data["tag_name"] = "Articulos";
        $data["page_title"] = "Ver Articulos";
        $data["page_name"] = "articulos";
        $arrData = $this->articulo->getActiveArticulos();
        $data["articulos"] = $arrData;
        $this->getView("articulo/verArticulos", $data);
    }
    public function verArticulo($id)
    {
        $data["tag_name"] = "Articulo";
        $data["page_title"] = "Ver Articulo";
        $data["page_name"] = "articulo";
        $data['script'] = 'denuncia.js';
        $this->articulo->setId($id);
        $arrData = $this->articulo->getArticuloHome();
        $data["articulo"] = $arrData;
        $this->getView("articulo/verArticulo", $data);
    }
    public function verProyecto($id)
    {
        $data["tag_name"] = "Proyecto";
        $data["page_title"] = "Ver Proyecto";
        $data["page_name"] = "proyectos";
        $data['script'] = 'acciones.js';
        $this->proyecto->setId($id);
        $arrData = $this->proyecto->getProyectoHome();
        $data["proyecto"] = $arrData;
        // dep($data);
        $this->getView("proyecto/verProyecto", $data);
    }
}
