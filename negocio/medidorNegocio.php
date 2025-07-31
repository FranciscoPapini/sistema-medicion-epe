<?php
/*Clase Datos*/
require_once('datos/medidorDb.php');

class MedidorNegocio{
  
    public function listar(){
        $db = new MedidorDb();
        return $db->getAll();
    }

  
    public function recuperar($id){
        $db = new MedidorDb();       
        return $db->getOne($id);
    }


    public function guardar(){

    	//validar los campos recibidos por $_POST
      $_POST['tipo'] = strtolower($_POST['tipo']);


    	$valido = true;
    	$datos = $_POST;

    	if($valido){
    	//si todo está ok, guardar en BD e informar por pantalla
    		$medidor = new Medidor($datos);
	        $db = new MedidorDb();
	        if($medidor->getId()){

	        	if( $db->update($medidor) instanceof Medidor ){
	        		Util::setMsj('El medidor fue actualizado con &eacute;xito','success');
	        	}else{
	        		Util::setMsj('Hubo un problema actualizando el medidor','danger');
	        	}
                    header('Location:?modulo=medidor&accion=listar');
                    die();
	        }else{

	        	if( $db->insert($medidor) instanceof Medidor ){
	        		Util::setMsj('El medidor fue insertado con &eacute;xito','success');
	        	}else{
	        		Util::setMsj('Hubo un problema insertando el medidor','danger');
	        	}
                    header('Location:?modulo=medidor&accion=listar');
                    die();
	        }
    	}else{
    	//si hay algun error, informar por pantalla
    	}
    }

    public function eliminar(){

        //validar los campos recibidos por $_POST
        $valido = true;
        $datos = $_POST;

        if($valido){
        //si todo está ok, guardar en BD e informar por pantalla
            $medidor = new Medidor($datos);
            $db = new MedidorDb();

            if( $db->remove($medidor)){
                Util::setMsj('El medidor fue eliminado con &eacute;xito','success');
            }else{
                Util::setMsj('Hubo un problema eliminando el medidor','danger');
            }
            header('Location:?modulo=medidor&accion=listar');
            die();
        }else{
        //si hay algun error, informar por pantalla
        }
    }
}
?>