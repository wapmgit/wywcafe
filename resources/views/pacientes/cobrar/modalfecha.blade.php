<div class="modal fade modal-slide-in-right" aria-hidden="true"
role="dialog" tabindex="-1" id="modalfecha">
		{!!Form::open(array('url'=>'/pacientes/actfecha','method'=>'POST','autocomplete'=>'off','id'=>'formulariodespacho'))!!}
            {{Form::token()}}
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" 
				aria-label="Close">
                     <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title">ACtualizar fecha de Despacho </h4>
			</div>
			<div class="modal-body">
				<p>
				<label>Fecha</label>	
	<input type="date" name="fechadespacho" value="<?php echo date("Y-m-d");?>" class="form-control">
	<input type="hidden" name="ventafecha" value="{{$venta->idventa}}" class="form-control">
				</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
				<button type="submit" class="btn btn-primary">Confirmar</button>
			</div>
		</div>
	</div>
	{{Form::Close()}}

</div>
