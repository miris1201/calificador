<?php
session_start();
$dir_fc = "../../../../";

include_once $dir_fc . 'connections/trop.php';  
include_once $dir_fc . 'connections/php_config.php';  
include_once $dir_fc . 'common/function.class.php';
include_once $dir_fc . 'data/remisiones.class.php';

$cFn     = new cFunction();
$cAccion = new cRemision();

$master = "";

$done = false;
$resp = "";
$resm = "";


extract($_REQUEST);

$arrayFisico    = $cAccion->getArrayEdoFisico();
$arrayEstudios  = $cAccion->getArrayEstudios();
$arrayOcupacion = $cAccion->getArrayOcupacion();

if($master != ""){

    $done = 1;
    $allC = $cAccion->getCiudadanoByRem($master);   
    if($allC->rowCount() > 0){
        while($rowm = $allC->fetch(PDO::FETCH_OBJ)){
        $id_ciudadano       = $rowm->id_ciudadano;  
        $nm_remisor         = $rowm->nm_remisor;
        $edad               = $rowm->edad;
        $domicilio          = $rowm->domicilio;
        $id_edo_fisico      = $rowm->id_edo_fisico;
        $id_nvl_estudios    = $rowm->id_nvl_estudios;
        $nvl_estudios       = $rowm->nvl_estudios;
        $id_ocupacion       = $rowm->id_ocupacion;
        $ocupacion          = $rowm->ocupacion;
        $genero =  ($rowm->sexo == 1) ? 'Femenino' : 'Masculino' ;


        $allF = $cAccion->getFaltasByCiudadano( $id_ciudadano );

        $anio_rem = $cAccion->getFechaRem( $master);
        $salario = $cAccion->getCalculoTotalSMD( $anio_rem );

          
        $edoFisico  = (isset($arrayFisico[$id_edo_fisico]) && $arrayFisico[$id_edo_fisico] != "" ) ? $arrayFisico[$id_edo_fisico] : '';
        $nvlEstudios  = (isset($arrayEstudios[$id_nvl_estudios]) && $arrayEstudios[$id_nvl_estudios] != "" ) ? $arrayEstudios[$id_nvl_estudios] : $nvl_estudios;
        $ocupacion  = (isset($arrayOcupacion[$id_ocupacion]) && $arrayOcupacion[$id_ocupacion] != "" ) ? $arrayOcupacion[$id_ocupacion] : $ocupacion;

        $resp .= "  <div class='row'>
                        <div class='col-xs-12'>
                            <div class='row' >                                
                                <div class='col-sm-6'>
                                    <h4 class='text-light'>                               
                                        <b>Nombre del Infractor: </b> $nm_remisor <br>
                                        <b>Edad: </b>: $edad años &nbsp;&nbsp; <b>Sexo: </b> $genero &nbsp;&nbsp; <b>Edo. Físico: </b> $edoFisico<br>
                                        <b>Estudios: </b>: $nvlEstudios &nbsp;&nbsp; <b>Ocupación: </b> $ocupacion <br>
                                        <b>Domicilio: </b>: <br>$domicilio                                        
                                    </h4>
                                </div>
                                <div class='col-lg-4'>
                                    <table class='table table-hover table-striped'>
                                        <thead>
                                            <tr>
                                                <td width='4%' class='text-center'>Artículo</td>
                                                <td width='4%' class='text-center'>Falta</td>
                                                <td width='4%' class='text-center'>S/M Diario</td>
                                                <td width='4%' class='text-center'>Hr de arresto</td>
                                                <td width='4%' class='text-center'>Total</td>
                                            </tr>
                                            <tr>
                                                    <td colpan='5' class='text-right'></td>
                                            </tr>
                                        </thead>
                                        <tbody> ";
                                        $t_final = 0;
                                        $t_horas = 0;
                                        while($rowF = $allF->fetch(PDO::FETCH_OBJ)){
                                            $id_rem_falta = $rowF->id_rem_falta;
                                            $falta        = $rowF->falta;
                                            $fraccion     = $rowF->fraccion;
                                            $smd          = $rowF->smd;
                                            $hr_arresto   = $rowF->hr_arresto; 

                                            $total = $salario * $smd;

                                            $t_final += $total;
                                            $t_horas += $hr_arresto;
                                            $resp .= "
                                                <tr>
                                                    <td width='3%' class='text-center'>$falta</td>
                                                    <td width='4%' class='text-center'>$fraccion</td>
                                                    <td width='4%' class='text-center'>$smd</td>
                                                    <td width='4%' class='text-center'>$hr_arresto</td>
                                                    <td width='4%' class='text-center text-success'>$$total</td>
                                                </tr>                                                
                                            ";                                        
                                        }                                        
                            $resp .= "      
                                            <tr class='text-right text-danger'>
                                                <td colspan='2'>Total de horas: $t_horas</td>
                                                <td colspan='3'>Total a pagar: $$t_final</td>
                                            </tr>
                                        </tbody>                                 
                                    </table>
                                </div>
                                <div class='col-md-2'>
                                    <a onclick='handleEditD($id_ciudadano, $id_rem_falta)'
                                        class='btn ink-reaction btn-icon-toggle btn-warning'
                                        data-placement='top'
                                        id='btnEdit'
                                        title='Editar datos'>
                                        <i class='fa fa-pencil'></i>
                                    </a>
                                    <a onclick='handlePrint($id_rem_falta, $id_ciudadano)'
                                        class='btn ink-reaction btn-icon-toggle btn-warning'
                                        data-placement='top'
                                        id='btnEdit'
                                        title='Editar datos'>
                                        <i class='fa fa-pencil'></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>";     
        }
    }
    

}else{

    $resp = "Error, al consultar la información";
}


$cAccion->closeOut();

echo json_encode(array("done" => $done,
                       "resp" => $resp,
                       "resm" => $resm));

?>
