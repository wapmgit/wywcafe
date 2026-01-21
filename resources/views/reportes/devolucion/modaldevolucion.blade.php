<div class="modal fade modal-slide-in-right" aria-hidden="true"
role="dialog" tabindex="-1" id="modaldevolucion">
{!!Form::open(array('url'=>'pedido/devolucionfac','method'=>'GET','autocomplete'=>'off','id'=>'formulario','files'=>'true'))!!}
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" 
				aria-label="Close">
                     <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title">Ajuste Venta -> {{$venta->idventa}}</h4>
			</div>
			<div class="modal-body">
			<div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
			<label id="art"></label>
			</div>
				<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            		 <div class="form-group">
            			<label for="nombre">Nueva Cantidad</label>
            			<input type="number" step="any" name="cantidad" id="idcantidad" min="1" required value="" class="form-control">
					<input type="hidden" name="idventa"  value="{{$venta->idventa}}" >
						<input type="hidden" name="idarticulo"  id="idarticulo" value="" >
						<input type="hidden" name="pcomi"  value="{{$venta->comision}}"  >
						<input type="hidden" name="tasa"  value="{{$venta->tasa}}" >
						<input type="hidden" name="mcomi"  value="{{$venta->montocomision}}"  >
					<input type="hidden" name="iddetalle" id="iddetalle"  value="" >
					<input type="hidden" name="plink"  value="1" >
            		</div>
            	</div>
				<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            		 <div class="form-group">
            			<label for="nombre">Nuevo Precio</label>
            			<input type="number" step="any" name="precio" id="idprecio" min="1" required value="" class="form-control">

            		</div>
            	</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
				<button type="button" id="senddevolu" class="btn btn-primary">Confirmar</button>
			</div>
		</div>
	</div>
	{{Form::Close()}}

</div>
@push ('scripts')
<script> 

 $('#senddevolu').on("click",function(){ 
document.getElementById('senddevolu').style.display="none";
 document.getElementById('formulario').submit(); })

	</script>
@endpush