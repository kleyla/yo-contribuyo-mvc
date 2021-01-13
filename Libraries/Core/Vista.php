<?php

class Vista
{
    public function __construct()
    {
        // $this->views = new Vista();
        $this->loadModel();
    }
    public function loadModel()
    {
        // echo get_class($this);
        $dato = explode('Vista', get_class($this));
        // echo "-" . $dato[0] . "-";
        if ($dato != "Dashboard" && $dato != "Errors") {
            $model = $dato[0] . "Modelo";
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
        }
    }
    public function getView($view, $data = "")
    {
        $view = VIEWS . $view . ".php";
        if (file_exists($view)) {
            require_once($view);
        } else {
            echo "No existe la vista";
        }
    }
    public function getViewp($controller, $view, $data = "")
    {
        $controller = get_class($controller);
        if ($controller == "Home") {
            $view = VIEWS . $view . ".php";
        } else {
            $view = VIEWS . strtolower($controller) . "/" . $view . ".php";
        }
        // echo $view;
        if (file_exists($view)) {
            require_once($view);
        }
    }
}
