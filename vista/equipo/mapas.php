<div class="container" id="non-printable">
      <div class="page-header" id="non-printable">
        <h1>Mapa</h1> 
      </div>
     <p class="help-block">S&oacute;lo muestra los equipos que tienen coordenadas cargadas en el sistema. <a href="?modulo=equipo&accion=listarSinCoordenadas">Presione aqu&iacute; para ver los que no tienen coordenadas.</a></p>
                

 <div class="center-block" id="map_canvas" style="width:1000px; height:600px; text-align: center;" ></div>

<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&key="></script> //Ohne key
<script type="text/javascript">

var map; //importante definirla fuera de la funcion initialize() para poderla usar desde otras funciones.
 
 function initialize() {

lastWindow=null;

      var punto = new google.maps.LatLng(-32.9746081,-60.7633916); //ubicación de ROSARIO
      var myOptions = {
       zoom: 9, //nivel de zoom para poder ver de cerca.
       center: punto,
       scrollwheel: false, //si colocas true en vez de false el usuario podrá hacer scroll dentro del mapa
       draggable: true, //esta opción es la manito que aparece y es usado para desplazarse en el mapa
       mapTypeId: google.maps.MapTypeId.ROADMAP //Tipo de mapa inicial
      }  

     map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);

<?php 
          $arrayEquipos = $equipoNegocio->listarTodosMapa();
          if( count($arrayEquipos) > 0 ){
            $i = 1;
            foreach( $arrayEquipos as $equipo ){            
?>
          var marker = new google.maps.Marker({ 
          position: new google.maps.LatLng(<?php echo $equipo->getLatitud(); ?>, <?php echo $equipo->getLongitud(); ?>),
          map: map,
          title: '<?php echo mb_strtoupper($equipo->getUsuario(), 'UTF-8'); ?>'
          });

          var content = '<div id="content">'+
                      '<div id="siteNotice">'+
                      '</div>'+
                      '<div id="bodyContent">'+
                      '<p>Usuario: <b><?php echo mb_strtoupper($equipo->getUsuario(), 'UTF-8'); ?></b> Folio: <b><?php if ($equipo->getFolio() == 0) { echo '-'; } else { echo $equipo->getFolio(); } ?></b></p>'+
                      '<p>Direcci&oacute;n: <b><?php echo ucwords($equipo->getDireccion()) . ' - ' . ucwords($equipo->getLocalidad()); ?></b></p>'+
                      '<p>Coordenadas: <b><?php echo $equipo->getLatitud() . ', ' . $equipo->getLongitud(); ?></b></p>'+
                      '</div>'+
                      '</div>';


          var infowindow = new google.maps.InfoWindow();

          google.maps.event.addListener(marker,'click', (function(marker,content,infowindow){ 
          return function() {

          if (lastWindow) lastWindow.close();

           infowindow.setContent(content);
           infowindow.open(map,marker);
           lastWindow=infowindow;

           };
           })(marker,content,infowindow)); 

<?php 
            } //del foreach
          } //del count
?>

}  
</script>
</div>
