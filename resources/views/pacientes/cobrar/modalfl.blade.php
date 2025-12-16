<div class="modal fade modal-slide-in-right" aria-hidden="true"
role="dialog" tabindex="-1" id="modalfl{{$cat->idventa}}">
		{!!Form::open(array('url'=>'/pacientes/pasarfl','method'=>'POST','autocomplete'=>'off','id'=>'formulariocliente'))!!}
            {{Form::token()}}
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" 
				aria-label="Close">
                     <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title">Confirma Operacion¡¡ </h4>
			</div>
			<div class="modal-body">
			<p> Confirma Convertir en Forma Libre el Documento {{$cat->serie_comprobante}}-{{$cat->num_comprobante}}
			<input type="hidden"  name="idventafl" value="{{$cat->idventa}}"></p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
				<button type="submit" class="btn btn-primary">Confirmar</button>
			</div>
		</div>
	</div>
	{{Form::Close()}}

</div>
