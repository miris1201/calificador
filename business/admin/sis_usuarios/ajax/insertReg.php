<?php
$dir_fc = "../../../../";

include_once $dir_fc.'connections/trop.php'; 
include_once $dir_fc.'connections/php_config.php'; 
include_once $dir_fc.'data/users.class.php';

$cAccion  = new cUsers();

$id_rol         = 0;
$admin          = 0;
$usuario        = "";
$nombre         = "";
$apepat         = "";
$apemat         = "";
$correo         = "";
$sexo           = "";
$id_direccion   = "";
$id_area        = "";
$clave          = "";
$origen_user    = array();
$id_aplicativo  = "";
$id_modulo      = "";

$imp            = 1;
$nuevo          = 1;
$edi            = 1;
$elim           = 0;
$exportar       = 1;

$done           = 0;
$alert          = "warning";

extract($_REQUEST);


if($usuario      == "" || $nombre == "" || $apepat        == "" || $apemat == "" || 
   $sexo         == "" || $clave == ""  ){ //Verficando datos vacios
    $resp = "Debes de ingresar correctamente los datos";
}else{
    if(isset($_SESSION[admin]) && $_SESSION[admin] == 1){
        $user_admin = $admin;
    }else{
        $user_admin = 0;
    }
    //buscar si existe un usuario con el mismo nombre
    $cAccion->setUsuario($usuario);
    $userFound = $cAccion->foundUser();

    if ($userFound > 0) {
        $resp = "El nombre de usuario seleccionado ya existe en la base de datos, intentar con otro";
        
    } else {

        $cAccion->setId_rol($id_rol);
        $cAccion->setId_direccion($id_direccion);
        $cAccion->setClave(hash('sha256',$clave));
        $cAccion->setNombre($nombre);
        $cAccion->setApepa($apepat);
        $cAccion->setApema($apemat);
        $cAccion->setCorreo($correo);
        $cAccion->setSexo($sexo);
        $cAccion->setImprimir(1);
        $cAccion->setEditar(1);
        $cAccion->setEliminar($elim);
        $cAccion->setNuevo(1);
        $cAccion->setAdmin($user_admin);

        $inserted = $cAccion->insertReg(date("Y-m-d"));

        if(is_numeric($inserted) AND $inserted > 0){
            $cAccion->setId_usuario($inserted);
            
            if(isset($menus)){
                foreach ($menus as $id_arr => $valor_arr) {
                    $cAccion->setImprimir(1);
                    $cAccion->setNuevo(1);
                    $cAccion->setEditar(1);
                    $cAccion->setEliminar(0);
                    $cAccion->setExportar(1);
                
                    $imp      = 1;
                    $nuevo    = 1;
                    $edi      = 0;
                    $elim     = 1;
                    $exportar = 1;
                
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
            $resp  = "Usuario agregado correctamente.";
            $alert = "success";
        }else{
            $done  = 0;
            $resp  = "Ocurrió un incoveniente con la base de datos: -- ".$inserted;
        }
        $cAccion->closeOut();
    }
}
echo json_encode(
    array(
        "done" => $done, 
        "resp" => $resp, 
        "alert" => $alert
    )
);
