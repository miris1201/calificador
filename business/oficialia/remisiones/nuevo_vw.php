<?php
$dir_fc       = "";
include_once $dir_fc.'connections/trop.php';
include_once $dir_fc.'connections/php_config.php';

extract($_REQUEST);

$current_file = basename($_SERVER["PHP_SELF"]);
$dir          = dirname($_SERVER['PHP_SELF'])."/".$controller;
$checkMenu    = $server_name.$dir."/";   
$param        = "?controller=".$controller."&action=";

$sys_id_men   = 9;
$sys_tipo     = 0; // Nuevo.

$ruta_app     = "";
$titulo_edi  = "Nueva";
$titulo_curr  = "Remisión";

include_once $dir_fc.'data/inicial.class.php';
include_once $dir_fc.'data/remisiones.class.php';

$cInicial   = new cInicial();
$cAccion    = new cRemision();

include_once 'business/sys/check_session.php'; 

if( !isset($_SESSION[_is_view_] )){
    $_SESSION[_is_view_] = 1;
}

$type = $_SESSION[_is_view_];
$_SESSION[_type_] = $type;


$id = 0;
$fec_remision = $horaActual;
$patrulla    = "";
$agente      = "";
$escolta     = "";
$id_colonia  = "";
$sector      = "";
$calle       = "";
$entrecalle1 = "";
$entrecalle2 = "";
$observaciones = "";

$readOnly   = "";
$showInput  = "";
$frmName = "frmData";

$showInfractor = "";
$return_paginacion = "";
$requerido  = "";


if ($_SESSION[_type_] == 2 || $_SESSION[_type_] == 3) {
    if (!isset($_SESSION[_editar_]) || !is_numeric($_SESSION[_editar_]) || $_SESSION[_editar_] <= 0) {
        $showinfo = false;
       
    } else {
        $id = $_SESSION[_editar_];

        $rsR    = $cAccion->getRemisionbyid($id);

        if ($rsR->rowCount() > 0) {
            $arrR = $rsR->fetch(PDO::FETCH_OBJ);

            $id_remision = $arrR->id_remision;
            $id_turno    = $arrR->id_turno;
            $folio       = $arrR->folio;
            $patrulla    = $arrR->patrulla;
            $agente      = $arrR->agente;
            $escolta     = $arrR->escolta;
            $id_colonia  = $arrR->id_colonia;
            $sector      = $arrR->sector;
            $calle       = $arrR->calle;
            $entrecalle1 = $arrR->entrecalle1;
            $entrecalle2 = $arrR->entrecalle2;
            $observaciones = $arrR->observaciones;
            $fec_remision = $arrR->fecha_remision;


            if(!isset($pag)){ $pag=1;}
            if(!isset($busqueda) || $busqueda == ""){$busqueda = "";}
            $return_paginacion = "&pag=".$pag."&busqueda=".$busqueda;
        } else {
            $showinfo = false;
        }
    }
}

if ($_SESSION[_is_view_] == 1) {
    $showInfractor = "style='display: none'";
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
    <meta content="<?php echo $titulo_curr?>" name="description"/>
    <meta content="" name="author"/>
    <?php include("dist/inc/headercommon.php"); ?>
    <link rel="stylesheet" type="text/css" href="dist/assets/css/select2.min.css?v=1.001">
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
                                <input type="hidden" name="current_file" id="current_file" 
                                    value="<?php echo $param."index".$return_paginacion?>"/>                               
                                <input type="hidden" name="id_remision" id="id_remision" value="<?php echo $id?>">
                                <div class="row">
                                    <div class="col-xs-12 col-md-12 col-sm-12">
                                        <fieldset><legend>Datos de <?php echo $titulo_curr?></legend>          
                                            <div class="row">
                                                <div class="col-sm-2">
                                                    <div class="form-group">
                                                        <input 
                                                            type="datetime-local" 
                                                            class="form-control"
                                                            name="fecha_remision"
                                                            id="fecha_remision"
                                                            autocomplete="off"
                                                            required
                                                            value="<?php echo $fec_remision?>"
                                                            <?php echo $readOnly?>>
                                                        <label
                                                            for="fecha_remision">
                                                            Fecha Remisión <span class="text-danger">*</span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>                              
                                            <div class="row">                                            
                                                <div class="col-sm-2">
                                                    <div class="form-group floating-label">
                                                        <input 
                                                            type="text" 
                                                            class="form-control"
                                                            name="patrulla"
                                                            id="patrulla"
                                                            autocomplete="off"
                                                            required
                                                            value="<?php echo $patrulla?>"
                                                            <?php echo $readOnly?>>
                                                        <label
                                                            for="patrulla">
                                                            Patrulla <span class="text-danger">*</span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-sm-5">
                                                    <div class="form-group">
                                                        <select name="id_patrullero" id="id_patrullero"
                                                            <?php echo $readOnly?> 
                                                            class="form-control">
                                                            <option value=""></option>
                                                            <?php
                                                            $rsP = $cAccion->getCatElementos();
                                                            while($rwP = $rsP->fetch(PDO::FETCH_OBJ)){ 
                                                                $selA = "";
                                                                if ($rwP->no_empleado == $agente) {
                                                                    $selA = "selected";
                                                                }
                                                                
                                                                ?>
                                                                <option value="<?php echo $rwP->id_usuario?>" <?php echo $selA?>>
                                                                    <?php echo $rwP->no_empleado .' - ' .$rwP->nm_elemento?> 
                                                                </option>
                                                            <?php
                                                            } ?>
                                                        </select>
                                                        <label for="id_patrullero">Patrullero
                                                            <span class="text-danger">*</span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-sm-5">
                                                    <div class="form-group">
                                                        <select name="id_escolta" id="id_escolta"
                                                            <?php echo $readOnly?> 
                                                            class="form-control">
                                                            <option value=""></option>
                                                            <?php
                                                            $rsE = $cAccion->getCatElementos();
                                                            while($rwE = $rsE->fetch(PDO::FETCH_OBJ)){ 
                                                                $selE = "";
                                                                if ($rwE->no_empleado == $escolta) {
                                                                    $selE = "selected";
                                                                }
                                                                ?>
                                                                <option value="<?php echo $rwE->id_usuario?>" <?php echo $selE?>>
                                                                    <?php echo $rwE->no_empleado .' - ' .$rwE->nm_elemento?> 
                                                                </option>
                                                            <?php
                                                            } ?>
                                                        </select>
                                                        <label for="id_escolta">Escolta
                                                            <span class="text-danger">*</span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-5">
                                                    <div class="form-group">
                                                        <select name="id_colonia" id="id_colonia"
                                                            <?php echo $readOnly?> 
                                                            class="form-control">
                                                            <option value=""></option>
                                                            <?php
                                                            $rs = $cAccion->getCatColonias();
                                                            while($rwC = $rs->fetch(PDO::FETCH_OBJ)){ 
                                                                $selC = "";
                                                                if ($rwC->id_comunidad == $id_colonia) {
                                                                    $selC = "selected";
                                                                }
                                                                ?>
                                                                <option value="<?php echo $rwC->id_comunidad?>" <?php echo $selC?>>
                                                                    <?php echo $rwC->colonia. ' ('.$rwC->tipologia .') '?> 
                                                                </option>
                                                            <?php
                                                            } ?>
                                                        </select>
                                                        <label
                                                            for="id_colonia">
                                                            Colonia <span class="text-danger">*</span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-sm-1">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control"
                                                            id="sector" name="sector"
                                                            <?php echo $readOnly?> 
                                                            value=" <?php echo $sector?>">
                                                        <label
                                                            for="sector">
                                                            Sector <span class="text-danger">*</span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-sm-2">
                                                    <div class="form-group">
                                                        <input type="number" class="form-control"
                                                            id="folio_rnd" name="folio_rnd"
                                                            min="0"
                                                            <?php echo $readOnly?> 
                                                            value="">
                                                        <label
                                                            for="folio_rnd">
                                                            Folio RND <span class="text-danger">*</span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="form-group">
                                                        <select name="id_autoridad" id="id_autoridad"
                                                            <?php echo $readOnly?> 
                                                            class="form-control">
                                                            <option value=""></option>
                                                            <?php
                                                            $rsA = $cAccion->getCatAutoridad();
                                                            while($rwA = $rsA->fetch(PDO::FETCH_OBJ)){ ?>
                                                                <option value="<?php echo $rwA->id_autoridad?>">
                                                                    <?php echo $rwA->descripcion?> 
                                                                </option>
                                                            <?php
                                                            } ?>
                                                        </select>
                                                        <label
                                                            for="id_autoridad">
                                                            Autoridad que remite <span class="text-danger">*</span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">                                                
                                                <div class="col-sm-6">
                                                    <div class="form-group floating-label">
                                                        <input type="text" class="form-control"
                                                            id="calle" name="calle"
                                                            <?php echo $readOnly?> 
                                                            value="<?php echo $calle?> ">
                                                        <label
                                                            for="calle">
                                                            Calle <span class="text-danger">*</span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="form-group floating-label">
                                                        <input type="text" class="form-control"
                                                            id="entre_calle" name="entre_calle"
                                                            <?php echo $readOnly?> 
                                                            value="<?php echo $entrecalle1?> ">
                                                        <label
                                                            for="entre_calle">
                                                            Entre calle <span class="text-danger">*</span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="form-group floating-label">
                                                        <input type="text" class="form-control"
                                                            id="y_calle" name="y_calle"
                                                            <?php echo $readOnly?> 
                                                            value="<?php echo $entrecalle2?> ">
                                                        <label
                                                            for="y_calle">
                                                            Y calle <span class="text-danger">*</span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="form-group floating-label">
                                                        <textarea name="observaciones" id="observaciones" rows="5"
                                                            <?php echo $readOnly?> 
                                                            class="form-control"><?php echo $observaciones?> </textarea>
                                                        <label
                                                            for="observaciones">
                                                            Observaciones <span class="text-danger">*</span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </fieldset>
                                        <fieldset id="dataInfractor" <?php echo $showInfractor?>>
                                            <legend>Datos del infractor</legend>
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <div class="form-group floating-label">
                                                        <input type="text" class="form-control"
                                                            id="nombre" name="nombre"
                                                            <?php echo $readOnly?> 
                                                            value="">
                                                        <label
                                                            for="nombre">
                                                            Nombre <span class="text-danger">*</span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group floating-label">
                                                        <input type="text" class="form-control"
                                                            id="apepa" name="apepa"
                                                            <?php echo $readOnly?> 
                                                            value="">
                                                        <label
                                                            for="apepa">
                                                            Apellido Paterno <span class="text-danger">*</span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group floating-label">
                                                        <input type="text" class="form-control"
                                                            id="apema" name="apema"
                                                            <?php echo $readOnly?> 
                                                            value="">
                                                        <label
                                                            for="apema">
                                                            Apellido Materno <span class="text-danger">*</span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-1">
                                                    <div class="form-group floating-label">
                                                        <input type="number" class="form-control"
                                                            id="edad" name="edad" min="0" max="100"
                                                            <?php echo $readOnly?> 
                                                            value="">
                                                        <label
                                                            for="edad">
                                                            Edad <span class="text-danger">*</span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-sm-2">
                                                    <div class="form-group floating-label">
                                                        <select name="sexo" id="sexo" class="form-control">
                                                            <option value=""></option>
                                                            <option value="1">Femenino</option>
                                                            <option value="2">Masculino</option>
                                                        </select>
                                                        <label
                                                            for="sexo">
                                                            Sexo <span class="text-danger">*</span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-sm-2">
                                                    <div class="form-group floating-label">
                                                        <select name="id_edo_fisico" id="id_edo_fisico" class="form-control">
                                                            <option value=""></option>
                                                            <?php
                                                            $rsF = $cAccion->getCatEstadoFisico();
                                                            while($rwF = $rsF->fetch(PDO::FETCH_OBJ)){ ?>
                                                                <option value="<?php echo $rwF->id_edo_fisico?>">
                                                                    <?php echo $rwF->descripcion?> 
                                                                </option>
                                                            <?php
                                                            } ?>
                                                        </select>
                                                        <label
                                                            for="id_edo_fisico">
                                                            Estado Físico <span class="text-danger">*</span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="form-group floating-label">
                                                        <select name="id_ocupacion" id="id_ocupacion" class="form-control">
                                                            <option value=""></option>
                                                            <?php
                                                            $rsO = $cAccion->getCatOcupacion();
                                                            while($rwO = $rsO->fetch(PDO::FETCH_OBJ)){ ?>
                                                                <option value="<?php echo $rwO->id_ocupacion?>">
                                                                    <?php echo $rwO->descripcion?> 
                                                                </option>
                                                            <?php
                                                            } ?>
                                                        </select>
                                                        <label
                                                            for="id_ocupacion">
                                                            Ocupación <span class="text-danger">*</span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="form-group floating-label">
                                                        <select name="id_estudios" id="id_estudios" class="form-control">
                                                            <option value=""></option>
                                                            <?php
                                                            $rsN = $cAccion->getCatEstudios();
                                                            while($rwN = $rsN->fetch(PDO::FETCH_OBJ)){ ?>
                                                                <option value="<?php echo $rwN->id_nvl_estudios?>">
                                                                    <?php echo $rwN->descripcion?> 
                                                                </option>
                                                            <?php
                                                            } ?>
                                                        </select>
                                                        <label
                                                            for="id_estudios">
                                                            Nivel de Estudios <span class="text-danger">*</span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="form-group floating-label">
                                                        <textarea name="domicilio" id="domicilio" rows="2"
                                                            <?php echo $readOnly?> 
                                                            class="form-control"></textarea>
                                                        <label
                                                            for="domicilio">
                                                            Domicilio <span class="text-danger">*</span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-12 form-group">
                                                    <h4>
                                                        <span id="faltas_dtl" class="text-bold"></span>
                                                        <i id="fracciones_dtl"></i>
                                                    </h4>
                                                </div>
                                            </div>
                                            <div class="row">                                                
                                                <div class="col-sm-1">
                                                    <div class="form-group floating-label">
                                                        <select name="id_articulo"
                                                                id="id_articulo"
                                                                class="form-control">
                                                            <option value=""></option>
                                                            <?php
                                                            $rsArt = $cAccion->getCatArticulos();
                                                            while($rwArt = $rsArt->fetch(PDO::FETCH_OBJ)){ ?>
                                                                <option value="<?php echo $rwArt->id_articulo?>">
                                                                    <?php echo $rwArt->articulo?>
                                                                </option>
                                                            <?php
                                                            } ?>
                                                        </select>
                                                        <label
                                                            for="id_articulo">
                                                            Artículo <span class="text-danger">*</span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-sm-2">
                                                    <div class="form-group floating-label">
                                                        <select name="id_falta_a" 
                                                                id="id_falta_a" 
                                                                class="form-control">                                                            
                                                        </select>
                                                        <label
                                                            for="id_falta_a">
                                                            Falta Administrativa
                                                            <span class="text-danger">*</span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-sm-1">
                                                    <div class="form-group">
                                                        <div id="div_smd"></div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-1">
                                                    <div class="form-group">
                                                        <div id="div_horas"></div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-2">
                                                    <a  title="Regresar a la lista"
                                                        class="btn ink-reaction"
                                                        id="bntInfractor"
                                                        style="background-color: #B0C4DE;">
                                                        <i class="fa fa-user-plus" aria-hidden="true"></i>
                                                        Guardar infractor
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="col-sm-8">
                                                <table class="table table-bordered" id="tabla_infractores">
                                                    <tr>
                                                        <th></th>
                                                        <th></th>
                                                        <th>Infractores</th>
                                                    </tr>
                                                </table>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-10">
                                                    <legend>Infractores</legend>
                                                    <?php
                                                    $rs_Em = $cAccion->getInfractoresById( $id_remision );

                                                    while($row = $rs_Em->fetch(PDO::FETCH_OBJ) ){
                                                        $id_ciudadano = $row->id_ciudadano;
                                                        $id_turno     = $row->id_turno;
                                                        $nombre       = $row->nm_ciudadano;
                                                        $sexo = $row->sexo;
                                                        $edad = $row->edad;
                                                        $domicilio = $row->domicilio;
                                                        $edofisico = $row->edofisico;
                                                        $nvl_estudios = $row->nvl_estudios;
                                                        $ocupacion = $row->ocupacion;

                                                        $genero = ($sexo == 1) ? 'Femenino' : 'Masculino';

                                                        ?>
                                                        <td id='infractores' width='5%'>
                                                            <a class="btn ink-reaction btn-icon-toggle"
                                                                onclick='handleDelete(<?php echo $id_ciudadano?>)'>
                                                                <span class='fa fa-times fa-2x-2x'></span>
                                                            </a>
                                                        </td>
                                                        <td id='infractores' width='5%'>
                                                            <a class="btn ink-reaction btn-icon-toggle"
                                                                onclick='handleUpdate(<?php echo $id_ciudadano?>)'>
                                                                <span class='fa fa-pencil fa-2x-2x'></span>
                                                            </a>
                                                        </td>
                                                        <strong><?php echo $nombre?> </strong> / Sexo: <?php echo $genero?> / Edad: <?php echo $edad?><br>
                                                        <span>| Estado Físico: <?php echo $edofisico?> / Estudios: <?php echo $nvl_estudios?> / Ocupación: <?php echo $ocupacion?>  </span> <br>
                                                        <span>| Domicilio: <?php echo $domicilio?> </span> <br>                                                                                                                                                               
                                                        <?php
                                                    } ?>
                                                </div>
                                            </div><br>
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
<?php include("dist/components/remision.magnament.php"); ?>
<script src="dist/assets/js/select2.full.min.js"></script>
</body>
</html>
