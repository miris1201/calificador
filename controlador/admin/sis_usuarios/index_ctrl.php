<?php

class admin_usuarios {
    public function index() {
        require_once('business/admin/sis_usuarios/index_vw.php');
    }
    public function ver() {
        require_once('business/admin/sis_usuarios/editar_vw.php');
    }
    public function nuevo() {
        require_once('business/admin/sis_usuarios/nuevo_vw.php');
    }
    public function error() {
    require_once('business/error.php');
    }
}
?>
