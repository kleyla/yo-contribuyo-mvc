<?php

class ComentariosModel extends Mysql
{
    private $accion;
    private $strContenido;

    public function __construct()
    {
        parent::__construct();
        // echo "mensaje desde el modelo home!";
    }
    public function insertComentario(int $idProyecto, string $contenido)
    {
        try {
            $this->strContenido = $contenido;
            // $this->accion = new AccionesModel();
            $idUsuario = intval($_SESSION['idUser']);

            // ACCION
            $query_insert = "INSERT INTO acciones(usuario_id, proyecto_id) VALUES (?,?)";
            $arrData = array($idUsuario, $idProyecto);
            $request_accion = $this->insert($query_insert, $arrData);
            // $request_accion = $this->accion->insertAccion($idUsuario, $idProyecto);
            
            // COMENTARIO
            $query_insert = "INSERT INTO comentarios(contenido, accion_id) VALUES (?,?)";
            $arrData = array($this->strContenido, $request_accion);
            $request_comentario = $this->insert($query_insert, $arrData);
            return $request_accion;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}
