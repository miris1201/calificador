<?php

$dir_fc  = "../../../../";

include_once $dir_fc.'data/catalogos.class.php';
$cAccion = new cCatalogos();


$done   = 0;
$alert  = "error";
$resp   = "No se ha iniciado";

extract($_REQUEST);

if(isset($tipo) && isset($id)){

    $cAccion->setId($id);

    $do = ($tipo == 3) ? $cAccion->deleteReg('tbl_smd', 'id_smd') : $cAccion->updateStatus('tbl_smd', 'id_smd', $tipo);

    if(is_numeric($do)){
        $done  = 1;
        $alert = "success";
        $resp  = "Registro actualizado correctamente";
    }else{
        $resp  = "Ocurrió un inconveniente ". $do;
    }

} else {
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
