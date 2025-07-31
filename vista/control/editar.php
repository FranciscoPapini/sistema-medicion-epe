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
        $control = $controlNegocio->recuperar($_GET['id']);
        $txtAction = 'Editar';
    }else{
        $control = new Control();
        $txtAction = 'Agregar';
    }
    ?>
    <div class="container">
      <div class="page-header">
        <h1><?php echo $txtAction; ?> Control</h1>
      </div>
        <form role="form" method="post" id="principal">
            <input type="hidden" name="id" value="<?php echo $control->getId();?>" >
            <div class="form-group">
                <label for="tipo">Tipo</label>
                <input type="text" class="form-control" id="tipo" name="tipo" placeholder="Tipo" value="<?php echo strtoupper($control->getTipo());?>" <?php if(!$_GET['id']) echo 'autofocus'; ?> required>
                <div class="help-block with-errors"></div>
            </div>
            <div class="form-group">
                <label for="constante">Constante</label>
                <input type="number" step="0.01" class="form-control" id="constante" name="constante" placeholder="Constate" value="<?php echo $control->getConstante();?>" required>
                <div class="help-block with-errors"></div>
            </div>
            <div class="form-group">
                <label for="decima">Decimal</label>
                <input type="number" step="0.0" class="form-control" id="decima" name="decima" placeholder="Decimal" value="<?php echo $control->getDecima();?>" required>
                <div class="help-block with-errors"></div>
            </div>

            <button type="button" class="btn btn-default cancelForm">Cancelar</button>
            <button type="submit" class="btn btn-primary"><?php echo $txtAction; ?></button>
        </form>
    </div>