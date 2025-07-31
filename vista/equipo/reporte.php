<?php
if($_GET['id']) {
      $equipo = $equipoNegocio->recuperar($_GET['id']);
      require_once('negocio/controlNegocio.php');
      $controlNegocio = new ControlNegocio();
      $control = $controlNegocio->recuperar($equipo->getIdControl());

      require_once('negocio/transformadorTensionNegocio.php');
      $transformadorTensionNegocio = new TransformadorTensionNegocio();
      $tv = $transformadorTensionNegocio->recuperar($equipo->getIdTv());

      require_once('negocio/transformadorCorrienteNegocio.php');
      $transformadorCorrienteNegocio = new TransformadorCorrienteNegocio();
      $ti = $transformadorCorrienteNegocio->recuperar($equipo->getIdTi());

      require_once('negocio/medidorNegocio.php');
      $medidorNegocio = new MedidorNegocio();
      $medidor = $medidorNegocio->recuperar($equipo->getIdMedidor());
      $medidor_respaldo = $medidorNegocio->recuperar($equipo->getIdMedidorRespaldo());
     
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
            $this->Cell(130, 10, 'Reporte de Equipo', 0, 0, 'C');

            $this->Line(10, 30, 200, 30);

            $this->Ln(15);

          }
      
          function Footer()
          {
            $this->SetY(-15);
            $this->SetFont('Helvetica', 'I', 8);
            $this->Cell(0, 10, utf8_decode('Página ').$this->PageNo().' / {nb}', 0, 0, 'C');
          }

      }

  $pdf = new PDF('P', 'mm', 'A4');
  $pdf->SetTitle('Reporte de Equipo');
  $pdf->AliasNbPages();
  $pdf->AddPage();
 

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
  if ($equipo->getDireccion() == '0') { $direccion2 = '-'; }
  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->Cell(120, 6, utf8_decode($direccion2), 0, 1, 'L', 0);


  $pdf->SetX(35);
  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(15, 6, utf8_decode("Coordenadas:"), 0, 0, 'R', 0);
  
  if ($equipo->getLatitud() == 0) { $coord = '-'; } else { $coord = $equipo->getLatitud() . ', ' . $equipo->getLongitud(); }  
  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->Cell(75, 6, $coord, 0, 1, 'L', 0);  

  $pdf->Cell(50, 3, '', 0, 1, '', 0);


  $pdf->SetX(35);
  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(15, 6, 'Tipo de Medidor:', 0, 0, 'R', 0);
  
  if ($medidor->getId() == 1) { $tipoMed = '-'; } else { $tipoMed = strtoupper($medidor->getTipo()) . ' - Cte. ' . $medidor->getConstante(); }
  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->Cell(75, 6, utf8_decode($tipoMed), 0, 0, 'L', 0);

  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(20, 6, 'Nro. de Medidor:', 0, 0, 'R', 0);

  if ($equipo->getNroMedidor() == 0) { $nroMed = '-'; } else { $nroMed = $equipo->getNroMedidor(); }
  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->Cell(20, 6, $nroMed, 0, 1, 'L', 0);


if($equipo->getRespaldo() == ('on' || 1)){

  $pdf->SetX(35);
  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(15, 6, 'Tipo Medidor Respaldo:', 0, 0, 'R', 0);

  if ($medidor_respaldo->getId() == 1) { $tipoMedResp = '-'; } else { $tipoMedResp = strtoupper($medidor_respaldo->getTipo()) . ' - Cte. ' . $medidor_respaldo->getConstante(); }
  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->Cell(75, 6, utf8_decode($tipoMedResp), 0, 0, 'L', 0);

  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(20, 6, 'Nro. Medidor Respaldo:', 0, 0, 'R', 0);

  if ($equipo->getNroMedidorRespaldo() == 0) { $nroMedResp = '-'; } else { $nroMedResp = $equipo->getNroMedidorRespaldo(); }
  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->Cell(20, 6, $nroMedResp, 0, 1, 'L', 0);

} else {

  $pdf->SetX(35);
  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(15, 6, 'Medidor de Respaldo:', 0, 0, 'R', 0);

  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->Cell(15, 6, 'No', 0, 1, 'L', 0);

} //si hay respaldo


  if ($equipo->getMediaTension() == 0){

  if($equipo->getRelacionTi() == '0') {
  $multiplicacion = '';
  } else {
  list($nro_max, $nro_min) = explode("/", $equipo->getRelacionTi());
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

  if($equipo->getCabina() == 1 || $equipo->getRelacionTi() == '0') { 
  $multiplicacion = '';
  } else {
  list($nro_max, $nro_min) = explode("/", $equipo->getRelacionTi());
  $multiplicacion = ($nro_max / $nro_min) * ($equipo->getCabina() / 110);

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

  $pdf->Cell(50, 3, '', 0, 1, '', 0);


  if ($equipo->getMediaTension() == 1) {


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
  
  if($equipo->getNroTvR() == 0) { $tvr = '-'; } else { $tvr = $equipo->getNroTvR(); }        
  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->Cell(75, 6, $tvr, 0, 0, 'L', 0);

  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(20, 6, 'Nro. TI fase R:', 0, 0, 'R', 0);
  
  if($equipo->getNroTiR() == 0) { $tir = '-'; } else { $tir = $equipo->getNroTiR(); }      
  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->Cell(20, 6, $tir, 0, 1, 'L', 0);


  $pdf->SetX(35);  
  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(15, 6, 'Nro. TV fase S:', 0, 0, 'R', 0);
  
  if($equipo->getNroTvS() == 0) { $tvs = '-'; } else { $tvs = $equipo->getNroTvS(); }        
  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->Cell(75, 6, $tvs, 0, 0, 'L', 0);

  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(20, 6, 'Nro. TI fase S:', 0, 0, 'R', 0);
  
  if($equipo->getNroTiS() == 0) { $tis = '-'; } else { $tis = $equipo->getNroTiS(); }    
  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->Cell(20, 6, $tis, 0, 1, 'L', 0);


  $pdf->SetX(35);
  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(15, 6, 'Nro. TV fase T:', 0, 0, 'R', 0);
  
  if($equipo->getNroTvT() == 0) { $tvt = '-'; } else { $tvt = $equipo->getNroTvT(); }        
  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->Cell(75, 6, $tvt, 0, 0, 'L', 0);

  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(20, 6, 'Nro. TI fase T:', 0, 0, 'R', 0);
  
  if($equipo->getNroTiT() == 0) { $tit = '-'; } else { $tit = $equipo->getNroTiT(); }  
  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->Cell(20, 6, $tit, 0, 1, 'L', 0);

 } else {


  $pdf->SetX(35);
  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(15, 6, 'Tipo de Controles:', 0, 0, 'R', 0);
  
  if ($control->getId() == 1) { $tipoCont = '-'; } else { $tipoCont = strtoupper($control->getTipo()) . ' - Cte. ' . $control->getConstante() . ' (X ' . $controlMultiplicacion . ')'; }
  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->Cell(75, 6, utf8_decode($tipoCont), 0, 0, 'L', 0);
  
  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(20, 6, 'Tipo de TI:', 0, 0, 'R', 0);
  
  if ($ti->getId() == 1) { $tipoTi = '-'; } else { $tipoTi = strtoupper($ti->getTipo()) . ' - ' . strtoupper($ti->getClase()) . ' - ' . strtoupper($ti->getPrestacion()); }
  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->Cell(20, 6, utf8_decode($tipoTi), 0, 1, 'L', 0);
  

  $pdf->SetX(35);  
  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(15, 6, 'Nro. Control fase R:', 0, 0, 'R', 0);
  
  if($equipo->getNroControlR() == 0) { $cr = '-'; } else { $cr = $equipo->getNroControlR(); }        
  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->Cell(75, 6, $cr, 0, 0, 'L', 0);

  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(20, 6, 'Nro. TI fase R:', 0, 0, 'R', 0);
  
  if($equipo->getNroTiR() == 0) { $tir = '-'; } else { $tir = $equipo->getNroTiR(); }      
  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->Cell(20, 6, $tir, 0, 1, 'L', 0);


  $pdf->SetX(35);  
  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(15, 6, 'Nro. Control fase S:', 0, 0, 'R', 0);
  
  if($equipo->getNroControlS() == 0) { $cs = '-'; } else { $cs = $equipo->getNroControlS(); }        
  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->Cell(75, 6, $cs, 0, 0, 'L', 0);

  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(20, 6, 'Nro. TI fase S:', 0, 0, 'R', 0);
  
  if($equipo->getNroTiS() == 0) { $tis = '-'; } else { $tis = $equipo->getNroTiS(); }    
  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->Cell(20, 6, $tis, 0, 1, 'L', 0);


  $pdf->SetX(35);
  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(15, 6, 'Nro. Control fase T:', 0, 0, 'R', 0);
  
  if($equipo->getNroControlT() == 0) { $ct = '-'; } else { $ct = $equipo->getNroControlT(); }        
  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->Cell(75, 6, $ct, 0, 0, 'L', 0);

  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(20, 6, 'Nro. TI fase T:', 0, 0, 'R', 0);
  
  if($equipo->getNroTiT() == 0) { $tit = '-'; } else { $tit = $equipo->getNroTiT(); }  
  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->Cell(20, 6, $tit, 0, 1, 'L', 0);

  } //si es media tension


  $pdf->SetX(35);
  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(15, 6, utf8_decode("Relación de TV:"), 0, 0, 'R', 0);
  
  if($equipo->getCabina() == '0') { $cabina = '380 V'; } else { if ($equipo->getCabina() == '1') { $cabina = 'No Especificado'; } else { $cabina = $equipo->getCabina() . ' V'; } }
  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->Cell(75, 6, $cabina, 0, 0, 'L', 0);

  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(20, 6, utf8_decode("Relación de TI:"), 0, 0, 'R', 0);
  if($equipo->getRelacionTi() == '0') { $relacionti = '-'; } else { if($multiplicacion == '') { $relacionti = $equipo->getRelacionTi(); } else { $relacionti = $equipo->getRelacionTi() . ' (X ' . $multiplicacion . ')'; } }
  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->Cell(20, 6, $relacionti, 0, 1, 'L', 0);


  $pdf->Cell(50, 3, '', 0, 1, '', 0);

 
  if($equipo->getMediaTension() == 1) 
  {


  $pdf->SetX(35);
  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(15, 6, 'Tipo de Controles:', 0, 0, 'R', 0);
  
  if ($control->getId() == 1) { $tipoCont = '-'; } else { $tipoCont = strtoupper($control->getTipo()) . ' - Cte. ' . $control->getConstante() . ' (X ' . $controlMultiplicacion . ')'; }
  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->Cell(75, 6, utf8_decode($tipoCont), 0, 0, 'L', 0);
  
  if ($equipo->getMediaTension() == 0) { $pot = 'BT'; } else { $pot = 'MT'; }      

  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(20, 6, 'Potencia:', 0, 0, 'R', 0);

  if($equipo->getPotencia() == 0) { $potencia = '- '; } else { $potencia = $equipo->getPotencia() . ' KW '; }  
  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->Cell(20, 6, $potencia.$pot, 0, 1, 'L', 0);
  

  $pdf->SetX(35);  
  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(15, 6, 'Nro. Control fase R:', 0, 0, 'R', 0);
  
  if($equipo->getNroControlR() == 0) { $cr = '-'; } else { $cr = $equipo->getNroControlR(); }        
  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->Cell(75, 6, $cr, 0, 0, 'L', 0);

  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(20, 6, 'Retirado:', 0, 0, 'R', 0);
  
  if($equipo->getRetirado() == 0) { $retirado = 'No'; } else { $retirado = 'Si'; }  
  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->Cell(20, 6, $retirado, 0, 1, 'L', 0);  


  $pdf->SetX(35);  
  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(15, 6, 'Nro. Control fase S:', 0, 0, 'R', 0);
  
  if($equipo->getNroControlS() == 0) { $cs = '-'; } else { $cs = $equipo->getNroControlS(); }        
  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->Cell(75, 6, $cs, 0, 0, 'L', 0);


  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(20, 6, utf8_decode("Telemedición:"), 0, 0, 'R', 0);
  
  if($equipo->getTelemedicion() == 0) { $tele = 'No'; } else { $tele = 'Si'; }  
  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->Cell(20, 6, $tele, 0, 1, 'L', 0);


  $pdf->SetX(35);
  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(15, 6, 'Nro. Control fase T:', 0, 0, 'R', 0);
  
  if($equipo->getNroControlT() == 0) { $ct = '-'; } else { $ct = $equipo->getNroControlT(); }        
  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->Cell(75, 6, $ct, 0, 1, 'L', 0);

  $pdf->Cell(50, 3, '', 0, 1, '', 0);


  $pdf->SetX(35);  
  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(15, 6, utf8_decode("Observación:"), 0, 0, 'R', 0);

  if ($equipo->getObservacion() == '0') { $obs = '-'; } else { $obs = ucfirst($equipo->getObservacion()); }
  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->MultiCell(120, 4, utf8_decode($obs), 0, 'L', 0);

  }

  if ($equipo->getMediaTension() == 0) { $pot = 'BT'; } else { $pot = 'MT'; }      
  if ($equipo->getMediaTension() == 1) 
  {

  } else {


  $pdf->SetX(35);
  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(15, 6, 'Potencia:', 0, 0, 'R', 0);

  if($equipo->getPotencia() == 0) { $potencia = '- '; } else { $potencia = $equipo->getPotencia() . ' KW '; }  
  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->Cell(75, 6, $potencia.$pot, 0, 0, 'L', 0);

  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(20, 6, 'Equipo Retirado:', 0, 0, 'R', 0);
  
  if($equipo->getRetirado() == 0) { $retirado = 'No'; } else { $retirado = 'Si'; }  
  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->Cell(20, 6, $retirado, 0, 1, 'L', 0);  


  $pdf->SetX(35);  
  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(15, 6, utf8_decode("Telemedición:"), 0, 0, 'R', 0);
  
  if($equipo->getTelemedicion() == 0) { $tele = 'No'; } else { $tele = 'Si'; }  
  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->Cell(75, 6, $tele, 0, 1, 'L', 0);


  $pdf->SetX(35);  
  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(15, 6, utf8_decode("Observación:"), 0, 0, 'R', 0);

  if ($equipo->getObservacion() == '0') { $obs = '-'; } else { $obs = ucfirst($equipo->getObservacion()); }
  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->MultiCell(120, 4, utf8_decode($obs), 0, 'L', 0);

}
  
  $pdf->Output();
  ob_end_flush(); // It's printed here, because ob_end_flush "prints" what's in


} else { ?>
        <div class="container" id="non-printable">
            <div class="alert alert-danger" role="alert"><b>Debe seleccionar un equipo</b></div>
        </div>
        <?php 
            die();  
        }
?>   