<?php
require_once $dir_fc."connections/conn_data.php";
//require_once $dir_fc."connections/conn_config.php";

class cUsers extends BD
{
    private $id_usuario;
    private $id_rol;
    private $usuario;
    private $clave;
    private $id_menu;

    private $filtro;
    private $inicio;
    private $fin;
    private $limite;

    private $conn;

    function __construct()
    {
        //Esta es la que llama a la base de datos
        //parent::__construct();
        $this->conn = new BD();
    }


    /**
     * Get the value of id_usuario
     */ 
    public function getId_usuario()
    {
        return $this->id_usuario;
    }

    /**
     * Set the value of id_usuario
     *
     * @return  self
     */ 
    public function setId_usuario($id_usuario)
    {
        $this->id_usuario = $id_usuario;

        return $this;
    }

    /**
     * Get the value of id_rol
     */ 
    public function getId_rol()
    {
        return $this->id_rol;
    }

    /**
     * Set the value of id_rol
     *
     * @return  self
     */ 
    public function setId_rol($id_rol)
    {
        $this->id_rol = $id_rol;

        return $this;
    }

    /**
     * Get the value of usuario
     */ 
    public function getUsuario()
    {
        return $this->usuario;
    }

    /**
     * Set the value of usuario
     *
     * @return  self
     */ 
    public function setUsuario($usuario)
    {
        $this->usuario = $usuario;

        return $this;
    }

   

    /**
     * Get the value of nvaclave
     */ 
    public function getNvaclave()
    {
        return $this->nvaclave;
    }

    /**
     * Set the value of nvaclave
     *
     * @return  self
     */ 
    public function setNvaclave($nvaclave)
    {
        $this->nvaclave = $nvaclave;

        return $this;
    }

  

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

    /**
     * Get the value of id_menu
     */ 
    public function getId_menu()
    {
        return $this->id_menu;
    }

    /**
     * Set the value of id_menu
     *
     * @return  self
     */ 
    public function setId_menu($id_menu)
    {
        $this->id_menu = $id_menu;

        return $this;
    }


    public function getUser( $dataUser ) {
        $query = " SELECT 
                        U.id_usuario, 
                        U.id_rol,
                        U.usuario, 
                        U.nombre, 
                        U.admin,
                        CONCAT_WS(' ', U.nombre, U.apepa, U.apema) AS nombrecompleto,
                        DATE_FORMAT(U.fec_ingreso, '%d/%m/%Y') AS fecha_ingreso,
                        R.rol, 
                        M.link AS carpeta
                    FROM ws_usuario AS U 
                    LEFT JOIN ws_rol AS R ON R.id = U.id_rol
                    LEFT JOIN ws_menu AS M ON U.id_carpeta = M.id_menu
                   WHERE usuario = ?
                     AND clave = ?
                     AND U.activo = 1
                   LIMIT 1";
        $result = $this->conn->prepare($query);
        
        $result->execute($dataUser);
        
        return $result;       
    }

    
    public function getAllReg( $rol ){
        //Inicio fin son para paginado
        $milimite  = "";
        $condition = "";

        if ($this->getLimite() == 1){ $milimite = "LIMIT ".$this->getInicio().", ".$this->getFin();}
        $filtro = $this->getFiltro();

        if ($filtro != ""){
            $condition = " AND CONCAT_WS(' ', U.nombre, U.apepa, U.apema) LIKE '%".$filtro."%' 
                            OR usuario LIKE '%".$filtro."%' ";
        }

        $condNoSuper = ( $rol > 1 ) ? ' AND U.id_rol > 1 ' : '';

        $query  = " SELECT id_usuario, 
                           usuario, 
                           CONCAT_WS(' ', U.nombre, U.apepa, U.apema) AS nombre,
                           U.activo,
                           U.id_zona, 
                           U.admin
                      FROM ws_usuario as U 
                     WHERE id_rol <= 2 $condition $condNoSuper               
                    ORDER BY id_usuario DESC ".$milimite;
        $result = $this->conn->prepare($query);
        $result->execute();
        return $result;
    }

    public function getRegbyid(){
        $query = "  SELECT id_usuario, id_rol, id_zona, usuario,  
                            nombre, apepa, apema, admin, activo
                     FROM ws_usuario 
                    WHERE id_usuario = ".$this->getId_usuario() ."
                    LIMIT 1";
        $result = $this->conn->prepare($query);
        $result->execute();
        return $result;
    }

    public function checarMenuUser(){
        $query = " SELECT id_usuario_menu, imp, edit, elim, nuevo, exportar
                      FROM ws_usuario_menu 
                     WHERE id_menu = " . $this->getId_menu() . "
                       AND id_usuario = " . $this->getId_usuario();
        $result = $this->conn->prepare($query);
        $result->execute();

        return $result;
    }

    public function getCatTurno(){
        $query = "  SELECT id_turno, descripcion, activo
                     FROM cat_turno 
                     WHERE activo = 1 
                     ORDER BY id_turno ASC";
        $result = $this->conn->prepare($query);
        $result->execute();
        return $result;
    }

    
    public function foundUserConcidencia( $data ){
        //Busca si existe un usuario con el nombre
        $query = " SELECT usuario 
                     FROM ws_usuario 
                    WHERE usuario = ? AND id_usuario = ? ";
        $result    = $this->conn->prepare($query);
        $result->execute( $data);
        $registrosf = $result->rowCount();
        return $registrosf;
    }
    
    public function foundUser( $usuario ){
        $query = "SELECT usuario FROM ws_usuario WHERE usuario = '$usuario'";
        $result = $this->conn->prepare($query);
        $result->execute();
        $registrosf = $result->rowCount();
        return $registrosf;
    }

    public function updateReg( $dataU ){
        $correcto   = 1;
        $exec       = $this->conn->conexion();
        $update = " UPDATE ws_usuario
                       SET id_rol        = ?,
                           id_zona       = ?, 
                           usuario       = ?,
                           nombre        = ?,
                           apepa         = ?,
                           apema         = ?,
                           admin         = ?
                     WHERE id_usuario    = ?";
        $result = $this->conn->prepare($update);
        $exec->beginTransaction();
        $result->execute( $dataU);
        $exec->commit();
        return $correcto;
    }

    public function insertRegdtluser( $dataDtl ){

        $exec = $this->conn->conexion();
        $correcto   = 1;

        $insert_dtl = " INSERT INTO ws_usuario_menu(
                                    id_usuario, 
                                    id_menu, 
                                    imp,
                                    edit,
                                    elim,
                                    nuevo,
                                    exportar) 
                    VALUES ( ?,
                             ?,
                             ?,
                             ?,
                             ?,
                             ?,
                             ?)";
        $result = $this->conn->prepare($insert_dtl);
        $exec->beginTransaction();
        $result->execute( $dataDtl );
        if ($correcto == 1) {
            $correcto = $exec->lastInsertId();
        }
        $exec->commit();
        return $correcto;
    }

    public function deleteRegUsMenu(){
        $correcto   = 2;
        $delete     = "DELETE FROM ws_usuario_menu WHERE id_usuario = ".$this->getId_usuario();

        $result = $this->conn->prepare($delete);
        $result->execute();
        return $correcto;
    }

    public function insertReg($data ){

        $correcto= 1;
        $exec = $this->conn->conexion();

        $insert = " INSERT INTO ws_usuario(id_rol, 
                                           id_zona,
                                           fec_ingreso, 
                                           usuario, 
                                           clave,  
                                           nombre, 
                                           apepa, 
                                           apema, 
                                           admin)
                                    VALUES (?,
                                           ?,
                                           ?,
                                           ?,
                                           ?,
                                           ?,
                                           ?,
                                           ?,
                                           ?)";
        $result = $this->conn->prepare($insert);
        $exec->beginTransaction();
        $result->execute( $data );
        if ($correcto == 1) {
            $correcto = $exec->lastInsertId();
        }
        $exec->commit();
        return $correcto;
    }
    
    public function insertRegdtlByRol( $id_usuario, $id_profile ){
        $exec = $this->conn->conexion();
        
        try {
            $correcto   = 1;
            $insert_dtl ="INSERT INTO ws_usuario_menu(
                                    id_usuario, 
                                    id_menu, 
                                    imp,
                                    edit,
                                    elim,
                                    nuevo,
                                    exportar) 
                               SELECT 
                                    '$id_usuario', 
                                    id_menu, 
                                    imp,
                                    edit,
                                    elim,
                                    nuevo,
                                    exportar 
                                 FROM ws_rol_menu 
                                 WHERE id_rol = ".$id_profile;

            $result = $this->conn->prepare($insert_dtl);
            $exec->beginTransaction();
            $result->execute();
            
            $exec->commit();
            return $correcto;
        }
        catch (\PDOException $e){
            return "Error!: " . $e->getMessage();
        }

    }
    
    public function insertRegUser( $dataUser ){

        $correcto= 1;
        $exec = $this->conn->conexion();

        $insert = " INSERT INTO ws_usuario(
                                    id_rol,
                                    id_colonia,
                                    created_at,
                                    usuario,
                                    clave,
                                    nombre,
                                    apepa,
                                    apema,
                                    correo,
                                    domicillio,
                                    telefono,
                                    tel_movil,
                                    fec_ingreso,
                                    imp,
                                    edit,
                                    elim,
                                    nuev,
                                    img
                                    )
                                    VALUES (
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
                                    ?,
                                    ?,
                                    ?,
                                    ?,
                                    ?,
                                    ?,
                                    ?
                                    )";
        $result = $this->conn->prepare($insert);
        $exec->beginTransaction();

        $result->execute( $dataUser );

        if ($correcto == 1) {
            $correcto = $exec->lastInsertId();
        }
        $exec->commit();
        return $correcto;

    }

    public function updateStatus($tipo){
        $correcto   = 1;        
        $update = " UPDATE ws_usuario 
                       SET activo = $tipo
                     WHERE id_usuario = ".$this->getId_usuario();
        $result = $this->conn->prepare($update);
        $result->execute();
        $result = null;
        $this->conn = null;
        return $correcto;

    }

    public function deleteReg(){
        $correcto   = 2;
        
        $delete = "DELETE FROM ws_usuario WHERE id_usuario = ".$this->getId_usuario();        
        $result = $this->conn->prepare($delete);
        $result->execute();
        $result = null;
        $this->conn = null;
        return $correcto;
    }

    public function getRegbyPW(){
        $query  = " SELECT id_usuario, usuario FROM ws_usuario
                     WHERE id_usuario = ".$this->getId_usuario()." 
                    AND clave = '".$this->getClave()."' LIMIT 1";
        $result = $this->conn->prepare($query);
        $result->execute();
        $registrosf = $result->rowCount();
        return $registrosf;
    }

    public function updateRegPW(){
        $correcto   = 1;

        $exec = $this->conn->conexion();

        $update = " UPDATE ws_usuario
                       SET clave = '".$this->getNvaclave()."'
                     WHERE id_usuario = ".$this->getId_usuario();
        // echo $update;
        $result = $this->conn->prepare($update);
        $exec->beginTransaction();
        $result->execute();
        $exec->commit();

        $result = null;
        $exec = null;

        return $correcto;
    }

    public function getUserLock(){
        $query = "  SELECT id_usuario, id_rol, usuario, nombre,
                            CONCAT_WS(' ', nombre, apepa, apema) AS nombrecompleto, correo,
                            DATE_FORMAT(fec_ingreso, '%d/%m/%Y' ) AS fecha_ingreso
                    FROM ws_usuario 
                    where id_usuario = ".$this->getId_usuario()." and clave = '".$this->getClave()."'
                    AND activo = 1";
        $result = $this->conn->prepare($query);
        $result->execute();
        return $result;
    }

    public function updateRegacount(){
        $correcto   = 1;
        $exec       = $this->conn->conexion();

        $update = " UPDATE ws_usuario
                       SET nombre   = '".$this->getNombre()."', 
                           apepa    = '".$this->getApepa()."',
                           apema    = '".$this->getApema()."',
                           usuario  = '" . $this->getUsuario() . "'
                     WHERE id_usuario = " . $this->getId_usuario();
        $result = $this->conn->prepare($update);
        $exec->beginTransaction();
        $result->execute();
        $exec->commit();
        return $correcto;
    }
 
    public function closeOut(){
        $this->conn = null;
    }  

 
}
?>