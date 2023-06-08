<?php


$dir_fc = "../../../../";
include_once $dir_fc.'data/remisiones.class.php';
include_once $dir_fc.'common/function.class.php';

$cAccion = new cRemision();
$cFn     = new cFunction();

$id_colonia   = "";
$resp = "";

extract($_REQUEST);

if(isset($id_colonia) && is_numeric($id_colonia)){
    $sector = $cAccion->getSectorByColonia( $id_colonia );
    
}
   
echo $sector;

?>