<?php
$dir_fc       = "../../../../";

include_once $dir_fc.'data/users.class.php';
$cUsers = new cUsers();

$done   = 0;
$alert  = "error";
$resp   = "No se ha iniciado";

extract($_REQUEST);

if(isset($tipo) && isset($id)){

    $cUsers->setId_usuario($id);

    $do = ( $tipo == 3 ) ? $cUsers->deleteReg() : $cUsers->updateStatus($tipo);

    if(is_numeric($do)){
        $done  = 1;
        $alert = "success";
        $resp  = "Registro actualizado correctamente";
    }else{
        $resp  = "Ocurrió un inconveniente ". $do;
    }

}else{
    $resp = "No se recibieron los parámetros adecuadamente";
}
echo json_encode(
    array(
        "done" => $done, 
        "alert" => $alert,
        "resp" => $resp
    )
);
?>
