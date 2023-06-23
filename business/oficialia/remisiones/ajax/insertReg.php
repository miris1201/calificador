<?php
session_start();
$dir_fc = "../../../../";

include_once $dir_fc.'connections/trop.php'; 
include_once $dir_fc.'connections/php_config.php'; 
include_once $dir_fc.'data/remisiones.class.php';
include_once $dir_fc.'common/function.class.php';

$cAccion  = new cRemision();
$cFn      = new cFunction();


$fecha_remision = "";
$patrulla       = "";
$id_patrullero  = 0;
$id_escolta     = 0;
$id_colonia     = 0;
$sector         = 0;
$folio_rnd      = 0;
$id_autoridad   = 0;
$calle          = "";
$entre_calle    = "";
$y_calle        = "";
$observaciones  = "";
$folio          = 0;

$done  = 0;
$resp  = "";
$alert = "warning";

extract($_REQUEST);

if( !isset($_SESSION[id_usr])
    || $patrulla == ""
    || !is_numeric($id_patrullero) || $id_patrullero == 0
    || !is_numeric($id_escolta) || $id_escolta == 0
    || !is_numeric($id_colonia) || $id_colonia == 0
    || !is_numeric($sector) || $sector == 0 
    || !is_numeric($folio_rnd)
    || !is_numeric($id_autoridad) || $id_autoridad == 0  
    || $calle == "" || $entre_calle == ""
    || $observaciones == ""
    ){ //Verficando datos vacios
    $resp = "Debes de ingresar correctamente los datos";

}else{          


    $date = $cFn->formatearFecha($fecha_remision);

    $data = array(
        $_SESSION[id_usr],
        date('Y-m-d H:i'),
        $date,
        $_SESSION[id_turno],
        $folio,
        $patrulla,
        $id_patrullero,
        $id_escolta,
        $id_colonia,
        $sector, 
        $calle,
        $entre_calle,
        $y_calle,
        $observaciones

    );

    var_dump( $data );

    $inserted = $cAccion->insertRemision( $data );

    if(is_numeric($inserted) AND $inserted > 0){
        $done  = 1;
        $resp  = "Registro agregado correctamente.";
        $alert = "success";
    
    } else {
        $done  = 0;
        $resp  = "Ocurrió un incoveniente con la base de datos: -- ".$inserted;

    }
    
}
echo json_encode(array("done" => $done, "resp" => $resp, "alert" => $alert));

$cAccion->closeOut();
?>
