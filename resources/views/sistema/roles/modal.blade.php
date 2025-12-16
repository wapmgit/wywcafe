
<div class="modal  modal-default" aria-hidden="true"
role="dialog" tabindex="-1"  id="modal-pass{{$q->id}}">
 	{!!Form::open(array('url'=>'/sistema/actpass','method'=>'POST','autocomplete'=>'off','id'=>'formulario','files'=>'true'))!!}
            {{Form::token()}}
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" 
				aria-label="Close">
                     <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title">Actualizar clave de Acceso Usuario: {{$q->name}}</h4>
			</div>
			<div class="modal-body">

	<p>Actualizar Contraseña
		<input type="hidden" name="id"  value="{{$q->id}}" >
		<input type="password" name="pass"  value="" class="form-control">
	</p>
		</div> 
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
				<button type="submit" class="btn btn-primary">Confirmar</button>
			</div>
		</div>
	</div>

		{!!Form::close()!!}		
</div>