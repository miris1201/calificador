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
$sexo           = "";
$clave          = "";
$id_turno       = "";
$id_zona        = "";

$imp            = 1;
$nuevo          = 1;
$edi            = 1;
$elim           = 0;
$exportar       = 1;

$done           = 0;
$alert          = "warning";

extract($_REQUEST);


if($usuario      == "" || $nombre == "" || $apepat == "" || $id_zona == "" || 
    $id_turno == "" || $sexo == "" || $clave == ""  ){ //Verficando datos vacios
    $resp = "Debes de ingresar correctamente los datos";
}else{
    if(isset($_SESSION[admin]) && $_SESSION[admin] == 1){
        $user_admin = $admin;
    }else{
        $user_admin = 0;
    }
    //buscar si existe un usuario con el mismo nombre
    $userFound = $cAccion->foundUser( $usuario );

    if ($userFound > 0) {
        $resp = "El nombre de usuario seleccionado ya existe en la base de datos, intentar con otro";
        
    } else {

        if(!isset($imp)) {  $imp = 0;}
        if(!isset($edit)){ $edit = 0;}
        if(!isset($elim)){ $elim = 0;}
        if(!isset($nuev)){ $nuev = 0;}
        if(!isset($export)){ $export = 0;}


        $f_ingreso = date('Y-m-d');
        $clave = MD5($clave);
        $data = array(
            $id_rol,
            $id_zona,
            $id_turno,            
            $f_ingreso,   
            $usuario, 
            $clave,
            $nombre,
            $apepat,
            $apemat,
            $sexo,
            $user_admin
        );

        $inserted = $cAccion->insertReg( $data );

        if(is_numeric($inserted) AND $inserted > 0){
            if(isset($menus)){
                foreach ($menus as $id_arr => $valor_arr) {
                    $imp      = 0;
                    $nuevo    = 0;
                    $edi      = 0;
                    $elim     = 0;
                    $exportar = 0;

                    $dataDtl = array(
                        $inserted,
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

                            $dataDtl = array(
                                $inserted,
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
            $resp  = "Usuario agregado correctamente.";
            $alert = "success";
        }else{
            $done  = 0;
            $resp  = "Ocurrió un incoveniente con la base de datos: -- ".$inserted;
        }
        
    }
}
echo json_encode(
    array(
        "done" => $done, 
        "resp" => $resp, 
        "alert" => $alert
    )
);

$cAccion->closeOut();
