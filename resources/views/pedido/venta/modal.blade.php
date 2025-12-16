<div class="modal fade modal-slide-in-right" aria-hidden="true"
role="dialog" tabindex="-1" id="modal-{{$venta->idventa}}">
{!!Form::open(array('url'=>'/pedido/pedido/facturar','method'=>'POST','autocomplete'=>'off','id'=>'formulario','files'=>'true'))!!}
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" 
				aria-label="Close">
                     <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title">Importar documento a Factura</h4>
			</div>
			<div class="modal-body">
				<p>Confirma Convertir en factura el  Pedido {{$venta->idventa}}?</p>
						<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
			           <div class="form-group">
					   <label for="serie_comprobante">Fecha Emision</label>
					<input type="date" name="fecha_emi"  id="fecha_emi" value="<?php echo $fserver; ?>" class="form-control">
					</div>
					</div>
					<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
<div class="form-group">
						<label for="serie_comprobante">Serie</label>
						<input type="text" style="background-color:#edefef" name="serie_comprobante" value="NE00" size="5" class="form-control"placeholder="serie del comprobante" > 
					</div>	
					</div>
				<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            		 <div class="form-group">
            	
						<input type="hidden" name="idventa"  value="{{$venta->idventa}}" >
                        @foreach($detalles as $cat1)
						<?php if($cat1->cantidad > 0 ){ ?>
                <input type="hidden" value="{{$cat1->idarticulo}}" name="idarticulo[]" class ="form-control"></input>
				<input type="hidden" value="{{$cat1->cantidad}}" name="cantidad[]" class ="form-control"></input>
                <input type="hidden" value="{{$cat1->costo}}" name="costo[]" class ="form-control"></input>
                <input type="hidden" value="{{$cat1->precio_venta}}" name="precio[]" class ="form-control"></input>
                <input type="hidden" value="{{$cat1->descuento}}" name="descuento[]" class ="form-control"></input>
						<?php } ?>
                        @endforeach
            		</div>
            	</div>
			</div>
			<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
			           <div class="form-group">
           </div>
		   </div>
			<div class="modal-footer">	
			<input type="hidden" name="exe"  value="<?php echo $acumex; ?>"  >				
			<input type="hidden" name="cto"  value="<?php echo $ctob; ?>"  >				
				<input type="hidden" name="ivaf"  value="<?php echo $acumbib; ?>"  >				
				<input type="hidden" name="iva"  value="<?php echo $acumbi; ?>"  >
				<input type="hidden" name="mcomi"  value="<?php echo $mcomi; ?>"  >
				<input type="hidden" name="licor"  value="<?php echo $licor; ?>"  >
				<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
				<button type="submit" id="btnconfirmar" class="btn btn-primary">Confirmar</button>
			</div>
		</div>
	</div>
	{{Form::Close()}}

</div>