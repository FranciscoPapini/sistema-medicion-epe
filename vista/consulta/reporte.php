<?php
if($_GET['id']) {
      $consulta = $consultaNegocio->recuperar($_GET['id']);
      require_once('negocio/equipoNegocio.php');
      $equipoNegocio = new EquipoNegocio();
      $equipo = $equipoNegocio->recuperar($consulta->getIdEquipo());

      require_once('negocio/controlNegocio.php');
      $controlNegocio = new ControlNegocio();
      $control = $controlNegocio->recuperar($consulta->getIdControl());

      require_once('negocio/transformadorTensionNegocio.php');
      $transformadorTensionNegocio = new TransformadorTensionNegocio();
      $tv = $transformadorTensionNegocio->recuperar($consulta->getIdTv());

      require_once('negocio/transformadorCorrienteNegocio.php');
      $transformadorCorrienteNegocio = new TransformadorCorrienteNegocio();
      $ti = $transformadorCorrienteNegocio->recuperar($consulta->getIdTi());

      require_once('negocio/medidorNegocio.php');
      $medidorNegocio = new MedidorNegocio();
      $medidor = $medidorNegocio->recuperar($consulta->getIdMedidor());

  //    $consultaUltima = $consultaNegocio->getUna($equipo->getId());

      require_once('negocio/lecturaNegocio.php');
      
      require_once('pdf/fpdf/fpdf.php');

      ob_end_clean(); //    the buffer and never prints or returns anything.
      ob_start();

      class PDF extends FPDF
      {
          function Header()
          {

            $this->SetFont('Arial', 'UI', 8);
            $this->Cell(80, 10, utf8_decode("Laboratorio Eléctrico Rosario"), 0, 0, 'L');
            $this->Cell(110, 10, utf8_decode("Empresa Provincial de la Energía de Santa Fe"), 0, 1, 'R');

            $this->SetFont('Helvetica', '', 16);
            $this->Cell(30);
            $this->Cell(130, 10, utf8_decode("Reporte de Revisión"), 0, 0, 'C');

            $this->Line(10, 30, 200, 30);

            $this->Ln(15);

          }
      
          function Footer()
          {
            $this->SetY(-10);
            $this->SetFont('Helvetica', 'I', 8);
            $this->Cell(0, 10, utf8_decode('Página ').$this->PageNo().' / {nb}', 0, 0, 'C');
          }

      }

  $pdf = new PDF('P', 'mm', 'A4');
  $pdf->SetTitle(utf8_decode("Revisión de Equipo"));
  $pdf->AliasNbPages();
  $pdf->AddPage();

// Equipo


  $pdf->SetX(35);
  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(15, 6, 'Usuario:', 0, 0, 'R', 0);
  
  $usu = mb_strtoupper($equipo->getUsuario(), 'UTF-8');
  $pdf->SetFont('Helvetica', 'B', 11);
  $pdf->Cell(120, 6, utf8_decode($usu), 0, 1, 'L', 0);


  $pdf->SetX(35);
  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(15, 6, 'Fecha de Alta:', 0, 0, 'R', 0);
  
  $fecha = Util::dbToDate($equipo->getAlta());
  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->Cell(20, 6, $fecha, 0, 1, 'L', 0);


  $pdf->SetX(35);
  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(15, 6, 'Ruta:', 0, 0, 'R', 0);
  
  if($equipo->getRuta() == 0) { $ruta = '-'; } else { $ruta = $equipo->getRuta(); }          
  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->Cell(75, 6, $ruta, 0, 0, 'L', 0);

  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(20, 6, 'Folio:', 0, 0, 'R', 0);

  if($equipo->getFolio() == 0) { $folio = '-'; } else { $folio = $equipo->getFolio(); }        
  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->Cell(20, 6, $folio, 0, 1, 'L', 0);


  $pdf->SetX(35);
  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(15, 6, utf8_decode("Dirección:"), 0, 0, 'R', 0);

  $direccion2 = ucwords($equipo->getDireccion()) . ' - ' . ucwords($equipo->getLocalidad());
  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->Cell(120, 6, utf8_decode($direccion2), 0, 1, 'L', 0);


  $pdf->SetX(35);
  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(15, 6, utf8_decode("Coordenadas:"), 0, 0, 'R', 0);
  
  if ($equipo->getLatitud() == 0) { $coord = '-'; } else { $coord = $equipo->getLatitud() . ', ' . $equipo->getLongitud(); }  
  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->Cell(75, 6, $coord, 0, 1, 'L', 0);

//Revision

  $pdf->Cell(50, 6, '', 0, 1, '', 0);


  $pdf->SetX(35);  
  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(15, 6, utf8_decode("Fecha de Revisión:"), 0, 0, 'R', 0);
  
  $fecha = Util::dbToDate($consulta->getFecha());
  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->Cell(75, 6, $fecha, 0, 0, 'L', 0);

  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(20, 6, 'Equipo Funciona Correctamente:', 0, 0, 'R', 0);
  
  if($consulta->getFunciona() == 0) { $funciona = 'No'; } else { $funciona = 'Si'; }  
  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->Cell(20, 6, $funciona, 0, 1, 'L', 0);

  
  $pdf->SetX(35);  
  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(15, 6, "Inspector:", 0, 0, 'R', 0);
  
  if($consulta->getInspector() == '0') { $inspector = '-'; } else { $inspector = ucwords($consulta->getInspector()); }  
  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->Cell(75, 6, utf8_decode($inspector), 0, 0, 'L', 0);

  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(20, 6, "Ayudante:", 0, 0, 'R', 0);
  
  if($consulta->getAyudante() == '0') { $ayudante = '-'; } else { $ayudante = ucwords($consulta->getAyudante()); }  
  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->Cell(30, 6, utf8_decode($ayudante), 0, 1, 'L', 0);


  $pdf->SetX(35);  
  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(15, 6, "Curva:", 0, 0, 'R', 0);
  
  if($consulta->getCurva() == 0) { $curva = 'No'; } else { $curva = 'Si'; }  
  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->Cell(20, 6, $curva, 0, 1, 'L', 0);

 
  $pdf->SetX(35);  
  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(15, 6, 'Motivo:', 0, 0, 'R', 0);
  
  if($consulta->getMotivo() == '0') { $motivo = '-'; } else { $motivo = ucfirst($consulta->getMotivo()); }  
  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->MultiCell(120, 5, utf8_decode($motivo), 0, 'L', 0);


  $pdf->Cell(20, 3, '', 0, 1, 'R', 0);


  $pdf->SetX(35);  
  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(15, 6, utf8_decode("Descripción:"), 0, 0, 'R', 0);
  
  if($consulta->getDescripcion() == '0') { $desc = '-'; } else { $desc = ucfirst($consulta->getDescripcion()); }  
  $pdf->SetFont('Helvetica', '', 10);
  $pdf->MultiCell(120, 4, utf8_decode($desc), 0, 'L', 0);

  $pdf->Cell(50, 3, '', 0, 1, '', 0);

  $pdf->SetX(35);  
  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(15, 6, 'Precintos:', 0, 0, 'R', 0);
  
  if($consulta->getPrecintos() == '0') { $precintos = '-'; } else { $precintos = strtoupper($consulta->getPrecintos()); }  
  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->MultiCell(120, 6, utf8_decode($precintos), 0, 'L', 0);

  $pdf->Cell(20, 3, '', 0, 1, '', 0);


// Equipo en consulta/revision

  //$pdf->Cell(50, 6, '', 0, 1, '', 0);


  $pdf->SetX(35);
  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(15, 6, 'Tipo de Medidor:', 0, 0, 'R', 0);
  
  if($medidor->getId() == 1) { $tipoMedCons = '-'; } else { $tipoMedCons = strtoupper($medidor->getTipo()) . ' - Cte. ' . $medidor->getConstante();; } 
  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->Cell(75, 6, utf8_decode($tipoMedCons), 0, 0, 'L', 0);

  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(20, 6, 'Nro. de Medidor:', 0, 0, 'R', 0);

  $pdf->SetFont('Helvetica', 'B', 10);
  if($consulta->getNroMedidor() == 0) { $nroMedCons = '-'; } else { $nroMedCons = $consulta->getNroMedidor(); } 
  $pdf->Cell(20, 6, $nroMedCons, 0, 1, 'L', 0);


if($consulta->getRespaldo() == ('on' || 1)) {

} else {


  $pdf->SetX(35);
  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(15, 6, 'Medidor de Respaldo:', 0, 0, 'R', 0);

  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->Cell(15, 6, 'No', 0, 1, 'L', 0);

}


  if ($consulta->getMediaTension() == 0){

  if($consulta->getRelacionTi() == '0') {
  $multiplicacion = '';
  } else {
  list($nro_max, $nro_min) = explode("/", $consulta->getRelacionTi());
  $multiplicacion = ($nro_max / $nro_min);
  $decimal = $control->getDecima();
  switch ($decimal) {
    case '0':
      $division = 1;
      break;
    case '1':
      $division = 10;
      break;
    case '2':
      $division = 100;
      break;
    case '3':
      $division = 1000;
      break;          
    default:
      break;
  }
  $controlMultiplicacion = ($multiplicacion / $division);

  }

  } else {

  if($consulta->getCabina() == 1 || $consulta->getRelacionTi() == '0') { 
  $multiplicacion = '';
  } else {
  list($nro_max, $nro_min) = explode("/", $consulta->getRelacionTi());
  $multiplicacion = ($nro_max / $nro_min) * ($consulta->getCabina() / 110);
  $decimal = $control->getDecima();
  switch ($decimal) {
    case '0':
      $division = 1;
      break;
    case '1':
      $division = 10;
      break;
    case '2':
      $division = 100;
      break;
    case '3':
      $division = 1000;
      break;          
    default:
      break;
  }
  $controlMultiplicacion = ($multiplicacion / $division);

  }

  }

  if ($consulta->getMediaTension() == 1) {


  $pdf->SetX(35);
  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(15, 6, 'Tipo de TV:', 0, 0, 'R', 0);
  
  if ($tv->getId() == 1) { $tipoTv = '-'; } else { $tipoTv = strtoupper($tv->getTipo()) . ' - ' . strtoupper($tv->getClase()) . ' - ' . strtoupper($tv->getPrestacion()); }
  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->Cell(75, 6, utf8_decode($tipoTv), 0, 0, 'L', 0);
  
  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(20, 6, 'Tipo de TI:', 0, 0, 'R', 0);
  
  if ($ti->getId() == 1) { $tipoTi = '-'; } else { $tipoTi = strtoupper($ti->getTipo()) . ' - ' . strtoupper($ti->getClase()) . ' - ' . strtoupper($ti->getPrestacion()); }
  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->Cell(20, 6, utf8_decode($tipoTi), 0, 1, 'L', 0);
  

  $pdf->SetX(35);  
  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(15, 6, 'Nro. TV fase R:', 0, 0, 'R', 0);
  
  if($consulta->getNroTvR() == 0) { $tvr = '-'; } else { $tvr = $consulta->getNroTvR(); }        
  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->Cell(75, 6, $tvr, 0, 0, 'L', 0);

  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(20, 6, 'Nro. TI fase R:', 0, 0, 'R', 0);
  
  if($consulta->getNroTiR() == 0) { $tir = '-'; } else { $tir = $consulta->getNroTiR(); }      
  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->Cell(20, 6, $tir, 0, 1, 'L', 0);


  $pdf->SetX(35);  
  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(15, 6, 'Nro. TV fase S:', 0, 0, 'R', 0);
  
  if($consulta->getNroTvS() == 0) { $tvs = '-'; } else { $tvs = $consulta->getNroTvS(); }        
  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->Cell(75, 6, $tvs, 0, 0, 'L', 0);

  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(20, 6, 'Nro. TI fase S:', 0, 0, 'R', 0);
  
  if($consulta->getNroTiS() == 0) { $tis = '-'; } else { $tis = $consulta->getNroTiS(); }    
  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->Cell(20, 6, $tis, 0, 1, 'L', 0);


  $pdf->SetX(35);
  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(15, 6, 'Nro. TV fase T:', 0, 0, 'R', 0);
  
  if($consulta->getNroTvT() == 0) { $tvt = '-'; } else { $tvt = $consulta->getNroTvT(); }        
  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->Cell(75, 6, $tvt, 0, 0, 'L', 0);

  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(20, 6, 'Nro. TI fase T:', 0, 0, 'R', 0);
  
  if($consulta->getNroTiT() == 0) { $tit = '-'; } else { $tit = $consulta->getNroTiT(); }  
  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->Cell(20, 6, $tit, 0, 1, 'L', 0);

  } else { 


  $pdf->SetX(35);
  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(15, 6, 'Tipo de Controles:', 0, 0, 'R', 0);
  
  if($control->getId() == 1) { $tipoControlCons = '-'; } else { $tipoControlCons = strtoupper($control->getTipo()) . ' - Cte. ' . $control->getConstante() . ' (X ' . $controlMultiplicacion . ')'; } 
  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->Cell(75, 6, utf8_decode($tipoControlCons), 0, 0, 'L', 0);
  
  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(20, 6, 'Tipo de TI:', 0, 0, 'R', 0);
  
  if($ti->getId() == 1) { $tipoTiCons = '-'; } else { $tipoTiCons = strtoupper($ti->getTipo()) . ' - ' . strtoupper($ti->getClase()) . ' - ' . strtoupper($ti->getPrestacion()); } 
  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->Cell(20, 6, utf8_decode($tipoTiCons), 0, 1, 'L', 0);
  

  $pdf->SetX(35);  
  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(15, 6, 'Nro. Control fase R:', 0, 0, 'R', 0);
  
   if($consulta->getNroControlR() == 0) { $cr = '-'; } else { $cr = $consulta->getNroControlR(); }        
  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->Cell(75, 6, $cr, 0, 0, 'L', 0);

  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(20, 6, 'Nro. TI fase R:', 0, 0, 'R', 0);
  
  if($consulta->getNroTiR() == 0) { $tir = '-'; } else { $tir = $consulta->getNroTiR(); }      
  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->Cell(20, 6, $tir, 0, 1, 'L', 0);


  $pdf->SetX(35);  
  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(15, 6, 'Nro. Control fase S:', 0, 0, 'R', 0);
  
  if($consulta->getNroControlS() == 0) { $cs = '-'; } else { $cs = $consulta->getNroControlS(); }        
  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->Cell(75, 6, $cs, 0, 0, 'L', 0);

  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(20, 6, 'Nro. TI fase S:', 0, 0, 'R', 0);
  
  if($consulta->getNroTiS() == 0) { $tis = '-'; } else { $tis = $consulta->getNroTiS(); }    
  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->Cell(20, 6, $tis, 0, 1, 'L', 0);


  $pdf->SetX(35);
  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(15, 6, 'Nro. Control fase T:', 0, 0, 'R', 0);
  
  if($consulta->getNroControlT() == 0) { $ct = '-'; } else { $ct = $consulta->getNroControlT(); }        
  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->Cell(75, 6, $ct, 0, 0, 'L', 0);

  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(20, 6, 'Nro. TI fase T:', 0, 0, 'R', 0);
  
  if($consulta->getNroTiT() == 0) { $tit = '-'; } else { $tit = $consulta->getNroTiT(); }  
  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->Cell(20, 6, $tit, 0, 1, 'L', 0);

  } //si es media tension


  $pdf->SetX(35);
  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(15, 6, utf8_decode("Relación de TV:"), 0, 0, 'R', 0);
  
  if($consulta->getCabina() == '0') { $cabina = '380 V'; } else { if($consulta->getCabina() == '1') { $cabina = 'No Especificado'; } else { $cabina = $consulta->getCabina() . ' V'; } }
  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->Cell(75, 6, $cabina, 0, 0, 'L', 0);

  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(20, 6, utf8_decode("Relación de TI:"), 0, 0, 'R', 0);
  
  if($consulta->getRelacionTi() == '0') { $relacionti = '-'; } else { if($multiplicacion == '') { $relacionti = $consulta->getRelacionTi(); } else { $relacionti = $consulta->getRelacionTi() . ' (X ' . $multiplicacion . ')'; } }  
  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->Cell(20, 6, $relacionti, 0, 1, 'L', 0);


  $pdf->Cell(50, 3, '', 0, 1, '', 0);

 
  if($consulta->getMediaTension() == 1) 
  {


  $pdf->SetX(35);
  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(15, 6, 'Tipo de Controles:', 0, 0, 'R', 0);
  
  if($control->getId() == 1) { $tipoControlCons = '-'; } else { $tipoControlCons = strtoupper($control->getTipo()) . ' - Cte. ' . $control->getConstante() . ' (X ' . $controlMultiplicacion . ')'; } 
  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->Cell(75, 6, utf8_decode($tipoControlCons), 0, 0, 'L', 0);


  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(20, 6, 'Potencia:', 0, 0, 'R', 0);

  if ($consulta->getMediaTension() == 0) { $pot = 'BT'; } else { $pot = 'MT'; }
  
  if($consulta->getPotencia() == 0) { $potencia = '- '; } else { $potencia = $consulta->getPotencia() . ' KW '; }  
  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->Cell(20, 6, $potencia.$pot, 0, 1, 'L', 0);


  $pdf->SetX(35);  
  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(15, 6, 'Nro. Control fase R:', 0, 0, 'R', 0);
  
   if($consulta->getNroControlR() == 0) { $cr = '-'; } else { $cr = $consulta->getNroControlR(); }        
  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->Cell(75, 6, $cr, 0, 0, 'L', 0);


  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(20, 6, 'Equipo Retirado:', 0, 0, 'R', 0);
  
  if($consulta->getRetirado() == 0) { $retirado = 'No'; } else { $retirado = 'Si'; }  
  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->Cell(20, 6, $retirado, 0, 1, 'L', 0); 
 

  $pdf->SetX(35);  
  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(15, 6, 'Nro. Control fase S:', 0, 0, 'R', 0);
  
  if($consulta->getNroControlS() == 0) { $cs = '-'; } else { $cs = $consulta->getNroControlS(); }        
  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->Cell(75, 6, $cs, 0, 0, 'L', 0);


  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(20, 6, utf8_decode("Telemedición:"), 0, 0, 'R', 0);
  
  if($consulta->getTelemedicion() == 0) { $tele = 'No'; } else { $tele = 'Si'; }  
  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->Cell(20, 6, $tele, 0, 1, 'L', 0);


  $pdf->SetX(35);
  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(15, 6, 'Nro. Control fase T:', 0, 0, 'R', 0);
  
  if($consulta->getNroControlT() == 0) { $ct = '-'; } else { $ct = $consulta->getNroControlT(); }        
  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->Cell(75, 6, $ct, 0, 1, 'L', 0);

  }

  if ($consulta->getMediaTension() == 0) { $pot = 'BT'; } else { $pot = 'MT'; }      
  if ($consulta->getMediaTension() == 1) 
  {

  } else {


  $pdf->SetX(35);
  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(15, 6, 'Potencia:', 0, 0, 'R', 0);

  if($consulta->getPotencia() == 0) { $potencia = '- '; } else { $potencia = $consulta->getPotencia() . ' KW '; }  
  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->Cell(75, 6, $potencia.$pot, 0, 0, 'L', 0);

  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(20, 6, 'Equipo Retirado:', 0, 0, 'R', 0);
  
  if($consulta->getRetirado() == 0) { $retirado = 'No'; } else { $retirado = 'Si'; }  
  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->Cell(20, 6, $retirado, 0, 1, 'L', 0);  


  $pdf->SetX(35);  
  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(15, 6, utf8_decode("Telemedición:"), 0, 0, 'R', 0);
  
  if($consulta->getTelemedicion() == 0) { $tele = 'No'; } else { $tele = 'Si'; }  
  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->Cell(75, 6, $tele, 0, 1, 'L', 0);

}

// Estados del Medidor
  if($consulta->getLeido() == 1 && $consulta->getLeido4() == 1)
  {
      $pdf->AddPage();
  }

  $pdf->SetX(30);
  $pdf->SetFont('Helvetica', 'U', 14);
  $pdf->Cell(145, 10, utf8_decode("Estados"), 0, 1, 'C', 0);


  $pdf->SetX(35);  
  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(15, 6, utf8_decode("Toma de Lectura:"), 0, 0, 'R', 0);
  
  if($consulta->getLeido() == ('on' || 1) || $consulta->getLeido4() == ('on' || 1)) { $leido = 'Si'; } else { $leido = 'No'; }  
  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->Cell(75, 6, $leido, 0, 0, 'L', 0);

  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(20, 6, 'Reseteo de Medidor:', 0, 0, 'R', 0);
  
  if($consulta->getLeido4() == 0) { $reseteo = 'No'; } else { $reseteo = 'Si'; }  
  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->Cell(20, 6, $reseteo, 0, 1, 'L', 0);

  if($consulta->getLeido4() == 0) {
  $pdf->Cell(50, 6, '', 0, 1, '', 0);

}

      if($consulta->getLeido4() == ('on' || 1)) {


  $pdf->SetX(30);  
  $pdf->SetFont('Helvetica', 'U', 14);
  $pdf->Cell(150, 10, utf8_decode("Estados antes del Reseteo"), 0, 1, 'C', 0);

      }

      if($consulta->getLeido() == ('on' || 1)) {

      $lecturaNegocio = new LecturaNegocio();
      $lectura = $lecturaNegocio->recuperarUna($consulta->getId(), 0);


  $pdf->SetX(25);  
  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(20, 6, "4:", 0, 0, 'R', 0);
  
  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->Cell(20, 6, $lectura->getCuatro(), 0, 0, 'L', 0);

  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(20, 6, "6:", 0, 0, 'R', 0);
  
  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->Cell(20, 6, $lectura->getSeis(), 0, 0, 'L', 0);

  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(20, 6, "10:", 0, 0, 'R', 0);
  
  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->Cell(20, 6, $lectura->getDies(), 0, 0, 'L', 0);

  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(20, 6, "14:", 0, 0, 'R', 0);
  
  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->Cell(20, 6, $lectura->getCatorce(), 0, 1, 'L', 0);


  $pdf->SetX(25);  
  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(20, 6, "5:", 0, 0, 'R', 0);
  
  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->Cell(20, 6, $lectura->getCinco(), 0, 0, 'L', 0);

  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(20, 6, "9:", 0, 0, 'R', 0);
  
  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->Cell(20, 6, $lectura->getNueve(), 0, 0, 'L', 0);

  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(20, 6, "13:", 0, 0, 'R', 0);
  
  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->Cell(20, 6, $lectura->getTrece(), 0, 0, 'L', 0);

  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(20, 6, "16:", 0, 0, 'R', 0);
  
  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->Cell(20, 6, $lectura->getDieciseis(), 0, 1, 'L', 0);


  $pdf->Cell(50, 6, '', 0, 1, '', 0);


  $pdf->SetX(25);  
  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(20, 6, "34:", 0, 0, 'R', 0);
  
  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->Cell(20, 6, $lectura->getTreintaycuatro(), 0, 0, 'L', 0);

  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(20, 6, "37:", 0, 0, 'R', 0);
  
  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->Cell(20, 6, $lectura->getTreintaysiete(), 0, 0, 'L', 0);

  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(20, 6, "41:", 0, 0, 'R', 0);
  
  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->Cell(20, 6, $lectura->getCuarentayuno(), 0, 0, 'L', 0);

  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(20, 6, "45:", 0, 0, 'R', 0);
  
  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->Cell(20, 6, $lectura->getCuarentaycinco(), 0, 1, 'L', 0);


  $pdf->SetX(25);  
  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(20, 6, "35:", 0, 0, 'R', 0);
  
  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->Cell(20, 6, $lectura->getTreintaycinco(), 0, 0, 'L', 0);

  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(20, 6, "39:", 0, 0, 'R', 0);
  
  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->Cell(20, 6, $lectura->getTreintaynueve(), 0, 0, 'L', 0);

  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(20, 6, "43:", 0, 0, 'R', 0);
  
  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->Cell(20, 6, $lectura->getCuarentaytres(), 0, 0, 'L', 0);

  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(20, 6, "46:", 0, 0, 'R', 0);
  
  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->Cell(20, 6, $lectura->getCuarentayseis(), 0, 1, 'L', 0);


  $pdf->SetX(25);  
  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(20, 6, "36:", 0, 0, 'R', 0);
  
  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->Cell(20, 6, $lectura->getTreintayseis(), 0, 0, 'L', 0);

  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(20, 6, "40:", 0, 0, 'R', 0);
  
  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->Cell(20, 6, $lectura->getCuarenta(), 0, 0, 'L', 0);

  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(20, 6, "44:", 0, 0, 'R', 0);
  
  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->Cell(20, 6, $lectura->getCuarentaycuatro(), 0, 1, 'L', 0);


  $pdf->Cell(50, 6, '', 0, 1, '', 0);


  $pdf->SetX(25);  
  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(20, 6, "R:", 0, 0, 'R', 0);
  
  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->Cell(20, 6, $lectura->getErre(), 0, 0, 'L', 0);

  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(20, 6, "S:", 0, 0, 'R', 0);
  
  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->Cell(20, 6, $lectura->getEse(), 0, 0, 'L', 0);

  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(20, 6, "T:", 0, 0, 'R', 0);
  
  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->Cell(20, 6, $lectura->getTe(), 0, 0, 'L', 0);

  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(20, 6, "19:", 0, 0, 'R', 0);
  
  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->Cell(20, 6, $lectura->getDiecinueve(), 0, 1, 'L', 0);

}


           if($consulta->getLeido4() == ('on' || 1) && $consulta->getLeido() == 0) {

  $pdf->SetX(35);  
  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(15, 6, "Estados:", 0, 0, 'R', 0);
  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->Cell(20, 6, utf8_decode("No se tomó estado"), 0, 1, 'L', 0);

           }

            if($consulta->getLeido4() == ('on' || 1)) {


  $pdf->SetX(30);  
  $pdf->SetFont('Helvetica', 'U', 14);
  $pdf->Cell(150, 10, utf8_decode("Estados después del Reseteo"), 0, 1, 'C', 0);

            $lecturaNegocio = new LecturaNegocio();
            $lectura3 = $lecturaNegocio->recuperarUna($consulta->getId(), 2);


  $pdf->SetX(25);  
  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(20, 6, "4:", 0, 0, 'R', 0);
  
  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->Cell(20, 6, $lectura3->getCuatro(), 0, 0, 'L', 0);

  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(20, 6, "6:", 0, 0, 'R', 0);
  
  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->Cell(20, 6, $lectura3->getSeis(), 0, 0, 'L', 0);

  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(20, 6, "10:", 0, 0, 'R', 0);
  
  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->Cell(20, 6, $lectura3->getDies(), 0, 0, 'L', 0);

  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(20, 6, "14:", 0, 0, 'R', 0);
  
  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->Cell(20, 6, $lectura3->getCatorce(), 0, 1, 'L', 0);


  $pdf->SetX(25);  
  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(20, 6, "5:", 0, 0, 'R', 0);
  
  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->Cell(20, 6, $lectura3->getCinco(), 0, 0, 'L', 0);

  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(20, 6, "9:", 0, 0, 'R', 0);
  
  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->Cell(20, 6, $lectura3->getNueve(), 0, 0, 'L', 0);

  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(20, 6, "13:", 0, 0, 'R', 0);
  
  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->Cell(20, 6, $lectura3->getTrece(), 0, 0, 'L', 0);

  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(20, 6, "16:", 0, 0, 'R', 0);
  
  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->Cell(20, 6, $lectura3->getDieciseis(), 0, 1, 'L', 0);


  $pdf->Cell(50, 6, '', 0, 1, '', 0);


  $pdf->SetX(25);  
  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(20, 6, "34:", 0, 0, 'R', 0);
  
  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->Cell(20, 6, $lectura3->getTreintaycuatro(), 0, 0, 'L', 0);

  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(20, 6, "37:", 0, 0, 'R', 0);
  
  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->Cell(20, 6, $lectura3->getTreintaysiete(), 0, 0, 'L', 0);

  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(20, 6, "41:", 0, 0, 'R', 0);
  
  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->Cell(20, 6, $lectura3->getCuarentayuno(), 0, 0, 'L', 0);

  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(20, 6, "45:", 0, 0, 'R', 0);
  
  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->Cell(20, 6, $lectura3->getCuarentaycinco(), 0, 1, 'L', 0);


  $pdf->SetX(25);  
  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(20, 6, "35:", 0, 0, 'R', 0);
  
  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->Cell(20, 6, $lectura3->getTreintaycinco(), 0, 0, 'L', 0);

  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(20, 6, "39:", 0, 0, 'R', 0);
  
  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->Cell(20, 6, $lectura3->getTreintaynueve(), 0, 0, 'L', 0);

  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(20, 6, "43:", 0, 0, 'R', 0);
  
  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->Cell(20, 6, $lectura3->getCuarentaytres(), 0, 0, 'L', 0);

  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(20, 6, "46:", 0, 0, 'R', 0);
  
  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->Cell(20, 6, $lectura3->getCuarentayseis(), 0, 1, 'L', 0);


  $pdf->SetX(25);  
  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(20, 6, "36:", 0, 0, 'R', 0);
  
  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->Cell(20, 6, $lectura3->getTreintayseis(), 0, 0, 'L', 0);

  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(20, 6, "40:", 0, 0, 'R', 0);
  
  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->Cell(20, 6, $lectura3->getCuarenta(), 0, 0, 'L', 0);

  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(20, 6, "44:", 0, 0, 'R', 0);
  
  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->Cell(20, 6, $lectura3->getCuarentaycuatro(), 0, 1, 'L', 0);


  $pdf->Cell(50, 6, '', 0, 1, '', 0);


  $pdf->SetX(25);  
  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(20, 6, "R:", 0, 0, 'R', 0);
  
  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->Cell(20, 6, $lectura3->getErre(), 0, 0, 'L', 0);

  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(20, 6, "S:", 0, 0, 'R', 0);
  
  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->Cell(20, 6, $lectura3->getEse(), 0, 0, 'L', 0);

  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(20, 6, "T:", 0, 0, 'R', 0);
  
  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->Cell(20, 6, $lectura3->getTe(), 0, 0, 'L', 0);

  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(20, 6, "19:", 0, 0, 'R', 0);
  
  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->Cell(20, 6, $lectura3->getDiecinueve(), 0, 1, 'L', 0);

}

 if ($consulta->getLeido() == 1 && $consulta->getLeido4() == 1)
  {

  $pdf->Cell(50, 6, '', 0, 1, '', 0);

  } else {

        if (($consulta->getLeido4() == 1 && $consulta->getLeido2() == 1) || ($consulta->getLeido() == 1 && $consulta->getLeido2() == 1) || ($consulta->getLeido5() == 1))
        {
            $pdf->AddPage();

        } else {

          $pdf->Cell(50, 6, '', 0, 1, '', 0);

        } 
  //$pdf->Cell(10, 4, '', 0, 1, '', 0);
  }

// Retiro de Medidor en Consulta

//if ($consulta->getLeido() == 1 && $consulta->getLeido4() == 0 || $consulta->getLeido() == 0 && $consulta->getLeido4() == 1) {

  // $pdf->Cell(50, 6, '', 0, 1, '', 0);
 
//}

if($consulta->getRespaldo() == ('on' || 1))
{

  $pdf->SetX(30);
  $pdf->SetFont('Helvetica', 'U', 14);
  $pdf->Cell(150, 10, utf8_decode("Medidor de Respaldo"), 0, 1, 'C', 0);

  $medidor_respaldo = $medidorNegocio->recuperar($consulta->getIdMedidorRespaldo());

  $pdf->SetX(35);  
  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(15, 6, utf8_decode("Retiro Medidor Respaldo:"), 0, 0, 'R', 0);
  
  if($consulta->getRetiroRespaldo() == ('on' || 1)) { $retiro_respaldo = 'Si'; } else { $retiro_respaldo = 'No'; }
  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->Cell(75, 6, $retiro_respaldo, 0, 1, 'L', 0);

  $pdf->SetX(35);  
  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(15, 6, utf8_decode("Tipo Medidor Respaldo:"), 0, 0, 'R', 0);
  
  $tipo_respaldo = strtoupper($medidor_respaldo->getTipo()) . ' - Cte. ' . $medidor_respaldo->getConstante();
  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->Cell(75, 6, utf8_decode($tipo_respaldo), 0, 0, 'L', 0);

        
  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(20, 6, utf8_decode("Nro. Medidor Respaldo:"), 0, 0, 'R', 0);
  
  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->Cell(20, 6, $consulta->getNroMedidorRespaldo(), 0, 1, 'L', 0);

  $pdf->Cell(50, 6, '', 0, 1, '', 0);

  $pdf->SetX(30);
  $pdf->SetFont('Helvetica', 'U', 14);
  $pdf->Cell(150, 10, utf8_decode("Estados Medidor Respaldo"), 0, 1, 'C', 0);


  $pdf->SetX(35);  
  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(15, 6, utf8_decode("Toma de Lectura:"), 0, 0, 'R', 0);
  
  if($consulta->getLeido5() == ('on' || 1)) { $leido5 = 'Si'; } else { $leido5 = 'No'; }
  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->Cell(20, 6, $leido5, 0, 1, 'L', 0);

      if($consulta->getLeido5() == ('on' || 1)) {

      $lecturaNegocio = new LecturaNegocio();
      $lectura4 = $lecturaNegocio->recuperarUna($consulta->getId(), 3);

// Estados de Medidor Retirado

  $pdf->Cell(50, 6, '', 0, 1, '', 0);


  $pdf->SetX(25);  
  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(20, 6, "4:", 0, 0, 'R', 0);
  
  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->Cell(20, 6, $lectura4->getCuatro(), 0, 0, 'L', 0);

  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(20, 6, "6:", 0, 0, 'R', 0);
  
  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->Cell(20, 6, $lectura4->getSeis(), 0, 0, 'L', 0);

  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(20, 6, "10:", 0, 0, 'R', 0);
  
  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->Cell(20, 6, $lectura4->getDies(), 0, 0, 'L', 0);

  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(20, 6, "14:", 0, 0, 'R', 0);
  
  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->Cell(20, 6, $lectura4->getCatorce(), 0, 1, 'L', 0);


  $pdf->SetX(25);  
  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(20, 6, "5:", 0, 0, 'R', 0);
  
  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->Cell(20, 6, $lectura4->getCinco(), 0, 0, 'L', 0);

  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(20, 6, "9:", 0, 0, 'R', 0);
  
  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->Cell(20, 6, $lectura4->getNueve(), 0, 0, 'L', 0);

  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(20, 6, "13:", 0, 0, 'R', 0);
  
  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->Cell(20, 6, $lectura4->getTrece(), 0, 0, 'L', 0);

  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(20, 6, "16:", 0, 0, 'R', 0);
  
  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->Cell(20, 6, $lectura4->getDieciseis(), 0, 1, 'L', 0);


  $pdf->Cell(50, 6, '', 0, 1, '', 0);


  $pdf->SetX(25);  
  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(20, 6, "34:", 0, 0, 'R', 0);
  
  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->Cell(20, 6, $lectura4->getTreintaycuatro(), 0, 0, 'L', 0);

  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(20, 6, "37:", 0, 0, 'R', 0);
  
  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->Cell(20, 6, $lectura4->getTreintaysiete(), 0, 0, 'L', 0);

  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(20, 6, "41:", 0, 0, 'R', 0);
  
  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->Cell(20, 6, $lectura4->getCuarentayuno(), 0, 0, 'L', 0);

  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(20, 6, "45:", 0, 0, 'R', 0);
  
  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->Cell(20, 6, $lectura4->getCuarentaycinco(), 0, 1, 'L', 0);


  $pdf->SetX(25);  
  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(20, 6, "35:", 0, 0, 'R', 0);
  
  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->Cell(20, 6, $lectura4->getTreintaycinco(), 0, 0, 'L', 0);

  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(20, 6, "39:", 0, 0, 'R', 0);
  
  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->Cell(20, 6, $lectura4->getTreintaynueve(), 0, 0, 'L', 0);

  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(20, 6, "43:", 0, 0, 'R', 0);
  
  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->Cell(20, 6, $lectura4->getCuarentaytres(), 0, 0, 'L', 0);

  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(20, 6, "46:", 0, 0, 'R', 0);
  
  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->Cell(20, 6, $lectura4->getCuarentayseis(), 0, 1, 'L', 0);


  $pdf->SetX(25);  
  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(20, 6, "36:", 0, 0, 'R', 0);
  
  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->Cell(20, 6, $lectura4->getTreintayseis(), 0, 0, 'L', 0);

  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(20, 6, "40:", 0, 0, 'R', 0);
  
  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->Cell(20, 6, $lectura4->getCuarenta(), 0, 0, 'L', 0);

  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(20, 6, "44:", 0, 0, 'R', 0);
  
  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->Cell(20, 6, $lectura4->getCuarentaycuatro(), 0, 1, 'L', 0);


  $pdf->Cell(50, 6, '', 0, 1, '', 0);


  $pdf->SetX(25);  
  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(20, 6, "R:", 0, 0, 'R', 0);
  
  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->Cell(20, 6, $lectura4->getErre(), 0, 0, 'L', 0);

  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(20, 6, "S:", 0, 0, 'R', 0);
  
  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->Cell(20, 6, $lectura4->getEse(), 0, 0, 'L', 0);

  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(20, 6, "T:", 0, 0, 'R', 0);
  
  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->Cell(20, 6, $lectura4->getTe(), 0, 0, 'L', 0);

  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(20, 6, "19:", 0, 0, 'R', 0);
  
  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->Cell(20, 6, $lectura4->getDiecinueve(), 0, 1, 'L', 0);

}


}








  $pdf->SetX(30);
  $pdf->SetFont('Helvetica', 'U', 14);
  $pdf->Cell(150, 10, utf8_decode("Retiro de Medidor"), 0, 1, 'C', 0);


  $pdf->SetX(35);  
  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(15, 6, utf8_decode("Medidor Retirado:"), 0, 0, 'R', 0);
  
  if($consulta->getLeido2() == ('on' || 1)) { $leido2 = 'Si'; } else { $leido2 = 'No'; }  
  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->Cell(20, 6, $leido2, 0, 1, 'L', 0);
  
  if($consulta->getLeido2() == ('on' || 1)) {

  $medidor_ret = $medidorNegocio->recuperar($consulta->getIdMedidorRet());


  $pdf->SetX(35);  
  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(15, 6, utf8_decode("Tipo Medidor Retirado:"), 0, 0, 'R', 0);
  
  $tipo_ret = strtoupper($medidor_ret->getTipo()) . ' - Cte. ' . $medidor->getConstante();
  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->Cell(75, 6, utf8_decode($tipo_ret), 0, 0, 'L', 0);

        
  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(20, 6, utf8_decode("Nro. Medidor Retirado:"), 0, 0, 'R', 0);
  
  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->Cell(20, 6, $consulta->getNroMedidorRet(), 0, 1, 'L', 0);

}

if ($consulta->getLeido2() == ('on' || 1)) { 

  $pdf->Cell(50, 6, '', 0, 1, '', 0);


  $pdf->SetX(30);
  $pdf->SetFont('Helvetica', 'U', 14);
  $pdf->Cell(150, 10, utf8_decode("Estados de Medidor Retirado"), 0, 1, 'C', 0);


  $pdf->SetX(35);  
  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(15, 6, utf8_decode("Toma de Lectura:"), 0, 0, 'R', 0);
  
  if($consulta->getLeido3() == ('on' || 1)) { $leido3 = 'Si'; } else { $leido3 = 'No'; }
  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->Cell(20, 6, $leido3, 0, 1, 'L', 0);

      if($consulta->getLeido3() == ('on' || 1)) {

      $lecturaNegocio = new LecturaNegocio();
      $lectura2 = $lecturaNegocio->recuperarUna($consulta->getId(), 1);

// Estados de Medidor Retirado

  $pdf->Cell(50, 6, '', 0, 1, '', 0);


  $pdf->SetX(25);  
  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(20, 6, "4:", 0, 0, 'R', 0);
  
  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->Cell(20, 6, $lectura2->getCuatro(), 0, 0, 'L', 0);

  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(20, 6, "6:", 0, 0, 'R', 0);
  
  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->Cell(20, 6, $lectura2->getSeis(), 0, 0, 'L', 0);

  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(20, 6, "10:", 0, 0, 'R', 0);
  
  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->Cell(20, 6, $lectura2->getDies(), 0, 0, 'L', 0);

  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(20, 6, "14:", 0, 0, 'R', 0);
  
  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->Cell(20, 6, $lectura2->getCatorce(), 0, 1, 'L', 0);


  $pdf->SetX(25);  
  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(20, 6, "5:", 0, 0, 'R', 0);
  
  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->Cell(20, 6, $lectura2->getCinco(), 0, 0, 'L', 0);

  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(20, 6, "9:", 0, 0, 'R', 0);
  
  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->Cell(20, 6, $lectura2->getNueve(), 0, 0, 'L', 0);

  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(20, 6, "13:", 0, 0, 'R', 0);
  
  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->Cell(20, 6, $lectura2->getTrece(), 0, 0, 'L', 0);

  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(20, 6, "16:", 0, 0, 'R', 0);
  
  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->Cell(20, 6, $lectura2->getDieciseis(), 0, 1, 'L', 0);


  $pdf->Cell(50, 6, '', 0, 1, '', 0);


  $pdf->SetX(25);  
  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(20, 6, "34:", 0, 0, 'R', 0);
  
  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->Cell(20, 6, $lectura2->getTreintaycuatro(), 0, 0, 'L', 0);

  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(20, 6, "37:", 0, 0, 'R', 0);
  
  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->Cell(20, 6, $lectura2->getTreintaysiete(), 0, 0, 'L', 0);

  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(20, 6, "41:", 0, 0, 'R', 0);
  
  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->Cell(20, 6, $lectura2->getCuarentayuno(), 0, 0, 'L', 0);

  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(20, 6, "45:", 0, 0, 'R', 0);
  
  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->Cell(20, 6, $lectura2->getCuarentaycinco(), 0, 1, 'L', 0);


  $pdf->SetX(25);  
  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(20, 6, "35:", 0, 0, 'R', 0);
  
  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->Cell(20, 6, $lectura2->getTreintaycinco(), 0, 0, 'L', 0);

  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(20, 6, "39:", 0, 0, 'R', 0);
  
  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->Cell(20, 6, $lectura2->getTreintaynueve(), 0, 0, 'L', 0);

  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(20, 6, "43:", 0, 0, 'R', 0);
  
  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->Cell(20, 6, $lectura2->getCuarentaytres(), 0, 0, 'L', 0);

  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(20, 6, "46:", 0, 0, 'R', 0);
  
  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->Cell(20, 6, $lectura2->getCuarentayseis(), 0, 1, 'L', 0);


  $pdf->SetX(25);  
  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(20, 6, "36:", 0, 0, 'R', 0);
  
  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->Cell(20, 6, $lectura2->getTreintayseis(), 0, 0, 'L', 0);

  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(20, 6, "40:", 0, 0, 'R', 0);
  
  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->Cell(20, 6, $lectura2->getCuarenta(), 0, 0, 'L', 0);

  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(20, 6, "44:", 0, 0, 'R', 0);
  
  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->Cell(20, 6, $lectura2->getCuarentaycuatro(), 0, 1, 'L', 0);


  $pdf->Cell(50, 6, '', 0, 1, '', 0);


  $pdf->SetX(25);  
  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(20, 6, "R:", 0, 0, 'R', 0);
  
  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->Cell(20, 6, $lectura2->getErre(), 0, 0, 'L', 0);

  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(20, 6, "S:", 0, 0, 'R', 0);
  
  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->Cell(20, 6, $lectura2->getEse(), 0, 0, 'L', 0);

  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(20, 6, "T:", 0, 0, 'R', 0);
  
  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->Cell(20, 6, $lectura2->getTe(), 0, 0, 'L', 0);

  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(20, 6, "19:", 0, 0, 'R', 0);
  
  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->Cell(20, 6, $lectura2->getDiecinueve(), 0, 1, 'L', 0);

}

}


//  $pdf->Cell(50, 10, '', 0, 1, '', 0);

  $pdf->SetX(35);
  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(15, 10, "Revisado por:", 0, 0, 'R', 0);

  $revisado = ucwords($_SESSION['administrador']['nombre']) . ', ' . ucwords($_SESSION['administrador']['apellido']);
  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->Cell(20, 10, $revisado, 0, 1, 'L', 0);

  $pdf->Output();
  ob_end_flush(); // It's printed here, because ob_end_flush "prints" what's in

} else { ?>
        <div class="container" id="non-printable">
            <div class="alert alert-danger" role="alert"><b>Debe seleccionar una revisi&oacute;n</b></div>
        </div>
<?php 
            die();  
        }
?>