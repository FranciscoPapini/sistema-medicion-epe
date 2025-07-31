<?php
if($_GET['col']){
      require_once('negocio/equipoNegocio.php');
      $equipoNegocio = new EquipoNegocio();
      require_once('negocio/lecturaNegocio.php');
      $lecturaNegocio = new LecturaNegocio();

      require_once('negocio/controlNegocio.php');
      $controlNegocio = new ControlNegocio();
      $arrayControles = $controlNegocio->listar();

      require_once('negocio/transformadorTensionNegocio.php');
      $transformadorTensionNegocio = new TransformadorTensionNegocio();
      $arrayTv = $transformadorTensionNegocio->listar();

      require_once('negocio/transformadorCorrienteNegocio.php');
      $transformadorCorrienteNegocio = new TransformadorCorrienteNegocio();
      $arrayTi = $transformadorCorrienteNegocio->listar();

      require_once('negocio/medidorNegocio.php');
      $medidorNegocio = new MedidorNegocio();
      $arrayMedidores = $medidorNegocio->listar();
       

      $equipo = new Equipo();
      $fechaAlta = date('d/m/Y');

      $consulta = new Consulta();
      $fechaConsulta = date('d/m/Y');  

?>
    <div class="container" id="non-printable">
      <div class="page-header" id="non-printable">
        <h1>Colocaci&oacute;n de Equipo de Medici&oacute;n</h1>
      </div>
        <?php echo Util::getMsj(); ?>
        <form role="form" method="post" id="principal">

            <input type="hidden" name="id_equipo" value="" >
            <input type="hidden" name="id_administrador" value="<?php echo $_SESSION['administrador']['id'];?>">

<div class="panel panel-info">
  <div class="panel-heading">
    <h3 class="panel-title">Datos de Equipo</h3>
  </div>
  <div class="panel-body">

    <div class="row">
            <div class="col-md-12"> 
                <div class="form-group">
                <label for="usuario">Usuario</label>
                <input type="text" class="form-control" id="usuario" name="usuario" placeholder="Usuario" autofocus value="" required >
                <div class="help-block with-errors"></div>
                </div>
            </div>
    </div>

  <input type="hidden" class="form-control datepicker" id="alta" name="alta" placeholder="dd/mm/yyyy" value="<?php echo $fechaAlta;?>" pattern="^(?:(?:31(\/|-|\.)(?:0?[13578]|1[02]))\1|(?:(?:29|30)(\/|-|\.)(?:0?[1,3-9]|1[0-2])\2))(?:(?:1[6-9]|[2-9]\d)?\d{2})$|^(?:29(\/|-|\.)0?2\3(?:(?:(?:1[6-9]|[2-9]\d)?(?:0[48]|[2468][048]|[13579][26])|(?:(?:16|[2468][048]|[3579][26])00))))$|^(?:0?[1-9]|1\d|2[0-8])(\/|-|\.)(?:(?:0?[1-9])|(?:1[0-2]))\4(?:(?:1[6-9]|[2-9]\d)?\d{2})$" required>
 

<div class="row">
            <div class="col-md-6"> 
                <div class="form-group">
                <label for="ruta">Ruta</label>
                <input type="number" class="form-control" id="ruta" name="ruta" placeholder="Ruta" value="" required >
                <div class="help-block with-errors"></div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                <label for="folio">Folio</label>
                <input type="number" class="form-control" id="folio" name="folio" placeholder="Folio" value="" required >
                <div class="help-block with-errors"></div>
                </div> 
            </div>
</div>


<div class="row">
            <div class="col-md-6"> 
              <div class="form-group">
                <label for="direccion">Direcci&oacute;n</label>
                <input type="text" class="form-control" id="direccion" name="direccion" placeholder="Direcci&oacute;n" value="" required>
                <div class="help-block with-errors"></div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="localidad">Localidad</label>
                <input type="text" class="form-control" id="localidad" name="localidad" placeholder="Localidad" value="" required>
                <div class="help-block with-errors"></div>
              </div> 
            </div>
</div>


<div class="row">
            <div class="col-md-6"> 
                <div class="form-group">
                <label for="latitud">Latitud</label> 
                <p class="help-block" style="display: inline;">(Formato -dd.dddddd)</p>
                <input type="number" step="0.000001" class="form-control" id="latitud" name="latitud" placeholder="-dd.dddd" value="" >
                <div class="help-block with-errors"></div>
                </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="longitud">Longitud</label>
                <p class="help-block" style="display: inline;">(Formato -dd.dddddd)</p>
                <input type="number" step="0.000001" class="form-control" id="longitud" name="longitud" placeholder="-dd.dddd" value="" >
                <div class="help-block with-errors"></div>
                </div>
            </div>
</div>

<hr>

<div class="row">
          <div class="col-md-6">
            <div class="form-group">
                <label for="id_medidor">Tipo de Medidor</label>
                <select class="form-control" id="id_medidor" name="id_medidor" required>
                    <option value="">Seleccione una opci&oacute;n</option>
                    <?php
                    foreach ($arrayMedidores as $medidor) {
                        echo '<option value="'. $medidor->getId() .'" ';
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
                <input type="number" class="form-control" id="nro_medidor"  name="nro_medidor" placeholder="N&uacute;mero de Medidor" value="" required>
                <div class="help-block with-errors"></div>
            </div> 
          </div>
</div>




<div class="row">
            <div class="col-md-6"> 
              <div class="form-group">
                <label for="potencia">Potencia</label>
                <div class="input-group">
                <input type="number" class="form-control" id="potencia" name="potencia" placeholder="Potencia" value="" >
                <div class="input-group-addon">KW</div>
                </div>    
              </div>
            </div>
</div>


<div id="directo2">
    <div class="row">
            <div class="col-md-6"> 
              <div class="form-group">
                <div class="col-auto">
                  <label for="media_tension">
                  <input type="checkbox" id="media_tension" name="media_tension"> Media Tensi&oacute;n
                  </label>
                  <p class="help-block">(Seleccione esta opci&oacute;n si el equipo es de media tensi&oacute;n)</p>
                </div>
              </div>
            </div>
  
    </div> 

<div id="div-relacion-tv3" style="display:none">
      <div class="row">
          <div class="col-md-4">
            <div class="form-group">
                <label for="id_tv">Tipo de TV</label>
                <select class="form-control" id="id_tv" name="id_tv">
                    <option value="">Seleccione una opci&oacute;n</option>
                    <?php
                    foreach ($arrayTv as $tv) {
                        echo '<option value="'. $tv->getId() .'" ';
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
              <select class="form-control" id="cabina" name="cabina">
                <option selected value="" >Seleccione una opci&oacute;n</option>
                <option value="1">No Especificado</option> 
                <option value="13200">13200 V</option>
                <option value="33000">33000 V</option>
                <option value="132000">132000 V</option>
              </select>
            <div class="help-block with-errors"></div>
            </div>
          </div>
</div>

      <div class="row">
          <div class="col-md-4">
            <div class="form-group">
                <label for="nro_tv_r">N&uacute;mero de TV fase R</label>
                <input type="number" class="form-control" id="nro_tv_r" name="nro_tv_r" placeholder="N&uacute;mero de TV fase R" value="">
                <div class="help-block with-errors"></div>
            </div> 
          </div>
          <div class="col-md-4">
            <div class="form-group">
                <label for="nro_tv_s">N&uacute;mero de TV fase S</label>
                <input type="number" class="form-control" id="nro_tv_s" name="nro_tv_s" placeholder="N&uacute;mero de TV fase S" value="">
                <div class="help-block with-errors"></div>
            </div> 
          </div>
          <div class="col-md-4">
            <div class="form-group">
                <label for="nro_tv_t">N&uacute;mero de TV fase T</label>
                <input type="number" class="form-control" id="nro_tv_t" name="nro_tv_t" placeholder="N&uacute;mero de TV fase T" value="">
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
                <select class="form-control" id="tipo_controle" name="id_control" required>
                    <option value="">Seleccione una opci&oacute;n</option>
                    <?php
                    foreach ($arrayControles as $control) {
                        echo '<option value="'. $control->getId() .'" ';
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
                <input type="number" class="form-control" id="nro_control_r" name="nro_control_r" placeholder="N&uacute;mero de Control fase R" value="" >
                <div class="help-block with-errors"></div>
            </div> 
          </div>
          <div class="col-md-4">
            <div class="form-group">
                <label for="nro_control_s">N&uacute;mero de Control fase S</label>
                <input type="number" class="form-control" id="nro_control_s" name="nro_control_s" placeholder="N&uacute;mero de Control fase S" value="" >
                <div class="help-block with-errors"></div>
            </div> 
          </div>
          <div class="col-md-4">
            <div class="form-group">
                <label for="nro_control_t">N&uacute;mero de Control fase T</label>
                <input type="number" class="form-control" id="nro_control_t" name="nro_control_t" placeholder="N&uacute;mero de Control fase T" value="" >
                <div class="help-block with-errors"></div>
            </div>
          </div>
      </div>

<hr>

<div class="row">
      <div class="col-md-4">
            <div class="form-group">
                <label for="tipo_t">Tipo de TI</label>
                <select class="form-control" id="tipo_t" name="id_ti" required>
                    <option value="">Seleccione una opci&oacute;n</option>
                    <?php
                    foreach ($arrayTi as $ti) {
                        echo '<option value="'. $ti->getId() .'" ';
                        if($ti->getId() == 1) {
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
                  <select class="form-control" id="relacion_t" name="relacion_ti" required>
                    <option selected value="" >Seleccione una opci&oacute;n</option>
                    <option value="-">-</option> 
                    <option value="1/1" >1/1</option> 
                    <option value="15/5" >15/5</option>
                    <option value="25/5" >25/5</option>
                    <option value="30/5" >30/5</option>
                    <option value="50/5" >50/5</option>
                    <option value="100/5" >100/5</option>
                    <option value="150/5" >150/5</option>
                    <option value="200/5" >200/5</option>
                    <option value="250/5" >250/5</option>
                    <option value="300/5" >300/5</option>
                    <option value="350/5" >350/5</option>
                    <option value="400/5" >400/5</option>
                    <option value="500/5" >500/5</option>
                    <option value="600/5" >600/5</option>
                    <option value="700/5" >700/5</option>
                    <option value="800/5" >800/5</option>
					<option value="1000/5" >1000/5</option>
                    <option value="1500/5" >1500/5</option>
                  </select> 
                <div class="help-block with-errors"></div>
               </div>
            </div>
      </div>

      <div class="row">
          <div class="col-md-4">
            <div class="form-group">
                <label for="nro_ti_r">N&uacute;mero de TI fase R</label>
                <input type="number" class="form-control" id="nro_ti_r" name="nro_ti_r" placeholder="N&uacute;mero de TI fase R" value="" >
                <div class="help-block with-errors"></div>
            </div> 
          </div>
          <div class="col-md-4">
            <div class="form-group">
                <label for="nro_ti_s">N&uacute;mero de TI fase S</label>
                <input type="number" class="form-control" id="nro_ti_s" name="nro_ti_s" placeholder="N&uacute;mero de TI fase S" value="" >
                <div class="help-block with-errors"></div>
            </div> 
          </div>
          <div class="col-md-4">
            <div class="form-group">
                <label for="nro_ti_t">N&uacute;mero de TI fase T</label>
                <input type="number" class="form-control" id="nro_ti_t" name="nro_ti_t" placeholder="N&uacute;mero de TI fase T" value="" >
                <div class="help-block with-errors"></div>
            </div> 
          </div> 
      </div>

  </div>

<hr>

            <div class="form-group">
                <label for="observacion">Observaci&oacute;n</label>
                <input type="text" class="form-control" id="observacion" name="observacion" placeholder="Observaci&oacute;n" value="">
                <div class="help-block with-errors"></div>
            </div>
          <div class="col-auto">
                <label for="telemedicion">
                  <input type="checkbox" id="telemedicion" name="telemedicion" > Telemedici&oacute;n
                </label>
                <p class="help-block">(Seleccione esta opci&oacute;n si el equipo es telemedido)</p>
                <div class="help-block with-errors"></div>
          </div>
  <input type="hidden" id="retirado" name="retirado" > 
  
<hr>

          <div class="form-group">
              <div class="col-auto">
                    <label for="curva">
                    <input type="checkbox" id="curva" name="curva" > Curva
                    </label>
                    <p class="help-block">(Seleccione esta opci&oacute;n si se tom&oacute; una curva)</p>
                    <div class="help-block with-errors"></div> 
              </div>
          </div>



           <div class="form-group">
                <div class="col-auto">
                  <label for="leido">
                  <input type="checkbox" id="leido" name="leido" > Lectura Visual
                  </label>
                  <p class="help-block">(Seleccione esta opci&oacute;n para cargar la lectura visual)</p>
                <div class="help-block with-errors"></div> 
                </div>
            </div>




<div class="panel panel-info" id="div-lectura" style="display:none" >
  <div class="panel-heading">
    <h3 class="panel-title">Datos de Lectura</h3>
  </div>
  <div class="panel-body">

        <div class="row">
          <div class="col-md-3">
                     <div class="form-group" >
                        <label for="cuatro">4</label>
                        <input type="number" step="0.001" class="form-control" id="cuatro" name="cuatro" placeholder="Cuatro" value="">
                        <div class="help-block with-errors"></div> 
                     </div>  
                     <div class="form-group" >
                        <label for="cinco">5</label>
                        <input type="number" step="0.001" class="form-control" id="cinco" name="cinco" placeholder="Cinco" value="">
                        <div class="help-block with-errors"></div> 
                     </div>   
              </div>
          <div class="col-md-3">
                     <div class="form-group" >
                        <label for="seis">6</label>
                        <input type="number" step="0.001" class="form-control" id="seis" name="seis" placeholder="Seis" value="">
                        <div class="help-block with-errors"></div> 
                     </div>
                     <div class="form-group" >
                        <label for="nueve">9</label>
                        <input type="number" step="0.001" class="form-control" id="nueve" name="nueve" placeholder="Nueve" value="">
                        <div class="help-block with-errors"></div> 
                     </div>
              </div>     
          <div class="col-md-3">
                     <div class="form-group" >
                        <label for="dies">10</label>
                        <input type="number" step="0.001" class="form-control" id="dies" name="dies" placeholder="Diez" value="">
                        <div class="help-block with-errors"></div> 
                     </div>
                     <div class="form-group" >
                        <label for="trece">13</label>
                        <input type="number" step="0.001" class="form-control" id="trece" name="trece" placeholder="Trece" value="">
                        <div class="help-block with-errors"></div> 
                     </div>    
        </div>
          <div class="col-md-3">
                     <div class="form-group" >
                        <label for="catorce">14</label>
                        <input type="number" step="0.001" class="form-control" id="catorce" name="catorce" placeholder="Catorce" value="">
                        <div class="help-block with-errors"></div> 
                      </div>  
                     <div class="form-group" >
                        <label for="dieciseis">16</label>
                        <input type="number" step="0.001" class="form-control" id="dieciseis" name="dieciseis" placeholder="Dieciseis" value="">
                        <div class="help-block with-errors"></div> 
                     </div>
        </div>         
      </div>
  
<hr>

        <div class="row">
          <div class="col-md-3">
                     <div class="form-group" >
                        <label for="treintaycuatro">34</label>
                        <input type="number" step="0.001" class="form-control" id="treintaycuatro" name="treintaycuatro" placeholder="Treinta y cuatro" value="">
                        <div class="help-block with-errors"></div> 
                      </div>  
                     <div class="form-group" >
                        <label for="treintaycinco">35</label>
                        <input type="number" step="0.001" class="form-control" id="treintaycinco" name="treintaycinco" placeholder="Treinta y cinco" value="">
                        <div class="help-block with-errors"></div> 
                      </div>    
                     <div class="form-group" >
                        <label for="treintayseis">36</label>
                        <input type="number" step="0.001" class="form-control" id="treintayseis" name="treintayseis" placeholder="Treinta y seis" value="">
                        <div class="help-block with-errors"></div> 
                     </div> 
              </div>
          <div class="col-md-3">
                     <div class="form-group" >
                        <label for="treintaysiete">37</label>
                        <input type="number" step="0.001" class="form-control" id="treintaysiete" name="treintaysiete" placeholder="Treinta y siete" value="">
                        <div class="help-block with-errors"></div> 
                      </div>  
                     <div class="form-group" >
                        <label for="treintaynueve">39</label>
                        <input type="number" step="0.001" class="form-control" id="treintaynueve" name="treintaynueve" placeholder="Treinta y nueve" value="">
                        <div class="help-block with-errors"></div> 
                      </div>    
                     <div class="form-group" >
                        <label for="cuarenta">40</label>
                        <input type="number" step="0.001" class="form-control" id="cuarenta" name="cuarenta" placeholder="Cuarenta" value="">
                        <div class="help-block with-errors"></div> 
                     </div> 
              </div>     
          <div class="col-md-3">
                     <div class="form-group" >
                        <label for="cuarentayuno">41</label>
                        <input type="number" step="0.001" class="form-control" id="cuarentayuno" name="cuarentayuno" placeholder="Cuarenta y uno" value="">
                        <div class="help-block with-errors"></div> 
                      </div>  
                     <div class="form-group" >
                        <label for="cuarentaytres">43</label>
                        <input type="number" step="0.001" class="form-control" id="cuarentaytres" name="cuarentaytres" placeholder="Cuarenta y tres" value="">
                        <div class="help-block with-errors"></div> 
                     </div>   
                     <div class="form-group" >
                        <label for="cuarentaycuatro">44</label>
                        <input type="number" step="0.001" class="form-control" id="cuarentaycuatro" name="cuarentaycuatro" placeholder="Cuarenta y cuatro" value="">
                        <div class="help-block with-errors"></div> 
                     </div>   
        </div>
          <div class="col-md-3">
                     <div class="form-group" >
                        <label for="cuarentaycinco">45</label>
                        <input type="number" step="0.001" class="form-control" id="cuarentaycinco" name="cuarentaycinco" placeholder="Cuarenta y cinco" value="">
                        <div class="help-block with-errors"></div> 
                      </div>  
                     <div class="form-group" >
                        <label for="cuarentayseis">46</label>
                        <input type="number" step="0.001" class="form-control" id="cuarentayseis" name="cuarentayseis" placeholder="Cuarenta y seis" value="">
                        <div class="help-block with-errors"></div> 
                     </div>     
        </div> 
      </div>

<hr>
        <div class="row">
          <div class="col-md-3">
                     <div class="form-group" >
                        <label for="erre">R</label>
                        <input type="number" step="0.0" class="form-control" id="erre" name="erre" placeholder="R" value="">
                        <div class="help-block with-errors"></div> 
                     </div>   
            </div>
          <div class="col-md-3">
                    <div class="form-group" >
                        <label for="ese">S</label>
                        <input type="number" step="0.0" class="form-control" id="ese" name="ese" placeholder="S" value="">
                        <div class="help-block with-errors"></div> 
                     </div>
            </div>     
          <div class="col-md-3">
                     <div class="form-group" >
                        <label for="te">T</label>
                        <input type="number" step="0.0" class="form-control" id="te" name="te" placeholder="T" value="">
                        <div class="help-block with-errors"></div> 
                     </div> 
            </div>
          <div class="col-md-3">
                     <div class="form-group" >
                        <label for="diecinueve">19</label>
                        <input type="number" step="0.0" class="form-control" id="diecinueve" name="diecinueve" placeholder="Diecinueve" value="">
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
    <h3 class="panel-title">Datos de Revisi&oacute;n</h3>
  </div>
  <div class="panel-body">
  
            <div class="form-group">
                <label for="fecha">Fecha de Revisi&oacute;n</label>
                <p class="help-block">Formato dd/mm/yyyy</p>
                <input type="text" class="form-control datepicker" id="fecha" name="fecha" placeholder="dd/mm/yyyy" value="<?php echo $fechaConsulta;?>" tabindex="-1" pattern="^(?:(?:31(\/|-|\.)(?:0?[13578]|1[02]))\1|(?:(?:29|30)(\/|-|\.)(?:0?[1,3-9]|1[0-2])\2))(?:(?:1[6-9]|[2-9]\d)?\d{2})$|^(?:29(\/|-|\.)0?2\3(?:(?:(?:1[6-9]|[2-9]\d)?(?:0[48]|[2468][048]|[13579][26])|(?:(?:16|[2468][048]|[3579][26])00))))$|^(?:0?[1-9]|1\d|2[0-8])(\/|-|\.)(?:(?:0?[1-9])|(?:1[0-2]))\4(?:(?:1[6-9]|[2-9]\d)?\d{2})$" required>
                <div class="help-block with-errors"></div>
            </div>
            <div class="form-group" >
                <label for="motivo">Motivo</label>
                <input type="text" class="form-control" id="motivo" name="motivo" placeholder="Motivo" value="Colocaci&oacute;n de equipo de medici&oacute;n" tabindex="-1" required>
                <div class="help-block with-errors"></div>
            </div> 
           <div class="form-group">
                <label for="descripcion">Descripci&oacute;n</label>
                <textarea class="form-control" rows="5" id="descripcion" name="descripcion" required placeholder="Descripci&oacute;n" value="" ></textarea>
                <div class="help-block with-errors"></div>
            </div>
           <div class="form-group">
                <label for="precintos">Precintos</label>
                <textarea class="form-control" rows="3" id="precintos" name="precintos" required placeholder="Precintos" value="" ></textarea>
                <div class="help-block with-errors"></div>
            </div>
          <div class="row">
              <div class="col-md-6"> 
                <div class="form-group">
                <label for="inspector">Inspector</label>
                    <input type="text" class="form-control" id="inspector" name="inspector" placeholder="Inspector" value="" required>
               <div class="help-block with-errors"></div>
                </div>
              </div>
              <div class="col-md-6"> 
                <div class="form-group">
                <label for="ayudante">Ayudante</label>
                    <input type="text" class="form-control" id="ayudante" name="ayudante" placeholder="Ayudante" value="" required>
               <div class="help-block with-errors"></div>
                </div>
              </div>
          </div>
    <div class="row">
            <div class="col-md-12"> 
              <div class="form-group" >
                <label for="funciona">Funciona Correctamente</label>
                  <select class="form-control" id="funciona" name="funciona" required>
                    <option selected value="" >Seleccione una opci&oacute;n</option>
                    <option value="0" >No</option> 
                    <option value="1" >Si</option>
                  </select> 
                    <p class="help-block">(Seleccione si el equipo qued&oacute; funcionando correctamente)</p>
                <div class="help-block with-errors"></div>
               </div>
            </div>
    </div>

</div>
</div>    

            <button type="button" class="btn btn-default cancelForm">Cancelar</button>
            <button type="submit" class="btn btn-primary"><?php echo 'Agregar'; ?></button>
        </form>
   </div>

 <?php   
} // si existe col
?>