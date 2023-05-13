<?php
$dir_fc = "../../../";
/*-----------------------------------      Estableciendo la Clases  --------------------------------------*/
include_once $dir_fc.'data/users.class.php';
/*--------------------------------------------------------------------------------------------------------*/
include_once $dir_fc.'connections/trop.php'; //Inclueye configuración de fecha y  hora de mexico
include_once $dir_fc.'connections/php_config.php'; //Inclueye configuración de fecha y  hora de mexico

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

if($usuario == "" || $nombre == "" || $apepat == "" || $apemat == "" || $sexo == ""){
    $resp = "Debes de ingresar correctamente los datos";
}else{
    //Checar si intentó cmabiar su nombre de usuario
    $cAccion->setUsuario($usuario);
    $cAccion->setId_usuario($_SESSION[id_usr]);

    $userCoincidencia = $cAccion->foundUserConcidencia();
    if ($userCoincidencia == 1){
        //Si se encuentra coincidencia quiere decir que no cambio su nombre de usuario
        $userFound = 0;
    }else{
        //De lo contrario buscar si existe un usuario con el mismo nombre
        $userFound = $cAccion->foundUser();
    }

    if ($userFound>0) {
        $resp = "El usuario ya existe en la base de datos, favor de intentar con otro nombre de usuario";
    } else {


        $cAccion->setNombre($nombre);
        $cAccion->setApePa($apepat);
        $cAccion->setApeMa($apemat);
        $cAccion->setCorreo($correo);
        $cAccion->setSexo($sexo);

        $inserted = $cAccion->updateRegacount();

        if(is_numeric($inserted)){
            $done  = 1;
            $resp  = "Tu cuenta a sido actualizada correctamente.";
            $alert = "success";
        } 
    }
}

echo json_encode(array("done" => $done, "resp" => $resp, "alert" => $alert));
?>
