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
$imp                = 0;
$nuevo              = 0;
$edi                = 0;
$elim               = 0;
$exportar           = 0;
$done               = 0;
$aplicar            = 0;
extract($_REQUEST);

$cAccion->setId($id_rol);
$cAccion->setRol($rol);
$cAccion->setDescripcion($descripcion);
$actualiza = $cAccion->updateReg();

if ($actualiza>0) {
    $done = 1;
    $resp = "Registro actualizado correctamente.";
    
    $cAccion->setImprimir(0);
    $cAccion->setNuevo(0);
    $cAccion->setEditar(0);
    $cAccion->setEliminar(0);
    $cAccion->setExportar(0);

    $cAccion->deleteRegRM();
    if(isset($menus)){
        foreach ($menus as $id_arr => $valor_arr) {
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
            $cAccion->insertRegdtl();
        }
    }

}else{
    $resp = "Ocurrió un inconveniente .. ".$actualiza;
}
echo json_encode(array("done" => $done, "resp" => $resp));
?>
