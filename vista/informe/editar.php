<?php
    if ($_GET['id']) {
        $informe = $informeNegocio->recuperar($_GET['id']);
        $txtAction = 'Editar';
        $fecha = Util::dbToDate($informe->getFecha());

            if( ($informe->getIdAdministrador() == $_SESSION['administrador']['id']) || $_SESSION['administrador']['id'] == 1 || $_SESSION['administrador']['id'] == 2 || $_SESSION['administrador']['id'] == 3 ){

            } else {

            ?>
                <div class="container" id="non-printable">
                    <div class="alert alert-danger" role="alert"><b>No puede editar un informe cargado por otro administrador</b></div>
                </div>
                <?php 
                die();
            }

    }else{
        $informe = new Informe();
        $txtAction = 'Agregar';
        $fecha = date('d/m/Y');
    }
    ?>
    <div class="container">
      <div class="page-header">
        <h1><?php echo $txtAction; ?> Informe</h1>
      </div>
      <?php echo Util::getMsj(); ?>
        <form role="form" method="post" id="principal">
            <input type="hidden" name="id" value="<?php echo $informe->getId();?>">
            <input type="hidden" name="id_administrador" value="<?php echo $_SESSION['administrador']['id'];?>">

            <div class="form-group">
                <label for="fecha">Fecha de Informe</label>
                <p class="help-block">Formato dd/mm/yyyy.</p>
                <input type="text" class="form-control datepicker" id="fecha" name="fecha" placeholder="dd/mm/yyyy" value="<?php echo $fecha;?>" pattern="^(?:(?:31(\/|-|\.)(?:0?[13578]|1[02]))\1|(?:(?:29|30)(\/|-|\.)(?:0?[1,3-9]|1[0-2])\2))(?:(?:1[6-9]|[2-9]\d)?\d{2})$|^(?:29(\/|-|\.)0?2\3(?:(?:(?:1[6-9]|[2-9]\d)?(?:0[48]|[2468][048]|[13579][26])|(?:(?:16|[2468][048]|[3579][26])00))))$|^(?:0?[1-9]|1\d|2[0-8])(\/|-|\.)(?:(?:0?[1-9])|(?:1[0-2]))\4(?:(?:1[6-9]|[2-9]\d)?\d{2})$" required>
                <div class="help-block with-errors"></div>
            </div>

              <div class="form-group">
                <label for="tipo">Tipo de Informe</label>
                        <select class="form-control" id="tipo_informe" name="tipo" required>
                          <option selected value="" >Seleccione una opci&oacute;n</option>
                          <option value="inspección de caja" <?php if($informe->getTipo() == 'inspección de caja') { echo 'selected'; } ?> ><?php echo mb_strtoupper('inspección de caja', 'UTF-8'); ?></option> 
                          <option value="puesta en servicio rechazada" <?php if($informe->getTipo() == 'puesta en servicio rechazada') { echo 'selected'; } ?> >PUESTA EN SERVICIO RECHAZADA</option>
                        </select> 
                <div class="help-block with-errors"></div>
            </div>

            <div class="form-group" id="div_aprobado_informe" <?php if(strtolower($informe->getTipo()) == "puesta en servicio rechazada") { ?> style="display: none;"<?php } ?>>
                <div class="col-auto">
                <label for="aprobado">
                <input type="checkbox" id="aprobado" name="aprobado" <?php if($informe->getAprobado() == 1) { echo 'checked'; } ?>> Aprobado
                </label>
            <p class="help-block">(Seleccione esta opci&oacute;n si el informe esta aprobado)</p>
                <div class="help-block with-errors"></div>
              </div>
                </div>

           <div class="form-group">
                <label for="descripcion">Descripci&oacute;n</label>
                <textarea class="form-control" id="descripcion" name="descripcion" rows="5" placeholder="Descripci&oacute;n" required><?php echo ucfirst($informe->getDescripcion());?></textarea>
                <div class="help-block with-errors"></div>
            </div>

            <div class="form-group">
                <label for="usuario">Usuario</label>
                <input type="text" class="form-control" id="usuario" name="usuario" placeholder="Usuario" value="<?php if($informe->getUsuario() == '0') { echo ''; } else { echo ucwords($informe->getUsuario()); } ?>" >
                <div class="help-block with-errors"></div>
            </div>
 
            <div class="form-group">
                <label for="direccion">Direcci&oacute;n</label>
                <input type="text" class="form-control" id="direccion" name="direccion" placeholder="Direcci&oacute;n" value="<?php echo ucwords($informe->getDireccion()); ?>" required>
                <div class="help-block with-errors"></div>
            </div>
            <div class="form-group">
                <label for="localidad">Localidad</label>
                <input type="text" class="form-control" id="localidad" name="localidad" placeholder="Localidad" value="<?php echo ucwords($informe->getLocalidad()); ?>" required>
                <div class="help-block with-errors"></div>
            </div>
            <div class="form-group">
                <label for="inspector">Inspector</label>
                <input type="text" class="form-control" id="inspector" name="inspector" placeholder="Inspector" value="<?php echo ucwords($informe->getInspector());?>" required>
                <div class="help-block with-errors"></div>
            </div>            
           <div class="form-group">
                <label for="ayudante">Ayudante</label>
                <input type="text" class="form-control" id="ayudante" name="ayudante" placeholder="Ayudante" value="<?php echo ucwords($informe->getAyudante());?>" required>
                <div class="help-block with-errors"></div>
            </div>   
       
            <button type="button" class="btn btn-default cancelForm">Cancelar</button>
            <button type="submit" class="btn btn-primary"><?php echo $txtAction; ?></button>
        </form>
    </div>