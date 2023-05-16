<?php
//Incluyendo la conexión a la base de datos
require_once $dir_fc."connections/conn_data.php";
/**
 * * Operaciones y movimientos que se realizan para el menú y otras herramientas de inicio que viene de la base de datos
 */
class cInicial extends BD
{
    private $conn;

    function __construct()
    {
        $this->conn = new BD();
    }

    public function menuParents($usr){
        try {
            $query = " SELECT DISTINCT (rm.id_menu), m.texto, m.link, m.title, m.class
		 			     FROM ws_usuario_menu rm
		 			     JOIN ws_menu m ON rm.id_menu = m.id_menu
		 			    WHERE m.id_grupo = 0 AND rm.id_usuario = ".$usr." AND m.activo = 1  
                        ORDER BY m.orden ASC ";
            $result = $this->conn->prepare($query);
            $result->execute();
            return $result;
        }
        catch(\PDOException $e)
        {
            return "Error!: " . $e->getMessage();
        }
    }

    public function menuChild($parent, $usr){
        try {
            $query = " SELECT m.id_menu, 
                              m.texto, 
                              m.link, 
                              m.title, 
                              m.class
                         FROM ws_menu m
                        WHERE m.id_grupo > 0 
                            AND m.activo = 1 
                            AND m.id_grupo = $parent
                            AND m.id_menu in (select id_menu from ws_usuario_menu WHERE id_usuario = ".$usr." )
                       ORDER BY orden ASC ";
            // echo $query;
            $result = $this->conn->prepare($query);
            $result->execute();
            return $result;
        }
        catch(\PDOException $e) {
            print "Error!: " . $e->getMessage();
        }
    }

    public function traeRolByUser($id){
        $query = " SELECT id_usuario_menu AS id_rol 
                     FROM ws_usuario_menu WHERE id_usuario = $id";
        $result = $this->conn->prepare($query);
        $result->execute();
        return $result;
    }

    public function checarRol_pagina($id_usr, $id_menu) {
        $query  = " SELECT count(id_usuario_menu) as contador, imp, edit, elim, nuevo, exportar
                      FROM ws_usuario_menu 
                     WHERE id_usuario = $id_usr AND id_menu = $id_menu 
                     LIMIT 1";
        $result = $this->conn->prepare($query);
        $result->execute();
        return $result;
    }

}
?>
