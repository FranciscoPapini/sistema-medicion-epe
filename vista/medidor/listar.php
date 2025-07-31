<?php
    if ($_SESSION['administrador']['id'] != 1 && $_SESSION['administrador']['id'] != 2 && $_SESSION['administrador']['id'] != 3 ) {
?>
        <div class="container" id="non-printable">
            <div class="alert alert-danger" role="alert"><b>No tiene permisos para ver los Medidores</b></div>
        </div>
<?php 
    die();  
    }
?>   

    <div class="container">
      <div class="page-header">
        <h1>Medidores <button type="button" class="btn btn-primary btn-sm" id="btn-agregar" name="btn-agregar" onclick="document.location='?modulo=medidor&accion=editar'">Agregar</button></h1>
      </div>
      <?php echo Util::getMsj(); ?>
      <div class="table-responsive text-nowrap">
      <table class="table table-striped table-bordered table-hover" id="tableListar">
        <thead>
          <tr>
            <th>Tipo</th>
            <th>Constante</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $arrayMedidores = $medidorNegocio->listar();
          if( count($arrayMedidores) > 0 ){
            foreach( $arrayMedidores as $medidor ){
                    if($medidor->getId() == 1){ } else {
            ?>
              <tr>
                <td><?php echo strtoupper($medidor->getTipo());?></td>
                <td><?php echo $medidor->getConstante();?></td>
                <td>
                  <a href="?modulo=medidor&accion=editar&id=<?php echo $medidor->getId();?>" data-toggle="tooltip" title="Editar Medidor"><span class="glyphicon glyphicon-pencil"></span></a>&nbsp;
                  <?php if ($medidor->getId() != 2 && $medidor->getId() != 3) { ?>
                  <a href="?modulo=medidor&accion=eliminar&id=<?php echo $medidor->getId();?>" data-toggle="tooltip" title="Eliminar Medidor"><span class="glyphicon glyphicon-remove"></span></a>
                  <?php 
                  } 
                  ?>
                </td>
              </tr>
          <?php
            }
          }
          }else{
          ?>
          <tr>
            <td colspan="3">No se encontraron resultados</td>
          </tr>
          <?php
          }
          ?>
        </tbody>
      </table>
      </div>
    </div>