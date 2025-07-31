<?php    
        require_once('negocio/medidorNegocio.php');
        $medidorNegocio = new MedidorNegocio();
        $arrayMedidores = $medidorNegocio->listar();

        if ($_GET['id']) {

        $consulta = $consultaNegocio->recuperar($_GET['id']);
        $txtAction = 'Editar';
        $fechaConsulta = Util::dbToDate($consulta->getFecha());

        $motivo = $consulta->getMotivo();
        $visual = $consulta->getLeido();
        $visual2 = $consulta->getLeido2();
        $visual3 = $consulta->getLeido3();
        $visual4 = $consulta->getLeido4();
        $visual5 = $consulta->getLeido5();

        $arrayConsultas = $consultaNegocio->listarOrdenado($_GET['id_equipo']);
        $primero = $arrayConsultas[0];

            if ($primero->getId() == $consulta->getId())
            {}
            else { ?>
            <div class="container" id="non-printable">
                <div class="alert alert-danger" role="alert"><b>No puede realizar esta operaci&oacute;n</b></div>
            </div>
<?php 
            die();  
            }

      $medidor_consulta = $medidorNegocio->recuperar($consulta->getIdMedidor());

      } else {

      if ($_GET['novedad'])
      {
        $motivo = 0;
      } else {
        $motivo = 1;
      }

      $consulta = new Consulta();
      $txtAction = 'Agregar';
      $fechaConsulta = date('d/m/Y');

      $visual = 0;
      $visual2 = 0;
      $visual3 = 0;
      $visual4 = 0;
      $visual5 = 0;

      }
      
      require_once('negocio/transformadorTensionNegocio.php');
      $transformadorTensionNegocio = new TransformadorTensionNegocio();
      $arrayTv = $transformadorTensionNegocio->listar();

      require_once('negocio/transformadorCorrienteNegocio.php');
      $transformadorCorrienteNegocio = new TransformadorCorrienteNegocio();
      $arrayTi = $transformadorCorrienteNegocio->listar();

      require_once('negocio/controlNegocio.php');
      $controlNegocio = new ControlNegocio();
      $arrayControles = $controlNegocio->listar();

      require_once('negocio/lecturaNegocio.php');
      $lecturaNegocio = new LecturaNegocio();

      if ($visual == ('on' || 1 )) {
          $lectura = $lecturaNegocio->recuperarUna($_GET['id'], 0); //lectura visual comun
      }
      if ($visual3 == ('on' || 1 )) {
          $lectura2 = $lecturaNegocio->recuperarUna($_GET['id'], 1); // lectura de retiro
      } 
      if ($visual4 == ('on' || 1 )) {
          $lectura3 = $lecturaNegocio->recuperarUna($_GET['id'], 2); //lectura de reseteo
      } 
      if ($visual5 == ('on' || 1 )) {
          $lectura4 = $lecturaNegocio->recuperarUna($_GET['id'], 3); //lectura de respaldo
      } 
      require_once('negocio/equipoNegocio.php');
      $equipoNegocio = new EquipoNegocio();
      $equipo = $equipoNegocio->recuperar($_GET['id_equipo']);
      $medidor_equipo = $medidorNegocio->recuperar($equipo->getIdMedidor());

      if($equipo->getRetirado() == 1) {
        $reti = 'listar';
?>
        <div class="container" id="non-printable">
            <div class="alert alert-danger" role="alert"><b>No puede realizar esta operaci&oacute;n</b></div>
        </div>
<?php 
        die();

      } else {
        $reti = 'editar';
      }
?>
    <div class="container" id="non-printable">
        <ol class="breadcrumb" id="non-printable">
              <li class="active"><?php echo $equipo->getFolio() . ' - ' . mb_strtoupper($equipo->getUsuario(), 'UTF-8'); ?></a></li>
        </ol>
      <div class="page-header" id="non-printable">
          <h1><?php echo $txtAction; if ($_GET['novedad'] || $motivo == '0') { ?> Problema <?php } else { ?> Revisi&oacute;n <?php } ?></h1>
      </div>
      <?php echo Util::getMsj(); ?>

      <form role="form" method="post" id="principal">

        <input type="hidden" name="id_administrador" value="<?php echo $_SESSION['administrador']['id'];?>">
<?php

          if ($_GET['novedad'] || $motivo == '0'){
?> 
          <div class="container" style="display:none" id="non-printable">
<?php 
          }
?>

  <div class="form-group">
          <div class="col-auto">
              <label for="leido2">
              <input type="checkbox" id="leido2" name="leido2" <?php if($_GET['id']) { if($consulta->getLeido2() == 1) { echo 'checked'; } }?>> Medidor Retirado
              </label>
              <p class="help-block">(Seleccione esta opci&oacute;n si se retir&oacute; el medidor)</p>
              <div class="help-block with-errors"></div> 
            </div>
  </div>

<div class="panel panel-warning" id="div-lectura2" <?php if ($_GET['id']) { if ( $visual2 == ('on' || 1) ) {  } else { ?> style="display:none" <?php } } else { ?> style="display:none" <?php }  ?>>
      <div class="panel-heading">
          <h3 class="panel-title">Datos de Medidor Retirado</h3>
      </div>
    <div class="panel-body">

    <div class="row">
          <div class="col-md-6">
            <div class="form-group">
                <label for="id_medidor_ret">Tipo de Medidor Retirado</label>
                <select class="form-control" id="id_medidor_ret" name="id_medidor_ret">
                    <option value="">Seleccione una opci&oacute;n</option>
                    <?php
                    foreach ($arrayMedidores as $medidor_ret) {
                        echo '<option value="'. $medidor_ret->getId() .'" ';

 if($_GET['id']) { if ($visual2 == ('on' || 1)) { if($consulta->getIdMedidorRet() == $medidor_ret->getId()) { if($medidor_ret->getId() == 1) {} else { echo "selected "; } } } }

                        echo '>' . strtoupper($medidor_ret->getTipo()) . '</option>';
                    }
                    ?>
                </select>
                <div class="help-block with-errors"></div>
               </div>            
             </div>
          <div class="col-md-6">
              <div class="form-group">
                <label for="nro_medidor_ret">N&uacute;mero de Medidor Retirado</label>
                <input type="text" class="form-control" id="nro_medidor_ret" name="nro_medidor_ret" placeholder="N&uacute;mero de Medidor Retirado" value="<?php if($_GET['id']) { if ($visual2 == ('on' || 1)) { echo $consulta->getNroMedidorRet(); } }?>" >
                <div class="help-block with-errors"></div>
              </div>
          </div>  
    </div>  

<hr>

  <div class="form-group">
          <div class="col-auto">
                <label for="leido3">
                <input type="checkbox" id="leido3" name="leido3" <?php if($_GET['id']) { if($consulta->getLeido3() == 1) { echo 'checked'; } } ?> > Lectura Visual Medidor Retirado
                </label>
                <p class="help-block">(Seleccione esta opci&oacute;n para cargar la lectura visual del medidor retirado)</p>
                <div class="help-block with-errors"></div> 
              </div>
  </div>

<div class="panel panel-warning" id="div-lectura3" <?php if ($_GET['id']) { if ( $visual3 == ('on' || 1) ) {  } else { ?> style="display:none" <?php } } else { ?> style="display:none" <?php }  ?>>
      <div class="panel-heading">
          <h3 class="panel-title">Datos de Lectura de Medidor Retirado</h3>
      </div>
    <div class="panel-body">

      <div class="row">
          <div class="col-md-3">
                     <div class="form-group" >
                        <label for="cuatrow">4</label>
                        <input type="number" step="0.001" class="form-control" id="cuatrow" name="cuatrow" placeholder="Cuatro" value="<?php if($_GET['id']) { if($visual3 == ('on' || 1)) { echo $lectura2->getCuatro(); }} ?>">
                          <div class="help-block with-errors"></div> 
                     </div>  
                     <div class="form-group" >
                        <label for="cincow">5</label>
                        <input type="number" step="0.001" class="form-control" id="cincow" name="cincow" placeholder="Cinco" value="<?php if($_GET['id']) { if($visual3 == ('on' || 1)) { echo $lectura2->getCinco(); }} ?>">
                          <div class="help-block with-errors"></div> 
                     </div>   
              </div>
          <div class="col-md-3">
                     <div class="form-group" >
                        <label for="seisw">6</label>
                        <input type="number" step="0.001" class="form-control" id="seisw" name="seisw" placeholder="Seis" value="<?php if($_GET['id']) { if ($visual3 == ('on' || 1)) { echo $lectura2->getSeis(); } }?>">
                          <div class="help-block with-errors"></div> 
                     </div>
                     <div class="form-group" >
                        <label for="nuevew">9</label>
                        <input type="number" step="0.001" class="form-control" id="nuevew" name="nuevew" placeholder="Nueve" value="<?php if($_GET['id']) { if ($visual3 == ('on' || 1)) { echo $lectura2->getNueve(); }}?>">
                          <div class="help-block with-errors"></div> 
                     </div>
              </div>     
          <div class="col-md-3">
                     <div class="form-group" >
                        <label for="diesw">10</label>
                        <input type="number" step="0.001" class="form-control" id="diesw" name="diesw" placeholder="Diez" value="<?php if($_GET['id']) { if ($visual3 == ('on' || 1)) { echo $lectura2->getDies(); } }?>">
                          <div class="help-block with-errors"></div> 
                     </div>
                     <div class="form-group" >
                        <label for="trecew">13</label>
                        <input type="number" step="0.001" class="form-control" id="trecew" name="trecew" placeholder="Trece" value="<?php if($_GET['id']) { if ($visual3 == ('on' || 1)) { echo $lectura2->getTrece(); } }?>">
                          <div class="help-block with-errors"></div> 
                     </div>    
            </div>
          <div class="col-md-3">
                     <div class="form-group" >
                        <label for="catorcew">14</label>
                        <input type="number" step="0.001" class="form-control" id="catorcew" name="catorcew" placeholder="Catorce" value="<?php if($_GET['id']) { if ($visual3 == ('on' || 1)) { echo $lectura2->getCatorce(); } }?>">
                          <div class="help-block with-errors"></div> 
                      </div>  
                     <div class="form-group" >
                        <label for="dieciseisw">16</label>
                        <input type="number" step="0.001" class="form-control" id="dieciseisw" name="dieciseisw" placeholder="Dieciseis" value="<?php if($_GET['id']) { if ($visual3 == ('on' || 1)) { echo $lectura2->getDieciseis(); } }?>">
                          <div class="help-block with-errors"></div> 
                     </div>
            </div>         
      </div>
  
<hr>

      <div class="row">
          <div class="col-md-3">
                     <div class="form-group" >
                        <label for="treintaycuatrow">34</label>
                        <input type="number" step="0.001" class="form-control" id="treintaycuatrow" name="treintaycuatrow" placeholder="Treinta y cuatro" value="<?php if($_GET['id']) { if ($visual3 == ('on' || 1)) { echo $lectura2->getTreintaycuatro(); } }?>">
                          <div class="help-block with-errors"></div> 
                      </div>  
                     <div class="form-group" >
                        <label for="treintaycincow">35</label>
                        <input type="number" step="0.001" class="form-control" id="treintaycincow" name="treintaycincow" placeholder="Treinta y cinco" value="<?php if($_GET['id']) { if ($visual3 == ('on' || 1)) { echo $lectura2->getTreintaycinco(); } }?>">
                          <div class="help-block with-errors"></div> 
                      </div>    
                     <div class="form-group" >
                        <label for="treintayseisw">36</label>
                        <input type="number" step="0.001" class="form-control" id="treintayseisw" name="treintayseisw" placeholder="Treinta y seis" value="<?php if($_GET['id']) { if ($visual3 == ('on' || 1)) { echo $lectura2->getTreintayseis(); } }?>">
                          <div class="help-block with-errors"></div> 
                     </div> 
              </div>
          <div class="col-md-3">
                     <div class="form-group" >
                        <label for="treintaysietew">37</label>
                        <input type="number" step="0.001" class="form-control" id="treintaysietew" name="treintaysietew" placeholder="Treinta y siete" value="<?php if($_GET['id']) { if ($visual3 == ('on' || 1)) { echo $lectura2->getTreintaysiete(); } }?>">
                          <div class="help-block with-errors"></div> 
                      </div>  
                     <div class="form-group" >
                        <label for="treintaynuevew">39</label>
                        <input type="number" step="0.001" class="form-control" id="treintaynuevew" name="treintaynuevew" placeholder="Treinta y nueve" value="<?php if($_GET['id']) { if ($visual3 == ('on' || 1)) { echo $lectura2->getTreintaynueve(); } }?>">
                          <div class="help-block with-errors"></div> 
                      </div>    
                     <div class="form-group" >
                        <label for="cuarentaw">40</label>
                        <input type="number" step="0.001" class="form-control" id="cuarentaw" name="cuarentaw" placeholder="Cuarenta" value="<?php if($_GET['id']) { if ($visual3 == ('on' || 1)) { echo $lectura2->getCuarenta(); } }?>">
                          <div class="help-block with-errors"></div> 
                     </div> 
              </div>     
          <div class="col-md-3">
                     <div class="form-group" >
                        <label for="cuarentayunow">41</label>
                        <input type="number" step="0.001" class="form-control" id="cuarentayunow" name="cuarentayunow" placeholder="Cuarenta y uno" value="<?php if($_GET['id']) { if ($visual3 == ('on' || 1)) { echo $lectura2->getCuarentayuno(); } }?>">
                          <div class="help-block with-errors"></div> 
                      </div>  
                     <div class="form-group" >
                        <label for="cuarentaytresw">43</label>
                        <input type="number" step="0.001" class="form-control" id="cuarentaytresw" name="cuarentaytresw" placeholder="Cuarenta y tres" value="<?php if($_GET['id']) { if ($visual3 == ('on' || 1)) { echo $lectura2->getCuarentaytres(); } }?>">
                          <div class="help-block with-errors"></div> 
                     </div>   
                     <div class="form-group" >
                        <label for="cuarentaycuatrow">44</label>
                        <input type="number" step="0.001" class="form-control" id="cuarentaycuatrow" name="cuarentaycuatrow" placeholder="Cuarenta y cuatro" value="<?php if($_GET['id']) { if ($visual3 == ('on' || 1)) { echo $lectura2->getCuarentaycuatro(); } }?>">
                          <div class="help-block with-errors"></div> 
                     </div>   
            </div>
          <div class="col-md-3">
                     <div class="form-group" >
                        <label for="cuarentaycincow">45</label>
                        <input type="number" step="0.001" class="form-control" id="cuarentaycincow" name="cuarentaycincow" placeholder="Cuarenta y cinco" value="<?php if($_GET['id']) { if ($visual3 == ('on' || 1)) { echo $lectura2->getCuarentaycinco(); } }?>">
                          <div class="help-block with-errors"></div> 
                      </div>  
                     <div class="form-group" >
                        <label for="cuarentayseisw">46</label>
                        <input type="number" step="0.001" class="form-control" id="cuarentayseisw" name="cuarentayseisw" placeholder="Cuarenta y seis" value="<?php if($_GET['id']) { if ($visual3 == ('on' || 1)) { echo $lectura2->getCuarentayseis(); } }?>">
                          <div class="help-block with-errors"></div> 
                     </div>     
            </div> 
      </div>

<hr>
       
    <div class="row">
          <div class="col-md-3">
                     <div class="form-group" >
                        <label for="errew">R</label>
                        <input type="number" step="0.0" class="form-control" id="errew" name="errew" placeholder="R" value="<?php if($_GET['id']) { if ($visual3 == ('on' || 1)) { echo $lectura2->getErre(); } }?>">
                          <div class="help-block with-errors"></div> 
                     </div>   
            </div>
          <div class="col-md-3">
                    <div class="form-group" >
                        <label for="esew">S</label>
                        <input type="number" step="0.0" class="form-control" id="esew" name="esew" placeholder="S" value="<?php if($_GET['id']) { if ($visual3 == ('on' || 1)) { echo $lectura2->getEse(); } }?>">
                          <div class="help-block with-errors"></div> 
                     </div>
            </div>     
          <div class="col-md-3">
                     <div class="form-group" >
                        <label for="tew">T</label>
                        <input type="number" step="0.0" class="form-control" id="tew" name="tew" placeholder="T" value="<?php if($_GET['id']) { if ($visual3 == ('on' || 1)) { echo $lectura2->getTe(); } }?>">
                          <div class="help-block with-errors"></div> 
                     </div> 
            </div>
          <div class="col-md-3">
                     <div class="form-group" >
                        <label for="diecinuevew">19</label>
                        <input type="number" step="0.0" class="form-control" id="diecinuevew" name="diecinuevew" placeholder="Diecinueve" value="<?php if($_GET['id']) { if ($visual3 == ('on' || 1)) { echo $lectura2->getDiecinueve(); } }?>">
                          <div class="help-block with-errors"></div> 
                        </div>
            </div>         
    </div>

            </div>
            </div>

            </div>
            </div>


<div class="panel panel-info">
      <div class="panel-heading">
          <h3 class="panel-title">Datos de Equipo</h3>
      </div>
  <div class="panel-body">
  
  <div class="row">
            <div class="col-md-12"> 
                <div class="form-group">
                <label for="usuario">Usuario</label>
                <input type="text" class="form-control" id="usuario" name="usuario" placeholder="Usuario" value="<?php if ($equipo->getUsuario() == '0') { echo ''; } else { echo mb_strtoupper($equipo->getUsuario(), 'UTF-8'); }?>" required >
                <div class="help-block with-errors"></div>
                </div>
            </div>
  </div>

<div class="row">
            <div class="col-md-6"> 
                <div class="form-group">
                <label for="ruta">Ruta</label>
                <input type="number" class="form-control" id="ruta" name="ruta" placeholder="Ruta" value="<?php if ($equipo->getRuta() == '0') { echo ''; } else { echo $equipo->getRuta(); }?>" <?php if($_SESSION['administrador']['id'] == 1 || $_SESSION['administrador']['id'] == 2 || $_SESSION['administrador']['id'] == 3) {} else { if($equipo->getRuta() == '0') {} else { echo 'readonly'; } }?> >
                <div class="help-block with-errors"></div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                <label for="folio">Folio</label>
                <input type="number" class="form-control" id="folio" name="folio" placeholder="Folio" value="<?php if ($equipo->getFolio() == '0') { echo ''; } else { echo $equipo->getFolio(); }?>" <?php if ($_GET['novedad'] || $motivo == '0') {} else { 
                  echo 'required ';
                  if($_SESSION['administrador']['id'] == 1 || $_SESSION['administrador']['id'] == 2 || $_SESSION['administrador']['id'] == 3) {} else { if($equipo->getFolio() == '0') {} else { echo 'readonly'; } }
                  } ?> >
                <div class="help-block with-errors"></div>
                </div> 
            </div>
</div>

      <input type="hidden" id="alta" name="alta" value="<?php echo Util::dbToDate($equipo->getAlta());?>"  pattern="^(?:(?:31(\/|-|\.)(?:0?[13578]|1[02]))\1|(?:(?:29|30)(\/|-|\.)(?:0?[1,3-9]|1[0-2])\2))(?:(?:1[6-9]|[2-9]\d)?\d{2})$|^(?:29(\/|-|\.)0?2\3(?:(?:(?:1[6-9]|[2-9]\d)?(?:0[48]|[2468][048]|[13579][26])|(?:(?:16|[2468][048]|[3579][26])00))))$|^(?:0?[1-9]|1\d|2[0-8])(\/|-|\.)(?:(?:0?[1-9])|(?:1[0-2]))\4(?:(?:1[6-9]|[2-9]\d)?\d{2})$" >

<div class="row">
            <div class="col-md-6"> 
                <div class="form-group">
                <label for="direccion">Direcci&oacute;n</label>
                <input type="text" class="form-control" id="direccion" name="direccion" placeholder="Direcci&oacute;n" value="<?php if ($equipo->getDireccion() == '0') { echo ''; } else { echo ucwords($equipo->getDireccion()); }?>" required>
                <div class="help-block with-errors"></div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                <label for="localidad">Localidad</label>
                <input type="text" class="form-control" id="localidad" name="localidad" placeholder="Localidad" value="<?php if ($equipo->getLocalidad() == '0') { echo ''; } else { echo ucwords($equipo->getLocalidad()); }?>" required>
                <div class="help-block with-errors"></div>
                </div>
            </div>
</div>

<div class="row">
            <div class="col-md-6"> 
                <div class="form-group">
                <label for="latitud">Latitud</label>
                <p class="help-block" style="display: inline;">(Formato -dd.dddddd)</p>
                <input type="number" step="0.000001" class="form-control" id="latitud" name="latitud" placeholder="-dd.dddd" value="<?php if ($equipo->getLatitud() == 0) { echo ''; } else { echo $equipo->getLatitud(); }?>" >
                <div class="help-block with-errors"></div>
                </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="longitud">Longitud</label>
                <p class="help-block" style="display: inline;">(Formato -dd.dddddd)</p>                
                <input type="number" step="0.000001" class="form-control" id="longitud" name="longitud" placeholder="-dd.dddd" value="<?php if ($equipo->getLongitud() == 0) { echo ''; } else { echo $equipo->getLongitud(); }?>" >
                <div class="help-block with-errors"></div>
              </div>
            </div>
</div>


<hr>

<div class="row">
          <div class="col-md-6">
            <div class="form-group">
                <label for="id_medidor">Tipo de Medidor</label>
                <select class="form-control" id="id_medidor" name="id_medidor" <?php if ($_GET['novedad'] || $motivo == '0') {} else { echo 'required'; } ?>>
                    <option value="">Seleccione una opci&oacute;n</option>
                    <?php
                    foreach ($arrayMedidores as $medidor) {
                        echo '<option value="'. $medidor->getId() .'" ';

if($_GET['id']) { if($consulta->getIdMedidor() == $medidor->getId()) { if($medidor->getId() == 1) {} else {  echo "selected "; } } } else { if($equipo->getIdMedidor() == $medidor->getId()) { if($medidor->getId() == 1) {} else { echo "selected "; } } }


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
                <input type="number" class="form-control" id="nro_medidor" name="nro_medidor" placeholder="N&uacute;mero de Medidor" <?php if ($_GET['novedad'] || $motivo == '0') {} else { echo 'required'; } ?> value="<?php if($_GET['id']) { echo $consulta->getNroMedidor(); } else { if ($equipo->getNroMedidor() == '0') { echo ''; } else { echo $equipo->getNroMedidor(); } }?>" >
                <div class="help-block with-errors"></div>
                </div> 
            </div>
</div> 
 

      <div class="col-auto">
            <label for="respaldo">
              <input type="checkbox" id="respaldo" name="respaldo" <?php if($_GET['id']) { if($consulta->getRespaldo() == 1) { echo 'checked'; } } else { if($equipo->getRespaldo() == 1) { echo 'checked'; } } ?>> Medidor de Respaldo
            </label>
            <p class="help-block">(Seleccione esta opci&oacute;n si el equipo tiene un medidor de respaldo)</p>
                <div class="help-block with-errors"></div>
      </div>


<div class="row" id="div-respaldo" <?php if ($_GET['id']) { if ( $consulta->getRespaldo() == ('on' || 1) ) {} else { ?> style="display:none" <?php } } else { if( $equipo->getRespaldo() == ('on' || 1)) {} else { ?> style="display:none" <?php } } ?>>
          <div class="col-md-6">
            <div class="form-group">
                <label for="id_medidor_respaldo">Tipo de Medidor de Respaldo</label>
                <select class="form-control" id="id_medidor_respaldo" name="id_medidor_respaldo">
                    <option value="">Seleccione una opci&oacute;n</option>
                    <?php
                    foreach ($arrayMedidores as $medidor_respaldo) {
                        echo '<option value="'. $medidor_respaldo->getId() .'" ';

if($_GET['id']) { if($consulta->getIdMedidorRespaldo() == $medidor_respaldo->getId()) { if($medidor_respaldo->getId() == 1) {} else {  echo "selected "; } } } else { if($equipo->getIdMedidorRespaldo() == $medidor_respaldo->getId()) { if($medidor_respaldo->getId() == 1) {} else { echo "selected "; } } }


                        echo '>' . strtoupper($medidor_respaldo->getTipo()) . '</option>';
                    }
                    ?>
                </select>
                <div class="help-block with-errors"></div>
               </div>            
             </div>

            <div class="col-md-6"> 
                <div class="form-group">
                <label for="nro_medidor_respaldo">N&uacute;mero de Medidor de Respaldo</label>
                <input type="number" class="form-control" id="nro_medidor_respaldo" name="nro_medidor_respaldo" placeholder="N&uacute;mero de Medidor de Respaldo" value="<?php if($_GET['id']) { if($consulta->getNroMedidorRespaldo() == '0') { echo ''; } else { echo $consulta->getNroMedidorRespaldo(); } } else { if ($equipo->getNroMedidorRespaldo() == '0') { echo ''; } else { echo $equipo->getNroMedidorRespaldo(); } }?>" >
                <div class="help-block with-errors"></div>
                </div> 
            </div>
</div> 
 


<div class="row">
            <div class="col-md-6"> 
                <div class="form-group">
                <label for="potencia">Potencia</label>
                <div class="input-group">
                <input type="number" class="form-control" id="potencia" name="potencia" placeholder="Potencia" value="<?php if($_GET['id']) { if ($consulta->getPotencia() == '0') { echo ''; } else { echo $consulta->getPotencia(); } } else { if ($equipo->getPotencia() == '0') { echo ''; } else { echo $equipo->getPotencia(); } }?>" >
                <div class="input-group-addon">KW</div>
                </div>  
                </div>  
        </div>
</div> 

<div id="directo2" <?php if($_GET['id']) { if($medidor_consulta->getId() == 2 || $medidor_consulta->getId() == 3) { ?> style="display: none;" <?php } } else { if($medidor_equipo->getId() ==  2 || $medidor_equipo->getId() ==  3) { ?> style="display: none;" <?php } else {} } ?>>

<div class="row">
            <div class="col-md-6"> 
              <div class="form-group">
              <div class="col-auto">
              <label for="media_tension">
              <input type="checkbox" id="media_tension" name="media_tension" <?php if($_GET['id']) { if($consulta->getMediaTension() == 1) { echo 'checked'; } } else { if($equipo->getMediaTension() == 1) { echo 'checked'; } }?>> Media Tensi&oacute;n
              </label>
              <p class="help-block">(Seleccione esta opci&oacute;n si el equipo es de media tensi&oacute;n)</p>
              </div>
              </div> 
            </div>
</div>

<div id="div-relacion-tv3" <?php if ($_GET['id']) { if($consulta->getMediaTension() == 0) { ?> style="display:none" <?php } else {} } else { if($equipo->getMediaTension() == 0) { ?> style="display:none" <?php } else {} } ?>>

    <div class="row">
          <div class="col-md-4">
            <div class="form-group">
                <label for="id_tv">Tipo de TV</label>
                <select class="form-control" id="id_tv" name="id_tv">
                    <option value="">Seleccione una opci&oacute;n</option>
                    <?php
                    foreach ($arrayTv as $tv) {

                        echo '<option value="'. $tv->getId() .'" ';

if($_GET['id']) { if($consulta->getIdTv() == $tv->getId()) { if($tv->getId() == 1) {} else {  echo "selected "; } } } else { if($equipo->getIdTv() == $tv->getId()) { if($tv->getId() == 1) {} else { echo "selected "; } } }

                        if ($tv->getId() == 1) {
                        echo '>' . strtoupper($tv->getTipo()) . '</option>';

                        } else {
                        echo '>' . strtoupper($tv->getTipo()) . ' - '. strtoupper($tv->getClase()) . ' - ' . strtoupper($tv->getPrestacion()) . '</option>';
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
                  <select class="form-control" id="cabina" name="cabina"  >
                        <option selected value="" >Seleccione una opci&oacute;n</option>
                        <option value="1" <?php if($_GET['id']) { if($consulta->getCabina() == '1') { echo 'selected'; } } else { if($equipo->getCabina() == '1') { echo 'selected'; } }?> >No Especificado</option> 
                        <option value="13200" <?php if($_GET['id']) { if($consulta->getCabina() == '13200') { echo 'selected'; } } else { if($equipo->getCabina() == '13200') { echo 'selected'; } } ?> >13200 V</option>
                        <option value="33000" <?php if($_GET['id']) { if($consulta->getCabina() == '33000') { echo 'selected'; } } else { if($equipo->getCabina() == '33000') { echo 'selected'; } } ?> >33000 V</option>
                        <option value="132000" <?php if($_GET['id']) { if($consulta->getCabina() == '132000') { echo 'selected'; } } else { if($equipo->getCabina() == '132000') { echo 'selected'; } } ?> >132000 V</option>
                  </select>
                <div class="help-block with-errors"></div>
            </div>
            </div>
</div>

     <div class="row">
          <div class="col-md-4">
            <div class="form-group">
                <label for="nro_tv_r">N&uacute;mero de TV fase R</label>
                <input type="number" class="form-control" id="nro_tv_r" name="nro_tv_r" placeholder="N&uacute;mero de TV fase R" value="<?php if($_GET['id']) { if ($consulta->getNroTvR() == '0') { echo ''; } else { echo $consulta->getNroTvR(); } } else { if ($equipo->getNroTvR() == '0') { echo ''; } else { echo $equipo->getNroTvR(); } }?>" >
              <div class="help-block with-errors"></div>
            </div> 
          </div>
          <div class="col-md-4">
            <div class="form-group">
                <label for="nro_tv_s">N&uacute;mero de TV fase S</label>
                <input type="number" class="form-control" id="nro_tv_s" name="nro_tv_s" placeholder="N&uacute;mero de TV fase S" value="<?php if($_GET['id']) { if ($consulta->getNroTvS() == '0') { echo ''; } else { echo $consulta->getNroTvS(); } } else { if ($equipo->getNroTvS() == '0') { echo ''; } else { echo $equipo->getNroTvS(); } }?>" >
              <div class="help-block with-errors"></div>
            </div> 
          </div>
          <div class="col-md-4">
              <div class="form-group">
                <label for="nro_tv_t">N&uacute;mero de TV fase T</label>
                <input type="number" class="form-control" id="nro_tv_t" name="nro_tv_t" placeholder="N&uacute;mero de TV fase T" value="<?php if($_GET['id']) { if ($consulta->getNroTvT() == '0') { echo ''; } else { echo $consulta->getNroTvT(); } } else { if ($equipo->getNroTvT() == '0') { echo ''; } else { echo $equipo->getNroTvT(); } }?>" >
                <div class="help-block with-errors"></div>
              </div> 
            </div> 
      </div>

</div> 
      
<hr>
          
<div class="row">
        <div class="col-md-4">
          <div class="form-group">
                <label for="tipo_controle">Tipo de Controles</label>
                <select class="form-control" id="tipo_controle" name="id_control" <?php if ($_GET['novedad'] || $motivo == '0') {} else { echo 'required'; } ?>>
                    <option value="">Seleccione una opci&oacute;n</option>
                    <?php
                    foreach ($arrayControles as $control) {
                        echo '<option value="'. $control->getId() .'" ';

if($_GET['id']) { if($consulta->getIdControl() == $control->getId()) { if($control->getId() == 1) {} else {  echo "selected "; } } } else { if($equipo->getIdControl() == $control->getId()) { if($control->getId() == 1) {} else { echo "selected "; } } }

                        if($control->getId() == 1){
                        echo '>' . strtoupper($control->getTipo()) . '</option>';
                        } else {
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
                <input type="number" class="form-control" id="nro_control_r" name="nro_control_r" placeholder="N&uacute;mero de Control fase R" value="<?php if($_GET['id']) { if ($consulta->getNroControlR() == '0') { echo ''; } else { echo $consulta->getNroControlR(); } } else { if ($equipo->getNroControlR() == '0') { echo ''; } else { echo $equipo->getNroControlR(); } }?>" >
                <div class="help-block with-errors"></div>
            </div> 
          </div>
          <div class="col-md-4">
            <div class="form-group">
                <label for="nro_control_s">N&uacute;mero de Control fase S</label>
                <input type="number" class="form-control" id="nro_control_s" name="nro_control_s" placeholder="N&uacute;mero de Control fase S" value="<?php if($_GET['id']) { if ($consulta->getNroControlS() == '0') { echo ''; } else { echo $consulta->getNroControlS(); } } else { if ($equipo->getNroControlS() == '0') { echo ''; } else { echo $equipo->getNroControlS(); } }?>" >
                <div class="help-block with-errors"></div>
            </div> 
          </div>
          <div class="col-md-4">
            <div class="form-group">
                <label for="nro_control_t">N&uacute;mero de Control fase T</label>
                <input type="number" class="form-control" id="nro_control_t" name="nro_control_t" placeholder="N&uacute;mero de Control fase T" value="<?php if($_GET['id']) { if ($consulta->getNroControlT() == '0') { echo ''; } else { echo $consulta->getNroControlT(); } } else { if ($equipo->getNroControlT() == '0') { echo ''; } else { echo $equipo->getNroControlT(); } }?>" >
                <div class="help-block with-errors"></div>
            </div>
          </div>
    </div>

<hr>

      <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label for="tipo_t">Tipo de TI</label>
                <select class="form-control" id="tipo_t" name="id_ti" <?php if ($_GET['novedad'] || $motivo == '0') {} else { echo 'required'; } ?>>
                    <option value="">Seleccione una opci&oacute;n</option>
                    <?php
                    foreach ($arrayTi as $ti) {
                        echo '<option value="'. $ti->getId() .'" ';

if($_GET['id']) { if($consulta->getIdTi() == $ti->getId()) { if($ti->getId() == 1) {} else {  echo "selected "; } } } else { if($equipo->getIdTi() == $ti->getId()) { if($ti->getId() == 1) {} else { echo "selected "; } } }

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
                <label for="relacion_t">Relaci&oacute;n de TI</label>
<select class="form-control" id="relacion_t" name="relacion_ti" <?php if ($_GET['novedad'] || $motivo == '0') {} else { echo 'required'; } ?>>
  <option selected value="" >Seleccione una opci&oacute;n</option>
  <option value="-" <?php if($_GET['id']) { if(strtolower($consulta->getRelacionTi()) == '-') { echo 'selected'; } } else { if(strtolower($equipo->getRelacionTi()) == '-') { echo 'selected'; } }?> >-</option> 
  <option value="1/1" <?php if($_GET['id']) { if(strtolower($consulta->getRelacionTi()) == '1/1') { echo 'selected'; } } else { if(strtolower($equipo->getRelacionTi()) == '1/1') { echo 'selected'; } }?> >1/1</option> 
  <option value="15/5" <?php if($_GET['id']) { if(strtolower($consulta->getRelacionTi()) == '15/5') { echo 'selected'; } } else { if(strtolower($equipo->getRelacionTi()) == '15/5') { echo 'selected'; } }?> >15/5</option>
  <option value="25/5" <?php if($_GET['id']) { if(strtolower($consulta->getRelacionTi()) == '25/5') { echo 'selected'; } } else { if(strtolower($equipo->getRelacionTi()) == '25/5') { echo 'selected'; } }?> >25/5</option>
  <option value="30/5" <?php if($_GET['id']) { if(strtolower($consulta->getRelacionTi()) == '30/5') { echo 'selected'; } } else { if(strtolower($equipo->getRelacionTi()) == '30/5') { echo 'selected'; } }?> >30/5</option>
  <option value="50/5" <?php if($_GET['id']) { if(strtolower($consulta->getRelacionTi()) == '50/5') { echo 'selected'; } } else { if(strtolower($equipo->getRelacionTi()) == '50/5') { echo 'selected'; } }?> >50/5</option>
  <option value="100/5" <?php if($_GET['id']) { if(strtolower($consulta->getRelacionTi()) == '100/5') { echo 'selected'; } } else { if(strtolower($equipo->getRelacionTi()) == '100/5') { echo 'selected'; } }?> >100/5</option>
  <option value="150/5" <?php if($_GET['id']) { if(strtolower($consulta->getRelacionTi()) == '150/5') { echo 'selected'; } } else { if(strtolower($equipo->getRelacionTi()) == '150/5') { echo 'selected'; } }?> >150/5</option>
  <option value="200/5" <?php if($_GET['id']) { if(strtolower($consulta->getRelacionTi()) == '200/5') { echo 'selected'; } } else { if(strtolower($equipo->getRelacionTi()) == '200/5') { echo 'selected'; } }?> >200/5</option>
  <option value="250/5" <?php if($_GET['id']) { if(strtolower($consulta->getRelacionTi()) == '250/5') { echo 'selected'; } } else { if(strtolower($equipo->getRelacionTi()) == '250/5') { echo 'selected'; } }?> >250/5</option>
  <option value="300/5" <?php if($_GET['id']) { if(strtolower($consulta->getRelacionTi()) == '300/5') { echo 'selected'; } } else { if(strtolower($equipo->getRelacionTi()) == '300/5') { echo 'selected'; } }?> >300/5</option>
  <option value="350/5" <?php if($_GET['id']) { if(strtolower($consulta->getRelacionTi()) == '350/5') { echo 'selected'; } } else { if(strtolower($equipo->getRelacionTi()) == '350/5') { echo 'selected'; } }?> >350/5</option>
  <option value="400/5" <?php if($_GET['id']) { if(strtolower($consulta->getRelacionTi()) == '400/5') { echo 'selected'; } } else { if(strtolower($equipo->getRelacionTi()) == '400/5') { echo 'selected'; } }?> >400/5</option>
  <option value="500/5" <?php if($_GET['id']) { if(strtolower($consulta->getRelacionTi()) == '500/5') { echo 'selected'; } } else { if(strtolower($equipo->getRelacionTi()) == '500/5') { echo 'selected'; } }?> >500/5</option>
  <option value="600/5" <?php if($_GET['id']) { if(strtolower($consulta->getRelacionTi()) == '600/5') { echo 'selected'; } } else { if(strtolower($equipo->getRelacionTi()) == '600/5') { echo 'selected'; } }?> >600/5</option>
  <option value="700/5" <?php if($_GET['id']) { if(strtolower($consulta->getRelacionTi()) == '700/5') { echo 'selected'; } } else { if(strtolower($equipo->getRelacionTi()) == '700/5') { echo 'selected'; } }?> >700/5</option>
  <option value="800/5" <?php if($_GET['id']) { if(strtolower($consulta->getRelacionTi()) == '800/5') { echo 'selected'; } } else { if(strtolower($equipo->getRelacionTi()) == '700/5') { echo 'selected'; } }?> >800/5</option>
  <option value="1000/5" <?php if($_GET['id']) { if(strtolower($consulta->getRelacionTi()) == '1000/5') { echo 'selected'; } } else { if(strtolower($equipo->getRelacionTi()) == '1000/5') { echo 'selected'; } }?> >1000/5</option>
  <option value="1500/5" <?php if($_GET['id']) { if(strtolower($consulta->getRelacionTi()) == '1500/5') { echo 'selected'; } } else { if(strtolower($equipo->getRelacionTi()) == '1500/5') { echo 'selected'; } }?> >1500/5</option>
</select> 
                <div class="help-block with-errors"></div>
               </div>
            </div>
      </div>

    <div class="row">
          <div class="col-md-4">
            <div class="form-group">
                <label for="nro_ti_r">N&uacute;mero de TI fase R</label>
                <input type="number" class="form-control" id="nro_ti_r" name="nro_ti_r" placeholder="N&uacute;mero de TI fase R" value="<?php if($_GET['id']) { if ($consulta->getNroTiR() == '0') { echo ''; } else { echo $consulta->getNroTiR(); } } else { if ($equipo->getNroTiR() == '0') { echo ''; } else { echo $equipo->getNroTiR(); } }?>" >
                <div class="help-block with-errors"></div>
            </div> 
          </div>
          <div class="col-md-4">
            <div class="form-group">
                <label for="nro_ti_s">N&uacute;mero de TI fase S</label>
                <input type="number" class="form-control" id="nro_ti_s" name="nro_ti_s" placeholder="N&uacute;mero de TI fase S" value="<?php if($_GET['id']) { if ($consulta->getNroTiS() == '0') { echo ''; } else { echo $consulta->getNroTiS(); } } else { if ($equipo->getNroTiS() == '0') { echo ''; } else { echo $equipo->getNroTiS(); } }?>" >
                <div class="help-block with-errors"></div>
            </div> 
          </div>
          <div class="col-md-4">
            <div class="form-group">
                <label for="nro_ti_t">N&uacute;mero de TI fase T</label>
                <input type="number" class="form-control" id="nro_ti_t" name="nro_ti_t" placeholder="N&uacute;mero de TI fase T" value="<?php if($_GET['id']) { if ($consulta->getNroTiT() == '0') { echo ''; } else { echo $consulta->getNroTiT(); } } else { if ($equipo->getNroTiT() == '0') { echo ''; } else { echo $equipo->getNroTiT(); } }?>" >
                <div class="help-block with-errors"></div>
                  </div> 
              </div> 
      </div>

</div> 

<hr>

            <div class="form-group">
                <label for="observacion">Observaci&oacute;n</label>
                <input type="text" class="form-control" id="observacion" name="observacion" placeholder="Observaci&oacute;n" value="<?php if ($equipo->getObservacion() == '0') { echo ''; } else { echo ucfirst($equipo->getObservacion()); }?>">
            </div>

            <div class="col-auto">
                <label for="telemedicion">
                <input type="checkbox" id="telemedicion" name="telemedicion" <?php if($_GET['id']) { if($consulta->getTelemedicion() == 1) { echo 'checked'; } } else { if($equipo->getTelemedicion() == 1) { echo 'checked'; } }?>> Telemedici&oacute;n
                </label>
                <p class="help-block">(Seleccione esta opci&oacute;n si el equipo es telemedido)</p>
                <div class="help-block with-errors"></div>
            </div>

            <div class="col-auto">
                <label for="retirado">
                <input type="checkbox" id="retirado" name="retirado" <?php if($_GET['id']) { if($consulta->getRetirado() == 1) { echo 'checked'; } } else { if($equipo->getRetirado() == 1) { echo 'checked'; } }?>> Equipo Retirado
                </label>
                <p class="help-block">(Seleccione esta opci&oacute;n si el equipo fue retirado)</p>
                <div class="help-block with-errors"></div>
            </div>
          
<hr>

            <div class="form-group">
                <div class="col-auto">
                  <label for="curva">
                  <input type="checkbox" id="curva" name="curva" <?php if($consulta->getCurva() == 1) { echo 'checked'; } ?>> Curva
                  </label>
                  <p class="help-block">(Seleccione esta opci&oacute;n si se tom&oacute; una curva al medidor)</p>
                  <div class="help-block with-errors"></div> 
                </div>
            </div>

        <div class="form-group">
          <div class="col-auto">
              <label for="leido4">
              <input type="checkbox" id="leido4" name="leido4" <?php if($consulta->getLeido4() == 1) { echo 'checked'; } ?> > Reseteo de Medidor
              </label>
              <p class="help-block">(Seleccione esta opci&oacute;n si se resete&oacute; el medidor)</p>
              <div class="help-block with-errors"></div> 
          </div>
        </div>

<div class="panel panel-default" id="div-lectura4" <?php if ($_GET['id']) { if ( $visual4 == ('on' || 1) ) {  } else { ?> style="display:none" <?php } } else { ?> style="display:none" <?php }  ?>>
        <div class="panel-heading">
            <h3 class="panel-title">Datos de Lectura de Medidor Reseteado</h3>
        </div>
  <div class="panel-body">

    <div class="row">
          <div class="col-md-3">
                     <div class="form-group" >
                        <label for="cuatroww">4</label>
                        <input type="number" step="0.001" class="form-control" id="cuatroww" name="cuatroww" placeholder="Cuatro" value="<?php if($_GET['id']) { if($visual4 == ('on' || 1)) { echo $lectura3->getCuatro(); }} ?>">
                          <div class="help-block with-errors"></div> 
                     </div>  
                     <div class="form-group" >
                        <label for="cincoww">5</label>
                        <input type="number" step="0.001" class="form-control" id="cincoww" name="cincoww" placeholder="Cinco" value="<?php if($_GET['id']) { if($visual4 == ('on' || 1)) { echo $lectura3->getCinco(); }} ?>">
                          <div class="help-block with-errors"></div> 
                     </div>   
              </div>
          <div class="col-md-3">
                     <div class="form-group" >
                        <label for="seisww">6</label>
                        <input type="number" step="0.001" class="form-control" id="seisww" name="seisww" placeholder="Seis" value="<?php if($_GET['id']) { if ($visual4 == ('on' || 1)) { echo $lectura3->getSeis(); } }?>">
                          <div class="help-block with-errors"></div> 
                     </div>
                     <div class="form-group" >
                        <label for="nueveww">9</label>
                        <input type="number" step="0.001" class="form-control" id="nueveww" name="nueveww" placeholder="Nueve" value="<?php if($_GET['id']) { if ($visual4 == ('on' || 1)) { echo $lectura3->getNueve(); }}?>">
                          <div class="help-block with-errors"></div> 
                     </div>
            </div>     
          <div class="col-md-3">
                     <div class="form-group" >
                        <label for="diesww">10</label>
                        <input type="number" step="0.001" class="form-control" id="diesww" name="diesww" placeholder="Diez" value="<?php if($_GET['id']) { if ($visual4 == ('on' || 1)) { echo $lectura3->getDies(); } }?>">
                          <div class="help-block with-errors"></div> 
                     </div>
                     <div class="form-group" >
                        <label for="treceww">13</label>
                        <input type="number" step="0.001" class="form-control" id="treceww" name="treceww" placeholder="Trece" value="<?php if($_GET['id']) { if ($visual4 == ('on' || 1)) { echo $lectura3->getTrece(); } }?>">
                          <div class="help-block with-errors"></div> 
                     </div>    
            </div>
          <div class="col-md-3">
                     <div class="form-group" >
                        <label for="catorceww">14</label>
                        <input type="number" step="0.001" class="form-control" id="catorceww" name="catorceww" placeholder="Catorce" value="<?php if($_GET['id']) { if ($visual4 == ('on' || 1)) { echo $lectura3->getCatorce(); } }?>">
                          <div class="help-block with-errors"></div> 
                      </div>  
                     <div class="form-group" >
                        <label for="dieciseisww">16</label>
                        <input type="number" step="0.001" class="form-control" id="dieciseisww" name="dieciseisww" placeholder="Dieciseis" value="<?php if($_GET['id']) { if ($visual4 == ('on' || 1)) { echo $lectura3->getDieciseis(); } }?>">
                          <div class="help-block with-errors"></div> 
                     </div>
            </div>         
    </div>
  
<hr>

    <div class="row">
          <div class="col-md-3">
                     <div class="form-group" >
                        <label for="treintaycuatroww">34</label>
                        <input type="number" step="0.001" class="form-control" id="treintaycuatroww" name="treintaycuatroww" placeholder="Treinta y cuatro" value="<?php if($_GET['id']) { if ($visual4 == ('on' || 1)) { echo $lectura3->getTreintaycuatro(); } }?>">
                          <div class="help-block with-errors"></div> 
                      </div>  
                     <div class="form-group" >
                        <label for="treintaycincoww">35</label>
                        <input type="number" step="0.001" class="form-control" id="treintaycincoww" name="treintaycincoww" placeholder="Treinta y cinco" value="<?php if($_GET['id']) { if ($visual4 == ('on' || 1)) { echo $lectura3->getTreintaycinco(); } }?>">
                          <div class="help-block with-errors"></div> 
                      </div>    
                     <div class="form-group" >
                        <label for="treintayseisww">36</label>
                        <input type="number" step="0.001" class="form-control" id="treintayseisww" name="treintayseisww" placeholder="Treinta y seis" value="<?php if($_GET['id']) { if ($visual4 == ('on' || 1)) { echo $lectura3->getTreintayseis(); } }?>">
                          <div class="help-block with-errors"></div> 
                     </div> 
          </div>
          <div class="col-md-3">
                     <div class="form-group" >
                        <label for="treintaysieteww">37</label>
                        <input type="number" step="0.001" class="form-control" id="treintaysieteww" name="treintaysieteww" placeholder="Treinta y siete" value="<?php if($_GET['id']) { if ($visual4 == ('on' || 1)) { echo $lectura3->getTreintaysiete(); } }?>">
                          <div class="help-block with-errors"></div> 
                      </div>  
                     <div class="form-group" >
                        <label for="treintaynueveww">39</label>
                        <input type="number" step="0.001" class="form-control" id="treintaynueveww" name="treintaynueveww" placeholder="Treinta y nueve" value="<?php if($_GET['id']) { if ($visual4 == ('on' || 1)) { echo $lectura3->getTreintaynueve(); } }?>">
                          <div class="help-block with-errors"></div> 
                      </div>    
                     <div class="form-group" >
                        <label for="cuarentaww">40</label>
                        <input type="number" step="0.001" class="form-control" id="cuarentaww" name="cuarentaww" placeholder="Cuarenta" value="<?php if($_GET['id']) { if ($visual4 == ('on' || 1)) { echo $lectura3->getCuarenta(); } }?>">
                          <div class="help-block with-errors"></div> 
                     </div> 
          </div>     
          <div class="col-md-3">
                     <div class="form-group" >
                        <label for="cuarentayunoww">41</label>
                        <input type="number" step="0.001" class="form-control" id="cuarentayunoww" name="cuarentayunoww" placeholder="Cuarenta y uno" value="<?php if($_GET['id']) { if ($visual4 == ('on' || 1)) { echo $lectura3->getCuarentayuno(); } }?>">
                          <div class="help-block with-errors"></div> 
                      </div>  
                     <div class="form-group" >
                        <label for="cuarentaytresww">43</label>
                        <input type="number" step="0.001" class="form-control" id="cuarentaytresww" name="cuarentaytresww" placeholder="Cuarenta y tres" value="<?php if($_GET['id']) { if ($visual4 == ('on' || 1)) { echo $lectura3->getCuarentaytres(); } }?>">
                          <div class="help-block with-errors"></div> 
                     </div>   
                     <div class="form-group" >
                        <label for="cuarentaycuatroww">44</label>
                        <input type="number" step="0.001" class="form-control" id="cuarentaycuatroww" name="cuarentaycuatroww" placeholder="Cuarenta y cuatro" value="<?php if($_GET['id']) { if ($visual4 == ('on' || 1)) { echo $lectura3->getCuarentaycuatro(); } }?>">
                          <div class="help-block with-errors"></div> 
                     </div>   
          </div>
          <div class="col-md-3">
                     <div class="form-group" >
                        <label for="cuarentaycincoww">45</label>
                        <input type="number" step="0.001" class="form-control" id="cuarentaycincoww" name="cuarentaycincoww" placeholder="Cuarenta y cinco" value="<?php if($_GET['id']) { if ($visual4 == ('on' || 1)) { echo $lectura3->getCuarentaycinco(); } }?>">
                          <div class="help-block with-errors"></div> 
                      </div>  
                     <div class="form-group" >
                        <label for="cuarentayseisww">46</label>
                        <input type="number" step="0.001" class="form-control" id="cuarentayseisww" name="cuarentayseisww" placeholder="Cuarenta y seis" value="<?php if($_GET['id']) { if ($visual4 == ('on' || 1)) { echo $lectura3->getCuarentayseis(); } }?>">
                          <div class="help-block with-errors"></div> 
                     </div>     
          </div> 
    </div>

<hr>
    <div class="row">
          <div class="col-md-3">
                     <div class="form-group" >
                        <label for="erreww">R</label>
                        <input type="number" step="0.0" class="form-control" id="erreww" name="erreww" placeholder="R" value="<?php if($_GET['id']) { if ($visual4 == ('on' || 1)) { echo $lectura3->getErre(); } }?>">
                          <div class="help-block with-errors"></div> 
                     </div>   
          </div>
          <div class="col-md-3">
                    <div class="form-group" >
                        <label for="eseww">S</label>
                        <input type="number" step="0.0" class="form-control" id="eseww" name="eseww" placeholder="S" value="<?php if($_GET['id']) { if ($visual4 == ('on' || 1)) { echo $lectura3->getEse(); } }?>">
                          <div class="help-block with-errors"></div> 
                     </div>
          </div>     
          <div class="col-md-3">
                     <div class="form-group" >
                        <label for="teww">T</label>
                        <input type="number" step="0.0" class="form-control" id="teww" name="teww" placeholder="T" value="<?php if($_GET['id']) { if ($visual4 == ('on' || 1)) { echo $lectura3->getTe(); } }?>">
                          <div class="help-block with-errors"></div> 
                     </div> 
          </div>
          <div class="col-md-3">
                     <div class="form-group" >
                        <label for="diecinueveww">19</label>
                        <input type="number" step="0.0" class="form-control" id="diecinueveww" name="diecinueveww" placeholder="Diecinueve" value="<?php if($_GET['id']) { if ($visual4 == ('on' || 1)) { echo $lectura3->getDiecinueve(); } }?>">
                          <div class="help-block with-errors"></div> 
                        </div>
            </div>         
    </div>

            </div>
            </div>

<div class="alert alert-info" role="alert" id="info" name="info" <?php if($consulta->getLeido4() == 0) { ?> style="display: none;" <?php } ?> >
  La siguiente Lectura Visual que puede cargar es de <b>antes del reseteo del medidor</b>
</div>


            <div class="form-group">
                <div class="col-auto">
                <label for="leido">
                <input type="checkbox" id="leido" name="leido" <?php if($consulta->getLeido() == 1) { echo 'checked'; } ?>> Lectura Visual</label>
                <p class="help-block">(Seleccione esta opci&oacute;n para cargar la lectura visual)</p>
                <div class="help-block with-errors"></div> 
                </div>
            </div>

<div class="panel panel-info" id="div-lectura" <?php if ($_GET['id']) { if ( $visual == ('on' || 1) ) {  } else { ?> style="display:none" <?php } } else { ?> style="display:none" <?php }  ?>>
      <div class="panel-heading">
            <h3 class="panel-title">Datos de Lectura de Medidor</h3>
      </div>
  <div class="panel-body">

    <div class="row">
          <div class="col-md-3">
                     <div class="form-group" >
                        <label for="cuatro">4</label>
                        <input type="number" step="0.001" class="form-control" id="cuatro" name="cuatro" placeholder="Cuatro" value="<?php if($_GET['id']) { if($visual == ('on' || 1)) { echo $lectura->getCuatro(); }} ?>">
                          <div class="help-block with-errors"></div> 
                     </div>  
                     <div class="form-group" >
                        <label for="cinco">5</label>
                        <input type="number" step="0.001" class="form-control" id="cinco" name="cinco" placeholder="Cinco" value="<?php if($_GET['id']) { if($visual == ('on' || 1)) { echo $lectura->getCinco(); }} ?>">
                          <div class="help-block with-errors"></div> 
                     </div>   
          </div>
          <div class="col-md-3">
                     <div class="form-group" >
                        <label for="seis">6</label>
                        <input type="number" step="0.001" class="form-control" id="seis" name="seis" placeholder="Seis" value="<?php if($_GET['id']) { if ($visual == ('on' || 1)) { echo $lectura->getSeis(); } }?>">
                          <div class="help-block with-errors"></div> 
                     </div>
                     <div class="form-group" >
                        <label for="nueve">9</label>
                        <input type="number" step="0.001" class="form-control" id="nueve" name="nueve" placeholder="Nueve" value="<?php if($_GET['id']) { if ($visual == ('on' || 1)) { echo $lectura->getNueve(); }}?>">
                          <div class="help-block with-errors"></div> 
                     </div>
          </div>     
          <div class="col-md-3">
                     <div class="form-group" >
                        <label for="dies">10</label>
                        <input type="number" step="0.001" class="form-control" id="dies" name="dies" placeholder="Diez" value="<?php if($_GET['id']) { if ($visual == ('on' || 1)) { echo $lectura->getDies(); } }?>">
                          <div class="help-block with-errors"></div> 
                     </div>
                     <div class="form-group" >
                        <label for="trece">13</label>
                        <input type="number" step="0.001" class="form-control" id="trece" name="trece" placeholder="Trece" value="<?php if($_GET['id']) { if ($visual == ('on' || 1)) { echo $lectura->getTrece(); } }?>">
                          <div class="help-block with-errors"></div> 
                     </div>    
          </div>
          <div class="col-md-3">
                     <div class="form-group" >
                        <label for="catorce">14</label>
                        <input type="number" step="0.001" class="form-control" id="catorce" name="catorce" placeholder="Catorce" value="<?php if($_GET['id']) { if ($visual == ('on' || 1)) { echo $lectura->getCatorce(); } }?>">
                          <div class="help-block with-errors"></div> 
                      </div>  
                     <div class="form-group" >
                        <label for="dieciseis">16</label>
                        <input type="number" step="0.001" class="form-control" id="dieciseis" name="dieciseis" placeholder="Dieciseis" value="<?php if($_GET['id']) { if ($visual == ('on' || 1)) { echo $lectura->getDieciseis(); } }?>">
                          <div class="help-block with-errors"></div> 
                     </div>
          </div>         
    </div>
  
<hr>

    <div class="row">
          <div class="col-md-3">
                     <div class="form-group" >
                        <label for="treintaycuatro">34</label>
                        <input type="number" step="0.001" class="form-control" id="treintaycuatro" name="treintaycuatro" placeholder="Treinta y cuatro" value="<?php if($_GET['id']) { if ($visual == ('on' || 1)) { echo $lectura->getTreintaycuatro(); } }?>">
                          <div class="help-block with-errors"></div> 
                      </div>  
                     <div class="form-group" >
                        <label for="treintaycinco">35</label>
                        <input type="number" step="0.001" class="form-control" id="treintaycinco" name="treintaycinco" placeholder="Treinta y cinco" value="<?php if($_GET['id']) { if ($visual == ('on' || 1)) { echo $lectura->getTreintaycinco(); } }?>">
                          <div class="help-block with-errors"></div> 
                      </div>    
                     <div class="form-group" >
                        <label for="treintayseis">36</label>
                        <input type="number" step="0.001" class="form-control" id="treintayseis" name="treintayseis" placeholder="Treinta y seis" value="<?php if($_GET['id']) { if ($visual == ('on' || 1)) { echo $lectura->getTreintayseis(); } }?>">
                          <div class="help-block with-errors"></div> 
                     </div> 
          </div>
          <div class="col-md-3">
                     <div class="form-group" >
                        <label for="treintaysiete">37</label>
                        <input type="number" step="0.001" class="form-control" id="treintaysiete" name="treintaysiete" placeholder="Treinta y siete" value="<?php if($_GET['id']) { if ($visual == ('on' || 1)) { echo $lectura->getTreintaysiete(); } }?>" >
                          <div class="help-block with-errors"></div> 
                      </div>  
                     <div class="form-group" >
                        <label for="treintaynueve">39</label>
                        <input type="number" step="0.001" class="form-control" id="treintaynueve" name="treintaynueve" placeholder="Treinta y nueve" value="<?php if($_GET['id']) { if ($visual == ('on' || 1)) { echo $lectura->getTreintaynueve(); } }?>">
                          <div class="help-block with-errors"></div> 
                      </div>    
                     <div class="form-group" >
                        <label for="cuarenta">40</label>
                        <input type="number" step="0.001" class="form-control" id="cuarenta" name="cuarenta" placeholder="Cuarenta" value="<?php if($_GET['id']) { if ($visual == ('on' || 1)) { echo $lectura->getCuarenta(); } }?>">
                          <div class="help-block with-errors"></div> 
                     </div> 
          </div>     
          <div class="col-md-3">
                     <div class="form-group" >
                        <label for="cuarentayuno">41</label>
                        <input type="number" step="0.001" class="form-control" id="cuarentayuno" name="cuarentayuno" placeholder="Cuarenta y uno" value="<?php if($_GET['id']) { if ($visual == ('on' || 1)) { echo $lectura->getCuarentayuno(); } }?>">
                          <div class="help-block with-errors"></div> 
                      </div>  
                     <div class="form-group" >
                        <label for="cuarentaytres">43</label>
                        <input type="number" step="0.001" class="form-control" id="cuarentaytres" name="cuarentaytres" placeholder="Cuarenta y tres" value="<?php if($_GET['id']) { if ($visual == ('on' || 1)) { echo $lectura->getCuarentaytres(); } }?>">
                          <div class="help-block with-errors"></div> 
                     </div>   
                     <div class="form-group" >
                        <label for="cuarentaycuatro">44</label>
                        <input type="number" step="0.001" class="form-control" id="cuarentaycuatro" name="cuarentaycuatro" placeholder="Cuarenta y cuatro" value="<?php if($_GET['id']) { if ($visual == ('on' || 1)) { echo $lectura->getCuarentaycuatro(); } }?>">
                          <div class="help-block with-errors"></div> 
                     </div>   
          </div>
          <div class="col-md-3">
                     <div class="form-group" >
                        <label for="cuarentaycinco">45</label>
                        <input type="number" step="0.001" class="form-control" id="cuarentaycinco" name="cuarentaycinco" placeholder="Cuarenta y cinco" value="<?php if($_GET['id']) { if ($visual == ('on' || 1)) { echo $lectura->getCuarentaycinco(); } }?>">
                          <div class="help-block with-errors"></div> 
                      </div>  
                     <div class="form-group" >
                        <label for="cuarentayseis">46</label>
                        <input type="number" step="0.001" class="form-control" id="cuarentayseis" name="cuarentayseis" placeholder="Cuarenta y seis" value="<?php if($_GET['id']) { if ($visual == ('on' || 1)) { echo $lectura->getCuarentayseis(); } }?>">
                          <div class="help-block with-errors"></div> 
                     </div>     
          </div> 
    </div>

<hr>
        <div class="row">
          <div class="col-md-3">
                     <div class="form-group" >
                        <label for="erre">R</label>
                        <input type="number" step="0.0" class="form-control" id="erre" name="erre" placeholder="R" value="<?php if($_GET['id']) { if ($visual == ('on' || 1)) { echo $lectura->getErre(); } }?>">
                          <div class="help-block with-errors"></div> 
                     </div>   
          </div>
          <div class="col-md-3">
                    <div class="form-group" >
                        <label for="ese">S</label>
                        <input type="number" step="0.0" class="form-control" id="ese" name="ese" placeholder="S" value="<?php if($_GET['id']) { if ($visual == ('on' || 1)) { echo $lectura->getEse(); } }?>">
                          <div class="help-block with-errors"></div> 
                     </div>
          </div>     
          <div class="col-md-3">
                     <div class="form-group" >
                        <label for="te">T</label>
                        <input type="number" step="0.0" class="form-control" id="te" name="te" placeholder="T" value="<?php if($_GET['id']) { if ($visual == ('on' || 1)) { echo $lectura->getTe(); } }?>">
                          <div class="help-block with-errors"></div> 
                     </div> 
          </div>
          <div class="col-md-3">
                     <div class="form-group" >
                        <label for="diecinueve">19</label>
                        <input type="number" step="0.0" class="form-control" id="diecinueve" name="diecinueve" placeholder="Diecinueve" value="<?php if($_GET['id']) { if ($visual == ('on' || 1)) { echo $lectura->getDiecinueve(); } }?>">
                          <div class="help-block with-errors"></div> 
                        </div>
          </div>         
    </div>

            </div>
            </div>












      <div class="col-auto" id="retiro_respaldo" <?php if($_GET['id']) { if($consulta->getRespaldo() == ('on' || 1)) {} else { ?> style="display:none" <?php } } else { if($equipo->getRespaldo() == ('on' || 1)) {} else { ?> style="display:none" <?php } } ?>>
            <label for="retiro-respaldo">
              <input type="checkbox" id="retiro_respaldo" name="retiro_respaldo" <?php if($consulta->getRetiroRespaldo() == 1) { echo 'checked'; } ?>> Retiro de Medidor de Respaldo
            </label>
            <p class="help-block">(Seleccione esta opci&oacute;n si el medidor de respaldo fue retirado)</p>
                <div class="help-block with-errors"></div>
      </div>





            <div class="form-group" id="leido-respaldo" <?php if($_GET['id']) { if($consulta->getRespaldo() == ('on' || 1)) {} else { ?> style="display:none" <?php } } else { if($equipo->getRespaldo() == ('on' || 1)) {} else { ?> style="display:none" <?php } } ?>>
                <div class="col-auto">
                <label for="leido5">
                <input type="checkbox" id="leido5" name="leido5" <?php if($consulta->getLeido5() == 1) { echo 'checked'; } ?>> Lectura Visual de Medidor de Respaldo</label>
                <p class="help-block">(Seleccione esta opci&oacute;n para cargar la lectura visual de medidor de respaldo)</p>
                <div class="help-block with-errors"></div> 
                </div>
            </div>

<div class="panel panel-info" id="div-lectura-respaldo" <?php if ($_GET['id']) { if ( $visual5 == ('on' || 1) ) {  } else { ?> style="display:none" <?php } } else { ?> style="display:none" <?php }  ?>>
      <div class="panel-heading">
            <h3 class="panel-title">Datos de Lectura de Medidor de Respaldo</h3>
      </div>
  <div class="panel-body">

    <div class="row">
          <div class="col-md-3">
                     <div class="form-group" >
                        <label for="cuatrowww">4</label>
                        <input type="number" step="0.001" class="form-control" id="cuatrowww" name="cuatrowww" placeholder="Cuatro" value="<?php if($_GET['id']) { if($visual5 == ('on' || 1)) { echo $lectura4->getCuatro(); }} ?>">
                          <div class="help-block with-errors"></div> 
                     </div>  
                     <div class="form-group" >
                        <label for="cincowww">5</label>
                        <input type="number" step="0.001" class="form-control" id="cincowww" name="cincowww" placeholder="Cinco" value="<?php if($_GET['id']) { if($visual5 == ('on' || 1)) { echo $lectura4->getCinco(); }} ?>">
                          <div class="help-block with-errors"></div> 
                     </div>   
          </div>
          <div class="col-md-3">
                     <div class="form-group" >
                        <label for="seiswww">6</label>
                        <input type="number" step="0.001" class="form-control" id="seiswww" name="seiswww" placeholder="Seis" value="<?php if($_GET['id']) { if ($visual5 == ('on' || 1)) { echo $lectura4->getSeis(); } }?>">
                          <div class="help-block with-errors"></div> 
                     </div>
                     <div class="form-group" >
                        <label for="nuevewww">9</label>
                        <input type="number" step="0.001" class="form-control" id="nuevewww" name="nuevewww" placeholder="Nueve" value="<?php if($_GET['id']) { if ($visual5 == ('on' || 1)) { echo $lectura4->getNueve(); }}?>">
                          <div class="help-block with-errors"></div> 
                     </div>
          </div>     
          <div class="col-md-3">
                     <div class="form-group" >
                        <label for="dieswww">10</label>
                        <input type="number" step="0.001" class="form-control" id="dieswww" name="dieswww" placeholder="Diez" value="<?php if($_GET['id']) { if ($visual5 == ('on' || 1)) { echo $lectura4->getDies(); } }?>">
                          <div class="help-block with-errors"></div> 
                     </div>
                     <div class="form-group" >
                        <label for="trecewww">13</label>
                        <input type="number" step="0.001" class="form-control" id="trecewww" name="trecewww" placeholder="Trece" value="<?php if($_GET['id']) { if ($visual5 == ('on' || 1)) { echo $lectura4->getTrece(); } }?>">
                          <div class="help-block with-errors"></div> 
                     </div>    
          </div>
          <div class="col-md-3">
                     <div class="form-group" >
                        <label for="catorcewww">14</label>
                        <input type="number" step="0.001" class="form-control" id="catorcewww" name="catorcewww" placeholder="Catorce" value="<?php if($_GET['id']) { if ($visual5 == ('on' || 1)) { echo $lectura4->getCatorce(); } }?>">
                          <div class="help-block with-errors"></div> 
                      </div>  
                     <div class="form-group" >
                        <label for="dieciseiswww">16</label>
                        <input type="number" step="0.001" class="form-control" id="dieciseiswww" name="dieciseiswww" placeholder="Dieciseis" value="<?php if($_GET['id']) { if ($visual5 == ('on' || 1)) { echo $lectura4->getDieciseis(); } }?>">
                          <div class="help-block with-errors"></div> 
                     </div>
          </div>         
    </div>
  
<hr>

    <div class="row">
          <div class="col-md-3">
                     <div class="form-group" >
                        <label for="treintaycuatrowww">34</label>
                        <input type="number" step="0.001" class="form-control" id="treintaycuatrowww" name="treintaycuatrowww" placeholder="Treinta y cuatro" value="<?php if($_GET['id']) { if ($visual5 == ('on' || 1)) { echo $lectura4->getTreintaycuatro(); } }?>">
                          <div class="help-block with-errors"></div> 
                      </div>  
                     <div class="form-group" >
                        <label for="treintaycincowww">35</label>
                        <input type="number" step="0.001" class="form-control" id="treintaycincowww" name="treintaycincowww" placeholder="Treinta y cinco" value="<?php if($_GET['id']) { if ($visual5 == ('on' || 1)) { echo $lectura4->getTreintaycinco(); } }?>">
                          <div class="help-block with-errors"></div> 
                      </div>    
                     <div class="form-group" >
                        <label for="treintayseiswww">36</label>
                        <input type="number" step="0.001" class="form-control" id="treintayseiswww" name="treintayseiswww" placeholder="Treinta y seis" value="<?php if($_GET['id']) { if ($visual5 == ('on' || 1)) { echo $lectura4->getTreintayseis(); } }?>">
                          <div class="help-block with-errors"></div> 
                     </div> 
          </div>
          <div class="col-md-3">
                     <div class="form-group" >
                        <label for="treintaysietewww">37</label>
                        <input type="number" step="0.001" class="form-control" id="treintaysietewww" name="treintaysietewww" placeholder="Treinta y siete" value="<?php if($_GET['id']) { if ($visual5 == ('on' || 1)) { echo $lectura4->getTreintaysiete(); } }?>" >
                          <div class="help-block with-errors"></div> 
                      </div>  
                     <div class="form-group" >
                        <label for="treintaynuevewww">39</label>
                        <input type="number" step="0.001" class="form-control" id="treintaynuevewww" name="treintaynuevewww" placeholder="Treinta y nueve" value="<?php if($_GET['id']) { if ($visual5 == ('on' || 1)) { echo $lectura4->getTreintaynueve(); } }?>">
                          <div class="help-block with-errors"></div> 
                      </div>    
                     <div class="form-group" >
                        <label for="cuarentawww">40</label>
                        <input type="number" step="0.001" class="form-control" id="cuarentawww" name="cuarentawww" placeholder="Cuarenta" value="<?php if($_GET['id']) { if ($visual5 == ('on' || 1)) { echo $lectura4->getCuarenta(); } }?>">
                          <div class="help-block with-errors"></div> 
                     </div> 
          </div>     
          <div class="col-md-3">
                     <div class="form-group" >
                        <label for="cuarentayunowww">41</label>
                        <input type="number" step="0.001" class="form-control" id="cuarentayunowww" name="cuarentayunowww" placeholder="Cuarenta y uno" value="<?php if($_GET['id']) { if ($visual5 == ('on' || 1)) { echo $lectura4->getCuarentayuno(); } }?>">
                          <div class="help-block with-errors"></div> 
                      </div>  
                     <div class="form-group" >
                        <label for="cuarentaytreswww">43</label>
                        <input type="number" step="0.001" class="form-control" id="cuarentaytreswww" name="cuarentaytreswww" placeholder="Cuarenta y tres" value="<?php if($_GET['id']) { if ($visual5 == ('on' || 1)) { echo $lectura4->getCuarentaytres(); } }?>">
                          <div class="help-block with-errors"></div> 
                     </div>   
                     <div class="form-group" >
                        <label for="cuarentaycuatrowww">44</label>
                        <input type="number" step="0.001" class="form-control" id="cuarentaycuatrowww" name="cuarentaycuatrowww" placeholder="Cuarenta y cuatro" value="<?php if($_GET['id']) { if ($visual5 == ('on' || 1)) { echo $lectura4->getCuarentaycuatro(); } }?>">
                          <div class="help-block with-errors"></div> 
                     </div>   
          </div>
          <div class="col-md-3">
                     <div class="form-group" >
                        <label for="cuarentaycincowww">45</label>
                        <input type="number" step="0.001" class="form-control" id="cuarentaycincowww" name="cuarentaycincowww" placeholder="Cuarenta y cinco" value="<?php if($_GET['id']) { if ($visual5 == ('on' || 1)) { echo $lectura4->getCuarentaycinco(); } }?>">
                          <div class="help-block with-errors"></div> 
                      </div>  
                     <div class="form-group" >
                        <label for="cuarentayseiswww">46</label>
                        <input type="number" step="0.001" class="form-control" id="cuarentayseiswww" name="cuarentayseiswww" placeholder="Cuarenta y seis" value="<?php if($_GET['id']) { if ($visual5 == ('on' || 1)) { echo $lectura4->getCuarentayseis(); } }?>">
                          <div class="help-block with-errors"></div> 
                     </div>     
          </div> 
    </div>

<hr>
        <div class="row">
          <div class="col-md-3">
                     <div class="form-group" >
                        <label for="errewww">R</label>
                        <input type="number" step="0.0" class="form-control" id="errewww" name="errewww" placeholder="R" value="<?php if($_GET['id']) { if ($visual5 == ('on' || 1)) { echo $lectura4->getErre(); } }?>">
                          <div class="help-block with-errors"></div> 
                     </div>   
          </div>
          <div class="col-md-3">
                    <div class="form-group" >
                        <label for="esewww">S</label>
                        <input type="number" step="0.0" class="form-control" id="esewww" name="esewww" placeholder="S" value="<?php if($_GET['id']) { if ($visual5 == ('on' || 1)) { echo $lectura4->getEse(); } }?>">
                          <div class="help-block with-errors"></div> 
                     </div>
          </div>     
          <div class="col-md-3">
                     <div class="form-group" >
                        <label for="tewww">T</label>
                        <input type="number" step="0.0" class="form-control" id="tewww" name="tewww" placeholder="T" value="<?php if($_GET['id']) { if ($visual5 == ('on' || 1)) { echo $lectura4->getTe(); } }?>">
                          <div class="help-block with-errors"></div> 
                     </div> 
          </div>
          <div class="col-md-3">
                     <div class="form-group" >
                        <label for="diecinuevewww">19</label>
                        <input type="number" step="0.0" class="form-control" id="diecinuevewww" name="diecinuevewww" placeholder="Diecinueve" value="<?php if($_GET['id']) { if ($visual5 == ('on' || 1)) { echo $lectura4->getDiecinueve(); } }?>">
                          <div class="help-block with-errors"></div> 
                        </div>
          </div>         
    </div>

            </div>
            </div>

















</div>
</div>

            <input type="hidden" name="problema" value="<?php if ($_GET['novedad'] || $motivo == '0'){ echo '1'; } else { echo '0'; } ?>">

            <input type="hidden" name="id" value="<?php echo $consulta->getId();?>">
            <input type="hidden" name="id_consulta" value="">
            <input type="hidden" name="retired" value="<?php echo $equipo->getRetirado();?>">
            <input type="hidden" name="id_equipo" value="<?php echo $_GET['id_equipo'];?>">
<?php 
      if ($_GET['novedad'] || $motivo == '0'){
?> 

      </div>

<?php 

      }

      if ($_GET['novedad'] || $motivo == '0' )
      {} else {
?>

<div class="panel panel-info">
      <div class="panel-heading">
            <h3 class="panel-title">Datos de Revisi&oacute;n</h3>
      </div>
  <div class="panel-body">
        <?php
        }
        ?>
            <div class="form-group">
                <label for="fecha">Fecha de <?php if ($_GET['novedad'] || $motivo == '0') { ?> Problema <?php } else { ?> Revisi&oacute;n <?php } ?></label>
                <p class="help-block">Formato dd/mm/yyyy</p>
                <input type="text" class="form-control datepicker" id="fecha" name="fecha" placeholder="dd/mm/yyyy" <?php if(!$_GET['id']) { ?> tabindex = "-1" <?php } ?> value="<?php echo $fechaConsulta;?>" pattern="^(?:(?:31(\/|-|\.)(?:0?[13578]|1[02]))\1|(?:(?:29|30)(\/|-|\.)(?:0?[1,3-9]|1[0-2])\2))(?:(?:1[6-9]|[2-9]\d)?\d{2})$|^(?:29(\/|-|\.)0?2\3(?:(?:(?:1[6-9]|[2-9]\d)?(?:0[48]|[2468][048]|[13579][26])|(?:(?:16|[2468][048]|[3579][26])00))))$|^(?:0?[1-9]|1\d|2[0-8])(\/|-|\.)(?:(?:0?[1-9])|(?:1[0-2]))\4(?:(?:1[6-9]|[2-9]\d)?\d{2})$" required>
                <div class="help-block with-errors"></div>
            </div>
          <?php
            if ($_GET['novedad'] || $motivo == '0'){
?>
                <input type="hidden" id="motivo" name="motivo" value="0" >
<?php
            } else {
          ?>
            <div class="form-group">
                <label for="motivo">Motivo de Revisi&oacute;n</label>
                    <input type="text" class="form-control" id="motivo" name="motivo" placeholder="Motivo" value="<?php echo ucfirst($consulta->getMotivo());?>" required>
                <div class="help-block with-errors"></div>
            </div>
<?php
            }        
            
            if ($_GET['novedad'] || $motivo == '0'){
?>
            <div class="form-group">
                <label for="descripcion">Descripci&oacute;n de Problema</label>
                    <input type="text" class="form-control" id="descripcion" name="descripcion" placeholder="Descripci&oacute;n" value="<?php if ($consulta->getDescripcion() == '0') { echo ''; } else { echo ucfirst($consulta->getDescripcion()); } ?>" required>
                <div class="help-block with-errors"></div>
            </div>
<?php
            } else {

?>
            <div class="form-group">
                <label for="descripcion">Descripci&oacute;n de Revisi&oacute;n</label>
                    <textarea class="form-control" rows="5" id="descripcion" required name="descripcion" placeholder="Descripci&oacute;n" ><?php if($consulta->getDescripcion() == '0') { echo ''; } else { echo ucfirst($consulta->getDescripcion()); } ?></textarea>
                <div class="help-block with-errors"></div>
            </div>


            <div class="form-group">
                <label for="precintos">Precintos</label>
                    <textarea class="form-control" rows="3" id="precintos" required name="precintos" placeholder="Precintos" ><?php if($consulta->getPrecintos() == '0') { echo ''; } else { echo ucfirst($consulta->getPrecintos()); } ?></textarea>
                <div class="help-block with-errors"></div>
            </div>


<?php
          }
            if ($_GET['novedad'] || $motivo == '0'){
?>
                <input type="hidden" id="inspector" name="inspector" value="" >
                <input type="hidden" id="ayudante" name="ayudante" value="" >
<?php
            } else {
          ?>
      <div class="row">
            <div class="col-md-6"> 
            <div class="form-group">
                <label for="inspector">Inspector</label>
                    <input type="text" class="form-control" id="inspector" name="inspector" placeholder="Inspector" value="<?php if($consulta->getInspector() == '0') { echo ''; } else { echo ucwords($consulta->getInspector()); } ?>" required>
               <div class="help-block with-errors"></div>
                </div>
            </div>
            <div class="col-md-6"> 
            <div class="form-group">
                <label for="ayudante">Ayudante</label>
                    <input type="text" class="form-control" id="ayudante" name="ayudante" placeholder="Ayudante" value="<?php if($consulta->getAyudante() == '0') { echo ''; } else { echo ucwords($consulta->getAyudante()); } ?>" required>
               <div class="help-block with-errors"></div>
            </div>
            </div>
      </div>
<?php
    }  
            if ($_GET['novedad'] || $motivo == '0'){}
            else {
?> 
<div class="row" id="div-funciona">
            <div class="col-md-12"> 
              <div class="form-group">
                <label for="funciona">Funciona Correctamente</label>
                      <select class="form-control" id="funciona" name="funciona" required>
                        <option selected value="" >Seleccione una opci&oacute;n</option>
                        <option value="0" <?php if (is_null($consulta->getId())) {} else { if($consulta->getFunciona() == 0) { echo 'selected'; } } ?> >No</option> 
                        <option value="1" <?php if($consulta->getFunciona() == 1) { echo 'selected'; } ?> >Si</option>
                      </select> 
                    <p class="help-block">(Seleccione si el equipo qued&oacute; funcionando correctamente)</p>
                <div class="help-block with-errors"></div>
               </div>
            </div>
</div>
<?php ?>

</div>
</div>

<?php 
              }
?>
            <button type="button" class="btn btn-default cancelForm">Cancelar</button>
<?php
            if ($_GET['novedad'] || $motivo == '0'){
?>
            <div class="btn-group">
              <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                <?php echo $txtAction; ?> y... <span class="caret"></span>
              </button>
              <ul class="dropdown-menu" role="menu" id="submit">
                <li><a href="?modulo=equipo&accion=buscar">Ir al buscador</a></li>
                <li><a href="?modulo=consulta&accion=listar&id_equipo=<?php echo $equipo->getId(); ?>">Volver a revisiones</a></li>
              </ul>
            </div>
            <button type="submit" class="btn btn-primary hidden" id="submit-button"></button>
<?php 
            } else {
?>
            <button type="submit" class="btn btn-primary"><?php echo $txtAction; ?></button>
<?php 
}
?>
      </form>
    </div>