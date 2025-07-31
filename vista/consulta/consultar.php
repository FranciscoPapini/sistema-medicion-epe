<?php
if($_GET['id']) {
      $consulta = $consultaNegocio->recuperar($_GET['id']);
      require_once('negocio/equipoNegocio.php');
      $equipoNegocio = new EquipoNegocio();
      $equipo = $equipoNegocio->recuperar($consulta->getIdEquipo());

      require_once('negocio/controlNegocio.php');
      $controlNegocio = new ControlNegocio();
      $control = $controlNegocio->recuperar($consulta->getIdControl());

      require_once('negocio/transformadorTensionNegocio.php');
      $transformadorTensionNegocio = new TransformadorTensionNegocio();
      $tv = $transformadorTensionNegocio->recuperar($consulta->getIdTv());

      require_once('negocio/transformadorCorrienteNegocio.php');
      $transformadorCorrienteNegocio = new TransformadorCorrienteNegocio();
      $ti = $transformadorCorrienteNegocio->recuperar($consulta->getIdTi());

      require_once('negocio/medidorNegocio.php');
      $medidorNegocio = new MedidorNegocio();
      $medidor = $medidorNegocio->recuperar($consulta->getIdMedidor());

  //    $consultaUltima = $consultaNegocio->getUna($equipo->getId());

      require_once('negocio/lecturaNegocio.php');
?>
    <div class="container" id="non-printable">
      <div class="page-header" id="non-printable">
        <h1>Detalle de Revisi&oacute;n
          <a href="?modulo=consulta&accion=reporte&id=<?php echo $consulta->getId();?>" class="pull-right"><button type="button" class="btn btn-info btn-sm pull-right">Imprimir</button></a>
        </h1>
      </div>

      <div id="reporte" id="printable">

<div class="panel panel-info" >
  <div class="panel-heading">
    <h3 class="panel-title">Datos de Revisi&oacute;n</h3>
  </div>
  <div class="panel-body">

       <div class="row">
          <div class="col-md-6">
            <p><strong>Usuario:</strong> <?php if($equipo->getUsuario() == '0') { echo '-'; } else { echo mb_strtoupper($equipo->getUsuario(), 'UTF-8');}?></p>
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
            <p><strong>Fecha de Revisi&oacute;n:</strong> <?php echo Util::dbToDate($consulta->getFecha()); ?></p> 
          </div> 
          <div class="col-md-6">
            <p><strong>Equipo Funciona Correctamente:</strong> <?php if($consulta->getFunciona() == 0){ echo 'No'; } else { echo 'Si'; } ?></p>
        </div>
    </div>

      <div class="row">
          <div class="col-md-6">
            <p><strong>Inspector:</strong> <?php if($consulta->getInspector() == '0'){ echo '-'; } else { echo ucwords($consulta->getInspector()); } ?></p>
          </div>
          <div class="col-md-6">
            <p><strong>Ayudante:</strong> <?php if($consulta->getAyudante() == '0'){ echo '-'; } else { echo ucwords($consulta->getAyudante()); } ?></p>
          </div>
      </div> 
    <div class="row">
          <div class="col-md-12">
            <p><strong>Curva:</strong> <?php if($consulta->getCurva() == '0'){ echo 'No'; } else { echo 'Si'; } ?></p>
          </div>
    </div>
    <div class="row">
          <div class="col-md-12">
            <p><strong>Motivo:</strong> <?php if($consulta->getMotivo() == '0') { echo '-'; } else { echo ucfirst($consulta->getMotivo()); }?></p>
          </div>
    </div>
    <div class="row">
        <div class="col-md-12">
          <p><strong>Descripci&oacute;n:</strong> <?php if($consulta->getDescripcion() == '0'){ echo '-'; } else { echo nl2br(ucfirst($consulta->getDescripcion())); } ?></p>  
        </div>
    </div>

    <div class="row">
          <div class="col-md-12">
            <p><strong>Precintos:</strong> <?php if($consulta->getPrecintos() == '0') { echo '-'; } else { echo nl2br(strtoupper($consulta->getPrecintos())); }?></p>  
          </div>
    </div>

<br/>

  <div class="row">
          <div class="col-md-6">
            <p><strong>Tipo de Medidor:</strong> <?php if($medidor->getId() == 1) { echo '-'; } else { echo strtoupper($medidor->getTipo()) . ' - Cte. ' . $medidor->getConstante(); } ?></p>
          </div>
          <div class="col-md-6">
            <p><strong>Nro. de Medidor:</strong> <?php if($consulta->getNroMedidor() == '0') { echo '-'; } else { echo $consulta->getNroMedidor();}?></p>
          </div>
  </div>

<?php 
if($consulta->getRespaldo() == ('on' || 1)) {

} else {

?>
<div class="row">
      <div class="col-md-12">
          <p><strong>Medidor de Respaldo:</strong> No</p>
      </div>
</div>

<?php
}

  if ($consulta->getMediaTension() == 0){

  if($consulta->getRelacionTi() == '0') {
  $multiplicacion = '';
  } else {
  list($nro_max, $nro_min) = explode("/", $consulta->getRelacionTi());
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

  if($consulta->getCabina() == 1 || $consulta->getRelacionTi() == '0') { 
  $multiplicacion = '';
  } else {
  list($nro_max, $nro_min) = explode("/", $consulta->getRelacionTi());
  $multiplicacion = ($nro_max / $nro_min) * ($consulta->getCabina() / 110);
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
if ($consulta->getMediaTension() == 1) {
?>

         <div class="col-md-6">
              <p><strong>Tipo de TV:</strong> <?php if($tv->getId() == 1) { echo '-'; } else { echo strtoupper($tv->getTipo()) . ' - ' . strtoupper($tv->getClase()) . ' - ' . strtoupper($tv->getPrestacion());}?></p>  
              <p><strong>Nro. TV fase R:</strong> <?php if($consulta->getNroTvR() == '0') { echo '-'; } else { echo $consulta->getNroTvR();}?></p>  
              <p><strong>Nro. TV fase S:</strong> <?php if($consulta->getNroTvS() == '0') { echo '-'; } else { echo $consulta->getNroTvS();}?></p>  
               <p><strong>Nro. TV fase T:</strong> <?php if($consulta->getNroTvT() == '0') { echo '-'; } else { echo $consulta->getNroTvT();}?></p>  
        </div>

<?php 
} else {
?>
          <div class="col-md-6">
              <p><strong>Tipo de Controles:</strong> <?php if($control->getId() == 1) { echo '-'; } else { echo strtoupper($control->getTipo()) . ' - Cte. ' . $control->getConstante() . ' (X ' . $controlMultiplicacion . ')';}?></p>
              <p><strong>Nro. Control fase R:</strong> <?php if($consulta->getNroControlR() == '0') { echo '-'; } else { echo $consulta->getNroControlR();}?></p> 
              <p><strong>Nro. Control fase S:</strong> <?php if($consulta->getNroControlS() == '0') { echo '-'; } else { echo $consulta->getNroControlS();}?></p> 
              <p><strong>Nro. Control fase T:</strong> <?php if($consulta->getNroControlT() == '0') { echo '-'; } else { echo $consulta->getNroControlT();}?></p> 
          </div>

<?php 
}
?>

         <div class="col-md-6">
            <p><strong>Tipo de TI:</strong> <?php if($ti->getId() == 1) { echo '-'; } else { echo strtoupper($ti->getTipo()) . ' - ' . strtoupper($ti->getClase()) . ' - ' . strtoupper($ti->getPrestacion());}?></p>  
            <p><strong>Nro. TI fase R:</strong> <?php if($consulta->getNroTiR() == '0') { echo '-'; } else { echo $consulta->getNroTiR();}?></p>  
            <p><strong>Nro. TI fase S:</strong> <?php if($consulta->getNroTiS() == '0') { echo '-'; } else { echo $consulta->getNroTiS();}?></p>  
             <p><strong>Nro. TI fase T:</strong> <?php if($consulta->getNroTiT() == '0') { echo '-'; } else { echo $consulta->getNroTiT();}?></p> 
          </div>
    </div>


    <div class="row">
          <div class="col-md-6">
              <p><strong>Relaci&oacute;n de TV:</strong> <?php if($consulta->getCabina() == '0') { echo '380 V'; } else { if ($consulta->getCabina() == '1') { echo 'No Especificado'; } else { echo $consulta->getCabina() . ' V'; } }?></p>
          </div>
          <div class="col-md-6">
              <p><strong>Relaci&oacute;n de TI:</strong> <?php if($consulta->getRelacionTi() == '0') { echo '-'; } else { if($multiplicacion == '') { echo $consulta->getRelacionTi(); } else { echo $consulta->getRelacionTi() . ' (X ' . $multiplicacion . ')'; } }?></p> 
          </div>        
    </div>

<?php

if($equipo->getMediaTension() == 1)
{
?>
    <div class="row">
          <div class="col-md-6">
              <p><strong>Tipo de Controles:</strong> <?php if($control->getId() == 1) { echo '-'; } else { echo strtoupper($control->getTipo()) . ' - Cte. ' . $control->getConstante() . ' (X ' . $controlMultiplicacion . ')';}?></p>
              <p><strong>Nro. Control fase R:</strong> <?php if($consulta->getNroControlR() == '0') { echo '-'; } else { echo $consulta->getNroControlR();}?></p> 
              <p><strong>Nro. Control fase S:</strong> <?php if($consulta->getNroControlS() == '0') { echo '-'; } else { echo $consulta->getNroControlS();}?></p> 
              <p><strong>Nro. Control fase T:</strong> <?php if($consulta->getNroControlT() == '0') { echo '-'; } else { echo $consulta->getNroControlT();}?></p> 
          </div>

<?php 
if ($consulta->getMediaTension() == 0) { $pot = 'BT'; } else { $pot = 'MT'; }
?>    
          <div class="col-md-6">
            <p><strong>Potencia:</strong> <?php if($consulta->getPotencia() == '0') { echo '- '.$pot; } else { echo $consulta->getPotencia() . ' KW ' . $pot;}?></p>  
            <p><strong>Equipo Retirado:</strong> <?php if($consulta->getRetirado() == 0){ echo 'No'; } else { echo 'Si'; } ?></p>
            <p><strong>Telemedici&oacute;n:</strong> <?php if($consulta->getTelemedicion() == 0){ echo 'No'; } else { echo 'Si'; } ?></p>
          </div>  
    </div>
<?php
}

if ($consulta->getMediaTension() == 0) { $pot = 'BT'; } else { $pot = 'MT'; }
if ($consulta->getMediaTension() == 1) 
{

} else {
?>    

    <div class="row">
          <div class="col-md-6">
            <p><strong>Potencia:</strong> <?php if($consulta->getPotencia() == '0') { echo '- '.$pot; } else { echo $consulta->getPotencia() . ' KW ' . $pot;}?></p>  
          </div>
          <div class="col-md-6">
            <p><strong>Equipo Retirado:</strong> <?php if($consulta->getRetirado() == 0){ echo 'No'; } else { echo 'Si'; } ?></p>
          </div>
    </div>
    <div class="row">
          <div class="col-md-6">
            <p><strong>Telemedici&oacute;n:</strong> <?php if($consulta->getTelemedicion() == 0){ echo 'No'; } else { echo 'Si'; } ?></p>
          </div>
    </div>

<?php 
}
?>

<hr>

  <h4>Estados de Medidor</h4>
     <div class="row">
          <div class="col-md-6">
              <p><strong>Toma de Lectura:</strong> <?php if($consulta->getLeido() == ('on' || 1) || $consulta->getLeido4() == ('on' || 1)) { echo 'Si'; } else { echo 'No'; } ?>
              </p>
          </div>
          <div class="col-md-6">
              <p><strong>Reseteo de Medidor:</strong> <?php if($consulta->getLeido4() == 0){ echo 'No'; } else { echo 'Si'; } ?></p>
          </div>  
    </div>  

<?php 
      
      if($consulta->getLeido4() == ('on' || 1)) {
  ?>
  <hr>
    <div class="row">
          <div class="col-md-6">
          <h4>Estados antes del Reseteo</h4>
          </div>
    </div>
  <?php
      }
            if($consulta->getLeido() == ('on' || 1)) {

                $lecturaNegocio = new LecturaNegocio();
                $lectura = $lecturaNegocio->recuperarUna($consulta->getId(), 0);
?>
    <div class="row">
          <div class="col-md-3">
                <p><strong>4:</strong> <?php echo $lectura->getCuatro(); ?></p>
                <p><strong>5:</strong> <?php echo $lectura->getCinco(); ?></p>
          </div>
          <div class="col-md-3">
                <p><strong>6:</strong> <?php echo $lectura->getSeis(); ?></p>
                <p><strong>9:</strong> <?php echo $lectura->getNueve(); ?></p>
              </div>
         <div class="col-md-3">
                <p><strong>10:</strong> <?php echo $lectura->getDies(); ?></p>
                <p><strong>13:</strong> <?php echo $lectura->getTrece(); ?></p>
              </div>   
          <div class="col-md-3">
                <p><strong>14:</strong> <?php echo $lectura->getCatorce(); ?></p>
                <p><strong>16:</strong> <?php echo $lectura->getDieciseis(); ?></p>
          </div>
    </div>

</br>

    <div class="row">
          <div class="col-md-3">
                <p><strong>34:</strong> <?php echo $lectura->getTreintaycuatro(); ?></p>
                <p><strong>35:</strong> <?php echo $lectura->getTreintaycinco(); ?></p>
                <p><strong>36:</strong> <?php echo $lectura->getTreintayseis(); ?></p>
          </div>
          <div class="col-md-3">
                <p><strong>37:</strong> <?php echo $lectura->getTreintaysiete(); ?></p>
                <p><strong>39:</strong> <?php echo $lectura->getTreintaynueve(); ?></p>
                <p><strong>40:</strong> <?php echo $lectura->getCuarenta(); ?></p>
          </div>
          <div class="col-md-3">
                <p><strong>41:</strong> <?php echo $lectura->getCuarentayuno(); ?></p>
                <p><strong>43:</strong> <?php echo $lectura->getCuarentaytres(); ?></p>
                <p><strong>44:</strong> <?php echo $lectura->getCuarentaycuatro(); ?></p> 
          </div>   
          <div class="col-md-3">
                <p><strong>45:</strong> <?php echo $lectura->getCuarentaycinco(); ?></p>
                <p><strong>46:</strong> <?php echo $lectura->getCuarentayseis(); ?></p>
                <p>&nbsp;</p>
          </div>
    </div> 

</br>

    <div class="row">
          <div class="col-md-3">
                <p><strong>R:</strong> <?php echo $lectura->getErre(); ?></p>
          </div>
          <div class="col-md-3">
                <p><strong>S:</strong> <?php echo $lectura->getEse(); ?></p>
          </div>
          <div class="col-md-3">
                <p><strong>T:</strong> <?php echo $lectura->getTe(); ?></p>
          </div>  
          <div class="col-md-3">
                <p><strong>19:</strong> <?php echo $lectura->getDiecinueve(); ?></p>
          </div>
    </div>
<?php 
          }

           if($consulta->getLeido4() == ('on' || 1) && $consulta->getLeido() == 0) {
?>
    <div class="row">
          <div class="col-md-6">
              <p><strong>Estados:</strong> No se tom&oacute; estado</p>
          </div>
    </div>
<?php
          }
          
          if($consulta->getLeido4() == ('on' || 1)) {
?>

<hr>
<h4>Estados despu&eacute;s del Reseteo</h4>
<?php 
                $lecturaNegocio = new LecturaNegocio();
                $lectura3 = $lecturaNegocio->recuperarUna($consulta->getId(), 2);
?>
    <div class="row">
          <div class="col-md-3">
              <p><strong>4:</strong> <?php echo $lectura3->getCuatro(); ?></p>
              <p><strong>5:</strong> <?php echo $lectura3->getCinco(); ?></p>
          </div>
          <div class="col-md-3">
              <p><strong>6:</strong> <?php echo $lectura3->getSeis(); ?></p>
              <p><strong>9:</strong> <?php echo $lectura3->getNueve(); ?></p>
              </div>
          <div class="col-md-3">
              <p><strong>10:</strong> <?php echo $lectura3->getDies(); ?></p>
              <p><strong>13:</strong> <?php echo $lectura3->getTrece(); ?></p>
              </div>   
          <div class="col-md-3">
              <p><strong>14:</strong> <?php echo $lectura3->getCatorce(); ?></p>
              <p><strong>16:</strong> <?php echo $lectura3->getDieciseis(); ?></p>
          </div>
    </div>

</br>

       <div class="row">
          <div class="col-md-3">
              <p><strong>34:</strong> <?php echo $lectura3->getTreintaycuatro(); ?></p>
              <p><strong>35:</strong> <?php echo $lectura3->getTreintaycinco(); ?></p>
              <p><strong>36:</strong> <?php echo $lectura3->getTreintayseis(); ?></p>
          </div>
          <div class="col-md-3">
              <p><strong>37:</strong> <?php echo $lectura3->getTreintaysiete(); ?></p>
              <p><strong>39:</strong> <?php echo $lectura3->getTreintaynueve(); ?></p>
              <p><strong>40:</strong> <?php echo $lectura3->getCuarenta(); ?></p>
          </div>
          <div class="col-md-3">
              <p><strong>41:</strong> <?php echo $lectura3->getCuarentayuno(); ?></p>
              <p><strong>43:</strong> <?php echo $lectura3->getCuarentaytres(); ?></p>
              <p><strong>44:</strong> <?php echo $lectura3->getCuarentaycuatro(); ?></p> 
          </div>   
          <div class="col-md-3">
              <p><strong>45:</strong> <?php echo $lectura3->getCuarentaycinco(); ?></p>
              <p><strong>46:</strong> <?php echo $lectura3->getCuarentayseis(); ?></p>
              <p>&nbsp;</p>
          </div>
      </div> 
  
</br>

    <div class="row">
          <div class="col-md-3">
            <p><strong>R:</strong> <?php echo $lectura3->getErre(); ?></p>
          </div>
          <div class="col-md-3">
            <p><strong>S:</strong> <?php echo $lectura3->getEse(); ?></p>
          </div>
          <div class="col-md-3">
            <p><strong>T:</strong> <?php echo $lectura3->getTe(); ?></p>
          </div>  
          <div class="col-md-3">
            <p><strong>19:</strong> <?php echo $lectura3->getDiecinueve(); ?></p>
          </div>
    </div>
<?php 
           }


if($consulta->getRespaldo() == ('on' || 1))
{
?>

<hr>
  <h4>Medidor de Respaldo</h4>

      <?php 
      

      $medidor_respaldo = $medidorNegocio->recuperar($consulta->getIdMedidorRespaldo());


      ?>  
      <div class="row">
          <div class="col-md-12">
              <p><strong>Retiro de Medidor de Respaldo:</strong> <?php if($consulta->getRetiroRespaldo() == ('on' || 1)) { echo 'Si'; } else { echo 'No'; }?></p>
          </div>
      </div>
      <div class="row">
          <div class="col-md-6">
              <p><strong>Tipo de Medidor de Respaldo:</strong> <?php echo strtoupper($medidor_respaldo->getTipo()) . ' - Cte. ' . strtoupper($medidor_respaldo->getConstante()); ?></p>
          </div>
          <div class="col-md-6">
                <p><strong>Nro. de Medidor de Respaldo:</strong> <?php echo $consulta->getNroMedidorRespaldo(); ?></p>
          </div>
      </div>

  <h4>Estados de Medidor de Respaldo</h4>
     <div class="row">
          <div class="col-md-6">
              <p><strong>Toma de Lectura:</strong> <?php if($consulta->getLeido5() == ('on' || 1)) { echo 'Si'; } else { echo 'No'; } ?></p>
          </div>
    </div>  
      <?php
                if($consulta->getLeido5() == ('on' || 1)){

                $lecturaNegocio = new LecturaNegocio();
                $lectura4 = $lecturaNegocio->recuperarUna($consulta->getId(), 3);
?>

    <div class="row">
          <div class="col-md-3">
              <p><strong>4:</strong> <?php echo $lectura4->getCuatro(); ?></p>
              <p><strong>5:</strong> <?php echo $lectura4->getCinco(); ?></p>
          </div>
          <div class="col-md-3">
              <p><strong>6:</strong> <?php echo $lectura4->getSeis(); ?></p>
              <p><strong>9:</strong> <?php echo $lectura4->getNueve(); ?></p>
          </div>
          <div class="col-md-3">
              <p><strong>10:</strong> <?php echo $lectura4->getDies(); ?></p>
              <p><strong>13:</strong> <?php echo $lectura4->getTrece(); ?></p>
          </div>   
          <div class="col-md-3">
              <p><strong>14:</strong> <?php echo $lectura4->getCatorce(); ?></p>
              <p><strong>16:</strong> <?php echo $lectura4->getDieciseis(); ?></p>
          </div>
    </div>

</br>

      <div class="row">
            <div class="col-md-3">
                <p><strong>34:</strong> <?php echo $lectura4->getTreintaycuatro(); ?></p>
                <p><strong>35:</strong> <?php echo $lectura4->getTreintaycinco(); ?></p>
                <p><strong>36:</strong> <?php echo $lectura4->getTreintayseis(); ?></p>
            </div>
            <div class="col-md-3">
                <p><strong>37:</strong> <?php echo $lectura4->getTreintaysiete(); ?></p>
                <p><strong>39:</strong> <?php echo $lectura4->getTreintaynueve(); ?></p>
                <p><strong>40:</strong> <?php echo $lectura4->getCuarenta(); ?></p>
            </div>
            <div class="col-md-3">
                  <p><strong>41:</strong> <?php echo $lectura4->getCuarentayuno(); ?></p>
                  <p><strong>43:</strong> <?php echo $lectura4->getCuarentaytres(); ?></p>
                  <p><strong>44:</strong> <?php echo $lectura4->getCuarentaycuatro(); ?></p> 
            </div>   
            <div class="col-md-3">
                  <p><strong>45:</strong> <?php echo $lectura4->getCuarentaycinco(); ?></p>
                  <p><strong>46:</strong> <?php echo $lectura4->getCuarentayseis(); ?></p>
                  <p>&nbsp;</p>
            </div>
      </div> 
  
</br>

  <div class="row">
          <div class="col-md-3">
              <p><strong>R:</strong> <?php echo $lectura4->getErre(); ?></p>
          </div>
          <div class="col-md-3">
              <p><strong>S:</strong> <?php echo $lectura4->getEse(); ?></p>
          </div>
          <div class="col-md-3">
              <p><strong>T:</strong> <?php echo $lectura4->getTe(); ?></p>
          </div>  
          <div class="col-md-3">
              <p><strong>19:</strong> <?php echo $lectura4->getDiecinueve(); ?></p>
          </div>
  </div>
<?php 

} //si hay lectura de respaldo

} //si hay respaldo
?>



<hr>
  <h4>Retiro de Medidor</h4>
     <div class="row">
          <div class="col-md-6">
<p><strong>Medidor Retirado:</strong> <?php if($consulta->getLeido2() == ('on' || 1)) { echo 'Si'; } else { echo 'No'; } ?></p>
      </div>

      </div>

      <?php 
        if($consulta->getLeido2() == ('on' || 1)) {
      

      $medidor_ret = $medidorNegocio->recuperar($consulta->getIdMedidorRet());


      ?>  
      <div class="row">
          <div class="col-md-6">
              <p><strong>Tipo de Medidor Retirado:</strong> <?php echo strtoupper($medidor_ret->getTipo()) . ' - Cte. ' . strtoupper($medidor_ret->getConstante()); ?></p>
          </div>
          <div class="col-md-6">
                <p><strong>Nro. de Medidor Retirado:</strong> <?php echo $consulta->getNroMedidorRet(); ?></p>
          </div>
      </div>
<?php 
        }

  if ($consulta->getLeido2() == ('on' || 1)) {
?>
<hr>
  <h4>Estados de Medidor Retirado</h4>
     <div class="row">
          <div class="col-md-6">
              <p><strong>Toma de Lectura:</strong> <?php if($consulta->getLeido3() == ('on' || 1)) { echo 'Si'; } else { echo 'No'; } ?></p>
          </div>
    </div>  
      <?php
            if($consulta->getLeido3() == ('on' || 1)) {

                $lecturaNegocio = new LecturaNegocio();
                $lectura2 = $lecturaNegocio->recuperarUna($consulta->getId(), 1);
?>

    <div class="row">
          <div class="col-md-3">
              <p><strong>4:</strong> <?php echo $lectura2->getCuatro(); ?></p>
              <p><strong>5:</strong> <?php echo $lectura2->getCinco(); ?></p>
          </div>
          <div class="col-md-3">
              <p><strong>6:</strong> <?php echo $lectura2->getSeis(); ?></p>
              <p><strong>9:</strong> <?php echo $lectura2->getNueve(); ?></p>
          </div>
          <div class="col-md-3">
              <p><strong>10:</strong> <?php echo $lectura2->getDies(); ?></p>
              <p><strong>13:</strong> <?php echo $lectura2->getTrece(); ?></p>
          </div>   
          <div class="col-md-3">
              <p><strong>14:</strong> <?php echo $lectura2->getCatorce(); ?></p>
              <p><strong>16:</strong> <?php echo $lectura2->getDieciseis(); ?></p>
          </div>
    </div>

</br>

      <div class="row">
            <div class="col-md-3">
                <p><strong>34:</strong> <?php echo $lectura2->getTreintaycuatro(); ?></p>
                <p><strong>35:</strong> <?php echo $lectura2->getTreintaycinco(); ?></p>
                <p><strong>36:</strong> <?php echo $lectura2->getTreintayseis(); ?></p>
            </div>
            <div class="col-md-3">
                <p><strong>37:</strong> <?php echo $lectura2->getTreintaysiete(); ?></p>
                <p><strong>39:</strong> <?php echo $lectura2->getTreintaynueve(); ?></p>
                <p><strong>40:</strong> <?php echo $lectura2->getCuarenta(); ?></p>
            </div>
            <div class="col-md-3">
                  <p><strong>41:</strong> <?php echo $lectura2->getCuarentayuno(); ?></p>
                  <p><strong>43:</strong> <?php echo $lectura2->getCuarentaytres(); ?></p>
                  <p><strong>44:</strong> <?php echo $lectura2->getCuarentaycuatro(); ?></p> 
            </div>   
            <div class="col-md-3">
                  <p><strong>45:</strong> <?php echo $lectura2->getCuarentaycinco(); ?></p>
                  <p><strong>46:</strong> <?php echo $lectura2->getCuarentayseis(); ?></p>
                  <p>&nbsp;</p>
            </div>
      </div> 
  
</br>

  <div class="row">
          <div class="col-md-3">
              <p><strong>R:</strong> <?php echo $lectura2->getErre(); ?></p>
          </div>
          <div class="col-md-3">
              <p><strong>S:</strong> <?php echo $lectura2->getEse(); ?></p>
          </div>
          <div class="col-md-3">
              <p><strong>T:</strong> <?php echo $lectura2->getTe(); ?></p>
          </div>  
          <div class="col-md-3">
              <p><strong>19:</strong> <?php echo $lectura2->getDiecinueve(); ?></p>
          </div>
  </div>
<?php 
           }

         }
?>
      </div>
      </div>

    <button type="button" onclick="window.close();" class="btn btn-default btn-block">Cerrar Ventana</button>
<?php

} else {
  Util::setMjs('Debe seleccionar una revisi&oacute;n','warning');
  header('Location: ?modulo=equipo&accion=listar');
  die();
}
?>

</div>
</div>

</div>
</div>