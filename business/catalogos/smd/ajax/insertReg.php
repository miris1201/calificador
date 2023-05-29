<?php
$dir_fc = "../../../../";

include_once $dir_fc.'data/catalogos.class.php';
include_once $dir_fc.'connections/trop.php'; 
include_once $dir_fc.'connections/php_config.php'; 

$cAccion  = new cCatalogos();

$nombre         = "";
$descripcion    = "";

$done  = 0;
$resp  = "";
$alert = "warning";

extract($_REQUEST);

if(  !is_numeric($ejercicio)
    || $salario == "" 
    ){ //Verficando datos vacios
    $resp = "Debes de ingresar correctamente los datos";

}else{    
    //buscar si existe un registro en el mismo año
    $umaFound = $cAccion->foundUMA( $ejercicio );

    if ($umaFound > 0) {
        $resp = "El ejercicio seleccionado ya existe en la base de datos, favor de revisar el catálogo.";
    } else {
        
        $data = array(
            $ejercicio, 
            $salario
        );

        $inserted = $cAccion->insertUMA( $data );

        if(is_numeric($inserted) AND $inserted > 0){
            $done  = 1;
            $resp  = "Registro agregado correctamente.";
            $alert = "success";
        
        } else {
            $done  = 0;
            $resp  = "Ocurrió un incoveniente con la base de datos: -- ".$inserted;

        }
    }
}
echo json_encode(array("done" => $done, "resp" => $resp, "alert" => $alert));

$cAccion->closeOut();
?>
