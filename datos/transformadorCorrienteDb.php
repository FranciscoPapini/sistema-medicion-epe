<?php
require_once('datos/Db.php');

require_once('entidades/transformadorCorriente.php');

class TransformadorCorrienteDb extends Db{

    public function getOne($id){
        global $mysqli;
        
        $sql = "SELECT ti.*
                FROM transformadorCorriente AS ti
                WHERE ti.id = " . $id . "
                LIMIT 1";

        $result = $this->mysqli->query($sql) or die("Error " . $sql . mysqli_error($mysqli));
        $ti = new TransformadorCorriente( $result->fetch_assoc() );
        $result->free();
        
        return $ti;
    }


    public function getAll(){
        
        $sql = "SELECT ti.* 
                FROM transformadorCorriente AS ti
                WHERE ti.eliminado = 0 
                ORDER BY ti.tipo ASC";

        $result = $this->mysqli->query($sql) or die("Error " . $sql . mysqli_error($mysqli));
        $array = $this->resourceToObjects($result,'TransformadorCorriente');
        $result->free();
        
        return $array;
    }


    public function update($ti){
        
        $sql = "UPDATE transformadorCorriente SET  tipo = '" . $ti->getTipo() . "', 
                                                   clase = '" . $ti->getClase() . "',
                                                   prestacion = '" . $ti->getPrestacion() . "'

                WHERE id = " . $ti->getId();
        $this->mysqli->query($sql) or die("Error " . $sql . mysqli_error($mysqli));
        
        return $ti;
    }


    public function insert($ti){
        
        $sql = "INSERT INTO transformadorCorriente (tipo, 
                                                    clase,
                                                    prestacion)
                VALUES ( '" . $ti->getTipo() . "', 
                         '" . $ti->getClase() . "',
                         '" . $ti->getPrestacion() . "' )";

        $this->mysqli->query($sql) or die("Error " . $sql . mysqli_error($mysqli));
        $ti->setId( $this->mysqli->insert_id );
        
        return $ti;
    }


    public function remove($ti){
        $sql = "UPDATE transformadorCorriente SET eliminado = 1
                WHERE id = " . $ti->getId();
        $this->mysqli->query($sql) or die("Error " . $sql . mysqli_error($mysqli));
        return true;
    }
}

?>