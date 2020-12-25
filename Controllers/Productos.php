<?php

class Productos extends Controllers
{

    public function __construct()
    {
        parent::__construct();
    }
    public function productos()
    {
        // echo 1;
        $data["tag_name"] = "Productos";
        $data["page_title"] = "Productos en venta";
        $data["page_name"] = "productos";
        $this->views->getView($this, "productos", $data);
    }
}
