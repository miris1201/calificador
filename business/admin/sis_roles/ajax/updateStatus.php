<?php
$dir_fc       = "../../../../";

include_once $dir_fc.'data/rol.class.php';
$cRol = new cRol();

$done   = 0;
$alert  = "error";
$resp   = "No se ha iniciado";

extract($_REQUEST);

if(isset($tipo) && isset($id)){

    $cRol->setId($id);

    $do = ( $tipo == 3 ) ? $cRol->deleteReg() : $cRol->updateStatus($tipo);

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
