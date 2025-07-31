<?php
/*Clase Datos*/
require_once('datos/administradorDb.php');

class AdministradorNegocio{
  
    public function listar(){
        $db = new AdministradorDb();
        return $db->getAll();
    }
  

    public function recuperar($id){
        $db = new AdministradorDb();       
        return $db->getOne($id);
    }


    public function login($user, $password){
        $db = new AdministradorDb();       
        return $db->login($user, $password);
    }


    public function validarUser($user){
        $db = new AdministradorDb();
        return $db->checkAdministrador($user);
    }


    public function guardar(){

        //validar los campos recibidos por $_POST
        $valido = true;

        $_POST['nombre'] = mb_strtolower($_POST['nombre'], 'UTF-8');
        $_POST['apellido'] = mb_strtolower($_POST['apellido'], 'UTF-8');

        $datos = $_POST;
        $confPassword = $datos['confpassword'];

        if($valido){
        //si todo está ok, guardar en BD e informar por pantalla
            $administrador = new Administrador($datos);
            $db = new AdministradorDb();
            if($administrador->getId()){
                    if(Util::validarPassword($administrador->getPassword(), $confPassword)){
                        if( $db->update($administrador) instanceof Administrador ){
                            Util::setMsj('El administrador fue actualizado con &eacute;xito','success');
                        }else{
                            Util::setMsj('Hubo un problema actualizando el administrador','danger');
                        }
                        header('Location:?modulo=administrador&accion=listar');
                        die();
                    }else{
                        Util::setMsj('Las contraseñas no coinciden','danger');
                        header('Location:?modulo=administrador&accion=editar&id='.$administrador->getId());
                        die();
                    }
                        
            }else{
                if( $db->checkAdministrador($administrador->getUsuario()) ){ 
                    if( $db->insert($administrador) instanceof Administrador ){
                        Util::setMsj('El administrador fue insertado con &eacute;xito','success');
                    }else{
                        Util::setMsj('Hubo un problema insertando el administrador','danger');
                        }
                    header('Location:?modulo=administrador&accion=listar');
                    die();
                    }
                else{
                        Util::setMsj('El usuario <strong>'.$administrador->getUsuario().'</strong> ya existe. Intente con otro usuario','danger');
                        return false;
                    }
                }
        }
        else{
        //si hay algun error, informar por pantalla
        }
    }

    public function eliminar(){

        //validar los campos recibidos por $_POST
        $valido = true;
        $datos = $_POST;

        if($valido){
        //si todo está ok, guardar en BD e informar por pantalla
            $administrador = new Administrador($datos);
            $db = new AdministradorDb();

            if( $db->remove($administrador)){
                Util::setMsj('El administrador <strong>'.$_POST['administrador'].'</strong> fue eliminado con &eacute;xito','success');
            }else{
                Util::setMsj('Hubo un problema eliminando el administrador','danger');
            }
            header('Location:?modulo=administrador&accion=listar');
            die();
        }else{
        //si hay algun error, informar por pantalla
        }
    }
}
?>