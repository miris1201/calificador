<?php

class admin_roles {
    public function index() {
        require_once('business/admin/sis_roles/index_vw.php');
    }
    public function ver() {
        require_once('business/admin/sis_roles/editar_vw.php');
    }
    public function nuevo() {
        require_once('business/admin/sis_roles/nuevo_vw.php');
    }
    public function error() {
    require_once('business/error.php');
    }
}
?>
