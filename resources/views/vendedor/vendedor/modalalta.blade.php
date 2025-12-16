<div class="modal modal-danger" aria-hidden="true"
role="dialog" tabindex="-1" id="modal-delete-{{$cat->id_vendedor}}">
	{{Form::Open(array('action'=>array('VendedoresController@destroy',$cat->id_vendedor),'method'=>'delete'))}}
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" 
				aria-label="Close">
                     <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title"> Inactivar Vendedor</h4>
			</div>
			<div class="modal-body">
				<p>¿Confirma Inactivar Vendedor?</bR>
				{{ $cat->nombre}}</p>
				<input type="hidden" class="form-class" name="tipo" value="0">
				<input type="hidden" class="form-class" name="id" value="{{$cat->id_vendedor}}">
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
				<button type="submit" class="btn btn-primary">Confirmar</button>
			</div>
		</div>
	</div>
	{{Form::Close()}}

</div>