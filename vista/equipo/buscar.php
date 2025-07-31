<div class="container" id="non-printable" >
      <div class="page-header" id="non-printable" >
        <h1>
<?php if ($_GET['arreglo']) {
          echo 'Equipos';
?>
         <button type="button" class="btn btn-primary btn-sm" id="btn-agregar" name="btn-agregar" onclick="document.location='?modulo=equipo&accion=buscar'">Nueva B&uacute;squeda</button>
<?php 
          } else { if($_SESSION['mensaje']) { echo 'Equipo'; } else { echo 'Buscar Equipo'; } } 
          Util::getButton();
          ?>
        </h1>
      </div>
      <?php echo Util::getMsj(); ?>
        <form role="form" method="post" id="principal">

<?php 
if ($_GET['arreglo']) {

    require_once('negocio/medidorNegocio.php');
    $medidorNegocio = new MedidorNegocio();

?>      <div class="table-responsive text-nowrap">
      <table class="table table-striped table-bordered table-hover" id="tableListar">
        <thead>
          <tr>
            <th>Usuario</th>
            <th>Folio</th>
            <th>Direcci&oacute;n</th>
            <th>Localidad</th>
            <th>Medidor</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          <?php

            foreach( $_SESSION['buscador'] as $equipo ){

            $medidor = $medidorNegocio->recuperar($equipo->getIdMedidor());

            if ($equipo->getRetirado() == 1) { $estado = 'prev'; } else { $estado = ''; }
          ?>
              <tr class="<?php echo $estado; ?>" >
                <td><?php echo ucwords($equipo->getUsuario()); ?></td>
                <td><?php if($equipo->getFolio() == '0') { echo '-'; } else { echo $equipo->getFolio();}?></td>
                <td><?php if($equipo->getDireccion() == '0') { echo '-'; } else { echo ucwords($equipo->getDireccion());}?></td>
                <td><?php if($equipo->getLocalidad() == '0') { echo '-'; } else { echo ucwords($equipo->getLocalidad());}?></td>  

                <td><?php if($equipo->getNroMedidor() == '0' && $medidor->getId() == 1) { echo '-'; } else { if($medidor->getId() == 1)  { echo 'Nro: '; echo ucwords($equipo->getNroMedidor()); } else { if($equipo->getNroMedidor() == '0')  { echo strtoupper($medidor->getTipo()); } else { echo strtoupper($medidor->getTipo()); echo ' Nro: '; echo $equipo->getNroMedidor();  }} }?></td>
              <td>
                <?php if ($_SESSION['administrador']['id'] == 1 || $_SESSION['administrador']['id'] == 2 || $_SESSION['administrador']['id'] == 3) 
                { ?>
                  <a href="?modulo=equipo&accion=editar&id=<?php echo $equipo->getId();?>" data-toggle="tooltip" title="Editar Equipo"><span class="glyphicon glyphicon-pencil"></span></a>&nbsp;
                <?php 
                } ?>
                  <a href="?modulo=consulta&accion=listar&id_equipo=<?php echo $equipo->getId();?>" data-toggle="tooltip" title="Listar Revisiones"><span class="glyphicon glyphicon-list"></span></a>&nbsp;
                  <a href="?modulo=equipo&accion=consultar&id=<?php echo $equipo->getId();?>" data-toggle="tooltip" target="_blank" title="Ver Detalle"><span class="glyphicon glyphicon-eye-open"></span></a>&nbsp;
                  <a href="?modulo=equipo&accion=reporte&id=<?php echo $equipo->getId();?>" data-toggle="tooltip" target="_blank" title="Imprimir"><span class="glyphicon glyphicon-print"></span></a>
                </td>
              </tr>
          <?php
            }
          
          ?>
        </tbody>
      </table>
          </div>

<?php
} else {
?>

<div class="row">
            <div class="col-md-12"> 
                <div class="form-group">
                <label for="buscador">Buscar</label>
                <input type="text" class="form-control" id="buscador" name="buscador" placeholder="Ingrese Usuario, Folio, N&uacute;mero de Medidor, Direcci&oacute;n o Localidad" value="" required >
                <div class="help-block with-errors"></div>
            </div>

        </div>
</div>
            <button type="submit" class="btn btn-primary">Buscar</button>

<?php
}
?>
        </form>
</div>