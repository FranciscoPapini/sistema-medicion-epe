<?php
abstract class Db {

    private $dbhost;
    private $dbuser;
    private $dbpass;
    private $dbname;
    public $mysqli;


    public function __construct() {
        $this->dbhost = "localhost:3306";
        $this->dbuser = "rosario";
        $this->dbpass = "258ruaU$";
        $this->dbname = "laborosa_laboratorio";

        $this->connect();
    }


    protected function connect(){
        $this->mysqli = mysqli_connect($this->dbhost, $this->dbuser, $this->dbpass, $this->dbname) or die("Error " . $sql . mysqli_error($mysqli));
        $this->mysqli->set_charset('utf8');
    }


    //Auxiliares
    protected function resourceToArray($res){
        $array = array();
        while ($row = $res->fetch_assoc()) {
            $array[] = $row;
        }
        return $array;
    }
    
    
    protected function resourceToObjects($res,$class){
        $array = array();
        while ($row = $res->fetch_assoc()) {
            $array[] = new $class($row);
        }
        return $array;
    }
}
?>