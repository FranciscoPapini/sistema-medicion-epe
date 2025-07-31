<?php

class Equipo{

	private $id;

	public function getId(){
		return $this->id;
	}

	public function setId($id){
		$this->id = $id;
	}


	private $id_control;

	public function getIdControl(){
		return $this->id_control;
	}

	public function setIdControl($id_control){
		$this->id_control = $id_control;
	}	


	private $id_tv;

	public function getIdTv(){
		return $this->id_tv;
	}

	public function setIdTv($id_tv){
		$this->id_tv = $id_tv;
	}	


	private $id_ti;

	public function getIdTi(){
		return $this->id_ti;
	}

	public function setIdTi($id_ti){
		$this->id_ti = $id_ti;
	}


	private $id_medidor;

	public function getIdMedidor(){
		return $this->id_medidor;
	}

	public function setIdMedidor($id_medidor){
		$this->id_medidor = $id_medidor;
	}


	private $id_medidor_respaldo;

	public function getIdMedidorRespaldo(){
		return $this->id_medidor_respaldo;
	}

	public function setIdMedidorRespaldo($id_medidor_respaldo){
		$this->id_medidor_respaldo = $id_medidor_respaldo;
	}


	private $usuario;

	public function getUsuario(){
		return $this->usuario;
	}

	public function setUsuario($usuario){
		$this->usuario = $usuario;
	}	


	private $folio;

	public function getFolio(){
		return $this->folio;
	}

	public function setFolio($folio){
		$this->folio = $folio;
	}	


	private $direccion;

	public function getDireccion(){
		return $this->direccion;
	}

	public function setDireccion($direccion){
		$this->direccion = $direccion;
	}	


	private $ruta;

	public function getRuta(){
		return $this->ruta;
	}

	public function setRuta($ruta){
		$this->ruta = $ruta;
	}


	private $nro_medidor;

	public function getNroMedidor(){
		return $this->nro_medidor;
	}

	public function setNroMedidor($nro_medidor){
		$this->nro_medidor = $nro_medidor;
	}


	private $nro_medidor_respaldo;

	public function getNroMedidorRespaldo(){
		return $this->nro_medidor_respaldo;
	}

	public function setNroMedidorRespaldo($nro_medidor_respaldo){
		$this->nro_medidor_respaldo = $nro_medidor_respaldo;
	}


	private $relacion_ti;

	public function getRelacionTi(){
		return $this->relacion_ti;
	}

	public function setRelacionTi($relacion_ti){
		$this->relacion_ti = $relacion_ti;
	}


	private $alta;

	public function getAlta(){
		return $this->alta;
	}

	public function setAlta($alta){
		$this->alta = $alta;
	}


	private $localidad;

	public function getLocalidad(){
		return $this->localidad;
	}

	public function setLocalidad($localidad){
		$this->localidad = $localidad;
	}	


	private $observacion;

	public function getObservacion(){
		return $this->observacion;
	}

	public function setObservacion($observacion){
		$this->observacion = $observacion;
	}	


	private $telemedicion;

	public function getTelemedicion(){
		return $this->telemedicion;
	}

	public function setTelemedicion($telemedicion){
		$this->telemedicion = $telemedicion;
	}


	private $retirado;

	public function getRetirado(){
		return $this->retirado;
	}

	public function setRetirado($retirado){
		$this->retirado = $retirado;
	}


	private $potencia;

	public function getPotencia(){
		return $this->potencia;
	}

	public function setPotencia($potencia){
		$this->potencia = $potencia;
	}


	private $tipo_ti;

	public function getTipoTi(){
		return $this->tipo_ti;
	}

	public function setTipoTi($tipo_ti){
		$this->tipo_ti = $tipo_ti;
	}


	private $nro_ti_r;

	public function getNroTiR(){
		return $this->nro_ti_r;
	}

	public function setNroTiR($nro_ti_r){
		$this->nro_ti_r = $nro_ti_r;
	}

	
	private $nro_ti_s;

	public function getNroTiS(){
		return $this->nro_ti_s;
	}

	public function setNroTiS($nro_ti_s){
		$this->nro_ti_s = $nro_ti_s;
	}

	
	private $nro_ti_t;

	public function getNroTiT(){
		return $this->nro_ti_t;
	}

	public function setNroTiT($nro_ti_t){
		$this->nro_ti_t = $nro_ti_t;
	}


	private $nro_control_r;

	public function getNroControlR(){
		return $this->nro_control_r;
	}

	public function setNroControlR($nro_control_r){
		$this->nro_control_r = $nro_control_r;
	}


	private $nro_control_s;

	public function getNroControlS(){
		return $this->nro_control_s;
	}

	public function setNroControlS($nro_control_s){
		$this->nro_control_s = $nro_control_s;
	}


	private $nro_control_t;

	public function getNroControlT(){
		return $this->nro_control_t;
	}

	public function setNroControlT($nro_control_t){
		$this->nro_control_t = $nro_control_t;
	}


	private $media_tension;

	public function getMediaTension(){
		return $this->media_tension;
	}

	public function setMediaTension($media_tension){
		$this->media_tension = $media_tension;
	}


	private $cabina;

	public function getCabina(){
		return $this->cabina;
	}

	public function setCabina($cabina){
		$this->cabina = $cabina;
	}


	private $nro_tv_r;

	public function getNroTvR(){
		return $this->nro_tv_r;
	}

	public function setNroTvR($nro_tv_r){
		$this->nro_tv_r = $nro_tv_r;
	}

	
	private $nro_tv_s;

	public function getNroTvS(){
		return $this->nro_tv_s;
	}

	public function setNroTvS($nro_tv_s){
		$this->nro_tv_s = $nro_tv_s;
	}

	
	private $nro_tv_t;

	public function getNroTvT(){
		return $this->nro_tv_t;
	}

	public function setNroTvT($nro_tv_t){
		$this->nro_tv_t = $nro_tv_t;
	}


	private $latitud;

	public function getLatitud(){
		return $this->latitud;
	}

	public function setLatitud($latitud){
		$this->latitud = $latitud;
	}


	private $longitud;

	public function getLongitud(){
		return $this->longitud;
	}

	public function setLongitud($longitud){
		$this->longitud = $longitud;
	}


	private $respaldo;

	public function getRespaldo(){
		return $this->respaldo;
	}

	public function setRespaldo($respaldo){
		$this->respaldo = $respaldo;
	}


    public function __construct($array = null){
        if ($array['id']) {
        	$this->setId($array['id']);
        }
        $this->setUsuario($array['usuario']);
        $this->setIdControl($array['id_control']);
        $this->setIdTv($array['id_tv']);
        $this->setIdTi($array['id_ti']);    	
	    $this->setIdMedidor($array['id_medidor']);    	
	    $this->setIdMedidorRespaldo($array['id_medidor_respaldo']);

        $aux = ($array['folio'])? $array['folio'] : 0;
		$this->setFolio($aux);
        $aux2 = ($array['ruta'])? $array['ruta'] : 0;
		$this->setRuta($aux2);
        $auu = ($array['direccion'])? $array['direccion'] : 0;
		$this->setDireccion($auu);
	    $aux3 = ($array['nro_medidor'])? $array['nro_medidor'] : 0;
		$this->setNroMedidor($aux3);
	    $aux4 = ($array['relacion_ti'])? $array['relacion_ti'] : 0;
		$this->setRelacionTi($aux4);
	    $this->setAlta($array['alta']);        
        $aux6 = ($array['localidad'])? $array['localidad'] : 0;
		$this->setLocalidad($aux6);
        $aux5 = ($array['observacion'])? $array['observacion'] : 0;
		$this->setObservacion($aux5);
		$this->setTelemedicion(($array['telemedicion'] == ('on' || 1))? 1 : 0);
		$this->setRetirado(($array['retirado'] == ('on' || 1))? 1 : 0);
        $aux10 = ($array['potencia'])? $array['potencia'] : 0;
		$this->setPotencia($aux10);
        $aux12 = ($array['nro_ti_r'])? $array['nro_ti_r'] : 0;
		$this->setNroTiR($aux12);
        $aux13 = ($array['nro_ti_s'])? $array['nro_ti_s'] : 0;
		$this->setNroTiS($aux13);
        $aux14 = ($array['nro_ti_t'])? $array['nro_ti_t'] : 0;
		$this->setNroTiT($aux14);
        $aux15 = ($array['nro_control_r'])? $array['nro_control_r'] : 0;
		$this->setNroControlR($aux15);
        $aux16 = ($array['nro_control_s'])? $array['nro_control_s'] : 0;
		$this->setNroControlS($aux16);
        $aux17 = ($array['nro_control_t'])? $array['nro_control_t'] : 0;
		$this->setNroControlT($aux17);
		$this->setMediaTension(($array['media_tension'] == ('on' || 1))? 1 : 0);
        $aux20 = ($array['cabina'])? $array['cabina'] : 0;
		$this->setCabina($aux20);      
        $aux21 = ($array['latitud'])? $array['latitud'] : 0;
		$this->setLatitud($aux21);
        $aux22 = ($array['longitud'])? $array['longitud'] : 0;
		$this->setLongitud($aux22);
        $aux24 = ($array['nro_tv_r'])? $array['nro_tv_r'] : 0;
		$this->setNroTvR($aux24);
        $aux25 = ($array['nro_tv_s'])? $array['nro_tv_s'] : 0;
		$this->setNroTvS($aux25);
        $aux26 = ($array['nro_tv_t'])? $array['nro_tv_t'] : 0;
		$this->setNroTvT($aux26);

	    $aux27 = ($array['nro_medidor_respaldo'])? $array['nro_medidor_respaldo'] : 0;
		$this->setNroMedidorRespaldo($aux27);
		$this->setRespaldo(($array['respaldo'] == ('on' || 1))? 1 : 0);

    	}	   	
}
?>