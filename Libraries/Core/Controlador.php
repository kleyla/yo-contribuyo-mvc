<?php
class Controlador
{
    public function __construct()
    {
        // $this->vista = new Vista();
        $this->loadModel();
        $this->loadView();
    }
    public function loadModel()
    {
        // HomeMode.php
        $controlador = get_class($this);
        // echo $controlador;
        if ($controlador != "Dashboard" && $controlador != "Register") {
            $model = get_class($this) . "Modelo";
            // $model = ucfirst(get_class($this));
            // echo $model;
            $routClass = "Modelo/" . $model . ".php";
            // echo $routClass;
            if (file_exists($routClass)) {
                require_once($routClass);
                $this->model = new $model();
            } else {
                echo "No existe el modelo";
            }
        } else {
            // echo "es Dash";
        }
    }

    public function loadView()
    {
        $controlador = get_class($this);
        // echo $controlador;
        if ($controlador != "Comentario") {
            $vista = $controlador . "Vista";
            $routClass = "Vista/" . strtolower($controlador) . "/" . $vista . ".php";
            // echo $routClass;
            if (file_exists($routClass)) {
                require_once($routClass);
                $this->vista = new $vista();
            } else {
                echo "No existe la vista";
            }
        }
    }
}
