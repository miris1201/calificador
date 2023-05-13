<?php
/*--------------------------------------------------------------------------------------------------------*/
$dir_fc       = "";
include_once $dir_fc.'connections/trop.php';
include_once $dir_fc.'connections/php_config.php';

$sys_id_men   = 2;
$sys_tipo     = 2; //Editar

extract($_REQUEST);

$current_file = basename($_SERVER["PHP_SELF"]);
$dir          = dirname($_SERVER['PHP_SELF'])."/".$controller;
$checkMenu    = $server_name.$dir."/";   
$param        = "?controller=".$controller."&action=";

$ruta_app     = "";
$titulo_curr  = "Usuario";
$real_sis     = "sis_usuarios";

include_once $dir_fc.'data/inicial.class.php';
include_once $dir_fc.'data/rol.class.php';
include_once $dir_fc.'data/users.class.php';
include_once $dir_fc.'common/function.class.php';

$cInicial   = new cInicial();  
$cRoles     = new cRol();       
$cAccion    = new cUsers();
$cFn      = new cFunction();

include_once 'business/sys/check_session.php'; 

$showinfo    = true;
$id_usuario  = "";
$id_rol      = "";
$usuario     = "";
$sexo        = "";
$nombre      = "";
$apepa       = "";
$apema       = "";
$correo      = "";
$imp         = "";
$edit        = "";
$elim        = "";
$nuev        = "";
$activo      = "";
$admin       = "";
$titulo_edi  = "Visualizando";
$arreglo     = array();

if(!isset($pag)){ $pag=1;}
if(!isset($busqueda) || $busqueda == ""){$busqueda = "";}

$return_paginacion = "&pag=".$pag."&busqueda=".$busqueda;

if(!isset($_SESSION[_editar_]) || !is_numeric($_SESSION[_editar_]) || $_SESSION[_editar_]<= 0){
    $showinfo = false;
}else{
    $id          = $_SESSION[_editar_];
    $cAccion->setId_usuario($id);
    $rsEditar    = $cAccion->getRegbyid();

    if($rsEditar->rowCount() > 0){
        $arrEdi         = $rsEditar->fetch(PDO::FETCH_OBJ);
        $id_usuario     = $arrEdi->id_usuario;
        $id_rol         = $arrEdi->id_rol;
        $usuario        = $arrEdi->usuario;
        $sexo           = $arrEdi->sexo;
        $nombre         = $arrEdi->nombre;
        $apepa          = $arrEdi->apepa;
        $apema          = $arrEdi->apema;
        $correo         = $arrEdi->correo;
        $imp            = $arrEdi->imp;
        $edit           = $arrEdi->edit;
        $elim           = $arrEdi->elim;
        $nuev           = $arrEdi->nuev;
        $activo         = $arrEdi->activo;
        $admin          = $arrEdi->admin;


    } else {
        $showinfo = false;

    }
}

if($_SESSION[_is_view_] == 1){
    $titulo_edi = "Editando";
}

$arrayModulo = $cAccion->getArrayModulo();

?>
<!DOCTYPE html>
<html>
<head>
    <title><?php echo $titulo_edi." ".$titulo_curr?> | <?php echo $titulo_paginas?></title>
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
        <section>
            <div class="section-body">
                <div class="row">
                    <div class="col-lg-8">
                        <h1 class="text-primary main-title">
                            <?php echo $titulo_edi. " " .$titulo_curr?> 
                        </h1>
                    </div>
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
                                <?php echo $titulo_edi?>
                            </li>
                        </ol>
                    </div>
                </div>
                <?php
                if($_SESSION[edit] == "1" && $showinfo == true) { ?>
                    <div class="card">                        
                        <div class="card-head style-accent-bright">
                            <div class="tools pull-left">
                                <a class="btn ink-reaction btn-floating-action btn-accent-light"
                                   href='<?php echo $param."index".$return_paginacion?>' 
                                   title="Regresar a la lista">
                                    <i class="fa fa-arrow-left"></i>
                                </a>
                            </div>                            
                        </div>
                        <div class="card-body">
                            <form id="frmUpdateUser" 
                                class="form" 
                                role="form" 
                                method="post">
                                <div class="row">
                                    <div class="col-xs-12 col-md-12 col-sm-12">
                                        <input type="hidden" name="current_file" id="current_file" value="<?php echo $param?>"/>
                                        <input type="hidden" name="id_usuario" id="id_usuario" value="<?php echo $id?>"/>
                                        <fieldset><legend>Datos de <?php echo $titulo_curr?></legend>
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <input type="text" 
                                                                class="form-control" 
                                                                name="nombre" 
                                                                id="nombre" 
                                                                autocomplete="off"
                                                                style="text-transform: capitalize;"
                                                                required 
                                                                value="<?php echo $nombre ?>">
                                                        <label for="nombre">Nombre(s)
                                                            <span class="text-danger">*</span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <input type="text" 
                                                        class="form-control" 
                                                               name="apepat" id="apepat" 
                                                               autocomplete="off"
                                                               value="<?php echo $apepa?>"
                                                               style="text-transform: capitalize;">
                                                        <label for="apepat">Apellido Paterno 
                                                            <span class="text-danger">*</span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" 
                                                                name="apemat" id="apemat" autocomplete="off"
                                                               value="<?php echo $apema?>"
                                                               style="text-transform: capitalize;">
                                                        <label for="apemat">Apellido Materno 
                                                            <span class="text-danger">*</span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" 
                                                                name="usuario" id="usuario" autocomplete="off"
                                                               required value="<?php echo $usuario?>">
                                                        <label for="usuario">Nombre de Usuario 
                                                            <span class="text-danger">*</span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <input type="email" class="form-control" name="correo" id="correo"
                                                               autocomplete="off" value="<?php echo $correo?>">
                                                        <label for="correo">Correo electrónico</label>
                                                    </div>
                                                </div>
                                            </div>                                            
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <select name="sexo" id="sexo" class="form-control" required>
                                                            <option value=""></option>
                                                            <option value="1" <?php if ($sexo == 1) { echo "selected";} ?>>
                                                                Masculino
                                                            </option>
                                                            <option value="2" <?php if ($sexo == 2) { echo "selected";} ?>>
                                                                Femenino
                                                            </option>
                                                        </select>
                                                        <label for="sexo">Género: 
                                                            <span class="text-danger">*</span>
                                                        </label>
                                                    </div>
                                                </div>                                              
                                            </div>
                                            <div class="row">
                                                <?php
                                                if(isset($_SESSION[admin]) && $_SESSION[admin] == 1){
                                                    ?>
                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <select name="admin" id="admin" class="form-control" required>
                                                                <option value=""></option>
                                                                <option value="0" <?php if($admin == 0) echo "selected" ?>>Usuario Estándar</option>
                                                                <option value="1" <?php if($admin == 1) echo "selected" ?>>Usuario Administrativo</option>
                                                            </select>
                                                            <label for="admin">Tipo de usuario <span class="text-danger">*</span></label>
                                                        </div>
                                                    </div>
                                                    <?php
                                                }
                                                ?>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                    <input type="hidden" id="rol_sel" name="rol_sel" value="<?php echo $id_rol?>">
                                                        <select name="id_rol" id="id_rol" 
                                                            class="form-control" required>
                                                            <option value=""></option>
                                                            <?php
                                                            $rsRol = $cRoles->getAllRoles();
                                                            while($rw_rol = $rsRol->fetch(PDO::FETCH_OBJ)){
                                                                $sel = "";
                                                                if ($rw_rol->id == $id_rol) {
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
                                        <fieldset>
                                            <legend>Prefiles</legend>
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
                                                                    title="Imprimir Registros">
                                                                <b>Seleccionar todos</b>
                                                            </label>
                                                        </div>
                                                        <div id="permisos_ajax">
                                                            <?php
                                                            $cRoles->setId($id_rol);
                                                            $rsRol           = $cRoles->parentsMenu();
                                                            $totalRows_rsRol = $rsRol->rowCount();
                                                            while ($rowReg   = $rsRol->fetch(PDO::FETCH_OBJ)) {
                                                            $chk = "";
                                                            $cAccion->setId_menu($rowReg->id);
                                                            $checked_r  = $cAccion->checarMenuUser();
                                                            if ($checked_r->rowCount() > 0) {
                                                                $chk = "checked";
                                                            }
                                                            ?>
                                                            <div id="<?php echo $rowReg->id?>">
                                                                <div class="checkbox checkbox-styled">
                                                                    <span id="btn_mostrar_<?php echo $rowReg->id?>" 
                                                                            class="btn-plus-ne mostrar"> 
                                                                            <i class="fa fa-plus-square-o"></i>
                                                                    </span>
                                                                    <span id="btn_ocultar_<?php echo $rowReg->id?>" 
                                                                            class="btn-plus-ne ocultar"> 
                                                                          <i class="fa fa-minus-square-o"></i>
                                                                    </span>
                                                                    <label>
                                                                        <input name="menus[]" id="menu_<?php echo $rowReg->id?>" 
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
                                                            $rsRol_c  = $cRoles->childsMenu($rowReg->id);
                                                            ?>
                                                            <div id="child-menu_<?php echo $rowReg->id?>" class="child-menu">
                                                                <?php
                                                                while ($rowReg_c = $rsRol_c->fetch(PDO::FETCH_OBJ)) {
                                                                    $chk_imp     = "";
                                                                    $chk_edit    = "";
                                                                    $chk_nuevo   = "";
                                                                    $chk_elim    = "";
                                                                    $chk_exportar= "";
                                                                    $chk_2 = "";
                                                                    $cAccion->setId_menu($rowReg_c->id);
                                                                    $checked_r_2 = $cAccion->checarMenuUser();
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
                                                                            id="grupo_m_<?php echo $rowReg_c->id?>" 
                                                                            name="grupo[<?php echo $rowReg_c->id?>]" 
                                                                            value="<?php echo $rowReg_c->id_grupo?>">
                                                                    <div class="checkbox checkbox-styled">
                                                                        <label class="separador-desc">
                                                                            <input name="menus[]" 
                                                                                   id="child_<?php echo $rowReg->id?> _<?php echo $rowReg_c->id?>" 
                                                                                   type="checkbox"
                                                                                   value="<?php echo $rowReg_c->id?>"
                                                                                   title="<?php echo $rowReg_c->texto?>" <?php echo $chk_2 ?>>
                                                                            <?php echo  $rowReg_c->texto ?>
                                                                        </label>
                                                                        <label class="separador">
                                                                            <input type="checkbox" 
                                                                                   name="permiso_imp[<?php echo $rowReg_c->id?>]" value="1"
                                                                                   title="Imprimir" id="permiso_imp<?php echo $rowReg_c->id?>" 
                                                                                   <?php if($chk_imp == 1){ echo "checked";}?>>
                                                                             Imprimir
                                                                        </label>
                                                                        <label class="separador">
                                                                            <input type="checkbox" 
                                                                                   name="permiso_nuevo[<?php echo $rowReg_c->id?>]" value="1"
                                                                                   title="Nuevo" id="permiso_nuevo<?php echo $rowReg_c->id?>" 
                                                                                   <?php if($chk_nuevo == 1){ echo "checked";}?>>
                                                                            Nuevo
                                                                        </label>
                                                                        <label class="separador">
                                                                            <input type="checkbox" 
                                                                                   name="permiso_edit[<?php echo $rowReg_c->id?>]" value="1"
                                                                                   title="Editar" id="permiso_edit<?php echo $rowReg_c->id?>" 
                                                                                   <?php if($chk_edit == 1){ echo "checked";}?>>
                                                                            Editar
                                                                        </label>
                                                                        <label class="separador">
                                                                            <input type="checkbox" 
                                                                                   name="permiso_elim[<?php echo $rowReg_c->id?>]" value="1"
                                                                                   title="Eliminar" id="permiso_elim<?php echo $rowReg_c->id?>" 
                                                                                   <?php if($chk_elim == 1){ echo "checked";}?>>
                                                                            Eliminar
                                                                        </label>
                                                                        <label class="separador">
                                                                            <input type="checkbox" 
                                                                                   name="permiso_exportar[<?php echo $rowReg_c->id?>]" value="1"
                                                                                   title="Exportar" id="permiso_exportar<?php echo $rowReg_c->id?>" 
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
                                                    </div>
                                                </div>
                                            </article>
                                        </fieldset><br>
                                        <fieldset>
                                            <?php
                                            if($_SESSION[_is_view_] == 1){ //Si es editar
                                                ?>
                                                <div class="row">
                                                    <div class="col-sm-12 col-md-4 col-xs-12 col-lg-4">
                                                        <button type="submit" 
                                                                class="btn ink-reaction btn-block btn-primary" 
                                                                id="btn_guardar">
                                                            <i class="fa fa-save"></i> Guardar Cambios
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
                    include("business/sys/permissions_d.php");
                }?>
            </div>
        </section>
    </div>
    <?php include($dir_fc."inc/menucommon.php") ?>
</div>
<?php include("dist/components/users.magnament.php"); ?>
<script src="dist/assets/js/select2.full.min.js"></script>
</body>
</html>
