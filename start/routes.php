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
        case 'controlador/catalogos/elementos':
                $controller = new cElementos();
            break;
        case 'controlador/catalogos/faltas':
                $controller = new cFaltas();
            break;
        case 'controlador/catalogos/uma':
                $controller = new cUMA();
            break;
    }
    $controller->{ $action }();
}

$controllers = array(
    'controlador'                     => ['index'],
    'controlador/business'            => ['show'],
    'controlador/sys'                 => ['account', 'add_account'],
    'controlador/admin/sis_usuarios'  => ['index', 'nuevo'],
    'controlador/admin/sis_roles' 	  => ['index', 'nuevo'],
    'controlador/catalogos/elementos' => ['index', 'nuevo'],
    'controlador/catalogos/faltas'    => ['index', 'nuevo'],
    'controlador/catalogos/uma'       => ['index', 'nuevo'],
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
