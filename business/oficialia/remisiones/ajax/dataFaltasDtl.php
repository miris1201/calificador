<?php


$dir_fc = "../../../../";
include_once $dir_fc.'data/remisiones.class.php';
include_once $dir_fc.'common/function.class.php';

$cAccion = new cRemision();
$cFn     = new cFunction();

$id   = "";
$descripcion = "";
$inputs      = "";
$dias_min    = "";
$dias_max    = "";
$hr_min      = "";
$hr_max      = "";


$resp = "";
$done = 1;
$alert = "error";

extract($_REQUEST);

if(isset($id) && is_numeric($id)){

    $done = 1;
    $data = $cAccion->getDataFaltasDtl( $id );
    while($rw = $data->fetch(PDO::FETCH_OBJ)){
        $descripcion = $rw->descripcion;
        $dias_min    = $rw->dias_min;
        $dias_max    = $rw->dias_max;
        $hr_min      = $rw->hr_min;
        $hr_max      = $rw->hr_max;

        $input_smd = "<input type='number' class='form-control' 
                        id='dias_smd' name='dias_smd'
                        min='$dias_min' max='$dias_max'>
                        <label for='dias_smd'>S/M Diarios
                        </label>
                        ";

        $input_hrs = "<input type='number' class='form-control' 
                        id='hr_arresto' name='hr_arresto'
                        min='$hr_min' max='$hr_max'>
                        <label for='hr_arresto'>Hr de arresto 
                        </label>";

    }
}
   
echo json_encode(array( "done" => $done, 
                        "resp" => $resp, 
                        "alert" => $alert,
                        "descripcion" => $descripcion,
                        "input_smd" => $input_smd,
                        "input_hrs" => $input_hrs                   
                    
                    ));

?>