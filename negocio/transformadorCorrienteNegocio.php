<?php
/*Clase Datos*/
require_once('datos/transformadorCorrienteDb.php');

class TransformadorCorrienteNegocio{
  
    public function listar(){
        $db = new TransformadorCorrienteDb();
        return $db->getAll();
    }
  

    public function recuperar($id){
        $db = new TransformadorCorrienteDb();       
        return $db->getOne($id);
    }


    public function guardar(){

    	//validar los campos recibidos por $_POST
        $_POST['tipo'] = strtolower($_POST['tipo']);
        $_POST['clase'] = strtolower($_POST['clase']);
        $_POST['prestacion'] = strtolower($_POST['prestacion']);

    	$valido = true;
    	$datos = $_POST;

    	if($valido){
    	//si todo está ok, guardar en BD e informar por pantalla
    		$ti = new TransformadorCorriente($datos);
	        $db = new TransformadorCorrienteDb();
	        if($ti->getId()){

	        	if( $db->update($ti) instanceof TransformadorCorriente ){
	        		Util::setMsj('El TI fue actualizado con &eacute;xito','success');
	        	}else{
	        		Util::setMsj('Hubo un problema actualizando el TI','danger');
	        	}
                    header('Location:?modulo=transformadorCorriente&accion=listar');
                    die();
	        }else{

	        	if( $db->insert($ti) instanceof TransformadorCorriente ){
	        		Util::setMsj('El TI fue insertado con &eacute;xito','success');
	        	}else{
	        		Util::setMsj('Hubo un problema insertando el TI','danger');
	        	}
                    header('Location:?modulo=transformadorCorriente&accion=listar');
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
            $ti = new TransformadorCorriente($datos);
            $db = new TransformadorCorrienteDb();

            if( $db->remove($ti)){
                Util::setMsj('El TI fue eliminado con &eacute;xito','success');
            }else{
                Util::setMsj('Hubo un problema eliminando el TI','danger');
            }
            header('Location:?modulo=transformadorCorriente&accion=listar');
            die();
        }else{
        //si hay algun error, informar por pantalla
        }
    }
}
?>