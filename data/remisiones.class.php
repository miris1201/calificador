<?php
//Incluyendo la conexión a la base de datos
require_once $dir_fc."connections/conn_data.php";

class cRemision extends BD
{
    private $conn;

    function __construct() {
        //Esta es la que llama a la base de datos
        //parent::__construct();
        $this->conn = new BD();
    }

    private $filtro;
    private $inicio;
    private $fin;
    private $limite;

        /**
     * Get the value of filtro
     */ 
    public function getFiltro()
    {
        return $this->filtro;
    }

    /**
     * Set the value of filtro
     *
     * @return  self
     */ 
    public function setFiltro($filtro)
    {
        $this->filtro = $filtro;

        return $this;
    }

    /**
     * Get the value of inicio
     */ 
    public function getInicio()
    {
        return $this->inicio;
    }

    /**
     * Set the value of inicio
     *
     * @return  self
     */ 
    public function setInicio($inicio)
    {
        $this->inicio = $inicio;

        return $this;
    }

    /**
     * Get the value of fin
     */ 
    public function getFin()
    {
        return $this->fin;
    }

    /**
     * Set the value of fin
     *
     * @return  self
     */ 
    public function setFin($fin)
    {
        $this->fin = $fin;

        return $this;
    }

    /**
     * Get the value of limite
     */ 
    public function getLimite()
    {
        return $this->limite;
    }

    /**
     * Set the value of limite
     *
     * @return  self
     */ 
    public function setLimite($limite)
    {
        $this->limite = $limite;

        return $this;
    }

  
    public function getAllReg(){
        //Incio fin son para paginado
        $milimite = "";
        $condition = "";
        if ($this->getLimite() == 1){ $milimite = "LIMIT ".$this->getInicio().", ".$this->getFin();}

        if ($this->getFiltro() != ""){
            $condition = " WHERE ejercicio = ".$this->getFiltro()." ";
        }

        $query = "  SELECT id_remision, id_usr_captura, fecha_captura, id_ciudadano, 
                             DATE_FORMAT(fecha_remision, '%d-%m-%Y %H:%I') as fecha_remision, 
                            id_turno, folio, subfolio, año, falta1, falta2, falta3, patrulla, agente, 
                            escolta, sector, id_colonia, calle, entrecalle1, entrecalle2, observaciones, 
                            manifiestainfractor, manifiestacalificador, sts, patrullero, escoltan, activo
                      FROM tbl_remision 
                     $condition 
                    ORDER BY año DESC, folio DESC ".$milimite;
        $result = $this->conn->prepare($query);
        $result->execute();
        return $result;
    }

    public function getCountCiudadanos($id) {
        $count = 0;
        $query = "  SELECT COUNT(*) AS CC
                      FROM tbl_ciudadanos 
                     WHERE id_remision = $id  ";
        $result = $this->conn->prepare($query);
        $result->execute();
        if ($result->rowCount() > 0) {
            $row = $result->fetch(PDO::FETCH_OBJ);
            $count = $row->CC;
        }
        return $count;
    }

    public function getNmCiudadanos($id) {
        $array = array();
        $query = "  SELECT CONCAT_WS(' ', nombre, apepa, apema) as nm_ciudadano
                      FROM tbl_ciudadanos 
                     WHERE id_remision = $id  ";
        $result = $this->conn->prepare($query);
        $result->execute();
        if ($result->rowCount() > 0) {
            $row = $result->fetch(PDO::FETCH_OBJ);
            $array = $row->nm_ciudadano;
        }
        return $array;
    }
  
    public function getRegCiudadanosByRem($id) {
        $query = "  SELECT CONCAT_WS(' ', nombre, apepa, apema) as nm_ciudadano
                      FROM tbl_ciudadanos 
                     WHERE id_remision = $id  ";
        $result = $this->conn->prepare($query);
        $result->execute();
        return $result;
    }

    public function getCatElementos(){
        $query = "  SELECT id_usuario, no_empleado, CONCAT_WS(' ', nombre, apepa, apema) as nm_elemento
                      FROM ws_usuario 
                    where id_rol = 5 AND activo = 1
                    ORDER BY no_empleado ASC ";
        $result = $this->conn->prepare($query);
        $result->execute();
        return $result;
    }

    public function getCatColonias(){
        $query = "  SELECT id_comunidad, colonia, tipologia
                      FROM cat_comunidad 
                    ORDER BY colonia ASC ";
        $result = $this->conn->prepare($query);
        $result->execute();
        return $result;
    }

    public function getSectorByColonia( $id ) {
        $data = 0;

        $query = "  SELECT sector
                      FROM cat_comunidad 
                     WHERE id_comunidad = $id  ";
        $result = $this->conn->prepare($query);
        $result->execute();
        while ($row = $result->fetch(PDO::FETCH_OBJ)) {
            $data = $row->sector;
        }
        return $data;
    }

    public function getCatAutoridad(){
        $query = "  SELECT id_autoridad, descripcion, activo
                      FROM cat_autoridad_remite
                     WHERE activo = 1
                    ORDER BY descripcion ASC ";
        $result = $this->conn->prepare($query);
        $result->execute();
        return $result;
    }

    public function getCatEstadoFisico(){
        $query = "  SELECT id_edo_fisico, descripcion, activo
                      FROM cat_edo_fisico 
                     WHERE activo = 1
                    ORDER BY descripcion ASC ";
        $result = $this->conn->prepare($query);
        $result->execute();
        return $result;
    }

    public function getCatOcupacion(){
        $query = "  SELECT id_ocupacion, descripcion, activo
                      FROM cat_ocupacion 
                     WHERE activo = 1
                    ORDER BY descripcion ASC ";
        $result = $this->conn->prepare($query);
        $result->execute();
        return $result;
    }

    public function getCatEstudios(){
        $query = "  SELECT id_nvl_estudios, descripcion, activo
                      FROM cat_nivel_estudios 
                     WHERE activo = 1
                    ORDER BY id_nvl_estudios ASC ";
        $result = $this->conn->prepare($query);
        $result->execute();
        return $result;
    }

    public function getCatArticulos(){
        $query = "  SELECT id_articulo, articulo, descripcion, activo
                      FROM cat_articulos 
                     WHERE activo = 1
                    ORDER BY id_articulo ASC ";
        $result = $this->conn->prepare($query);
        $result->execute();
        return $result;
    }

    public function closeOut(){
        $this->conn = null;
    }
  



}
