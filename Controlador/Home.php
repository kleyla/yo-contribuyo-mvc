<?php

class Home extends Controlador
{
    public function __construct()
    {
        parent::__construct();
        require_once("Modelo/ProyectoModelo.php");
        $this->proyecto = new ProyectoModelo();
        require_once("Modelo/ArticuloModelo.php");
        $this->articulo = new ArticuloModelo();
    }

    public function home()
    {
        // echo "mensaje desde el controlador";
        session_start();
        $data["tag_name"] = "Home";
        $data["page_title"] = "Pagina principal";
        $data["page_name"] = "home";
        $arrData = $this->proyecto->getActiveProyectos();
        $data["proyectos"] = $arrData;
        $arrData = $this->articulo->getActiveArticulos();
        $data["articulos"] = $arrData;
        $this->vista->getView($this, "home", $data);
    }
    public function proyectos()
    {
        session_start();
        $data["tag_name"] = "Proyectos";
        $data["page_title"] = "Ver Proyectos";
        $data["page_name"] = "proyectos";
        $arrData = $this->proyecto->getActiveProyectos();
        $data["proyectos"] = $arrData;
        // dep($data);
        $this->vista->getView($this, "proyecto/verProyectos", $data);
    }

    public function articulos()
    {
        session_start();
        // echo "mensaje desde el controlador";
        $data["tag_name"] = "Articulos";
        $data["page_title"] = "Ver Articulos";
        $data["page_name"] = "articulos";
        $arrData = $this->articulo->getActiveArticulos();
        $data["articulos"] = $arrData;
        $this->vista->getView($this, "articulo/verArticulos", $data);
    }
    public function verArticulo($id)
    {
        if (intval($id) > 0) {
            session_start();
            $data["tag_name"] = "Articulo";
            $data["page_title"] = "Ver Articulo";
            $data["page_name"] = "articulo";
            $data['script'] = 'denuncia/DenunciaVista.js';
            $this->articulo->setId($id);
            $arrData = $this->articulo->getArticuloHome();
            $data["articulo"] = $arrData;
            $this->vista->getView($this, "articulo/verArticulo", $data);
        }
    }
    public function verProyecto($id)
    {
        if (intval($id) > 0) {
            session_start();
            $data["tag_name"] = "Proyecto";
            $data["page_title"] = "Ver Proyecto";
            $data["page_name"] = "proyectos";
            $data['script'] = 'accion/AccionVista.js';
            $this->proyecto->setId($id);
            $arrData = $this->proyecto->getProyectoHome();
            $data["proyecto"] = $arrData;
            // dep($data);
            $this->vista->getView($this, "proyecto/verProyecto", $data);
        }
    }
}
