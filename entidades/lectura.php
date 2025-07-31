<?php

class Lectura{

	private $id;

	public function getId(){
		return $this->id;
	}

	public function setId($id){
		$this->id = $id;
	}


	private $id_consulta;

	public function getIdConsulta(){
		return $this->id_consulta;
	}

	public function setIdConsulta($id_consulta){
		$this->id_consulta = $id_consulta;
	}


	private $retiro;

	public function getRetiro(){
		return $this->retiro;
	}

	public function setRetiro($retiro){
		$this->retiro = $retiro;
	}


	private $cuatro;

	public function getCuatro(){
		return $this->cuatro;
	}

	public function setCuatro($cuatro){
		$this->cuatro = $cuatro;
	}	


	private $cinco;

	public function getCinco(){
		return $this->cinco;
	}

	public function setCinco($cinco){
		$this->cinco = $cinco;
	}


	private $seis;

	public function getSeis(){
		return $this->seis;
	}

	public function setSeis($seis){
		$this->seis = $seis;
	}


	private $nueve;

	public function getNueve(){
		return $this->nueve;
	}

	public function setNueve($nueve){
		$this->nueve = $nueve;
	}


	private $dies;

	public function getDies(){
		return $this->dies;
	}

	public function setDies($dies){
		$this->dies = $dies;
	}


	private $trece;

	public function getTrece(){
		return $this->trece;
	}

	public function setTrece($trece){
		$this->trece = $trece;
	}


	private $catorce;

	public function getCatorce(){
		return $this->catorce;
	}

	public function setCatorce($catorce){
		$this->catorce = $catorce;
	}


	private $dieciseis;

	public function getDieciseis(){
		return $this->dieciseis;
	}

	public function setDieciseis($dieciseis){
		$this->dieciseis = $dieciseis;
	}	


	private $diecinueve;

	public function getDiecinueve(){
		return $this->diecinueve;
	}

	public function setDiecinueve($diecinueve){
		$this->diecinueve = $diecinueve;
	}	


	private $erre;

	public function getErre(){
		return $this->erre;
	}

	public function setErre($erre){
		$this->erre = $erre;
	}


	private $ese;

	public function getEse(){
		return $this->ese;
	}

	public function setEse($ese){
		$this->ese = $ese;
	}


	private $te;

	public function getTe(){
		return $this->te;
	}

	public function setTe($te){
		$this->te = $te;
	}


	private $treintaycuatro;

	public function getTreintaycuatro(){
		return $this->treintaycuatro;
	}

	public function setTreintaycuatro($treintaycuatro){
		$this->treintaycuatro = $treintaycuatro;
	}


	private $treintaycinco;

	public function getTreintaycinco(){
		return $this->treintaycinco;
	}

	public function setTreintaycinco($treintaycinco){
		$this->treintaycinco = $treintaycinco;
	}


	private $treintayseis;

	public function getTreintayseis(){
		return $this->treintayseis;
	}

	public function setTreintayseis($treintayseis){
		$this->treintayseis = $treintayseis;
	}


	private $treintaysiete;

	public function getTreintaysiete(){
		return $this->treintaysiete;
	}

	public function setTreintaysiete($treintaysiete){
		$this->treintaysiete = $treintaysiete;
	}


	private $treintaynueve;

	public function getTreintaynueve(){
		return $this->treintaynueve;
	}

	public function setTreintaynueve($treintaynueve){
		$this->treintaynueve = $treintaynueve;
	}


	private $cuarenta;

	public function getCuarenta(){
		return $this->cuarenta;
	}

	public function setCuarenta($cuarenta){
		$this->cuarenta = $cuarenta;
	}


	private $cuarentayuno;

	public function getCuarentayuno(){
		return $this->cuarentayuno;
	}

	public function setCuarentayuno($cuarentayuno){
		$this->cuarentayuno = $cuarentayuno;
	}


	private $cuarentaytres;

	public function getCuarentaytres(){
		return $this->cuarentaytres;
	}

	public function setCuarentaytres($cuarentaytres){
		$this->cuarentaytres = $cuarentaytres;
	}


	private $cuarentaycuatro;

	public function getCuarentaycuatro(){
		return $this->cuarentaycuatro;
	}

	public function setCuarentaycuatro($cuarentaycuatro){
		$this->cuarentaycuatro = $cuarentaycuatro;
	}
	

	private $cuarentaycinco;

	public function getCuarentaycinco(){
		return $this->cuarentaycinco;
	}

	public function setCuarentaycinco($cuarentaycinco){
		$this->cuarentaycinco = $cuarentaycinco;
	}


	private $cuarentayseis;

	public function getCuarentayseis(){
		return $this->cuarentayseis;
	}

	public function setCuarentayseis($cuarentayseis){
		$this->cuarentayseis = $cuarentayseis;
	}

	
    public function __construct($array = null){
        if ($array['id']) {
        	$this->setId($array['id']);
        }
	    $this->setIdConsulta($array['id_consulta']);
		$this->setRetiro($array['retiro']);
		$this->setCuatro($array['cuatro']);
		$this->setCinco($array['cinco']);
		$this->setSeis($array['seis']);
		$this->setNueve($array['nueve']);
		$this->setDies($array['dies']);
		$this->setTrece($array['trece']);
		$this->setCatorce($array['catorce']);
		$this->setDieciseis($array['dieciseis']);
		$this->setDiecinueve($array['diecinueve']);
		$this->setErre($array['erre']);
		$this->setEse($array['ese']);
		$this->setTe($array['te']);
		$this->setTreintaycuatro($array['treintaycuatro']);
	    $this->setTreintaycinco($array['treintaycinco']);
	    $this->setTreintayseis($array['treintayseis']);
	    $this->setTreintaysiete($array['treintaysiete']);
	    $this->setTreintaynueve($array['treintaynueve']);
	    $this->setCuarenta($array['cuarenta']);
	    $this->setCuarentayuno($array['cuarentayuno']);
	    $this->setCuarentaytres($array['cuarentaytres']);
	    $this->setCuarentaycuatro($array['cuarentaycuatro']);
	    $this->setCuarentaycinco($array['cuarentaycinco']);
		$this->setCuarentayseis($array['cuarentayseis']);
    	}	   	
}
?>