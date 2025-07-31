<div class="container">

      <div class="page-header">
        <h1>Informes <button type="button" class="btn btn-primary btn-sm" onclick="document.location='?modulo=informe&accion=editar'">Agregar</button></h1>
      </div>
      <?php echo Util::getMsj(); ?>
      <div class="table-responsive text-nowrap">
      <table class="table table-striped table-bordered table-hover" id="tableListar">
        <thead>
          <tr>
            <th style="display: none;">Fecha a Ordenar</th>
            <th style="display: none;">Id</th>
            <th>Fecha</th>
            <th>Usuario</th>
            <th>Tipo</th>
            <th>Direcci&oacute;n</th>
            <th>Localidad</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $arrayInformes = $informeNegocio->listar();
          if( count($arrayInformes) > 0 ){
            foreach( $arrayInformes as $informe ){
          ?>
              <tr>
                <td style="display: none;"><?php echo $informe->getFecha();?></td>
                <td style="display: none;"><?php echo $informe->getId();?></td>
                <td><?php echo Util::DbToDate($informe->getFecha());?></td>
                <td><?php if($informe->getUsuario() == '0') { echo '-'; } else { echo ucwords($informe->getUsuario()); }?></td>
                <td><?php echo ucwords($informe->getTipo());?></td>
                <td><?php echo ucwords($informe->getDireccion());?></td>
                <td><?php echo ucwords($informe->getLocalidad());?></td>
                <td>
                  <?php 
                    if( ($informe->getIdAdministrador() == $_SESSION['administrador']['id']) || $_SESSION['administrador']['id'] == 1 || $_SESSION['administrador']['id'] == 2 || $_SESSION['administrador']['id'] == 3 ){
                  ?>
                  <a href="?modulo=informe&accion=editar&id=<?php echo $informe->getId();?>" data-toggle="tooltip" title="Editar Informe"><span class="glyphicon glyphicon-pencil"></span></a>&nbsp;
                  <a href="?modulo=informe&accion=eliminar&id=<?php echo $informe->getId();?>" data-toggle="tooltip" title="Eliminar Informe"><span class="glyphicon glyphicon-remove"></span></a>&nbsp;
                  <?php 
                    }
                  ?> 
                  <a href="?modulo=informe&accion=consultar&id=<?php echo $informe->getId();?>" class="btnConsultar" data-toggle="tooltip" title="Ver Detalle"><span class="glyphicon glyphicon-eye-open"></span></a>&nbsp;
                  <a href="?modulo=informe&accion=reporte&id=<?php echo $informe->getId();?>" data-toggle="tooltip" target="_blank" title="Imprimir"><span class="glyphicon glyphicon-print"></span></a>
                  

                </td>
              </tr>
          <?php
            }
          }else{
          ?>
          <tr>
            <td colspan="7">No se encontraron resultados</td>
          </tr>
          <?php
          }
          ?>
        </tbody>
      </table>
      </div>
   </div>