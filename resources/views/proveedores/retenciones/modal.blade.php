
<div class="modal modal-danger" aria-hidden="true"
role="dialog" tabindex="-1" id="modal-delete-{{$cat->idretencion}}_{{$cat->afiva}}">
	{!!Form::open(array('url'=>'/cxp/proveedor/anular','method'=>'POST','autocomplete'=>'off'))!!}
            {{Form::token()}}
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" 
				aria-label="Close">
                     <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title">Anular Retencion en Compra  </h4>
			</div>
			<div class="modal-body">
				<p>¿Confirme si desea Anular Retencion? {{$cat->idretencion}}
				<input type="hidden" value="{{$cat->idretencion}}_{{$cat->afiva}}" name="idret"></input></p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
				<button type="submit" class="btn btn-primary">Confirmar</button>
			</div>
		</div>
	</div>
	{{Form::Close()}}

</div>
