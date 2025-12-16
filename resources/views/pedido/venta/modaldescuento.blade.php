<div class="modal fade modal-slide-in-right" aria-hidden="true"
role="dialog" tabindex="-1" id="modaldescuen-{{$det->idarticulo}}">
{!!Form::open(array('url'=>'pedido/descuento','method'=>'GET','autocomplete'=>'off','files'=>'true'))!!}
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" 
				aria-label="Close">
                     <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title">Aplicar Descuento a  Pedido-> {{$venta->idventa}}</h4>
			</div>
			<div class="modal-body">
			<div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
			<label>{{$det->articulo}}</label>
			</div>
				<div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
            		 <div class="form-group">
            			<label for="nombre">Porcentaje </label>
            			<input type="number" step="any" name="porcentaje" min="0.01" required value="{{$det->descuento}}" class="form-control">
					<input type="hidden" name="idventa"  value="{{$venta->idventa}}" >
						<input type="hidden" name="idarticulo"  value="{{$det->idarticulo}}" >
					<input type="hidden" name="iddetalle"  value="{{$det->iddetalle_venta}}" >
				
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