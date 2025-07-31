<?php

class TransformadorCorriente{

	private $id;

	public function getId(){
		return $this->id;
	}
	
	public function setId($id){
		$this->id = $id;
	}


	private $tipo;

	public function getTipo(){
		return $this->tipo;
	}

	public function setTipo($tipo){
		$this->tipo = $tipo;
	}


	private $clase;

	public function getClase(){
		return $this->clase;
	}

	public function setClase($clase){
		$this->clase = $clase;
	}


	private $prestacion;

	public function getPrestacion(){
		return $this->prestacion;
	}

	public function setPrestacion($prestacion){
		$this->prestacion = $prestacion;
	}


	public function __construct($array = null){
		if($array){
			if($array['id']){
				$this->setId($array['id']);
			}
	    	$this->setTipo($array['tipo']);
	    	$this->setClase($array['clase']);
	    	$this->setPrestacion($array['prestacion']);	    	
    	}
	}	
}
?>