<?php
/*Clase Datos*/
require_once('datos/Db.php');
/*Clase Entidades*/
require_once('entidades/administrador.php');

class AdministradorDb extends Db{

    public function getOne($id){
        
        $sql = "SELECT a.* 
                FROM administrador AS a
                WHERE a.id = " . $id . "
                LIMIT 1";

        $result = $this->mysqli->query($sql) or die("Error " . $sql . mysqli_error($mysqli));
        $administrador = new Administrador( $result->fetch_assoc() );
        $result->free();
        
        return $administrador;
    }

    
    public function getAll(){
        
        $sql = "SELECT a.*
                FROM administrador AS a
                WHERE a.eliminado = 0
                ORDER BY a.apellido DESC, a.nombre DESC";

        $result = $this->mysqli->query($sql) or die("Error " . $sql . mysqli_error($mysqli));
        $array = $this->resourceToObjects($result,'Administrador');
        $result->free();
        
        return $array;
    }

    
    public function login($user, $password){
        
        $sql = "SELECT a.* 
                FROM administrador AS a
                WHERE a.usuario = '" . $user . "'
                AND a.password = '" . md5($password) . "'
                AND a.eliminado = 0
                LIMIT 1";

        $result = $this->mysqli->query($sql) or die("Error " . mysqli_error($mysqli));
        if($result->num_rows > 0){
	        $administrador = new Administrador( $result->fetch_assoc() );
	        $result->free();
	        return $administrador;
        }else{
        	return false;
        }
    }

   
    public function update($administrador){
  
            $sql = "UPDATE administrador SET nombre = '" . $administrador->getNombre() . "', 
                                       apellido = '" . $administrador->getApellido() . "', ";
                                       if($administrador->getPassword()){
                                            $sql.= "password = '".md5($administrador->getPassword())."', ";
                                        }
                                       $sql.= " 
                                       email = '" . $administrador->getEmail() . "'                   
                    WHERE id = " . $administrador->getId();
        $this->mysqli->query($sql) or die("Error " . $sql . mysqli_error($mysqli));
        
        return $administrador;
    }

    
    /*Funcion verifica que no exista un administrador con el mismo usuario*/
    public function checkAdministrador($administrador){

        $sql = "SELECT a.*
        FROM administrador AS a
        WHERE a.usuario = '" . $administrador . "'";
        $result = $this->mysqli->query($sql) or die("Error " . $sql . mysqli_error($mysqli));
        if($result->num_rows > 0){
            return false;
        }
        else{
            return true;
        }   
    }

   
    public function insert($administrador){

        $sql = "INSERT INTO administrador(     
                                     nombre,
                                     apellido,
                                     usuario,
                                     password,
                                     email)
                VALUES ('" . $administrador->getNombre() . "', 
                        '" . $administrador->getApellido() . "', 
                        '" . $administrador->getUsuario() . "',
                        '" . md5($administrador->getPassword()) . "',
                        '" . $administrador->getEmail() . "' )";

        $this->mysqli->query($sql) or die("Error " . $sql . mysqli_error($mysqli));
        $administrador->setId( $this->mysqli->insert_id );
        
        return $administrador;
    }

    
    public function remove($administrador){
        $sql = "UPDATE administrador SET eliminado = 1
                WHERE id = " . $administrador->getId();
        $this->mysqli->query($sql) or die("Error " . $sql . mysqli_error($mysqli));
        
        return true;
    }
}

?>