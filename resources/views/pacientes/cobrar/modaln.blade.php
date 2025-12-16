<div class="modal fade modal-slide-in-right" aria-hidden="true"
role="dialog" tabindex="-1" id="modaln">
		{!!Form::open(array('url'=>'/pacientes/pago/nd','method'=>'POST','autocomplete'=>'off','id'=>'formulariocliente'))!!}
            {{Form::token()}}
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" 
				aria-label="Close">
                     <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title">Confirma realizar pago a todas las Notas de Debito¡¡ </h4>
			</div>
			<div class="modal-body">
				<p>Seleccione Moneda:
				@foreach ($notas as $cat2)				
				<input type="hidden" value="{{$cat2->idnota}}" name="nota[]" class ="form-control"></input>
				<input type="hidden" value="{{$cat2->pendiente}}" name="pendiente[]" class ="form-control"></input>
					@endforeach
				</p>
						<select name="pidpagomodaln" id="pidpagomodaln" class="form-control">
					
						@foreach ($monedas as $mo)
						<?php if($mo->tipo==0){?> 
							<option value="{{$mo->idmoneda}}_{{$mo->nombre}}">{{$mo->idmoneda}}-{{$mo->nombre}}</option>
						<?php } ?>
						@endforeach
						</select>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
				<button type="submit" class="btn btn-primary">Confirmar</button>
			</div>
		</div>
	</div>
	{{Form::Close()}}

</div>
