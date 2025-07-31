<?php
/*Clase Datos*/
require_once('datos/lecturaDb.php');

class LecturaNegocio{
  
  public function listar($id_consulta){
      $db = new LecturaDb();
      return $db->getAll($id_consulta);
  }


  public function recuperar($id_consulta){
  	 $db = new LecturaDb();
  	 return $db->getOne($id_consulta);
  }


  public function recuperarUna($id_consulta, $retiro){
     $db = new LecturaDb();
     return $db->getOneUna($id_consulta, $retiro);
  }
 

  public function guardar(){
  }


  public function eliminar(){
  }
}
?>