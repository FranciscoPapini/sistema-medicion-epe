<?php
    if ($_GET['id'] == 1 || ($_SESSION['administrador']['id'] != 1 && $_SESSION['administrador']['id'] != 2 && $_SESSION['administrador']['id'] != 3) ) {
?>
        <div class="container" id="non-printable">
            <div class="alert alert-danger" role="alert"><b>No tiene permisos para editar los TI</b></div>
        </div>
<?php 
    die();  
    }    

    if ($_GET['id']) {
        $ti = $transformadorCorrienteNegocio->recuperar($_GET['id']);
        $txtAction = 'Editar';
    }else{
        $ti = new TransformadorCorriente();
        $txtAction = 'Agregar';
    }
    ?>
    <div class="container">
      <div class="page-header">
        <h1><?php echo $txtAction; ?> Transformador de Corriente</h1>
      </div>
        <form role="form" method="post" id="principal">
            <input type="hidden" name="id" value="<?php echo $ti->getId();?>" >
            <div class="form-group">
                <label for="tipo">Tipo</label>
                <input type="text" class="form-control" id="tipo" name="tipo" placeholder="Tipo" value="<?php echo strtoupper($ti->getTipo());?>" <?php if(!$_GET['id']) echo 'autofocus'; ?> required>
                <div class="help-block with-errors"></div>
            </div>
            <div class="form-group">
                <label for="clase">Clase</label>
                <input type="text" class="form-control" id="clase" name="clase" placeholder="Clase" value="<?php echo strtoupper($ti->getClase());?>" required>
                <div class="help-block with-errors"></div>
            </div>
            <div class="form-group">
                <label for="prestacion">Prestaci&oacute;n</label>
                <input type="text" class="form-control" id="prestacion" name="prestacion" placeholder="Prestaci&oacute;n" value="<?php echo strtoupper($ti->getPrestacion());?>" required>
                <div class="help-block with-errors"></div>
            </div>

            <button type="button" class="btn btn-default cancelForm">Cancelar</button>
            <button type="submit" class="btn btn-primary"><?php echo $txtAction; ?></button>
        </form>
    </div>