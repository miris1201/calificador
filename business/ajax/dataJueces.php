<?php


$dir_fc = "../../";
include_once $dir_fc.'data/business.class.php';
include_once $dir_fc.'common/function.class.php';

$cAccion = new cBusiness();

$id_turno      = "";
$id_juez       = "";
$id_secretario = "";

$resp = "";
$done = 0;
$alert = "error";

extract($_REQUEST);

if(isset($id) && is_numeric($id)){

    $done = 1;
    
    $dataJ = $cAccion->getDataJuez();
    $jueces = "<option></option>";
    $secretario = "<option></option>";
    while($rwJ = $dataJ->fetch(PDO::FETCH_OBJ)){
        $sel = "";
        if ($rwJ->id_turno == $id) {
            $sel = "selected";
        }
        $jueces .= "<option value='$rwJ->id_juez' $sel>$rwJ->nm_juez</option>";
        $secretario .= "<option value='$rwJ->id_secretario' $sel>$rwJ->nm_secretario</option>";

    }
}
   
echo json_encode(array( "done" => $done, 
                        "resp" => $resp, 
                        "alert" => $alert,
                        "jueces" => $jueces,
                        "secretario" => $secretario ));

?>