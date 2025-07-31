<?php
    if ($_SESSION['administrador']['id'] != 1 && $_SESSION['administrador']['id'] != 2 && $_SESSION['administrador']['id'] != 3 ) {
    ?>
        <div class="container" id="non-printable">
            <div class="alert alert-danger" role="alert"><b>No tiene permisos para ver los Controles</b></div>
        </div>
<?php 
    die();  
    }
?>   
    <div class="container">
      <div class="page-header">
        <h1>Controles <button type="button" class="btn btn-primary btn-sm" id="btn-agregar" name="btn-agregar" onclick="document.location='?modulo=control&accion=editar'">Agregar</button></h1>
      </div>
      <?php echo Util::getMsj(); ?>
      <div class="table-responsive text-nowrap">
      <table class="table table-striped table-bordered table-hover" id="tableListar">
        <thead>
          <tr>
            <th>Tipo</th>
            <th>Constante</th>
            <th>Decimal</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $arrayControles = $controlNegocio->listar();
          if( count($arrayControles) > 0 ){
            foreach( $arrayControles as $control ){
                    if($control->getId() == 1){ } else {
          ?>
              <tr>
                <td><?php echo strtoupper($control->getTipo());?></td>
                <td><?php echo $control->getConstante();?></td>
                <td><?php echo $control->getDecima();?></td>
                <td>

                  <a href="?modulo=control&accion=editar&id=<?php echo $control->getId();?>" data-toggle="tooltip" title="Editar Control"><span class="glyphicon glyphicon-pencil"></span></a>&nbsp;
                  <a href="?modulo=control&accion=eliminar&id=<?php echo $control->getId();?>" data-toggle="tooltip" title="Eliminar Control"><span class="glyphicon glyphicon-remove"></span></a>

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