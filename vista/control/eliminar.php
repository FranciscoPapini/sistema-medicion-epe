<?php
    if ($_GET['id']) {

    if ($_GET['id'] == 1 || ($_SESSION['administrador']['id'] != 1 && $_SESSION['administrador']['id'] != 2 && $_SESSION['administrador']['id'] != 3) ) {
?>
        <div class="container" id="non-printable">
            <div class="alert alert-danger" role="alert"><b>No tiene permisos para eliminar los Controles</b></div>
        </div>
    <?php 
    die();  
    }    
    
    $control = $controlNegocio->recuperar($_GET['id']);
    
    Util::setMsj('Est&aacute; a punto de eliminar el siguiente control:','warning', false);
    ?>
    <div class="container">
      <div class="page-header">
        <h1>Eliminar Control</h1>
      </div>
        <?php echo Util::getMsj(); ?>
        <form role="form" method="post">
            <input type="hidden" name="id" value="<?php echo $control->getId();?>" >
            <div class="form-group">
                <label for="tipo">Tipo</label>
                <input type="text" class="form-control" id="tipo" name="tipo" readonly placeholder="Tipo" value="<?php echo strtoupper($control->getTipo());?>" >
            </div>
            <div class="form-group">
                <label for="constante">Constante</label>
                <input type="text" class="form-control" id="constante" name="constante" readonly placeholder="Constante" value="<?php echo $control->getConstante();?>" >
            </div>            
          <div class="form-group">
                <label for="decima">Decimal</label>
                <input type="number" class="form-control" id="decima" name="decima" readonly placeholder="Decimal" value="<?php echo $control->getDecima();?>" >
            </div>


            <button type="button" class="btn btn-default cancelForm">Cancelar</button>
            <button type="submit" class="btn btn-primary">Eliminar</button>
        </form>
    <?php 
    }
    else {?>
        <div class="container" id="non-printable">
            <div class="alert alert-danger" role="alert"><b>Debe seleecionar un Control</b></div>
        </div>
<?php 
        die(); 
        }  
?>
    </div>