

<div class="modal fade modal-slide-in-right" aria-hidden="true"
role="dialog" tabindex="-1" id="modal-delete-{{$renc->id_mov}}">
<?php $tipo=$renc->id_mov."_2"; ?>
	{{Form::Open(array('action'=>array('ReportesController@destroy',$tipo),'method'=>'delete'))}}
	<div class="modal-dialog">
		<div class="modal-content">
					

			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" 
				aria-label="Close">
                     <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title">Anular Movimiento de Nota de Credito</h4>
			</div>
			<div class="modal-warning">
			<div class="modal-body">
				<p>¿Confirme si desea Anular el  # {{$renc->id_mov}}?</p>
			</div>
			</div>
			<div class="modal-footer">
			<input type="hidden" name="tipo"  value="2" class="form-control">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
				<button type="submit" class="btn btn-primary">Confirmar</button>
			</div>
			</div>
		
	</div>
	{{Form::Close()}}

</div>