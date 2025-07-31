<?php
require_once('datos/Db.php');

require_once('entidades/control.php');

class ControlDb extends Db{

    public function getOne($id){
        global $mysqli;
        
        $sql = "SELECT c.*
                FROM control AS c
                WHERE c.id = " . $id . "
                LIMIT 1";

        $result = $this->mysqli->query($sql) or die("Error " . $sql . mysqli_error($mysqli));
        $control = new Control( $result->fetch_assoc() );
        $result->free();
        
        return $control;
    }


    public function getAll(){
        
        $sql = "SELECT c.* 
                FROM control AS c
                WHERE c.eliminado = 0 
                ORDER BY c.tipo ASC";

        $result = $this->mysqli->query($sql) or die("Error " . $sql . mysqli_error($mysqli));
        $array = $this->resourceToObjects($result,'Control');
        $result->free();
        
        return $array;
    }


    public function update($control){
        
        $sql = "UPDATE control SET  tipo = '" . $control->getTipo() . "', 
                                    constante = '" . $control->getConstante() . "',
                                    decima = " . $control->getDecima() . "

                WHERE id = " . $control->getId();
        $this->mysqli->query($sql) or die("Error " . $sql . mysqli_error($mysqli));
        
        return $control;
    }


    public function insert($control){
        
        $sql = "INSERT INTO control (tipo, 
                                     constante, 
                                     decima)
                VALUES ( '" . $control->getTipo() . "', 
                          " . $control->getConstante() . ", 
                          " . $control->getDecima() . " )";

        $this->mysqli->query($sql) or die("Error " . $sql . mysqli_error($mysqli));
        $control->setId( $this->mysqli->insert_id );
        
        return $control;
    }


    public function remove($control){
        $sql = "UPDATE control SET eliminado = 1
                WHERE id = " . $control->getId();
        $this->mysqli->query($sql) or die("Error " . $sql . mysqli_error($mysqli));
        return true;
    }
}
?>