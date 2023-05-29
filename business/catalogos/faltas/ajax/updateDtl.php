<?php
session_start();
$dir_fc = "../../../../";

include_once $dir_fc.'data/catalogos.class.php';
include_once $dir_fc.'connections/trop.php'; 
include_once $dir_fc.'connections/php_config.php';
include_once $dir_fc.'common/function.class.php';

$cAccion  = new cCatalogos();
$cFn      = new cFunction();  

$id          = 0;
$fraccion    = "";
$descripcion = "";
$hr_min      = "";
$hr_max      = "";

$done     = 0;
$alert    = "warning";

extract($_REQUEST);

if(!is_numeric($id) || $id <= 0 
    || !is_numeric($hr_min)
    || !is_numeric($hr_min)
    || $fraccion == "" || $descripcion == "" ){
    $resp = "Debes de ingresar correctamente los datos";

} else {

    $data = array($fraccion, $id);

    $fraccionCoincidencia = $cAccion->foundFraccionConcidencia( $data );
    if ($fraccionCoincidencia == 1){
        //Si se encuentra coincidencia quiere decir que no cambio su nombre de usuario
        $fraccionFound = 0;
    }else{
        //De lo contrario buscar si existe un usuario con el mismo nombre
        $fraccionFound = $cAccion->foundFraccion( $fraccion );
    }

    if ($fraccionFound >0) {
        $resp  = "El registro ya existe en la base de datos, favor de revisar el catálogo.";
    } else {

        $dataFraccion = array(
            $fraccion, 
            $descripcion, 
            $hr_min, 
            $hr_max,
            $id
        );

        $update = $cAccion->updateFraccion( $dataFraccion );
        if(is_numeric($update) AND $update > 0){
            

            $done  = 1;
            $resp  = "Fracción actualizad correctamente.";
            $alert = "success";
        }else{
            $done  = 0;
            $resp  = "Ocurrió un incoveniente con la base de datos: -- ".$inserted;
        }
    }
}

echo json_encode(array("done" => $done, "resp" => $resp, "alert" => $alert));
?>
