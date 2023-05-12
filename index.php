<?php
if(isset($_GET['controller']) && isset($_GET['action'])) {
    $controller = 'controlador/'.$_GET['controller'];
    $action     = $_GET['action'];
} else {
    $controller = 'controlador';
    $action     = 'index';
}
require_once('start/routes.php');
?>