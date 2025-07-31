<?php
    if ($_SESSION['administrador']['id'] != 1 && $_SESSION['administrador']['id'] != 2 && $_SESSION['administrador']['id'] != 3 ) {
?>
        <div class="container" id="non-printable">
            <div class="alert alert-danger" role="alert"><b>No tiene permisos para ver los TI</b></div>
        </div>
<?php 
    die();  
    }
?>   
    <div class="container">
      <div class="page-header">
        <h1>Transformadores de Corriente <button type="button" class="btn btn-primary btn-sm" id="btn-agregar" name="btn-agregar" onclick="document.location='?modulo=transformadorCorriente&accion=editar'">Agregar</button></h1>
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
          $arrayTi = $transformadorCorrienteNegocio->listar();
          if( count($arrayTi) > 0 ){
            foreach( $arrayTi as $ti ){
                    if($ti->getId() == 1){ } else {
          ?>
              <tr>
                <td><?php echo strtoupper($ti->getTipo());?></td>
                <td><?php echo strtoupper($ti->getClase());?></td>
                <td><?php echo strtoupper($ti->getPrestacion());?></td>
                <td>
               
                  <a href="?modulo=transformadorCorriente&accion=editar&id=<?php echo $ti->getId();?>" data-toggle="tooltip" title="Editar TI"><span class="glyphicon glyphicon-pencil"></span></a>&nbsp;
                  <a href="?modulo=transformadorCorriente&accion=eliminar&id=<?php echo $ti->getId();?>" data-toggle="tooltip" title="Eliminar TI"><span class="glyphicon glyphicon-remove"></span></a>

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