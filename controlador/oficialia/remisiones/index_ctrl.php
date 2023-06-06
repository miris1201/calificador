<?php

class cLRemision {
    public function index() {
        require_once('business/oficialia/remisiones/index_vw.php');
    }
    public function nuevo() {
        require_once('business/oficialia/remisiones/nuevo_vw.php');
    }
    public function historial() {
        require_once('business/oficialia/remisiones/historial_vw.php');
    }
    public function error() {
    require_once('business/error.php');
    }
}
?>
