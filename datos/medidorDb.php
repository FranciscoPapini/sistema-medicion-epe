<?php
require_once('datos/Db.php');

require_once('entidades/medidor.php');

class MedidorDb extends Db{

    public function getOne($id){
        global $mysqli;
        
        $sql = "SELECT m.*
                FROM medidor AS m
                WHERE m.id = " . $id . "
                LIMIT 1";

        $result = $this->mysqli->query($sql) or die("Error " . $sql . mysqli_error($mysqli));
        $medidor = new Medidor( $result->fetch_assoc() );
        $result->free();
        
        return $medidor;
    }


    public function getAll(){
        
        $sql = "SELECT m.* 
                FROM medidor AS m
                WHERE m.eliminado = 0 
                ORDER BY m.tipo ASC";

        $result = $this->mysqli->query($sql) or die("Error " . $sql . mysqli_error($mysqli));
        $array = $this->resourceToObjects($result,'Medidor');
        $result->free();
        
        return $array;
    }

    public function update($medidor){
        
        $sql = "UPDATE medidor SET  tipo = '" . $medidor->getTipo() . "', 
                                    constante = '" . $medidor->getConstante() . "'
                WHERE id = " . $medidor->getId();
        $this->mysqli->query($sql) or die("Error " . $sql . mysqli_error($mysqli));
        return $medidor;
    }

    public function insert($medidor){
        
        $sql = "INSERT INTO medidor (tipo, 
                                     constante)
                VALUES ( '" . $medidor->getTipo() . "', 
                          " . $medidor->getConstante() . ")";

        $this->mysqli->query($sql) or die("Error " . $sql . mysqli_error($mysqli));
        $medidor->setId( $this->mysqli->insert_id );
        
        return $medidor;
    }

    public function remove($medidor){
        $sql = "UPDATE medidor SET eliminado = 1
                WHERE id = " . $medidor->getId();
        $this->mysqli->query($sql) or die("Error " . $sql . mysqli_error($mysqli));
        return true;
    }
}

?>