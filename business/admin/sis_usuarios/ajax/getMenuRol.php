<?php
$dir_fc = "../../../../";

include_once $dir_fc . 'data/rol.class.php';
include_once $dir_fc . 'connections/trop.php';  
include_once $dir_fc . 'connections/php_config.php';  

$cAccion = new cRol();

$id_rol = 0;

extract($_REQUEST);

if(is_numeric($id_rol) && $id_rol <> 0){
    $cAccion->setId($id_rol);

    $rsRol           = $cAccion->parentsMenu();
    while ($rowReg   = $rsRol->fetch(PDO::FETCH_OBJ)) {
        $chk = "";
        $cAccion->setid_menu($rowReg->id_menu);
        $checked_r  = $cAccion->checarRol_menu();
        if ($checked_r->rowCount() > 0) {
            $chk = "checked";
        }
        ?>
        <div id="<?php echo $rowReg->id_menu?>">
            <div class="checkbox">
                <span id="btn_mostrar_<?php echo $rowReg->id_menu?>" 
                        class="btn-plus-ne mostrar"> 
                        <i class="fa fa-plus-square-o"></i>
                </span>
                <span id="btn_ocultar_<?php echo $rowReg->id_menu?>" 
                        class="btn-plus-ne ocultar"> 
                        <i class="fa fa-minus-square-o"></i>
                </span>
                <label>
                    <input name="menus[]" id="menu_<?php echo $rowReg->id_menu?>"
                            type="checkbox"
                            value="<?php echo $rowReg->id_menu?>" <?php echo $chk ?>
                            title="<?php echo $rowReg->texto?>">
                    <?php echo $rowReg->texto ?>
                </label>
            </div>
            <input type="hidden" 
                    id="grupo_m_<?php echo $rowReg->id_menu?>"
                    name="grupo[<?php echo $rowReg->id_menu?>]"
                    value="<?php echo $rowReg->id_grupo?>">
        </div>
        <?php
        $rsRol_c = $cAccion->childsMenu($rowReg->id_menu);
        ?>
        <div id="child-menu_<?php echo $rowReg->id_menu?>" class="child-menu">
            <?php
            while ($rowReg_c = $rsRol_c->fetch(PDO::FETCH_OBJ)) {
                $chk_imp     = "";
                $chk_edit    = "";
                $chk_nuevo   = "";
                $chk_elim    = "";
                $chk_exportar= "";
                $chk_2 = "";
                $cAccion->setId_menu($rowReg_c->id_menu);
                $checked_r_2 = $cAccion->checarRol_menu();
                if ($checked_r_2->rowCount() > 0) {
                    $chk_2 = "checked";
                    $rw_check = $checked_r_2->fetch(PDO::FETCH_OBJ);
                    $chk_imp = $rw_check->imp;
                    $chk_edit = $rw_check->edit;
                    $chk_nuevo = $rw_check->nuevo;
                    $chk_elim = $rw_check->elim;
                    $chk_exportar = $rw_check->exportar;
                }
                ?>
                <input type="hidden" 
                        id="grupo_m_<?php echo $rowReg_c->id_menu?>" 
                        name="grupo[<?php echo $rowReg_c->id_menu?>]" 
                        value="<?php echo $rowReg_c->id_grupo?>">
                <div class="checkbox ">
                    <label class="separador-desc">
                        <input name="menus[]" 
                               id="child_<?php echo $rowReg->id_menu?> _<?php echo $rowReg_c->id_menu?>" 
                               type="checkbox" <?php echo $chk_2 ?>
                               value="<?php echo $rowReg_c->id_menu?>" 
                               title="<?php echo $rowReg_c->texto?>">
                        <?php echo $rowReg_c->texto ?>
                    </label>
                    <label class="separador">
                        <input type="checkbox" title="Imprimir" 
                               name="permiso_imp[<?php echo $rowReg_c->id_menu?>]" value="1"
                               id="permiso_imp<?php echo $rowReg_c->id_menu?>" 
                               <?php if($chk_imp == 1){ echo "checked";}?>>
                        Imprimir

                    </label>
                    <label class="separador">
                        <input type="checkbox" title="Nuevo" 
                               name="permiso_nuevo[<?php echo $rowReg_c->id_menu?>]" value="1"
                               id="permiso_nuevo<?php echo $rowReg_c->id_menu?>" 
                               <?php if($chk_nuevo == 1){ echo "checked";}?>>
                        Nuevo
                    </label>
                    <label class="separador">
                        <input type="checkbox" title="Editar" 
                               name="permiso_edit[<?php echo $rowReg_c->id_menu?>]" value="1"
                               id="permiso_edit<?php echo $rowReg_c->id_menu?>" 
                               <?php if($chk_edit == 1){ echo "checked";}?>>
                        Editar
                    </label>
                    <label class="separador">
                        <input type="checkbox" title="Eliminar" 
                               name="permiso_elim[<?php echo $rowReg_c->id_menu?>]" value="1"
                               id="permiso_elim<?php echo $rowReg_c->id_menu?>" 
                               <?php if($chk_elim == 1){ echo "checked";}?>>
                        Eliminar
                    </label>
                    <label class="separador">
                        <input type="checkbox" title="Exportar" 
                               name="permiso_exportar[<?php echo $rowReg_c->id_menu?>]" value="1"
                               id="permiso_exportar<?php echo $rowReg_c->id_menu?>" 
                               <?php if($chk_exportar == 1){ echo "checked";}?>>
                        Exportar
                    </label>
                </div>
                <?php
            }
            ?>
        </div>
        <?php
    }

}else{
    echo "Valores recibidos, no válidos.";
    
}
?>