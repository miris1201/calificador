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

    function getCountPromociones( $date_ini, $date_end, $searchTerm = null){

        $count = 0;

        $condition = "";
        
        if($date_ini != "" && $date_end != "" ){
            $condition.= " AND DATE_FORMAT (v.fecha_captura, '%Y-%m-%d') 
                                between '".$date_ini."' AND '".$date_end."'";
        }

        $query = "SELECT
                    COUNT(v.id_visita) as countVisitas
                  FROM tbl_visitas as v
                  WHERE v.promocion = 1 $condition ";
                  
        $result = $this->conn->prepare($query);
        $result->execute();

        if($result->rowCount() > 0){
            $rw = $result->fetch(PDO::FETCH_OBJ);

            $count = $rw->countVisitas;
        }
        return $count;
    }

    function getTopClients( $numberTop ){
        
        $query = "SELECT
                    c.id_cliente,
                    c.id_membresia,
                    c.id_usuario_captura,
                    c.id_usuario_modifica,
                    c.fecha_captura,
                    c.fecha_modifica,
                    CONCAT_WS( ' ', c.nombre, c.apellidop, c.apellidom) as nombrecompleto,
                    c.tel,
                    c.calle,
                    c.no_ext,
                    c.no_int,
                    c.colonia,
                    c.cp,
                    c.mun,
                    c.estado,
                    c.rfc,
                    c.debe,
                    c.abono,
                    c.saldo,
                    c.email,
                    c.descuento,
                    c.comentarios,
                    c.visitas_limitadas,
                    m.no_membersia,
                    c.count_promos,
                    c.visitas_totales,
                    c.active
                  FROM cat_cliente as c
                  LEFT JOIN cat_membresia as m on m.id_cliente = c.id_cliente
                 ORDER BY c.visitas_totales DESC LIMIT $numberTop";
                  
        $result = $this->conn->prepare($query);
        $result->execute();
        return $result;
    }

    public function getMainImgById($id)
    {
        $name = "avatar1.png";

        try {
            $queryUser = "SELECT
                                img_name
                            FROM cat_clientes_img as  a
                           WHERE id_cliente = $id 
                           ORDER by principal desc
                           LIMIT 1 ";

            $result = $this->conn->prepare($queryUser);
            $result->execute();

            if ($result->rowCount() > 0) {
                $rw = $result->fetch(PDO::FETCH_OBJ);
                $name = $rw->img_name;
            }

            return $name;
        } catch (\PDOException $e) {
            return "Error!: " . $e->getMessage();
        }
    }

    function getCountVisitas( $date_ini, $date_end, $searchTerm = null){

        $count = 0;

        $condition = "";

        if($date_ini != "" && $date_end != "" ){
            $condition.= " AND DATE_FORMAT (v.fecha_captura, '%Y-%m-%d') 
                                between '".$date_ini."' AND '".$date_end."'";
        }

        $query = "SELECT
                    COUNT(v.id_visita) as countvisita
                  FROM tbl_visitas as v
                  WHERE 1 $condition";
                  
        $result = $this->conn->prepare($query);
        $result->execute();

        if( $result->rowCount() > 0){
            $rw = $result->fetch(PDO::FETCH_OBJ);

            $count = $rw->countvisita;
        }
        return $count;
    }
  
    public function closeOut(){
        $this->conn = null;
    }
  

}
