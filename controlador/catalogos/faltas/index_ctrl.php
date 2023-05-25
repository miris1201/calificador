<?php

class cFaltas {
    public function index() {
        require_once('business/catalogos/faltas/index_vw.php');
    }
    public function nuevo() {
        require_once('business/catalogos/faltas/nuevo_vw.php');
    }
    public function error() {
    require_once('business/error.php');
    }
}
?>
