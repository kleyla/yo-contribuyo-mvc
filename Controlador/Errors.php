<?php

class Errors extends Controlador
{
    public function __construct()
    {
        parent::__construct();
    }

    public function notFound()
    {
        // echo "error";
        $this->vista->index();
    }
}

$notFound = new Errors();
$notFound->notFound();
