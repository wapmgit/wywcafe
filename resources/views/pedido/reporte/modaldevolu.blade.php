<div class="modal fade modal-slide-in-right" aria-hidden="true"
role="dialog" tabindex="-1" id="modaldevolu-{{$cob->iddetalle_venta}}">
{!!Form::open(array('url'=>'pedido/devolucionpedido','method'=>'GET','autocomplete'=>'off','id'=>'formulario','files'=>'true'))!!}
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" 
				aria-label="Close">
                     <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title">Indique cantidad para restar a pedido</h4>
			</div>
			<div class="modal-body">
			<label>{{$cob->articulo}}</label>
				<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            		 <div class="form-group">
            			<label for="nombre">Cantidad</label>
            			<input type="number" step="any" name="cantidad" min="1" max="{{$cob->cantidad}}" required value="{{$cob->cantidad}}" class="form-control">
					<input type="hidden" name="idventa"  value="{{$cob->idventa}}" >
						<input type="hidden" name="idarticulo"  value="{{$cob->idarticulo}}" >
						<input type="hidden" name="vendedor"  value="{{$cob->vendedor}}" >
					<input type="hidden" name="iddetalle"  value="{{$cob->iddetalle_venta}}" >
            		</div>
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