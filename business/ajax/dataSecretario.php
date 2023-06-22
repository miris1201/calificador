<?php


$dir_fc = "../../";
include_once $dir_fc.'data/business.class.php';
include_once $dir_fc.'common/function.class.php';

$cAccion = new cBusiness();

$id_turno      = "";
$id_juez       = "";
$id_secretario = "";

$resp = "";
$done = 1;
$alert = "error";

extract($_REQUEST);

if(isset($id) && is_numeric($id)){

    $done = 1;
    
    $dataS = $cAccion->getDataSecretario();
    $secretario = "<option></option>";
    while($rwS = $dataS->fetch(PDO::FETCH_OBJ)){        
        $sel = "";
        if ($rwS->id_juez == $id) {
            $sel = "selected";
        }
        $secretario .= "<option value='$rwS->id_secretario' $sel>$rwS->nm_secretario</option>";

    }
}
   
echo json_encode(array( "done" => $done, 
                        "resp" => $resp, 
                        "alert" => $alert,
                        "secretario" => $secretario ));

?>