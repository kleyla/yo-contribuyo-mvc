<?php

class ArticuloVista extends Vista
{
    public function __construct()
    {
        parent::__construct();
    }
    public function index()
    {
        // echo "Desde la vista Articulo";
        $data["page_id"] = 1;
        $data["page_tag"] = "Articulos";
        $data["page_title"] = "Articulos - Yo contribuyo";
        $data["page_name"] = "articulos";
        $data["nav_articulos"] = "active";
        $data["script"] = "articulo.js";
        $this->getView("articulo/articulos", $data);
    }
    public function form($id)
    {
        $data["page_id"] = 1;
        $data["page_tag"] = "Articulos";
        $data["page_title"] = "Articulos - Formulario";
        $data["page_name"] = "articulos";
        $data["nav_articulos"] = "active";
        $data["script"] = "articulo_nuevo.js";
        $data["id_articulo"] = $id;
        $this->getView("articulo/form", $data);
    }
}
