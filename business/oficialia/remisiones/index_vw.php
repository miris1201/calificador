<?php
$dir_fc       = "";
include_once $dir_fc.'connections/trop.php';
include_once $dir_fc.'connections/php_config.php';

$attempt    = "";
$accion     = "";
$respuesta  = "";
$busqueda   = "";

extract($_REQUEST);

$current_file = basename($_SERVER["PHP_SELF"]);
$dir          = dirname($_SERVER['PHP_SELF'])."/".$controller;
$checkMenu    = $server_name.$dir."/";
$param        = "?controller=".$controller."&action=";

$sys_id_men   = 9;
$sys_tipo     = 0;

include_once $dir_fc.'data/inicial.class.php';
include_once $dir_fc.'common/function.class.php';
include_once $dir_fc.'data/remisiones.class.php';

$cInicial = new cInicial();
$cFn      = new cFunction();
$cLista   = new cRemision();

include_once 'business/sys/check_session.php';    


$title_act  = "Remisiones";
$registros  = c_num_reg;

extract($_REQUEST);


if (isset($_GET["pag"])) { $pag = $_GET["pag"];} else { $pag = 1;}
if (is_numeric($pag)) { $inicio = (($pag - 1) * $registros);} else {$inicio = 0;}

if ($busqueda == "") {
    $filtro      = "";
    $fPaginacion = "";
    $back        = "";
    $MSJresult   = "";
} else {
    $filtro      = $busqueda;
    $fPaginacion = "&busqueda=".$busqueda;
    
    $back = "<a type='button' class='btn btn-floating-action ink-reaction' 
                style='background-color: #B0C4DE;' 
                href='".$param."index' title='(Eliminar filtro de búsqueda)'>
                <span class='fa fa-filter'></span>
            </a>";
    $MSJresult = $cFn->custom_alert(
        'info', 
        'Resultados encontrados con la busqueda',
        $busqueda,
        1, 
        1
    );
}

$cLista->setFiltro($filtro);
$cLista->setInicio($inicio);
$cLista->setFin($registros);
$cLista->setLimite(0);

$rs_count       = $cLista->getAllReg(); //Cuenta todos los registros (le doy 0 al limite)
$countRegistros = $rs_count->rowCount();
$numeroTotalPaginas = ceil($countRegistros/$registros);

$cLista->setLimite(1);
$rsRegShow = $cLista->getAllReg(); //Trae todos los registros (ya le puse limite)

$ruta_app = "";
?>
<!DOCTYPE html>
<html>
<head>
    <title><?php echo $title_act?> | <?php echo $titulo_paginas?></title>
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
                        <h2 class="text-primary main-title">
                            <?php echo $title_act ?> 
                            <span class="badge">
                                <?php echo $countRegistros?>
                            </span>
                        </h2>
                    </div>
                    <div class="col-lg-4">
                        <ol class="breadcrumb pull-right">
                            <li><a href="<?php echo $param?>business/">Inicio</a></li>
                            <li class="active">Lista de <?php echo $title_act ?></li>
                        </ol>
                    </div>
                </div>
                <div class="card">
                    <div class="card-head" style="background-color: #5F9EA0;">
                        <div class="tools pull-left">
                            <?php
                            if($_SESSION[nuev] == 1) { ?>
                                <a class="btn ink-reaction btn-floating-action"
                                    style="background-color: #B0C4DE;" 
                                   onclick="openMyLink(1,0, '<?php echo $param?>nuevo');"
                                   title="Agregar un nuevo Registro">
                                    <i class="fa fa-plus"></i>
                                </a>
                                <?php
                            }
                            echo $back;
                            ?>
                        </div>
                        <div class="tools">
                            <div class="navbar-search">
                                <button 
                                    type="button"
                                    id="btnSearch" 
                                    class="btn btn-icon-toggle ink-reaction">
                                    <i class="fa fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div id="respuesta_ajax"><?php echo $MSJresult?></div>
                            </div>
                        </div>
                        <div class="row form-group">
                        <?php if ($countRegistros >= 1) {
                            ?>
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-hover table-striped">
                                        <thead>
                                            <tr>
                                                <td width="2%" class="text-right"></td>
                                                <td width="3%">Folio</td>
                                                <td width="10%">Fecha Remision</td>
                                                <td width="20%">Nombres</td>
                                                <td width="40%">Observaciones</td>
                                                <th class="text-center">Funciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        while ($rowReg    = $rsRegShow->fetch(PDO::FETCH_OBJ)) {
                                            $iId          = $rowReg->id_remision;
                                            $iId_turno    = $rowReg->id_turno;
                                            $date_rem     = $rowReg->fecha_remision;
                                            $ejercicio    = $rowReg->año;
                                            $folio        = $rowReg->folio;
                                            $detalle      = $rowReg->observaciones;
                                            $isActive     = $rowReg->activo;

                                            if($isActive == 1){
                                                $showEstatus = "fa fa-check-circle text-success";
                                                $bajaAlta    = 0;
                                                $icoAB       = "fa fa-ban";
                                                $titleAB     = "Dar de baja";

                                            } else {
                                                $showEstatus = "fa fa-times-circle text-danger";
                                                $bajaAlta    = 1;
                                                $icoAB       = "fa fa-check";
                                                $titleAB     = "Dar de Alta";
                                            }

                                            $sDetalle_show = $detalle;
                                            if(strlen($detalle) > 40) {
                                                $sDetalle_show = substr($detalle, 0, 350)."...";
                                            }

                                            $count = $cLista->getCountCiudadanos($iId);
                                            if($count > 1){
                                                $sid_empleado = "-";
                                                $snombre      = "<a href='javascript:void(0)' onclick='handleCiudadanos(".$iId.")' 
                                                                    title='Ver Ciudadanos'>
                                                                     <i class=\"fa fa-users\" aria-hidden=\"true\"></i> ($count) Ciudadanos
                                                                </a> ";
                                            }else{
                                                $snombre = $cLista->getNmCiudadanos( $iId);
                                            }

                                            ?>
                                            <tr>
                                                <td><span class="pull-left <?php echo $showEstatus?>"></span></td>
                                                <td><?php echo $folio?></td>
                                                <td><?php echo $date_rem?></td>
                                                <td><?php echo $snombre?></td>
                                                <td><?php echo $sDetalle_show?></td>
                                                <td class="text-center">
                                                    <a href="javascript:void(0);" 
                                                        onclick="openMyLink(3,<?php echo $iId ?>, '<?php echo $param.'historial&pag='.$pag.$fPaginacion?>')" 
                                                        class="btn ink-reaction btn-icon-toggle"
                                                        data-toggle="tooltip" 
                                                        data-placement="top"
                                                        data-original-title="Historial / Seguimiento">
                                                        <i class="fa fa-eye"> </i>
                                                    </a>
                                                    <?php
                                                    if($_SESSION[edit] == 1) {
                                                        if($isActive == 1){ ?>
                                                        <a 
                                                            href="javascript:void(0);" 
                                                            onclick="openMyLink(2,<?php echo $iId ?>, '<?php echo $param.'nuevo&pag='.$pag.$fPaginacion?>')" 
                                                            class="btn ink-reaction btn-icon-toggle"
                                                            data-toggle="tooltip" 
                                                            data-placement="top" 
                                                            title="Editar Registro">
                                                            <span class="glyphicon glyphicon-pencil"></span>
                                                        </a>
                                                    <?php
                                                        }
                                                    }
                                                    if($_SESSION[elim] == 1){ ?>
                                                        <a 
                                                            onclick="handleDeleteU(<?php echo $iId.','.$bajaAlta ?>)"
                                                            class="btn ink-reaction btn-icon-toggle btn-warning"
                                                            data-placement="top" 
                                                            title="<?php echo $titleAB ?>">
                                                            <span class="<?php echo $icoAB ?>"></span>
                                                        </a>
                                                        <a 
                                                            onclick="handleDeleteU(<?php echo $iId?>, 3)" 
                                                            data-toggle="tooltip"
                                                            class="btn ink-reaction btn-icon-toggle btn-danger" 
                                                            data-placement="top" 
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
                                        ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <?php
                            echo $cFn->fn_paginacion($pag, $numeroTotalPaginas, $raiz, $param."index", $fPaginacion);
                            ?>
                        </div>
                        <?php
                        }else{
                            echo $cFn->custom_alert("info", "", "No se encontraron registros en la base de datos. ", 1, 1);  
                        }
                        ?>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <?php include($dir_fc."inc/menucommon.php") ?>
</div>
<?php include("dist/components/remision.php"); ?>
<div 
    class="modal small fade" 
    id="idModalSearch" 
    tabindex="-1" 
    role="dialog" 
    aria-labelledby="myModalLabel" 
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <button 
                    type="button" 
                    class="close" 
                    data-dismiss="modal">×</button>
                <h5 class="modal-title">Búsqueda</h5>
            </div>              
            <form 
                role="form" 
                id="frmSearch" 
                class="form">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group floating-label">
                                <input 
                                    type="text" 
                                    class="form-control dirty"
                                    name="txtBuscar"
                                    id="idSearch"
                                    autocomplete="off"/>
                                <label for="idSearch">
                                    Ejercicio: <span class="text-danger">*</span>
                                </label>
                            </div>
                        </div>                        
                    </div>
                </div>
                <div class="modal-footer">
                    <button 
                        type="button" 
                        class="btn btn-link btn-danger" 
                        data-dismiss="modal">
                        Cerrar
                    </button>
                    <button 
                        type="submit" 
                        id="btnHandleSubmitSearch" 
                        class="btn bg-success ink-reaction" >
                        Realizar Búsqueda
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal small fade" id="id_modal_detalle" 
    tabindex="-1" role="dialog" 
    aria-labelledby="myModalLabel" 
    aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <button 
                    type="button" 
                    class="close" 
                    data-dismiss="modal">×</button>
                <h5 class="modal-title">Detalle </h5>
            </div> 
            <div class="modal-body" id="htmlDetalle">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                        </tr>
                    </thead>    
                    <tbody id="table_ondata">
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button 
                    type="button" 
                    class="btn btn-link btn-danger" 
                    data-dismiss="modal">
                    Cerrar
                </button>
            </div>
        </div>
    </div>
</div>
</body>
</html>