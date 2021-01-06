<?php

class ArticuloVista extends Vista
{
    public function __construct()
    {
        parent::__construct();
        // echo "Desde la vista Login";
    }
    public function index()
    {
        $data["page_id"] = 1;
        $data["page_tag"] = "Articulos";
        $data["page_title"] = "Articulos - Yo contribuyo";
        $data["page_name"] = "articulos";
        $data["nav_articulos"] = "active";
        $data["script"] = "articulo.js";

        $view = VIEWS . "articulo/articulos.php";
        require_once($view);
    }
    public function form($id)
    {
        $data["page_id"] = 1;
        $data["page_tag"] = "Articulos";
        $data["page_title"] = "Articulos - Formulario";
        $data["page_name"] = "articulos";
        $data["script"] = "articulo_nuevo.js";
        $data["id_articulo"] = $id;

        $view = VIEWS . "articulo/form.php";
        require_once($view);
    }
}
