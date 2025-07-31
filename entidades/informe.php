<?php

class Informe{

	private $id;

	public function getId(){
		return $this->id;
	}

	public function setId($id){
		$this->id = $id;
	}


	private $id_administrador;

	public function getIdAdministrador(){
		return $this->id_administrador;
	}

	public function setIdAdministrador($id_administrador){
		$this->id_administrador = $id_administrador;
	}	


	private $tipo;

	public function getTipo(){
		return $this->tipo;
	}

	public function setTipo($tipo){
		$this->tipo = $tipo;
	}


	private $usuario;

	public function getUsuario(){
		return $this->usuario;
	}

	public function setUsuario($usuario){
		$this->usuario = $usuario;
	}


	private $fecha;
 
	public function getFecha(){
		return $this->fecha;
	}

	public function setFecha($fecha){
		$this->fecha = $fecha;
	}

	
	private $descripcion;

	public function getDescripcion(){
		return $this->descripcion;
	}

	public function setDescripcion($descripcion){
		$this->descripcion = $descripcion;
	}

	
	private $direccion;

	public function getDireccion(){
		return $this->direccion;
	}

	public function setDireccion($direccion){
		$this->direccion = $direccion;
	}


	private $localidad;

	public function getLocalidad(){
		return $this->localidad;
	}

	public function setLocalidad($localidad){
		$this->localidad = $localidad;
	}


	private $inspector;

	public function getInspector(){
		return $this->inspector;
	}

	public function setInspector($inspector){
		$this->inspector = $inspector;
	}


	private $ayudante;

	public function getAyudante(){
		return $this->ayudante;
	}

	public function setAyudante($ayudante){
		$this->ayudante = $ayudante;
	}


	private $aprobado;

	public function getAprobado(){
		return $this->aprobado;
	}

	public function setAprobado($aprobado){
		$this->aprobado = $aprobado;
	}


    public function __construct($array = null){
    	if($array['id']){
    		$this->setId($array['id']);
    	}
		$this->setIdAdministrador($array['id_administrador']);
        $this->setTipo($array['tipo']);
        $aux = ($array['usuario'])? $array['usuario'] : 0;
		$this->setUsuario($aux);
        $this->setFecha($array['fecha']);
        $this->setDescripcion($array['descripcion']);
        $this->setDireccion($array['direccion']);	
        $this->setLocalidad($array['localidad']);	
        $this->setInspector($array['inspector']);	
        $this->setAyudante($array['ayudante']);	
		$this->setAprobado(($array['aprobado'] == ('on' || 1))? 1 : 0);
    }
}
?>