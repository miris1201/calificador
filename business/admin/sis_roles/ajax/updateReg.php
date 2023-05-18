<?php
$dir_fc = "../../../../";
include_once $dir_fc.'connections/trop.php'; 
include_once $dir_fc.'connections/php_config.php'; 
include_once $dir_fc.'data/rol.class.php';

$cAccion  = new cRol();

$id_rol             = "";
$rol                = "";
$descripcion        = "";

$permiso_imp[]      = "";
$permiso_nuevo[]    = "";
$permiso_edit[]     = "";
$permiso_elim[]     = "";
$permiso_exportar[] = "";

$imp      = 0;
$nuev     = 0;
$edit     = 0;
$elim     = 0;
$exportar = 0;

$done   = 0;
$resp   = "";

extract($_REQUEST);

$data  = array(
        $rol, 
        $descripcion,
        $id_rol );

$actualiza = $cAccion->updateReg( $data );

if ($actualiza > 0) {
    $done = 1;
    $alert = "success";
    $resp = "Registro actualizado correctamente.";
    
    if(!isset($imp)) {  $imp = 0;}
    if(!isset($edit)){ $edit = 0;}
    if(!isset($elim)){ $elim = 0;}
    if(!isset($nuev)){ $nuev = 0;}
    if(!isset($exportar)){ $exportar = 0;}


    if(isset($menus)){
        $cAccion->setId($id_rol);
        $cAccion->deleteRegRM();
        foreach ($menus as $id_arr => $valor_arr) {

            $dataR = array(
                $id_rol,
                $valor_arr,
                $imp,            
                $edit,   
                $elim, 
                $nuev,
                $exportar );
                    
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
                        $exportar = $permiso_exportar[$valor_arr];
                    }

                    $dataR = array( $id_rol,
                                $valor_arr,
                                $imp,
                                $edit,
                                $elim,
                                $nuev, 
                                $exportar );
                }
            }
            $cAccion->insertRegdtl( $dataR );
        }
    }

}else{
    $resp = "Ocurrió un inconveniente .. ".$actualiza;
}
echo json_encode(array("done" => $done, "resp" => $resp, "alert" => $alert));
?>
