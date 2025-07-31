<?php
/*Clase Datos*/
require_once('datos/consultaDb.php');
require_once('datos/equipoDb.php');
require_once('negocio/equipoNegocio.php');
require_once('negocio/lecturaNegocio.php');


class ConsultaNegocio{
  
  public function listar($id_usuario){
      $db = new ConsultaDb();
      return $db->getAll($id_usuario);
  }


  public function listarRep($id_usuario){
      $db = new ConsultaDb();
      return $db->getAllrep($id_usuario);
  }


  public function listarAreparar($id_usuario){
      $db = new ConsultaDb();
      return $db->getAllaReparar($id_usuario);
  }


  public function listarOrdenado($id_usuario){
      $db = new ConsultaDb();
      return $db->getAllordenado($id_usuario);
  }


  public function listarOrdenadoUna($id_usuario){
      $db = new ConsultaDb();
      return $db->getAllordenadoUna($id_usuario);
  }


  public function listarOrdenadoCuatro($id_usuario){
      $db = new ConsultaDb();
      return $db->getAllordenadoCuatro($id_usuario);
  }


  public function recuperar($id_usuario){
  	 $db = new ConsultaDb();
  	 return $db->getOne($id_usuario);
  }


  public function getUna($id_equipo){
     $db = new ConsultaDb();
     return $db->getUno($id_equipo);
  }


  public function guardarColocacion(){

      $_POST['motivo'] = mb_strtolower($_POST['motivo'], 'UTF-8');
      $_POST['descripcion'] = mb_strtolower($_POST['descripcion'], 'UTF-8');
      $_POST['inspector'] = mb_strtolower($_POST['inspector'], 'UTF-8');
      $_POST['ayudante'] = mb_strtolower($_POST['ayudante'], 'UTF-8');
      $_POST['usuario'] = mb_strtolower($_POST['usuario'], 'UTF-8');
      $_POST['direccion'] = mb_strtolower($_POST['direccion'], 'UTF-8');
      $_POST['localidad'] = mb_strtolower($_POST['localidad'], 'UTF-8');
      $_POST['observacion'] = mb_strtolower($_POST['observacion'], 'UTF-8');
      $_POST['id_administrador'] = $_SESSION['administrador']['id'];

      if($_POST['media_tension'] == ('on' || 1)){

      } else {
          $_POST['cabina'] = 0;
          $_POST['relacion_tv'] = 0;
          $_POST['id_tv'] = 1;
          $_POST['nro_tv_r'] = 0;
          $_POST['nro_tv_s'] = 0;
          $_POST['nro_tv_t'] = 0;
      }

      $_POST['leido2'] = 0;
      $_POST['leido3'] = 0;
      $_POST['leido4'] = 0;
      $_POST['leido5'] = 0;
      $_POST['id_medidor_respaldo'] = 1;
      $_POST['nro_medidor_respaldo'] = 0;
      $_POST['id_medidor_ret'] = 1;
      $_POST['nro_medidor_ret'] = 0;

      if($_POST['id_control']) {} else {
        $_POST['id_control'] = 1;
      }

      if($_POST['id_tv']) {} else {
        $_POST['id_tv'] = 1;
      }

      if($_POST['id_ti']) {} else {
        $_POST['id_ti'] = 1;
      }

      $datosConsulta = $_POST;
      $datosEquipo = $_POST;

      $datosConsulta['fecha'] = Util::dateToDb($_POST['fecha']);
      $datosEquipo['alta'] = Util::dateToDb($_POST['fecha']);
      
      if ($_POST['retired'] == '1') {
        $valido = false;
      } else {
        $valido = true;
      }

      if($valido){
      //si todo está ok, guardar en BD e informar por pantalla

          $equipo = new Equipo($datosEquipo);
          $dbb = new EquipoDb();

         if( $dbb->checkEquipo($equipo->getRuta(), $equipo->getFolio()) ){

              if( $dbb->insert($equipo) instanceof Equipo ){
                Util::setMsj('El equipo fue insertado con &eacute;xito','success');
              }else{
                Util::setMsj('Hubo un problema insertando el equipo','danger');
                header('Location:?modulo=equipo&accion=buscar');
                die();
              }
          }
          else{
                Util::setMsj('El equipo con Ruta: <strong>' . $equipo->getRuta() . '</strong> y Folio: <strong>' . $equipo->getFolio() . '</strong> ya existe','danger');
                header('Location:?modulo=equipo&accion=listar');
                die();
          }

          $datosConsulta['id_equipo'] = $equipo->getId( $dbb->getUno() );

          $consulta = new Consulta($datosConsulta);
          $db = new ConsultaDb();

            if( $db->insert($consulta) instanceof Consulta ){

                 if ($_POST['leido'] == ('on' || 1)) {

                            $consultaActual = $db->getUltimo();
                            $datosLectura = $_POST;
                            $datosLectura['id_consulta'] = $consultaActual->getId();
                            $datosLectura['retiro'] = 0;

                            $lectura = new Lectura($datosLectura);
                            $dbb2 = new LecturaDb(); 
                            $dbb2->insert($lectura) instanceof Lectura;
                    }

                    Util::setMsj('La revisi&oacute;n y el equipo fueron insertados con &eacute;xito','success');
                    header('Location:?modulo=consulta&accion=listar&id_equipo='.$equipo->getId());
                    die();
            }else{
                    Util::setMsj('Hubo un problema insertando la revisi&oacute;n','danger');
                    header('Location:?modulo=equipo&accion=buscar');
                    die();
      }
    }
  }


   public function guardar(){

      $_POST['motivo'] = mb_strtolower($_POST['motivo'], 'UTF-8');
      $_POST['descripcion'] = mb_strtolower($_POST['descripcion'], 'UTF-8');
      $_POST['inspector'] = mb_strtolower($_POST['inspector'], 'UTF-8');
      $_POST['ayudante'] = mb_strtolower($_POST['ayudante'], 'UTF-8');
      $_POST['usuario'] = mb_strtolower($_POST['usuario'], 'UTF-8');
      $_POST['direccion'] = mb_strtolower($_POST['direccion'], 'UTF-8');
      $_POST['localidad'] = mb_strtolower($_POST['localidad'], 'UTF-8');
      $_POST['observacion'] = mb_strtolower($_POST['observacion'], 'UTF-8');
      $_POST['id_administrador'] = $_SESSION['administrador']['id'];

      if($_POST['leido2'] == ('on' || 1)){

      } else {
        $_POST['id_medidor_ret'] = 1;
        $_POST['nro_medidor_ret'] = 0;
        $_POST['leido3'] = 0;
      }

      if($_POST['respaldo'] == ('on' || 1)){

      } else {
        $_POST['id_medidor_respaldo'] = 1;
        $_POST['nro_medidor_respaldo'] = 0;
        $_POST['leido5'] = 0;
      }

      if($_POST['media_tension'] == ('on' || 1)){

      } else {
          $_POST['cabina'] = 0;
          $_POST['relacion_tv'] = 0;
          $_POST['id_tv'] = 1;
          $_POST['nro_tv_r'] = 0;
          $_POST['nro_tv_s'] = 0;
          $_POST['nro_tv_t'] = 0;
      } 

      if($_POST['id_medidor']) {} else {
        $_POST['id_medidor'] = 1;
      }

      if($_POST['id_control']) {} else {
        $_POST['id_control'] = 1;
      }

      if($_POST['id_tv']) {} else {
        $_POST['id_tv'] = 1;
      }

      if($_POST['id_ti']) {} else {
        $_POST['id_ti'] = 1;
      }      

      if($_POST['id_medidor'] == '2') {
        $_POST['relacion_ti'] = '1/1';
      }

      $datosConsulta = $_POST;
      $datosEquipo = $_POST;

      $datosConsulta['fecha'] = Util::dateToDb($_POST['fecha']);
      $datosEquipo['alta'] = Util::dateToDb($_POST['alta']);

      if($_POST['retiro_respaldo'] == ('on' || 1)){

      $datosEquipo['respaldo'] = 0;
      $datosEquipo['id_medidor_respaldo'] = 1;
      $datosEquipo['nro_medidor_respaldo'] = 0;

      } else {

      }

      if($_POST['id'] == ""){
          $datosEquipo['id'] = $_POST['id_equipo'];
      }
      else{
          $datosConsulta['id'] = $_POST['id'];
          $datosEquipo['id'] = $_POST['id_equipo'];
      }

      if ($_POST['retired'] == '1') {
        $valido = false;
      } else {
        $valido = true;
      }

     if ($_POST['problema'] == 1)
     {
        $datosConsulta['funciona'] = 0;
     } else {
     }

    if ($_POST['retirado'] == ('on' || 1)) {
        $datosConsulta['funciona'] = 1;
    }

    	if($valido){
    	//si todo está ok, guardar en BD e informar por pantalla

      		$consulta = new Consulta($datosConsulta);
	        $db = new ConsultaDb();

          $equipo = new Equipo($datosEquipo);
          $dbb = new EquipoDb();

          if($consulta->getId()){

                 if ($_POST['leido'] == ('on' || 1)) {

                            $dbb3 = new LecturaDb();
                            $resultado = $dbb3->getOneUna($consulta->getId(), 0);

                      if ($resultado){

                            $lectura = new Lectura($datosLectura);
                            $dbb5 = new LecturaDb(); 
                            $dbb5->removeLectura($consulta->getId(), true, 0) instanceof Lectura;

                      } else {  

                      }

                            $datosLectura = $_POST;
                            $datosLectura['id_consulta'] = $consulta->getId();
                            $datosLectura['retiro'] = 0;

                            $lectura = new Lectura($datosLectura);
                            $dbb6 = new LecturaDb(); 
                            $dbb6->insert($lectura) instanceof Lectura; 

                  } else {

                            $dbb3 = new LecturaDb();
                            $resultado = $dbb3->getOneUna($consulta->getId(), 0);
                            if ($resultado){
                            $lectura = new Lectura($datosLectura);
                            $dbb5 = new LecturaDb(); 
                            $dbb5->removeLectura($consulta->getId(), false, 0) instanceof Lectura;

                      } else {
                       
                      }

                  }

                  if ($_POST['leido2'] == ('on' || 1) && $_POST['leido3'] == ('on' || 1)) {


                            $dbb33 = new LecturaDb();
                            $resultado = $dbb33->getOneUna($consulta->getId(), 1);

                      if ($resultado){
                            $lectura = new Lectura($datosLectura);
                            $dbb5 = new LecturaDb(); 
                            $dbb5->removeLectura($consulta->getId(), true, 1) instanceof Lectura;

                      } else {
                       
                      }
                            $datosLectura = $_POST;
                            $datosLectura['retiro'] = 1;
                            $datosLectura['id_consulta'] = $consulta->getId();
                            $datosLectura['cuatro'] = $_POST['cuatrow'];
                            $datosLectura['cinco'] = $_POST['cincow'];
                            $datosLectura['seis'] = $_POST['seisw'];
                            $datosLectura['nueve'] = $_POST['nuevew'];
                            $datosLectura['dies'] = $_POST['diesw'];
                            $datosLectura['trece'] = $_POST['trecew'];
                            $datosLectura['catorce'] = $_POST['catorcew'];
                            $datosLectura['dieciseis'] = $_POST['dieciseisw'];
                            $datosLectura['diecinueve'] = $_POST['diecinuevew'];
                            $datosLectura['erre'] = $_POST['errew'];
                            $datosLectura['ese'] = $_POST['esew'];
                            $datosLectura['te'] = $_POST['tew'];
                            $datosLectura['treintaycuatro'] = $_POST['treintaycuatrow'];
                            $datosLectura['treintaycinco'] = $_POST['treintaycincow'];
                            $datosLectura['treintayseis'] = $_POST['treintayseisw'];
                            $datosLectura['treintaysiete'] = $_POST['treintaysietew'];
                            $datosLectura['treintaynueve'] = $_POST['treintaynuevew'];
                            $datosLectura['cuarenta'] = $_POST['cuarentaw'];
                            $datosLectura['cuarentayuno'] = $_POST['cuarentayunow'];
                            $datosLectura['cuarentaytres'] = $_POST['cuarentaytresw'];
                            $datosLectura['cuarentaycuatro'] = $_POST['cuarentaycuatrow'];
                            $datosLectura['cuarentaycinco'] = $_POST['cuarentaycincow'];
                            $datosLectura['cuarentayseis'] = $_POST['cuarentayseisw'];
                            
                            $lectura = new Lectura($datosLectura);
                            $dbb6 = new LecturaDb(); 
                            $dbb6->insert($lectura) instanceof Lectura;

                  } else {

                            $dbb3 = new LecturaDb();
                            $resultado = $dbb3->getOneUna($consulta->getId(), 1);

                      if ($resultado){

                            $lectura = new Lectura($datosLectura);
                            $dbb5 = new LecturaDb(); 
                            $dbb5->removeLectura($consulta->getId(), false, 1) instanceof Lectura;

                      } else {

                      }

                  }
                  if ($_POST['leido4'] == ('on' || 1)) {

                            $dbb34 = new LecturaDb();
                            $resultado = $dbb34->getOneUna($consulta->getId(), 2);

                      if ($resultado){
                            $lectura = new Lectura($datosLectura);
                            $dbb55 = new LecturaDb(); 
                            $dbb55->removeLectura($consulta->getId(), true, 2) instanceof Lectura;

                      } else {

                      }

                            $datosLectura = $_POST;
                            $datosLectura['retiro'] = 2;
                            $datosLectura['id_consulta'] = $consulta->getId();
                            $datosLectura['cuatro'] = $_POST['cuatroww'];
                            $datosLectura['cinco'] = $_POST['cincoww'];
                            $datosLectura['seis'] = $_POST['seisww'];
                            $datosLectura['nueve'] = $_POST['nueveww'];
                            $datosLectura['dies'] = $_POST['diesww'];
                            $datosLectura['trece'] = $_POST['treceww'];
                            $datosLectura['catorce'] = $_POST['catorceww'];
                            $datosLectura['dieciseis'] = $_POST['dieciseisww'];
                            $datosLectura['diecinueve'] = $_POST['diecinueveww'];
                            $datosLectura['erre'] = $_POST['erreww'];
                            $datosLectura['ese'] = $_POST['eseww'];
                            $datosLectura['te'] = $_POST['teww'];
                            $datosLectura['treintaycuatro'] = $_POST['treintaycuatroww'];
                            $datosLectura['treintaycinco'] = $_POST['treintaycincoww'];
                            $datosLectura['treintayseis'] = $_POST['treintayseisww'];
                            $datosLectura['treintaysiete'] = $_POST['treintaysieteww'];
                            $datosLectura['treintaynueve'] = $_POST['treintaynueveww'];
                            $datosLectura['cuarenta'] = $_POST['cuarentaww'];
                            $datosLectura['cuarentayuno'] = $_POST['cuarentayunoww'];
                            $datosLectura['cuarentaytres'] = $_POST['cuarentaytresww'];
                            $datosLectura['cuarentaycuatro'] = $_POST['cuarentaycuatroww'];
                            $datosLectura['cuarentaycinco'] = $_POST['cuarentaycincoww'];
                            $datosLectura['cuarentayseis'] = $_POST['cuarentayseisww'];                           

                            $lectura = new Lectura($datosLectura);
                            $dbb66 = new LecturaDb(); 
                            $dbb66->insert($lectura) instanceof Lectura;
                
                  } else {

                            $dbb34 = new LecturaDb();
                            $resultado = $dbb34->getOneUna($consulta->getId(), 2);

                      if ($resultado){

                            $lectura = new Lectura($datosLectura);
                            $dbb55 = new LecturaDb(); 
                            $dbb55->removeLectura($consulta->getId(), false, 2) instanceof Lectura;

                      } else {
                      
                      }

                  }
                  if ($_POST['leido5'] == ('on' || 1)) {

                            $dbb344 = new LecturaDb();
                            $resultado = $dbb344->getOneUna($consulta->getId(), 3);

                      if ($resultado){
                            $lectura = new Lectura($datosLectura);
                            $dbb555 = new LecturaDb(); 
                            $dbb555->removeLectura($consulta->getId(), true, 3) instanceof Lectura;

                      } else {

                      }

                            $datosLectura = $_POST;
                            $datosLectura['retiro'] = 3;
                            $datosLectura['id_consulta'] = $consulta->getId();
                            $datosLectura['cuatro'] = $_POST['cuatrowww'];
                            $datosLectura['cinco'] = $_POST['cincowww'];
                            $datosLectura['seis'] = $_POST['seiswww'];
                            $datosLectura['nueve'] = $_POST['nuevewww'];
                            $datosLectura['dies'] = $_POST['dieswww'];
                            $datosLectura['trece'] = $_POST['trecewww'];
                            $datosLectura['catorce'] = $_POST['catorcewww'];
                            $datosLectura['dieciseis'] = $_POST['dieciseiswww'];
                            $datosLectura['diecinueve'] = $_POST['diecinuevewww'];
                            $datosLectura['erre'] = $_POST['errewww'];
                            $datosLectura['ese'] = $_POST['esewww'];
                            $datosLectura['te'] = $_POST['tewww'];
                            $datosLectura['treintaycuatro'] = $_POST['treintaycuatrowww'];
                            $datosLectura['treintaycinco'] = $_POST['treintaycincowww'];
                            $datosLectura['treintayseis'] = $_POST['treintayseiswww'];
                            $datosLectura['treintaysiete'] = $_POST['treintaysietewww'];
                            $datosLectura['treintaynueve'] = $_POST['treintaynuevewww'];
                            $datosLectura['cuarenta'] = $_POST['cuarentawww'];
                            $datosLectura['cuarentayuno'] = $_POST['cuarentayunowww'];
                            $datosLectura['cuarentaytres'] = $_POST['cuarentaytreswww'];
                            $datosLectura['cuarentaycuatro'] = $_POST['cuarentaycuatrowww'];
                            $datosLectura['cuarentaycinco'] = $_POST['cuarentaycincowww'];
                            $datosLectura['cuarentayseis'] = $_POST['cuarentayseiswww'];                           

                            $lectura = new Lectura($datosLectura);
                            $dbb666 = new LecturaDb(); 
                            $dbb666->insert($lectura) instanceof Lectura;
                
                  } else {

                            $dbb344 = new LecturaDb();
                            $resultado = $dbb344->getOneUna($consulta->getId(), 3);

                      if ($resultado){

                            $lectura = new Lectura($datosLectura);
                            $dbb555 = new LecturaDb(); 
                            $dbb555->removeLectura($consulta->getId(), false, 3) instanceof Lectura;

                      } else {
                      
                      }

                  }

        if($_POST['problema'] == 0) {

	        	if( $db->update($consulta) instanceof Consulta && $dbb->update($equipo) instanceof Equipo ){
	        		Util::setMsj('La revisi&oacute;n y el equipo fueron actualizados con &eacute;xito','success');
            }else{
	        		Util::setMsj('Hubo un problema actualizando la revisi&oacute;n y el equipo','danger');
	        	}    
        } else {

            if( $db->update($consulta) instanceof Consulta ){
              Util::setMsj('El problema fue actualizado con &eacute;xito','success');
            }else{
              Util::setMsj('Hubo un problema actualizando el problema','danger');
            }

        }

        }else{

      if($_POST['problema'] == 0) {

	        	if( $db->insert($consulta) instanceof Consulta && $dbb->update($equipo) instanceof Equipo ){

                 if ($_POST['leido'] == ('on' || 1)) {

                            $consultaActual = $db->getUltimo();
                            $datosLectura = $_POST;
                            $datosLectura['id_consulta'] = $consultaActual->getId();
                            $datosLectura['retiro'] = 0;

                            $lectura = new Lectura($datosLectura);
                            $dbb2 = new LecturaDb(); 
                            $dbb2->insert($lectura) instanceof Lectura;
                    }

                 if ($_POST['leido2'] == ('on' || 1) && $_POST['leido3'] == ('on' || 1)) {

                            $consultaActual = $db->getUltimo();
                            $datosLectura = $_POST;
                            $datosLectura['retiro'] = 1;
                            $datosLectura['id_consulta'] = $consultaActual->getId();
                            $datosLectura['cuatro'] = $_POST['cuatrow'];
                            $datosLectura['cinco'] = $_POST['cincow'];
                            $datosLectura['seis'] = $_POST['seisw'];
                            $datosLectura['nueve'] = $_POST['nuevew'];
                            $datosLectura['dies'] = $_POST['diesw'];
                            $datosLectura['trece'] = $_POST['trecew'];
                            $datosLectura['catorce'] = $_POST['catorcew'];
                            $datosLectura['dieciseis'] = $_POST['dieciseisw'];
                            $datosLectura['diecinueve'] = $_POST['diecinuevew'];
                            $datosLectura['erre'] = $_POST['errew'];
                            $datosLectura['ese'] = $_POST['esew'];
                            $datosLectura['te'] = $_POST['tew'];
                            $datosLectura['treintaycuatro'] = $_POST['treintaycuatrow'];
                            $datosLectura['treintaycinco'] = $_POST['treintaycincow'];
                            $datosLectura['treintayseis'] = $_POST['treintayseisw'];
                            $datosLectura['treintaysiete'] = $_POST['treintaysietew'];
                            $datosLectura['treintaynueve'] = $_POST['treintaynuevew'];
                            $datosLectura['cuarenta'] = $_POST['cuarentaw'];
                            $datosLectura['cuarentayuno'] = $_POST['cuarentayunow'];
                            $datosLectura['cuarentaytres'] = $_POST['cuarentaytresw'];
                            $datosLectura['cuarentaycuatro'] = $_POST['cuarentaycuatrow'];
                            $datosLectura['cuarentaycinco'] = $_POST['cuarentaycincow'];
                            $datosLectura['cuarentayseis'] = $_POST['cuarentayseisw'];

                            $lectura = new Lectura($datosLectura);
                            $dbb2 = new LecturaDb(); 
                            $dbb2->insert($lectura) instanceof Lectura;
                    }

                    if ($_POST['leido4'] == ('on' || 1)) {

                            $consultaActual = $db->getUltimo();
                            $datosLectura = $_POST;
                            $datosLectura['retiro'] = 2;
                            $datosLectura['id_consulta'] = $consultaActual->getId();
                            $datosLectura['cuatro'] = $_POST['cuatroww'];
                            $datosLectura['cinco'] = $_POST['cincoww'];
                            $datosLectura['seis'] = $_POST['seisww'];
                            $datosLectura['nueve'] = $_POST['nueveww'];
                            $datosLectura['dies'] = $_POST['diesww'];
                            $datosLectura['trece'] = $_POST['treceww'];
                            $datosLectura['catorce'] = $_POST['catorceww'];
                            $datosLectura['dieciseis'] = $_POST['dieciseisww'];
                            $datosLectura['diecinueve'] = $_POST['diecinueveww'];
                            $datosLectura['erre'] = $_POST['erreww'];
                            $datosLectura['ese'] = $_POST['eseww'];
                            $datosLectura['te'] = $_POST['teww'];
                            $datosLectura['treintaycuatro'] = $_POST['treintaycuatroww'];
                            $datosLectura['treintaycinco'] = $_POST['treintaycincoww'];
                            $datosLectura['treintayseis'] = $_POST['treintayseisww'];
                            $datosLectura['treintaysiete'] = $_POST['treintaysieteww'];
                            $datosLectura['treintaynueve'] = $_POST['treintaynueveww'];
                            $datosLectura['cuarenta'] = $_POST['cuarentaww'];
                            $datosLectura['cuarentayuno'] = $_POST['cuarentayunoww'];
                            $datosLectura['cuarentaytres'] = $_POST['cuarentaytresww'];
                            $datosLectura['cuarentaycuatro'] = $_POST['cuarentaycuatroww'];
                            $datosLectura['cuarentaycinco'] = $_POST['cuarentaycincoww'];
                            $datosLectura['cuarentayseis'] = $_POST['cuarentayseisww'];

                            $lectura = new Lectura($datosLectura);
                            $dbb2 = new LecturaDb(); 
                            $dbb2->insert($lectura) instanceof Lectura;
                    }

                    if ($_POST['leido5'] == ('on' || 1)) {

                            $consultaActual = $db->getUltimo();
                            $datosLectura = $_POST;
                            $datosLectura['retiro'] = 3;
                            $datosLectura['id_consulta'] = $consultaActual->getId();
                            $datosLectura['cuatro'] = $_POST['cuatrowww'];
                            $datosLectura['cinco'] = $_POST['cincowww'];
                            $datosLectura['seis'] = $_POST['seiswww'];
                            $datosLectura['nueve'] = $_POST['nuevewww'];
                            $datosLectura['dies'] = $_POST['dieswww'];
                            $datosLectura['trece'] = $_POST['trecewww'];
                            $datosLectura['catorce'] = $_POST['catorcewww'];
                            $datosLectura['dieciseis'] = $_POST['dieciseiswww'];
                            $datosLectura['diecinueve'] = $_POST['diecinuevewww'];
                            $datosLectura['erre'] = $_POST['errewww'];
                            $datosLectura['ese'] = $_POST['esewww'];
                            $datosLectura['te'] = $_POST['tewww'];
                            $datosLectura['treintaycuatro'] = $_POST['treintaycuatrowww'];
                            $datosLectura['treintaycinco'] = $_POST['treintaycincowww'];
                            $datosLectura['treintayseis'] = $_POST['treintayseiswww'];
                            $datosLectura['treintaysiete'] = $_POST['treintaysietewww'];
                            $datosLectura['treintaynueve'] = $_POST['treintaynuevewww'];
                            $datosLectura['cuarenta'] = $_POST['cuarentawww'];
                            $datosLectura['cuarentayuno'] = $_POST['cuarentayunowww'];
                            $datosLectura['cuarentaytres'] = $_POST['cuarentaytreswww'];
                            $datosLectura['cuarentaycuatro'] = $_POST['cuarentaycuatrowww'];
                            $datosLectura['cuarentaycinco'] = $_POST['cuarentaycincowww'];
                            $datosLectura['cuarentayseis'] = $_POST['cuarentayseiswww'];

                            $lectura = new Lectura($datosLectura);
                            $dbb2 = new LecturaDb(); 
                            $dbb2->insert($lectura) instanceof Lectura;
                    }
	        		Util::setMsj('La revisi&oacute;n fue insertada con &eacute;xito y el equipo actualizado','success');
	                 
          	}else{
	        		Util::setMsj('Hubo un problema insertando la revisi&oacute;n','danger');
	        	}

      } else {

            if( $db->insert($consulta) instanceof Consulta ){
              Util::setMsj('El problema fue insertado con &eacute;xito','success');
            }else{
              Util::setMsj('Hubo un problema insertando el problema','danger');
            }
      }

	        }
          
              if ($_POST['problema'] == 1){
                header('Location:'.$datosConsulta['redirect']);
                die();
              } else {
                header('Location:?modulo=consulta&accion=listar&id_equipo='.$equipo->getId());
                die();                
              }

    	}else{
              Util::setMsj('La revisi&oacute;n / problema no se puede agregar ya que el equipo esta retirado','danger');
              header('Location:?modulo=consulta&accion=listar&id_equipo='.$_POST['id_equipo']);
          die();
              	//si hay algun error, informar por pantalla
    	}
  }


  public function imprimirTrabajos(){

     $_POST['fecha_desde'] = Util::dateToDb($_POST['fecha_desde']);
     $_POST['fecha_hasta'] = Util::dateToDb($_POST['fecha_hasta']);
     if($_POST['fecha_desde'] <= $_POST['fecha_hasta']){
      $valido = true;
     } else {
      $valido = false;
     }

     if($valido){
      $db = new ConsultaDb();
      $_SESSION['reporteTrabajos'] = $db->getAllTrabajos($_POST['fecha_desde'], $_POST['fecha_hasta']);
      if(count($_SESSION['reporteTrabajos']) > 0){

      header('Location:?modulo=consulta&accion=reporteTrabajos');
      die();
      
      } else {

      Util::setMsj('No hay revisiones en las fechas seleccionadas','warning');
      header('Location:?modulo=consulta&accion=imprimirTrabajos');
      die();

      }
     } else {

      Util::setMsj('Fechas inv&aacute;lidas','danger');
      header('Location:?modulo=consulta&accion=imprimirTrabajos');
      die();
     
     }
  }

        /*No esta en uso*/
        public function eliminar(){

        //validar los campos recibidos por $_POST
        $datos = $_POST;

        if ($_POST['retired'] == '1') {
          $valido = false;
        } else {
          $valido = true;
        }

        $valido = false;

        if($valido){
        //si todo está ok, guardar en BD e informar por pantalla
            $consulta = new Consulta($datos);
            $db = new ConsultaDb();
            if( $db->remove($consulta)){
                Util::setMsj('La revisi&oacute;n fue eliminada con &eacute;xito','success');
            }else{
                Util::setMsj('Hubo un problema eliminando la revisi&oacute;n','danger');
            }
                header('Location:?modulo=consulta&accion=listar&id_equipo='.$consulta->getIdEquipo());
                die();
        }else{
              Util::setMsj('La revisi&oacute;n / problema no se puede eliminar ya que el equipo esta retirado','danger');
              header('Location:?modulo=consulta&accion=listar&id_equipo='.$equipo->getId());
              die();
              //si hay algun error, informar por pantalla
        }
    }
}
?>