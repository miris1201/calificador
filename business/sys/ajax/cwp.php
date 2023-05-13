<?php
$dir_fc = "../../../";
session_start();

include_once $dir_fc.'data/users.class.php';
include_once $dir_fc.'connections/trop.php'; 
include_once $dir_fc.'connections/php_config.php'; 

$cAccion    = new cUsers();

$nuevaclave = "";
$confclave  = "";

$done = 0;
$resp = "";
$alert = "warning";

extract($_REQUEST);

$cAccion->setId_usuario($_SESSION[id_usr]);
$cAccion->setClave(md5($clave));
$rows   = $cAccion->getRegbyPW();

if($rows == 1){
    if($nuevaclave == $confclave){
        $date = date('Y-m-d H:i:s');


        $cAccion->setNvaclave(md5($nuevaclave));
        $msg = $cAccion->updateRegPW($date);

        if(is_numeric($msg)){
            $done  = 1;
            $resp  = "Tu contraseña ah sido actualizada correctamente. Reinicia tu sesión.";
            $alert = "success";
        } 

    } else {
        $resp = "Confirmación de contraseña no coincide";

    }

} else {
    $resp = "Contraseña actual incorrecta";

}

echo json_encode(array("done" => $done, "resp" => $resp, "alert" => $alert));
?>
