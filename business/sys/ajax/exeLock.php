<?php
$dir_fc = "../../../";
session_start();

include_once $dir_fc.'data/users.class.php';     
include_once $dir_fc.'connections/php_config.php'; 

$cAccion    = new cUsers();

extract($_REQUEST);

if (empty($password)) {					//Error 2 - campos vacios
    echo "No has insertado la clave";

} else {
    $cAccion->setClave(md5($password));									//Cifrando la clave
    $cAccion->setId_usuario($_SESSION[id_usr]);
    $selectUser = $cAccion->getUserLock();
    if ($selectUser->rowCount() > 0)  {
        $_SESSION[looked] = 0;
        echo $_SESSION[looked];
        //header("location:../business/home.php");
    }
    else 													// Error 1 - información incorrecta
    {
        echo "Los datos insertados son incorrectos";
        //header("location:../index.php?attempt=error_1");
    }
}
?>
