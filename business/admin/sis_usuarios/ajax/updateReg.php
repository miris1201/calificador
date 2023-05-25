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
$sexo          = "";   
$clave         = "";
$admin         = "";
$id_zona       = "";
$id_turno      = "";

$imp      = 0;
$nuev     = 0;
$edit     = 0;
$elim     = 0;
$export   = 0;

$done     = 0;
$alert    = "warning";

extract($_REQUEST);


if(!is_numeric($id_usuario) || $id_usuario <= 0 || $usuario == "" || $nombre == "" || 
   $apepat == ""            || !is_numeric($id_zona) || $id_zona <= 0 ){

    $resp = "Debes de ingresar correctamente los datos";
}
else{
    if(isset($_SESSION[admin]) && $_SESSION[admin] == 1){
        $user_admin = $admin;
    }else{
        $user_admin = 0;
    }

    if(!isset($imp)) {  $imp = 0;}
    if(!isset($edit)){ $edit = 0;}
    if(!isset($elim)){ $elim = 0;}
    if(!isset($nuev)){ $nuev = 0;}
    if(!isset($export)){ $export = 0;}

    //Checar si intentó cmabiar su nombre de usuario
    $data = array($usuario, $id_usuario);

    $userCoincidencia = $cAccion->foundUserConcidencia( $data );
    if ($userCoincidencia == 1){
        //Si se encuentra coincidencia quiere decir que no cambio su nombre de usuario
        $userFound = 0;
    }else{
        //De lo contrario buscar si existe un usuario con el mismo nombre
        $userFound = $cAccion->foundUser( $usuario );
    }

    if ($userFound > 0) {
        $resp = "El usuario ya existe en la base de datos, favor de intentar con otro nombre de usuario";

    } else {

        $dataU = array(
            $id_rol,
            $id_zona,
            $usuario, 
            $nombre,
            $apepat,
            $apemat,
            $user_admin,
            $id_usuario
        );

        $inserted = $cAccion->updateReg( $dataU );

        if(is_numeric($inserted) AND $inserted > 0){
            if(isset($menus)){
                $cAccion->setId_usuario($id_usuario);
                $cAccion->deleteRegUsMenu();
                foreach ($menus as $id_arr => $valor_arr) {                                        
                    $imp      = 0;
                    $nuev    = 0;
                    $edit      = 0;
                    $elim     = 0;
                    $export = 0;

                    $dataDtl = array(
                        $id_usuario,
                        $valor_arr,
                        $imp,            
                        $edit,   
                        $elim, 
                        $nuev,
                        $export
                    );
                    if(isset($grupo)){
                        $grupo_rec = $grupo[$valor_arr];
                        if($grupo_rec <> 0){
                            if(isset($permiso_imp[$valor_arr])){
                                $imp = $permiso_imp[$valor_arr];
                            }
                            if(isset($permiso_nuevo[$valor_arr])){
                                $nuev = $permiso_nuevo[$valor_arr];
                            }
                            if(isset($permiso_edit[$valor_arr])){
                                $edit = $permiso_edit[$valor_arr];
                            }
                            if(isset($permiso_elim[$valor_arr])){
                                $elim = $permiso_elim[$valor_arr];
                            }
                            if(isset($permiso_exportar[$valor_arr])){
                                $export = $permiso_exportar[$valor_arr];
                            }
                            $dataDtl = array(
                                $id_usuario,
                                $valor_arr,
                                $imp,            
                                $edit,   
                                $elim, 
                                $nuev,
                                $export
                            );
                        }
                    }

                    $correcto = $cAccion->insertRegdtluser( $dataDtl );
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
