<?php
    if ($_GET['id']) {

        $informe = $informeNegocio->recuperar($_GET['id']);
    
        if( ($informe->getIdAdministrador() == $_SESSION['administrador']['id']) || $_SESSION['administrador']['id'] == 1 || $_SESSION['administrador']['id'] == 2 || $_SESSION['administrador']['id'] == 3 ){

    Util::setMsj('Está a punto de eliminar el siguiente informe:','warning',false);
    ?>
    <div class="container">
        <div class="page-header">
            <h1>Eliminar Informe</h1>
        </div>
        <?php echo Util::getMsj(); ?>
        <form role="form" method="post">
            <input type="hidden" name="id" value="<?php echo $informe->getId();?>">
            <div class="form-group">
                <label for="fecha">Fecha</label>
                <input type="text" class="form-control" id="fecha" name="fecha" readonly value="<?php echo Util::DbToDate($informe->getFecha());?>" >
            </div>

            <div class="form-group">
                <label for="tipo">Tipo</label>
                <input type="text" class="form-control" id="tipo" name="tipo" readonly value="<?php echo mb_strtoupper($informe->getTipo(), 'UTF-8');?>" >
            </div>
            <div class="form-group">
                <label for="descripcion">Descripci&oacute;n</label>
                <textarea class="form-control" id="descripcion" name="descripcion" rows="5" readonly><?php echo ucfirst($informe->getDescripcion());?></textarea>
                <div class="help-block with-errors"></div>
            </div>           
            <div class="form-group">
                <label for="usuario">Usuario</label>
                <input type="text" class="form-control" id="usuario" name="usuario" readonly value="<?php echo ucwords($informe->getUsuario());?>" >
            </div>
            <div class="form-group">
                <label for="direccion">Direcci&oacute;n</label>
                <input type="text" class="form-control" id="direccion" name="direccion" readonly value="<?php echo ucwords($informe->getDireccion()) . ' - ' . ucwords($informe->getLocalidad()); ?>" >
            </div>
            <div class="form-group">
                <label for="inspector">Inspector</label>
                <input type="text" class="form-control" id="inspector" name="inspector" readonly value="<?php echo ucwords($informe->getInspector());?>" >
            </div>            
           <div class="form-group">
                <label for="ayudante">Ayudante</label>
                <input type="text" class="form-control" id="ayudante" name="ayudante" readonly value="<?php echo ucwords($informe->getAyudante());?>" >
            </div>    

            <button type="button" class="btn btn-default cancelForm">Cancelar</button>
            <button type="submit" class="btn btn-primary">Eliminar</button>
        </form>
    </div>
<?php 

} else {

?>
        <div class="container" id="non-printable">
            <div class="alert alert-danger" role="alert"><b>No puede eliminar un informe cargado por otro administrador</b></div>
        </div>
        <?php 
        die();
}
}
?>