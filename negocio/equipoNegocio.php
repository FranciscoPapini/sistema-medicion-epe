<?php
/*Clase Datos*/
require_once('datos/equipoDb.php');

class EquipoNegocio{

  public function listarTodos(){
      $db = new EquipoDb();
      return $db->getAllTodos();
  }


  public function listarTodosRetirados(){
      $db = new EquipoDb();
      return $db->getAllTodosRetirados();
  }


  public function listarTodosOrd(){
      $db = new EquipoDb();
      return $db->getAllTodosOrd();
  }


  public function listarTodosExcel(){
      $db = new EquipoDb();
      return $db->getAllTodosExcel();
  }


  public function listarTodosMapa(){
      $db = new EquipoDb();
      return $db->getAllTodosMapa();
  }


  public function listarTodosSinCoord(){
      $db = new EquipoDb();
      return $db->getAllTodosSinCoord();
  }


  public function listarTodosAreparar(){
      $db = new EquipoDb();
      return $db->getAllTodosAreparar();
  }


  public function listarTodosSinFolio(){
      $db = new EquipoDb();
      return $db->getAllTodosSinFolio();
  }  


  public function recuperar($id){
  	 $db = new EquipoDb();
  	 return $db->getOne($id);
  }


  public function buscar(){
     $db = new EquipoDb();
     $_POST['buscador'] = mb_strtolower($_POST['buscador'], 'UTF-8');

     $arrayEquipos = $db->getAllBuscado($_POST['buscador']);
     
     if (count($arrayEquipos) > 0) {

     $_SESSION['buscador'] = $arrayEquipos;
     header('Location:?modulo=equipo&accion=buscar&arreglo=1');
     die();
     } else {
     Util::setMsj('El equipo buscado por: <strong>' . $_POST['buscador'] . '</strong> no se encontr&oacute;','warning');
     header('Location:?modulo=equipo&accion=buscar');
     die();
     }
  }


  public function guardar(){

    	$valido = true;

      if($_POST['media_tension'] == ('on' || 1)){

      } else {
          $_POST['cabina'] = 0;
          $_POST['relacion_tv'] = 0;
          $_POST['id_tv'] = 1;
          $_POST['nro_tv_r'] = 0;
          $_POST['nro_tv_s'] = 0;
          $_POST['nro_tv_t'] = 0;
      } 

      $_POST['usuario'] = mb_strtolower($_POST['usuario'], 'UTF-8');
      $_POST['direccion'] = mb_strtolower($_POST['direccion'], 'UTF-8');
      $_POST['localidad'] = mb_strtolower($_POST['localidad'], 'UTF-8');
      $_POST['observacion'] = mb_strtolower($_POST['observacion'], 'UTF-8');

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

      if($_POST['id_medidor_respaldo']) {} else {
        $_POST['id_medidor_respaldo'] = 1;
      }

      if($_POST['respaldo'] == ('on' || 1)){

      } else {
        $_POST['id_medidor_respaldo'] = 1;
        $_POST['nro_medidor_respaldo'] = 0;
      }


    	$datos = $_POST;
      $datos['alta'] = Util::dateToDb($datos['alta']);

      if($_POST['id_medidor'] == '2') {
        $_POST['relacion_ti'] = '1/1';

      }

    	if($valido){
    	//si todo está ok, guardar en BD e informar por pantalla



      //     if ($_POST['retirado'] == ('on' || 1)) si se retira se pone el folio en 0, eso hay que ver. capaz que mantiene el folio 
      //      {

      //        $datos['folio'] = '0';
            
      //      }

    /*Al retirar equipo, concateno el folio, por si se vuelve a usar para otro usuario, pero no lo voy a usar. Lo voy a dejar sin folio al equipo retirado.

   //         $longitud = strlen($_POST['folio']);

   //       switch ($longitud) {
   //         case '1':
                $agregar = '1111111';
                break;
            case '2':
                $agregar = '111111';
                break;
            case '3':
                $agregar = '11111';
                break;
            case '4':
                $agregar = '1111';
                break;
            case '5':
                $agregar = '111';
                break;
            default:
                break;
          }

           $datos['folio'] = $_POST['folio'] . $agregar;

          }
*/
        $equipo = new Equipo($datos);
          $db = new EquipoDb();

          if($equipo->getId()){

            if ($_POST['retired'] == ('on' || 1) || ($_SESSION['administrador']['id'] != 1 && $_SESSION['administrador']['id'] != 2 && $_SESSION['administrador']['id'] != 3)){

            if( $db->updateUpp($equipo) instanceof Equipo ){
              Util::setMsj('El equipo fue actualizado con &eacute;xito','success');
              
      //        require_once('datos/consultaDb.php');
      //        require_once('negocio/consultaNegocio.php');

              if($datos['redirect'] == "?modulo=consulta&accion=listar&id_equipo") {
                header('Location:?modulo=consulta&accion=listar&id_equipo='.$equipo->getId());
                die();
                } else {
                header('Location:'.$datos['redirect']);
                die();
                }

            }else{
                Util::setMsj('Hubo un problema actualizando el equipo','danger');
                header('Location:?modulo=equipo&accion=listar');
                die();
            }
            }

      if ($_POST['ruta_anterior'] == 0 || $_POST['folio_anterior'] == 0) {

          $check = $db->checkEquipo($equipo->getRuta(), $equipo->getFolio());

            } else { 
                      if ($_POST['ruta_anterior'] == $_POST['ruta'] && $_POST['folio_anterior'] == $_POST['folio'])
                      {
                        $check = true;
                      } else { 
          $check = $db->checkEquipo($equipo->getRuta(), $equipo->getFolio());
                      }
      }
            
            if( $check ){

            if( $db->update($equipo) instanceof Equipo ){
              Util::setMsj('El equipo fue actualizado con &eacute;xito','success');
              
              if($datos['redirect'] == "?modulo=consulta&accion=listar&id_equipo") {
                header('Location:?modulo=consulta&accion=listar&id_equipo='.$equipo->getId());
                die();
                } else {
                header('Location:'.$datos['redirect']);
                die();
                }

            }else{
                Util::setMsj('Hubo un problema actualizando el equipo','danger');
                header('Location:?modulo=equipo&accion=listar');
            die();
            }
        
        } else {
                Util::setMsj('El equipo con Ruta: <strong>' . $equipo->getRuta() . '</strong> y Folio: <strong>' . $equipo->getFolio() . '</strong> ya existe','danger');
                header('Location:?modulo=equipo&accion=listar');
                die();
          }
        }
          else{
            if( $db->checkEquipo($equipo->getRuta(), $equipo->getFolio()) ){

              if( $db->insert($equipo) instanceof Equipo ){
                Util::setMsj('El equipo fue insertado con &eacute;xito','success');
                
                if($datos['redirect'] == "?modulo=consulta&accion=editar&id_equipo") {
                  $equipo = $db->getUno();
                  header('Location:?modulo=consulta&accion=editar&id_equipo='.$equipo->getId());
                  die();
                } else {
                header('Location:'.$datos['redirect']);
                die();
                }
              }else{
                  Util::setMsj('Hubo un problema insertando el equipo','danger');
                  header('Location:?modulo=equipo&accion=listar');
                  die();
              }
          }
          else{
                  Util::setMsj('El equipo con Ruta: <strong>' . $equipo->getRuta() . '</strong> y Folio: <strong>' . $equipo->getFolio() . '</strong> ya existe','danger');
                  header('Location:?modulo=equipo&accion=listar');
                  die();
          }
        }
      }else{
      //si hay algun error, informar por pantalla
      }
    }


    /*No esta en uso*/
    public function eliminar(){

        //validar los campos recibidos por $_POST
        $valido = false;
        $datos = $_POST;

        if($valido){
        //si todo está ok, guardar en BD e informar por pantalla
            $equipo = new Equipo($datos);
            $db = new EquipoDb();

            if( $db->remove($equipo)){
                Util::setMsj('El equipo <strong>'.$equipo->getRuta().' '.$equipo->getFolio().' </strong> fue eliminado con &eacute;xito','success');
            }else{
                Util::setMsj('Hubo un problema eliminando el equipo','danger');
            }
                header('Location:?modulo=equipo&accion=listar');
                die();
        }else{
        //si hay algun error, informar por pantalla
        }
    }
}
?>