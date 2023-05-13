<?php
$dir_fc = "";
include_once $dir_fc.'connections/trop.php';
include_once $dir_fc.'connections/php_config.php';

extract($_REQUEST);

$current_file = basename($_SERVER["PHP_SELF"]);
$dir          = dirname($_SERVER['PHP_SELF'])."/".$controller;
$checkMenu    = $server_name.$dir."/";
$param        = "?controller=".$controller."&action=";

$sys_id_men   = 0;
$ruta_app     = "";

include_once $dir_fc.'data/inicial.class.php';
include_once $dir_fc.'data/users.class.php';

$cInicial   = new cInicial();  
$cUsers     = new cUsers();    

extract($_REQUEST);

?>
<!DOCTYPE html>
<html>
<head>
    <title>Creando Nueva cuenta | <?php echo $titulo_paginas?></title>
    <meta content="" name="description"/>
    <meta content="" name="author"/>
    <?php include("dist/inc/headercommon.php"); ?>
</head>
<body class="<?php echo _BODY_STYLE_ ?> ">
<?php include ($dir_fc."inc/public_header.php")?>
<div class="offcanvas"></div>
<div id="content">
    <section>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-8"></div>
                <div class="col-lg-4">
                    <ol class="breadcrumb pull-right">
                        <li><a href="<?php echo $raiz?>">Inicio</a></li>
                        <li class="active text-sm">Agregando Cuenta</li>
                    </ol>
                </div>
            </div>
            <div class="card">
                <div class="card-head style-success">
                    <div class="tools pull-left">
                        <a class="btn ink-reaction btn-floating-action btn-primary"
                            href='<?php echo $raiz?>' 
                            title="Regresar al inicio">
                            <i class="fa fa-arrow-left"></i>
                        </a>
                    </div>
                    <strong>Agregando Cuenta</strong>
                    <div class="tools">
                        <span class="fa fa-2x fa-check-circle text-default" 
                            title="Usuario Activo"></span>
                    </div>
                </div>
                <div class="card-body">
                    <form id="frmAddAccount" 
                        class="form" 
                        role="form" 
                        method="post" >
                        <div class="row">
                            <div class="col-xs-12 col-md-12 col-sm-12">
                                <fieldset><legend>Datos de Usuario</legend>
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="form-group floating-label">
                                                <input 
                                                    type="text" 
                                                    class="form-control" 
                                                    name="nombre" 
                                                    id="nombre" 
                                                    autocomplete="off"
                                                    required 
                                                    >
                                                <label for="nombre">
                                                    Nombre(s)<span class="text-danger">*</span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group floating-label">
                                                <input 
                                                    type="text" 
                                                    class="form-control" 
                                                    name="apepat" 
                                                    id="apepat" 
                                                    autocomplete="off"
                                                    >
                                                <label for="apepat">
                                                    Apellido Paterno <span class="text-danger">*</span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group floating-label">
                                                <input 
                                                    type="text" 
                                                    class="form-control"
                                                    name="apemat" 
                                                    id="apemat" 
                                                    autocomplete="off"
                                                    >
                                                <label for="apemat">
                                                    Apellido Materno <span class="text-danger">*</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="form-group floating-label">
                                                <input 
                                                    type="email" 
                                                    class="form-control" 
                                                    name="correo" 
                                                    id="correo"
                                                    required 
                                                    autocomplete="off" >
                                                <label for="correo">
                                                    Correo electrónico (Para ingresar al sistema) <span class="text-danger">*</span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-group floating-label">
                                                <select 
                                                    name="sexo" 
                                                    id="sexo" 
                                                    class="form-control" 
                                                    required 
                                                    >
                                                    <option value=""></option>
                                                    <option value="1">Masculino</option>
                                                    <option value="2">Femenino</option>
                                                </select>
                                                <label for="sexo">
                                                    Género: <span class="text-danger">*</span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-md-6">
                                            <div class="form-group">
                                                <select 
                                                    name="id_colonia" 
                                                    id="id_colonia" 
                                                    class="form-control" 
                                                    required>
                                                    <option value=""></option>
                                                    <?php
                                                    $getCalle = $cUsers->getPublicColonias();
                                                    while($rowc = $getCalle->fetch(PDO::FETCH_OBJ)){
                                                    ?>
                                                        <option value="<?php echo $rowc->id_comunidad?>">
                                                            <?php echo $rowc->colonia?>
                                                        </option>
                                                    <?php
                                                    }

                                                    ?>
                                                </select>
                                                <label for="id_colonia">
                                                    Colonia <span class="text-danger">*</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group floating-label">
                                                <input 
                                                    type="text" 
                                                    class="form-control" 
                                                    name="domicillio" 
                                                    id="domicillio" 
                                                    autocomplete="off"
                                                    >
                                                <label for="domicillio">
                                                    Domicilio
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <div class="form-group floating-label">
                                                <input 
                                                    type="text" 
                                                    class="form-control" 
                                                    name="telefono" 
                                                    id="telefono" 
                                                    autocomplete="off"
                                                    >
                                                <label for="telefono">Telefono Fijo
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group floating-label">
                                                <input 
                                                    type="test" 
                                                    class="form-control" 
                                                    name="tel_movil" 
                                                    id="tel_movil"
                                                    autocomplete="off" >
                                                <label for="tel_movil">
                                                    Teléfono Movil
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                                <fieldset>
                                    <div class="row">
                                        <div class="col-sm-12 col-md-4 col-xs-12 col-lg-4">
                                            <button type="submit" 
                                                class="btn ink-reaction btn-block btn-info" 
                                                id="btn_guardar">
                                                <i class="glyphicon glyphicon-floppy-disk"></i> Guardar Datos
                                            </button>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                    </form>
                </div>
            </div>                
        </div>
    </section>
</div>
<?php include("dist/components/account.php"); ?>  
</body>
</html>
