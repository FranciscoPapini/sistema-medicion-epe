<?php
    if ($_GET['id'] == 1 || ($_SESSION['administrador']['id'] != 1 && $_SESSION['administrador']['id'] != 2 && $_SESSION['administrador']['id'] != 3) ) {
?>
        <div class="container" id="non-printable">
            <div class="alert alert-danger" role="alert"><b>No tiene permisos para editar los Medidores</b></div>
        </div>
<?php 
    die();  
    }    
        
    if ($_GET['id']) {
        $medidor = $medidorNegocio->recuperar($_GET['id']);
        $txtAction = 'Editar';
    }else{
        $medidor = new Medidor();
        $txtAction = 'Agregar';
    }
    ?>

    <div class="container">
      <div class="page-header">
        <h1><?php echo $txtAction; ?> Medidor</h1>
      </div>
        <form role="form" method="post" id="principal">
            <input type="hidden" name="id" value="<?php echo $medidor->getId();?>" >
            <div class="form-group">
                <label for="tipo">Tipo</label>
                <input type="text" class="form-control" id="tipo" name="tipo" placeholder="Tipo" <? if($medidor->getId() == 2) { echo 'readonly'; } if(!$_GET['id']) echo 'autofocus'; ?> value="<?php echo strtoupper($medidor->getTipo());?>" required>
                <div class="help-block with-errors"></div>
            </div>
            <div class="form-group">
                <label for="constante">Constante</label>
                <input type="number" step="0.01" class="form-control" id="constante" name="constante" placeholder="Constate" value="<?php echo $medidor->getConstante();?>" required>
                <div class="help-block with-errors"></div>
            </div>
            <button type="button" class="btn btn-default cancelForm">Cancelar</button>
            <button type="submit" class="btn btn-primary"><?php echo $txtAction; ?></button>
        </form>
    </div>