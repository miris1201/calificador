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
include_once $dir_fc.'data/rol.class.php';
include_once $dir_fc.'data/users.class.php';

$cInicial   = new cInicial();  
$cRoles     = new cRol();      
$cEditar    = new cUsers();    

include_once 'business/sys/check_session.php'; 

$showinfo   = true;
$id_usuario = "";
$id_rol     = "";
$usuario    = "";
$sexo       = "";
$nombre     = "";
$apepa      = "";
$apema      = "";
$correo     = "";
$imp        = "";
$edit       = "";
$elim       = "";
$nuev       = "";
$activo     = "";
$admin      = "";

extract($_REQUEST);


$id = $_SESSION[id_usr];
if(!isset($id) || !is_numeric($id) || $id<= 0){
    $showinfo = false;
}else{
    $cEditar->setId_usuario($id);
    $rsEditar    = $cEditar->getRegbyid();
    if($rsEditar->rowCount() > 0){
        $arrEdi      = $rsEditar->fetch(PDO::FETCH_OBJ);
        $id_usuario  = $arrEdi->id_usuario;
        $id_rol      = $arrEdi->id_rol;
        $usuario     = $arrEdi->usuario;
        $sexo        = $arrEdi->sexo;
        $nombre      = $arrEdi->nombre;
        $apepa       = $arrEdi->apepa;
        $apema       = $arrEdi->apema;
        $activo      = $arrEdi->activo;
        $admin       = $arrEdi->admin;
    }else{
        $showinfo = false;
    }

}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Mi cuenta | <?php echo $titulo_paginas?></title>
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
                            <li><a href="<?php echo $raiz?>">Inicio</a></li>
                            <li class="active">Mis datos</li>
                        </ol>
                    </div>
                </div>
                <?php
                if($showinfo == true) {   ?>
                    <div class="card">
                        <?php
                        if($activo == 1){
                            $class_activo = "fa fa-2x fa-check-circle text-default";
                            $title_activo = "Usuario activo";
                            $card_style   = "style-success";
                        }else{
                            $class_activo = "fa fa-2x fa-times-circle text-default";
                            $title_activo = "Usuario inactivo";
                            $card_style   = "style-gray-light";
                        }
                        ?>
                        <div class="card-head <?php echo $card_style?>">
                            <div class="tools pull-left">
                                <a class="btn ink-reaction btn-floating-action btn-primary"
                                   href='<?php echo $raiz?>?controller=business&action=show' 
                                   title="Regresar al inicio">
                                   <i class="fa fa-arrow-left"></i>
                                </a>
                            </div>
                            <b>Mi cuenta</b>
                            <div class="tools">
                                <span class="<?php echo $class_activo?>" 
                                    title="Usuario Activo"></span>
                            </div>
                        </div>
                        <div class="card-body">
                            <form id="frmAccount" 
                                class="form" 
                                role="form" 
                                method="post" >
                                <div class="row">
                                    <div class="col-xs-12 col-md-12 col-sm-12">
                                        <input type="hidden" name="current_file" id="current_file" value="<?php echo $raiz?>?controller=business&action=show"/>
                                        <input type="hidden" name="id_usuario" id="id_usuario" value="<?php echo $id?>"/>
                                        <fieldset><legend>Datos de Usuario</legend>
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <div class="form-group floating-label">
                                                        <input type="text" class="form-control" name="nombre" id="nombre" autocomplete="off"
                                                               required value="<?php echo $nombre?>" readonly>
                                                        <label for="nombre">Nombre(s)<span class="text-danger">*</span></label>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group floating-label">
                                                        <input type="text" class="form-control" name="apepat" id="apepat" autocomplete="off"
                                                               value="<?php echo $apepa?>" readonly>
                                                        <label for="apepat">Apellido Paterno <span class="text-danger">*</span></label>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group floating-label">
                                                        <input type="text" class="form-control" name="apemat" id="apemat" autocomplete="off"
                                                               value="<?php echo $apema?>" readonly>
                                                        <label for="apemat">Apellido Materno <span class="text-danger">*</span></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <div class="form-group floating-label">
                                                        <input 
                                                            type="text"
                                                            class="form-control" 
                                                            name="usuario" 
                                                            id="usuario" 
                                                            autocomplete="off"
                                                            required 
                                                            value="<?php echo $usuario?>" 
                                                            readonly>
                                                        <label for="usuario">Nombre de Usuario <span class="text-danger">*</span></label>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group floating-label">
                                                        <select name="sexo" id="sexo" class="form-control" required readonly>
                                                            <option value=""></option>
                                                            <option value="1" <?php if ($sexo == 1) { echo "selected";} ?>>Femenino</option>
                                                            <option value="2" <?php if ($sexo == 2) { echo "selected";} ?>>Masculino</option>
                                                        </select>
                                                        <label for="sexo">Sexo: <span class="text-danger">*</span></label>
                                                    </div>
                                                </div>
                                            </div>                                            
                                        </fieldset>
                                        <fieldset>
                                            <div class="row">
                                                <div class="col-sm-12 col-md-4 col-xs-12 col-lg-4">
                                                    <button type="button" 
                                                        class="btn ink-reaction btn-block style-success" 
                                                        id="btn_cp"
                                                        onclick="cpwModal()">
                                                        <i class="fa fa-key"></i> 
                                                        Cambiar Contraseña
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
                    //Incliur el código de permisos denegados
                    include("../sys/permissions_d.php");
                }?>
            </div>
        </section>
    </div>
    <?php include($dir_fc."inc/menucommon.php") ?>
</div>
<?php include("dist/components/account.php"); ?>  
<div class="modal small fade" id="idModalcpw" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h5 class="modal-title"> Cambiar Contraseña</h5>
            </div>
            <form role="form" id="idCPW" class="form">
                <div class="modal-body">
                    <article id="container-info">                        
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group floating-label">
                                    <input type="password" class="form-control" id="clave" name="clave"  required>
                                    <label for="clave">Contraseña Actual</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group floating-label">
                                    <input type="password" class="form-control validate" id="nuevaclave" name="nuevaclave" 
                                         required>
                                    <label for="nuevaclave">Contraseña Nueva</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group floating-label">
                                    <input type="password" class="form-control" id="confclave" name="confclave" 
                                         required>
                                    <label for="confclave">Confirmar Contraseña</label>
                                </div>
                            </div>                            
                        </div>
                    </article>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-link btn-danger" data-dismiss="modal">Cancelar</button>
                    <button type="submit" id="btnGuardarcpw" class="btn bg-success ink-reaction" >Aceptar</button>                    
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>
