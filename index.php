<?php

require_once('negocio/equipoNegocio.php');
require_once('negocio/consultaNegocio.php');

session_start();
error_reporting(E_ALL ^ E_NOTICE);
date_default_timezone_set('America/Argentina/Buenos_Aires');

require_once('util/util.php');

if($_POST['user'] && $_POST['pass']){
   
    require_once('negocio/administradorNegocio.php');
    $administradorNegocio = new AdministradorNegocio();
    $adm = $administradorNegocio->login($_POST['user'], $_POST['pass']);
    if($adm){
        $_SESSION['administrador']['id'] = $adm->getId();
        $_SESSION['administrador']['nombre'] = $adm->getNombre();
        $_SESSION['administrador']['apellido'] = $adm->getApellido();
        $_SESSION['administrador']['usuario'] = $adm->getUsuario();
        $_SESSION['administrador']['email'] = $adm->getEmail();
        header('Location: ?modulo=equipo&accion=buscar');
        die();
    }else{
        Util::setMsj('Usuario o contrase&ntilde;a incorrectos','danger', false);
        header('Location: login.php');
        die();
    }
}elseif($_GET['action'] == 'logout'){
    unset($_SESSION['administrador']);
    unset($_SESSION['buscador']);
    unset($_SESSION['reporteTrabajos']);
    Util::setMsj('Has cerrado sesi&oacute;n','info', false);
    header('Location: login.php');
    die();
}

if($_SESSION['administrador'])

{
    $modulo = $_GET['modulo']? $_GET['modulo'] : 'equipo';
    $accion = $_GET['accion']? $_GET['accion'] : 'buscar';
    
    /*Clase Negocio*/
    require_once('negocio/'.$modulo.'Negocio.php');

    $nombreNegocio = $modulo."Negocio";
    $$nombreNegocio = new $nombreNegocio();

    /*Proceso de formularios*/
    if($_POST){
        switch ($accion) {
            case 'buscar':
                $$nombreNegocio->buscar();
                break;
            case 'editar':
                $$nombreNegocio->guardar();
                break;
            case 'eliminar':
                $$nombreNegocio->eliminar();
                break;
            case 'consultar':
                break;
            case 'agregarColocacion':
                $$nombreNegocio->guardarColocacion();
                break;
            case 'agregarAmbos':
                $$nombreNegocio->guardarAmbos();
                break;
            case 'listarAreparar':
                $accion = 'listarAreparar';
                break;
            case 'listarSinVisitas':
                $accion = 'listarSinVisitas';
                break;
           case 'listarSinCoordenadas':
                $accion = 'listarSinCoordenadas';
                break;
           case 'listarSinFolio':
                $accion = 'listarSinFolio';
                break;
           case 'imprimir':
                $accion = 'imprimir';
                break;
           case 'imprimirTrabajos':
                $$nombreNegocio->imprimirTrabajos();
                break;
            default:
                $accion = 'buscar';
                break;
        }
    }

        if ($accion == 'reporte' || $accion == 'reporteProblemas' || $accion == 'reporteProblemasLista' || $accion == 'reporteTrabajos' || $accion == 'reporteSinVisitas' || $accion == 'excel')
    {
            require_once('vista/'.$modulo.'/'.$accion.'.php');
    }
    else {
            require_once('vista/inc/head.php');
            require_once('vista/'.$modulo.'/'.$accion.'.php');
            require_once('vista/inc/foot.php'); 
         }
}
else{
    header('Location: login.php');
    die();
}
?>