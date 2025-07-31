<?php 
      require_once('negocio/equipoNegocio.php');
      $equipoNegocio = new EquipoNegocio();
      $equipo = $equipoNegocio->recuperar($_GET['id_equipo']);

      require_once('negocio/lecturaNegocio.php');
      $lecturaNegocio = new LecturaNegocio();
?>
    <div class="container" id="non-printable">
    <ol class="breadcrumb" id="non-printable">
        <?php 
        if($equipo->getRetirado() == 0 && ($_SESSION['administrador']['id'] != 1 && $_SESSION['administrador']['id'] != 2 && $_SESSION['administrador']['id'] != 3)){
        ?>
              <li class="active"><?php echo $equipo->getFolio() . ' - ' . mb_strtoupper($equipo->getUsuario(), 'UTF-8'); ?></li>
        <?php
        } else{
        ?>
              <li><a href="?modulo=equipo&accion=editar&id=<?php echo $equipo->getId(); ?>" data-toggle="tooltip" title="Editar Equipo"><?php echo $equipo->getFolio() . ' - ' . mb_strtoupper($equipo->getUsuario(), 'UTF-8'); ?></a></li>
        <?php
        }
        ?>
              <li><a href="?modulo=equipo&accion=consultar&id=<?php echo $equipo->getId();?>" data-toggle="tooltip" target="_blank" title="Ver Detalle de Equipo"><span class="glyphicon glyphicon-eye-open"></span></a></li>
              <li class="active">Revisiones</li>
      </ol>
      <div class="page-header" id="non-printable">
        <h1>Revisiones      
          <?php
          if ($equipo->getRetirado() == 1) { $estado = 'disabled'; $estado2 = false; } else { $estado = ''; $estado2 = true; }   
          ?>
         <button <?php echo $estado; ?> type="button" class="btn btn-primary btn-sm" id="btn-agregar" name="btn-agregar" onclick="document.location='?modulo=consulta&accion=editar&id_equipo=<?php echo $_GET['id_equipo'] ?>'">Agregar</button>
         <button type="button" <?php echo $estado; ?> class="btn btn-danger btn-sm pull-right" onclick="document.location='?modulo=consulta&accion=editar&id_equipo=<?php echo $equipo->getId();?>&novedad=1'">Agregar Problema</button></h1>
      </div>
<?php echo Util::getMsj();?>
    <div id="reporte" id="printable">
    <div class="table-responsive text-nowrap">
      <table class="table table-striped table-bordered table-hover" id="tableListar" >
        <thead>
          <tr>
            <th style="display: none;">Fecha a Ordenar</th>
            <th style="display: none;">Id</th>
            <th>Fecha</th>
            <th>Motivo</th>
            <th>Curva</th>
            <th>Estados</th>
            <th>Funciona</th>
            <th style="width:5%">Acciones</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $arrayConsultas = $consultaNegocio->listarOrdenado($_GET['id_equipo']);
          $primero = $arrayConsultas[0];
          if( count($arrayConsultas) > 0 ){
            foreach( $arrayConsultas as $consulta ){
                
                    $resultado = $consulta->getLeido();
                    if($resultado == 0)
                    { $resultado = ''; } 
                    else { $resultado = 'info'; } 

                    $problema = $consulta->getMotivo();
                    if ($problema == '0')
                    { $problema = 'danger'; }
                    else { $problema = ''; }
?>
              <tr class="<?php echo $problema; ?>">
                <th style="display: none;"><?php echo $consulta->getFecha(); ?></th>
                <th style="display: none;"><?php echo $consulta->getId(); ?></th>
                <td><?php echo Util::DbToDate($consulta->getFecha());?></td>
                <td><?php if($consulta->getMotivo() == '0') { echo ucfirst($consulta->getDescripcion()); } else { echo ucfirst($consulta->getMotivo());}?></td>
                <td><?php if ($consulta->getMotivo() == '0') { echo '-'; } else { if ($consulta->getCurva() == '0') { echo 'No'; } else { echo 'Si'; } } ?></td>
                <td><?php if ($consulta->getMotivo() == '0') { echo '-'; } else { if($consulta->getLeido() == '0' && $consulta->getLeido3() == '0') { echo 'No'; } else { echo 'Si'; } }?></td>
                <td><?php if ($consulta->getMotivo() == '0') { echo '-'; } else { if($consulta->getFunciona() == '0') { echo 'No'; } else { echo 'Si'; } }?></td>
              <td>
<?php 
                  if($estado2){
                              
                            if ($primero->getId() == $consulta->getId())
                            {
?> 
                  <a href="?modulo=consulta&accion=editar&id=<?php echo $consulta->getId();?>&id_equipo=<?php echo $_GET['id_equipo'] ?>" data-toggle="tooltip" title="Editar"><span class="glyphicon glyphicon-pencil"></span></a>&nbsp;
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
        }else{
          ?>
          <tr>
            <td colspan="8">No se encontraron resultados</td>
          </tr>
          <?php
          }
          ?>
        </tbody>
      </table>
</div>
</div>
</div>