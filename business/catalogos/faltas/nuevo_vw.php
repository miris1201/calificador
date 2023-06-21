<?php
$dir_fc       = "";
include_once $dir_fc.'connections/trop.php';
include_once $dir_fc.'connections/php_config.php';

extract($_REQUEST);

$current_file = basename($_SERVER["PHP_SELF"]);
$dir          = dirname($_SERVER['PHP_SELF'])."/".$controller;
$checkMenu    = $server_name.$dir."/";   
$param        = "?controller=".$controller."&action=";

$sys_id_men   = 6;
$sys_tipo     = 0; // Nuevo.

$ruta_app     = "";
$titulo_edi  = "Nueva";
$titulo_curr  = "Falta";

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

$id_articulo = "";
$articulo    = "";
$descripcion = "";

$fraccion = "";

$readOnly   = "";
$showInput  = "";
$showInput  = "";
$frmName = "frmDataF";


$direccion  = 0;
$area       = 0;
$return_paginacion = "";
$requerido  = "";


if ($_SESSION[_type_] == 2 || $_SESSION[_type_] == 3) {
    if (!isset($_SESSION[_editar_]) || !is_numeric($_SESSION[_editar_]) || $_SESSION[_editar_] <= 0) {
        $showinfo = false;
       
    } else {
        $id = $_SESSION[_editar_];

        $rsEditar    = $cAccion->getFaltabyid($id);

        $rsEditar->rowCount();
        if ($rsEditar->rowCount() > 0) {
            $arrEdi = $rsEditar->fetch(PDO::FETCH_OBJ);

            $id_articulo = $arrEdi->id_articulo;
            $articulo    = $arrEdi->articulo;
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
    // $showInput = "style='display: none'";
    $frmName = "frmUpdateF";
    $requerido = "required";
    $return_paginacion = "&e=1&pag=".$pag."&busqueda=".$busqueda;
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
                        <div class="card-head" style="background-color: #5A96E3;">
                            <div class="tools pull-left">
                                <a  title="Regresar a la lista"
                                    class="btn ink-reaction btn-floating-action" 
                                    style="background-color: #E7CEA6;"
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
                                <input type="hidden" name="id_articulo" id="id_articulo" value="<?php echo $id?>">
                                <div class="row">
                                    <div class="col-xs-12 col-md-12 col-sm-12">
                                        <fieldset><legend>Datos de <?php echo $titulo_curr?></legend>                                        
                                        <div class="row form-group">                                            
                                            <div class="col-sm-2">
                                                <div class="form-group floating-label">
                                                    <input 
                                                        type="text" 
                                                        class="form-control"
                                                        name="articulo"
                                                        id="articulo"
                                                        autocomplete="off"
                                                        style="text-transform: capitalize;"
                                                        required
                                                        value="<?php echo $articulo?>"
                                                        <?php echo $readOnly?>>
                                                    <label 
                                                        for="articulo">
                                                        Artículo<span class="text-danger">*</span>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-sm-10">
                                                <div class="form-group floating-label">
                                                    <textarea name="descripcion" id="descripcion" rows="1"
                                                        class="form-control" 
                                                        <?php echo $readOnly?>><?php echo $descripcion?>
                                                    </textarea>
                                                    <label for="descripcion">Descripción
                                                        <span class="text-danger">*</span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>   
                                        <div class="row" <?php echo $showInput?>>
                                            <legend>Nueva fracción</legend>
                                            <div class="col-sm-1">
                                                <div class="form-group floating-label">
                                                    <input 
                                                        type="text" 
                                                        class="form-control"
                                                        name="fraccion"
                                                        id="fraccion"
                                                        autocomplete="off"
                                                        style="text-transform: capitalize;"
                                                        <?php echo $readOnly?>>
                                                    <label 
                                                        for="fraccion">
                                                        Artículo
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-sm-1">
                                                <div class="form-group floating-label">
                                                    <input 
                                                        type="text" 
                                                        class="form-control"
                                                        name="h_min"
                                                        id="h_min"
                                                        autocomplete="off"
                                                        style="text-transform: capitalize;"
                                                        <?php echo $readOnly?>>
                                                    <label 
                                                        for="h_min">
                                                        Hr. min
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-sm-1">
                                                <div class="form-group floating-label">
                                                    <input 
                                                        type="text" 
                                                        class="form-control"
                                                        name="h_max"
                                                        id="h_max"
                                                        autocomplete="off"
                                                        style="text-transform: capitalize;"
                                                        <?php echo $readOnly?>>
                                                    <label 
                                                        for="h_max">
                                                        Hr. max
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-sm-9">
                                                <div class="form-group floating-label">
                                                    <textarea name="descripcion_f" id="descripcion_f" rows="4"
                                                        class="form-control" <?php echo $readOnly?>> </textarea>
                                                    <label for="descripcion_f">Descripción
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
                                                        style="background-color: #E7CEA6;"  
                                                        id="btn_guardar">
                                                        <span class="glyphicon glyphicon-floppy-disk"></span> Guardar
                                                    </button>
                                                </div>
                                            </div>
                                        </fieldset>
                                        <?php 
                                        }
                                        if ($id_articulo > 0) { 
                                        ?>
                                        <fieldset >
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <table class="table table-striped">
                                                        <thead>
                                                            <tr>
                                                                <th colspan="5" class="text-center">
                                                                    <strong>Fracciones del Artículo</strong>
                                                                </th>
                                                            </tr>
                                                            <tr>
                                                                <th width="2%"></th>
                                                                <th class="text-center" width="1%">Fracción</th>
                                                                <th class="text-center" width="40%">Descripción</th>
                                                                <th class="text-center" width="1%">Hr. mínimo</th>
                                                                <th class="text-center" width="1%">Hr. máxima</th>
                                                                <th width="5%">Funciones</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        <?php    
                                                        if ($id_articulo > 0) {                          
                                                            $rsDtl = $cAccion->getFaltaDtlbyid( $id_articulo );
                                                            if ($rsDtl->rowCount() > 0) {
                                                                while($arrDtl = $rsDtl->fetch(PDO::FETCH_OBJ)){
                                                                $id_Dtl       = $arrDtl->id_articulo_dtl;
                                                                $fraccion     = $arrDtl->fraccion;
                                                                $descripcion  = $arrDtl->descripcion;
                                                                $hr_min       = $arrDtl->hr_min;
                                                                $hr_max       = $arrDtl->hr_max;
                                                                $activo_i     = $arrDtl->activo;

                                                                if($activo_i == 1){
                                                                    $showEstatus = "fa fa-check-circle text-success";
                                                                    $bajaAlta    = 0;
                                                                    $icoAB       = "glyphicon glyphicon-ban-circle";
                                                                    $titleAB     = "Dar de baja";
                                                                } else {
                                                                    $showEstatus = "fa fa-times-circle text-danger";
                                                                    $bajaAlta    = 1;
                                                                    $icoAB       = "fa fa-check";
                                                                    $titleAB     = "Dar de alta";
                                                                }
                                                                ?>
                                                                <tr>
                                                                    <td>
                                                                        <span class="pull-left <?php echo $showEstatus?>"></span> 
                                                                    </td> 
                                                                    <td>
                                                                        <input type="text" class="form-control"
                                                                        id="fraccion<?php echo $id_Dtl?>"
                                                                        name="fraccion<?php echo $id_Dtl?>"
                                                                        <?php echo $readOnly?> value="<?php echo $fraccion?>">    
                                                                    </td> 
                                                                    <td>
                                                                        <textarea name="descripcion_dtl<?php echo $id_Dtl?>" id="descripcion_dtl<?php echo $id_Dtl?>" rows="3"
                                                                        <?php echo $readOnly?>
                                                                        class="form-control"><?php echo $descripcion?> </textarea>
                                                                    </td> 
                                                                    <td>
                                                                        <input type="text" class="form-control" 
                                                                            id="hr_min<?php echo $id_Dtl?>"
                                                                            name="hr_min<?php echo $id_Dtl?>"
                                                                        <?php echo $readOnly?> value="<?php echo $hr_min?>">    
                                                                    </td> 
                                                                    <td>
                                                                        <input type="text" class="form-control"
                                                                            id="hr_max<?php echo $id_Dtl?>"
                                                                            name="hr_max<?php echo $id_Dtl?>"
                                                                        <?php echo $readOnly?> value="<?php echo $hr_max?>">    
                                                                    </td>
                                                                    <td>
                                                                        <a  onclick="handleSaveDtl(<?php echo $id_Dtl ?>)"
                                                                            class="btn ink-reaction btn-icon-toggle"
                                                                            data-placement="top" 
                                                                            data-toggle="tooltip"
                                                                            <?php echo $readOnly?>
                                                                            title="Guardar cambios">
                                                                            <span class="fa fa-save"></span>
                                                                        </a>
                                                                        <?php 
                                                                        if($_SESSION[elim] == 1) {
                                                                        ?>
                                                                            <a onclick="handleDeleteReg(<?php echo $id_Dtl.','.$bajaAlta ?>)"
                                                                                class="btn ink-reaction btn-icon-toggle"
                                                                                data-placement="top" 
                                                                                data-toggle="tooltip"
                                                                                <?php echo $readOnly?>
                                                                                title="<?php echo $titleAB ?>">
                                                                                <span class="<?php echo $icoAB ?>"></span>
                                                                            </a>
                                                                            <a onclick="handleDeleteReg(<?php echo $id_Dtl?>, 3)" 
                                                                                data-toggle="tooltip"
                                                                                class="btn ink-reaction btn-icon-toggle" 
                                                                                data-placement="top" 
                                                                                <?php echo $readOnly?>
                                                                                title="Eliminar">
                                                                                <span class="fa fa-trash"></span>
                                                                            </a>
                                                                        <?php 
                                                                        }
                                                                        ?>
                                                                    </td> 
                                                                </tr>
                                                            <?php 
                                                                }
                                                            }
                                                        }
                                                            ?>
                                                        </tbody>
                                                    </table>
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
