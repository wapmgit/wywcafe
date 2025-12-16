<div class="modal modal-danger" aria-hidden="true"
role="dialog" tabindex="-1" id="modal-delete-{{$ven->idventa}}">
{!!Form::open(array('url'=>'/pedido/pedido/destruir','method'=>'POST','autocomplete'=>'off','id'=>'formulario','files'=>'true'))!!}
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" 
				aria-label="Close">
                     <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title">Anular Pedido</h4>
			</div>
			<div class="modal-body">
				<p>Confirme si desea Anular el Pedido {{$ven->idventa}}
				            			<input type="hidden" name="venta" value="{{$ven->idventa}}" class="form-control" >
				</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
				<button type="submit" class="btn btn-primary">Confirmar</button>
			</div>
		</div>
	</div>
	{{Form::Close()}}

</div>