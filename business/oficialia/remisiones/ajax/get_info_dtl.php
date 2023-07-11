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

          
        $edoFisico  = (isset($arrayFisico[$id_edo_fisico]) && $arrayFisico[$id_edo_fisico] != "" ) ? $arrayFisico[$id_edo_fisico] : '';
        $nvlEstudios  = (isset($arrayEstudios[$id_nvl_estudios]) && $arrayEstudios[$id_nvl_estudios] != "" ) ? $arrayEstudios[$id_nvl_estudios] : $nvl_estudios;
        $ocupacion  = (isset($arrayOcupacion[$id_ocupacion]) && $arrayOcupacion[$id_ocupacion] != "" ) ? $arrayOcupacion[$id_ocupacion] : $ocupacion;

        $resp .= "  <div class='row'>
                        <div class='col-xs-12'>
                            <div class='row' >                                
                                <div class='col-xs-7 col-md-11 col-lg-5'>
                                    <h4 class='text-light'>                               
                                        <b>Nombre del Infractor: </b> $nm_remisor <br>
                                        <b>Edad: </b>: $edad años &nbsp;&nbsp; <b>Sexo: </b> $genero &nbsp;&nbsp; <b>Edo. Físico: </b> $edoFisico<br>
                                        <b>Estudios: </b>: $nvlEstudios &nbsp;&nbsp; <b>Ocupación: </b> $ocupacion <br>
                                        <b>Domicilio: </b>: <br>$domicilio                                        
                                    </h4>
                                </div>
                                <div class='col-xs-7 col-md-11 col-lg-7'>
                                    <table class='table table-hover table-striped'>
                                        <thead>
                                            <tr>
                                                <td width='3%'>Artículo</td>
                                                <td width='10%'>Falta</td>
                                                <td width='20%'>S/M Diario</td>
                                                <td width='40%'>Hr de arresto</td>
                                                <td width='40%'>Total</td>
                                            </tr>
                                        </thead>
                                        <tbody>                                    
                                    </table>
                                </div>
                                <div class='col-xs-7 col-md-11 col-lg-5'>
                                    <a class='btn btn-ink-reaction btn-floating-action btn-danger'
                                        id='btnFollow'
                                        title='Agregar Seguimiento'>
                                        <i class='fa fa-plus'></i>
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
