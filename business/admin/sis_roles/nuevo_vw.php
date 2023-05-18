<?php
$dir_fc       = "";
include_once $dir_fc.'connections/trop.php';
include_once $dir_fc.'connections/php_config.php';

extract($_REQUEST);

$sys_id_men   = 3;
$sys_tipo     = 0; //Nuevo

$current_file = basename($_SERVER["PHP_SELF"]);
$dir          = dirname($_SERVER['PHP_SELF'])."/".$controller;
$checkMenu    = $server_name.$dir."/";    
$param        = "?controller=".$controller."&action=";

$ruta_app     = "";
$titulo_edi  = "Nuevo";
$titulo_curr  = "Rol"; 

include_once $dir_fc.'data/inicial.class.php';
include_once $dir_fc.'data/rol.class.php';

$cInicial    = new cInicial();  
$cAccion     = new cRol();       

include_once 'business/sys/check_session.php';

if( !isset($_SESSION[_is_view_] )){
    $_SESSION[_is_view_] = 1;
}

$type = $_SESSION[_is_view_];
$_SESSION[_type_] = $type;

$readOnly   = "";
$showInput  = "";
$frmName = "frmData";

$return_paginacion = "";
$requerido  = "";
$id = 0;
$id_rol = 0;
$rol = "";
$descripcion = "";

if ($_SESSION[_type_] == 2 || $_SESSION[_type_] == 3) {
    if (!isset($_SESSION[_editar_]) || !is_numeric($_SESSION[_editar_]) || $_SESSION[_editar_] <= 0) {
        $showinfo = false;
       
    } else {
        $id = $_SESSION[_editar_];

        $rsEditar    = $cAccion->getRegbyId($id);

        if ($rsEditar->rowCount() > 0) {
            $arrEdi = $rsEditar->fetch(PDO::FETCH_OBJ);

            $id_rol      = $arrEdi->id;
            $rol         = $arrEdi->rol;
            $descripcion = $arrEdi->descripcion;
            $activo      = $arrEdi->activo;
        

            if(!isset($pag)){ $pag=1;}
            if(!isset($busqueda) || $busqueda == ""){$busqueda = "";}
            $return_paginacion = "&pag=".$pag."&busqueda=".$busqueda;
        } else {
            $showinfo = false;
        }
    }
} 



if ($_SESSION[_is_view_] == 2) {
    $titulo_edi = "Editando";
    $showInput = "style='display: none'";
    $frmName = "frmUpdate";
    $requerido = "required";
}
if ($_SESSION[_is_view_] == 3) {
    $titulo_edi = "Visualizando";
    $readOnly = "disabled"; 
    $showInput = "style='display: none'";
    
}


?>
<!DOCTYPE html>
<html>
<head>
    <title><?php echo $titulo_curr?> | <?php echo $titulo_paginas?></title>
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
            <div class="section-body contain-lg">
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
                                <a href="<?php echo $param."index"?>">
                                    Lista de Roles
                                </a>
                            </li>
                            <li class="active">
                                <?php echo $titulo_curr?>
                            </li>
                        </ol>
                    </div>
                </div>
                <?php                //Verifica si el usuario puede insertar registros
                if($_SESSION[nuev] == "1") {
                    ?>
                    <div class="card">
                        <div class="card-head" style="background-color: #5F9EA0;">
                            <div class="tools pull-left">
                                <a class="btn ink-reaction btn-floating-action"
                                    style="background-color: #B0C4DE;" 
                                    href='<?php echo $param."index".$return_paginacion?>'
                                    title="Regresar a la lista">
                                    <i class="fa fa-arrow-left"></i>
                                </a>
                            </div>
                            <strong class="text-uppercase">
                                <?php echo $titulo_edi. " " .$titulo_curr?>
                            </strong>
                        </div>
                        <div class="card-body">
                            <form 
                                id="<?php echo $frmName?>"  
                                class="form"                                 
                                role="form" 
                                method="post">                                
                                <div class="row">
                                    <div class="col-xs-12 col-md-12 col-sm-12">
                                    <input type="hidden" name="current_file" id="current_file" value="<?php echo $param."index".$return_paginacion?>"/>                               
                                    <input type="hidden" name="id_rol" id="id_rol" value="<?php echo $id?>">
                                        <fieldset><legend>Datos de <?php echo $titulo_curr?></legend>
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <div class="form-group floating-label">
                                                        <input type="text" 
                                                            class="form-control" 
                                                            name="rol" 
                                                            id="rol" 
                                                            value="<?php echo $rol?>"
                                                            <?php echo $readOnly?>
                                                            required>
                                                        <label for="rol">
                                                            Nombre del Rol <span class="text-danger">*</span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group floating-label">
                                                        <input type="text" 
                                                            class="form-control" 
                                                            name="descripcion" 
                                                            id="descripcion" 
                                                            value="<?php echo $descripcion?>"
                                                            <?php echo $readOnly?>
                                                            required>
                                                        <label for="descripcion">
                                                            Descripción <span class="text-danger">*</span>
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
                                                                        <?php echo $readOnly?>
                                                                        title="Imprimir Registros">
                                                                    <b>Seleccionar todos</b>
                                                                </label>
                                                            </div>
                                                            <?php
                                                            $cAccion->setId($id_rol);
                                                            $rsRol           = $cAccion->parentsMenu();
                                                            while ($rowReg   = $rsRol->fetch(PDO::FETCH_OBJ)) {     
                                                                $chk = "";
                                                                $cAccion->setId_menu($rowReg->id_menu);
                                                                $checked_r  = $cAccion->checarRol_menu();
                                                                if ($checked_r->rowCount() > 0) {
                                                                    $chk = "checked";
                                                                }                                                          
                                                                ?>
                                                                <div id="<?php echo $rowReg->id_menu?>">
                                                                    <div class="checkbox checkbox-styled">
                                                                        <span   id="btn_mostrar_<?php echo $rowReg->id_menu?>" 
                                                                                class="btn-plus-ne mostrar" >
                                                                            <i class="fa fa-plus-square-o"></i>
                                                                        </span>
                                                                        <span id="btn_ocultar_<?php echo $rowReg->id_menu?>"                                                                               
                                                                                class="btn-plus-ne ocultar">
                                                                            <i class="fa fa-minus-square-o"></i>
                                                                        </span>
                                                                        <label>
                                                                            <input  name="menus[]" 
                                                                                    id="menu_<?php echo $rowReg->id_menu?>"
                                                                                    type="checkbox" 
                                                                                    <?php echo $chk?>
                                                                                    <?php echo $readOnly?>
                                                                                    value="<?php echo $rowReg->id_menu?>" 
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
                                                                $rsRol_c  = $cAccion->childsMenu($rowReg->id_menu);
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
                                                                            $chk_elim  = $rw_check->elim;
                                                                            $chk_exportar = $rw_check->exportar;
                                                                        }
                                                                        ?>
                                                                        <input type="hidden" id="grupo_m_<?php echo $rowReg_c->id_menu?>" 
                                                                                name="grupo[<?php echo $rowReg_c->id_menu?>]" 
                                                                                value="<?php echo $rowReg_c->id_grupo?>">
                                                                        <div class="checkbox checkbox-styled">
                                                                            <label class="separador-desc">
                                                                                <input name="menus[]" 
                                                                                        id="child_<?php echo $rowReg->id_menu?> _<?php echo $rowReg_c->id_menu?>" 
                                                                                        type="checkbox"
                                                                                        value="<?php echo $rowReg_c->id_menu?>" 
                                                                                        title="<?php echo $rowReg_c->texto?>"
                                                                                        <?php echo $chk_2 ?>
                                                                                        <?php echo $readOnly?>>
                                                                                <?php echo $rowReg_c->texto ?>
                                                                            </label>
                                                                            <label class="separador">
                                                                                <input type="checkbox" name="permiso_imp[<?php echo $rowReg_c->id_menu?>]" 
                                                                                        value="1" title="Imprimir" 
                                                                                        <?php echo $readOnly?>
                                                                                        id="permiso_imp<?php echo $rowReg_c->id_menu?>" 
                                                                                        <?php if($chk_imp == 1){ echo "checked";}?>>
                                                                                Imprimir
                                                                            </label>
                                                                            <label class="separador">
                                                                                <input type="checkbox" name="permiso_nuevo[<?php echo $rowReg_c->id_menu?>]" 
                                                                                        value="1" title="Nuevo" 
                                                                                        <?php echo $readOnly?>
                                                                                        id="permiso_nuevo<?php echo $rowReg_c->id_menu?>"
                                                                                        <?php if($chk_nuevo == 1){ echo "checked";}?>>
                                                                                Nuevo
                                                                            </label>
                                                                            <label class="separador">
                                                                                <input type="checkbox" name="permiso_edit[<?php echo $rowReg_c->id_menu?>]" 
                                                                                        value="1" title="Editar" 
                                                                                        <?php echo $readOnly?>
                                                                                        id="permiso_edit<?php echo $rowReg_c->id_menu?>"
                                                                                        <?php if($chk_edit == 1){ echo "checked";}?>>
                                                                                Editar
                                                                            </label>
                                                                            <label class="separador">
                                                                                <input type="checkbox" name="permiso_elim[<?php echo $rowReg_c->id_menu?>]" 
                                                                                        value="1" title="Eliminar" 
                                                                                        <?php echo $readOnly?>
                                                                                        id="permiso_elim<?php echo $rowReg_c->id_menu?>"
                                                                                        <?php if($chk_elim == 1){ echo "checked";}?>>
                                                                                Eliminar
                                                                            </label>
                                                                            <label class="separador">
                                                                                <input type="checkbox" name="permiso_exportar[<?php echo $rowReg_c->id_menu?>]" 
                                                                                        value="1" title="Exportar" 
                                                                                        <?php echo $readOnly?>
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
                                                            ?>
                                                        </div>
                                                    </article>
                                                </div>
                                            </div>
                                        </fieldset>
                                        <?php 
                                        if ($_SESSION[_is_view_] == 1 || $_SESSION[_is_view_] == 2) {
                                        ?>
                                        <fieldset><br>
                                            <div class="row">
                                                <div class="col-sm-12 col-md-4 col-xs-12 col-lg-4">
                                                    <button type="submit" id="btn_guardar"
                                                        style="background-color: #B0C4DE;" 
                                                        class="btn ink-reaction btn-block">
                                                        <span class="glyphicon glyphicon-floppy-disk"></span> 
                                                        Guardar Cambios
                                                    </button>
                                                </div>
                                            </div>
                                        </fieldset>
                                        <?php 
                                        }
                                        ?>
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
