<?php
/*Clase Datos*/
require_once('datos/controlDb.php');

class ControlNegocio{
  
    public function listar(){
        $db = new ControlDb();
        return $db->getAll();
    }
  

    public function recuperar($id){
        $db = new ControlDb();       
        return $db->getOne($id);
    }


    public function guardar(){

    	//validar los campos recibidos por $_POST

        $_POST['tipo'] = strtolower($_POST['tipo']);

    	$valido = true;
    	$datos = $_POST;

    	if($valido){
    	//si todo está ok, guardar en BD e informar por pantalla
    		$control = new Control($datos);
	        $db = new ControlDb();
	        if($control->getId()){

	        	if( $db->update($control) instanceof Control ){
	        		Util::setMsj('El control fue actualizado con &eacute;xito','success');
	        	}else{
	        		Util::setMsj('Hubo un problema actualizando el control','danger');
	        	}
                    header('Location:?modulo=control&accion=listar');
                    die();
	        }else{

	        	if( $db->insert($control) instanceof Control ){
	        		Util::setMsj('El control fue insertado con &eacute;xito','success');
	        	}else{
	        		Util::setMsj('Hubo un problema insertando el control','danger');
	        	}
                    header('Location:?modulo=control&accion=listar');
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
            $control = new Control($datos);
            $db = new ControlDb();

            if( $db->remove($control)){
                Util::setMsj('El control fue eliminado con &eacute;xito','success');
            }else{
                Util::setMsj('Hubo un problema eliminando el control','danger');
            }
            header('Location:?modulo=control&accion=listar');
            die();
        }else{
        //si hay algun error, informar por pantalla
        }
    }
}
?>