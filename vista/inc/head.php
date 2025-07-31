<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Grandes Usuarios - <?php if($modulo == 'consulta') { if ($_GET['novedad']) { echo 'Problema'; } else { if ($accion == 'agregarAmbos') { echo 'Equipo'; } else { echo 'Revisi&oacute;n'; } } } else { if ($accion == 'mapas') { echo 'Mapa'; } else { echo ucfirst($modulo); } } ?></title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/datepicker3.css" rel="stylesheet">
    <link href="css/dataTables.bootstrap.css" rel="stylesheet">
    <link href="css/estilos.css" rel="stylesheet">

    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body <?php if($accion == 'mapas') { ?> onload="initialize(); <?php } ?> ">
    <div class="navbar navbar-default" role="navigation">
      <div class="container" >

        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="?modulo=equipo&accion=buscar">GU</a>
        </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">Equipos <span class="caret"></span></a>
              <ul class="dropdown-menu" role="menu">
                <li><a href="?modulo=equipo&accion=buscar"><span class="glyphicon glyphicon-search"></span> Buscar Equipo</a></li>
                <li class="divider"></li>
                <li><a href="?modulo=equipo&accion=listar"><span class="glyphicon glyphicon-list"></span> Listar Equipos</a></li>
                <li><a href="?modulo=equipo&accion=listarRetirados"><span class="glyphicon glyphicon-list"></span> Listar Equipos Retirados</a></li>
                <li><a href="?modulo=equipo&accion=listarSinFolio"><span class="glyphicon glyphicon-list"></span> Listar Equipos sin Folio</a></li>
                <li class="divider"></li>
                <li><a href="?modulo=equipo&accion=editar"><span class="glyphicon glyphicon-plus"></span> Agregar Equipo</a></li>
                <li><a href="?modulo=consulta&accion=agregarColocacion&col=1"><span class="glyphicon glyphicon-plus"></span> Colocaci&oacute;n de Equipo</a></li>
              </ul>
            </li>
        <li><a href="?modulo=equipo&accion=mapas">Mapa <span class="sr-only"></span></a></li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">Reportes <span class="caret"></span></a>
              <ul class="dropdown-menu" role="menu">
                <li><a href="?modulo=equipo&accion=listarNovedades"><span class="glyphicon glyphicon-list"></span> Listar Trabajos</a></li>
                <li><a href="?modulo=consulta&accion=imprimirTrabajos" target="_blank"><span class="glyphicon glyphicon-print"></span> Imprimir Trabajos</a></li>
                <li class="divider"></li>
                <li><a href="?modulo=equipo&accion=listarAreparar"><span class="glyphicon glyphicon-list"></span> Listar Equipos con Problemas</a></li>
                <li><a href="?modulo=equipo&accion=reporteProblemasLista" target="_blank"><span class="glyphicon glyphicon-print"></span> Imprimir Reporte en Lista</a></li>
                <li><a href="?modulo=equipo&accion=reporteProblemas" target="_blank"><span class="glyphicon glyphicon-print"></span> Imprimir Reporte en Detalle</a></li>
                <li class="divider"></li>
                <li><a href="?modulo=equipo&accion=listarSinVisitas"><span class="glyphicon glyphicon-list"></span> Listar Equipos sin Visitas</a></li>
                <li><a href="?modulo=equipo&accion=reporteSinVisitas" target="_blank"><span class="glyphicon glyphicon-print"></span> Imprimir Reporte</a></li>
              </ul>
            </li>
          </ul>
          <ul class="nav navbar-nav navbar-right">
          <?php 
          if( $_SESSION['administrador']['id'] == 1 || $_SESSION['administrador']['id'] == 2 || $_SESSION['administrador']['id'] == 3 ){
          ?>
              <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">Medidores <span class="caret"></span></a>
              <ul class="dropdown-menu" role="menu">
                <li><a href="?modulo=control&accion=listar"><span class="glyphicon glyphicon-list"></span> Listar Controles</a></li>
                <li><a href="?modulo=medidor&accion=listar"><span class="glyphicon glyphicon-list"></span> Listar Medidores</a></li>
                <li><a href="?modulo=transformadorTension&accion=listar"><span class="glyphicon glyphicon-list"></span> Listar TV</a></li>
                <li><a href="?modulo=transformadorCorriente&accion=listar"><span class="glyphicon glyphicon-list"></span> Listar TI</a></li>
              </ul>
            </li>
          <?php
          }
          ?>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">Opciones <span class="caret"></span></a>
              <ul class="dropdown-menu" role="menu">
          <?php
          if( $_SESSION['administrador']['id'] == 1 || $_SESSION['administrador']['id'] == 2 || $_SESSION['administrador']['id'] == 3 ){
          ?>
                <li><a href="?modulo=administrador&accion=listar"><span class="glyphicon glyphicon-list"></span> Listar Administradores</a></li>
                <li><a href="?modulo=administrador&accion=editar"><span class="glyphicon glyphicon-plus"></span> Agregar Administrador</a></li>
                <li class="divider"></li>
                <li><a href="?modulo=equipo&accion=excel"><span class="glyphicon glyphicon-file"></span> Generar Excel</a></li>
                <li class="divider"></li>
          <?php
          }
          ?>
                <li><a href="?modulo=informe&accion=listar"><span class="glyphicon glyphicon-list"></span>  Listar Informes</span></a></li>
                <li class="divider"></li>
                <li><a href="?modulo=administrador&accion=editar&id=<?php echo $_SESSION['administrador']['id']; ?>"><span class="glyphicon glyphicon-pencil"></span> Editar Datos</a></li>
              </ul>
            </li>
            <li><a href="index.php?action=logout">Salir</a></li>
          </ul>
          <p class="navbar-text navbar-right" tabindex="-1">Hola <strong><?php echo ucwords($_SESSION['administrador']['nombre']); ?></strong>!</p>
        </div><!--/.nav-collapse -->
      </div>
    </div><!-- /navbar -->