<?php
$dir_fc = "../";
include_once $dir_fc.'data/users.class.php';
include_once $dir_fc.'connections/php_config.php';
include_once $dir_fc.'common/function.class.php';

$cUsers	 =	new cUsers();
$cFn	 =	new cFunction();
$txtPass = "";
$done    = 0;
$alert   = "error";
$resp    = "Sin procesar";

extract($_REQUEST);

try {

    if (!isset($txtUser) || empty($txtUser) || empty($txtPass)){
        throw new Exception("Los campos requeridos  están vacios");
    }

    $arrayUserLogin = array(
        $cFn->get_sub_string($txtUser,40),
        md5($txtPass)
    );

    $selectUser = $cUsers->getUser( $arrayUserLogin );

    $num_rows   = 0;
    $carpeta_go = "";
    $tipo       = gettype($selectUser);

    if($tipo == "string"){
        throw new Exception("Ocurrió un incoveniente con los datos insertados ".$selectUser);
    }
    
    $datos = $selectUser->fetch(PDO::FETCH_ASSOC);
    
    if($selectUser->rowCount() == 0){
        throw new Exception("No existen coincidencias con las credenciales ingresadas");
    }

    session_start();

    $done  = 1;
    $resp  = "?controller=business&action=show";
    $alert = "success";
    
    $_SESSION[s_ncompleto]  = $datos['nombrecompleto'];
    $_SESSION[s_nombre]     = $datos['nombre'];
    $_SESSION[s_sexo]       = $datos['sexo'];
    $_SESSION[s_f_i]        = $datos['fecha_ingreso'];
    $_SESSION[id_usr]       = $datos['id_usuario'];
    $_SESSION[user]         = $datos['usuario'];
    $_SESSION[id_rol]       = $datos['id_rol'];
    $_SESSION[rol]          = $datos['rol'];
    $_SESSION[admin]        = $datos['admin'];            
    $_SESSION[id_direccion] = $datos['id_direccion'];            

    $cUsers->setId_usuario($_SESSION[id_usr]);

} catch (\Exception $e) {
	$resp = $e->getMessage();
}

echo json_encode(
    array(
        "done" => $done, 
        "alert" => $alert, 
        "goto" => $resp
    )
);