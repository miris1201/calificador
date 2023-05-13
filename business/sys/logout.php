<?php
$dir_fc       = "../../";
include_once $dir_fc.'connections/trop.php';
//**********    Salir del sistema, solo eliminamos las cookies y las variables de sesion :)  ***************
//Eliminando Session
session_start();
session_destroy();
//Eliminando Cookies
header("location:".$raiz."index.php");   		//Llevandolo al index para que inice sesión man.
?>
