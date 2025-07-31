<?php

    if ($_GET['id'] == 1 || ($_SESSION['administrador']['id'] != 1 && $_SESSION['administrador']['id'] != 2 && $_SESSION['administrador']['id'] != 3) ) {
?>
        <div class="container" id="non-printable">
            <div class="alert alert-danger" role="alert"><b>No tiene permisos para editar los TV</b></div>
        </div>
<?php 
    die();  
    }

    if ($_GET['id']) {
  
        $tv = $transformadorTensionNegocio->recuperar($_GET['id']);
        $txtAction = 'Editar';

    }else{
        $tv = new TransformadorTension();
        $txtAction = 'Agregar';
    }
?>
    <div class="container">
      <div class="page-header">
        <h1><?php echo $txtAction; ?> Transformador de Tensi&oacute;n</h1>
      </div>
        <form role="form" method="post" id="principal">
            <input type="hidden" name="id" value="<?php echo $tv->getId();?>" >
            <div class="form-group">
                <label for="tipo">Tipo</label>
                <input type="text" class="form-control" id="tipo" name="tipo" placeholder="Tipo" value="<?php echo strtoupper($tv->getTipo());?>" <?php if(!$_GET['id']) echo 'autofocus'; ?> required>
                <div class="help-block with-errors"></div>
            </div>
            <div class="form-group">
                <label for="clase">Clase</label>
                <input type="text" class="form-control" id="clase" name="clase" placeholder="Clase" value="<?php echo strtoupper($tv->getClase());?>" required>
                <div class="help-block with-errors"></div>
            </div>
            <div class="form-group">
                <label for="prestacion">Prestaci&oacute;n</label>
                <input type="text" class="form-control" id="prestacion" name="prestacion" placeholder="Prestaci&oacute;n" value="<?php echo strtoupper($tv->getPrestacion());?>" required>
                <div class="help-block with-errors"></div>
            </div>

            <button type="button" class="btn btn-default cancelForm">Cancelar</button>
            <button type="submit" class="btn btn-primary"><?php echo $txtAction; ?></button>
        </form>
    </div>