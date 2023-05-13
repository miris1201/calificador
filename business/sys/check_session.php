<?php
session_start();

$bloqueado = 0;
if(!isset($_SESSION[looked])){
    $bloqueado = 0;
}else {
    $bloqueado = $_SESSION[looked];
}
if (!isset($_SESSION[id_usr]) || $_SESSION[id_usr]=="") //SI NO HA INICIADO SESSION LLEVARLO A iniciarla
{
    echo "<script language='javascript'>window.location= '".$raiz."?attempt=login';</script>";
}else{
    if($bloqueado == 1){
        //Sesión bloqueada
        echo "<script language='javascript'>window.location= '".$raiz."business/sys/lockscreen.php?attempt=login';</script>";
    }else{
        
        if($sys_id_men <> 0){
            $rolbyuser = $cInicial->traeRolByUser($_SESSION[id_usr]);

            if($rolbyuser->rowCount() > 0){
                $rol_found = false;
                while ($rw_rol_bu = $rolbyuser->fetch(PDO::FETCH_OBJ)){
                    if(!$rol_found){
                        $rol_checar_n  = $rw_rol_bu->id_rol;
                        $rwRol         = $cInicial->checarRol_pagina($_SESSION[id_usr], $sys_id_men);
                        $numero_rows   = $rwRol->rowCount();

                        if ($rwRol->rowCount() > 0){
                            $arrcount         = $rwRol->fetch(PDO::FETCH_OBJ);
                            //Aquí asigno el valor de lasesiones...
                            $contador         = $arrcount->contador;
                            if($contador != 0){
                                //Si hay contador
                                $_SESSION[imp]    = $arrcount->imp;
                                $_SESSION[edit]   = $arrcount->edit;
                                $_SESSION[elim]   = $arrcount->elim;
                                $_SESSION[nuev]   = $arrcount->nuevo;
                                $_SESSION[export] = $arrcount->exportar;
                                if($sys_tipo <> 0){
                                    $rol_found = true;
                                    switch ($sys_tipo){
                                        case 1:
                                            //Nuevo
                                            if($_SESSION[nuev] == 1){
                                                $tiene_acceso = true;
                                            }
                                            break;
                                        case 2:
                                            //Editar
                                            if($_SESSION[edit] == 1){
                                                $tiene_acceso = true;
                                            }
                                            break;
                                        case 3:
                                            //Eliminar
                                            if($_SESSION[elim] == 1){
                                                $tiene_acceso = true;
                                            }
                                            break;
                                        case 4:
                                            //Imprimir
                                            if($_SESSION[imp] == 1){
                                                $tiene_acceso = true;
                                            }
                                            break;
                                        default:
                                            $tiene_acceso = false;
                                            $rol_found    = false;
                                    }
                                }else{
                                    $tiene_acceso = true;
                                    $rol_found    = true;
                                }
                            }else{
                                $tiene_acceso = false;
                                $rol_found    = false;
                            }
                        }else{
                            $tiene_acceso = false;
                        }
                    }

                }
            }else{
                $tiene_acceso = false;
            }


            if(!$tiene_acceso){
                //Si no tiene acceso entonces llevarlo a una página de error
                // echo "<script language='javascript'>window.location= '".$raiz."business/sys/error_page.php';</script>";
            }
        }
    }

}
?>
