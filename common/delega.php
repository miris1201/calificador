<?php
session_start();

$dir_fc       = "../";
include_once $dir_fc.'connections/trop.php';
include_once $dir_fc.'connections/php_config.php';

$type = 0;
$id   = 0;

extract($_REQUEST);

$_SESSION[_editar_]  = $id;
$_SESSION[_is_view_] = $type;
