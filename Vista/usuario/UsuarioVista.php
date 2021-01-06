<?php

class UsuarioVista extends Vista
{
    public function __construct()
    {
        parent::__construct();
        // echo "Desde la vista Login";
    }
    public function index()
    {
        $data["page_id"] = 1;
        $data["page_tag"] = "Usuarios";
        $data["page_title"] = "Usuarios - Yo contribuyo";
        $data["page_name"] = "usuarios";
        $data["nav_usuarios"] = "active";
        $data["script"] = "usuario.js";
        $view = VIEWS . "usuario/usuarios.php";
        require_once($view);
    }
    public function perfil()
    {
        $data["page_tag"] = "Perfil";
        $data["page_title"] = "Perfil de usuario";
        $data["page_name"] = "perfil";
        $data["script"] = "js/functions_perfil.js";
        $view = VIEWS . "usuario/perfil.php";
        require_once($view);
    }
}
