<?php

class ProyectosModel extends Mysql
{
    public function __construct()
    {
        parent::__construct();
        // echo "mensaje desde el modelo home!";
    }
    public function all()
    {
        $sql = "SELECT * FROM proyectos, usuarios";
        $request = $this->select_all($sql);
        return $request;
    }
}
