<?php
session_start();
$dir_fc = "../../../../";

include_once $dir_fc.'data/catalogos.class.php';
include_once $dir_fc.'connections/trop.php'; 
include_once $dir_fc.'connections/php_config.php';
include_once $dir_fc.'common/function.class.php';

$cAccion  = new cCatalogos();
$cFn      = new cFunction();  

$id_articulo = 0;
$articulo    = "";
$descripcion = "";

$edit   = 0;
$done   = 0;
$alert  = "warning";

extract($_REQUEST);

if(!is_numeric($id_articulo) || $id_articulo <= 0 
    || $articulo == "" || $descripcion == "" ){
    $resp = "Debes de ingresar correctamente los datos";

} else {

    $data = array($articulo, $id_articulo);

    $falaCoincidencia = $cAccion->foundFaltaConcidencia( $data );
    if ($falaCoincidencia == 1){
        //Si se encuentra coincidencia quiere decir que no cambio su nombre de usuario
        $falaFound = 0;
    }else{
        //De lo contrario buscar si existe un usuario con el mismo nombre
        $falaFound = $cAccion->foundFalta( $articulo );
    }

    if ($falaFound >0) {
        $resp  = "El artículo ya existe en la base de datos, favor de revisar el catálogo.";
    } else {

        $dataFalta = array(
            $articulo, 
            $descripcion,
            $id_articulo
        );

        $update = $cAccion->updateFalta( $dataFalta );
        if(is_numeric($update) AND $update > 0){
            
            $done  = 1;
            $resp  = "Registro actualizado correctamente.";
            $alert = "success";

            if ($fraccion != "") {
                if(!is_numeric($h_min) || !is_numeric($h_max)
                || $descripcion_f == "") {
                    $resp .= "Debes de ingresar correctamente los datos";
                } else {

                    $dataFaltaDtl = array(
                        $id_articulo,
                        $fraccion, 
                        $descripcion_f,
                        $h_min,
                        $h_max                        
                    );

                    $inserted_Dtl = $cAccion->insertFraccion( $dataFaltaDtl );
                    if(is_numeric($inserted_Dtl) AND $inserted_Dtl > 0){     
                        $edit  = 1;
                        $resp  .= " (Fracción agregada).";

                    } else {                        
                        $resp  .= " (Error al agregar la fracción).";
                    
                    }
                }
            }
           
        }else{
            $done  = 0;
            $resp  = "Ocurrió un incoveniente con la base de datos: -- ".$inserted;
        }
    }
}

echo json_encode(array( "done" => $done, 
                        "resp" => $resp, 
                        "edit" => $edit,
                        "alert" => $alert));
?>
