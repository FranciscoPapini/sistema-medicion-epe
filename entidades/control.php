<?php

class Control{

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


	private $constante;

	public function getConstante(){
		return $this->constante;
	}

	public function setConstante($constante){
		$this->constante = $constante;
	}


	private $decima;

	public function getDecima(){
		return $this->decima;
	}

	public function setDecima($decima){
		$this->decima = $decima;
	}

	public function __construct($array = null){
		if($array){
			if($array['id']){
				$this->setId($array['id']);
			}
	    	$this->setTipo($array['tipo']);
	    	$this->setConstante($array['constante']);
	    	$this->setDecima($array['decima']);

    	}
	}	
}
?>