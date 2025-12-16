<div class="modal modal-danger" aria-hidden="true"
role="dialog" tabindex="-1" id="modal-delete-{{$det->idarticulo}}">
	{{Form::Open(array('action'=>array('BloquesController@destroy',$det->idarticulo),'method'=>'delete'))}}
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" 
				aria-label="Close">
                     <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title">Eliminar Articulo</h4>
			</div>
			<div class="modal-body">
				<p>Confirme si desea Eliminar el articulo</p>
					<input type="hidden" name="bloque" value="{{$bloque->idbloque}}" class="form-control">
					<input type="hidden" name="detalle" value="{{$det->iddetallebloque}}" class="form-control">
						<input type="hidden" name="id" value="{{$det->idarticulo}}" class="form-control">
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
				<button type="submit" class="btn btn-primary">Confirmar</button>
			</div>
		</div>
	</div>
	{{Form::Close()}}

</div>