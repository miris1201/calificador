<?php
$dir_fc = "../../../../";

include_once $dir_fc.'data/catalogos.class.php';
include_once $dir_fc.'connections/trop.php'; 
include_once $dir_fc.'connections/php_config.php'; 

$cAccion  = new cCatalogos();

$id_articulo = 0;
$articulo    = "";
$descripcion = "";

$edit   = 0;
$done   = 0;
$alert  = "warning";

extract($_REQUEST);

if( $articulo == "" || $descripcion == "" ){
    $resp = "Debes de ingresar correctamente los datos";

} else {
    
    //buscar si existe un falta con el mismo nombre
    $faltaFound = $cAccion->foundFalta( $articulo );

    if ($faltaFound > 0) {
        $resp = "La falta seleccionada ya existe en la base de datos, favor de revisar el catálogo.";
    } else {
        
        $data = array(
            $articulo,
            $descripcion
        );

        $inserted = $cAccion->insertFalta( $data );

        if(is_numeric($inserted) AND $inserted > 0){

            $done  = 1;
            $resp  = "Registro agregado correctamente.";
            $alert = "success";

            if ($fraccion != "") {
                if(!is_numeric($h_min) || !is_numeric($h_max)
                || $descripcion_f == "") {
                    $resp .= "Debes de ingresar correctamente los datos";
                } else {

                    $dataFaltaDtl = array(
                        $inserted,
                        $fraccion, 
                        $descripcion_f,
                        $h_min,
                        $h_max                        
                    );

                    $inserted_Dtl = $cAccion->insertFraccion( $dataFaltaDtl );
                    if(is_numeric($inserted_Dtl) AND $inserted_Dtl > 0){     
                        $resp  .= " (Fracción agregada).";

                    } else {                        
                        $resp  .= " (Error al agregar la fracción).";
                    
                    }
                }
            }
        
        } else {
            $done  = 0;
            $resp  = "Ocurrió un incoveniente con la base de datos: -- ".$inserted;
        }
    }
}
echo json_encode(array("done" => $done, "resp" => $resp, "alert" => $alert));

$cAccion->closeOut();
?>
