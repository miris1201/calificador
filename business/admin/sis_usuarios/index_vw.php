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

$sys_id_men   = 2;
$sys_tipo     = 0;

include_once $dir_fc.'data/inicial.class.php';
include_once $dir_fc.'common/function.class.php';
include_once $dir_fc.'data/users.class.php';

$cInicial = new cInicial();  
$cFn      = new cFunction(); 
$cLista   = new cUsers();

include_once 'business/sys/check_session.php';    
$registros  = 20; 

if (isset($_GET["pag"])) { $pag = $_GET["pag"];} else { $pag = 1;}
if (is_numeric($pag)) { $inicio = (($pag - 1) * $registros);} else {$inicio = 0;}

$ingreso = 1;

if ($busqueda == "") {
    $filtro      = "";
    $fPaginacion = "";
    $back        = "";
    $MSJresult   = "";
} else {
    $filtro      = $busqueda;
    $fPaginacion = "&busqueda=".$busqueda;
    $back = " <a type='button' 
                 class='btn btn-accent-dark btn-floating-action ink-reaction'  
                 href='".$param."index' 
                 title='(Eliminar filtro de búsqueda)'>
                 <span class='fa fa-filter'></span>
              </a>";
    $MSJresult = $cFn->custom_alert("info", " ", "Resultados encontrados con la busqueda: " . $busqueda . "", 1, 1);
}

$rol = $_SESSION[id_rol];

$cLista->setFiltro($filtro);
$cLista->setInicio($inicio);
$cLista->setFin($registros);
$cLista->setLimite(0);

$rs_count       = $cLista->getAllReg( $rol ); 
$countRegistros = $rs_count->rowCount();
$numeroTotalPaginas = ceil($countRegistros/$registros);

$cLista->setLimite(1);
$rsRegShow = $cLista->getAllReg( $rol );  

$ruta_app = "";

?>
<!DOCTYPE html>
<html>
<head>
    <title>Usuarios | <?php echo $titulo_paginas?></title>
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
                    <div class="col-lg-8">
                        <h1 class="text-primary main-title">
                            Lista de Usuarios 
                            <span class="badge">
                                <?php echo $countRegistros?>
                            </span>
                        </h1>
                    </div>
                    <div class="col-lg-4">
                        <ol class="breadcrumb pull-right">
                            <li><a href="<?php echo $raiz?>business/">Inicio</a></li>
                            <li class="active">Lista de Usuarios</li>
                        </ol>
                    </div>
                </div>
                <div class="card">
                    <div class="card-head style-accent-bright">
                        <div class="tools pull-left">
                            <?php
                            if($_SESSION[nuev] == "1") {
                                ?>
                                <a 
                                    class="btn ink-reaction btn-floating-action btn-accent" 
                                    href="<?php echo $param?>nuevo" 
                                    title="Agregar un nuevo Registro">
                                    <i class="fa fa-plus"></i>
                                </a>
                            <?php
                            }
                            echo $back?>

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
                                <div id="respuesta_ajax">
                                    <?php echo $MSJresult?></div>
                            </div>
                        </div>
                        <div class="row form-group">
                            <?php
                            if ($countRegistros >= 1) {
                            ?>
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                        <tr>
                                            <td width="2%"></td>
                                            <th>Usuario</th>
                                            <th>Nombre</th>
                                            <th class="text-center">Funciones</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        while ($rowReg  = $rsRegShow->fetch(PDO::FETCH_OBJ)) {
                                            $iId        = $rowReg->id_usuario;
                                            $sUsuario   = $rowReg->usuario;
                                            $sNombre    = $rowReg->nombre;
                                            $r_admin    = $rowReg->admin;
                                            $isActive   = $rowReg->activo;

                                            if($isActive == 1){
                                                $showEstatus = "fa fa-check-circle text-success";
                                                $bajaAlta    = 0;
                                                $icoAB       = "fa fa-ban";
                                                $titleAB     = "Dar de baja";
                                            }else{
                                                $showEstatus = "fa fa-times-circle text-danger";
                                                $bajaAlta    = 1;
                                                $icoAB       = "fa fa-check";
                                                $titleAB     = "Dar de Alta";
                                            }
                                            ?>
                                            <tr>
                                                <td>
                                                    <span class="pull-left <?php echo $showEstatus?>"></span>
                                                </td>
                                                <td><?php echo $sUsuario?></td>
                                                <td><?php echo $sNombre?> </td>
                                                <td class="text-center">
                                                    <a 
                                                        href="javascript:void(0);" 
                                                        onclick="openMyLink(0,<?php echo $iId ?>, '<?php echo $param."ver&pag=".$pag.$fPaginacion?>')" 
                                                        class="btn ink-reaction btn-icon-toggle"
                                                        data-toggle="tooltip" 
                                                        data-placement="top"
                                                        data-original-title="Ver registro">
                                                        <i class="fa fa-eye"> </i>
                                                    </a>
                                                    <?php

                                                    if($_SESSION[edit] == 1) {
                                                        ?>
                                                        <a 
                                                            href="javascript:void(0);" 
                                                            onclick="openMyLink(1,<?php echo $iId ?>, '<?php echo $param."ver&pag=".$pag.$fPaginacion?>')" 
                                                            class="btn ink-reaction btn-icon-toggle"
                                                            data-toggle="tooltip" 
                                                            data-placement="top" 
                                                            title="Editar Registro">
                                                            <span class="glyphicon glyphicon-pencil"></span>
                                                        </a>
                                                        <?php                                                         
                                                        if (($_SESSION[admin]) || $_SESSION[id_rol] <= 2) { 
                                                        ?>
                                                            <a 
                                                                onclick="cpwModal(<?php echo $iId ?>)"
                                                                class="btn ink-reaction btn-icon-toggle"
                                                                data-toggle="tooltip" 
                                                                data-placement="top"
                                                                title="Cambiar Contraseña">
                                                                <i class="fa fa-key"></i>
                                                            </a>
                                                        <?php
                                                        }
                                                    }
                                                    if($_SESSION[elim] == 1) { ?>
                                                        <a 
                                                            onclick="handleDeleteReg(<?php echo $iId.','.$bajaAlta ?>)"
                                                            class="btn ink-reaction btn-icon-toggle btn-warning"
                                                            data-placement="top" 
                                                            title="<?php echo $titleAB ?>">
                                                            <span class="<?php echo $icoAB ?>"></span>
                                                        </a>
                                                        <a 
                                                            onclick="handleDeleteReg(<?php echo $iId?>, 3)" 
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
<?php include("dist/components/users.php"); ?>
<div 
    class="modal small fade" 
    id="idModalcpw" 
    tabindex="-1" 
    role="dialog" 
    aria-labelledby="myModalLabel" 
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h5 class="modal-title">Cambiar Contraseña</h5>
            </div>              
            <form role="form" id="idCPW" class="form">
                <div class="modal-body">
                    <p class="error-text">
                        <i class="fa fa-warning text-danger modal-icon"></i>
                        <span id="men">
                            <b> ¿Está seguro que quieres cambiar contraseña?</b>
                        </span>                    
                    </p>
                    <div class="row">
                        <div id="respuesta_cpw"></div>
                        <input 
                            type="hidden" 
                            id="id_user_pw" 
                            name="id_user_pw"/>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group floating-label">
                                <input 
                                    type="password" 
                                    class="form-control" 
                                    name="nuevaclave" 
                                    id="nuevaclave"
                                    required 
                                    autocomplete="off" 
                                    maxlength="16">
                                <label for="nuevaclave">
                                    Contraseña Nueva <span class="text-danger">*</span>
                                </label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group floating-label">
                                <input 
                                    type="password" 
                                    class="form-control" 
                                    id="confclave" 
                                    name="confclave" 
                                    required
                                    autocomplete="off" 
                                    maxlength="16">
                                <label for="confclave">
                                    Confirmar Contraseña <span class="text-danger">*</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button 
                        type="button" 
                        class="btn btn-link btn-danger" 
                        data-dismiss="modal">Cerrar
                    </button>
                    <button 
                        type="submit" 
                        id="btn_aceptar_cpw" 
                        class="btn bg-success ink-reaction" >
                        Aceptar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
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
                        <div id="respuesta_cpw"></div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group floating-label">
                                <input 
                                    type="text" 
                                    class="form-control dirty" 
                                    name="txtBuscar" 
                                    id="idSearch" 
                                    autocomplete="off"                                    
                                />
                                <label for="idSearch">
                                    Nombre: <span class="text-danger">*</span>
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
<?php 
$cLista->closeOut();
?>
</body>
</html>

