<?php
//Incluyendo la conexión a la base de datos
require_once $dir_fc."connections/conn_data.php";
class cRol extends BD {
    
    private $id;
    private $rol;
    private $id_menu;
    private $descripcion;    

    private $filtro;
    private $inicio;
    private $fin;
    private $limite;
    
    private $imprimir;
    private $nuevo;
    private $editar;
    private $eliminar;
    private $exportar;

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

    /**
     * Get the value of rol
     */ 
    public function getRol()
    {
        return $this->rol;
    }

    /**
     * Set the value of rol
     *
     * @return  self
     */ 
    public function setRol($rol)
    {
        $this->rol = $rol;

        return $this;
    }

    /**
     * Get the value of descripcion
     */ 
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Set the value of descripcion
     *
     * @return  self
     */ 
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

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

    private $conn;

    function __construct()  {
        $this->conn = new BD();
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
     * Get the value of imprimir
     */ 
    public function getImprimir()
    {
        return $this->imprimir;
    }

    /**
     * Set the value of imprimir
     *
     * @return  self
     */ 
    public function setImprimir($imprimir)
    {
        $this->imprimir = $imprimir;

        return $this;
    }

    /**
     * Get the value of nuevo
     */ 
    public function getNuevo()
    {
        return $this->nuevo;
    }

    /**
     * Set the value of nuevo
     *
     * @return  self
     */ 
    public function setNuevo($nuevo)
    {
        $this->nuevo = $nuevo;

        return $this;
    }

    /**
     * Get the value of editar
     */ 
    public function getEditar()
    {
        return $this->editar;
    }

    /**
     * Set the value of editar
     *
     * @return  self
     */ 
    public function setEditar($editar)
    {
        $this->editar = $editar;

        return $this;
    }

    /**
     * Get the value of eliminar
     */ 
    public function getEliminar()
    {
        return $this->eliminar;
    }

    /**
     * Set the value of eliminar
     *
     * @return  self
     */ 
    public function setEliminar($eliminar)
    {
        $this->eliminar = $eliminar;

        return $this;
    }

    /**
     * Get the value of exportar
     */ 
    public function getExportar()
    {
        return $this->exportar;
    }

    /**
     * Set the value of exportar
     *
     * @return  self
     */ 
    public function setExportar($exportar)
    {
        $this->exportar = $exportar;

        return $this;
    }

    public function getAllReg(){
        $milimite = "";
        $condition = "";

        if ($this->getLimite() == 1) {
            $milimite = " LIMIT " . $this->getInicio() . ", " . $this->getFin();
        }

        if ($this->getFiltro() != "") {
            $condition = " WHERE rol LIKE '%" . $this->getFiltro() . "%' ";
        }

        $query = " SELECT id, rol, descripcion, activo
                     FROM ws_rol $condition
                   ORDER BY activo desc " . $milimite;
        $result = $this->conn->prepare($query);
        $result->execute();
        return $result;

    }

    public function getAllRoles(){
        $condition = "";

        if ($_SESSION[admin] != 1) {
            $condition .= " AND id > 1 ";
        }

        $query = " SELECT id, rol, descripcion  
                     FROM ws_rol 
                    WHERE activo = 1 $condition
                   ORDER BY id ASC";
        $result = $this->conn->prepare($query);
        $result->execute();
        return $result;      
    }

    public function parentsMenu(){
        $query = "  SELECT id, id_grupo, texto, link  FROM ws_menu
                    WHERE id_grupo = 0 AND activo = 1 ORDER BY id ASC";
        $result = $this->conn->prepare($query);
        $result->execute();
        return $result;
    }

    public function childsMenu($id_menu){
        $query = "  SELECT id, id_grupo, texto, link  FROM ws_menu
                    WHERE id_grupo = $id_menu and activo = 1 ORDER BY id ASC";
        $result = $this->conn->prepare($query);
        $result->execute();
        return $result;       
    }

    public function checarRol_menu(){
        $query ="   SELECT id, imp, edit, nuevo, elim, exportar 
                      FROM ws_rol_menu 
                     WHERE id_menu = ".$this->getId_menu()." 
                        AND id_rol = ".$this->getId();
        $result = $this->conn->prepare($query);
        $result->execute();
        return $result;
    }

    public function getRolbyId(){
        $query = "  SELECT id, rol, descripcion, activo FROM ws_rol WHERE id = ".$this->getId();
        $result   = $this->conn->prepare($query);
        $result->execute();
        return $result;
        
    }

    public function updateReg(){
        $correcto   = 1;
        $exec       = $this->conn->conexion();
        $update     = " UPDATE  ws_rol 
                           SET  rol = '".$this->getRol()."', 
                                descripcion = '".$this->getDescripcion()."'
                     WHERE id = ".$this->getId();
        $result = $this->conn->prepare($update);
        $exec->beginTransaction();
        $result->execute();
        $exec->commit();
        
        return $correcto;
    }

    public function deleteRegRM(){
        $correcto   = 2;
        $delete     = "DELETE FROM ws_rol_menu WHERE id_rol = ".$this->getId();

        $result = $this->conn->prepare($delete);
        $result->execute();

        return $correcto;
    }

    public function insertReg(){
        $exec = $this->conn->conexion();
        $correcto   = 1;
        $insert     = " INSERT INTO ws_rol(rol, pag_ini, descripcion)
                        VALUES ('".$this->getRol()."', 0, '".$this->getDescripcion()."')";
        $result = $this->conn->prepare($insert);
        $exec->beginTransaction();
        $result->execute();
        if ($correcto == 1){
            $correcto= $exec->lastInsertId();
        }
        $exec->commit();
        return $correcto;        
    }

    public function insertRegdtl(){
        $exec = $this->conn->conexion();
        $correcto   = 1;
        $insert_dtl ="INSERT INTO ws_rol_menu (id_rol, id_menu, imp, edit, elim, nuevo, exportar) 
                            VALUES (".$this->getId().", ".$this->getId_menu().", ".$this->getImprimir().", 
                                    ".$this->getEditar().", ".$this->getEliminar().", ".$this->getNuevo().",
                                    ".$this->getExportar().")";

        $result = $this->conn->prepare($insert_dtl);
        $exec->beginTransaction();
        $result->execute();
        if ($correcto == 1){
            $correcto= $exec->lastInsertId();
        }
        $exec->commit();
        return $correcto;       
    }

    public function foundRol(){
        $query = " SELECT rol FROM ws_rol WHERE rol = '".$this->getRol()."'";
        $result = $this->conn->prepare($query);
        $result->execute();
        $rows = $result->rowCount();
        return $rows;
     
    }

    public function updateStatus($tipo){
        $correcto   = 1;
        $exec       = $this->conn->conexion();

        $update = " UPDATE ws_rol SET activo = $tipo
                     WHERE id = ".$this->getId();

        $result = $this->conn->prepare($update);
        $exec->beginTransaction();
        $result->execute();
        $exec->commit();
        
        return $correcto;
    }

    public function deleteReg(){
        $correcto   = 2;
        $delete     = "DELETE FROM ws_rol WHERE id = ".$this->getId();

        $result = $this->conn->prepare($delete);
        $result->execute();

        return $correcto;
      
    }
    
    public function closeOut(){
        $this->conn = null;
    }



    
}
