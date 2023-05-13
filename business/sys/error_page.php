<?php
$dir_fc       = "../../";


include_once $dir_fc.'connections/trop.php';
include_once $dir_fc.'connections/php_config.php';
$sys_id_men   = 0;
$dir          = dirname($_SERVER['PHP_SELF']);
$current_file = basename($_SERVER["PHP_SELF"]);
$checkMenu    = $server_name.$dir."/";   


include_once $dir_fc.'data/inicial.class.php';
$cInicial = new cInicial();    

include_once '../sys/check_session.php'; 
$ruta_app = "";
?>

<!DOCTYPE html>
<html>
<head>
    <title><?php echo $titulo_paginas?></title>
    <meta content="" name="description"/>
    <meta content="" name="author"/>
</head>
<body class="<?php echo _BODY_STYLE_ ?> ">
<?php include ($dir_fc."inc/header.php")?>
<div id="base">
    <div class="offcanvas"></div>
    <div id="content">
        <section>
            <div class="col-lg-12 col-xs-12">
                <div class="error-page">
                    <h2 class="text-info text-center"> Acceso</h2>
                    <div class="error-content text-center">
                        <h3><i class="fa fa-warning text-yellow"></i> No se puede acceder a esta página</h3>
                        <p> La página solicitada no se encuentra disponible actualmente.</p>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <?php include($dir_fc."inc/menucommon.php") ?>
</div>
</body>
</html>