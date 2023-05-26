<?php
session_start();
$dir_fc = "../../../../";

include_once $dir_fc.'data/catalogos.class.php';
include_once $dir_fc.'connections/trop.php'; 
include_once $dir_fc.'connections/php_config.php';
include_once $dir_fc.'common/function.class.php';

$cAccion  = new cCatalogos();
$cFn      = new cFunction();  

$id_usuario = 0;
$nombre      = "";
$apepa       = "";
$apema       = "";
$no_empleado = "";

$done     = 0;
$alert    = "warning";

extract($_REQUEST);

if(!is_numeric($id_usuario) || $id_usuario <= 0 
    || !is_numeric($no_empleado)
    || !is_numeric($id_zona)
    || $nombre == "" || $apepa == "" ){
    $resp = "Debes de ingresar correctamente los datos";

} else {

    $data = array($no_empleado, $id_usuario);

    $elementoCoincidencia = $cAccion->foundElementoConcidencia( $data );
    if ($elementoCoincidencia == 1){
        //Si se encuentra coincidencia quiere decir que no cambio su nombre de usuario
        $elementoFound = 0;
    }else{
        //De lo contrario buscar si existe un usuario con el mismo nombre
        $elementoFound = $cAccion->foundElemento( $nombre );
    }

    if ($elementoFound >0) {
        $resp  = "El elemento ya existe en la base de datos, favor de revisar el catálogo.";
    } else {

        $dataElemento = array(
            $id_zona, 
            $no_empleado, 
            $nombre, 
            $apepa,
            $apema,
            $id_usuario
        );

        $update = $cAccion->updateElemento( $dataElemento );
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
