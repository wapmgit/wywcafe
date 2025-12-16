

<div class="modal fade modal-slide-in-right" aria-hidden="true"
role="dialog" tabindex="-1" id="modal-delete-{{$cob->idrecibo}}">
	{{Form::Open(array('action'=>array('CxpagarController@destroy',$cob->idrecibo),'method'=>'delete'))}}
	<div class="modal-dialog">
		<div class="modal-content">
					

			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" 
				aria-label="Close">
                     <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title">Anular Recibo de Pago</h4>
			</div>
			<div class="modal-warning">
			<div class="modal-body">
			<input type="hidden" name="tiporecibo" value="0"></input>
				<p>¿Confirme si desea Anular el Recibo # {{$cob->idrecibo}}?</p>
			</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
				<button type="submit" class="btn btn-primary">Confirmar</button>
			</div>
			</div>
		
	</div>
	{{Form::Close()}}

</div>
