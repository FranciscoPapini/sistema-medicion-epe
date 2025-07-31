<?php
/*Clase Datos*/
require_once('datos/informeDb.php');

class InformeNegocio{
  
    public function listar(){
        $db = new InformeDb();
        return $db->getAll();
    }
  

    public function recuperar($id){
        $db = new InformeDb();   
        return $db->getOne($id);
    }


    public function guardar(){

    	//validar los campos recibidos por $_POST
    	$valido = true;
    	$_POST['usuario'] = mb_strtolower($_POST['usuario'], 'UTF-8');
        $_POST['tipo'] = mb_strtolower($_POST['tipo'], 'UTF-8');
        $_POST['descripcion'] = mb_strtolower($_POST['descripcion'], 'UTF-8');
        $_POST['direccion'] = mb_strtolower($_POST['direccion'], 'UTF-8');
        $_POST['localidad'] = mb_strtolower($_POST['localidad'], 'UTF-8');
        $_POST['inspector'] = mb_strtolower($_POST['inspector'], 'UTF-8');
        $_POST['ayudante'] = mb_strtolower($_POST['ayudante'], 'UTF-8');
        $_POST['id_administrador'] = $_SESSION['administrador']['id'];

        if($_POST['tipo'] == "puesta en servicio rechazada") {
            $_POST['aprobado'] = 0;
        }
        
        $datos = $_POST;
    	$datos['fecha'] = Util::dateToDb($datos['fecha']);

    	if($valido){
    	//si todo está ok, guardar en BD e informar por pantalla
    		$informe = new Informe($datos);
	        $db = new InformeDb();
	        if($informe->getId()){

	        	if( $db->update($informe) instanceof Informe ){
	        		Util::setMsj('El informe fue actualizado con &eacute;xito','success');
	        	}else{
	        		Util::setMsj('Hubo un problema actualizando el informe','danger');
	        	}
                    header('Location:?modulo=informe&accion=listar');
                    die();
	        }else{

	        	if( $db->insert($informe) instanceof Informe ){
	        		Util::setMsj('El informe fue insertado con &eacute;xito','success');
	        	}else{
	        		Util::setMsj('Hubo un problema insertando el informe','danger');
	        	}
                header('Location:?modulo=informe&accion=listar');
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
            $informe = new Informe($datos);
            $db = new InformeDb();

            if( $db->remove($informe)){
                Util::setMsj('El informe fue eliminado con &eacute;xito','success');
            }else{
                Util::setMsj('Hubo un problema eliminando el informe','danger');
            }
            header('Location:?modulo=informe&accion=listar');
            die();
        }else{
        //si hay algun error, informar por pantalla
        }
    }
}
?>