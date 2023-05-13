<?php
function call($controller, $action) {
    require_once($controller . '/index_ctrl.php');
    switch($controller) {
        case 'controlador':
            $controller = new Inicio();
            break;
        case 'controlador/business':
            $controller = new Business();
            break;
        case 'controlador/sys':
            $controller = new Sys();
            break;
        case 'controlador/admin/sis_usuarios':
            $controller = new admin_usuarios();
            break;
        case 'controlador/admin/sis_roles':
            $controller = new admin_roles();
            break;
    }
    $controller->{ $action }();
}

$controllers = array(
    'controlador'                         => ['index'],
    'controlador/business'                => ['show'],
    'controlador/sys'                     => ['account', 'add_account'],
    'controlador/admin/sis_usuarios'      => ['ver', 'index', 'nuevo'],
    'controlador/admin/sis_roles' 	      => ['ver', 'index', 'nuevo'],
);

if (array_key_exists($controller, $controllers)) {

    if (in_array($action, $controllers[$controller])) {
        call($controller, $action);
    } else {
        call('business/', 'error');
    }
} else {
    call('business/', 'error');
}
