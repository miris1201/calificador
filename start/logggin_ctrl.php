<?php
session_start();
include_once 'connections/php_config.php';
if (!isset($_SESSION[id_usr]))
{
include_once 'connections/trop.php';
$ruta_app = "";

extract($_REQUEST);

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8"/>
    <title><?php echo $titulo_paginas?> | Ingresar al sistema</title>
    <meta content="" name="description"/>
    <meta content="" name="author"/>
    <?php include("dist/inc/headercommon.php"); ?>
    <?php include("dist/components/login.php"); ?>
    <link rel="shortcut icon" href="<?php echo $raiz?>src/assets/img/favicon.png?v=1.004"/>
</head>
<body >
<div class="main">
    <div class="container">
        <div class="text-center mt-2">
            <p class="text-xl text-bold text-success">
                <?php echo c_page_title ?>
            </p>
        </div>
        <div class="row form-group">
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                <div id="login">
                    <form method="post" id="frm_login">
                        <fieldset>
                            <p>
                                <span class="fa fa-user"></span>
                                <input 
                                    type="text"  
                                    placeholder="Usuario" 
                                    name="txtUser" 
                                    id="user" 
                                    autofocus
                                    required>
                            </p>
                            <p class="form-group">
                                <span class="fa fa-lock"></span>
                                <input type="password"  placeholder="Contraseña" id="password" name="txtPass" required>
                            </p>
                            <div class="form-group">
                                <button class="btn btn-block ink-reaction btn-success" type="submit" id="btn_login">
                                    Ingresar
                                </button>
                            </div>
                        </fieldset>
                    </form>

                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 text-center">
                <div class="logo">
                    <img src="dist/assets/img/logo.png?v=1.1" alt="Tlalnepantla" class="img-responsive">
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
            </div>
        </div>
    </div>
</div>
</body>
</html>
<?php
}
else{
    header("location:?controller=business&action=show");
}
?>
