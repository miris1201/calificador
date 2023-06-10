<?php


$dir_fc = "../../../../";
include_once $dir_fc.'data/remisiones.class.php';
include_once $dir_fc.'common/function.class.php';

$cAccion = new cRemision();
$cFn     = new cFunction();

$id   = "";
$descripcion = "";
$fracciones  = "";

$resp = "";
$done = 1;
$alert = "error";

extract($_REQUEST);

if(isset($id) && is_numeric($id)){

    $done = 1;
    $descripcion = $cAccion->getDataFaltas( $id );
    
    $data = $cAccion->getDataFracciones( $id );
    $fracciones = "<option></option>";
    while($rw = $data->fetch(PDO::FETCH_OBJ)){
        $fracciones .= "<option value='$rw->id_articulo_dtl'>$rw->fraccion</option>";

    }
}
   
echo json_encode(array( "done" => $done, 
                        "resp" => $resp, 
                        "alert" => $alert,
                        "descripcion" => $descripcion,
                        "fracciones" => $fracciones

                    
                    
                    ));

?>