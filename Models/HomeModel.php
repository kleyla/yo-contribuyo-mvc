<?php

class HomeModel extends Mysql
{
    public function __construct()
    {
        parent::__construct();
        // echo "mensaje desde el modelo home!";
    }
    public function getActiveProyects()
    {
        try {
            $sql = "SELECT * FROM proyectos WHERE estado = 1";
            $request = $this->select_all($sql);
            for ($i = 0; $i < count($request); $i++) {
                $id = $request[$i]['id_proyecto'];
                $sql_lenguajes = "SELECT lenguajes.*  FROM proyectos, lenguajes, proyecto_lenguaje WHERE proyectos.id_proyecto = $id AND proyecto_lenguaje.proyecto_id = proyectos.id_proyecto AND proyecto_lenguaje.lenguaje_id = lenguajes.id_lenguaje";
                $request_lenguajes = $this->select_all($sql_lenguajes);
                $request[$i]["lenguajes"] = $request_lenguajes;
            }
            // dep($request);
            return $request;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
    public function getActiveArticulos()
    {
        try {
            $sql = "SELECT articulos.*, usuarios.nick FROM articulos, usuarios 
                WHERE articulos.estado = 1 
                AND articulos.usuario_id = usuarios.id_usuario";
            $request = $this->select_all($sql);
            return $request;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
    public function getArticulo(int $id)
    {
        try {
            $sql = "SELECT articulos.*, usuarios.nick FROM articulos, usuarios WHERE id_articulo = $id 
                AND articulos.usuario_id = usuarios.id_usuario";
            $request = $this->select($sql);
            return $request;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
    public function getProyecto(int $id)
    {
        try {
            $this->intId = $id;
            $sql = "SELECT *  FROM proyectos WHERE id_proyecto = $id";
            $request = $this->select($sql);
            $sql = "SELECT lenguajes.*  FROM proyectos, lenguajes, proyecto_lenguaje WHERE id_proyecto = $this->intId AND proyecto_lenguaje.proyecto_id = proyectos.id_proyecto AND proyecto_lenguaje.lenguaje_id = lenguajes.id_lenguaje";
            $request_lenguajes = $this->select_all($sql);
            $request["lenguajes"] = $request_lenguajes;
            $sql = "SELECT c.*, u.nick, a.fecha
                FROM proyectos p, acciones a, comentarios c, usuarios u 
                WHERE p.id_proyecto = $id AND a.proyecto_id = p.id_proyecto AND a.usuario_id = u.id_usuario AND a.id_accion = c.accion_id AND a.estado = true";
            $request_comentarios = $this->select_all($sql);
            $request["comentarios"] = $request_comentarios;
            // dep($request);
            return $request;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}
