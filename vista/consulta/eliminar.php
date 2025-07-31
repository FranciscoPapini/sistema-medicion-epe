<?php

    $valido = false;

    if($valido) { 

    if ($_GET['id']) {
        $consulta = $consultaNegocio->recuperar($_GET['id']);
      
      require_once('negocio/equipoNegocio.php');
      $equipoNegocio = new EquipoNegocio();
      $equipo = $equipoNegocio->recuperar($_GET['id_equipo']);
    
    Util::setMsj('Est&aacute; a punto de eliminar la siguiente revisi&oacute;n:','warning',false);
    
    ?>
    <div class="container id="non-printable">
      <div class="page-header" id="non-printable">
        <h1>Eliminar Revisi&oacute;n</h1>
      </div>
      <?php echo Util::getMsj(); ?>
        <form role="form" method="post">
            <input type="hidden" name="id" value="<?php echo $consulta->getId();?>" >
            <input type="hidden" name="id_equipo" value="<?php echo $_GET['id_equipo'];?>" >
            <input type="hidden" name="retired" value="<?php echo $equipo->getRetirado();?>" >

            <div class="form-group">
                <label for="fecha">Fecha</label>
                <input type="text" class="form-control" id="fecha" name="fecha" readonly placeholder="Fecha" value="<?php if ($consulta->getFecha() == '0000-00-00') { echo '-'; } else { echo Util::dbToDate($consulta->getFecha()); } ?>" >
            </div>

            <div class="form-group">
                <label for="motivo">Motivo</label>
                <input type="text" class="form-control" id="motivo" name="motivo" readonly placeholder="Motivo" value="<?php if($consulta->getMotivo() == '0') { echo '-'; } else { echo ucfirst($consulta->getMotivo());}?>" >
            </div>

            <div class="form-group">
                <label for="descripcion">Descripci&oacute;n</label>
                <input type="text" class="form-control" id="descripcion" name="descripcion" readonly placeholder="Descripci&oacute;n" value="<?php if($consulta->getDescripcion() == '0') { echo '-'; } else { echo ucfirst($consulta->getDescripcion());} ?>" >
            </div>

            <div class="form-group">
                <label for="inspector">Inspector</label>
                <input type="text" class="form-control" id="inspector" name="inspector" readonly placeholder="Inspector" value="<?php if($consulta->getInspector() == '0') { echo '-'; } else { echo ucwords($consulta->getInspector());} ?>" >
            </div>
            <div class="form-group">
                <label for="ayudante">Ayudante</label>
                <input type="text" class="form-control" id="ayudante" name="ayudante" readonly placeholder="Ayudante" value="<?php if($consulta->getAyudante() == '0') { echo '-'; } else { echo ucwords($consulta->getAyudante());} ?>" >
            </div>

          <div class="col-auto">
            <label for="estado">
              <input type="checkbox" id="estado" name="estado" readonly> <?php if($consulta->getLeido() == 1) { echo 'checked'; } ?> > Toma de Lectura
            </label>
                <div class="help-block with-errors"></div>        
  </div>

  


          <button type="button" class="btn btn-default cancelForm">Cancelar</button>
            <button type="submit" class="btn btn-primary">Eliminar</button>
        </form>


<?php
    }
    else {
    Util::setMsj('Debe seleccionar una revisi&oacute;n','warning');
    header('Location:?modulo=equipo&accion=listar');
    }    
?>
    </div>
<?php 
} else { ?>
        <div class="container" id="non-printable">
            <div class="alert alert-danger" role="alert"><b>No puede eliminar la revisi&oacute;n o problema</b></div>
        </div>
<?php 
        die();  
        }
?>