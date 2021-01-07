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
        $dato = explode('Vista', get_class($this));
        // echo $dato[0];
        $model = $dato[0] . "Modelo";
        // $model = ucfirst(get_class($this));
        // echo $model;
        $routClass = "Modelo/" . $model . ".php";
        if (file_exists($routClass)) {
            // echo $routClass;
            require_once($routClass);
            $this->model = new $model();
        } else {
            echo "No existe el modelo";
        }
    }
    public function getView($view, $data = "")
    {
        $view = VIEWS . $view . ".php";
        // echo $view;
        if (file_exists($view)) {
            require_once($view);
        }else{
            echo "No existe la vista";
        }
    }
}
