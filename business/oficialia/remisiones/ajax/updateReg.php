<?php
session_start();
$dir_fc = "../../../../";

include_once $dir_fc.'data/catalogos.class.php';
include_once $dir_fc.'connections/trop.php'; 
include_once $dir_fc.'connections/php_config.php';
include_once $dir_fc.'common/function.class.php';

$cAccion  = new cCatalogos();
$cFn      = new cFunction();  

$id_smd = 0;
$ejercicio = "";
$salario   = "";

$done     = 0;
$alert    = "warning";

extract($_REQUEST);

if(!is_numeric($id_smd) || $id_smd <= 0 
    || !is_numeric($ejercicio)
    || $salario == "" ){
    $resp = "Debes de ingresar correctamente los datos";

} else {

    $data = array($ejercicio, $id_smd);

    $umaCoincidencia = $cAccion->foundUMAConcidencia( $data );
    if ($umaCoincidencia == 1){
        //Si se encuentra coincidencia quiere decir que no cambio el año o ejercicio
        $umaFound = 0;
    }else{
        //De lo contrario buscar si existe un registro con el mismo ejercicio
        $umaFound = $cAccion->foundUMA( $ejercicio );
    }

    if ($umaFound > 0) {
        $resp  = "El registro ya existe en la base de datos, favor de revisar el catálogo.";
        
    } else {

        $dataUMA = array(
            $ejercicio, 
            $salario, 
            $id_smd
        );

        $update = $cAccion->updateUMA( $dataUMA );
        if(is_numeric($update) AND $update > 0){
            $done  = 1;
            $resp  = "Registro actualizado correctamente.";
            $alert = "success";

        }else{
            $done  = 0;
            $resp  = "Ocurrió un incoveniente con la base de datos: -- ".$inserted;

        }
    }
}

echo json_encode(array("done" => $done, "resp" => $resp, "alert" => $alert));
?>
