<?php
require_once('datos/Db.php');

require_once('entidades/transformadorTension.php');

class TransformadorTensionDb extends Db{

    public function getOne($id){
        global $mysqli;
        
        $sql = "SELECT tv.*
                FROM transformadorTension AS tv
                WHERE tv.id = " . $id . "
                LIMIT 1";

        $result = $this->mysqli->query($sql) or die("Error " . $sql . mysqli_error($mysqli));
        $tv = new TransformadorTension( $result->fetch_assoc() );
        $result->free();
        
        return $tv;
    }

    public function getAll(){
        
        $sql = "SELECT tv.* 
                FROM transformadorTension AS tv
                WHERE tv.eliminado = 0 
                ORDER BY tv.tipo ASC";

        $result = $this->mysqli->query($sql) or die("Error " . $sql . mysqli_error($mysqli));
        $array = $this->resourceToObjects($result,'TransformadorTension');
        $result->free();
        
        return $array;
    }

    public function update($tv){
        
        $sql = "UPDATE transformadorTension SET  tipo = '" . $tv->getTipo() . "', 
                                                 clase = '" . $tv->getClase() . "',
                                                 prestacion = '" . $tv->getPrestacion() . "'
                                                 
                WHERE id = " . $tv->getId();
        $this->mysqli->query($sql) or die("Error " . $sql . mysqli_error($mysqli));
        
        return $tv;
    }

    public function insert($tv){
        
        $sql = "INSERT INTO transformadorTension (tipo, 
                                                  clase,
                                                  prestacion)
                VALUES ( '" . $tv->getTipo() . "', 
                         '" . $tv->getClase() . "',
                         '" . $tv->getPrestacion() . "' )";

        $this->mysqli->query($sql) or die("Error " . $sql . mysqli_error($mysqli));
        $tv->setId( $this->mysqli->insert_id );
        
        return $tv;
    }

    public function remove($tv){
        $sql = "UPDATE transformadorTension SET eliminado = 1
                WHERE id = " . $tv->getId();
        $this->mysqli->query($sql) or die("Error " . $sql . mysqli_error($mysqli));
        
        return true;
    }
}

?>