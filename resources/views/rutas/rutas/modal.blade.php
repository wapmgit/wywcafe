<div class="modal fade modal-slide-in-right" aria-hidden="true"
role="dialog" tabindex="-1" id="modal-calcular-{{$categoria->idcategoria}}">
{!!Form::open(array('url'=>'../almacen/categoria/recalcular','method'=>'POST','autocomplete'=>'off','id'=>'formulario','files'=>'true'))!!}
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" 
				aria-label="Close">
                     <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title">Indique Porcentaje de Incremento</h4>
			</div>
			<div class="modal-body">
				<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            		 <div class="form-group">
            			<label for="nombre">Porcentaje</label>
            			<input type="number" name="tasa" required value="" class="form-control" placeholder="%...">
						<input type="hidden" name="categoria"  value="{{$categoria->idcategoria}}" >
            		</div>
            	</div>
			</div>
			<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
			           <div class="form-group">
             <label for="modo">Modo</label><br>
        <label for="precio1"> Incremento P.v.</label> <input name="modo" type="radio" value="1" checked="checked">
         <label for="precio2"> Ajuste Utilidad</label> <input name="modo" type="radio" value="2">
           </div>
		   </div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
				<button type="submit" class="btn btn-primary">Confirmar</button>
			</div>
		</div>
	</div>
	{{Form::Close()}}

</div>