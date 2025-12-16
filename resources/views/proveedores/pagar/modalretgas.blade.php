<div class="modal fade modal-slide-in-right" aria-hidden="true"
role="dialog" tabindex="-1" id="modalretgas{{$cat->idgasto}}">
		{!!Form::open(array('url'=>'/cxp/retenciongas','method'=>'POST','autocomplete'=>'off','id'=>'formulariocliente'))!!}
            {{Form::token()}}
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" 
				aria-label="Close">
                     <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title">GENERAR RETENCION EN GASTO:  Doc -> {{$cat->documento}}</h4>
			</div>
			<div class="modal-body">
				<p>		<label>Tipo de Retencion</label>	<select name="idretencg" id="idretencg{{$cat->idgasto}}" class="form-control">
				<option value="0">Seleccione...</option>
            				@foreach ($retenc as $re)<?php if($re->beneficiar==$proveedor->tpersona){?>
            				<option value="{{$re->codigo}}_{{$re->ret}}_{{$re->afiva}}">{{$re->descrip}}</option><?php } ?>
            				@endforeach							
						</select>
				</p>
				<div class="col-lg-3 col-sm-3 col-md-3 col-xs-3">
            		 <div class="form-group">
            			<label for="nombre">M.Fac</label>
            			<input type="text" name="mfacg" id="mfacg{{$cat->idgasto}}" required value="{{$cat->monto*$cat->tasa}}"  class="form-control">
            		</div>
            	</div>
				<div class="col-lg-3 col-sm-3 col-md-3 col-xs-3">
            		 <div class="form-group">
            			<label for="nombre">Base</label>
            			<input type="text" name="mbaseg" id="mbaseg{{$cat->idgasto}}" required value="{{$cat->base*$cat->tasa}}"  class="form-control">
            		</div>
            	</div>
				<div class="col-lg-3 col-sm-3 col-md-3 col-xs-3">
            		 <div class="form-group">
            			<label for="nombre">Iva</label>
            			<input type="text" name="mivag" id="mivag{{$cat->idgasto}}" required value="{{$cat->iva*$cat->tasa}}"  class="form-control">
            		</div>
            	</div>
				<div class="col-lg-3 col-sm-3 col-md-3 col-xs-3">
            		 <div class="form-group">
            			<label for="nombre">Exento</label>
            			<input type="text" name="mexeng" id="mexeng{{$cat->idgasto}}" required value="{{$cat->exento*$cat->tasa}}"  class="form-control">
            		</div>
            	</div>
				<div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
					<div class="col-lg-6 col-sm-6 col-md-6 col-xs-6">
                 		 <div class="form-group">
            			<label>Monto retencion</label>
					<input type="number" id="mretg{{$cat->idgasto}}" name="mretg" step="0.001" class="form-control"></input>
					<input type="hidden" id="tasafacg{{$cat->idgasto}}" name="tasafacg" value="{{$cat->tasa}}" class="form-control"></input>
					<input type="hidden" id="facturag{{$cat->idgasto}}" name="facturag" value="{{$cat->idgasto}}" class="form-control"></input>
					<input type="hidden" name="idpg" value="{{$proveedor->idproveedor}}" class="form-control"></input>
					<input type="hidden" name="docug" value="{{ $cat->documento}}" class="form-control"></input>
            		</div>
            	</div>			
				<div class="col-lg-6 col-sm-6 col-md-6 col-xs-6">
            		 <div class="form-group">
            			<label for="nombre">$ Retencion</label>
            			<input type="number" name="mretdg" id="mretdg{{$cat->idgasto}}" step="0.001" value=""  class="form-control">
            		</div>
            	</div>

            	</div>
			</div>
			<div class="modal-footer">
				<button type="button" id="closeretg{{$cat->idgasto}}" class="btn btn-default" data-dismiss="modal">Cerrar</button>
				<button type="submit" id="sendretg{{$cat->idgasto}}" class="btn btn-primary">Confirmar</button>
			</div>
		</div>
	</div>
	{{Form::Close()}}
</div>
@push ('scripts')

<script>
$(document).ready(function(){
		document.getElementById('sendretg<?php echo  $cat->idgasto; ?>').style.display="none"; 
		$('#idretencg<?php echo  $cat->idgasto ?>').on("change",function(){			
		var iva=$("#mivag<?php echo  $cat->idgasto ?>").val();
		var base= $("#mbaseg<?php echo  $cat->idgasto ?>").val();
		retencion= $("#idretencg<?php echo  $cat->idgasto ?>").val();
		tm=retencion.split('_');
		  prete=tm[1];
		  apiva=tm[2];
		  if(apiva==1){ tret=(iva*(prete/100));
		 $("#mretg<?php echo  $cat->idgasto ?>").val(tret);
		 $("#mretdg<?php echo  $cat->idgasto ?>").val(tret/$("#tasafacg<?php echo  $cat->idgasto?>").val());
		 }else{ 
			tret=(base*(prete/100));
			$("#mretg<?php echo  $cat->idgasto ?>").val(tret);
			$("#mretdg<?php echo $cat->idgasto ?>").val(tret/$("#tasafacg<?php echo  $cat->idgasto ?>").val());
		 }
		 			document.getElementById('sendretg<?php echo  $cat->idgasto ?>').style.display=""; 
			});
			$('#closeretg<?php echo  $cat->idgasto; ?>').on("click",function(){
			$("#mretg<?php echo  $cat->idgasto; ?>").val(0);
			$("#mretdg<?php echo  $cat->idgasto; ?>").val(0);
			document.getElementById('sendretg<?php echo  $cat->idgasto; ?>').style.display="none"; 
			});
});
</script>
@endpush