<?php
      require_once('negocio/consultaNegocio.php');
      $consultaNegocio = new ConsultaNegocio();

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
            $this->Cell(215, 10, 'Reporte de Equipos sin Visitas', 0, 0, 'C');

            $this->Line(5, 20, 285, 20);

            $this->Ln(15);

          }
      
          function Footer()
          {
            $this->SetY(-15);
            $this->SetFont('Helvetica', 'I', 8);
            $this->Cell(0, 10, utf8_decode('Página ').$this->PageNo().' / {nb}', 0, 0, 'C');
          }

      } 
  
  $pdf = new PDF('L', 'mm', 'A4');
  $pdf->SetTitle('Equipos sin Visitas'); 
  $pdf->AliasNbPages();
  $pdf->AddPage();
  
          $arrayEquipos = $equipoNegocio->listarTodosOrd();
          if( count($arrayEquipos) > 0 ){


  $pdf->SetX(3);
  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->Cell(24, 6, utf8_decode("Última Visita"), 1, 0, 'C', 0);
  $pdf->Cell(75, 6, 'Usuario', 1, 0, 'C', 0);
  $pdf->Cell(13, 6, 'Folio', 1, 0, 'C', 0);
  $pdf->Cell(130, 6, utf8_decode("Dirección"), 1, 0, 'C', 0);
  $pdf->Cell(49, 6, 'Medidor', 1, 1, 'C', 0);
  $pdf->SetFont('Helvetica', '', 9);

        $fecha = Util::dateToDb(date('d/m/Y'));

            $cant = 0;
            foreach( $arrayEquipos as $equipo ){
              $consulta = $consultaNegocio->getUna($equipo->getId());  

              $date2=date_create($consulta->getFecha());
              $date1=date_create($fecha);
              $diff=date_diff($date2,$date1);

              if( $diff->days > 280 || is_null($consulta->getId()) ){
                $cant++;

  $medidor = $medidorNegocio->recuperar($equipo->getIdMedidor());

  $pdf->SetX(3);

  if (is_null($consulta->getId())) { $fechaCons = 'No hay registro'; } else { $fechaCons = Util::dbToDate($consulta->getFecha()); }
  $pdf->Cell(24, 6, $fechaCons, 1, 0, 'L', 0);
  $usu = ucwords($equipo->getUsuario());
  $pdf->Cell(75, 6, utf8_decode($usu), 1, 0, 'L', 0);
  if ($equipo->getFolio() == 0) { $folio = '-'; } else { $folio = $equipo->getFolio(); }
  $pdf->Cell(13, 6, $folio, 1, 0, 'L', 0);


  if ($equipo->getLatitud() == 0 || $equipo->getLongitud() == 0) { $coord = ''; } else { $coord = ' (' . $equipo->getLatitud() . ', ' . $equipo->getLongitud() . ')'; }
  $direcc = ucwords($equipo->getDireccion()) . $coord . ' - ' . ucwords($equipo->getLocalidad());
  if ($equipo->getDireccion() == '0') { $direcc = '-'; }
  $pdf->Cell(130, 6, utf8_decode($direcc), 1, 0, 'L', 0);

  $med = strtoupper($medidor->getTipo()) . ' Nro: ' . $equipo->getNroMedidor();
  if ($medidor->getId() == 1 && $equipo->getNroMedidor() == 0) { $med = '-'; }
  $pdf->Cell(49, 6, utf8_decode($med), 1, 1, 'L', 0);

              } //si es null o hay diferencia 

            } //del foreach
            
              if ($cant == 0)
              {

  $pdf->SetX(20);
  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(250, 6, 'No se encontraron resultados', 0, 1, 'C', 0);

              }
          } else {
          
  $pdf->SetX(20);
  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(250, 6, 'No hay equipos cargados en el sistema', 0, 1, 'C', 0);

          }  
        
  $pdf->Output();
  ob_end_flush(); // It's printed here, because ob_end_flush "prints" what's in

?>