<?php 
      require_once('negocio/consultaNegocio.php');
      $consultaNegocio = new ConsultaNegocio();

   //   $equipoNegocio = new EquipoNegocio();

      require_once('negocio/medidorNegocio.php');
      $medidorNegocio = new MedidorNegocio();

      require_once('pdf/fpdf/fpdf.php');
      ob_end_clean(); //    the buffer and never prints or returns anything.
      ob_start();

      class PDF extends FPDF
      {
          function Header()
          {

            $this->SetFont('Helvetica', '', 16);
            $this->Cell(30);
            $this->Cell(215, 10, 'Reporte de Equipos con Problemas', 0, 0, 'C');

            $this->Line(10, 20, 285, 20);

            $this->Ln(15);
          }
      
          function Footer()
          {
            $this->SetY(-15);
            $this->SetFont('Helvetica', 'I', 8);
            $this->Cell(0, 10, utf8_decode('Página ').$this->PageNo().' / {nb}', 0, 0, 'C');
          }

      }

        $cant = 0;
        $arrayEquipos = $equipoNegocio->listarTodosOrd(); 
        $pdf = new PDF('L', 'mm', 'A4');
        $pdf->SetTitle('Equipos con Problemas');       
        $pdf->AliasNbPages();
        $pdf->AddPage();
      if( count($arrayEquipos) > 0 ){
        foreach( $arrayEquipos as $equipo ){

        $consulta = $consultaNegocio->listarOrdenadoUna($equipo->getId());

                if ($consulta == true){

                    if ($consulta->getFunciona() == 0)
                    { $cant++;

  $medidor = $medidorNegocio->recuperar($equipo->getIdMedidor());

  $pdf->SetX(10);
  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(85, 6, 'Usuario', 1, 0, 'C', 0);
  $pdf->Cell(13, 6, 'Folio', 1, 0, 'C', 0);
  $pdf->Cell(130, 6, utf8_decode("Dirección"), 1, 0, 'C', 0);
  $pdf->Cell(50, 6, 'Medidor', 1, 1, 'C', 0);


  $pdf->SetX(10);
  $pdf->SetFont('Helvetica', 'B', 9);
  $usu = ucwords($equipo->getUsuario());
  $pdf->Cell(85, 5, utf8_decode($usu), 1, 0, 'L', 0);

  $pdf->SetFont('Helvetica', '', 9);
  if($equipo->getFolio() == 0) { $folio = '-'; } else { $folio = $equipo->getFolio(); }        
  $pdf->Cell(13, 5, $folio, 1, 0, 'L', 0);

  if ($equipo->getLatitud() == 0 || $equipo->getLongitud() == 0) { $coord = ''; } else { $coord = ' (' . $equipo->getLatitud() . ', ' . $equipo->getLongitud() . ')'; }
  $direccion2 = ucwords($equipo->getDireccion()) . $coord . ' - ' . ucwords($equipo->getLocalidad());
  $pdf->Cell(130, 5, utf8_decode($direccion2), 1, 0, 'L', 0);


  $med = strtoupper($medidor->getTipo()) . ' Nro: ' . $equipo->getNroMedidor();
  if ($medidor->getId() == 1 && $equipo->getNroMedidor() == 0) { $med = '-'; }
  $pdf->Cell(50, 5, utf8_decode($med), 1, 1, 'L', 0);


  $pdf->Cell(20, 2, '', 0, 1, '', 0);

  $pdf->SetX(45);
  $pdf->SetFont('Helvetica', '', 9);
  $pdf->Cell(20, 5, 'Fecha', 1, 0, 'C', 0);
  $pdf->Cell(145, 5, 'Motivo', 1, 0, 'C', 0);
  $pdf->Cell(40, 5, utf8_decode("Tipo"), 1, 1, 'C', 0);
  


      $arrayConsultas = $consultaNegocio->listarRep($equipo->getId()); 
      foreach ($arrayConsultas as $consulta) {
                                       
  $pdf->SetX(45);
  $fecha = Util::dbToDate($consulta->getFecha());
  $pdf->SetFont('Helvetica', '', 9);
  $pdf->Cell(20, 5, $fecha, 1, 0, 'L', 0);
  
  if ( $consulta->getMotivo() == '0') { if ($consulta->getDescripcion() == '0') { $motivo = ''; } else { $motivo = ucfirst($consulta->getDescripcion()); } } else { if ($consulta->getMotivo() == '0') { $motivo = ''; } else { $motivo = ucfirst($consulta->getMotivo()); } }
    $pdf->Cell(145, 5, utf8_decode($motivo), 1, 0, 'L', 0);
 
    if ($consulta->getFunciona() == 0 && $consulta->getMotivo() == '0') { $tipo = 'Reclamo / Problema'; } else { 
        if ($consulta->getFunciona() == 0) { $tipo = 'Revisión sin arreglar'; } else { $tipo = 'Revisión ok'; }
      }
    $pdf->Cell(40, 5, utf8_decode($tipo), 1, 1, 'L', 0);             


                              }
    $pdf->Cell(20, 5, '', 0, 1, '', 0);
                
                  } //del foreach

            } 
          }

      if ($cant == 0) {

  $pdf->SetX(20);
  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(250, 6, 'No hay resultados', 0, 1, 'C', 0);
  }
} else {
  $pdf->SetX(20);
  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(250, 6, 'No hay equipos cargados en el sistema', 0, 1, 'C', 0);  
}

  $pdf->Output();
  ob_end_flush(); // It's printed here, because ob_end_flush "prints" what's in

?>