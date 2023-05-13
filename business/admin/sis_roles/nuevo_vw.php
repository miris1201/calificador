<?php
/*--------------------------------------------------------------------------------------------------------*/
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
$titulo_curr  = "Rol"; 

include_once $dir_fc.'data/inicial.class.php';
include_once $dir_fc.'data/rol.class.php';

$cInicial    = new cInicial();  
$cEditar     = new cRol();       

include_once 'business/sys/check_session.php';


?>
<!DOCTYPE html>
<html>
<head>
    <title>Nuveo <?php echo $titulo_curr?> | <?php echo $titulo_paginas?></title>
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
                                <a href="<?php echo $param."index"?>">
                                    Lista de Roles
                                </a>
                            </li>
                            <li class="active">
                                Nuevo <?php echo $titulo_curr?>
                            </li>
                        </ol>
                    </div>
                </div>
                <?php                //Verifica si el usuario puede insertar registros
                if($_SESSION[nuev] == "1") {
                    ?>
                    <div class="card">
                        <div class="card-head style-accent-bright">
                            <div class="tools pull-left">
                                <a class="btn ink-reaction btn-floating-action btn-accent-bright"
                                   href='<?php echo $param."index"?>'  
                                   title="Regresar a la lista">
                                    <i class="fa fa-arrow-left"></i>
                                </a>
                            </div>
                            <b class="text-uppercase">
                                CREANDO NUEVA INFORMACIÓN DE <?php echo $titulo_curr?>
                            </b>
                        </div>
                        <div class="card-body">
                            <form 
                                id="frmAddRole" 
                                class="form"                                 
                                role="form" 
                                method="post">                                
                                <div class="row">
                                    <div class="col-xs-12 col-md-12 col-sm-12">
                                        <input type="hidden" name="current_file" id="current_file" value="<?php echo $param?>"/>
                                        <fieldset><legend>Datos de <?php echo $titulo_curr?></legend>
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <div class="form-group floating-label">
                                                        <input  type="text" 
                                                                class="form-control" 
                                                                name="rol" id="rol" 
                                                                required>
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
                                                                required>
                                                        <label for="descripcion">
                                                            Descripción hhh
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
                                                                                    value="<?php echo $rowReg->id?>" 
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
                                                                      
                                                                        ?>
                                                                        <input type="hidden" id="grupo_m_<?php echo $rowReg_c->id?>" 
                                                                                name="grupo[<?php echo $rowReg_c->id?>]" 
                                                                                value="<?php echo $rowReg_c->id_grupo?>">
                                                                        <div class="checkbox checkbox-styled">
                                                                            <label class="separador-desc">
                                                                                <input name="menus[]" id="child_<?php echo $rowReg->id?> _<?php echo $rowReg_c->id?>" 
                                                                                        type="checkbox"
                                                                                        value="<?php echo $rowReg_c->id?>" title="<?php echo $rowReg_c->texto?>">
                                                                                <?php echo $rowReg_c->texto ?>
                                                                            </label>
                                                                            <label class="separador">
                                                                                <input type="checkbox" name="permiso_imp[<?php echo $rowReg_c->id?>]" 
                                                                                        value="1" title="Editar" 
                                                                                        id="permiso_imp<?php echo $rowReg_c->id?>" >
                                                                                Imprimir
                                                                            </label>
                                                                            <label class="separador">
                                                                                <input type="checkbox" name="permiso_nuevo[<?php echo $rowReg_c->id?>]" 
                                                                                        value="1" title="Editar" 
                                                                                        id="permiso_nuevo<?php echo $rowReg_c->id?>">
                                                                                Nuevo
                                                                            </label>
                                                                            <label class="separador">
                                                                                <input type="checkbox" name="permiso_edit[<?php echo $rowReg_c->id?>]" 
                                                                                        value="1" title="Editar" 
                                                                                        id="permiso_edit<?php echo $rowReg_c->id?>">
                                                                                Editar
                                                                            </label>
                                                                            <label class="separador">
                                                                                <input type="checkbox" name="permiso_elim[<?php echo $rowReg_c->id?>]" 
                                                                                        value="1" title="Editar" 
                                                                                        id="permiso_elim<?php echo $rowReg_c->id?>">
                                                                                Eliminar
                                                                            </label>
                                                                            <label class="separador">
                                                                                <input type="checkbox" name="permiso_exportar[<?php echo $rowReg_c->id?>]" 
                                                                                        value="1" title="Editar" 
                                                                                        id="permiso_exportar<?php echo $rowReg_c->id?>">
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
                                            <div class="row">
                                                <div class="col-sm-12 col-md-4 col-xs-12 col-lg-4">
                                                    <button type="submit" id="btn_guardar"
                                                        class="btn ink-reaction btn-block btn-primary">
                                                        <span class="glyphicon glyphicon-floppy-disk"></span> 
                                                        Guardar Cambios
                                                    </button>
                                                </div>
                                            </div>
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
