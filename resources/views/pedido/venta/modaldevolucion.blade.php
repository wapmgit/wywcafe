<div class="modal fade modal-slide-in-right" aria-hidden="true"
role="dialog" tabindex="-1" id="modaldevolucion-{{$det->idarticulo}}">
{!!Form::open(array('url'=>'pedido/devolucion','method'=>'GET','autocomplete'=>'off','id'=>'formulario','files'=>'true'))!!}
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" 
				aria-label="Close">
                     <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title">Ajuste Pedido -> {{$venta->idventa}}</h4>
			</div>
			<div class="modal-body">
			<div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
			<label>{{$det->articulo}}</label>
			</div>
				<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            		 <div class="form-group">
            			<label for="nombre">Nueva Cantidad</label>
            			<input type="number" step="any" name="cantidad" min="0" required value="{{$det->cantidad}}" class="form-control">
					<input type="hidden" name="idventa"  value="{{$venta->idventa}}" >
						<input type="hidden" name="idarticulo"  value="{{$det->idarticulo}}" >
					<input type="hidden" name="iddetalle"  value="{{$det->iddetalle_venta}}" >
					<input type="hidden" name="plink"  value="0" >
            		</div>
            	</div>
				<div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
            		 <div class="form-group">
            			<label for="nombre">Precio Act.</label>
            			<input type="number"  step="0.01"  name="precio" min="0.01" required value="{{$det->precio_venta}}" class="form-control">

            		</div>
            	</div>
	<div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
            		 <div class="form-group">
            			<label for="nombre">Precio final</label>
            			<input type="number" step="0.01" name="preciof" min="0.01" required value="{{$det->preciof}}" class="form-control">

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