<?php

class cElementos {
    public function index() {
        require_once('business/catalogos/elementos/index_vw.php');
    }
    public function nuevo() {
        require_once('business/catalogos/elementos/nuevo_vw.php');
    }
    public function error() {
    require_once('business/error.php');
    }
}
?>
