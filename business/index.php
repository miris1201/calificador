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

$cInicial  = new cInicial();     
$cBusiness = new cBusiness();

include_once 'sys/check_session.php'; 

$ruta_app = "";

$profile        = $_SESSION[id_rol];

$date_ini_range = date('Y-m-d');
$date_end_range = date('Y-m-d');
$showDescRange  = "(Hoy)";

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
        <div class="section-header">
            <ol class="breadcrumb">
                <li>
                    <a href="#"><i class="glyphicon glyphicon-home" aria-hidden+-="true"></i> Inicio</a>
                </li>
            </ol>
        </div>
        <div class="section-body contain">
            <div class="row">
                
            </div>   
        </div>
    </section>
</div>
<?php include($dir_fc."inc/menucommon.php") ?>
</div>
<?php include("dist/components/business.php"); ?>
</body>
</html>
