<?php
/*Clase Datos*/
require_once('datos/Db.php');
/*Clase Entidades*/
require_once('entidades/lectura.php');

class LecturaDb extends Db{

      public function getOne($id){
        global $mysqli;
        
        $sql = "SELECT l.*
                FROM lectura AS l
                WHERE l.id_consulta = " . $id . "
                LIMIT 1";

        $result = $this->mysqli->query($sql) or die("Error " . $sql . mysqli_error($mysqli));
        
        $lectura = new Lectura( $result->fetch_assoc() );
        $result->free();

        return $lectura;

    }


      public function getOneUna($id, $retiro){
        global $mysqli;
        
        $sql = "SELECT l.*
                FROM lectura AS l
                WHERE l.id_consulta = " . $id . "
                AND l.retiro = " . $retiro . "
                LIMIT 1";

        $result = $this->mysqli->query($sql) or die("Error " . $sql . mysqli_error($mysqli));
        
        $lectura = new Lectura( $result->fetch_assoc() );
        $result->free();

        return $lectura;

    }

    
    public function getUna($id_consulta){
        global $mysqli;
        
        $sql = "SELECT l.* 
                FROM lectura AS l
                WHERE l.id_consulta = " . $id_consulta . "
                AND l.eliminado = 0
                LIMIT 1";

        $result = $this->mysqli->query($sql) or die("Error " . $sql . mysqli_error($mysqli));

        if($result->num_rows > 0){
                return true;
        }
        else{
            return false;
        }
    }


    public function insert($lectura){

        $sql = "INSERT INTO lectura (     id_consulta,
                                          retiro,
                                          cuatro,
                                          cinco,
                                          seis,
                                          nueve,
                                          dies,
                                          trece,
                                          catorce,
                                          dieciseis,
                                          diecinueve,
                                          erre,
                                          ese,
                                          te,
                                          treintaycuatro,
                                          treintaycinco,
                                          treintayseis,
                                          treintaysiete,
                                          treintaynueve,
                                          cuarenta,
                                          cuarentayuno,
                                          cuarentaytres,
                                          cuarentaycuatro,
                                          cuarentaycinco,
                                          cuarentayseis)
                 VALUES ( " . $lectura->getIdConsulta() . ",
                          " . $lectura->getRetiro() . ", 
                         '" . $lectura->getCuatro() . "', 
                         '" . $lectura->getCinco() . "', 
                         '" . $lectura->getSeis() . "', 
                         '" . $lectura->getNueve() . "', 
                         '" . $lectura->getDies() . "', 
                         '" . $lectura->getTrece() . "', 
                         '" . $lectura->getCatorce() . "', 
                         '" . $lectura->getDieciseis() . "', 
                         '" . $lectura->getDiecinueve() . "', 
                         '" . $lectura->getErre() . "', 
                         '" . $lectura->getEse() . "', 
                         '" . $lectura->getTe() . "', 
                         '" . $lectura->getTreintaycuatro() . "', 
                         '" . $lectura->getTreintaycinco() . "', 
                         '" . $lectura->getTreintayseis() . "', 
                         '" . $lectura->getTreintaysiete() . "', 
                         '" . $lectura->getTreintaynueve() . "', 
                         '" . $lectura->getCuarenta() . "', 
                         '" . $lectura->getCuarentayuno() . "', 
                         '" . $lectura->getCuarentaytres() . "', 
                         '" . $lectura->getCuarentaycuatro() . "', 
                         '" . $lectura->getCuarentaycinco() . "', 
                         '" . $lectura->getCuarentayseis() . "' )";

        $this->mysqli->query($sql) or die("Error " . $sql . mysqli_error($mysqli));

        return true;
    }


    public function removeLectura($id_consulta, $fisico, $retiro){

          if($fisico)
          {
          $sql = "DELETE FROM lectura
                  WHERE id_consulta = " . $id_consulta . " AND retiro = " . $retiro . " ";
          } else{
          $sql = "UPDATE lectura SET eliminado = 1
                  WHERE id_consulta = " . $id_consulta . " AND retiro = " . $retiro . " ";
          }
          $this->mysqli->query($sql) or die("Error " . $sql . mysqli_error($mysqli));
          return true;
    }

}
?>