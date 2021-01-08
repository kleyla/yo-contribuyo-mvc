<?php

class Dashboard extends Controlador
{

    function __construct()
    {
        parent::__construct();
        session_start();
        if (empty($_SESSION['login'])) {
            header('Location: ' . base_url() . 'login');
        }
    }
    public function dashboard()
    {
        // echo "Desde el controlador";
        $data["page_id"] = 2;
        $data["page_tag"] = "Dashboard";
        $data["page_title"] = "Dashboard - Yo contribuyo";
        $data["page_name"] = "dashboard";
        $data["nav_dash"] = "active";
        $this->vista->getView($this, "dashboard", $data);
    }
}
