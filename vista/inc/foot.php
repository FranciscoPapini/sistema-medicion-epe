<div id="loading">
    	<div id="loading-img"></div>
    	<p>Cargando</p>
    </div>
    <script src="js/jquery-1.11.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
	<script src="js/bootstrap-datepicker.js"></script>
	<script src="js/locales/bootstrap-datepicker.es.js"></script>
	<script src="js/jquery.dataTables.min.js"></script>
    <?php if($accion == 'listar' || $accion == 'listarAreparar' || $accion == 'listarNovedades' || $accion == 'listarTodos' || $accion == 'listarRetirados' || $accion == 'listarSinVisitas' || $accion == 'imprimir' || $accion == 'imprimir2' || $accion == 'listarSinCoordenadas' || $accion == 'listarSinFolio' ){ ?>
        <script src="js/dataTables.bootstrap.js"></script>
    <?php } elseif ($accion == 'editar' || $accion == 'consultar' || $accion == 'agregarColocacion' || $accion == 'imprimirTrabajos') { ?>
        <script src="js/validator.js"></script>
    <?php }
    if ($accion == 'buscar') { ?> <script src="js/validator.js"></script> <script src="js/dataTables.bootstrap.js"></script> <?php }
    ?>
    <script src="js/global.js"></script>
  </body>
</html>