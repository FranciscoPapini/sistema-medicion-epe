<?php 
      require_once('negocio/medidorNegocio.php');
      $medidorNegocio = new MedidorNegocio();

      require_once('negocio/consultaNegocio.php');
      $consultaNegocio = new ConsultaNegocio();
?>
    <div class="container">

      <div class="page-header" >
        <h1>Equipos sin Visitas Recientes
         <a href="?modulo=equipo&accion=reporteSinVisitas" target="_blank" class="pull-right"><button type="button" class="btn btn-info btn-sm pull-right">Imprimir</button></a>
        </h1>
      </div>
      <?php echo Util::getMsj(); ?>
      <div class="table-responsive text-nowrap">
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

        $fecha = Util::dateToDb(date('d/m/Y'));

          $arrayEquipos = $equipoNegocio->listarTodos();
          if( count($arrayEquipos) > 0 ){
            foreach( $arrayEquipos as $equipo ){
              $consulta = $consultaNegocio->getUna($equipo->getId());  

              $date2=date_create($consulta->getFecha());
              $date1=date_create($fecha);
              $diff=date_diff($date2,$date1);

              if( $diff->days > 280 || is_null($consulta->getId()) ){
              $medidor = $medidorNegocio->recuperar($equipo->getIdMedidor());

?>
               <tr>
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

            }

          }else{
          ?>
          <tr>
            <td colspan="6">No se encontraron resultados</td>
          </tr>
          <?php
          }
          ?>
        </tbody>
      </table>
      </div>
    </div>