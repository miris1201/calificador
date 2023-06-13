
<?php
session_start();
$dir_fc = "../../../";

include_once $dir_fc.'data/tarea.class.php';
include_once $dir_fc.'common/function.class.php';

$cAccion = new cTareas();
$cFn     = new cFunction();

$id     = "";
$nombre = "";
$resp   = "";

extract($_REQUEST);

// echo $nombre. " " .$id;

$done = 1;
$rs_instruccion = $cAccion->getPublicInstruccion();
$opciones_instruccion = "";
while($rw_instruccion = $rs_instruccion->fetch(PDO::FETCH_OBJ)){
    $selected_op = "";
    if($rw_instruccion->id_instruccion == 2){
        $selected_op = "selected";
    }

    $opciones_instruccion .= "<option value='".$rw_instruccion->id_instruccion."' ".$selected_op.">".$rw_instruccion->nombre."</option>";
}

if ($id > 0 && $id != "") {
    $resp = "<tr>";
    $resp .= "<td id='asignados'>";
    $resp .= "<input name='asignado_input[]' id='asignado".$id."' type='checkbox' checked value='".$id."'>";
    $resp .= "</td><td><label for='asignado".$id."'> ".$nombre."</td><td>";
    $resp .= "<select name='instruccionid[".$id."]' id='instruccionid".$id."' class='form-control'>".$opciones_instruccion."";
    $resp .= "</select></td>";
    $resp .= "</tr>";
    
} else {
    $resp = "";
}

echo $resp;


?>