<?php
session_start();
$dir_fc = "../../../../";

include_once $dir_fc.'data/users.class.php';
include_once $dir_fc.'connections/trop.php'; 
include_once $dir_fc.'connections/php_config.php'; 

$cAccion  = new cUsers();

$done     = 0;
$alert    = "warning";

extract($_REQUEST);

$direcciones = $cAccion->getRegDirecciones();

if(!is_string($direcciones)){
    $done  = 1;
    $alert = "success";
}

echo json_encode(
    array(
        "done" => $done, 
        "alert" => $alert, 
        "direcciones" => $direcciones
    )
);
?>
