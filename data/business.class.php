<?php
//Incluyendo la conexión a la base de datos
require_once $dir_fc."connections/conn_data.php";

class cBusiness extends BD
{
    private $conn;

    function __construct() {
        //Esta es la que llama a la base de datos
        //parent::__construct();
        $this->conn = new BD();
    }

    function getDataTurno(){

        $query = "  SELECT id_turno, descripcion, activo
                      FROM cat_turno 
                     WHERE activo = 1
                    ORDER BY id_turno ASC ";
        $result = $this->conn->prepare($query);
        $result->execute();
        return $result;
    }

    function getDataJuez() {
        $query = "  SELECT id_jueces_dtl, D.id_zona, D.id_turno, id_juez, 
                            CONCAT_WS(' ', J.nombre, J.apepa, J.apema) as nm_juez,
                            id_secretario, CONCAT_WS(' ', S.nombre, S.apepa, S.apema) as nm_secretario
                      FROM tbl_jueces_dtl D
                    LEFT JOIN ws_usuario J ON id_juez = J.id_usuario
                    LEFT JOIN ws_usuario S ON id_secretario = S.id_usuario
                    ORDER BY id_turno ASC ";
        $result = $this->conn->prepare($query);
        $result->execute();
        return $result;
    }

    function getDataSecretario() {
        $query = "  SELECT id_jueces_dtl, D.id_zona, D.id_turno, id_juez,
                            id_secretario, CONCAT_WS(' ', S.nombre, S.apepa, S.apema) as nm_secretario
                      FROM tbl_jueces_dtl D
                    LEFT JOIN ws_usuario S ON id_secretario = S.id_usuario
                    ORDER BY id_turno ASC ";
        $result = $this->conn->prepare($query);
        $result->execute();
        return $result;
    }

    public function getTurnoById( $id ) {
        $turno = "";
        $query = "  SELECT descripcion
                      FROM cat_turno 
                     WHERE id_turno = $id  ";
        $result = $this->conn->prepare($query);
        $result->execute();
        while ($row = $result->fetch(PDO::FETCH_OBJ)) {
            $turno = $row->descripcion;
        }
        return $turno;
    }

    public function getUsuarioById($id) {
        $name = "";
        $query = "  SELECT CONCAT_WS(' ', nombre, apepa, apema) as nm_completo
                      FROM ws_usuario 
                     WHERE id_usuario = $id  ";
        $result = $this->conn->prepare($query);
        $result->execute();
        while ($row = $result->fetch(PDO::FETCH_OBJ)) {
            $name = $row->nm_completo;
        }
        return $name;
    }
      
    public function closeOut(){
        $this->conn = null;
    }
}
