<?php

$dir_fc       = "";
include_once $dir_fc.'connections/trop.php';
include_once $dir_fc.'connections/php_config.php';

$sys_id_men   = 2;
$sys_tipo     = 1;

extract($_REQUEST);

$current_file = basename($_SERVER["PHP_SELF"]);
$dir          = dirname($_SERVER['PHP_SELF'])."/".$controller;
$checkMenu    = $server_name.$dir."/";
$param        = "?controller=".$controller."&action=";

$ruta_app     = "";
$titulo_edi  = "Nuevo";
$titulo_curr  = "Usuario";

include_once $dir_fc.'data/inicial.class.php';
include_once $dir_fc.'data/rol.class.php';
include_once $dir_fc.'data/users.class.php';

$cInicial   = new cInicial();
$cRoles     = new cRol();
$cAccion    = new cUsers();

include_once 'business/sys/check_session.php';


if( !isset($_SESSION[_is_view_] )){
    $_SESSION[_is_view_] = 1;
}

$type = $_SESSION[_is_view_];
$_SESSION[_type_] = $type;


$id = 0;
$id_usuario = "";
$id_rol     = "";
$empleado   = "";
$usuario    = "";
$nombre     = "";
$apepa      = "";
$apema      = "";
$imp        = "";
$edit       = "";
$elim       = "";
$nuev       = "";
$img        = "";
$admin      = "";
$activo     = "";


$readOnly   = "";
$showInput  = "";
$frmName    = "frmData";


$id_zona    = 0;
$id_turno   = 0;
$return_paginacion = "";
$requerido  = "";


if ($_SESSION[_type_] == 2 || $_SESSION[_type_] == 3) {
    if (!isset($_SESSION[_editar_]) || !is_numeric($_SESSION[_editar_]) || $_SESSION[_editar_] <= 0) {
        $showinfo = false;
       
    } else {
        $id = $_SESSION[_editar_];
       
        $cAccion->setId_usuario($id);
        $rsEditar    = $cAccion->getRegbyId($id);

        if ($rsEditar->rowCount() > 0) {
            $arrEdi = $rsEditar->fetch(PDO::FETCH_OBJ);

            $id_usuario = $arrEdi->id_usuario;
            $id_rol     = $arrEdi->id_rol;
            $id_zona    = $arrEdi->id_zona;
            $usuario    = $arrEdi->usuario;
            $nombre     = $arrEdi->nombre;
            $apepa      = $arrEdi->apepa;
            $apema      = $arrEdi->apema;
            $admin      = $arrEdi->admin;
            $activo     = $arrEdi->activo;

            
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
    <title><?php echo $titulo_edi. " " .$titulo_curr?> | <?php echo $titulo_paginas?></title>
    <meta content="" name="description"/>
    <meta content="" name="author"/>
    <?php include("dist/inc/headercommon.php"); ?>
    <link rel="stylesheet" type="text/css" href="dist/assets/css/select2.min.css?v=1.001">
</head>
<body class="<?php echo _BODY_STYLE_ ?> ">
<?php include ($dir_fc."inc/header.php")?>
<div id="base">
    <div class="offcanvas"></div>
    <div id="content">
        <section class="section-body contain-lg">
            <div class="row">
                <div class="col-lg-8">
                </div>
                <div class="col-lg-4">
                    <ol class="breadcrumb pull-right">
                        <li>
                            <a href="<?php echo $raiz?>business/">
                                Inicio
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo $param."index"?>">
                                Lista de <?php echo $titulo_curr?>
                            </a>
                        </li>
                        <li class="active">
                            <?php echo $titulo_edi. " " .$titulo_curr?>
                        </li>
                    </ol>
                </div>
            </div>
            <?php
            if($_SESSION[nuev] == "1") {
            ?>
            <div class="card">
                <div class="card-head" style="background-color: #5F9EA0;">
                    <div class="tools pull-left">
                        <a 
                            class="btn ink-reaction btn-floating-action" 
                            href='<?php echo $param."index".$return_paginacion?>' 
                            style="background-color: #B0C4DE;"
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
                        method="post" >
                        <input type="hidden" name="current_file" id="current_file" value="<?php echo $param."index".$return_paginacion?>"/>  
                        <input type="hidden" name="id_usuario" id="id_usuario" value="<?php echo $id?>">
                        <div class="row">
                            <div class="col-xs-12 col-md-12 col-sm-12">
                                <fieldset>
                                    <legend>Datos de <?php echo $titulo_curr?></legend>
                                    <div class="row form-group">
                                        <div class="col-sm-4">
                                            <div class="form-group floating-label">
                                                <input 
                                                    type="text" 
                                                    class="form-control"
                                                    name="nombre"
                                                    id="nombre"
                                                    autocomplete="off"
                                                    style="text-transform: capitalize;"
                                                    required
                                                    value="<?php echo $nombre?>"
                                                    <?php echo $readOnly?>>
                                                <label 
                                                    for="nombre">
                                                    Nombre(s)<span class="text-danger">*</span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group floating-label">
                                                <input type="text" class="form-control" 
                                                       name="apepat" id="apepat" 
                                                       style="text-transform: capitalize;"
                                                       autocomplete="off"
                                                       value="<?php echo $apepa?>"
                                                       <?php echo $readOnly?>>
                                                <label for="apepat">Apellido Paterno 
                                                    <span class="text-danger">*</span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group floating-label">
                                                <input type="text" class="form-control" 
                                                        name="apemat" id="apemat"
                                                        style="text-transform: capitalize;" 
                                                        autocomplete="off"
                                                        value="<?php echo $apema?>"
                                                        <?php echo $readOnly?>>
                                                <label for="apemat">Apellido Materno 
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-sm-3">
                                            <div class="form-group floating-label">
                                                <input type="text" class="form-control" 
                                                        name="usuario" id="usuario" 
                                                        autocomplete="off" 
                                                        required
                                                        value="<?php echo $usuario?>"
                                                        <?php echo $readOnly?>>
                                                <label for="usuario">Nombre de Usuario 
                                                    <span class="text-danger">*</span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-sm-3" <?php echo $showInput?>>
                                            <div class="form-group floating-label">
                                                <input type="password" class="form-control"
                                                        name="clave" id="clave"
                                                        autocomplete="off"
                                                        <?php echo $readOnly?>>
                                                <label for="clave">Password (clave de acceso)
                                                    <span class="text-danger">*</span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group floating-label">
                                                <select name="id_zona" id="id_zona" <?php echo $readOnly?>
                                                    class="form-control" required>
                                                    <option value=""></option>
                                                    <option value="1"  <?php if ($id_zona == 1) { echo "selected";} ?>>Poniente</option>
                                                    <option value="2"  <?php if ($id_zona == 2) { echo "selected";} ?>>Oriente</option>                                                   
                                                </select>
                                                <label for="id_zona">Zona 
                                                    <span class="text-danger">*</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row form-group">                                        
                                        <?php
                                        if(isset($_SESSION[admin]) && $_SESSION[admin] == 1){
                                            ?>
                                            <div class="col-sm-4">
                                                <div class="form-group floating-label">
                                                    <select name="admin" id="admin" <?php echo $readOnly?>
                                                        class="form-control" required>
                                                        <option value=""></option>
                                                        <option value="0"  <?php if ($admin == 0) { echo "selected";} ?>>Usuario Estándar</option>
                                                        <option value="1"  <?php if ($admin == 1) { echo "selected";} ?>>Usuario Administrativo</option>
                                                    </select>
                                                    <label for="admin">Tipo de usuario 
                                                        <span class="text-danger">*</span>
                                                    </label>
                                                </div>
                                            </div>
                                            <?php
                                        }  
                                        ?>                                        
                                        <div class="col-md-4">
                                            <div class="form-group floating-label">
                                                <select name="id_rol" id="id_rol" <?php echo $readOnly?>
                                                    class="form-control rol" required>
                                                    <option value=""></option>
                                                    <?php
                                                    $rs_rol = $cRoles->getAllRoles();
                                                    while($rw_rol = $rs_rol->fetch(PDO::FETCH_OBJ)){
                                                        $sel = "";
                                                        if ($id_rol == $rw_rol->id) {
                                                            $sel = "selected";
                                                        }
                                                        ?>
                                                        <option value="<?php echo $rw_rol->id?>" <?php echo $sel?>>
                                                            <?php echo $rw_rol->rol." - ".$rw_rol->descripcion?>
                                                        </option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                                <label for="id_rol">Perfil: 
                                                    <span class="text-danger">*</span>
                                                </label>
                                            </div>
                                        </div> 
                                    </div>
                                </fieldset>
                                <br>
                                <fieldset>
                                    <legend>Permisos</legend>
                                    <article id="permisos">
                                        <div class="row">
                                            <div class="permisos-field">
                                                <div class="checkbox checkbox-styled">
                                                    <label>
                                                        <input 
                                                            name="ckSelectAll" 
                                                            id="ckSelectAll" 
                                                            type="checkbox" 
                                                            value="1" 
                                                            title="Imprimir Registros"
                                                            <?php echo $readOnly?>>
                                                        <b>Seleccionar todos</b>
                                                    </label>
                                                </div>
                                                <div id="permisos_ajax">
                                                    <?php
                                                    if ($id > 0) {
                                                        $cRoles->setId($id_rol);
                                                        $rsRol           = $cRoles->parentsMenu();
                                                        while ($rowReg   = $rsRol->fetch(PDO::FETCH_OBJ)) {
                                                        $chk = "";
                                                        $cAccion->setId_menu($rowReg->id_menu);
                                                        $checked_r  = $cAccion->checarMenuUser();
                                                        if ($checked_r->rowCount() > 0) {
                                                            $chk = "checked";
                                                        }
                                                        ?>
                                                        <div id="<?php echo $rowReg->id_menu?>" class="parents-menu_<?php echo $rowReg->id_menu?>">
                                                            <div class="checkbox">
                                                                <span id="mostrar_<?php echo $rowReg->id_menu?>" 
                                                                        class="btn-plus-ne mostrar" > 
                                                                        <i class="fa fa-plus-square-o"></i>
                                                                </span>
                                                                <span id="ocultar_<?php echo $rowReg->id_menu?>" 
                                                                        class="btn-plus-ne ocultar"> 
                                                                    <i class="fa fa-minus-square-o"></i>
                                                                </span>
                                                                <label> <input name="menus[]" id="menu_<?php echo $rowReg->id_menu?>" 
                                                                        type="checkbox" <?php echo $readOnly?>
                                                                        value="<?php echo $rowReg->id_menu?>" <?php echo $chk ?>
                                                                        title="<?php echo $rowReg->texto?>"> <?php echo $rowReg->texto ?>
                                                                </label>
                                                            </div>
                                                            <input type="hidden" 
                                                                id="grupo_m_<?php echo $rowReg->id_menu?>" 
                                                                name="grupo[<?php echo $rowReg->id_menu?>]"
                                                                value="<?php echo $rowReg->id_grupo?>">
                                                        </div>
                                                        <?php $rsRol_c  = $cRoles->childsMenu($rowReg->id_menu); ?>
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
                                                                $checked_r_2 = $cAccion->checarMenuUser();
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
                                                                <input type="hidden" 
                                                                        id="grupo_m_<?php echo $rowReg_c->id_menu?>" 
                                                                        name="grupo[<?php echo $rowReg_c->id_menu?>]" 
                                                                        value="<?php echo $rowReg_c->id_grupo?>">
                                                                <div class="checkbox">
                                                                    <label class="separador-desc">
                                                                        <input name="menus[]" 
                                                                            id="child_<?php echo $rowReg->id_menu?> _<?php echo $rowReg_c->id_menu?>" 
                                                                            type="checkbox"
                                                                            value="<?php echo $rowReg_c->id_menu?>" 
                                                                            title="<?php echo $rowReg_c->texto?>" 
                                                                            <?php echo $chk_2 ?> <?php echo $readOnly?>>
                                                                            <?php echo $rowReg_c->texto ?>
                                                                    </label>
                                                                    <label class="separador">
                                                                        <input type="checkbox" 
                                                                            name="permiso_imp[<?php echo $rowReg_c->id_menu?>]" value="1"
                                                                            title="Imprimir" id="permiso_imp<?php echo $rowReg_c->id_menu?>"
                                                                            <?php echo $readOnly?> 
                                                                            <?php if($chk_imp == 1){ echo "checked";}?>>
                                                                        Imprimir
                                                                    </label>
                                                                    <label class="separador">
                                                                        <input type="checkbox" 
                                                                            name="permiso_nuevo[<?php echo $rowReg_c->id_menu?>]" value="1"
                                                                            title="Nuevo" id="permiso_nuevo<?php echo $rowReg_c->id_menu?>"
                                                                            <?php echo $readOnly?> 
                                                                            <?php if($chk_nuevo == 1){ echo "checked";}?>>
                                                                        Nuevo
                                                                    </label>
                                                                    <label class="separador">
                                                                        <input type="checkbox" 
                                                                            name="permiso_edit[<?php echo $rowReg_c->id_menu?>]" value="1"
                                                                            title="Editar" id="permiso_edit<?php echo $rowReg_c->id_menu?>" 
                                                                            <?php echo $readOnly?>
                                                                            <?php if($chk_edit == 1){ echo "checked";}?>>
                                                                        Editar
                                                                    </label>
                                                                    <label class="separador">
                                                                        <input type="checkbox" 
                                                                            name="permiso_elim[<?php echo $rowReg_c->id_menu?>]" value="1"
                                                                            title="Eliminar" id="permiso_elim<?php echo $rowReg_c->id_menu?>"
                                                                            <?php echo $readOnly?> 
                                                                            <?php if($chk_elim == 1){ echo "checked";}?>>
                                                                        Eliminar
                                                                    </label>
                                                                    <label class="separador">
                                                                        <input type="checkbox" 
                                                                            name="permiso_exportar[<?php echo $rowReg_c->id_menu?>]" value="1"
                                                                            title="Exportar" id="permiso_exportar<?php echo $rowReg_c->id_menu?>" 
                                                                            <?php echo $readOnly?>
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
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                    </article>
                                </fieldset>
                                <?php 
                                    if ($_SESSION[_is_view_] == 1 || $_SESSION[_is_view_] == 2) {
                                ?>
                                <fieldset> <br>
                                    <div class="row">
                                        <div class="col-sm-12 col-md-4 col-xs-12 col-lg-4">
                                            <button 
                                                type="submit" 
                                                class="btn ink-reaction btn-block"
                                                style="background-color: #B0C4DE;" 
                                                id="btn_guardar">
                                                <strong>
                                                <span class="glyphicon glyphicon-floppy-disk"></span>
                                                Guardar </strong>
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
            } else {
                include("../../sys/permissions_d.php");
            }?>
        </section>
    </div>
    <?php include($dir_fc."inc/menucommon.php") ?>
</div>
<?php include("dist/components/users.magnament.php"); ?>
<script src="dist/assets/js/select2.full.min.js"></script>
</body>
</html>
