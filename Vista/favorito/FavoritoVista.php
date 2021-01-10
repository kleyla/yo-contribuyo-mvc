<?php

class FavoritoVista extends Vista
{
    public function __construct()
    {
        parent::__construct();
        // echo "Desde la vista Login";
    }
    public function index()
    {
        $data["page_id"] = 1;
        $data["page_tag"] = "Favoritos";
        $data["page_title"] = "Favoritos - Yo contribuyo";
        $data["page_name"] = "favoritos";
        $data["nav_favoritos"] = "active";
        $data["script"] = "favorito/favoritos.js";
        $this->getView("favorito/favoritos", $data);
    }
}
