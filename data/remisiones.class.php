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
        $actual = date('Y');
        $condition_a = "DATE_FORMAT(fecha_remision, '%Y') = $actual";
        
        if ($this->getLimite() == 1){ $milimite = "LIMIT ".$this->getInicio().", ".$this->getFin();}

        
        if ($this->getFiltro() != ""){
            $condition = " WHERE folio = ".$this->getFiltro()." ";
        }

        $query = "  SELECT id_remision, id_usr_captura, fecha_captura, id_ciudadano, 
                             DATE_FORMAT(fecha_remision, '%d-%m-%Y %H:%i') as fecha_remision, 
                            id_turno, folio, subfolio, año, patrulla, id_agente, 
                            id_escolta, sector, id_colonia, calle, entrecalle1, entrecalle2, observaciones, 
                            manifiestainfractor, manifiestacalificador, sts, activo
                      FROM tbl_remision 
                     $condition 
                    ORDER BY año DESC, folio DESC, id_turno ASC  ".$milimite;
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

    public function getDataFaltas( $id ) {
        $descripcion = "";
        $query = "  SELECT A.articulo, A.descripcion
                      FROM cat_articulos A
                     WHERE A.id_articulo = $id  ";
        // echo $query;
        $result = $this->conn->prepare($query);
        $result->execute();
        while ($row = $result->fetch(PDO::FETCH_OBJ)) {
            $descripcion = $row->descripcion;
        }
        return $descripcion;
    }

    public function getDataFracciones( $id ) {

        $query = "  SELECT id_articulo_dtl, fraccion
                      FROM cat_articulos_dtl 
                     WHERE id_articulo = $id  
                     ORDER BY id_articulo_dtl ASC";
        $result = $this->conn->prepare($query);
        $result->execute();
        return $result;
    }

    public function getDataFaltasDtl( $id ) {

        $query = "  SELECT fraccion, descripcion, 
                           dias_min, dias_max, 
                           hr_min, hr_max
                      FROM cat_articulos_dtl
                     WHERE id_articulo_dtl = $id  ";
        $result = $this->conn->prepare($query);
        $result->execute();
        return $result;
    }

    public function getRemisionbyid( $id ) {

        $query = "  SELECT id_remision, id_usr_captura, fecha_captura, id_autoridad, folio_rnd,
                           DATE_FORMAT(fecha_remision, '%d-%m-%Y %H:%i') as fecha_remision, id_ciudadano, 
                           id_turno, folio, subfolio, año, patrulla, id_agente, id_escolta, 
                           sector, id_colonia, calle, entrecalle1, entrecalle2, observaciones, manifiestainfractor, 
                           manifiestacalificador, sts, activo
                      FROM tbl_remision
                     WHERE id_remision = $id  ";
        $result = $this->conn->prepare($query);
        $result->execute();
        return $result;
    }

    public function getInfractoresById( $id ) {

        $query = "  SELECT id_ciudadano, id_remision, folio, subfolio, ejercicio, id_turno, turno, 
                           CONCAT_WS(' ', nombre, apepa, apema) AS nm_ciudadano,
                           genero, sexo, edad, domicilio, id_edo_fisico, id_nvl_estudios,
                           nvl_estudios, ocupacion
                      FROM tbl_ciudadanos
                     WHERE id_remision = $id  ";
        $result = $this->conn->prepare($query);
        $result->execute();
        return $result;
    }

    public function getEdoFisicoById( $id ) {
        $descripcion = "";
        $query = "  SELECT id_edo_fisico, descripcion
                      FROM cat_edo_fisico 
                     WHERE id_edo_fisico = $id  ";
        $result = $this->conn->prepare($query);
        $result->execute();
        while ($row = $result->fetch(PDO::FETCH_OBJ)) {
            $descripcion = $row->descripcion;
        }
        return $descripcion;
    }

    public function getEstudiosById( $id ) {
        $descripcion = "";
        $query = "  SELECT id_nvl_estudios, descripcion
                      FROM cat_nivel_estudios 
                     WHERE id_nvl_estudios = $id  ";
        $result = $this->conn->prepare($query);
        $result->execute();
        while ($row = $result->fetch(PDO::FETCH_OBJ)) {
            $descripcion = $row->descripcion;
        }
        return $descripcion;
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

    public function getFoundFolio($id) {
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

    public function insertRemision( $data ){
        $correcto= 1;
        $exec = $this->conn->conexion();

        $insert = "INSERT INTO tbl_remision( id_usr_captura,
                                             fecha_captura,
                                             fecha_remision,
                                             id_turno,
                                             folio, 
                                             patrulla, 
                                             id_agente, 
                                             id_escolta, 
                                             id_colonia, 
                                             sector, 
                                             calle, 
                                             entrecalle1, 
                                             entrecalle2, 
                                             observaciones )
                    VALUES (  ?,
                              ?,
                              ?,
                              ?,
                              ?,
                              ?,
                              ?,
                              ?,
                              ?,
                              ?,
                              ?,
                              ?,
                              ?,
                              ?  )";

        $result = $this->conn->prepare($insert);
        $exec->beginTransaction();
        $result->execute($data);
        if ($correcto == 1){
            $correcto= $exec->lastInsertId();
        }
        $exec->commit();
        return $correcto;
    }

    public function getCiudadanoByRem($id) {
        $query = "  SELECT id_ciudadano, id_remision, folio, subfolio, 
                            ejercicio, id_turno, turno,
                            CONCAT_WS(' ', nombre, apepa, apema) as nm_remisor,  
                            sexo, edad, domicilio, id_ocupacion, ocupacion, id_nvl_estudios, 
                            nvl_estudios, id_edo_fisico
                      FROM tbl_ciudadanos 
                     WHERE id_remision = $id  ";
        $result = $this->conn->prepare($query);
        $result->execute();
       
        return $result;
    }


    public function getArrayEdoFisico(){
        $data = array();
        $query = "SELECT id_edo_fisico, descripcion
                    FROM cat_edo_fisico ";
        $result = $this->conn->prepare($query);
        $result->execute();
        while($row = $result->fetch(PDO::FETCH_OBJ)){
                $data[$row->id_edo_fisico] = $row->descripcion;
        }
        return $data;
        
    }

    public function getArrayEstudios(){
        $data = array();
        $query = "SELECT id_nvl_estudios, descripcion
                    FROM cat_nivel_estudios ";
        $result = $this->conn->prepare($query);
        $result->execute();
        while($row = $result->fetch(PDO::FETCH_OBJ)){
                $data[$row->id_nvl_estudios] = $row->descripcion;
        }
        return $data;
        
    }

    public function getArrayOcupacion(){
        $data = array();
        $query = "SELECT id_ocupacion, descripcion
                    FROM cat_ocupacion ";
        $result = $this->conn->prepare($query);
        $result->execute();
        while($row = $result->fetch(PDO::FETCH_OBJ)){
                $data[$row->id_ocupacion] = $row->descripcion;
        }
        return $data;
        
    }

    public function getFaltasByCiudadano( $id ) {
        $query = "  SELECT id_rem_falta, id_remision, falta, fraccion, smd, 
                            hr_arresto
                      FROM tbl_rem_faltas 
                     WHERE id_ciudadano = $id  ";
        $result = $this->conn->prepare($query);
        $result->execute();
       
        return $result;
    }

    public function getFechaRem($id) {
        $anio = "";
        $query = "  SELECT DATE_FORMAT(fecha_remision, '%Y') as anio
                      FROM tbl_remision 
                     WHERE id_remision = $id  ";
        $result = $this->conn->prepare($query);
        $result->execute();
       while($row = $result->fetch(PDO::FETCH_OBJ)){
            $anio = $row->anio;
        }
        return $anio;
    }


    public function getCalculoTotalSMD( $y ) {
        $salario = 0;
        $query = "  SELECT salario
                      FROM tbl_smd 
                     WHERE ejercicio = $y  ";
        $result = $this->conn->prepare($query);
        $result->execute();
        while($row = $result->fetch(PDO::FETCH_OBJ)){
            $salario = $row->salario;
        }
        return $salario;
    }


    public function updateRemision( $data ){
        $correcto   = 1;
        $exec       = $this->conn->conexion();
        $update = " UPDATE  tbl_remision
                       SET  fecha_remision  = ?,
                            id_autoridad    = ?,
                            folio_rnd       = ?,
                            patrulla        = ?,
                            id_agente       = ?,
                            id_escolta      = ?,
                            id_colonia      = ?,
                            sector          = ?,
                            calle           = ?,
                            entrecalle1     = ?,
                            entrecalle2     = ?,
                            observaciones   = ?
                     WHERE  id_remision     = ?";
        $result = $this->conn->prepare($update);
        $exec->beginTransaction();
        $result->execute( $data );
        $exec->commit();
        return $correcto;
    }


    public function closeOut(){
        $this->conn = null;
    }
  



}
