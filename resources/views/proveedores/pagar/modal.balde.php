<div class="modal fade modal-slide-in-right" aria-hidden="true"
role="dialog" tabindex="-1" id="modal">
		{!!Form::open(array('url'=>'/pacientes/pago','method'=>'POST','autocomplete'=>'off','id'=>'formulariocliente'))!!}
            {{Form::token()}}
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" 
				aria-label="Close">
                     <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title">Confirma realizar pago a todos los documentos¡¡ </h4>
			</div>
			<div class="modal-body">
				<p>Confirme si desea Procesar el Pago
				@foreach ($datos as $cat1)				
				<input type="hidden" value="{{$cat1->idingreso}}" name="factura[]" class ="form-control"></input>
				<input type="hidden" value="{{$cat1->saldo}}" name="saldo[]" class ="form-control"></input>
					@endforeach
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
