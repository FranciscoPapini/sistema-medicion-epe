<?php
require_once('datos/Db.php');

require_once('entidades/informe.php');

class InformeDb extends Db{

    public function getOne($id){
        global $mysqli;
        
        $sql = "SELECT i.*
                FROM informe AS i
                WHERE i.id = " . $id . "
                LIMIT 1";

        $result = $this->mysqli->query($sql) or die("Error " . mysqli_error($mysqli));
        
        $informe = new Informe( $result->fetch_assoc() );
        $result->free();
        
        return $informe;
    }

    public function getAll(){
        
        $sql = "SELECT i.* 
                FROM informe AS i 
                WHERE i.eliminado = 0
                ORDER BY i.fecha DESC";

        $result = $this->mysqli->query($sql) or die("Error " . mysqli_error($mysqli));
        $array = $this->resourceToObjects($result,'Informe');
        $result->free();
        
        return $array;
    }

    public function update($informe){
        
        $sql = "UPDATE informe SET   
                                    id_administrador = '" . $informe->getIdAdministrador() . "',
                                    tipo = '" . $informe->getTipo() . "',
                                    usuario = '" . $informe->getUsuario() . "',
                                    fecha = '" . $informe->getFecha() . "',
                                    descripcion = '" . $informe->getDescripcion() . "',
                                    direccion = '" . $informe->getDireccion() . "',
                                    localidad = '" . $informe->getlocalidad() . "',
                                    inspector = '" . $informe->getInspector() . "',
                                    ayudante = '" . $informe->getAyudante() . "',
                                    aprobado = " . $informe->getAprobado() . "

                WHERE id = " . $informe->getId();

        $this->mysqli->query($sql) or die("Error " . mysqli_error($mysqli));
        
        return $informe;
    }

    public function insert($informe){
        
        $sql = "INSERT INTO informe (   id_administrador,
                                        tipo,
                                        usuario,
                                        fecha,
                                        descripcion,
                                        direccion,
                                        localidad,
                                        inspector,
                                        ayudante,
                                        aprobado 
                                        )
                VALUES ( " . $informe->getIdAdministrador() . ",
                        '" . $informe->getTipo() . "', 
                        '" . $informe->getUsuario() . "', 
                        '" . $informe->getFecha() . "', 
                        '" . $informe->getDescripcion() . "',
                        '" . $informe->getDireccion() . "', 
                        '" . $informe->getlocalidad() . "',
                        '" . $informe->getInspector() . "',
                        '" . $informe->getAyudante() . "',
                         " . $informe->getAprobado() . " )";

        $this->mysqli->query($sql) or die("Error " . mysqli_error($mysqli));
        $informe->setId( $this->mysqli->insert_id );
        
        return $informe;
    }

    public function remove($informe){

        $sql = "UPDATE informe SET eliminado = 1
                WHERE id = " . $informe->getId();

        $this->mysqli->query($sql) or die("Error " . mysqli_error($mysqli));
        return true;
    }
}
?>