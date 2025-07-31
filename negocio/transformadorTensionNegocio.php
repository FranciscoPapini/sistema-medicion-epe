<?php
/*Clase Datos*/
require_once('datos/transformadorTensionDb.php');

class TransformadorTensionNegocio{
  
    public function listar(){
        $db = new TransformadorTensionDb();
        return $db->getAll();
    }

  
    public function recuperar($id){
        $db = new TransformadorTensionDb();       
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
    		$tv = new TransformadorTension($datos);
	        $db = new TransformadorTensionDb();
	        if($tv->getId()){

	        	if( $db->update($tv) instanceof TransformadorTension ){
	        		Util::setMsj('El TV fue actualizado con &eacute;xito','success');
	        	}else{
	        		Util::setMsj('Hubo un problema actualizando el TV','danger');
	        	}
                    header('Location:?modulo=transformadorTension&accion=listar');
                    die();
	        }else{

	        	if( $db->insert($tv) instanceof TransformadorTension ){
	        		Util::setMsj('El TV fue insertado con &eacute;xito','success');
	        	}else{
	        		Util::setMsj('Hubo un problema insertando el TV','danger');
	        	}
                    header('Location:?modulo=transformadorTension&accion=listar');
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
            $tv = new TransformadorTension($datos);
            $db = new TransformadorTensionDb();

            if( $db->remove($tv)){
                Util::setMsj('El TV fue eliminado con &eacute;xito','success');
            }else{
                Util::setMsj('Hubo un problema eliminando el TV','danger');
            }
            header('Location:?modulo=transformadorTension&accion=listar');
            die();
        }else{
        //si hay algun error, informar por pantalla
        }
    }
}
?>