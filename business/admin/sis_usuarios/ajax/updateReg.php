<?php
session_start();
$dir_fc = "../../../../";

include_once $dir_fc.'data/users.class.php';
include_once $dir_fc.'connections/trop.php'; 
include_once $dir_fc.'connections/php_config.php'; 

$cAccion  = new cUsers();

$id_usuario    = 0;
$id_rol        = 0;
$id_direccion  = "";
$id_area       = "";
$usuario       = "";
$nombre        = "";
$apepat        = "";
$apemat        = "";
$correo        = "";
$sexo          = "";   
$clave         = "";
$admin         = "";
$origen_user   = array();
$id_aplicativo = "";
$id_modulo     = "";

$imp      = 0;
$nuevo    = 0;
$edi      = 0;
$elim     = 0;
$exportar = 0;

$done     = 0;
$alert    = "warning";

extract($_REQUEST);


if(!is_numeric($id_usuario) || $id_usuario <= 0 || $usuario == "" || $nombre == ""      || 
   $apepat == ""            || $apemat == ""    || $sexo == ""    || $origen_user == "" ){

    $resp = "Debes de ingresar correctamente los datos";
}
else{
    if(isset($_SESSION[admin]) && $_SESSION[admin] == 1){
        $user_admin = $admin;
    }else{
        $user_admin = 0;
    }
    //Checar si intentó cmabiar su nombre de usuario
    $cAccion->setUsuario($usuario);
    $cAccion->setId_usuario($id_usuario);

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

        if($id_direccion == ""){
            $id_direccion = 0;
        }


        if(!isset($imp)) {  $imp = 0;}
        if(!isset($edit)){ $edit = 0;}
        if(!isset($elim)){ $elim = 0;}
        if(!isset($nuev)){ $nuev = 0;}

        $cAccion->setId_rol($id_rol);
        $cAccion->setId_direccion($id_direccion);
        $cAccion->setNombre($nombre);
        $cAccion->setApepa($apepat);
        $cAccion->setApema($apemat);
        $cAccion->setCorreo($correo);
        $cAccion->setSexo($sexo);
        $cAccion->setImprimir($imp);
        $cAccion->setEditar($edit);
        $cAccion->setEliminar($elim);
        $cAccion->setNvo_usr($nuev);
        $cAccion->setAdmin($user_admin);

        $inserted = $cAccion->updateReg();

        if(is_numeric($inserted) AND $inserted > 0){
            if(isset($menus)){
                $cAccion->deleteRegUsMenu();
                foreach ($menus as $id_arr => $valor_arr) {
                    
                    $cAccion->setImprimir(0);
                    $cAccion->setNuevo(0);
                    $cAccion->setEditar(0);
                    $cAccion->setEliminar(0);
                    $cAccion->setExportar(0);

                    $imp      = 0;
                    $nuevo    = 0;
                    $edi      = 0;
                    $elim     = 0;
                    $exportar = 0;

                    $cAccion->setId_menu($valor_arr);
                    if(isset($grupo)){
                        $grupo_rec = $grupo[$valor_arr];
                        if($grupo_rec <> 0){
                            if(isset($permiso_imp[$valor_arr])){
                                $imp = $permiso_imp[$valor_arr];
                            }
                            if(isset($permiso_nuevo[$valor_arr])){
                                $nuevo = $permiso_nuevo[$valor_arr];
                            }
                            if(isset($permiso_edit[$valor_arr])){
                                $edi = $permiso_edit[$valor_arr];
                            }
                            if(isset($permiso_elim[$valor_arr])){
                                $elim = $permiso_elim[$valor_arr];
                            }
                            if(isset($permiso_exportar[$valor_arr])){
                                $exportar = $permiso_exportar[$valor_arr];
                            }
                            $cAccion->setImprimir($imp);
                            $cAccion->setNuevo($nuevo);
                            $cAccion->setEditar($edi);
                            $cAccion->setEliminar($elim);
                            $cAccion->setExportar($exportar);
                        }
                    }
                    $correcto = $cAccion->insertRegdtluser();
                    if(!is_numeric($correcto)){
                        die($correcto);
                    }
                }
            }
           
            $done  = 1;
            $resp  = "Usuario actualizado correctamente.";
            $alert = "success";
        } else {
            $done  = 0;
            $resp  = "Ocurrió un incoveniente con la base de datos: -- ".$inserted;
        }
    }
}
echo json_encode(array("done" => $done, "resp" => $resp, "alert" => $alert));
?>
