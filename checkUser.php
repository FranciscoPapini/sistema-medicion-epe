<?php
require_once('negocio/administradorNegocio.php');

$administradorNegocio = new AdministradorNegocio();
if( $administradorNegocio->validarUser($_GET['usuario']) ){
	header("HTTP/1.0 200");
}else{
	header("HTTP/1.0 403 El usuario ".$_GET['usuario']." se encuentra en uso");
}
?>
