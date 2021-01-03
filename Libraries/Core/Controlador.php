<?php
class Controlador
{
    public function __construct()
    {
        $this->views = new Vista();
        $this->loadModel();
    }
    public function loadModel()
    {
        // HomeMode.php
        $model = get_class($this)."Modelo";
        // $model = ucfirst(get_class($this));
        // echo $model;
        $routClass = "Modelo/" . $model . ".php";
        // echo $routClass;
        if (file_exists($routClass)) {
            require_once($routClass);
            $this->model = new $model();
        }else{
            echo "No existe el modelo";
        }
    }
}
