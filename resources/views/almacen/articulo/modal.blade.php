<div class="modal modal-danger" aria-hidden="true"
role="dialog" tabindex="-1" id="modal-delete-{{$cat->idarticulo}}">
	{{Form::Open(array('action'=>array('ArticuloController@destroy',$cat->idarticulo),'method'=>'delete'))}}
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
					<input type="hidden" name="modo" value="0" class="form-control">
						<input type="hidden" name="id" value="{{$cat->idarticulo}}" class="form-control">
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
				<button type="submit" class="btn btn-primary">Confirmar</button>
			</div>
		</div>
	</div>
	{{Form::Close()}}

</div>