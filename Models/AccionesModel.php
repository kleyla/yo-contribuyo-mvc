<?php

class AccionesModel extends Mysql
{
    private $intId;
    private $intUsuarioId;
    private $intProyectoId;
    private $fecha;

    public function __construct()
    {
        parent::__construct();
        // echo "mensaje desde el modelo home!";
    }
    public function insertAccion(int $idUsuario, int $idProyecto)
    {
        try {
            $this->intUsuarioId = $idUsuario;
            $this->intProyectoId = $idProyecto;
            $query_insert = "INSERT INTO acciones(usuario_id, proyecto_id) VALUES (?,?)";
            $arrData = array($this->intUsuarioId, $this->intProyectoId);
            $request_insert = $this->insert($query_insert, $arrData);
            return $request_insert;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}
