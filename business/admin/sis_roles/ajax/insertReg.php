<?php
$dir_fc = "../../../../";

include_once $dir_fc.'data/rol.class.php';
include_once $dir_fc.'connections/trop.php'; 
include_once $dir_fc.'connections/php_config.php'; 


$cAccion  = new cRol();

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
$resp               = "";
$inserted           = "";

extract($_REQUEST);

//buscar si existe un rol con el mismo nombre
$cAccion->setRol($rol);
$RolFound = $cAccion->foundRol();

if ($RolFound > 0) {
    $resp = "Existe un rol con el mismo nombre";

} else {
    $cAccion->setDescripcion($descripcion);
    $inserted = $cAccion->insertReg();
}

if(is_numeric($inserted) AND $inserted  > 0){

    $done = 1;
    $resp = "Rol agregado correctamente";

    $cAccion->setImprimir(0);
    $cAccion->setNuevo(0);
    $cAccion->setEditar(0);
    $cAccion->setEliminar(0);
    $cAccion->setExportar(0);

    $cAccion->setId($inserted);
    if(isset($menus)){
        foreach ($menus as $id_arr => $valor_arr) {
            $cAccion ->setId_menu($valor_arr);
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
            $correcto = $cAccion->insertRegdtl();
        }
    }
    

} 

echo json_encode(array("done" => $done, "resp" => $resp));
?>
