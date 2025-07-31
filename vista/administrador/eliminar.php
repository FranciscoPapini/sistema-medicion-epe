<?php
    if ($_GET['id']) {
        if ($_GET['id'] != $_SESSION['administrador']['id']) {
            if ($_SESSION['administrador']['id'] == 1 || $_SESSION['administrador']['id'] == 2 || $_SESSION['administrador']['id'] == 3) {
            $administrador = $administradorNegocio->recuperar($_GET['id']);
    
    Util::setMsj('Est&aacute; a punto de eliminar el siguiente administrador:','warning',false);
?>
    <div class="container" id="non-printable">
          <div class="page-header" id="non-printable">
                <h1>Eliminar Administrador</h1>
          </div>
            <?php echo Util::getMsj(); ?>
        <form role="form" method="post">
            
            <input type="hidden" name="id" value="<?php echo $administrador->getId();?>" >

            <div class="form-group">
                <label for="administrador">Administrador</label>
                <input type="text" class="form-control" id="administrador" name="administrador" readonly placeholder="Administrador" value="<?php echo ucwords($administrador->getNombre()).' '.ucwords($administrador->getApellido()).' ('.$administrador->getUsuario().')';?>" >
            </div>
            
            <button type="button" class="btn btn-default cancelForm">Cancelar</button>
            <button type="submit" class="btn btn-primary">Eliminar</button>
        
        </form>
<?php
            }
            else{?>
        <div class="container" id="non-printable">
            <div class="alert alert-danger" role="alert"><b>No tiene permisos para eliminar administradores</b></div>
        </div>
            <?php 
            die();      
            }
        }
        else{ ?>
        <div class="container" id="non-printable">
            <div class="alert alert-danger" role="alert"><b>No puede eliminarse con la sesi&oacute;n activa</b></div>
        </div>
        <?php 
            die();  
        }
    }
    else{ ?>
        <div class="container" id="non-printable">
            <div class="alert alert-danger" role="alert"><b>Debe seleccionar un administrador</b></div>
        </div>
        <?php 
            die(); 
    } 
?>
    </div>