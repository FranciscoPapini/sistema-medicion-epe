<?php
      require_once('excel/Classes/PHPExcel.php');
      require_once('excel/Classes/PHPExcel/IOFactory.php');

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


      $objPHPExcel = new PHPExcel();
      $objPHPExcel->getProperties()
      ->setCreator('Laboratorio Electrico')
      ->setTitle('Datos de Equipo')
      ->setDescription('Reporte de equipo de medicion');
      $objPHPExcel->setActiveSheetIndex(0);
      $objPHPExcel->getActiveSheet()->setTitle('Hoja1');

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

      $objPHPExcel->getActiveSheet()->getStyle('A1:F1')->applyFromArray($estiloTituloColumnas);

      $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(40);
      $objPHPExcel->getActiveSheet()->setCellValue('A1','USUARIO');
      $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(8);
      $objPHPExcel->getActiveSheet()->setCellValue('B1','RUTA');
      $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(8);
      $objPHPExcel->getActiveSheet()->setCellValue('C1','FOLIO');
      $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(40);
      $objPHPExcel->getActiveSheet()->setCellValue('D1','DIRECCION');
      $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(30);
      $objPHPExcel->getActiveSheet()->setCellValue('E1','LOCALIDAD');
      $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(25);
      $objPHPExcel->getActiveSheet()->setCellValue('F1','COORDENADAS');


      $objPHPExcel->getActiveSheet()->setCellValue('A2',strtoupper($equipo->getUsuario()));
      $objPHPExcel->getActiveSheet()->setCellValue('B2',$equipo->getRuta());
      $objPHPExcel->getActiveSheet()->setCellValue('C2',$equipo->getFolio());
      $objPHPExcel->getActiveSheet()->setCellValue('D2',ucwords($equipo->getDireccion()));
      $objPHPExcel->getActiveSheet()->setCellValue('E2',ucwords($equipo->getLocalidad()));
      $objPHPExcel->getActiveSheet()->setCellValue('F2',$equipo->getLatitud() . ', ' .$equipo->getLongitud());



      header('Content-Type: application/vnd.ms-excel');
      header('Content-Disposition: attachment;filename="Excel.xls"');
      header('Cache-Control: max-age=0');
      $objWriter = PHPEXCEL_IOFactory::createWriter($objPHPExcel, 'Excel5');
      ob_end_clean();
      $objWriter->save('php://output');
?>