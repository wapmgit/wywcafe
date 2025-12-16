<div class="modal modal-danger" aria-hidden="true"
role="dialog" tabindex="-1" id="modal-delete-{{$cat->id_cliente}}">
	{{Form::Open(array('action'=>array('PacientesController@destroy',$cat->id_cliente),'method'=>'delete'))}}
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" 
				aria-label="Close">
                     <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title">Eliminar cliente</h4>
			</div>
			<div class="modal-body">
				<p>¿Confirma eliminar Cliente?</bR>
				{{ $cat->nombre}}</p>
				<input type="hidden" class="form-class" name="tipo" value="0">
				<input type="hidden" class="form-class" name="id" value="{{$cat->id_cliente}}">
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
				<button type="submit" class="btn btn-primary">Confirmar</button>
			</div>
		</div>
	</div>
	{{Form::Close()}}

</div>