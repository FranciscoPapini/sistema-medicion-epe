<?php 
$informe = $informeNegocio->recuperar($_GET['id']);
?>
    <div class="container">
      <div class="page-header">
        <h1>Reporte de Informe</h1>
      </div>
      <div id="reporte">
        <div class="row">
          <div class="col-md-12">
           <p><strong>Fecha:</strong> <?php echo Util::DbToDate($informe->getFecha()); ?></p>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <p><strong>Usuario:</strong> <?php if($informe->getUsuario() == '0') { echo '-'; } else { echo ucwords($informe->getUsuario()); } ?></p>
            <p><strong>Inspector:</strong> <?php echo ucwords($informe->getInspector()); ?></p>
            <p><strong>Tipo de Informe:</strong> <?php echo mb_strtoupper($informe->getTipo(), 'UTF-8'); ?></p>
          </div>
          <div class="col-md-6">
            <p><strong>Direcci&oacute;n:</strong> <?php echo ucwords($informe->getDireccion()) . ' - ' . ucwords($informe->getLocalidad()); ?></p>
            <p><strong>Ayudante:</strong> <?php echo ucwords($informe->getAyudante()); ?></p>
            <p><strong>Aprobado:</strong> <?php if($informe->getAprobado() == 0) { echo 'No'; } else { echo 'Si'; } ?></p>
          </div>
        </div>
          <div class="row">
            <div class="col-md-12">
            <p><strong>Descripci&oacute;n:</strong> <?php echo nl2br(ucfirst($informe->getDescripcion())); ?></p>
            </div>
            </div>
      </div>
    </div>