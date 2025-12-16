<div class="modal modal-warning" aria-hidden="true"
role="dialog" tabindex="-1" id="retencion{{$cat->idventa}}">
{!!Form::open(array('url'=>'/cxc/retencion','method'=>'POST','autocomplete'=>'off','id'=>'formulariocliente'))!!}
            {{Form::token()}}
				<div class="modal-dialog ">
	
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" 
				aria-label="Close">
                     <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title">GENERAR RETENCION EN VENTA:  Doc -> {{$cat->num_comprobante}} </h4>
			
			</div>
			<div class="modal-body">
				<p>			
				<div class="col-lg-4 col-sm-4 col-md-4 col-xs-4">	<label>% Retencion</label>	<input name="idretenc" id="idretenc{{$cat->idventa}}" readonly value="{{$cliente->retencion}}" class="form-control">
				</div>
	<div class="col-lg-4 col-sm-4 col-md-4 col-xs-4">	<label>N Comprobante</label>	
	<input type="text" name="comprobanteret" value="" id="ncomp{{$cat->idventa}}" class="form-control">
	</div>	
	<div class="col-lg-4 col-sm-4 col-md-4 col-xs-4">	<label>Fecha</label>	
	<input type="date" name="fecharet" value="<?php echo date("Y-m-d");?>" class="form-control">
	</div>
				</p>
				<div class="col-lg-3 col-sm-3 col-md-3 col-xs-3">
            		 <div class="form-group">
					 <?php
					 	$ivabs=($cat->base*0.16);
						  $ivabs = truncar(($ivabs),2);	?>
            			<label for="nombre">M.Fac</label>
            			<input type="text" name="mfac" id="mfac{{$cat->idventa}}" required value="<?php $pret=($cliente->retencion/100);echo truncar(($cat->texe+$cat->base+$ivabs),2) ?>"  class="form-control">
            		</div>
            	</div>
				<div class="col-lg-3 col-sm-3 col-md-3 col-xs-3">
            		 <div class="form-group">
            			<label for="nombre">Base</label>
            			<input type="text" name="mbase" id="mbase{{$cat->idventa}}" required value="{{$cat->base}}"  class="form-control">
            		</div>
            	</div>
				<div class="col-lg-3 col-sm-3 col-md-3 col-xs-3">
            		 <div class="form-group">
            			<label for="nombre">Iva</label>
            			<input type="text" name="miva" id="miva{{$cat->idventa}}" required value="{{$ivabs}}"  class="form-control">
            		</div>
            	</div>
				<div class="col-lg-3 col-sm-3 col-md-3 col-xs-3">
            		 <div class="form-group">
            			<label for="nombre">Exento</label>
            			<input type="text" name="mexen" id="mexen{{$cat->idventa}}" required value="{{$cat->texe}}"  class="form-control">
            		</div>
            	</div>
				<div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
					<div class="col-lg-6 col-sm-6 col-md-6 col-xs-6">
                 		 <div class="form-group">
            			<label>Monto retencion</label>
					<input type="number" id="mret{{$cat->idventa}}" name="mret" step="0.0001" class="form-control" value="<?php echo truncar(($pret*$ivabs),2); ?>"></input>
					<input type="hidden" id="tasafac{{$cat->idventa}}" name="tasafac" value="{{$cat->tasa}}" class="form-control"></input>
					<input type="hidden" id="factura{{$cat->idventa}}" name="factura" value="{{$cat->idventa}}" class="form-control"></input>
					<input type="hidden" name="idp" value="{{$cliente->id_cliente}}" class="form-control"></input>
					<input type="hidden" name="docu" value="{{ $cat->serie_comprobante}}" class="form-control"></input>
            		</div>
            	</div>			
				<div class="col-lg-6 col-sm-6 col-md-6 col-xs-6">
            		 <div class="form-group">
            			<label for="nombre">$ Retencion</label>
            			<input type="number" name="mretd" id="mretd{{$cat->idventa}}" step="0.0001" value=""  class="form-control">
            		</div>
            	</div>

            	</div>
			</div>
			<div class="modal-footer">
				<button type="button" id="closeret{{$cat->idventa}}" class="btn btn-default" data-dismiss="modal">Cerrar</button>
				<button type="submit" id="sendretf{{$cat->idventa}}" class="btn btn-primary">Confirmar</button>
			</div>
		</div>
		
		{{Form::Close()}}
</div>
@push ('scripts')
<script>
$("#ncomp<?php echo $cat->idventa; ?>").on("change",function(){
  	document.getElementById('sendretf<?php echo  $cat->idventa; ?>').style.display=""; 
});	
function trunc (x, posiciones = 0) {
  var s = x.toString()
  var l = s.length
  var decimalLength = s.indexOf('.') + 1
  var numStr = s.substr(0, decimalLength + posiciones)
  return Number(numStr)
}
	var tret=$("#ntbs").val();
	var retbs=$("#mret<?php echo $cat->idventa; ?>").val();
	var calculo=trunc((parseFloat(retbs)/parseFloat(tret)),2);

	document.getElementById('sendretf<?php echo  $cat->idventa; ?>').style.display="none"; 	
$("#mretd<?php echo  $cat->idventa; ?>").val(calculo);

</script>
@endpush