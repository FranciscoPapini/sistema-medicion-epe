<?php
    if ($_SESSION['administrador']['id'] != 1 && $_SESSION['administrador']['id'] != 2 && $_SESSION['administrador']['id'] != 3 ) {
?>
        <div class="container" id="non-printable">
            <div class="alert alert-danger" role="alert"><b>No tiene permisos para ver los TV</b></div>
        </div>
<?php 
    die();  
    }
?>  
    <div class="container">
      <div class="page-header">
        <h1>Transformadores de Tensi&oacute;n <button type="button" class="btn btn-primary btn-sm" id="btn-agregar" name="btn-agregar" onclick="document.location='?modulo=transformadorTension&accion=editar'">Agregar</button></h1>
      </div>
      <?php echo Util::getMsj(); ?>
      <div class="table-responsive text-nowrap">
      <table class="table table-striped table-bordered table-hover" id="tableListar">
        <thead>
          <tr>
            <th>Tipo</th>
            <th>Clase</th>
            <th>Prestaci&oacute;n</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $arrayTv = $transformadorTensionNegocio->listar();
          if( count($arrayTv) > 0 ){
            foreach( $arrayTv as $tv ){
                    if($tv->getId() == 1){ } else {
          ?>
              <tr>
                <td><?php echo strtoupper($tv->getTipo());?></td>
                <td><?php echo strtoupper($tv->getClase());?></td>
                <td><?php echo strtoupper($tv->getPrestacion());?></td>
                <td>

                  <a href="?modulo=transformadorTension&accion=editar&id=<?php echo $tv->getId();?>" data-toggle="tooltip" title="Editar TV"><span class="glyphicon glyphicon-pencil"></span></a>&nbsp;
                  <a href="?modulo=transformadorTension&accion=eliminar&id=<?php echo $tv->getId();?>" data-toggle="tooltip" title="Eliminar TV"><span class="glyphicon glyphicon-remove"></span></a>

                </td>
              </tr>
          <?php
            }
            }
          }else{
          ?>
          <tr>
            <td colspan="4">No se encontraron resultados</td>
          </tr>
          <?php
          }
          ?>
        </tbody>
      </table>
      </div>
    </div>