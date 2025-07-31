<?php
    if (($_GET['id'] == $_SESSION['administrador']['id']) || ($_GET['id'] && $_SESSION['administrador']['id'] == 1) || ($_GET['id'] && $_SESSION['administrador']['id'] == 2) || ($_GET['id'] && $_SESSION['administrador']['id'] == 3)) {
        $administrador = $administradorNegocio->recuperar($_GET['id']);
        $txtAction = 'Editar';
    }else if ($_SESSION['administrador']['id'] == 1 || $_SESSION['administrador']['id'] == 2 || $_SESSION['administrador']['id'] == 3){
        $administrador = new Administrador();
        $txtAction = 'Agregar';
    }else {
?>
    <div class="container" id="non-printable">
        <div class="alert alert-danger" role="alert"><b>No tiene permisos para agregar o editar administradores</b></div>
    </div>
<?php 
    die();  
    }
?>
    <div class="container" id="non-printable">
        <div class="page-header" id="non-printable">
        <?php echo Util::getMsj(); ?>
            <h1><?php echo $txtAction; ?> Administrador</h1>
        </div>
        
        <form role="form" method="post" id="principal">
            
            <input type="hidden" name="id" value="<?php echo $administrador->getId();?>" >
            
            <div class="form-group">
                <label for="usuario">Usuario</label>
                <input type="text" class="form-control" id="usuario" name="usuario" placeholder="Usuario" value="<?php echo $administrador->getUsuario();?>" 
                <?php if($_GET['id']) { ?> readonly <?php }else{?> data-remote="checkUser.php" required autofocus <?php } ?> >
                <div class="help-block with-errors"></div>
            </div>
            
            <div class="form-group">
                <label for="nombre">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre" value="<?php echo ucwords($administrador->getNombre());?>" required>
                <div class="help-block with-errors"></div>
            </div>
            
            <div class="form-group">
                <label for="apellido">Apellido</label>
                <input type="text" class="form-control" id="apellido" name="apellido" placeholder="Apellido" value="<?php echo ucwords($administrador->getApellido());?>" required>
                <div class="help-block with-errors"></div>
            </div>
            
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="<?php echo $administrador->getEmail();?>" required>
                <div class="help-block with-errors"></div>
            </div>
            
            <?php if($_GET['id']){ ?>
            <div class="alert alert-info" role="alert">Para cambiar su contrase&ntilde;a, complete los siguientes campos.<br>Para <strong>No</strong> cambiar su contrase&ntilde;a, <strong>No</strong> complete los siguientes campos.</div>
            <?php }
            ?>  
            <div class="alert alert-danger" role="alert" style="display:none" id="div-alert-pass" name="div-alert-pass">Las contrase&ntilde;as no coinciden</div>
            
            <div class="form-group">
                <label for="password">Contrase&ntilde;a</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Contrase&ntilde;a" value="" <?php if(!$_GET['id']) { ?> required <?php } ?> >
                <div class="help-block with-errors"></div>
            </div>
            
            <div class="form-group">
                <label for="confpassword">Confirmar Contrase&ntilde;a</label>
                <input type="password" class="form-control" id="confpassword" name="confpassword" placeholder="Confirmar Contrase&ntilde;a" value="" <?php if(!$_GET['id']) { ?> data-match="#password" <?php } ?> >
                <div class="help-block with-errors"></div>
            </div>

            <button type="button" class="btn btn-default cancelForm">Cancelar</button>
            <button type="submit" class="btn btn-primary"><?php echo $txtAction; ?></button>

        </form>
    </div>