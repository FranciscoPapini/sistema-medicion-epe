<?php
    require_once('negocio/medidorNegocio.php');
    $medidorNegocio = new MedidorNegocio();
    $arrayMedidores = $medidorNegocio->listar();

      if ($_GET['id']) {
          $equipo = $equipoNegocio->recuperar($_GET['id']);
          $txtAction = 'Editar';
          $fecha = Util::dbToDate($equipo->getAlta());
          $med = $medidorNegocio->recuperar($equipo->getIdMedidor());
      }else{
        $equipo = new Equipo();
        $txtAction = 'Agregar';
        $fecha = date('d/m/Y');
      }

    require_once('negocio/controlNegocio.php');
    $controlNegocio = new ControlNegocio();
    $arrayControles = $controlNegocio->listar();

    require_once('negocio/transformadorTensionNegocio.php');
    $transformadorTensionNegocio = new TransformadorTensionNegocio();
    $arrayTv = $transformadorTensionNegocio->listar();

    require_once('negocio/transformadorCorrienteNegocio.php');
    $transformadorCorrienteNegocio = new TransformadorCorrienteNegocio();
    $arrayTi = $transformadorCorrienteNegocio->listar();

?>
    <div class="container" id="non-printable" >
      <?php 
      if ($_GET['id']) {
           ?>
            <ol class="breadcrumb" id="non-printable">
              <li class="active"><?php echo $equipo->getFolio(); ?></a></li>
              <li class="active"><?php echo mb_strtoupper($equipo->getUsuario(), 'UTF-8'); ?></a></li>
            </ol>
      <?php 
      } else {}
      ?>
      <div class="page-header" id="non-printable" >
        <h1><?php echo $txtAction; ?> Equipo</h1>
      </div>
      <?php echo Util::getMsj(); ?>
        <form role="form" method="post" id="principal">
            <input type="hidden" name="id" value="<?php echo $equipo->getId();?>">
            <input type="hidden" name="ruta_anterior" value="<?php echo $equipo->getRuta();?>" >
            <input type="hidden" name="folio_anterior" value="<?php echo $equipo->getFolio();?>" >
            <input type="hidden" name="retired" value="<?php echo $equipo->getRetirado();?>" >
            <input type="hidden" name="sesion" value="<?php echo $_SESSION['administrador']['id']; ?>" >


<div class="row">
            <div class="col-md-6"> 
                <div class="form-group">
                <label for="usuario">Usuario</label>
                <input type="text" class="form-control" id="usuario" name="usuario" placeholder="Usuario" <?php if ($equipo->getUsuario() == '') { echo 'autofocus'; } ?> value="<?php if ($equipo->getUsuario() == '0') { echo ''; } else { echo mb_strtoupper($equipo->getUsuario(), 'UTF-8'); }?>"<?php if($equipo->getRetirado() == 1) { echo 'readonly'; } ?> required >
                <div class="help-block with-errors"></div>
                </div>
              </div>
              <div class="col-md-6">
              <div class="form-group">
                <label for="alta">Fecha de Alta</label>
                <p class="help-block" style="display: inline;">(Formato dd/mm/yyyy)</p>
                <input type="text" class="form-control datepicker" id="alta" name="alta" placeholder="dd/mm/yyyy" value="<?php echo $fecha;?>" tabindex="-1"  pattern="^(?:(?:31(\/|-|\.)(?:0?[13578]|1[02]))\1|(?:(?:29|30)(\/|-|\.)(?:0?[1,3-9]|1[0-2])\2))(?:(?:1[6-9]|[2-9]\d)?\d{2})$|^(?:29(\/|-|\.)0?2\3(?:(?:(?:1[6-9]|[2-9]\d)?(?:0[48]|[2468][048]|[13579][26])|(?:(?:16|[2468][048]|[3579][26])00))))$|^(?:0?[1-9]|1\d|2[0-8])(\/|-|\.)(?:(?:0?[1-9])|(?:1[0-2]))\4(?:(?:1[6-9]|[2-9]\d)?\d{2})$" <?php if($equipo->getRetirado() == 1) { echo 'readonly'; } ?>  required>
                <div class="help-block with-errors"></div>
                </div>    
              </div>
</div>


<div class="row">
            <div class="col-md-6"> 
                <div class="form-group">
                <label for="ruta">Ruta</label>
                <input type="number" class="form-control" id="ruta" name="ruta" placeholder="Ruta" value="<?php if($equipo->getRetirado() == 1) { echo $equipo->getRuta(); } else { if($equipo->getRuta() == 0) { echo ''; } else { echo $equipo->getRuta(); } } ?>" <?php if($_GET['id']) { if($_SESSION['administrador']['id'] == 1 || $_SESSION['administrador']['id'] == 2 || $_SESSION['administrador']['id'] == 3) { if($equipo->getRetirado() == 1) { echo 'readonly'; } } else { echo 'readonly'; } }?> required >
                <div class="help-block with-errors"></div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                <label for="folio">Folio</label>
                <input type="number" class="form-control" id="folio" name="folio" placeholder="Folio" value="<?php if($equipo->getRetirado() == 1) { echo $equipo->getFolio(); } else { if($equipo->getFolio() == 0) { echo ''; } else { echo $equipo->getFolio(); } } ?>" <?php if($_GET['id']) { if($_SESSION['administrador']['id'] == 1 || $_SESSION['administrador']['id'] == 2 || $_SESSION['administrador']['id'] == 3) { if($equipo->getRetirado() == 1) { echo 'readonly'; } } else { echo 'readonly'; } }?> required>
                <div class="help-block with-errors"></div>
                </div> 
            </div>
</div>

<div class="row">
            <div class="col-md-6"> 
            <div class="form-group">
                <label for="direccion">Direcci&oacute;n</label>
                <input type="text" class="form-control" id="direccion" name="direccion" placeholder="Direcci&oacute;n" value="<?php if ($equipo->getDireccion() == '0') { echo ''; } else { echo ucwords($equipo->getDireccion()); }?>" <?php if($equipo->getRetirado() == 1) { echo 'readonly'; } ?> required>
                <div class="help-block with-errors"></div>
            </div>
          </div>
            <div class="col-md-6">
               <div class="form-group">
                <label for="localidad">Localidad</label>
                <input type="text" class="form-control" id="localidad" name="localidad" placeholder="Localidad" value="<?php if ($equipo->getLocalidad() == '0') { echo ''; } else { echo ucwords($equipo->getLocalidad()); }?>" <?php if($equipo->getRetirado() == 1) { echo 'readonly'; } ?> required>
                <div class="help-block with-errors"></div>
            </div>
          </div>
</div>


<div class="row">
            <div class="col-md-6"> 
                <div class="form-group">
                <label for="latitud">Latitud</label>
                <p class="help-block" style="display: inline;">(Formato -dd.dddddd)</p>                
                <input type="number" step="0.000001" class="form-control" id="latitud" name="latitud" placeholder="-dd.dddd" value="<?php if ($equipo->getLatitud() == 0) { echo ''; } else { echo $equipo->getLatitud(); }?>" <?php if($equipo->getRetirado() == 1) { echo 'readonly'; } ?> >
                <div class="help-block with-errors"></div>
                </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="longitud">Longitud</label>
                <p class="help-block" style="display: inline;">(Formato -dd.dddddd)</p>                
                <input type="number" step="0.000001" class="form-control" id="longitud" name="longitud" placeholder="-dd.dddd" value="<?php if ($equipo->getLongitud() == 0) { echo ''; } else { echo $equipo->getLongitud(); }?>" <?php if($equipo->getRetirado() == 1) { echo 'readonly'; } ?> >
                <div class="help-block with-errors"></div>
                </div>
              </div>
</div>

<hr>

<div class="row">
          <div class="col-md-6">
            <div class="form-group">
                <label for="id_medidor">Tipo de Medidor</label>
                <select class="form-control" id="id_medidor" name="id_medidor" <?php if($_GET['id']) { if($_SESSION['administrador']['id'] == 1 || $_SESSION['administrador']['id'] == 2 || $_SESSION['administrador']['id'] == 3) { if($equipo->getRetirado() == 1) { echo 'disabled'; } } else { echo 'disabled'; } }?>>
                    <option value="">Seleccione una opci&oacute;n</option>
                    <?php
                    foreach ($arrayMedidores as $medidor) {
                        echo '<option value="'. $medidor->getId() .'" ';
                        if($medidor->getId() == $equipo->getIdMedidor()){
                          if($medidor->getId() == 1) {} else { 
                            echo "selected ";
                        }
                      }
                        echo '>' . strtoupper($medidor->getTipo()) . '</option>';
                    }
                    ?>
                </select>
                      <div class="help-block with-errors"></div>
               </div>            
             </div>
            <div class="col-md-6">
            <div class="form-group">
                <label for="nro_medidor">N&uacute;mero de Medidor</label>
                <input type="number" class="form-control" id="nro_medidor" name="nro_medidor" placeholder="N&uacute;mero de Medidor" value="<?php if ($equipo->getNroMedidor() == '0') { echo ''; } else { echo $equipo->getNroMedidor(); }?>" <?php if($_GET['id']) { if($_SESSION['administrador']['id'] == 1 || $_SESSION['administrador']['id'] == 2 || $_SESSION['administrador']['id'] == 3) { if($equipo->getRetirado() == 1) { echo 'disabled'; } } else { echo 'disabled'; } }?> >
                <div class="help-block with-errors"></div>
            </div> 
            </div>
</div>



      <div class="col-auto">
            <label for="respaldo">
              <input type="checkbox" id="respaldo" name="respaldo" <?php if($equipo->getRespaldo() == 1) { echo 'checked'; } ?> <?php if($_GET['id']) { if($_SESSION['administrador']['id'] == 1 || $_SESSION['administrador']['id'] == 2 || $_SESSION['administrador']['id'] == 3) { if($equipo->getRetirado() == 1) { echo 'disabled'; } } else { echo 'disabled'; } }?> > Medidor de Respaldo
            </label>
            <p class="help-block">(Seleccione esta opci&oacute;n si el equipo tiene un medidor de respaldo)</p>
                <div class="help-block with-errors"></div>
      </div>



<div class="row" id="div-respaldo" <?php if ($_GET['id']) { if ( $equipo->getRespaldo() == ('on' || 1) ) {  } else { ?> style="display:none" <?php } } else { ?> style="display:none" <?php }  ?>>
          <div class="col-md-6">
            <div class="form-group">
                <label for="id_medidor_respaldo">Tipo de Medidor de Respaldo</label>
                <select class="form-control" id="id_medidor_respaldo" name="id_medidor_respaldo" <?php if($_GET['id']) { if($_SESSION['administrador']['id'] == 1 || $_SESSION['administrador']['id'] == 2 || $_SESSION['administrador']['id'] == 3) { if($equipo->getRetirado() == 1) { echo 'disabled'; } } else { echo 'disabled'; } }?>>
                    <option value="">Seleccione una opci&oacute;n</option>
                    <?php
                    foreach ($arrayMedidores as $medidor) {
                        echo '<option value="'. $medidor->getId() .'" ';
                        if($medidor->getId() == $equipo->getIdMedidorRespaldo()){
                          if($medidor->getId() == 1) {} else { 
                            echo "selected ";
                        }
                      }
                        echo '>' . strtoupper($medidor->getTipo()) . '</option>';
                    }
                    ?>
                </select>
                      <div class="help-block with-errors"></div>
               </div>            
             </div>
            <div class="col-md-6">
            <div class="form-group">
                <label for="nro_medidor_respaldo">N&uacute;mero de Medidor de Respaldo</label>
                <input type="number" class="form-control" id="nro_medidor_respaldo" name="nro_medidor_respaldo" placeholder="N&uacute;mero de Medidor de Respaldo" value="<?php if ($equipo->getNroMedidorRespaldo() == '0') { echo ''; } else { echo $equipo->getNroMedidorRespaldo(); }?>" <?php if($_GET['id']) { if($_SESSION['administrador']['id'] == 1 || $_SESSION['administrador']['id'] == 2 || $_SESSION['administrador']['id'] == 3) { if($equipo->getRetirado() == 1) { echo 'disabled'; } } else { echo 'disabled'; } }?> >
                <div class="help-block with-errors"></div>
            </div> 
            </div>
</div>



<div class="row">
            <div class="col-md-6"> 
                <div class="form-group">
                <label for="potencia">Potencia</label>
                <div class="input-group">
                <input type="number" class="form-control" id="potencia" name="potencia" placeholder="Potencia" value="<?php if ($equipo->getPotencia() == '0') { echo ''; } else { echo $equipo->getPotencia(); }?>" <?php if($_GET['id']) { if($_SESSION['administrador']['id'] == 1 || $_SESSION['administrador']['id'] == 2 || $_SESSION['administrador']['id'] == 3) { if($equipo->getRetirado() == 1) { echo 'disabled'; } } else { echo 'disabled'; } } ?> >
                <div class="input-group-addon">KW</div>
                </div>    
                </div>
              </div>
</div>


<div id="directo2" <?php if (($_GET['id'] && $med->getId() == 2) || ($_GET['id'] && $med->getId() == 3)) { ?> style="display: none;" <?php }  ?>>
<div class="row">
        <div class="col-md-6"> 
          <div class="form-group">
            <div class="col-auto">
            <label for="media_tension">
              <input type="checkbox" id="media_tension" name="media_tension" <?php if($equipo->getMediaTension() == 1) { echo 'checked'; } ?> <?php if($_GET['id']) { if($_SESSION['administrador']['id'] == 1 || $_SESSION['administrador']['id'] == 2 || $_SESSION['administrador']['id'] == 3) { if($equipo->getRetirado() == 1) { echo 'disabled'; } } else { echo 'disabled'; } }?> > Media Tensi&oacute;n
               </label>
                <p class="help-block">(Seleccione esta opci&oacute;n si el equipo es de media tensi&oacute;n)</p>
              </div>
            </div>
        </div>
</div> 

<div <?php if ( ($_GET['id'] && $equipo->getMediaTension() == 0) || !$_GET['id'] ) { ?> style="display:none" <?php } ?> id="div-relacion-tv3">
 
      <div class="row">
          <div class="col-md-4">
            <div class="form-group">
                <label for="id_tv">Tipo de TV</label>
                <select class="form-control" id="id_tv" name="id_tv" <?php if($_GET['id']) { if($_SESSION['administrador']['id'] == 1 || $_SESSION['administrador']['id'] == 2 || $_SESSION['administrador']['id'] == 3) { if($equipo->getRetirado() == 1) { echo 'disabled'; } } else { echo 'disabled'; } }?>>
                    <option value="">Seleccione una opci&oacute;n</option>
                    <?php
                    foreach ($arrayTv as $tv) {
                        echo '<option value="'. $tv->getId() .'" ';
                        if($tv->getId() == $equipo->getIdTv()){
                          if($tv->getId() == 1) {} else { 
                            echo "selected ";
                        }
                      }
                      if ($tv->getId() == 1) {
                        echo '>' . strtoupper($tv->getTipo()) . '</option>';
                      } else {
                        echo '>' . strtoupper($tv->getTipo()) . ' - ' . strtoupper($tv->getClase()) . ' - ' . strtoupper($tv->getPrestacion()) . '</option>';
                      }
                    }
                    ?>
                </select>
                      <div class="help-block with-errors"></div>
                </div>
              </div>
             </div>

<div class="row">
        <div class="col-md-4">
          <div class="form-group">
                <label for="cabina">Relaci&oacute;n de TV</label>
              <select class="form-control" id="cabina" name="cabina" <?php if($_GET['id']) { if($_SESSION['administrador']['id'] == 1 || $_SESSION['administrador']['id'] == 2 || $_SESSION['administrador']['id'] == 3) { if($equipo->getRetirado() == 1) { echo 'disabled'; } } else { echo 'disabled'; } }?>>
                <option selected value="" >Seleccione una opci&oacute;n</option>
                  <option value="1" <?php if($equipo->getCabina() == '1') { echo 'selected'; } ?> >No Especificado</option> 
                <option value="13200" <?php if($equipo->getCabina() == '13200') { echo 'selected'; } ?> >13200 V</option>
                <option value="33000" <?php if($equipo->getCabina() == '33000') { echo 'selected'; } ?> >33000 V</option>
                <option value="132000" <?php if($equipo->getCabina() == '132000') { echo 'selected'; } ?> >132000 V</option>
              </select>
                <div class="help-block with-errors"></div>
              </div>
            </div>
  </div>


  <div class="row">
          <div class="col-md-4">
            <div class="form-group">
                <label for="nro_tv_r">N&uacute;mero de TV fase R</label>
                <input type="number" class="form-control" id="nro_tv_r" name="nro_tv_r" placeholder="N&uacute;mero de TV fase R" value="<?php if ($equipo->getNroTvR() == '0') { echo ''; } else { echo $equipo->getNroTvR(); }?>" <?php if($_GET['id']) { if($_SESSION['administrador']['id'] == 1 || $_SESSION['administrador']['id'] == 2 || $_SESSION['administrador']['id'] == 3) { if($equipo->getRetirado() == 1) { echo 'disabled'; } } else { echo 'disabled'; } } ?> >
                <div class="help-block with-errors"></div>
            </div> 
          </div>
          <div class="col-md-4">
            <div class="form-group">
                <label for="nro_tv_s">N&uacute;mero de TV fase S</label>
                <input type="number" class="form-control" id="nro_tv_s" name="nro_tv_s" placeholder="N&uacute;mero de TV fase S" value="<?php if ($equipo->getNroTvS() == '0') { echo ''; } else { echo $equipo->getNroTvS(); }?>" <?php if($_GET['id']) { if($_SESSION['administrador']['id'] == 1 || $_SESSION['administrador']['id'] == 2 || $_SESSION['administrador']['id'] == 3) { if($equipo->getRetirado() == 1) { echo 'disabled'; } } else { echo 'disabled'; } } ?> >
                <div class="help-block with-errors"></div>
            </div> 
          </div>
          <div class="col-md-4">
            <div class="form-group">
                <label for="nro_tv_t">N&uacute;mero de TV fase T</label>
                <input type="number" class="form-control" id="nro_tv_t" name="nro_tv_t" placeholder="N&uacute;mero de TV fase T" value="<?php if ($equipo->getNroTvT() == '0') { echo ''; } else { echo $equipo->getNroTvT(); }?>" <?php if($_GET['id']) { if($_SESSION['administrador']['id'] == 1 || $_SESSION['administrador']['id'] == 2 || $_SESSION['administrador']['id'] == 3) { if($equipo->getRetirado() == 1) { echo 'disabled'; } } else { echo 'disabled'; } } ?> >
                <div class="help-block with-errors"></div>
              </div> 
            </div> 
    </div> 

</div>

<hr>

 <div class="row">
          <div class="col-md-4">
            <div class="form-group">
                <label for="id_control">Tipo de Controles</label>
                <select class="form-control" id="id_control" name="id_control" <?php if($_GET['id']) { if($_SESSION['administrador']['id'] == 1 || $_SESSION['administrador']['id'] == 2 || $_SESSION['administrador']['id'] == 3) { if($equipo->getRetirado() == 1) { echo 'disabled'; } } else { echo 'disabled'; } }?>>
                    <option value="">Seleccione una opci&oacute;n</option>
                    <?php
                    foreach ($arrayControles as $control) {
                        echo '<option value="'. $control->getId() .'" ';
                        if($control->getId() == $equipo->getIdControl()){
                          if($control->getId() == 1) {} else { 
                            echo "selected ";
                        }
                      }
                      if($control->getId() == 1){
                        echo '>' . strtoupper($control->getTipo()) . '</option>';
                      } else{
                        echo '>' . strtoupper($control->getTipo()) . ' - ' . $control->getConstante() . '</option>';
                      }
                    }
                    ?>
                </select>
                      <div class="help-block with-errors"></div>
               </div>            
             </div>
  </div>


  <div class="row">
          <div class="col-md-4">
            <div class="form-group">
                <label for="nro_control_r">N&uacute;mero de Control fase R</label>
                <input type="number" class="form-control" id="nro_control_r" name="nro_control_r" placeholder="N&uacute;mero de Control fase R" value="<?php if ($equipo->getNroControlR() == '0') { echo ''; } else { echo $equipo->getNroControlR(); }?>" <?php if($_GET['id']) { if($_SESSION['administrador']['id'] == 1 || $_SESSION['administrador']['id'] == 2 || $_SESSION['administrador']['id'] == 3) { if($equipo->getRetirado() == 1) { echo 'disabled'; } } else { echo 'disabled'; } } ?> >
                <div class="help-block with-errors"></div>
            </div> 
          </div>
          <div class="col-md-4">
            <div class="form-group">
                <label for="nro_control_s">N&uacute;mero de Control fase S</label>
                <input type="number" class="form-control" id="nro_control_s" name="nro_control_s" placeholder="N&uacute;mero de Control fase S" value="<?php if ($equipo->getNroControlS() == '0') { echo ''; } else { echo $equipo->getNroControlS(); }?>" <?php if($_GET['id']) { if($_SESSION['administrador']['id'] == 1 || $_SESSION['administrador']['id'] == 2 || $_SESSION['administrador']['id'] == 3) { if($equipo->getRetirado() == 1) { echo 'disabled'; } } else { echo 'disabled'; } }?> >
                <div class="help-block with-errors"></div>
            </div> 
          </div>
          <div class="col-md-4">
            <div class="form-group">
                <label for="nro_control_t">N&uacute;mero de Control fase T</label>
                <input type="number" class="form-control" id="nro_control_t" name="nro_control_t" placeholder="N&uacute;mero de Control fase T" value="<?php if ($equipo->getNroControlT() == '0') { echo ''; } else { echo $equipo->getNroControlT(); }?>" <?php if($_GET['id']) { if($_SESSION['administrador']['id'] == 1 || $_SESSION['administrador']['id'] == 2 || $_SESSION['administrador']['id'] == 3) { if($equipo->getRetirado() == 1) { echo 'disabled'; } } else { echo 'disabled'; } }?> >
                <div class="help-block with-errors"></div>
            </div>
          </div>
  </div>

<hr>

    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label for="id_ti">Tipo de TI</label>
                <select class="form-control" id="id_ti" name="id_ti" <?php if($_GET['id']) { if($_SESSION['administrador']['id'] == 1 || $_SESSION['administrador']['id'] == 2 || $_SESSION['administrador']['id'] == 3) { if($equipo->getRetirado() == 1) { echo 'disabled'; } } else { echo 'disabled'; } }?>>
                    <option value="">Seleccione una opci&oacute;n</option>
                    <?php
                    foreach ($arrayTi as $ti) {
                        echo '<option value="'. $ti->getId() .'" ';
                        if($ti->getId() == $equipo->getIdTi()){
                          if($ti->getId() == 1) {} else { 
                            echo "selected ";
                        }
                      }
                      if ($ti->getId() == 1) {
                         echo '>' . strtoupper($ti->getTipo()) . '</option>';
                      } else {
                         echo '>' . strtoupper($ti->getTipo()) . ' - ' . strtoupper($ti->getClase()) . ' - ' . strtoupper($ti->getPrestacion()) . '</option>';
                      }
                    }
                    ?>
                </select>
                      <div class="help-block with-errors"></div>
               </div>            
             </div>
        </div>


    <div class="row">
            <div class="col-md-4"> 
              <div class="form-group" >
                <label for="relacion_ti">Relaci&oacute;n de TI</label>
            <select class="form-control" id="relacion_ti" name="relacion_ti" <?php if($_GET['id']) { if($_SESSION['administrador']['id'] == 1 || $_SESSION['administrador']['id'] == 2 || $_SESSION['administrador']['id'] == 3) { if($equipo->getRetirado() == 1) { echo 'disabled'; } } else { echo 'disabled'; } }?> >
              <option selected value="" >Seleccione una opci&oacute;n</option>
              <option value="-" <?php if(strtolower($equipo->getRelacionTi()) == '-') { echo 'selected'; } ?> >-</option> 
              <option value="1/1" <?php if(strtolower($equipo->getRelacionTi()) == '1/1') { echo 'selected'; } ?> >1/1</option> 
              <option value="15/5" <?php if(strtolower($equipo->getRelacionTi()) == '15/5') { echo 'selected'; } ?> >15/5</option>
              <option value="25/5" <?php if(strtolower($equipo->getRelacionTi()) == '25/5') { echo 'selected'; } ?> >25/5</option>
              <option value="30/5" <?php if(strtolower($equipo->getRelacionTi()) == '30/5') { echo 'selected'; } ?> >30/5</option>
              <option value="50/5" <?php if(strtolower($equipo->getRelacionTi()) == '50/5') { echo 'selected'; } ?> >50/5</option>
              <option value="100/5" <?php if(strtolower($equipo->getRelacionTi()) == '100/5') { echo 'selected'; } ?> >100/5</option>
              <option value="150/5" <?php if(strtolower($equipo->getRelacionTi()) == '150/5') { echo 'selected'; } ?> >150/5</option>
              <option value="200/5" <?php if(strtolower($equipo->getRelacionTi()) == '200/5') { echo 'selected'; } ?> >200/5</option>
              <option value="250/5" <?php if(strtolower($equipo->getRelacionTi()) == '250/5') { echo 'selected'; } ?> >250/5</option>
              <option value="300/5" <?php if(strtolower($equipo->getRelacionTi()) == '300/5') { echo 'selected'; } ?> >300/5</option>
              <option value="350/5" <?php if(strtolower($equipo->getRelacionTi()) == '350/5') { echo 'selected'; } ?> >350/5</option>
              <option value="400/5" <?php if(strtolower($equipo->getRelacionTi()) == '400/5') { echo 'selected'; } ?> >400/5</option>
              <option value="500/5" <?php if(strtolower($equipo->getRelacionTi()) == '500/5') { echo 'selected'; } ?> >500/5</option>
              <option value="600/5" <?php if(strtolower($equipo->getRelacionTi()) == '600/5') { echo 'selected'; } ?> >600/5</option>
              <option value="700/5" <?php if(strtolower($equipo->getRelacionTi()) == '700/5') { echo 'selected'; } ?> >700/5</option>
              <option value="800/5" <?php if(strtolower($equipo->getRelacionTi()) == '800/5') { echo 'selected'; } ?> >800/5</option>
			  <option value="1000/5" <?php if(strtolower($equipo->getRelacionTi()) == '1000/5') { echo 'selected'; } ?> >1000/5</option>
              <option value="1500/5" <?php if(strtolower($equipo->getRelacionTi()) == '1500/5') { echo 'selected'; } ?> >1500/5</option>
            </select> 
                <div class="help-block with-errors"></div>
               </div>
            </div>
      </div>

  <div class="row">
          <div class="col-md-4">
            <div class="form-group">
                <label for="nro_ti_r">N&uacute;mero de TI fase R</label>
                <input type="number" class="form-control" id="nro_ti_r" name="nro_ti_r" placeholder="N&uacute;mero de TI fase R" value="<?php if ($equipo->getNroTiR() == '0') { echo ''; } else { echo $equipo->getNroTiR(); }?>" <?php if($_GET['id']) { if($_SESSION['administrador']['id'] == 1 || $_SESSION['administrador']['id'] == 2 || $_SESSION['administrador']['id'] == 3) { if($equipo->getRetirado() == 1) { echo 'disabled'; } } else { echo 'disabled'; } } ?> >
                <div class="help-block with-errors"></div>
            </div> 
          </div>
          <div class="col-md-4">
            <div class="form-group">
                <label for="nro_ti_s">N&uacute;mero de TI fase S</label>
                <input type="number" class="form-control" id="nro_ti_s" name="nro_ti_s" placeholder="N&uacute;mero de TI fase S" value="<?php if ($equipo->getNroTiS() == '0') { echo ''; } else { echo $equipo->getNroTiS(); }?>" <?php if($_GET['id']) { if($_SESSION['administrador']['id'] == 1 || $_SESSION['administrador']['id'] == 2 || $_SESSION['administrador']['id'] == 3) { if($equipo->getRetirado() == 1) { echo 'disabled'; } } else { echo 'disabled'; } } ?> >
                <div class="help-block with-errors"></div>
            </div> 
          </div>
          <div class="col-md-4">
            <div class="form-group">
                <label for="nro_ti_t">N&uacute;mero de TI fase T</label>
                <input type="number" class="form-control" id="nro_ti_t" name="nro_ti_t" placeholder="N&uacute;mero de TI fase T" value="<?php if ($equipo->getNroTiT() == '0') { echo ''; } else { echo $equipo->getNroTiT(); }?>" <?php if($_GET['id']) { if($_SESSION['administrador']['id'] == 1 || $_SESSION['administrador']['id'] == 2 || $_SESSION['administrador']['id'] == 3) { if($equipo->getRetirado() == 1) { echo 'disabled'; } } else { echo 'disabled'; } } ?> >
                <div class="help-block with-errors"></div>
            </div> 
          </div> 
    </div>

</div> 

<hr>

            <div class="form-group">
                <label for="observacion">Observaci&oacute;n</label>
                <input type="text" class="form-control" id="observacion" name="observacion" placeholder="Observaci&oacute;n" value="<?php if ($equipo->getObservacion() == '0') { echo ''; } else { echo ucfirst($equipo->getObservacion()); }?>" <?php if($equipo->getRetirado() == 1) { echo 'disabled'; } ?> >
                <div class="help-block with-errors"></div>
            </div>

          <div class="col-auto">
                <label for="telemedicion">
                <input type="checkbox" id="telemedicion" name="telemedicion" <?php if($equipo->getTelemedicion() == 1) { echo 'checked'; } ?> <?php if($_GET['id']) { if($_SESSION['administrador']['id'] == 1 || $_SESSION['administrador']['id'] == 2 || $_SESSION['administrador']['id'] == 3) { if($equipo->getRetirado() == 1) { echo 'disabled'; } } else { echo 'disabled'; } }?> > Telemedici&oacute;n
                </label>
                <p class="help-block">(Seleccione esta opci&oacute;n si el equipo es telemedido)</p>
                <div class="help-block with-errors"></div>
            </div>


          <?php 
            if ($_GET['id']) {
          
if($_SESSION['administrador']['id'] == 1 || $_SESSION['administrador']['id'] == 2 || $_SESSION['administrador']['id'] == 3) { $estado = 'checkbox';

              } else { if ($equipo->getRetirado() == 0) { $estado = 'hidden'; } else { $estado = 'checkbox'; } }

              if ($estado == 'checkbox') {

          ?>
      <div class="col-auto">
            <label for="retirado">
              <input type="<?php echo $estado; ?>" id="retirado" name="retirado" <?php if($equipo->getRetirado() == 1) { echo 'checked'; } ?>> Equipo Retirado
            </label>
            <p class="help-block">(Seleccione esta opci&oacute;n si el equipo fue retirado)</p>
                <div class="help-block with-errors"></div>
      </div>

<?php
} // de estado == checkbox
} // si viene con id

?>

            <button type="button" class="btn btn-default cancelForm">Cancelar</button>

            <div class="btn-group dropup">
              <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                <?php echo $txtAction; ?> y... <span class="caret"></span>
              </button>
              <ul class="dropdown-menu" role="menu" id="submit">
                <li><a href="?modulo=equipo&accion=buscar">Ir al buscador</a></li>
                <?php if($_GET['id']) { ?>
                <li><a href="?modulo=consulta&accion=listar&id_equipo">Ir a revisiones</a></li>
                <?php if($_GET['coord']) { ?>
                <li><a href="?modulo=equipo&accion=listarSinCoordenadas">Volver al listado</a></li>
                  <?php }
                } else { ?>
                <li><a href="?modulo=consulta&accion=editar&id_equipo">Agregar revisi&oacute;n</a></li>
                <li><a href="?modulo=equipo&accion=editar">Agregar otro equipo</a></li>
                <?php  } ?>
              </ul>
            </div>
            <button type="submit" class="btn btn-primary hidden" id="submit-button"></button>

        </form>
    </div>