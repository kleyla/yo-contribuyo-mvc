<?php

class DashboardVista extends Vista
{
    public function __construct()
    {
        parent::__construct();
        // echo "Desde la vista Dash";
    }
    public function index()
    {
        $data["page_id"] = 2;
        $data["page_tag"] = "Dashboard";
        $data["page_title"] = "Dashboard - Tienda";
        $data["page_name"] = "dashboard";
        $data["nav_dash"] = "active";
        $this->getView("dashboard/dashboard", $data);
    }
}
