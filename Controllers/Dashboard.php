<?php

class Dashboard extends Controllers {

    function __construct()
    {
        parent::__construct();
    }
    public function dashboard()
    {
        $data["page_id"] = 2;
        $data["page_tag"] = "Dashboard";
        $data["page_title"] = "Dashboard - Tienda";
        $data["page_name"] = "dashboard";
        $this->views->getView($this, "dashboard", $data);
    }
}