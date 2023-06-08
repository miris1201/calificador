<?php
$dir_fc       = "";
include_once $dir_fc.'connections/trop.php';
include_once $dir_fc.'connections/php_config.php';

extract($_REQUEST);

$current_file = basename($_SERVER["PHP_SELF"]);
$dir          = dirname($_SERVER['PHP_SELF'])."/".$controller;
$checkMenu    = $server_name.$dir."/";   
$param        = "?controller=".$controller."&action=";

$sys_id_men   = 5;
$sys_tipo     = 0; // Nuevo.

$ruta_app     = "";
$titulo_edi  = "Nuevo";
$titulo_curr  = "Elemento";

include_once $dir_fc.'data/inicial.class.php';
include_once $dir_fc.'data/catalogos.class.php';

$cInicial   = new cInicial();
$cAccion    = new cCatalogos();

include_once 'business/sys/check_session.php'; 

if( !isset($_SESSION[_is_view_] )){
    $_SESSION[_is_view_] = 1;
}

$type = $_SESSION[_is_view_];
$_SESSION[_type_] = $type;


$id = 0;
$id_usuario  = "";
$id_zona     = "";
$no_empleado = "";
$nombre      = "";
$apepa       = "";
$apema       = "";
$activo      = "";


$readOnly   = "";
$showInput  = "";
$frmName = "frmDataE";


$direccion  = 0;
$area       = 0;
$return_paginacion = "";
$requerido  = "";


if ($_SESSION[_type_] == 2 || $_SESSION[_type_] == 3) {
    if (!isset($_SESSION[_editar_]) || !is_numeric($_SESSION[_editar_]) || $_SESSION[_editar_] <= 0) {
        $showinfo = false;
       
    } else {
        $id = $_SESSION[_editar_];

        $rsEditar    = $cAccion->getElementobyid($id);

        $rsEditar->rowCount();
        if ($rsEditar->rowCount() > 0) {
            $arrEdi = $rsEditar->fetch(PDO::FETCH_OBJ);

            $id_usuario  = $arrEdi->id_usuario;
            $id_zona     = $arrEdi->id_zona;
            $no_empleado = $arrEdi->no_empleado;
            $nombre      = $arrEdi->nombre;
            $apepa       = $arrEdi->apepa;
            $apema       = $arrEdi->apema;
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
    $frmName = "frmUpdateE";
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
    <meta content="<?php echo $titulo_curr?>" name="description"/>
    <meta content="" name="author"/>
    <?php include("dist/inc/headercommon.php"); ?>
</head>
<body class="<?php echo _BODY_STYLE_ ?>">
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
                                <a href="<?php echo $checkMenu?>">
                                    Lista                               
                                </a>
                            </li>
                            <li class="active">
                                <?php echo $titulo_curr?>
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
                                <a  title="Regresar a la lista"
                                    class="btn ink-reaction btn-floating-action" 
                                    style="background-color: #B0C4DE;"
                                    href='<?php echo $param."index".$return_paginacion?>'>
                                    <i class="fa fa-arrow-left"></i>
                                </a>  
                            </div>
                            <strong class="text-uppercase">
                                <?php echo $titulo_edi. " " .$titulo_curr?>
                            </strong>
                        </div>
                        <div class="card-body">
                            <form id="<?php echo $frmName?>" 
                                class="form" role="form" 
                                method="post">
                                <input type="hidden" name="current_file" id="current_file" value="<?php echo $param."index".$return_paginacion?>"/>                               
                                <input type="hidden" name="id_usuario" id="id_usuario" value="<?php echo $id?>">
                                <div class="row">
                                    <div class="col-xs-12 col-md-12 col-sm-12">
                                        <fieldset><legend>Datos de <?php echo $titulo_curr?></legend>                                        
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
                                                        name="apepa" id="apepa" 
                                                        style="text-transform: capitalize;"
                                                        autocomplete="off"
                                                        value="<?php echo $apepa?>"
                                                        <?php echo $readOnly?>>
                                                    <label for="apepa">Apellido Paterno 
                                                        <span class="text-danger">*</span>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group floating-label">
                                                    <input type="text" class="form-control" 
                                                            name="apema" id="apema"
                                                            style="text-transform: capitalize;" 
                                                            autocomplete="off"
                                                            value="<?php echo $apema?>"
                                                            <?php echo $readOnly?>>
                                                    <label for="apema">Apellido Materno 
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-sm-3">
                                                <div class="form-group floating-label">
                                                    <input 
                                                        type="number" 
                                                        class="form-control"
                                                        name="no_empleado"
                                                        id="no_empleado"
                                                        autocomplete="off"
                                                        style="text-transform: capitalize;"
                                                        required
                                                        value="<?php echo $no_empleado?>"
                                                        <?php echo $readOnly?>>
                                                    <label 
                                                        for="no_empleado">
                                                        No. empleado<span class="text-danger">*</span>
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
                                        </fieldset>
                                        <?php 
                                        if ($_SESSION[_is_view_] == 1 || $_SESSION[_is_view_] == 2) {
                                        ?>
                                        <fieldset>
                                            <div class="row">
                                                <div class="col-sm-12 col-md-4 col-xs-12 col-lg-4">
                                                    <button 
                                                        type="submit" 
                                                        class="btn ink-reaction btn-block"
                                                        style="background-color: #B0C4DE;"  
                                                        id="btn_guardar">
                                                        <span class="glyphicon glyphicon-floppy-disk"></span> Guardar
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
    </div><?php include($dir_fc."inc/menucommon.php") ?>
</div>
<?php include("dist/components/catalogos.magnament.php"); ?>
</body>
</html>
