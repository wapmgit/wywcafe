<div class="modal fade modal-slide-in-right" aria-hidden="true"
role="dialog" tabindex="-1" id="modalmultiple" >
  	{!!Form::open(array('url'=>'/cxc/multiple','method'=>'POST','autocomplete'=>'off'))!!}
 {{Form::token()}}
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header" style="background-color: #6495ed">
				<button type="button" class="close" data-dismiss="modal" 
				aria-label="Close">
                     <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title">Abono Multiples: <?php echo $ndoc=count($datos );?> Documentos  </h4>
			
			</div>
			<div class="modal-body">
				<h5 align="center">Cliente: <b>{{$cliente->cedula}} -> {{$cliente->nombre}}</b></h5>
			<h3 align="center">Por Cobrar: <?php echo number_format($acumf, 2,',','.'); ?> $. </h3>
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<div class="form-group">
						<select name="pidpagom" id="pidpagom" class="form-control">
					<option value="100" selected="selected">Selecione...</option>
						@foreach ($monedas as $p)<?php $count2++;?>
						<option id=vmm<?php echo $count2; ?> value="{{$p-> idmoneda}}_{{$p->tipo}}_{{$p->valor}}">{{$p -> nombre}}</option>
						@endforeach
						</select>
						</div>
		</div>
		       <table class="table table-striped table-bordered table-condensed table-hover">                  
                      <tbody>
					  <tr>
					  <td><label>Abono: </label><input type="number" name="montom" class="form-control" step="0.01" id="pmontom" value="0"></td>
					  <td><label>Resta: </label><input type="text" name="montop" class="form-control" id="pmontomresta"  value="<?php echo $acumf; ?>" readonly>
					  <input type="hidden" name="pmresta" id="pmresta" value="<?php echo $acumf; ?>" >
					  <input type="hidden" name="pmaux" id="pmaux" value="<?php echo $acumf; ?>" >
					  <input type="hidden" name="cliente" value="{{$cliente->id_cliente}}" >
					  <input type="hidden" name="ndocs" value="<?php echo $ndoc; ?>" >
					  <input type="hidden" id="nmoneda" name="nmoneda" value="" >
					  </td>
					  </tr>
					  </tbody>
                  </table>
				  <div>
				  </div>
			</div>
			<div class="modal-footer" style="background-color: #6495ed">
				<button type="button" id="btn-cerraram" class="btn btn-default" data-dismiss="modal">Cerrar</button>
				<button type="submit" id="send_am" class="btn btn-primary" style="display:none">Confirmar</button>
			</div>
		</div>
	</div>
	{!!Form::close()!!}	
</div>
@push ('scripts')

<script>
$(document).ready(function(){
			$('#pmontom').on("change",function(){				
			var pmab=$("#pmontom").val();
			var pmre=$("#pmresta").val();
			if(pmab>parseFloat(pmre)){alert('El monto no Puede ser mayor al monto por Cobrar');
			$("#pmontom").val(0);
			$("#pmontom").focus();
			}
			else{
				var tmab =parseFloat(pmre)-parseFloat(pmab);
				$("#pmontomresta").val(tmab);
				document.getElementById('send_am').style.display=""; 
			}
			});
		$('#pidpagom').on("change",function(){	
		tmoneda= $("#pidpagom option:selected").text();
		$("#nmoneda").val(tmoneda);
		var pmrem=$("#pmaux").val();
	     moneda= $("#pidpagom").val();
		 tm=moneda.split('_');
		  tipom=tm[1];
		  valort=tm[2];
		   	if (tipom==0){   
				$("#pmontomresta").val(pmrem);  
				$("#pmresta").val(pmrem);  
				}  
			if (tipom==1){ 
				$("#pmontomresta").val(parseFloat(pmrem)*parseFloat(valort));  				
				$("#pmresta").val(parseFloat(pmrem)*parseFloat(valort));  				
			}
			if (tipom==2){   
				$("#pmontomresta").val(pmrem/valort);   
				$("#pmresta").val(pmrem/valort);   
				}  				
    });
});
</script>
@endpush
