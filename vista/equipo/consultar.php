<?php
      $equipo = $equipoNegocio->recuperar($_GET['id']);
      require_once('negocio/controlNegocio.php');
      $controlNegocio = new ControlNegocio();
      $control = $controlNegocio->recuperar($equipo->getIdControl());

      require_once('negocio/transformadorTensionNegocio.php');
      $transformadorTensionNegocio = new TransformadorTensionNegocio();
      $tv = $transformadorTensionNegocio->recuperar($equipo->getIdTv());

      require_once('negocio/transformadorCorrienteNegocio.php');
      $transformadorCorrienteNegocio = new TransformadorCorrienteNegocio();
      $ti = $transformadorCorrienteNegocio->recuperar($equipo->getIdTi());

      require_once('negocio/medidorNegocio.php');
      $medidorNegocio = new MedidorNegocio();
      $medidor = $medidorNegocio->recuperar($equipo->getIdMedidor());
      $medidor_respaldo = $medidorNegocio->recuperar($equipo->getIdMedidorRespaldo());

?>
    <div class="container" id="non-printable">
      <div class="page-header" id="non-printable">
        <h1>Detalle de Equipo
          <a href="?modulo=equipo&accion=reporte&id=<?php echo $equipo->getId();?>" class="pull-right"><button type="button" class="btn btn-info btn-sm pull-right">Imprimir</button></a>
        </h1>
      </div>

      <div id="reporte" id="printable">
  
<div class="panel panel-info" >
  <div class="panel-heading">
    <h3 class="panel-title">Datos de Equipo</h3>
  </div>
  <div class="panel-body">

       <div class="row">
          <div class="col-md-6">
            <p><strong>Usuario: </strong><?php if($equipo->getUsuario() == '0') { echo '-'; } else { echo mb_strtoupper($equipo->getUsuario(), 'UTF-8');}?></p>
            </div>  
            <div class="col-md-6">
            <p><strong>Fecha de Alta:</strong> <?php if($equipo->getAlta() == '0000-00-00') { echo '-'; } else { echo Util::dbToDate($equipo->getAlta()); } ?></p>
            </div> 
        </div>

    <div class="row">
          <div class="col-md-6">
            <p><strong>Ruta:</strong> <?php if($equipo->getRuta() == '0') { echo '-'; } else { echo $equipo->getRuta();}?></p>
          </div>
          <div class="col-md-6">
            <p><strong>Folio:</strong> <?php if($equipo->getFolio() == '0') { echo '-'; } else { echo $equipo->getFolio();}?></p>
          </div>
    </div>

    <div class="row">
          <div class="col-md-6">
          <p><strong>Direcci&oacute;n:</strong> <?php if($equipo->getLocalidad() == '0') { echo '-'; } else { echo ucwords($equipo->getDireccion()) . ' - ' . ucwords($equipo->getLocalidad());}?></p> 
          </div>
          <div class="col-md-6">
          <p><strong>Coordenadas:</strong> <?php if($equipo->getLatitud() == 0) { echo '-'; } else { echo $equipo->getLatitud() . ', ' . $equipo->getLongitud(); }?></p> 
          </div>
    </div>


<hr>

    <div class="row">
          <div class="col-md-6">
            <p><strong>Tipo de Medidor:</strong> <?php if($medidor->getId() == 1) { echo '-'; } else { echo strtoupper($medidor->getTipo()) . ' - Cte. ' . $medidor->getConstante(); } ?></p>
          </div>
          <div class="col-md-6">
          <p><strong>Nro. de Medidor:</strong> <?php if($equipo->getNroMedidor() == '0') { echo '-'; } else { echo $equipo->getNroMedidor();}?></p>
          </div>
    </div>

<?php 
if($equipo->getRespaldo() == ('on' || 1)){
?>
    <div class="row">
          <div class="col-md-6">
            <p><strong>Tipo de Medidor de Respaldo:</strong> <?php if($medidor_respaldo->getId() == 1) { echo '-'; } else { echo strtoupper($medidor_respaldo->getTipo()) . ' - Cte. ' . $medidor_respaldo->getConstante(); } ?></p>
          </div>
          <div class="col-md-6">
          <p><strong>Nro. de Medidor de Respaldo:</strong> <?php if($equipo->getNroMedidorRespaldo() == '0') { echo '-'; } else { echo $equipo->getNroMedidorRespaldo();}?></p>
          </div>
    </div>

<?php
} else {
?>
    <div class="row">
          <div class="col-md-12">
            <p><strong>Medidor de Respaldo:</strong> No</p>
          </div>
    </div>
<?php
} //si hay respaldo

if ($equipo->getMediaTension() == 0){

if($equipo->getRelacionTi() == '0') {
$multiplicacion = '';
} else {
list($nro_max, $nro_min) = explode("/", $equipo->getRelacionTi());
$multiplicacion = ($nro_max / $nro_min);

$decimal = $control->getDecima();
switch ($decimal) {
  case '0':
    $division = 1;
    break;
  case '1':
    $division = 10;
    break;
  case '2':
    $division = 100;
    break;
  case '3':
    $division = 1000;
    break;          
  default:
    break;
}
$controlMultiplicacion = ($multiplicacion / $division);

}

} else {

if($equipo->getCabina() == 1 || $equipo->getRelacionTi() == '0') { 
$multiplicacion = '';
} else {
list($nro_max, $nro_min) = explode("/", $equipo->getRelacionTi());
$multiplicacion = ($nro_max / $nro_min) * ($equipo->getCabina() / 110);

$decimal = $control->getDecima();
switch ($decimal) {
  case '0':
    $division = 1;
    break;
  case '1':
    $division = 10;
    break;
  case '2':
    $division = 100;
    break;
  case '3':
    $division = 1000;
    break;          
  default:
    break;
}
$controlMultiplicacion = ($multiplicacion / $division);


}

}

?>
    <div class="row">

<?php 
if ($equipo->getMediaTension() == 1) {
?>
         <div class="col-md-6">
        <p><strong>Tipo de TV:</strong> <?php if($tv->getId() == 1) { echo '-'; } else { echo strtoupper($tv->getTipo()) . ' - ' . strtoupper($tv->getClase()) . ' - ' . strtoupper($tv->getPrestacion());}?></p>  
        <p><strong>Nro. TV fase R:</strong> <?php if($equipo->getNroTvR() == '0') { echo '-'; } else { echo $equipo->getNroTvR();}?></p>  
        <p><strong>Nro. TV fase S:</strong> <?php if($equipo->getNroTvS() == '0') { echo '-'; } else { echo $equipo->getNroTvS();}?></p>  
         <p><strong>Nro. TV fase T:</strong> <?php if($equipo->getNroTvT() == '0') { echo '-'; } else { echo $equipo->getNroTvT();}?></p>  
        </div>

<?php 
} else {
?>

          <div class="col-md-6">
          <p><strong>Tipo de Controles:</strong> <?php if($control->getId() == 1) { echo '-'; } else { echo strtoupper($control->getTipo()) . ' - Cte. ' . $control->getConstante() . ' (X ' . $controlMultiplicacion . ')';}?></p>
                    <p><strong>Nro. Control fase R:</strong> <?php if($equipo->getNroControlR() == '0') { echo '-'; } else { echo $equipo->getNroControlR();}?></p> 
          <p><strong>Nro. Control fase S:</strong> <?php if($equipo->getNroControlS() == '0') { echo '-'; } else { echo $equipo->getNroControlS();}?></p> 
          <p><strong>Nro. Control fase T:</strong> <?php if($equipo->getNroControlT() == '0') { echo '-'; } else { echo $equipo->getNroControlT();}?></p> 
          </div>


<?php 
}
?>

         <div class="col-md-6">
        <p><strong>Tipo de TI:</strong> <?php if($ti->getId() == 1) { echo '-'; } else { echo strtoupper($ti->getTipo()) . ' - ' . strtoupper($ti->getClase()) . ' - ' . strtoupper($ti->getPrestacion());}?></p>  
        <p><strong>Nro. TI fase R:</strong> <?php if($equipo->getNroTiR() == '0') { echo '-'; } else { echo $equipo->getNroTiR();}?></p>  
        <p><strong>Nro. TI fase S:</strong> <?php if($equipo->getNroTiS() == '0') { echo '-'; } else { echo $equipo->getNroTiS();}?></p>  
         <p><strong>Nro. TI fase T:</strong> <?php if($equipo->getNroTiT() == '0') { echo '-'; } else { echo $equipo->getNroTiT();}?></p>  
        </div>
  </div>

    <div class="row">
          <div class="col-md-6">
          <p><strong>Relaci&oacute;n de TV:</strong> <?php if($equipo->getCabina() == '0') { echo '380 V'; } else { if ($equipo->getCabina() == '1') { echo 'No Especificado'; } else { echo $equipo->getCabina() . ' V'; } }?></p>
                  </div>
          <div class="col-md-6">
           <p><strong>Relaci&oacute;n de TI:</strong> <?php if($equipo->getRelacionTi() == '0') { echo '-'; } else { if($multiplicacion == '') { echo $equipo->getRelacionTi(); } else { echo $equipo->getRelacionTi() . ' (X ' . $multiplicacion . ')'; } }?></p> 
          </div>       
    </div>

<?php

if($equipo->getMediaTension() == 1)
{
?>
    <div class="row">
        <div class="col-md-6">
        <p><strong>Tipo de Controles:</strong> <?php if($control->getId() == 1) { echo '-'; } else { echo strtoupper($control->getTipo()) . ' - Cte. ' . $control->getConstante() . ' (X ' . $controlMultiplicacion . ')';}?></p>
          <p><strong>Nro. Control fase R:</strong> <?php if($equipo->getNroControlR() == '0') { echo '-'; } else { echo $equipo->getNroControlR();}?></p> 
          <p><strong>Nro. Control fase S:</strong> <?php if($equipo->getNroControlS() == '0') { echo '-'; } else { echo $equipo->getNroControlS();}?></p> 
          <p><strong>Nro. Control fase T:</strong> <?php if($equipo->getNroControlT() == '0') { echo '-'; } else { echo $equipo->getNroControlT();}?></p> 
          </div>

        <div class="col-md-6">
<?php    
  if ($equipo->getMediaTension() == 0) { $pot = 'BT'; } else { $pot = 'MT'; } 
?>

        <p><strong>Potencia:</strong> <?php if($equipo->getPotencia() == '0') { echo '- '.$pot; } else { echo $equipo->getPotencia() . ' KW '.$pot;}?></p>  

        <p><strong>Equipo Retirado:</strong> <?php if($equipo->getRetirado() == 0){ echo 'No'; } else { echo 'Si'; } ?></p>

        <p><strong>Telemedici&oacute;n:</strong> <?php if($equipo->getTelemedicion() == 0){ echo 'No'; } else { echo 'Si'; } ?></p>

        <p><strong>Observaci&oacute;n:</strong> <?php if($equipo->getObservacion() == '0'){ echo '-'; } else { echo ucfirst($equipo->getObservacion()); } ?></p>
        </div>  
  
    </div>
<?php
}

if ($equipo->getMediaTension() == 0) { $pot = 'BT'; } else { $pot = 'MT'; }
if ($equipo->getMediaTension() == 1) 
{

} else {
?>    
    <div class="row">
          <div class="col-md-6">
          <p><strong>Potencia:</strong> <?php if($equipo->getPotencia() == '0') { echo '- '.$pot; } else { echo $equipo->getPotencia() . ' KW '.$pot;}?></p>  
          </div>
          <div class="col-md-6">
          <p><strong>Equipo Retirado:</strong> <?php if($equipo->getRetirado() == 0){ echo 'No'; } else { echo 'Si'; } ?></p>
          </div>
      </div>

    <div class="row">
          <div class="col-md-6">
          <p><strong>Telemedici&oacute;n:</strong> <?php if($equipo->getTelemedicion() == 0){ echo 'No'; } else { echo 'Si'; } ?></p>
          </div>
          <div class="col-md-6">
          <p><strong>Observaci&oacute;n:</strong> <?php if($equipo->getObservacion() == '0'){ echo '-'; } else { echo ucfirst($equipo->getObservacion()); } ?></p>
        </div>
    </div>

<?php 
}
?>
    </div>
    </div>

            <button type="button" onclick="window.close();" class="btn btn-default btn-block">Cerrar Ventana</button>

    </div>