<?php

class Consulta{

	private $id;

	public function getId(){
		return $this->id;
	}

	public function setId($id){
		$this->id = $id;

	}


	private $id_equipo;

	public function getIdEquipo(){
		return $this->id_equipo;
	}

	public function setIdEquipo($id_equipo){
		$this->id_equipo = $id_equipo;
	}


	private $id_administrador;

	public function getIdAdministrador(){
		return $this->id_administrador;
	}

	public function setIdAdministrador($id_administrador){
		$this->id_administrador = $id_administrador;
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


	private $id_medidor_ret;

	public function getIdMedidorRet(){
		return $this->id_medidor_ret;
	}

	public function setIdMedidorRet($id_medidor_ret){
		$this->id_medidor_ret = $id_medidor_ret;
	}


	private $curva;

	public function getCurva(){
		return $this->curva;
	}

	public function setCurva($curva){
		$this->curva = $curva;
	}	


	private $fecha;

	public function getFecha(){
		return $this->fecha;
	}

	public function setFecha($fecha){
		$this->fecha = $fecha;
	}


	private $motivo;

	public function getMotivo(){
		return $this->motivo;
	}

	public function setMotivo($motivo){
		$this->motivo = $motivo;
	}


	private $descripcion;

	public function getDescripcion(){
		return $this->descripcion;
	}

	public function setDescripcion($descripcion){
		$this->descripcion = $descripcion;

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


	private $leido; //de lectura visual a medidor de equipo

	public function getLeido(){
		return $this->leido;
	}

	public function setLeido($leido){
		$this->leido = $leido;

	}


	private $leido2; //si se retiro medidor se puede tomar lectura

	public function getLeido2(){
		return $this->leido2;
	}

	public function setLeido2($leido2){
		$this->leido2 = $leido2;

	}


	private $leido3; //si se tomo lectura a medidor retirado

	public function getLeido3(){
		return $this->leido3;
	}

	public function setLeido3($leido3){
		$this->leido3 = $leido3;

	}


	private $leido4; //si se reseteo el medidor se puede tomar curva

	public function getLeido4(){
		return $this->leido4;
	}

	public function setLeido4($leido4){
		$this->leido4 = $leido4;

	}


	private $leido5; //si se tomo lectura a medidor de respaldo

	public function getLeido5(){
		return $this->leido5;
	}

	public function setLeido5($leido5){
		$this->leido5 = $leido5;

	}


	private $respaldo;

	public function getRespaldo(){
		return $this->respaldo;
	}

	public function setRespaldo($respaldo){
		$this->respaldo = $respaldo;

	}


	private $funciona;

	public function getFunciona(){
		return $this->funciona;
	}

	public function setFunciona($funciona){
		$this->funciona = $funciona;

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


	private $nro_medidor_ret;

	public function getNroMedidorRet(){
		return $this->nro_medidor_ret;
	}

	public function setNroMedidorRet($nro_medidor_ret){
		$this->nro_medidor_ret = $nro_medidor_ret;
	}


	private $relacion_ti;

	public function getRelacionTi(){
		return $this->relacion_ti;
	}

	public function setRelacionTi($relacion_ti){
		$this->relacion_ti = $relacion_ti;
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

	
	private $tipo_tv;

	public function getTipoTv(){
		return $this->tipo_tv;
	}

	public function setTipoTv($tipo_tv){
		$this->tipo_tv = $tipo_tv;
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


	private $precintos;

	public function getPrecintos(){
		return $this->precintos;
	}

	public function setPrecintos($precintos){
		$this->precintos = $precintos;
	}


	private $retiro_respaldo;

	public function getRetiroRespaldo(){
		return $this->retiro_respaldo;
	}

	public function setRetiroRespaldo($retiro_respaldo){
		$this->retiro_respaldo = $retiro_respaldo;
	}


	public function __construct($array = null){
		if($array){
			if($array['id']){
				$this->setId($array['id']);
			}
			$this->setIdEquipo($array['id_equipo']);
			$this->setIdAdministrador($array['id_administrador']);
			$this->setIdControl($array['id_control']);
	        $this->setIdTv($array['id_tv']);    	
	        $this->setIdTi($array['id_ti']);    	
	        $this->setIdMedidor($array['id_medidor']);    	
	        $this->setIdMedidorRespaldo($array['id_medidor_respaldo']);    	
	        $this->setIdMedidorRet($array['id_medidor_ret']);    	
			$this->setFecha($array['fecha']);
        	$auxx = ($array['motivo'])? $array['motivo'] : 0;
			$this->setMotivo($auxx);
			$aux = ($array['descripcion'])? $array['descripcion'] : 0;
			$this->setDescripcion($aux);
			$aux2 = ($array['inspector'])? $array['inspector'] : 0;
			$this->setInspector($aux2);
			$ayu = ($array['ayudante'])? $array['ayudante'] : 0;
			$this->setAyudante($ayu);
			$this->setLeido(($array['leido'] == ('on' || 1))? 1 : 0);
			$this->setLeido2(($array['leido2'] == ('on' || 1))? 1 : 0);
			$this->setLeido3(($array['leido3'] == ('on' || 1))? 1 : 0);
			$this->setLeido4(($array['leido4'] == ('on' || 1))? 1 : 0);
			$this->setLeido5(($array['leido5'] == ('on' || 1))? 1 : 0);
			$this->setRespaldo(($array['respaldo'] == ('on' || 1))? 1 : 0);
			$this->setFunciona(($array['funciona'] == ('on' || 1))? 1 : 0);
        	$aux78 = ($array['nro_medidor_ret'])? $array['nro_medidor_ret'] : 0;
			$this->setNroMedidorRet($aux78);
		    $aux3 = ($array['nro_medidor'])? $array['nro_medidor'] : 0;
			$this->setNroMedidor($aux3);
		    $aux111 = ($array['nro_medidor_respaldo'])? $array['nro_medidor_respaldo'] : 0;
			$this->setNroMedidorRespaldo($aux111);
		    $aux4 = ($array['relacion_ti'])? $array['relacion_ti'] : 0;
			$this->setRelacionTi($aux4);
			$this->setTelemedicion(($array['telemedicion'] == ('on' || 1))? 1 : 0);
			$this->setRetirado(($array['retirado'] == ('on' || 1))? 1 : 0);
			$this->setFunciona($array['funciona']);
			$this->setCurva(($array['curva'] == ('on' || 1))? 1 : 0);
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
	        $aux24 = ($array['nro_tv_r'])? $array['nro_tv_r'] : 0;
			$this->setNroTvR($aux24);
	        $aux25 = ($array['nro_tv_s'])? $array['nro_tv_s'] : 0;
			$this->setNroTvS($aux25);
	        $aux26 = ($array['nro_tv_t'])? $array['nro_tv_t'] : 0;
			$this->setNroTvT($aux26);
	        $aux27 = ($array['precintos'])? $array['precintos'] : 0;
			$this->setPrecintos($aux27);
			$this->setRetiroRespaldo(($array['retiro_respaldo'] == ('on' || 1))? 1 : 0);
		}
	}

}
?>