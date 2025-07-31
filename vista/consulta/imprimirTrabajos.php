<div class="container" id="non-printable" >
      <div class="page-header" id="non-printable" >
        <h1>Trabajos en Equipos
        </h1>
      </div>
<?php echo Util::getMsj();?>
      <form role="form" method="post" id="principal">

<div class="row">
        <div class="col-md-12">
              <div class="form-group">
                <label for="fecha_desde">Fecha Desde</label>
                <p class="help-block" style="display: inline;">(Formato dd/mm/yyyy)</p>
                <input type="text" class="form-control datepicker" id="fecha_desde" name="fecha_desde" placeholder="dd/mm/yyyy" value="" pattern="^(?:(?:31(\/|-|\.)(?:0?[13578]|1[02]))\1|(?:(?:29|30)(\/|-|\.)(?:0?[1,3-9]|1[0-2])\2))(?:(?:1[6-9]|[2-9]\d)?\d{2})$|^(?:29(\/|-|\.)0?2\3(?:(?:(?:1[6-9]|[2-9]\d)?(?:0[48]|[2468][048]|[13579][26])|(?:(?:16|[2468][048]|[3579][26])00))))$|^(?:0?[1-9]|1\d|2[0-8])(\/|-|\.)(?:(?:0?[1-9])|(?:1[0-2]))\4(?:(?:1[6-9]|[2-9]\d)?\d{2})$" required>
                <div class="help-block with-errors"></div>
                </div>    
              </div>
</div>
<div class="row">
        <div class="col-md-12">
              <div class="form-group">
                <label for="fecha_hasta">Fecha Hasta</label>
                <p class="help-block" style="display: inline;">(Formato dd/mm/yyyy)</p>
                <input type="text" class="form-control datepicker" id="fecha_hasta" name="fecha_hasta" placeholder="dd/mm/yyyy" value="<?php echo date('d/m/Y'); ?>" pattern="^(?:(?:31(\/|-|\.)(?:0?[13578]|1[02]))\1|(?:(?:29|30)(\/|-|\.)(?:0?[1,3-9]|1[0-2])\2))(?:(?:1[6-9]|[2-9]\d)?\d{2})$|^(?:29(\/|-|\.)0?2\3(?:(?:(?:1[6-9]|[2-9]\d)?(?:0[48]|[2468][048]|[13579][26])|(?:(?:16|[2468][048]|[3579][26])00))))$|^(?:0?[1-9]|1\d|2[0-8])(\/|-|\.)(?:(?:0?[1-9])|(?:1[0-2]))\4(?:(?:1[6-9]|[2-9]\d)?\d{2})$" required>
                <div class="help-block with-errors"></div>
                </div>    
              </div>
</div>


            <button type="button" onclick="window.close();" class="btn btn-default cancelForm">Cancelar</button>
            <button type="submit" class="btn btn-primary">Imprimir</button>

      </form>

</div>