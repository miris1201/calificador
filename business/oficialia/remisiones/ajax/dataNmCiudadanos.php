<?php


$dir_fc = "../../../../";
include_once $dir_fc.'data/remisiones.class.php';
include_once $dir_fc.'common/function.class.php';

$cAccion = new cRemision();
$cFn     = new cFunction();

$id   = "";
$resp = "";

extract($_REQUEST);

if(isset($id) && is_numeric($id)){
    $rsC = $cAccion->getRegCiudadanosByRem( $id );
    if ($rsC->rowCount() > 0) {
    while($rwC = $rsC->fetch(PDO::FETCH_OBJ)){
        $resp  .= "<tr>";
        $resp .= "<td>$rwC->nm_ciudadano </td> ";
        $resp .= "</tr>";
    }   
}
    $resp .= "</table>";
    $done = 1;
    
    
} 
echo $resp;

?>