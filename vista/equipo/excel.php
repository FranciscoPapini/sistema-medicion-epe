<?php

    if ($_SESSION['administrador']['id'] != 1 && $_SESSION['administrador']['id'] != 2 && $_SESSION['administrador']['id'] != 3 ) {

    header('Location:?modulo=equipo&accion=buscar');

    } else {

      require_once('excel/Classes/PHPExcel.php');
      require_once('excel/Classes/PHPExcel/IOFactory.php');

      require_once('negocio/controlNegocio.php');
      require_once('negocio/transformadorTensionNegocio.php');
      require_once('negocio/transformadorCorrienteNegocio.php');
      require_once('negocio/medidorNegocio.php');

      $controlNegocio = new ControlNegocio();
      $transformadorTensionNegocio = new TransformadorTensionNegocio();
      $transformadorCorrienteNegocio = new TransformadorCorrienteNegocio();
      $medidorNegocio = new MedidorNegocio();

      $arrayEquipos = $equipoNegocio->listarTodosExcel();
      if( count($arrayEquipos) > 0 ){

      $fila = 2;

      $objPHPExcel = new PHPExcel();
      $objPHPExcel->getProperties()
      ->setCreator('Laboratorio Electrico')
      ->setTitle('Datos de Equipos')
      ->setDescription('Reporte de equipos de medicion');
      $objPHPExcel->setActiveSheetIndex(0);
      $objPHPExcel->getActiveSheet()->setTitle('Equipos');

      $estiloTituloColumnas = array(
      'font' => array(
      'name'  => 'Arial',
      'bold'  => true,
      'size' =>10,
      'color' => array(
      'rgb' => '000000'
      )
      ),
      'alignment' =>  array(
      'horizontal'=> PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
      'vertical'  => PHPExcel_Style_Alignment::VERTICAL_CENTER
      )
      );

      $estiloInformacion = new PHPExcel_Style();
      $estiloInformacion->applyFromArray( array(
      'font' => array(
      'name'  => 'Arial',
      'color' => array(
      'rgb' => '000000'
      )
      ),
      'fill' => array(
      'type'  => PHPExcel_Style_Fill::FILL_SOLID
      ),
      'borders' => array(
      'allborders' => array(
      'style' => PHPExcel_Style_Border::BORDER_THIN
      )
      ),
      'alignment' =>  array(
      'horizontal'=> PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
      'vertical'  => PHPExcel_Style_Alignment::VERTICAL_CENTER
      )
      ));

      $objPHPExcel->getActiveSheet()->getStyle('A1:AA1')->applyFromArray($estiloTituloColumnas);


      $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(40);
      $objPHPExcel->getActiveSheet()->setCellValue('A1','USUARIO');
      $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(8);
      $objPHPExcel->getActiveSheet()->setCellValue('B1','RUTA');
      $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(8);
      $objPHPExcel->getActiveSheet()->setCellValue('C1','FOLIO');
      $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(40);
      $objPHPExcel->getActiveSheet()->setCellValue('D1','DIRECCIÓN');
      $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(30);
      $objPHPExcel->getActiveSheet()->setCellValue('E1','LOCALIDAD');
      $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(25);
      $objPHPExcel->getActiveSheet()->setCellValue('F1','COORDENADAS');
      $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
      $objPHPExcel->getActiveSheet()->setCellValue('G1','TIPO MEDIDOR');
      $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(18);
      $objPHPExcel->getActiveSheet()->setCellValue('H1','NÚMERO MEDIDOR');
      $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(10);
      $objPHPExcel->getActiveSheet()->setCellValue('I1','POTENCIA');
      $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(20);
      $objPHPExcel->getActiveSheet()->setCellValue('J1','TIPO CONTROLES');
      $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(20);
      $objPHPExcel->getActiveSheet()->setCellValue('K1','NÚMERO CONTROL R');
      $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(20);
      $objPHPExcel->getActiveSheet()->setCellValue('L1','NÚMERO CONTROL S');
      $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(20);
      $objPHPExcel->getActiveSheet()->setCellValue('M1','NÚMERO CONTROL T');
      $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(15);
      $objPHPExcel->getActiveSheet()->setCellValue('N1','TIPO TI');
      $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(20);
      $objPHPExcel->getActiveSheet()->setCellValue('O1','RELACIÓN TI');
      $objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(15);
      $objPHPExcel->getActiveSheet()->setCellValue('P1','NÚMERO TI R');
      $objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(15);
      $objPHPExcel->getActiveSheet()->setCellValue('Q1','NÚMERO TI S');
      $objPHPExcel->getActiveSheet()->getColumnDimension('R')->setWidth(15);
      $objPHPExcel->getActiveSheet()->setCellValue('R1','NÚMERO TI T');
      $objPHPExcel->getActiveSheet()->getColumnDimension('S')->setWidth(21);
      $objPHPExcel->getActiveSheet()->setCellValue('S1','BAJA/MEDIA TENSIÓN');
      $objPHPExcel->getActiveSheet()->getColumnDimension('T')->setWidth(20);
      $objPHPExcel->getActiveSheet()->setCellValue('T1','TIPO TV');
      $objPHPExcel->getActiveSheet()->getColumnDimension('U')->setWidth(20);
      $objPHPExcel->getActiveSheet()->setCellValue('U1','RELACIÓN TV');
      $objPHPExcel->getActiveSheet()->getColumnDimension('V')->setWidth(15);
      $objPHPExcel->getActiveSheet()->setCellValue('V1','NÚMERO TV R');
      $objPHPExcel->getActiveSheet()->getColumnDimension('W')->setWidth(15);
      $objPHPExcel->getActiveSheet()->setCellValue('W1','NÚMERO TV S');
      $objPHPExcel->getActiveSheet()->getColumnDimension('X')->setWidth(15);
      $objPHPExcel->getActiveSheet()->setCellValue('X1','NÚMERO TV T');
      $objPHPExcel->getActiveSheet()->getColumnDimension('Y')->setWidth(35);
      $objPHPExcel->getActiveSheet()->setCellValue('Y1','OBSERVACIÓN');
      $objPHPExcel->getActiveSheet()->getColumnDimension('Z')->setWidth(20);
      $objPHPExcel->getActiveSheet()->setCellValue('Z1','TELEMEDICIÓN');
      $objPHPExcel->getActiveSheet()->getColumnDimension('AA')->setWidth(15);
      $objPHPExcel->getActiveSheet()->setCellValue('AA1','RETIRADO');


            foreach( $arrayEquipos as $equipo ){
            $medidor = $medidorNegocio->recuperar($equipo->getIdMedidor());
            $control = $controlNegocio->recuperar($equipo->getIdControl());
            $tv = $transformadorTensionNegocio->recuperar($equipo->getIdTv());
            $ti = $transformadorCorrienteNegocio->recuperar($equipo->getIdTi());


      $objPHPExcel->getActiveSheet()->setCellValue('A'.$fila,mb_strtoupper($equipo->getUsuario(), 'UTF-8'));
      $objPHPExcel->getActiveSheet()->setCellValue('B'.$fila,$equipo->getRuta());
      $objPHPExcel->getActiveSheet()->setCellValue('C'.$fila,$equipo->getFolio());
      $objPHPExcel->getActiveSheet()->setCellValue('D'.$fila,ucwords($equipo->getDireccion()));
      $objPHPExcel->getActiveSheet()->setCellValue('E'.$fila,ucwords($equipo->getLocalidad()));

      if($equipo->getLatitud() == '0' && $equipo->getLongitud() == '0') { $coord = '-'; } else { $coord = $equipo->getLatitud() . ', ' .$equipo->getLongitud(); }
      $objPHPExcel->getActiveSheet()->setCellValue('F'.$fila,$coord);

      if($medidor->getId() == 1) { $med = '-'; } else { $med = strtoupper($medidor->getTipo()); }  
      $objPHPExcel->getActiveSheet()->setCellValue('G'.$fila,$med);

      if($equipo->getNroMedidor() == '0') { $nroMed = '-'; } else { $nroMed = $equipo->getNroMedidor(); }
      $objPHPExcel->getActiveSheet()->setCellValue('H'.$fila,$nroMed);

      if($equipo->getPotencia() == '0') { $potencia = '-'; } else { $potencia = $equipo->getPotencia(); }
      $objPHPExcel->getActiveSheet()->setCellValue('I'.$fila,$potencia);

      if($control->getId() == 1) { $tipoCont = '-'; } else { $tipoCont = strtoupper($control->getTipo()); }
      $objPHPExcel->getActiveSheet()->setCellValue('J'.$fila,$tipoCont);


      $objPHPExcel->getActiveSheet()->setCellValue('K'.$fila,$equipo->getNroControlR());
      $objPHPExcel->getActiveSheet()->setCellValue('L'.$fila,$equipo->getNroControlS());
      $objPHPExcel->getActiveSheet()->setCellValue('M'.$fila,$equipo->getNroControlT());

      if($ti->getId() == 1) { $tipoTi = '-'; } else { $tipoTi = strtoupper($ti->getTipo()); }
      $objPHPExcel->getActiveSheet()->setCellValue('N'.$fila,$tipoTi);

      if($equipo->getRelacionTi() == '0') { $relacionTi = '-'; } else { $relacionTi = $equipo->getRelacionTi(); }
      $objPHPExcel->getActiveSheet()->setCellValue('O'.$fila,$relacionTi);

      $objPHPExcel->getActiveSheet()->setCellValue('P'.$fila,$equipo->getNroTiR());
      $objPHPExcel->getActiveSheet()->setCellValue('Q'.$fila,$equipo->getNroTiS());
      $objPHPExcel->getActiveSheet()->setCellValue('R'.$fila,$equipo->getNroTiT());

      if($equipo->getMediaTension() == 1) { $bajamedia = 'Media Tension'; } else { $bajamedia = 'Baja Tension';}
      $objPHPExcel->getActiveSheet()->setCellValue('S'.$fila,$bajamedia);

      if($tv->getId() == 1) { $tipoTv = '-'; } else { $tipoTv = strtoupper($tv->getTipo()); }
      $objPHPExcel->getActiveSheet()->setCellValue('T'.$fila,$tipoTv);

      if($equipo->getCabina() == '1') { $relacionTv = 'No Especificado'; } else { if($equipo->getCabina() == '0') { $relacionTv = '380 V'; } else { $relacionTv = $equipo->getCabina() . ' V'; } }
      $objPHPExcel->getActiveSheet()->setCellValue('U'.$fila,$relacionTv);

      $objPHPExcel->getActiveSheet()->setCellValue('V'.$fila,$equipo->getNroTvR());
      $objPHPExcel->getActiveSheet()->setCellValue('W'.$fila,$equipo->getNroTvS());
      $objPHPExcel->getActiveSheet()->setCellValue('X'.$fila,$equipo->getNroTvT());


      if($equipo->getObservacion() == '0') { $obs = ''; } else { $obs = ucfirst($equipo->getObservacion()); }
      $objPHPExcel->getActiveSheet()->setCellValue('Y'.$fila,$obs);

      if($equipo->getTelemedicion() == 1) { $tele = 'Si'; } else { $tele = 'No';}
      $objPHPExcel->getActiveSheet()->setCellValue('Z'.$fila,$tele);

      if($equipo->getRetirado() == 1) { $ret = 'Si'; } else { $ret = 'No';}
      $objPHPExcel->getActiveSheet()->setCellValue('AA'.$fila,$ret);

      $fila++;

            }

      }


      header('Content-Type: application/vnd.ms-excel');
      header('Content-Disposition: attachment;filename="Equipos.xls"');
      header('Cache-Control: max-age=0');
      $objWriter = PHPEXCEL_IOFactory::createWriter($objPHPExcel, 'Excel5');
      ob_end_clean();
      $objWriter->save('php://output');

} //si es administrador
?>