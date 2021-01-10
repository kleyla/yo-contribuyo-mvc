<?php

class Home extends Controlador
{
    public function __construct()
    {
        parent::__construct();
    }

    public function home()
    {
        session_start();
        $this->vista->index();
    }
    public function proyectos()
    {
        session_start();
        // dep($data);
        $this->vista->proyectos();
    }

    public function articulos()
    {
        session_start();
        $this->vista->articulos();
    }
    public function verArticulo($id)
    {
        if (intval($id) > 0) {
            // echo "mensaje desde el controlador";
            session_start();
            $this->vista->verArticulo($id);
        }
    }
    public function verProyecto($id)
    {
        if (intval($id) > 0) {
            session_start();
            $this->vista->verProyecto($id);
        }
    }
}
