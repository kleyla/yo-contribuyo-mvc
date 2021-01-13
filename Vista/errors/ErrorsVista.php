<?php

class ErrorsVista extends Vista
{
    public function __construct()
    {
        parent::__construct();
        // echo "Desde la vista Login";
    }
    public function index()
    {
        $this->getView("errors/error");
    }
}
