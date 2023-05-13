<?php
$Server = $_SERVER['HTTP_HOST'];

$raiz= "http://".$Server.":8080/";
$server_name ="http://$Server";

//Define zona horaria
date_default_timezone_set("America/Mexico_City");
$horaActual = date('Y-m-d H:i:s');
$titulo_paginas = "Administrador";

