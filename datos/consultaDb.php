<?php
/*Clase Datos*/
require_once('datos/Db.php');
/*Clase Entidades*/
require_once('entidades/consulta.php');

class ConsultaDb extends Db{

    public function getOne($id){
        global $mysqli;
        
        $sql = "SELECT c.* 
                FROM consulta AS c
                WHERE c.id = " . $id . "
                LIMIT 1";

        $result = $this->mysqli->query($sql) or die("Error " . $sql . mysqli_error($mysqli));
        $consulta = new Consulta($result->fetch_assoc());
        $result->free();
        
        return $consulta;
    }


    /*Funcion devuelve la ultima consulta insertada*/
    public function getUltimo(){
        global $mysqli;
        
        $sql = "SELECT c.* 
                FROM consulta AS c
                ORDER BY c.id DESC
                LIMIT 1";

        $result = $this->mysqli->query($sql) or die("Error " . $sql . mysqli_error($mysqli));
        $consulta = new Consulta($result->fetch_assoc());
        $result->free();
        
        return $consulta;
    }
    

    /*Funcion devuelve ultima consulta de un equipo (solo consulta). La uso para el reporte sin visitas*/
    public function getUno($id_equipo){
        global $mysqli;
        
        $sql = "SELECT c.* 
                FROM consulta AS c
                WHERE c.id_equipo = " . $id_equipo . "
                AND c.eliminado = 0
                AND c.motivo <> '0'
                ORDER BY c.id DESC
                LIMIT 1";

        $result = $this->mysqli->query($sql) or die("Error " . $sql . mysqli_error($mysqli));
        $consulta = new Consulta($result->fetch_assoc());
        $result->free();
        
        return $consulta;
    }


    public function getAll($id_equipo){
        
        $sql = "SELECT c.* 
                FROM consulta AS c
                WHERE c.id_equipo = ". $id_equipo . "
                AND c.eliminado = 0
                ORDER BY c.id DESC";

        $result = $this->mysqli->query($sql) or die("Error " . $sql . mysqli_error($mysqli));
        $array = $this->resourceToObjects($result,'Consulta');
        $result->free();
        
        return $array;
    }


    /*Funcion devuelve 2 consultas para el reporte*/
    public function getAllrep($id_equipo){
        
        $sql = "SELECT c.* 
                FROM consulta AS c
                WHERE c.id_equipo = ". $id_equipo . "
                AND c.eliminado = 0
                ORDER BY c.id DESC
                LIMIT 2";

        $result = $this->mysqli->query($sql) or die("Error " . $sql . mysqli_error($mysqli));
        $array = $this->resourceToObjects($result,'Consulta');
        $result->free();
        
        return $array;
    }


    /*No esta en uso. Funcion devuelve 2 consultas para el reporte*/ 
    public function getAllaReparar($id_equipo){
        
        $sql = "SELECT c.* 
                FROM consulta AS c
                WHERE c.id_equipo = ". $id_equipo . "
                AND c.eliminado = 0
                ORDER BY c.fecha DESC
                LIMIT 3";

        $result = $this->mysqli->query($sql) or die("Error " . $sql . mysqli_error($mysqli));
        $array = $this->resourceToObjects($result,'Consulta');
        $result->free();
        
        return $array;
    }


   public function getAllTrabajos($fecha_desde, $fecha_hasta){
        global $mysqli;

        $sql = "SELECT c.* 
                FROM consulta AS c
                WHERE c.fecha BETWEEN '" . date($fecha_desde) . "' AND '" . date($fecha_hasta) . "'  
                AND c.eliminado = 0
                AND c.motivo <> '0'
                ORDER BY c.fecha DESC, c.id DESC";

        $result = $this->mysqli->query($sql) or die("Error " . mysqli_error($mysqli));
        $array = $this->resourceToObjects($result,'Consulta');
        $result->free();
        
        return $array;
    }


    public function getAllordenado($id_equipo){
        
        $sql = "SELECT c.* 
                FROM consulta AS c
                WHERE c.id_equipo = ". $id_equipo . "
                AND c.eliminado = 0
                ORDER BY c.id DESC";

        $result = $this->mysqli->query($sql) or die("Error " . $sql . mysqli_error($mysqli));
        $array = $this->resourceToObjects($result,'Consulta');
        $result->free();
        
        return $array;
    }


    /*Funcion devuelve ultima consulta de un equipo (sea consulta o problema)*/
   public function getAllordenadoUna($id_equipo){
        
        $sql = "SELECT c.*
                FROM consulta AS c
                WHERE c.id_equipo = ". $id_equipo . "
                AND c.eliminado = 0
                ORDER BY c.id DESC
                LIMIT 1";

        $result = $this->mysqli->query($sql) or die("Error " . $sql . mysqli_error($mysqli));
        if($result->num_rows > 0){
          $consulta = new Consulta( $result->fetch_assoc() );
          $result->free();
          return $consulta;
        }else{
          return false;
        }
    }


   public function getAllordenadoCuatro($id_equipo){
        
        $sql = "SELECT c.*
                FROM consulta AS c
                WHERE c.id_equipo = ". $id_equipo . "
                AND c.eliminado = 0
                ORDER BY c.id DESC
                LIMIT 4";

        $result = $this->mysqli->query($sql) or die("Error " . $sql . mysqli_error($mysqli));
        $array = $this->resourceToObjects($result,'Consulta');
        $result->free();
        
        return $array;
    }


    public function update($consulta){
        
        $sql = "UPDATE  consulta SET 
                        id_administrador = " . $consulta->getIdAdministrador() . ",
                        id_control = " . $consulta->getIdControl() . ",
                        id_tv = " . $consulta->getIdTv() . ",
                        id_ti = " . $consulta->getIdTi() . ",
                        id_medidor = " . $consulta->getIdMedidor() . ",
                        id_medidor_respaldo = " . $consulta->getIdMedidorRespaldo() . ",                        
                        id_medidor_ret = " . $consulta->getIdMedidorRet() . ",
                        motivo = '" . $consulta->getMotivo() . "',
                        fecha = '" . $consulta->getFecha() . "',
                        curva = " . $consulta->getCurva() . ",            
                        descripcion = '". $consulta->getDescripcion() ."', 
                        inspector = '". $consulta->getInspector() ."',
                        ayudante = '". $consulta->getAyudante() ."',
                        leido = '" . $consulta->getLeido() . "',
                        leido2 = '" . $consulta->getLeido2() . "',
                        leido3 = '" . $consulta->getLeido3() . "',
                        leido4 = '" . $consulta->getLeido4() . "',
                        leido5 = '" . $consulta->getLeido5() . "',
                        respaldo = '" . $consulta->getRespaldo() . "',
                        funciona = " . $consulta->getFunciona() . ",                    
                        nro_medidor = " . $consulta->getNroMedidor() . ",
                        nro_medidor_respaldo = " . $consulta->getNroMedidorRespaldo() . ",
                        nro_medidor_ret = " . $consulta->getNroMedidorRet() . ",
                        relacion_ti = '" . $consulta->getRelacionTi() . "',
                        telemedicion = " . $consulta->getTelemedicion() . ", 
                        retirado = " . $consulta->getRetirado() . ",
                        potencia = " . $consulta->getPotencia() . ",
                        nro_ti_r = ". $consulta->getNroTiR() .",
                        nro_ti_s = ". $consulta->getNroTiS() .",
                        nro_ti_t = ". $consulta->getNroTiT() .",
                        nro_control_r = ". $consulta->getNroControlR() .",
                        nro_control_s = ". $consulta->getNroControlS() .",
                        nro_control_t = ". $consulta->getNroControlT() .",
                        media_tension = ". $consulta->getMediaTension() .",
                        cabina = " . $consulta->getCabina() .",
                        nro_tv_r = ". $consulta->getNroTvR() .",
                        nro_tv_s = ". $consulta->getNroTvS() .",
                        nro_tv_t = ". $consulta->getNroTvT() .",
                        precintos = '" . $consulta->getPrecintos() ."',
                        retiro_respaldo = " . $consulta->getRetiroRespaldo() . "

                WHERE id = " . $consulta->getId() . " ";

        $this->mysqli->query($sql) or die("Error " . $sql . mysqli_error($mysqli));
        
        return $consulta;
    }


    public function removeLectura($id_consulta, $fisico){

        if($fisico)
        {
        $sql = "DELETE FROM lectura
                WHERE id_consulta = " . $id_consulta . " ";
        } else{
        $sql = "UPDATE lectura SET eliminado = 1
                WHERE id_consulta = " . $id_consulta . " ";
        }
        $this->mysqli->query($sql) or die("Error " . $sql . mysqli_error($mysqli));
        return true;
    }


    public function insert($consulta){
        
        $sql = "INSERT INTO consulta (id_equipo,
                                      id_administrador,
                                      id_control,
                                      id_tv,
                                      id_ti,
                                      id_medidor,
                                      id_medidor_respaldo,
                                      id_medidor_ret,
                                      curva,
                                      fecha,
                                      motivo,
                                      descripcion,
                                      inspector,
                                      ayudante,
                                      leido,
                                      leido2,
                                      leido3,
                                      leido4,
                                      leido5,
                                      respaldo,
                                      funciona,
                                      nro_medidor,
                                      nro_medidor_respaldo,
                                      nro_medidor_ret, 
                                      relacion_ti,
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
                                      precintos,
                                      retiro_respaldo)

                VALUES ( " . $consulta->getIdEquipo() . ", 
                         " . $consulta->getIdAdministrador() . ",
                         " . $consulta->getIdControl() . ",
                         " . $consulta->getIdTv() . ",
                         " . $consulta->getIdTi() . ",
                         " . $consulta->getIdMedidor() . ",
                         " . $consulta->getIdMedidorRespaldo() . ",
                         " . $consulta->getIdMedidorRet() . ",
                         " . $consulta->getCurva() . ", 
                        '" . $consulta->getFecha() . "',
                        '" . $consulta->getMotivo() . "',
                        '" . $consulta->getDescripcion() . "',
                        '" . $consulta->getInspector() . "',
                        '" . $consulta->getAyudante() . "',
                         " . $consulta->getLeido() . ",
                         " . $consulta->getLeido2() . ",
                         " . $consulta->getLeido3() . ",
                         " . $consulta->getLeido4() . ",
                         " . $consulta->getLeido5() . ",
                         " . $consulta->getRespaldo() . ",
                         " . $consulta->getFunciona() . ",
                         " . $consulta->getNroMedidor() . ",
                         " . $consulta->getNroMedidorRespaldo() . ",
                         " . $consulta->getNroMedidorRet() . ",
                        '" . $consulta->getRelacionTi() . "',
                         " . $consulta->getTelemedicion() . ",
                         " . $consulta->getRetirado() . ",
                         " . $consulta->getPotencia() . ",
                         " . $consulta->getNroTiR() .",
                         " . $consulta->getNroTiS() .",
                         " . $consulta->getNroTiT() .",
                         " . $consulta->getNroControlR() .",
                         " . $consulta->getNroControlS() .",
                         " . $consulta->getNroControlT() .",
                         " . $consulta->getMediaTension() .",
                         " . $consulta->getCabina() .", 
                         " . $consulta->getNroTvR() .",
                         " . $consulta->getNroTvS() .",
                         " . $consulta->getNroTvT() .",
                        '" . $consulta->getPrecintos() ."',
                         " . $consulta->getRetiroRespaldo() . " )";
                

        $this->mysqli->query($sql) or die("Error " . $sql . mysqli_error($mysqli));
        $consulta->setId( $this->mysqli->insert_id );
        
        return $consulta;
      }


    /*No esta en uso*/
    public function insertLectura($lectura, $id_consulta){

        $sql = "INSERT INTO lectura (     id_consulta,
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
                VALUES ( " . $id_consulta . ",
                         '" . $lectura['cuatro'] . "', 
                         '" . $lectura['cinco'] . "', 
                         '" . $lectura['seis'] . "', 
                         '" . $lectura['nueve'] . "', 
                         '" . $lectura['dies'] . "', 
                         '" . $lectura['trece'] . "', 
                         '" . $lectura['catorce'] . "', 
                         '" . $lectura['dieciseis'] . "', 
                         '" . $lectura['diecinueve'] . "', 
                         '" . $lectura['erre'] . "', 
                         '" . $lectura['ese'] . "', 
                         '" . $lectura['te'] . "', 
                         '" . $lectura['treintaycuatro'] . "', 
                         '" . $lectura['treintaycinco'] . "', 
                         '" . $lectura['treintayseis'] . "', 
                         '" . $lectura['treintaysiete'] . "', 
                         '" . $lectura['treintaynueve'] . "', 
                         '" . $lectura['cuarenta'] . "', 
                         '" . $lectura['cuarentayuno'] . "', 
                         '" . $lectura['cuarentaytres'] . "', 
                         '" . $lectura['cuarentaycuatro'] . "', 
                         '" . $lectura['cuarentaycinco'] . "', 
                         '" . $lectura['cuarentayseis'] . "' )";

        $this->mysqli->query($sql) or die("Error " . $sql . mysqli_error($mysqli));
        
        return true;
    }


    public function remove($consulta){
        $sql = "UPDATE consulta SET eliminado = 1
                WHERE id = " . $consulta->getId();
        $this->mysqli->query($sql) or die("Error " . $sql . mysqli_error($mysqli));
        
        return true;
    }
}
?>