<?php

class DenunciaVista extends Vista
{
    public function __construct()
    {
        parent::__construct();
        // echo "Desde la vista Dash";
    }
    public function index($idArticulo)
    {
        $data["page_id"] = 3;
        $data["page_tag"] = "Denuncias";
        $data["page_title"] = "Denuncias - Yo contribuyo";
        $data["page_name"] = "denuncias";
        $data["nav_dash"] = "active";
        $data["script"] = "denuncia/denuncias.js";
        $data["id_articulo"] = $idArticulo;
        $this->getView("denuncia/verDenuncias", $data);
    }
}
