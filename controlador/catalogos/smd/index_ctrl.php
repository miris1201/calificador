<?php

class cUMA {
    public function index() {
        require_once('business/catalogos/smd/index_vw.php');
    }
    public function nuevo() {
        require_once('business/catalogos/smd/nuevo_vw.php');
    }
    public function error() {
    require_once('business/error.php');
    }
}
?>
