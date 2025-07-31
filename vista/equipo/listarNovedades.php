<?php 
      require_once('negocio/consultaNegocio.php');
      $consultaNegocio = new ConsultaNegocio();

      $equipoNegocio = new EquipoNegocio();

?>
    <div class="container" >

      <div class="page-header" >
        <h1>Trabajos en Equipos
                  <a href="?modulo=consulta&accion=imprimirTrabajos" target="_blank" class="pull-right"><button type="button" class="btn btn-info btn-sm pull-right">Imprimir Trabajos</button></a>
        </h1>
      </div>                   
      <?php echo Util::getMsj(); ?>
      <table class="table table-striped table-bordered table-hover" id="tableListar">
        <thead>
          <tr>
            <th style="display: none;">Fecha a Ordenar</th>
            <th style="display: none;">Id</th>
            <th style="width:1%">Fecha</th>
            <th style="width:15%">Usuario</th>
            <th style="width:5%">Folio</th>
            <th style="width:25%">Direcci&oacute;n</th>
            <th>Motivo</th>
            <th style="width:10%">Tipo</th>
            <th style="width:1%">Acciones</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $arrayEquipos = $equipoNegocio->listarTodos();
          if( count($arrayEquipos) > 0 ){
            foreach( $arrayEquipos as $equipo ){

                $arrayConsultas = $consultaNegocio->listarOrdenadoCuatro($equipo->getId());
                if ($equipo->getRetirado() == 1) { $estado2 = false; } else { $estado2 = true; }   


                  if ( count($arrayConsultas) > 0){
                  $primero = $arrayConsultas[0];

                    foreach ($arrayConsultas as $consulta) {
                      
                    $resultado = $consulta->getLeido();
                    if($resultado == 0)
                    { $resultado = ''; } 
                    else { $resultado = 'info'; } 

                    $problema = $consulta->getMotivo();
                    if ($problema == '0')
                    { $problema = 'danger'; }
                    else { $problema = ''; }

            if ($consulta->getFunciona() == 0 && $consulta->getMotivo() == '0') { $tipo = 'Reclamo / Problema'; } else { 
            if ($consulta->getFunciona() == 0) { $tipo = 'Revisión sin arreglar'; } else { $tipo = 'Revisión ok'; }
            }

            ?>
              <tr class="<?php echo $problema; ?>">
                <th style="display: none;"><?php echo $consulta->getFecha(); ?></th>
                <th style="display: none;"><?php echo $consulta->getId(); ?></th>
                <td style="width:1%"><?php echo Util::DbToDate($consulta->getFecha());?></td>
                <td style="width:15%"><?php echo ucwords($equipo->getUsuario()); ?></td>
                <td style="width:5%"><?php if($equipo->getFolio() == '0') { echo '-'; } else { echo $equipo->getFolio();}?></td>
                <td style="width:25%"><?php if($equipo->getDireccion() == '0' && $equipo->getLocalidad() == '0') { echo '-'; } else { if($equipo->getDireccion() == '0') { echo ucwords($equipo->getLocalidad()); } else { if($equipo->getLocalidad() == '0') { echo ucwords($equipo->getDireccion()); } else { echo ucwords($equipo->getDireccion()) . ' - ' . ucwords($equipo->getLocalidad());} } } ?></td>

                <td><?php   if ( $consulta->getMotivo() == '0') { if ($consulta->getDescripcion() == '0') { $motivo = ''; } else { $motivo = ucfirst($consulta->getDescripcion()); } } else { if ($consulta->getMotivo() == '0') { $motivo = ''; } else { $motivo = ucfirst($consulta->getMotivo()); } }
                echo $motivo;
                ?></td>

                <td style="width:10%"><?php echo $tipo; ?></td>
                <td style="width:1%">
<?php 
                  if($estado2){
                              
                            if ($primero->getId() == $consulta->getId())
                            {
?> 
                  <a href="?modulo=consulta&accion=editar&id=<?php echo $consulta->getId();?>&id_equipo=<?php echo $equipo->getId(); ?>" data-toggle="tooltip" title="Editar"><span class="glyphicon glyphicon-pencil"></span></a>&nbsp;
<?php 
                        if ($problema == 'danger')
                        { echo ''; } else { 
?>
                  <a href="?modulo=consulta&accion=consultar&id=<?php echo $consulta->getId();?>" data-toggle="tooltip" target="_blank" title="Ver Detalle"><span class="glyphicon glyphicon-eye-open"></span></a>&nbsp;
                  <a href="?modulo=consulta&accion=reporte&id=<?php echo $consulta->getId();?>" data-toggle="tooltip" target="_blank" title="Imprimir"><span class="glyphicon glyphicon-print"></span></a>
<?php                                     
                        }

                        } else { 

                        if ($problema == 'danger')
                        { echo '-'; } else { 
?>
                  <a href="?modulo=consulta&accion=consultar&id=<?php echo $consulta->getId();?>" data-toggle="tooltip"target="_blank" title="Ver Detalle"><span class="glyphicon glyphicon-eye-open"></span></a>&nbsp;
                  <a href="?modulo=consulta&accion=reporte&id=<?php echo $consulta->getId();?>" data-toggle="tooltip" target="_blank" title="Imprimir"><span class="glyphicon glyphicon-print"></span></a>
<?php                     
                        } 
                  }
                }else {

                        if ($problema == 'danger')
                        { echo '-'; } else { 
                   ?>
                <a href="?modulo=consulta&accion=consultar&id=<?php echo $consulta->getId();?>" data-toggle="tooltip" target="_blank" title="Ver Detalle"><span class="glyphicon glyphicon-eye-open"></span></a>&nbsp;
                <a href="?modulo=consulta&accion=reporte&id=<?php echo $consulta->getId();?>" data-toggle="tooltip" target="_blank" title="Imprimir"><span class="glyphicon glyphicon-print"></span></a>
<?php                     
                        }
                }
?>

                </td>
              </tr>
          <?php
                        
                  }

              }

                }
          }else{
          ?>
          <tr>
            <td colspan="9">No se encontraron resultados</td>
          </tr>
          <?php
          }
          ?>
        </tbody>
      </table>
    </div>