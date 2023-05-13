<?php
$dir_fc       = "";
include_once $dir_fc.'connections/trop.php';
include_once $dir_fc.'connections/php_config.php';

extract($_REQUEST);

$sys_id_men   = 3;
$sys_tipo     = 2; //Editar

$current_file = basename($_SERVER["PHP_SELF"]);
$dir          = dirname($_SERVER['PHP_SELF'])."/".$controller;
$checkMenu    = $server_name.$dir."/";    
$param        = "?controller=".$controller."&action=";

$ruta_app     = "";
$titulo_curr  = "Roles"; 

include_once $dir_fc.'data/inicial.class.php';
include_once $dir_fc.'data/rol.class.php';

$cInicial    = new cInicial();  
$cEditar     = new cRol();       

include_once 'business/sys/check_session.php';

$showinfo    = true;
$id_rol      = "";
$rol         = "";
$descripcion = "";
$activo      = "";
$titulo_edi  = "Visualizando";


if(!isset($pag)){ $pag=1;}
if(!isset($busqueda) || $busqueda == ""){$busqueda = "";}
$return_paginacion = "&pag=".$pag."&busqueda=".$busqueda;


if(!isset($_SESSION[_editar_]) || !is_numeric($_SESSION[_editar_]) || $_SESSION[_editar_]<= 0){
    $showinfo = false;
}else {
    $id = $_SESSION[_editar_];
    $cEditar->setId($id);
    $rsEditar = $cEditar->getRolbyId();
    if ($rsEditar->rowCount() > 0) {
        $arrEdi         = $rsEditar->fetch(PDO::FETCH_OBJ);
        $id_rol         = $arrEdi->id;
        $rol            = $arrEdi->rol;
        $descripcion    = $arrEdi->descripcion;
        $isActive       = $arrEdi->activo;
    } else {
        $showinfo = false;
    }

}
if($_SESSION[_is_view_] == 1){
    $titulo_edi = "Editando";
}
?>
<!DOCTYPE html>
<html>
<head>
    <title><?php echo $titulo_edi." ".$titulo_curr?> | <?php echo $titulo_paginas?></title>
    <meta content="" name="description"/>
    <meta content="" name="author"/>
    <?php include("dist/inc/headercommon.php"); ?>
</head>
<body class="<?php echo _BODY_STYLE_ ?> ">
<?php include ($dir_fc."inc/header.php")?>
<div id="base">
    <div class="offcanvas"></div>
    <div id="content">
        <section>
            <div class="section-body">
                <div class="row">
                    <div class="col-lg-8"></div>
                    <div class="col-lg-4">
                        <ol class="breadcrumb pull-right">
                            <li>
                                <a href="<?php echo $raiz?>business/">
                                    Inicio
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo $param."index".$return_paginacion?>">
                                    Lista de <?php echo $titulo_curr?>
                                </a>
                            </li>
                            <li class="active">
                                <?php echo $titulo_edi." ".$titulo_curr?>
                            </li>
                        </ol>
                    </div>
                </div>
                <?php                //Verifica si el usuario puede insertar registros
                if($_SESSION[edit] == "1" && $showinfo == true) {
                    ?>
                    <div class="card">
                        <?php
                        if($isActive == 1){
                            $class_activo = "fa fa-2x fa-check-circle text-default";
                            $title_activo = "Rol activo";
                            $card_style   = "style-accent-bright";
                        }else{
                            $class_activo = "fa fa-2x fa-times-circle text-default";
                            $title_activo = "Rol inactivo";
                            $card_style   = "style-gray-light";
                        }
                        ?>
                        <div class="card-head <?php echo $card_style?>">
                            <div class="tools pull-left">
                                <a class="btn ink-reaction btn-floating-action btn-accent-bright"
                                   href='<?php echo $param."index".$return_paginacion?>'  
                                   title="Regresar a la lista">
                                    <i class="fa fa-arrow-left"></i>
                                </a>
                            </div>
                            <b class="text-uppercase">
                                <?php echo $titulo_edi?> INFORMACIÓN DE <?php echo $titulo_curr?>
                            </b>
                            <div class="tools">
                                <span class="<?php echo $class_activo?>" 
                                    title="<?php echo $title_activo?>">
                                </span>
                            </div>
                        </div>
                        <div class="card-body">
                            <form 
                                id="frmEditRole" 
                                class="form"                                 
                                role="form" 
                                method="post">                                
                                <div class="row">
                                    <div class="col-xs-12 col-md-12 col-sm-12">
                                        <input type="hidden" name="current_file" id="current_file" value="<?php echo $param?>"/>
                                        <input type="hidden" name="id_rol" id="id_rol" value="<?php echo $id?>"/>
                                        <fieldset><legend>Datos de <?php echo $titulo_curr?></legend>
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <div class="form-group floating-label">
                                                        <input  type="text" 
                                                                class="form-control" 
                                                                name="rol" id="rol" 
                                                                required
                                                                value="<?php echo $rol?>">
                                                        <label for="rol">
                                                            Nombre del Rol 
                                                            <span class="text-danger">*</span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group floating-label">
                                                        <input  type="text" 
                                                                class="form-control" 
                                                                name="descripcion" 
                                                                id="descripcion"
                                                                value="<?php echo $descripcion?>" 
                                                                required>
                                                        <label for="descripcion">
                                                            Descripción 
                                                            <span class="text-danger">*</span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-sm-2">
                                                    <div class="form-group floating-label">
                                                        <input  type="checkbox" 
                                                                class="form-control" 
                                                                name="aplicar" 
                                                                id="aplicar"
                                                                value="1" checked>
                                                        <label for="checkbox">
                                                            Aplicar cambios a todos 
                                                            <span class="text-danger">*</span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </fieldset>
                                        <fieldset>
                                            <legend>
                                                Permisos por default
                                            </legend>
                                            <div class="row">
                                                <div class="col-sm-9">
                                                    <article id="permisos">
                                                        <div class="permisos-field">
                                                            <div class="checkbox checkbox-styled">
                                                                <label>
                                                                    <input 
                                                                        name="ckSelectAll" 
                                                                        id="ckSelectAll" 
                                                                        type="checkbox" 
                                                                        value="1" 
                                                                        title="Imprimir Registros">
                                                                    <b>Seleccionar todos</b>
                                                                </label>
                                                            </div>
                                                            <?php
                                                            $rsRol           = $cEditar->parentsMenu();
                                                            while ($rowReg   = $rsRol->fetch(PDO::FETCH_OBJ)) {
                                                                $chk = "";
                                                                $cEditar->setId_menu($rowReg->id);
                                                                $checked_r  = $cEditar->checarRol_menu();
                                                                if ($checked_r->rowCount() > 0) {
                                                                    $chk = "checked";
                                                                }
                                                                ?>
                                                                <div id="<?php echo $rowReg->id?>">
                                                                    <div class="checkbox checkbox-styled">
                                                                        <span   id="btn_mostrar_<?php echo $rowReg->id?>" 
                                                                                class="btn-plus-ne mostrar" >
                                                                            <i class="fa fa-plus-square-o"></i>
                                                                        </span>
                                                                        <span id="btn_ocultar_<?php echo $rowReg->id?>"                                                                               
                                                                                class="btn-plus-ne ocultar">
                                                                            <i class="fa fa-minus-square-o"></i>
                                                                        </span>
                                                                        <label>
                                                                            <input  name="menus[]" 
                                                                                    id="menu_<?php echo $rowReg->id?>"
                                                                                    type="checkbox" 
                                                                                    value="<?php echo $rowReg->id?>" <?php echo $chk ?>
                                                                                    title="<?php echo $rowReg->texto?>">
                                                                            <?php echo $rowReg->texto ?>
                                                                        </label>
                                                                    </div>
                                                                    <input type="hidden" 
                                                                           id="grupo_m_<?php echo $rowReg->id?>"
                                                                           name="grupo[<?php echo $rowReg->id?>]"
                                                                           value="<?php echo $rowReg->id_grupo?>">
                                                                </div>
                                                                <?php
                                                                $rsRol_c  = $cEditar->childsMenu($rowReg->id);
                                                                ?>
                                                                <div id="child-menu_<?php echo $rowReg->id?>" class="child-menu">
                                                                    <?php
                                                                    while ($rowReg_c = $rsRol_c->fetch(PDO::FETCH_OBJ)) {
                                                                        $chk_imp     = "";
                                                                         $chk_edit    = "";
                                                                        $chk_nvo     = "";
                                                                        $chk_elim    = "";
                                                                        $chk_xport   = "";
                                                                        $chk_2 = "";
                                                                        $cEditar->setId_menu($rowReg_c->id);
                                                                        $checked_r_2 = $cEditar->checarRol_menu();
                                                                        if ($checked_r_2->rowCount() > 0) {
                                                                            $chk_2 = "checked";
                                                                            $rw_check = $checked_r_2->fetch(PDO::FETCH_OBJ);
                                                                            $chk_imp  = $rw_check->imp;
                                                                            $chk_edit = $rw_check->edit;
                                                                            $chk_nvo  = $rw_check->nuevo;
                                                                            $chk_elim = $rw_check->elim;
                                                                            $chk_xport= $rw_check->exportar;
                                                                        }
                                                                        ?>
                                                                        <input type="hidden" id="grupo_m_<?php echo $rowReg_c->id?>" 
                                                                                name="grupo[<?php echo $rowReg_c->id?>]" 
                                                                                value="<?php echo $rowReg_c->id_grupo?>">
                                                                        <div class="checkbox checkbox-styled">
                                                                            <label class="separador-desc">
                                                                                <input name="menus[]" id="child_<?php echo $rowReg->id?> _<?php echo $rowReg_c->id?>" 
                                                                                        type="checkbox"
                                                                                        value="<?php echo $rowReg_c->id?>" title="<?php echo $rowReg_c->texto?>"
                                                                                         <?php echo $chk_2 ?>>
                                                                                <?php echo $rowReg_c->texto ?>
                                                                            </label>
                                                                            <label class="separador">
                                                                                <input type="checkbox" name="permiso_imp[<?php echo $rowReg_c->id?>]" 
                                                                                        value="1" title="Editar" 
                                                                                        id="permiso_imp<?php echo $rowReg_c->id?>" 
                                                                                        <?php if($chk_imp == 1){ echo "checked";}?>>
                                                                                Imprimir
                                                                            </label>
                                                                            <label class="separador">
                                                                                <input type="checkbox" name="permiso_nuevo[<?php echo $rowReg_c->id?>]" 
                                                                                        value="1" title="Editar" 
                                                                                        id="permiso_nuevo<?php echo $rowReg_c->id?>"
                                                                                        <?php if($chk_nvo == 1){ echo "checked";}?>>
                                                                                Nuevo
                                                                            </label>
                                                                            <label class="separador">
                                                                                <input type="checkbox" name="permiso_edit[<?php echo $rowReg_c->id?>]" 
                                                                                        value="1" title="Editar" 
                                                                                        id="permiso_edit<?php echo $rowReg_c->id?>" 
                                                                                        <?php if($chk_edit == 1){ echo "checked";}?>>
                                                                                Editar
                                                                            </label>
                                                                            <label class="separador">
                                                                                <input type="checkbox" name="permiso_elim[<?php echo $rowReg_c->id?>]" 
                                                                                        value="1" title="Editar" 
                                                                                        id="permiso_elim<?php echo $rowReg_c->id?>" 
                                                                                        <?php if($chk_elim == 1){ echo "checked";}?>>
                                                                                Eliminar
                                                                            </label>
                                                                            <label class="separador">
                                                                                <input type="checkbox" name="permiso_exportar[<?php echo $rowReg_c->id?>]" 
                                                                                        value="1" title="Editar" 
                                                                                        id="permiso_exportar<?php echo $rowReg_c->id?>" 
                                                                                        <?php if($chk_xport == 1){ echo "checked";}?>>
                                                                                Exportar
                                                                            </label>
                                                                        </div>
                                                                        <?php
                                                                    }
                                                                    ?>
                                                                </div>
                                                                <?php
                                                            }
                                                            ?>
                                                        </div>
                                                    </article>
                                                </div>
                                            </div>
                                        </fieldset>
                                        <fieldset>
                                            <?php
                                            if($_SESSION[_is_view_] == 1){ //Si es editar
                                            ?>
                                            <div class="row">
                                                <div class="col-sm-12 col-md-4 col-xs-12 col-lg-4">
                                                    <button type="submit" id="btn_guardar"
                                                        class="btn ink-reaction btn-block btn-primary">
                                                        <span class="glyphicon glyphicon-floppy-disk"></span> 
                                                        Guardar Cambios
                                                    </button>
                                                </div>
                                            </div>
                                            <?php
                                            }
                                            ?>
                                        </fieldset>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                <?php
                }else{
                    include("../../sys/permissions_d.php");
                }?>
            </div>
        </section>
    </div>
    <?php include($dir_fc."inc/menucommon.php") ?>
</div>
<?php include("dist/components/role.magnament.php"); ?>

</body>
</html>
