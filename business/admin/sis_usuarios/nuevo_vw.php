<?php
/*--------------------------------------------------------------------------------------------------------*/
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
$real_sis     = "sis_usuarios";
$titulo_curr  = "Usuario";

include_once $dir_fc.'data/inicial.class.php';
include_once $dir_fc.'data/rol.class.php';
include_once $dir_fc.'data/users.class.php';

$cInicial   = new cInicial();
$cRoles     = new cRol();
$cNuevo     = new cUsers();

include_once 'business/sys/check_session.php';

$arrayModulo = $cNuevo->getArrayModulo();

?>
<!DOCTYPE html>
<html>
<head>
    <title>Nuevo <?php echo $titulo_curr?> | <?php echo $titulo_paginas?></title>
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
        <section class="section-body">
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
                            Nuevo <?php echo $titulo_curr?>
                        </li>
                    </ol>
                </div>
            </div>
            <?php
            if($_SESSION[nuev] == "1") {
            ?>
            <div class="card">
                <div class="card-head style-accent-bright">
                    <div class="tools pull-left">
                        <a 
                            class="btn ink-reaction btn-floating-action btn-accent-light" 
                            href='<?php echo $param."index"?>' title="Regresar a la lista">
                            <i class="fa fa-arrow-left"></i>
                        </a>
                    </div>
                    <strong class="text-uppercase">
                        CREANDO NUEVO <?php echo $titulo_curr?>
                    </strong>
                </div>
                <div class="card-body">
                    <form 
                        id="frmAddUser" 
                        class="form" 
                        role="form" 
                        method="post" >
                        <input type="hidden" name="current_file" id="current_file" value="<?php echo $param?>"/>
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
                                                    required>
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
                                                       autocomplete="off">
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
                                                        autocomplete="off">
                                                <label for="apemat">Apellido Materno 
                                                    <span class="text-danger">*</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-sm-4">
                                            <div class="form-group floating-label">
                                                <input type="text" class="form-control" 
                                                        name="usuario" id="usuario" 
                                                        autocomplete="off" 
                                                        required>
                                                <label for="usuario">Nombre de Usuario 
                                                    <span class="text-danger">*</span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group floating-label">
                                                <input type="password" class="form-control"
                                                        name="clave" id="clave"
                                                        autocomplete="off"
                                                        required>
                                                <label for="clave">Password (clave de acceso)
                                                    <span class="text-danger">*</span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group floating-label">
                                                <input type="email" class="form-control" 
                                                        name="correo" id="correo"
                                                        autocomplete="off">
                                                <label for="correo">Correo electrónico </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-sm-4">
                                            <div class="form-group floating-label">
                                                <select name="sexo" id="sexo"
                                                    class="form-control" required>
                                                    <option value=""></option>
                                                    <option value="1">Masculino</option>
                                                    <option value="2">Femenino</option>
                                                </select>
                                                <label for="sexo">Género: 
                                                    <span class="text-danger">*</span>
                                                </label>
                                            </div>
                                        </div>
                                        <?php
                                        if(isset($_SESSION[admin]) && $_SESSION[admin] == 1){
                                            ?>
                                            <div class="col-sm-4">
                                                <div class="form-group floating-label">
                                                    <select name="admin" id="admin" 
                                                        class="form-control" required>
                                                        <option value=""></option>
                                                        <option value="0">Usuario Estándar</option>
                                                        <option value="1">Usuario Administrativo</option>
                                                    </select>
                                                    <label for="admin">Tipo de usuario 
                                                        <span class="text-danger">*</span>
                                                    </label>
                                                </div>
                                            </div>
                                            <?php
                                        }  
                                        ?>
                                    </div>
                                    <br>
                                    <div class="row">
                                        
                                        <div class="col-md-4">
                                            <div class="form-group floating-label">
                                                <select name="id_rol" id="id_rol" 
                                                    class="form-control rol" required>
                                                    <option value=""></option>
                                                    <?php
                                                    $rs_rol = $cRoles->getAllRoles();
                                                    while($rw_rol = $rs_rol->fetch(PDO::FETCH_OBJ)){
                                                        ?>
                                                        <option value="<?php echo $rw_rol->id?>">
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
                                                            title="Imprimir Registros">
                                                        <b>Seleccionar todos</b>
                                                    </label>
                                                </div>
                                                <div id="permisos_ajax"> </div>
                                            </div>
                                        </div>
                                    </article>
                                </fieldset>
                                <fieldset>
                                    <div class="row">
                                        <div class="col-sm-12 col-md-4 col-xs-12 col-lg-4">
                                            <button 
                                                type="submit" 
                                                class="btn ink-reaction btn-block btn-primary" 
                                                id="btn_guardar">
                                                <span class="glyphicon glyphicon-floppy-disk"></span> Guardar
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
