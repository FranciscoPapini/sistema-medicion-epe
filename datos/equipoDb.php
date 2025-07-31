<?php
/*Clase Datos*/
require_once('datos/Db.php');
/*Clase Entidades*/
require_once('entidades/equipo.php');

class EquipoDb extends Db{

    public function getOne($id){
        global $mysqli;
        
        $sql = "SELECT e.*
                FROM equipo AS e
                WHERE e.id = " . $id . "
                LIMIT 1";

        $result = $this->mysqli->query($sql) or die("Error " . $sql . mysqli_error($mysqli));
        
        $equipo = new Equipo( $result->fetch_assoc() );
        $result->free();

        return $equipo;

    }


    public function getUno(){
        global $mysqli;
        
        $sql = "SELECT e.*
                FROM equipo AS e
                ORDER BY e.id DESC
                LIMIT 1";

        $result = $this->mysqli->query($sql) or die("Error " . $sql . mysqli_error($mysqli));
        
        $equipo = new Equipo( $result->fetch_assoc() );
        $result->free();

        return $equipo;

    }


    public function getOneUna($id){
        global $mysqli;
        
        $sql = "SELECT e.*
                FROM equipo AS e
                WHERE e.id = " . $id . "
                LIMIT 1";

        $result = $this->mysqli->query($sql) or die("Error " . $sql . mysqli_error($mysqli));
        
        $equipo = new Equipo( $result->fetch_assoc() );
        $result->free();

        return $equipo;

    }


    public function getAllTodos(){
        global $mysqli;

        $sql = "SELECT e.* 
                FROM equipo AS e
                WHERE e.eliminado = 0
                AND e.retirado = 0
                ORDER BY e.usuario DESC";

        $result = $this->mysqli->query($sql) or die("Error " . $sql . mysqli_error($mysqli));
        $array = $this->resourceToObjects($result,'Equipo');
        $result->free();
        
        return $array;
    }


    public function getAllTodosRetirados(){
        global $mysqli;

        $sql = "SELECT e.* 
                FROM equipo AS e
                WHERE e.eliminado = 0
                AND e.retirado = 1
                ORDER BY e.usuario DESC";

        $result = $this->mysqli->query($sql) or die("Error " . $sql . mysqli_error($mysqli));
        $array = $this->resourceToObjects($result,'Equipo');
        $result->free();
        
        return $array;
    }


    public function getAllTodosOrd(){
        global $mysqli;

        $sql = "SELECT e.* 
                FROM equipo AS e
                WHERE e.eliminado = 0 
                AND e.retirado = 0
                ORDER BY e.localidad ASC, e.usuario ASC";

        $result = $this->mysqli->query($sql) or die("Error " . $sql . mysqli_error($mysqli));
        $array = $this->resourceToObjects($result,'Equipo');
        $result->free();
        
        return $array;
    }


    public function getAllTodosExcel(){
        global $mysqli;

        $sql = "SELECT e.* 
                FROM equipo AS e
                WHERE e.eliminado = 0 
                ORDER BY e.localidad ASC, e.usuario ASC";

        $result = $this->mysqli->query($sql) or die("Error " . $sql . mysqli_error($mysqli));
        $array = $this->resourceToObjects($result,'Equipo');
        $result->free();
        
        return $array;
    }

    public function getAllTodosMapa(){
        global $mysqli;

        $sql = "SELECT e.* 
                FROM equipo AS e
                WHERE e.eliminado = 0 
                AND e.retirado = 0
                AND e.latitud <> 0
                AND e.longitud <> 0
                ORDER BY e.usuario ASC";

        $result = $this->mysqli->query($sql) or die("Error " . $sql . mysqli_error($mysqli));
        $array = $this->resourceToObjects($result,'Equipo');
        $result->free();
        
        return $array;
    }


    public function getAllTodosSinCoord(){
        global $mysqli;

        $sql = "SELECT e.* 
                FROM equipo AS e
                WHERE e.eliminado = 0 
                AND e.retirado = 0
                AND e.latitud = 0
                ORDER BY e.usuario DESC";

        $result = $this->mysqli->query($sql) or die("Error " . $sql . mysqli_error($mysqli));
        $array = $this->resourceToObjects($result,'Equipo');
        $result->free();
        
        return $array;
    }


    public function getAllTodosAreparar(){
        global $mysqli;

        $sql = "SELECT e.* 
                FROM equipo AS e
                WHERE e.eliminado = 0 
                AND e.retirado = 0
                ORDER BY e.usuario DESC";


        $result = $this->mysqli->query($sql) or die("Error " . mysqli_error($mysqli));
        $array = $this->resourceToObjects($result,'Equipo');
        $result->free();
        
        return $array;
    }


    public function getAllTodosSinFolio(){
        global $mysqli;

        $sql = "SELECT e.* 
                FROM equipo AS e
                WHERE e.folio = 0
                AND e.retirado = 0
                ORDER BY e.usuario DESC";

        $result = $this->mysqli->query($sql) or die("Error " . $sql . mysqli_error($mysqli));
        $array = $this->resourceToObjects($result,'Equipo');
        $result->free();
        
        return $array;
    }


    public function getAllBuscado($buscador){
        global $mysqli;

        $sql = "SELECT e.* 
                FROM equipo AS e
                WHERE e.usuario LIKE '%".$buscador."%' OR
                e.direccion LIKE '%".$buscador."%' OR
                e.localidad LIKE '%".$buscador."%' OR
                e.folio LIKE '%".$buscador."%' OR
                e.nro_medidor LIKE '%".$buscador."%'
                ORDER BY e.usuario DESC";

        $result = $this->mysqli->query($sql) or die("Error " . $sql . mysqli_error($mysqli));
        $array = $this->resourceToObjects($result,'Equipo');
        $result->free();
        
        return $array;
    }


    public function checkEquipo($ruta, $folio){ // si el equipo fue retirado, puedo ingresar un nuevo equipo con misma ruta y folio por el e.retirado = 0.

        $sql = "SELECT e.*
        FROM equipo AS e
        WHERE e.ruta = " . $ruta . " AND e.folio = " . $folio . "
        AND e.ruta <> 0 AND e.folio <> 0
        AND e.retirado = 0
        AND e.eliminado = 0";
        $result = $this->mysqli->query($sql) or die("Error " . $sql . mysqli_error($mysqli));
        if($result->num_rows > 0){
            return false;
        }
        else{
            return true;
        }   
    }


    public function update($equipo){
        
        $sql = "UPDATE equipo SET   id_control = " . $equipo->getIdControl() . ",
                                    id_tv = " . $equipo->getIdTv() . ",
                                    id_ti = " . $equipo->getIdTi() . ",
                                    id_medidor = " . $equipo->getIdMedidor() . ",
                                    id_medidor_respaldo = " . $equipo->getIdMedidorRespaldo() . ",
                                    usuario = '" . $equipo->getUsuario() . "', 
                                    ruta = " . $equipo->getRuta() . ",
                                    folio = " . $equipo->getFolio() . ",
                                    direccion = '" . $equipo->getDireccion() . "',
                                    nro_medidor = " . $equipo->getNroMedidor() . ",
                                    nro_medidor_respaldo = " . $equipo->getNroMedidorRespaldo() . ",
                                    relacion_ti = '" . $equipo->getRelacionTi() . "',
                                    alta = '" . $equipo->getAlta() . "',
                                    localidad = '" . $equipo->getLocalidad() . "',
                                    observacion = '" . $equipo->getObservacion() . "', 
                                    telemedicion = " . $equipo->getTelemedicion() . ", 
                                    retirado = " . $equipo->getRetirado() . ",
                                    potencia = " . $equipo->getPotencia() . ",
                                    nro_ti_r = ". $equipo->getNroTiR() .",
                                    nro_ti_s = ". $equipo->getNroTiS() .",
                                    nro_ti_t = ". $equipo->getNroTiT() .",
                                    nro_control_r = ". $equipo->getNroControlR() .",
                                    nro_control_s = ". $equipo->getNroControlS() .",
                                    nro_control_t = ". $equipo->getNroControlT() .",
                                    media_tension = ". $equipo->getMediaTension() .",
                                    cabina = " . $equipo->getCabina() .",
                                    nro_tv_r = ". $equipo->getNroTvR() .",
                                    nro_tv_s = ". $equipo->getNroTvS() .",
                                    nro_tv_t = ". $equipo->getNroTvT() .",
                                    latitud = " . $equipo->getLatitud() .",  
                                    longitud = " . $equipo->getLongitud() .",
                                    respaldo = " . $equipo->getRespaldo() ."

                WHERE id = " . $equipo->getId() . " ";

        $this->mysqli->query($sql) or die("Error " . $sql . mysqli_error($mysqli));

        return $equipo;
    }


    public function updateUp($equipo){
        
        $sql = "UPDATE equipo SET   
                                    id_control = " . $equipo->getIdControl() . ",
                                    id_tv = " . $equipo->getIdTv() . ",
                                    id_ti = " . $equipo->getIdTi() . ",
                                    id_medidor = " . $equipo->getIdMedidor() . ",
                                    id_medidor_respaldo = " . $equipo->getIdMedidorRespaldo() . ",
                                    usuario = '" . $equipo->getUsuario() . "',
                                    nro_medidor = " . $equipo->getNroMedidor() . ",
                                    nro_medidor_respaldo = " . $equipo->getNroMedidorRespaldo() . ",
                                    relacion_ti = '" . $equipo->getRelacionTi() . "',
                                    telemedicion = " . $equipo->getTelemedicion() . ", 
                                    retirado = " . $equipo->getRetirado() . ",
                                    potencia = " . $equipo->getPotencia() . ",
                                    nro_ti_r = ". $equipo->getNroTiR() .",
                                    nro_ti_s = ". $equipo->getNroTiS() .",
                                    nro_ti_t = ". $equipo->getNroTiT() .",
                                    nro_control_r = ". $equipo->getNroControlR() .",
                                    nro_control_s = ". $equipo->getNroControlS() .",
                                    nro_control_t = ". $equipo->getNroControlT() .",
                                    media_tension = ". $equipo->getMediaTension() .",
                                    cabina = " . $equipo->getCabina() .",
                                    nro_tv_r = ". $equipo->getNroTvR() .",
                                    nro_tv_s = ". $equipo->getNroTvS() .",
                                    nro_tv_t = ". $equipo->getNroTvT() .",
                                    latitud = " . $equipo->getLatitud() .",  
                                    longitud = " . $equipo->getLongitud() .", 
                                    respaldo = " . $equipo->getRespaldo() ." 

                WHERE id = " . $equipo->getId() . " ";

        $this->mysqli->query($sql) or die("Error " . $sql . mysqli_error($mysqli));

        return $equipo;
    }



public function updateUpp($equipo){
        
        $sql = "UPDATE equipo SET   
                                    usuario = '" . $equipo->getUsuario() . "',
                                    alta = '" . $equipo->getAlta() . "',
                                    ruta = " . $equipo->getRuta() . ",
                                    folio = " . $equipo->getFolio() . ",
                                    direccion = '" . $equipo->getDireccion() . "',
                                    localidad = '" . $equipo->getLocalidad() . "',
                                    retirado = " . $equipo->getRetirado() . ",
                                    latitud = " . $equipo->getLatitud() .",  
                                    longitud = " . $equipo->getLongitud() ."                                     

                WHERE id = " . $equipo->getId() . " ";

        $this->mysqli->query($sql) or die("Error " . $sql . mysqli_error($mysqli));

        return $equipo;
    }


    public function insert($equipo){
        
        $sql = "INSERT INTO equipo ( id_control,
                                     id_tv,
                                     id_ti,
                                     id_medidor,
                                     id_medidor_respaldo,
                                     usuario,
                                     ruta, 
                                     folio,
                                     direccion,
                                     nro_medidor,
                                     nro_medidor_respaldo,
                                     relacion_ti,
                                     alta,
                                     localidad,
                                     observacion,
                                     telemedicion,
                                     retirado,
                                     potencia,
                                     nro_ti_r,
                                     nro_ti_s,
                                     nro_ti_t,
                                     nro_control_r,
                                     nro_control_s,
                                     nro_control_t,
                                     media_tension,
                                     cabina,
                                     nro_tv_r,
                                     nro_tv_s,
                                     nro_tv_t,
                                     latitud,
                                     longitud,
                                     respaldo
                                     )
                VALUES ( " . $equipo->getIdControl() . ",
                         " . $equipo->getIdTv() . ",
                         " . $equipo->getIdTi() . ",
                         " . $equipo->getIdMedidor() . ",
                         " . $equipo->getIdMedidorRespaldo() . ",
                        '" . $equipo->getUsuario() . "',
                         " . $equipo->getRuta() . ", 
                         " . $equipo->getFolio() . ",
                        '" . $equipo->getDireccion() . "',
                         " . $equipo->getNroMedidor() . ",
                         " . $equipo->getNroMedidorRespaldo() . ",
                        '" . $equipo->getRelacionTi() . "',
                        '" . $equipo->getAlta() . "',
                        '" . $equipo->getLocalidad() . "',
                        '" . $equipo->getObservacion() . "',
                         " . $equipo->getTelemedicion() . ",
                         " . $equipo->getRetirado() . ",
                         " . $equipo->getPotencia() . ",
                         " . $equipo->getNroTiR() .",
                         " . $equipo->getNroTiS() .",
                         " . $equipo->getNroTiT() .",
                         " . $equipo->getNroControlR() .",
                         " . $equipo->getNroControlS() .",
                         " . $equipo->getNroControlT() .",
                         " . $equipo->getMediaTension() .",
                         " . $equipo->getCabina() .",
                         " . $equipo->getNroTvR() .",
                         " . $equipo->getNroTvS() .",
                         " . $equipo->getNroTvT() .",
                         " . $equipo->getLatitud() .",
                         " . $equipo->getLongitud() .", 
                         " . $equipo->getRespaldo() ." )";

        $this->mysqli->query($sql) or die("Error " . $sql . mysqli_error($mysqli));
        $equipo->setId( $this->mysqli->insert_id );
        
        return $equipo;
    }


    public function remove($equipo){
        $sql = "UPDATE equipo SET eliminado = 1
                WHERE id = " . $equipo->getId();
        $this->mysqli->query($sql) or die("Error ");
        return true;
    }
}
?>