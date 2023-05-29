<?php
require_once $dir_fc."connections/conn_data.php";

class cCatalogos extends BD  {

    private $conn;

    function __construct()
    {
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

    private $id;

      /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    public function getAllFaltas(){
        //Incio fin son para paginado
        $milimite = "";
        $condition = "";
        if ($this->getLimite() == 1){ $milimite = "LIMIT ".$this->getInicio().", ".$this->getFin();}

        $filtro = $this->getFiltro();

        if ($filtro != ""){
            $condition = " WHERE descripcion LIKE '%$filtro%'  ";
        }

        $query = "  SELECT id_articulo, articulo, descripcion, activo
                      FROM cat_articulos $condition 
                    ORDER BY id_articulo DESC ".$milimite;
        $result = $this->conn->prepare($query);
        $result->execute();
        return $result;
    }

    public function getFaltabyid( $id ){
        $query = "  SELECT  id_articulo, articulo, descripcion, activo
                    FROM cat_articulos 
                    WHERE id_articulo = $id LIMIT 1";
        $result = $this->conn->prepare($query);
        $result->execute();
        return $result;
    }

    public function getFaltaDtlbyid( $id_dtl ){
        $query = "  SELECT id_articulo_dtl, id_articulo, fraccion, descripcion, hr_min, hr_max, activo
                    FROM cat_articulos_dtl 
                    WHERE id_articulo = $id_dtl";
        $result = $this->conn->prepare($query);
        $result->execute();
        return $result;
    }

    public function foundFalta( $giro ){
        //Busca si existe un articulo con el nombre
        $query= "SELECT articulo FROM cat_articulos WHERE articulo = '$giro'";
        $result = $this->conn->prepare($query);
        $result->execute();
        $registrosf = $result->rowCount();
        return $registrosf;
    }

    public function insertFalta( $data ){
        $correcto= 1;
        $exec = $this->conn->conexion();

        $insert = "INSERT INTO cat_articulos(articulo, descripcion)
                    VALUES (    ?, 
                                ?)";

        $result = $this->conn->prepare($insert);
        $exec->beginTransaction();
        $result->execute($data);
        if ($correcto == 1){
            $correcto= $exec->lastInsertId();
        }
        $exec->commit();
        return $correcto;
    }

   
    public function foundFaltaConcidencia( $data ){
        //Busca si existe un giro con el nombre
        $query= "   SELECT articulo FROM cat_articulos WHERE articulo = ? AND id_articulo = ? ";
        $result = $this->conn->prepare($query);
        $result->execute( $data );
        $registrosf = $result->rowCount();
        return $registrosf;
    }

    public function updateFalta( $data ){
        $correcto   = 1;
        $exec       = $this->conn->conexion();
        
        $update = " UPDATE cat_articulos
                      SET  articulo   = ?,
                           descripcion = ?
                     WHERE id_articulo = ?";
        $result = $this->conn->prepare($update);
        $exec->beginTransaction();
        $result->execute( $data );
        $exec->commit();
        return $correcto;
    }

    public function foundFraccionConcidencia( $data ){
        //Busca si existe un giro con el nombre
        $query= "   SELECT fraccion FROM cat_articulos_dtl WHERE fraccion = ? AND id_articulo_dtl = ? ";
        $result = $this->conn->prepare($query);
        $result->execute( $data );
        $registrosf = $result->rowCount();
        return $registrosf;
    }

    public function foundFraccion( $fraccion ){
        //Busca si existe un giro con el nombre
        $query= "SELECT fraccion FROM cat_articulos_dtl WHERE fraccion = '$fraccion'";
        $result = $this->conn->prepare($query);
        $result->execute();
        $registrosf = $result->rowCount();
        return $registrosf;
    }

    public function insertFraccion( $data ){
        $correcto= 1;
        $exec = $this->conn->conexion();

        $insert = "INSERT INTO cat_articulos_dtl(id_articulo, fraccion, descripcion, hr_min, hr_max)
                    VALUES (    ?, 
                                ?,
                                ?,
                                ?,
                                ?)";
        $result = $this->conn->prepare($insert);
        $exec->beginTransaction();
        $result->execute($data);
        if ($correcto == 1){
            $correcto= $exec->lastInsertId();
        }
        $exec->commit();
        return $correcto;
    }



    public function updateFraccion( $data ){
        $correcto   = 1;
        $exec       = $this->conn->conexion();
        
        $update = " UPDATE cat_articulos_dtl
                      SET  fraccion    = ?,
                           descripcion = ?,
                           hr_min      = ?,
                           hr_max    = ?
                     WHERE id_articulo_dtl = ?";
        $result = $this->conn->prepare($update);
        $exec->beginTransaction();
        $result->execute( $data );
        $exec->commit();
        return $correcto;
    }

    public function getAllElementos(){
        //Incio fin son para paginado
        $milimite = "";
        $condition = "";
        if ($this->getLimite() == 1){ $milimite = "LIMIT ".$this->getInicio().", ".$this->getFin();}

        $filtro = $this->getFiltro();

        if ($filtro != ""){
            $condition = " AND CONCAT_WS(' ', nombre, apepa, apema) LIKE '%".$filtro."%' 
                            OR no_empleado LIKE '%".$filtro."%' ";
        }

        $query = "  SELECT id_usuario, id_zona, CONCAT_WS(' ', nombre, apepa, apema) AS nombre,
                            no_empleado, activo
                      FROM ws_usuario 
                      WHERE id_rol = 5 $condition 
                    ORDER BY id_zona ASC, no_empleado ASC ".$milimite;

        $result = $this->conn->prepare($query);
        $result->execute();
        return $result;
    }

    public function getElementobyid( $id ){
        $query = "  SELECT id_usuario, id_zona, no_empleado, nombre, apepa, apema, activo
                    FROM ws_usuario 
                    WHERE id_usuario = $id LIMIT 1";
        $result = $this->conn->prepare($query);
        $result->execute();
        return $result;
    }

    public function foundElemento( $no_empleado ){
        //Busca si existe un giro con el nombre
        $query= "SELECT no_empleado FROM ws_usuario WHERE no_empleado = '$no_empleado'";
        $result = $this->conn->prepare($query);
        $result->execute();
        $registrosf = $result->rowCount();
        return $registrosf;
    }

    public function insertElemento( $data ){
        $correcto= 1;
        $exec = $this->conn->conexion();

        $insert = "INSERT INTO ws_usuario(id_rol, id_zona, fec_ingreso, no_empleado, nombre, apepa, apema)
                    VALUES (    ?, 
                                ?,
                                ?,
                                ?,
                                ?,
                                ?,
                                ?)";

        $result = $this->conn->prepare($insert);
        $exec->beginTransaction();
        $result->execute($data);
        if ($correcto == 1){
            $correcto= $exec->lastInsertId();
        }
        $exec->commit();
        return $correcto;
    }

    public function foundElementoConcidencia( $data ){
        //Busca si existe un elemento con el nombre
        $query= "   SELECT no_empleado FROM ws_usuario WHERE no_empleado = ? AND id_usuario = ? ";
        $result = $this->conn->prepare($query);
        $result->execute( $data );
        $registrosf = $result->rowCount();
        return $registrosf;
    }

    public function updateElemento( $data ){
        $correcto   = 1;
        $exec       = $this->conn->conexion();
        
        $update = " UPDATE ws_usuario
                      SET  id_zona  = ?, 
                           no_empleado = ?,
                           nombre   = ?,
                           apepa    = ?,
                           apema    = ?
                     WHERE id_usuario = ?";
        $result = $this->conn->prepare($update);
        $exec->beginTransaction();
        $result->execute( $data );
        $exec->commit();
        return $correcto;
    }


    public function getAllUMA(){
        //Incio fin son para paginado
        $milimite = "";
        $condition = "";
        if ($this->getLimite() == 1){ $milimite = "LIMIT ".$this->getInicio().", ".$this->getFin();}

        if ($this->getFiltro() != ""){
            $condition = " WHERE ejercicio = ".$this->getFiltro()." ";
        }

        $query = "  SELECT id_smd, ejercicio, salario, activo
                      FROM tbl_smd 
                     $condition 
                    ORDER BY ejercicio DESC ".$milimite;
        $result = $this->conn->prepare($query);
        $result->execute();
        return $result;
    }

    public function getUMAbyid( $id ){
        $query = "  SELECT id_smd, ejercicio, salario, activo
                      FROM tbl_smd 
                     WHERE id_smd = $id LIMIT 1";
        $result = $this->conn->prepare($query);
        $result->execute();
        return $result;
    }

    public function foundUMA( $ejercicio ){
        //Busca si existe un uma con el nombre
        $query= "SELECT ejercicio FROM tbl_smd WHERE ejercicio = '$ejercicio'";
        $result = $this->conn->prepare($query);
        $result->execute();
        $registrosf = $result->rowCount();
        return $registrosf;
    }

    public function insertUMA( $data ){
        $correcto= 1;
        $exec = $this->conn->conexion();

        $insert = "INSERT INTO tbl_smd( ejercicio, salario )
                    VALUES (  ?, 
                              ?)";

        $result = $this->conn->prepare($insert);
        $exec->beginTransaction();
        $result->execute($data);
        if ($correcto == 1){
            $correcto= $exec->lastInsertId();
        }
        $exec->commit();
        return $correcto;
    }

    public function foundUMAConcidencia( $data ){
        //Busca si existe un registro con el nombre
        $query= "   SELECT ejercicio FROM tbl_smd WHERE ejercicio = ? AND id_smd = ? ";
        $result = $this->conn->prepare($query);
        $result->execute( $data );
        $registrosf = $result->rowCount();
        return $registrosf;
    }

    public function updateUMA( $data ){
        $correcto   = 1;
        $exec       = $this->conn->conexion();
        
        $update = " UPDATE tbl_smd
                      SET  ejercicio = ?,
                           salario   = ?
                     WHERE id_smd    = ?";
        $result = $this->conn->prepare($update);
        $exec->beginTransaction();
        $result->execute( $data );
        $exec->commit();
        return $correcto;
    }


    public function deleteReg($table, $campo){
        $correcto   = 2;
        
        $delete = "DELETE FROM $table WHERE $campo = ".$this->getId();        
        $result = $this->conn->prepare($delete);
        $result->execute();
        $result = null;
        $this->conn = null;
        return $correcto;
    }

    public function updateStatus($table, $campo, $tipo){
        $correcto   = 1;        
        $update = " UPDATE $table
                       SET activo = $tipo
                     WHERE $campo = ".$this->getId();
        $result = $this->conn->prepare($update);
        $result->execute();
        $result = null;
        $this->conn = null;
        return $correcto;
    }

    
    public function closeOut(){
        $this->conn = null;
    } 



  
}

    

?>