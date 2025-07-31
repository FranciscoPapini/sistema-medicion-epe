<?php
if($_GET['id']) {
      $informe = $informeNegocio->recuperar($_GET['id']);

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
            $this->Cell(130, 10, 'Reporte de Informe', 0, 0, 'C');

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
  $pdf->SetTitle('Reporte de Informe');
  $pdf->AliasNbPages();
  $pdf->AddPage();
 

  $pdf->SetX(35);
  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(20, 6, 'Fecha de Informe:', 0, 0, 'R', 0);
  
  $fecha = Util::dbToDate($informe->getFecha());
  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->Cell(20, 6, $fecha, 0, 1, 'L', 0);


  $pdf->SetX(35);
  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(20, 6, 'Usuario:', 0, 0, 'R', 0);
  
  if($informe->getUsuario() == '0') { $usu = '-'; } else { $usu = mb_strtoupper($informe->getUsuario(), 'UTF-8'); }
  $pdf->SetFont('Helvetica', 'B', 11);
  $pdf->Cell(80, 6, utf8_decode($usu), 0, 1, 'L', 0);


  $pdf->SetX(35);
  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(20, 6, utf8_decode("Dirección:"), 0, 0, 'R', 0);

  $direccion = ucwords($informe->getDireccion()) . ' - ' . ucwords($informe->getLocalidad());
  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->Cell(80, 6, utf8_decode($direccion), 0, 1, 'L', 0);


  $pdf->SetX(35);
  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(20, 6, 'Inspector:', 0, 0, 'R', 0);
  
  $inspector = ucwords($informe->getInspector());          
  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->Cell(80, 6, utf8_decode($inspector), 0, 1, 'L', 0);


  $pdf->SetX(35);
  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(20, 6, 'Ayudante:', 0, 0, 'R', 0);

  $ayudante = ucwords($informe->getAyudante());          
  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->Cell(20, 6, utf8_decode($ayudante), 0, 1, 'L', 0);




  $pdf->SetX(35);
  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(20, 6, 'Tipo de Informe:', 0, 0, 'R', 0);
  
  $tipoInforme = mb_strtoupper($informe->getTipo(), 'UTF-8');
  $pdf->SetFont('Helvetica', 'B', 11);
  $pdf->Cell(80, 6, utf8_decode($tipoInforme), 0, 1, 'L', 0);


  $pdf->SetX(35);
  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(20, 6, 'Aprobado:', 0, 0, 'R', 0);

  if ($informe->getAprobado() == 0) { $aprobado = 'No'; } else { $aprobado = 'Si'; }
  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->Cell(20, 6, $aprobado, 0, 1, 'L', 0);


  $pdf->SetX(35);  
  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(20, 6, utf8_decode("Descripción:"), 0, 0, 'R', 0);

  $descripcion = ucfirst($informe->getDescripcion());
  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->MultiCell(120, 5, utf8_decode($descripcion), 0, 'L', 0);
  

  
  $pdf->Output();
  ob_end_flush(); // It's printed here, because ob_end_flush "prints" what's in


} else { ?>
        <div class="container" id="non-printable">
            <div class="alert alert-danger" role="alert"><b>Debe seleccionar un informe</b></div>
        </div>
        <?php 
        die();  
        }
?>   