<?php
$dir_fc = "../../../";

include_once $dir_fc.'data/users.class.php';

include_once $dir_fc.'connections/trop.php';
include_once $dir_fc.'connections/php_config.php';

session_start();

$cAccion  = new cUsers();

$id_usuario = 0;
$id_rol     = 0;
$usuario    = "";
$nombre     = "";
$apepat     = "";
$apemat     = "";
$correo     = "";
$sexo       = "";
$clave      = "";

$done = 0;
$resp = "";
$alert = "warning";

extract($_REQUEST);

try{
    
    if($correo == "" || $nombre == "" || $apepat == "" || $apemat == "" || $sexo == ""){
        throw new Exception("Debes de ingresar correctamente los datos");
    }
    
    if(!is_numeric($id_colonia)){
        throw new Exception("Colonia no válida");
    }

    if(!filter_var($correo, FILTER_VALIDATE_EMAIL)){
        throw new Exception("La dirección de correo electrónico es inválida");
    }

    if($cAccion->getUserByEmail( $correo )){
        throw new Exception("Ya existe en usuario generado con este correo electrónico");
    }    

    $id_profile = 4; //Default for public users
    $created_at = date("Y-m-d H:i");
    $fec_ingreso = date("Y-m-d");

    $img = ($sexo == 1) ? "avatar5.png" : "avatar2.png";
    
    $arrayInsert = array(
        $id_profile,
        $id_colonia,
        $created_at,
        $correo, //Su nombre de usuario será el correo electrónico
        hash('sha256',$clave),
        $nombre,
        $apepat,
        $apemat,
        $sexo,
        $correo,
        $domicillio,
        $telefono,
        $tel_movil,
        $fec_ingreso,
        1,
        0,
        0,
        0,
        $img,
    );

    $inserted = $cAccion->insertRegUser( $arrayInsert );

    if(!is_numeric($inserted)){
        throw new Exception("Ocurrió un inconveniente al insertar los registros");
    } 

    $done  = 1;
    $resp  = "Tu cuenta a sido registrada correctamente.";
    $alert = "success";

    //Inserta el perfil para que pueda ver el menú
    $doDtl = $cAccion->insertRegdtlByRol($inserted, $id_profile);

    if(!is_numeric($doDtl)){
        $resp .= " ||| No se ingresaron los permisos del usuario";
    }

    
} catch (\Exception $e) {
    $resp .= $e->getMessage();
}

echo json_encode(
    array(
        "done" => $done, 
        "resp" => $resp, 
        "alert" => $alert
    )
);

