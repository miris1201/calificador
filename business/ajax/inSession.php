<?php
session_start();

$dir_fc = "../../";
include_once $dir_fc.'connections/php_config.php';
include_once $dir_fc.'data/business.class.php';

$cAccion = new cBusiness();

$id_turno      = "";
$id_juez       = "";
$id_secretario = "";
$dataDetail    = "";

$resp = "";
$done = 0;
$alert = "error";

extract($_REQUEST);

if(isset($id_turno) && is_numeric($id_turno)
    || isset($id_juez) && is_numeric($id_juez)
    || isset($id_secretario) && is_numeric($id_secretario)
    ){

    $done = 1;

    $_SESSION[id_turno] = $id_turno;
    $_SESSION[id_juez]  = $id_juez;
    $_SESSION[id_secretario] = $id_secretario;

    

} else {
    $resp = "Debes seleccionar correctamente.";
}
   
echo json_encode(array( "done" => $done, 
                        "resp" => $resp, 
                        "alert" => $alert,
                        "dataD" => $dataDetail));

?>