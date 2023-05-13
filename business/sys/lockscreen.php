<?php

$dir_fc       = "../../";
session_start();

include_once $dir_fc.'connections/trop.php';
include_once $dir_fc.'connections/php_config.php';

$_SESSION[looked] = 1;
$ruta_app = "";

extract($_REQUEST);

if (!isset($_SESSION[id_usr]) || $_SESSION[id_usr]=="")  {
    echo "<script language='javascript'>window.location= '".$raiz."index.php?attempt=login';</script>";

} else{
//Recibiendo intentos de acceso al sistema (Fallidos ese vato!!)
    if (isset($attempt)) {
        switch ($attempt) {
            case "error_1":
                $msjError= "<div class=\"alert alert-danger\" role=\"alert\">
						<span class=\"glyphicon glyphicon-remove-circle\"></span> Los datos insertados son incorrectos
					</div>";
                break;
            case "error_2":
                $msjError= "<div class=\"alert alert-danger\" role=\"alert\">
						<span class=\"glyphicon glyphicon-remove-circle\"></span> Los campos están vacios
					</div>";
                break;
            case "login":
                $msjError= "<div class=\"alert alert-danger\" role=\"alert\">
						<span class=\"glyphicon glyphicon-remove-circle\"></span> Debes de acceder para consultar la página
					</div>";
                break;
            default:
                $msjError= "";
                break;
        }
    }else{
        $msjError= "";
    }
    ?>
    <!DOCTYPE html>
<html  class="lockscreen">
<head>
    <title><?php echo $titulo_paginas?></title>
    <!-- <?php include("dist/inc/headercommon.php"); ?> -->

</head>
    <body class="<?php echo _BODY_STYLE_ ?> ">
    <!-- BEGIN LOCKED SECTION -->
    <section class="section-account">
        <div class="img-backdrop" style="background-image: url('<?php echo $raiz?>src/assets/img/blur-background04.jpg')"></div>
        <div class="spacer"></div>
        <div class="card contain-xs style-transparent">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-9 col-lg-9 col-sm-12 col-xs-12">
                        <div id="error">
                            <?php echo $msjError?>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <img class="img-circle" src="<?php echo $raiz?>src/assets/img/<?php echo $_SESSION[s_img] ?>" alt="Usuario" />
                        <h2><?php echo $_SESSION[s_ncompleto]?></h2>
                        <form class="form" action="javascript: login()" method="post" accept-charset="utf-8" name="frm_login" id="frm_login">
                            <div class="form-group floating-label">
                                <div class="input-group">
                                    <div class="input-group-content">
                                        <input type="password" 
                                            id="password" 
                                            class="form-control" 
                                            name="password" required 
                                            autocomplete="off">
                                        <label for="password">Contraseña</label>
                                        <p class="help-block"><a href="logout.php">Ingresa con un usuario diferente</a></p>
                                    </div>
                                    <div class="input-group-btn">
                                        <button class="btn ink-reaction btn-floating-action btn-primary" type="submit"
                                            title="Ingresar" id="btn_ingresar"><i class="fa fa-unlock"></i></button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>
</html>
<?php
}
?>
