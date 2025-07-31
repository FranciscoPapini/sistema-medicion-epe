<?php
    if ($_GET['id']) {
    
    if ($_GET['id'] == 1 || ($_SESSION['administrador']['id'] != 1 && $_SESSION['administrador']['id'] != 2 && $_SESSION['administrador']['id'] != 3) ) {
?>
        <div class="container" id="non-printable">
            <div class="alert alert-danger" role="alert"><b>No tiene permisos para eliminar los TI</b></div>
        </div>
<?php 
    die();  
    }    

    $ti = $transformadorCorrienteNegocio->recuperar($_GET['id']);

    Util::setMsj('Est&aacute; a punto de eliminar el siguiente TI:','warning', false);
    ?>

    <div class="container">
      <div class="page-header">
        <h1>Eliminar Transformador de Corriente</h1>
      </div>
        <?php echo Util::getMsj(); ?>
        <form role="form" method="post">
            <input type="hidden" name="id" value="<?php echo $ti->getId();?>" >
            <div class="form-group">
                <label for="tipo">Tipo</label>
                <input type="text" class="form-control" id="tipo" name="tipo" readonly placeholder="Tipo" value="<?php echo strtoupper($ti->getTipo());?>" >
            </div>
            <div class="form-group">
                <label for="clase">Clase</label>
                <input type="text" class="form-control" id="clase" name="clase" readonly placeholder="Clase" value="<?php echo strtoupper($ti->getClase());?>" >
            </div>        
            <div class="form-group">
                <label for="prestacion">Prestaci&oacute;n</label>
                <input type="text" class="form-control" id="prestacion" name="prestacion" readonly placeholder="Prestaci&oacute;n" value="<?php echo strtoupper($ti->getPrestacion());?>" required>
            </div>

            <button type="button" class="btn btn-default cancelForm">Cancelar</button>
            <button type="submit" class="btn btn-primary">Eliminar</button>
        </form>
    <?php 
    }
    else { ?>
        <div class="container" id="non-printable">
            <div class="alert alert-danger" role="alert"><b>Debe seleecionar un TI</b></div>
        </div>
        <?php 
        die(); 
        }  
    ?>
    </div>