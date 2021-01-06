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
        $this->vista->index();
    }
}
