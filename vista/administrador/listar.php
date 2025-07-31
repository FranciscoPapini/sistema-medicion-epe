<?php
    if ($_SESSION['administrador']['id'] != 1 && $_SESSION['administrador']['id'] != 2 && $_SESSION['administrador']['id'] != 3 ) {
?>
        <div class="container" id="non-printable">
            <div class="alert alert-danger" role="alert"><b>No tiene permisos para ver los administradores</b></div>
        </div>
<?php 
        die();  
        }
?>
    <div class="container" id="non-printable">
      <div class="page-header" id="non-printable">
        <h1>Administradores <button type="button" class="btn btn-primary btn-sm" id="btn-agregar" name="btn-agregar" onclick="document.location='?modulo=administrador&accion=editar'">Agregar</button></h1>
      </div>
      <?php echo Util::getMsj(); ?>
<div class="table-responsive text-nowrap">      
      <table class="table table-striped table-bordered table-hover" id="tableListar">
        <thead>
          <tr>
            <th style="width:30%">Apellido</th>
            <th>Nombre</th>
            <th>Usuario</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $arrayAdministradores = $administradorNegocio->listar();
          if( count($arrayAdministradores) > 0 ){
            foreach( $arrayAdministradores as $administrador ){
          ?>
              <tr>
                <td><?php echo ucwords($administrador->getApellido());?></td>
                <td><?php echo ucwords($administrador->getNombre());?></td>
                <td><?php echo $administrador->getUsuario();?></td>
                <td>
                  <?php if( ($administrador->getId() == $_SESSION['administrador']['id']) || $_SESSION['administrador']['id'] == 1 || $_SESSION['administrador']['id'] == 2 || $_SESSION['administrador']['id'] == 3 ){
                  ?> 
                  <a href="?modulo=administrador&accion=editar&id=<?php echo $administrador->getId();?>" data-toggle="tooltip" title="Editar Administrador"><span class="glyphicon glyphicon-pencil"></span></a>&nbsp;
                  <?php }
                  if( ($administrador->getId() != $_SESSION['administrador']['id']) && ($_SESSION['administrador']['id'] == 1 || $_SESSION['administrador']['id'] == 2 || $_SESSION['administrador']['id'] == 3 )){
                  ?> 
                  <a href="?modulo=administrador&accion=eliminar&id=<?php echo $administrador->getId();?>" data-toggle="tooltip" title="Eliminar Administrador"><span class="glyphicon glyphicon-remove"></span></a>
                <?php } ?>
                </td>
              </tr>
          <?php
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