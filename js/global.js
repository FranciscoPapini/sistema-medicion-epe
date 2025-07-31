$(function(){

    var showLoading = function(){
        $('#loading').show();
    };

    var hideLoading = function(){
        $('#loading').hide();
    };

    var generarModal = function(titulo, contenido){
        if( !$('#miModal').length ){
            $('<div class="modal fade" id="miModal" tabindex="-1" role="dialog" aria-hidden="true"><div class="modal-dialog modal-lg"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button><h4 class="modal-title" id="myModalLabel">Modal title</h4></div><div class="modal-body"></div><div class="modal-footer" id="non-printable"><button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button></div></div></div></div>').appendTo('html');
            $('#miModal').on('show.bs.modal',hideLoading);
        }
        var modal = $('#miModal');
        $('h4.modal-title',modal).html(titulo);
        $('div.modal-body',modal).html(contenido);
        modal.modal('show');
    };

    var mostrarConsulta = function(e){
        e.preventDefault();
        var $this = $(this);
        showLoading();
        $.get(
            $this.attr('href'),

            function(data){
                var response = $("#reporte", data);
                generarModal('Detalle de Informe', response);
            }
        );
    };

    var validarPassword = function(e){
        e.preventDefault();
        
        var pass = $("#password").val();
        var confpass = $("#confpassword").val();

        if (pass && confpass){
            if (pass != confpass){
                $("#div-alert-pass").toggle(true);
            }
            else{
                $("#div-alert-pass").toggle(false);
            }
        }
        if (!pass && !confpass) {
            $("#div-alert-pass").toggle(false);
        }
    };

    /*Validar Password*/
    $("#password").on('change',validarPassword);
    $("#confpassword").on('change',validarPassword);

    /*Tooltip*/
    $('a[data-toggle="tooltip"]').tooltip({
        container: 'body'
    });

    /*Cancelar*/
    $('.cancelForm').on('click',function(e){
    	e.preventDefault();
    	$(this).prop('disabled',true);
    	history.go(-1);
    });

    /*Redireccionar submit*/
    $('#submit a').on('click',function(e){
        e.preventDefault();
        var form = $('form#principal'),
            $this = $(this);
        if(!$('input#redirect').length){
            $('<input type="hidden" name="redirect" id="redirect">').prependTo(form);
        }
        $('input#redirect').val($this.attr('href'));
        $('#submit-button').trigger('click');
    });

    /*Datepicker*/
    $(".datepicker").datepicker({
        format: "dd/mm/yyyy",
        language: "es",
        autoclose: true,
        todayHighlight: true
    });
    /*Datepicker validar fecha
        .on('change', function(e) {
        var curDate = $(this).datepicker("getDate");
        var maxDate = new Date();
        maxDate.setDate(maxDate.getDate() + 1); //add one day
        maxDate.setHours(0, 0, 0, 0);           // clear time portion for correct results
        if (curDate > maxDate) {
            alert('La fecha ingresada no puede ser mayor');
            $(this).datepicker("setDate", '');
    }
    })*/

    /*DataTable*/
    if(jQuery().DataTable) {
        $('#tableListar').DataTable({
            "order": [[0, 'desc'], [1, 'desc']],
            "aLengthMenu": [[10, 25, 50, 100, 200, -1], [10, 25, 50, 100, 200, "Todos"]],
            "iDisplayLength" : 10,
            "language": {
                "lengthMenu"            : "Mostrar _MENU_ registros por página",
                "zeroRecords"           : "No se encontraron resultados",
                "info"                  : "Mostrando página _PAGE_ de _PAGES_",
                "infoEmpty"             : "No hay registros disponibles",
                "infoFiltered"          : "(filtrado de _MAX_ registros totales)",
                "sSearch"               : "",
                "sSearchPlaceholder"    : 'Buscar',
                "oPaginate"             : {
                    "sFirst"                : "Primero",
                    "sPrevious"             : "Anterior", 
                    "sNext"                 : "Siguiente",
                    "sLast"                 : "Último"
                }
            }
        })

        .column( 0 ).visible( true );
        
    //$('.dataTables_filter input[type=search]').val(''); 

        $('#tableListarCons').DataTable({ //no esta en uso
            "order": [0, 'desc'],
            "aLengthMenu": [[10, 25, 50, 100, 200, -1], [10, 25, 50, 100, 200, "Todos"]],
            "iDisplayLength" : 10,
            "language": {
                "lengthMenu"            : "Mostrar _MENU_ registros por página",
                "zeroRecords"           : "No se encontraron resultados",
                "info"                  : "Mostrando página _PAGE_ de _PAGES_",
                "infoEmpty"             : "No hay registros disponibles",
                "infoFiltered"          : "(filtrado de _MAX_ registros totales)",
                "sSearch"               : "",
                "sSearchPlaceholder"    : 'Buscar',
                "oPaginate"             : {
                    "sFirst"                : "Primero",
                    "sPrevious"             : "Anterior", 
                    "sNext"                 : "Siguiente",
                    "sLast"                 : "Último"
                }
            }
        })

        .column( 0 ).visible( false );

    }


    /*DataTable*/
    if(jQuery().validator) {
        $('form#principal').validator();
    }
    
    /*Consultar consulta*/
    $('.btnConsultar').on('click',mostrarConsulta);
 
    /*Validar Password al editar Administrador*/
    $("#password").on('change',validarPassword);
    $("#confpassword").on('change',validarPassword);

    /*Mostrar Buscador*/
    $("#tipo_busqueda").on('change', function() {

    var selectValue = $(this).val();
    switch (selectValue) {

      case "1":
        $("#div1").show();
        $("#div2").hide();
        $("#div3").hide();
        $("#parametro1").prop('required',true);
        break;

      case "2":
        $("#div1").show();
        $("#div2").show();
        $("#div3").hide();
        $("#parametro1").prop('required',true);
        $("#parametro2").prop('required',true);
        break;

      case "3":
        $("#div1").show();
        $("#div2").show();
        $("#div3").show();
        $("#parametro1").prop('required',true);
        $("#parametro2").prop('required',true);
        $("#parametro3").prop('required',true);
        break;

    }

    }).change();



    //div id=directo ocultar cuando es alpha directo
    $("#id_medidor").on('click', function(e) {
    $("#id_medidor").on('change', function(e) {
        e.preventDefault();


    var selectValue = $(this).val();
    switch (selectValue) {

      case "2":
        $("#directo2").hide();
        $('#tipo_controle').removeAttr('required');
        $('#tipo_t').removeAttr('required');
        $('#relacion_t').removeAttr('required');
        $('#cabina').removeAttr('required');
        break;

      case "3":
        $("#directo2").hide();
        $('#tipo_controle').removeAttr('required');
        $('#tipo_t').removeAttr('required');
        $('#relacion_t').removeAttr('required');
        $('#cabina').removeAttr('required');
        break;

      default:
        $("#directo2").show();
        $("#tipo_controle").prop('required',true);
        $("#tipo_t").prop('required',true);
        $("#relacion_t").prop('required',true);
        break;

    }

    }).change();

    });



    //informe ocultar aprobado
    $("#tipo_informe").on('click', function(e) {
    $("#tipo_informe").on('change', function(e) {
        e.preventDefault();


    var selectValue = $(this).val().toLowerCase();

    switch (selectValue) {
      case 'puesta en servicio rechazada':
        $("#div_aprobado_informe").hide();
        break;

      default:
        $("#div_aprobado_informe").show();
        break;

    }

    }).change();

    });





    /*Mostrar Lectura*/
    $('#leido').on('click',function(e){
        $("#div-lectura").toggle(this.checked);
    });

    /*Mostrar Datos de Medidor Retirado*/
    $('#leido2').on('click',function(e){
        $("#div-lectura2").toggle(this.checked);
    });

    /*Mostrar Lectura Medidor Retirado*/
    $('#leido3').on('click',function(e){
        $("#div-lectura3").toggle(this.checked);
    });
    
    /*Mostrar Lectura de Reseteo*/
    $('#leido4').on('click',function(e){
        $("#div-lectura4").toggle(this.checked);
    });

    /*Mostrar Media Tension*/
    $('#media_tension').on('click',function(e){
        $("#div-relacion-tv").toggle(this.checked);
    });

    $('#media_tension').on('click',function(e){
        $("#div-relacion-tv2").toggle(this.checked);
    });

    $('#media_tension').on('click',function(e){
        $("#div-relacion-tv3").toggle(this.checked);
    });

    $('#respaldo').on('click',function(e){
        $("#div-respaldo").toggle(this.checked);
    });

    /*No esta en uso*/
    $('#coordenadas').on('click',function(e){
        $("#div-coordenadas2").toggle(this.checked);
    });

    /*Media Tension required*/
    $('#media_tension').on('click',function(e){
        if( $('#media_tension').prop('checked') ) {
            $("#cabina").prop('required',true);
        } else {
            $('#cabina').removeAttr('required');
        }
    });

    /*Si se retira el equipo en una consulta, debo quitar el div funciona*/
    $('#retirado').on('click',function(e){
        if( $('#retirado').prop('checked') ) {
            $("#funciona").removeAttr('required');
            $("#div-funciona").hide();
        } else {
            $('#funciona').prop('required',true);
            $("#div-funciona").show();
        }
    });


    /*Datos de Medidor Retirado required*/
    $('#leido2').on('click',function(e){
        if( $('#leido2').prop('checked') ) {
            $("#id_medidor_ret").prop('required',true);
            $("#nro_medidor_ret").prop('required',true);
        } else {
            $('#id_medidor_ret').removeAttr('required');
            $('#nro_medidor_ret').removeAttr('required');
        }
    });


    /*Datos de Medidor de Respaldo required*/
    $('#respaldo').on('click',function(e){
        if( $('#respaldo').prop('checked') ) {
            $("#id_medidor_respaldo").prop('required',true);
            $("#nro_medidor_respaldo").prop('required',true);
            $("#leido-respaldo").show();
            $("#retiro_respaldo").show();            
        } else {
            $('#id_medidor_respaldo').removeAttr('required');
            $('#nro_medidor_respaldo').removeAttr('required');
            $("#leido-respaldo").hide();
            $("#retiro_respaldo").hide();            
            $("#div-lectura-respaldo").hide();
        }
    });


    /*Mostrar Lectura de Respaldo*/
    $('#leido5').on('click',function(e){
        $("#div-lectura-respaldo").toggle(this.checked);
    });


 //   $('#leido4').on('click',function(e){
 //       if( $('#leido4').prop('checked') ) {
 //           $("#div-lectura").show();
 //           $('#leido').prop('checked', true);
 //       } else {
 //           $('#div-lectura').hide();
 //           $('#leido').prop('checked', false);
 //       }
 //   });      


    /*Mostrar Lectura de Reseteo*/
    $('#leido4').on('click',function(e){
        if( $('#leido4').prop('checked') ) {
            $("#info").show();
        } else {
            $("#info").hide();
        }
    });   


    var tipo_medidor = $("#id_medidor").val(); 
    var nro_medidor = $("#nro_medidor").val();
    var tipo_medidor_ret = $("#id_medidor_ret").val(); 
    var nro_medidor_ret = $("#nro_medidor_ret").val();

    /*Setear Datos de Medidor de Equipo en Medidor Retirado*/
    $('#leido2').on('click',function(e){
        if( $('#leido2').prop('checked') ) {

                if (tipo_medidor_ret != '' && nro_medidor_ret != '') {
                            $('#id_medidor_ret').val(tipo_medidor_ret);
                            $('#nro_medidor_ret').val(nro_medidor_ret);
                            if (tipo_medidor_ret != '' && nro_medidor_ret != '')
                                {
                                $("#id_medidor").val(tipo_medidor);
                                $("#nro_medidor").val(nro_medidor);    
                                } else {
                                }
                            $("#id_medidor").val('');
                            $("#nro_medidor").val('');                  
                } else { 
                            $('#id_medidor_ret').val(tipo_medidor);
                            $('#nro_medidor_ret').val(nro_medidor);
                            $("#id_medidor").val('');
                            $("#nro_medidor").val('');              
                        }
   
    } else {

    if (tipo_medidor_ret == '' && nro_medidor_ret == '')
    {
        tipo_medidor_ret = tipo_medidor;
        nro_medidor_ret = nro_medidor;
    }
            $('#id_medidor').val(tipo_medidor_ret);
            $('#nro_medidor').val(nro_medidor_ret);
            $("#id_medidor_ret").val('');
            $("#nro_medidor_ret").val('');  
    }


//                     if ($('#valid').length) {
 //        $('#tipo_medidor').val(tipo_medidor_ret);
  //       $('#nro_medidor').val(nro_medidor_ret);
   //      $("#tipo_medidor_ret").val('');
//         $("#nro_medidor_ret").val('');
//    } else {
//         $('#tipo_medidor').val(tipo_medidor);
//         $('#nro_medidor').val(nro_medidor);
//         $("#tipo_medidor_ret").val('');
 //        $("#nro_medidor_ret").val('');
   // }

        
   });

});