<?php
$dir_fc       = "";
include_once $dir_fc.'connections/trop.php';
include_once $dir_fc.'connections/php_config.php';

extract($_REQUEST);

$current_file = basename($_SERVER["PHP_SELF"]);
$dir          = dirname($_SERVER['PHP_SELF'])."/";
$checkMenu    = $server_name.$dir."?controller=business";
$param        = "?controller=business&action=";
$sys_id_men   = 0;

include_once $dir_fc.'data/inicial.class.php';
include_once $dir_fc.'data/business.class.php';

$cInicial = new cInicial();     
$cAccion  = new cBusiness();

include_once 'sys/check_session.php'; 

$id_turno      = "";
$id_juez       = "";
$id_secretario = "";
$turno         = "";
$juez          = "";
$secretario    = "";
$show          = "";
$showM         = "style='display: none'";
$id_turno      = 0; 

if(!isset($_SESSION[id_turno])){
    $_SESSION[id_turno] = 0;
}

if( !isset($_SESSION[id_juez] )){
    $_SESSION[id_juez]  = 0;
}

if( !isset($_SESSION[id_secretario] )){
    $_SESSION[id_secretario]  = 0;
}

extract($_REQUEST);

$id_turno = $_SESSION[id_turno];

if ($id_turno > 0) {
    $show = "style='display: none'";
    $showM = "";

    $turno = $cAccion->getTurnoById($_SESSION[id_turno]);
    $juez = $cAccion->getUsuarioById($_SESSION[id_juez]);
    $secretario = $cAccion->getUsuarioById($_SESSION[id_secretario]);
}

$ruta_app = "";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title><?php echo c_page_title?></title>
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
                    <div class="col-md-12 col-sm-12">
                        <div class="card">
                            <div class="card-body no-padding">
                                <div class="alert alert-callout alert-info no-margin">                                    
                                    <form 
                                        role="form"
                                        id="frmData"
                                        class="form">
                                        <fieldset>
                                            <div <?php echo $show?>>
                                                <div class="row">
                                                    <strong><i class="text-danger fa fa-bullhorn fa-2x"></i>
                                                        Llena la información
                                                    </strong>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-2">
                                                        <div class="form-group floating-label">
                                                            <select class="form-control" name="id_turno" id="id_turno">
                                                                <option></option>
                                                                <?php
                                                                $rsT = $cAccion->getDataTurno();
                                                                while($rwT = $rsT->fetch(PDO::FETCH_OBJ)) {
                                                                    ?>
                                                                    <option value="<?php echo $rwT->id_turno?>">
                                                                        <?php echo $rwT->descripcion?>
                                                                    </option>
                                                                    <?php
                                                                }
                                                                ?>
                                                            </select>
                                                            <label for="id_turno">Turno 
                                                                    <span class="text-danger">*</span>
                                                            </label>
                                                        </div>
                                                    </div> 
                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <select class="form-control" name="id_juez" id="id_juez">
                                                                <option></option>
                                                                
                                                                </select>
                                                            <label for="id_juez">Juez</label>
                                                        </div>
                                                    </div> 
                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <select class="form-control" name="id_secretario" id="id_secretario">
                                                                <option></option>
                                                            
                                                                </select>
                                                            <label for="id_secretario">Secretario</label>
                                                        </div>
                                                    </div>
                                                </div>
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
                                            </div>
                                        </fieldset>
                                    </form>                                    
                                </div>
                                <div class="alert alert-callout alert-info no-margin">                                    
                                    <fieldset <?php echo $showM?>>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <span id="dataDetalles" >
                                                    <div class="col-xs-3">
                                                        <div class="well">
                                                            <div class="clearfix">
                                                                <div class="pull-left"> Turno: </div>
                                                                <div class="pull-right"> <?php echo $turno; ?></div>
                                                            </div>
                                                            <div class="clearfix">
                                                                <div class="pull-left"> Juez : </div>
                                                                <div class="pull-right"> <?php echo $juez ?></div>
                                                            </div>
                                                            <div class="clearfix">
                                                                <div class="pull-left"> Secretario : </div>
                                                                <div class="pull-right"><?php echo $secretario?> </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </span>
                                            </div>
                                        </div>
                                    </fieldset>                                 
                                </div>
                            </div>
                        </div>
                    </div> 
                </div>            
            </div>
        </section>
    </div>
<?php include($dir_fc."inc/menucommon.php") ?>
</div>
<?php include("dist/components/business.php"); ?>
<div 
    class="modal small fade" 
    id="idModalData" 
    tabindex="-1" 
    role="dialog" 
    aria-labelledby="myModalLabel" 
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
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
                id="frmData" 
                class="form" >
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-5">
                            <div class="form-group floating-label">
                                <select class="form-control" name="id_turno" id="id_turno">
                                    <option></option>
                                    <?php
                                        $rsT = $cAccion->getDataTurno();
                                        while($rwT = $rsT->fetch(PDO::FETCH_OBJ)){
                                            ?>
                                            <option value="<?php echo $rwT->id_turno?>">
                                                <?php echo $rwT->descripcion?>
                                            </option>
                                            <?php
                                        }
                                        ?>
                                </select>
                                <label for="id_turno">Turno 
                                        <span class="text-danger">*</span>
                                </label>
                            </div>
                        </div> 
                        <div class="col-sm-5">
                            <div class="form-group floating-label">
                                <select class="form-control" name="id_juez" id="id_juez">
                                    <option></option>
                                    <?php
                                    $rsJ = $cAccion->getDataJuez();
                                    while($rwJ = $rsJ->fetch(PDO::FETCH_OBJ)){                                                                
                                        ?>
                                        <option value="<?php echo $rwJ->id_usuario?>">
                                            <?php echo $rwJ->nm_juez?>
                                        </option>
                                        <?php
                                    }
                                    ?>
                                    </select>
                                <label for="id_juez">Juez</label>
                            </div>
                        </div> 
                        <div class="col-sm-5">
                            <div class="form-group floating-label">
                                <select class="form-control" name="id_secretario" id="id_secretario">
                                    <option></option>
                                    <?php
                                    $rsS = $cLista->getDataSecretario();
                                    while($rwS = $rsS->fetch(PDO::FETCH_OBJ)){
                                        ?>
                                        <option value="<?php echo $rwS->id_usuario?>">
                                            <?php echo $rwS->nm_secretario?>
                                        </option>
                                        <?php
                                    }
                                    ?>
                                    </select>
                                <label for="id_secretario">Secretario</label>
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
</body>
</html>
