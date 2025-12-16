@extends ('layouts.admin')
@section ('contenido')
<?php $acum=0; $acum2=0;?>
<div class="row">
	<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
		<h3>Detalles de Cuentas por Cobrar</h3>

	</div>
</div>
	
<div class="row">
	  <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">

                 <div class="form-group">
                      <label for="proveedor">Nombre</label>
                   <p>{{$cliente->nombre}}</p>
                    </div>
            </div>
             <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">

                 <div class="form-group">
                      <label for="proveedor">Cedula</label>
                   <p>{{$cliente->cedula}}</p>
                    </div>
            </div>
             <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">

                 <div class="form-group">
                      <label for="proveedor">Telefono</label>
                   <p>{{$cliente->telefono}}</p>
                    </div>
            </div>
</div>

<div class="row">
<div class="panel panel-primary">
                <div class="panel-body">
               <div class="modal-content">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="table-responsive">
			<table class="table table-striped table-bordered table-condensed table-hover">
				<thead style="background-color: #A9D0F5">
					<th>Tipo de Venta</th>
					<th>N° Comprobante</th>
					<th>Fecha</th>
					<th>Monto</th>
					<th>Por Cobrar</th>
					<th>Abonar</th>
					
				
				</thead>
               @foreach ($datos as $cat)
               <?php 
               $acum=$cat->saldo+$acum; 
               $acum2=$cat->total_venta+$acum2; 
               ?>
				<tr>
          @include('pacientes.cobrar.modal')
					<td>{{$cat->tipo_comprobante}}</td>
					<td>{{$cat->serie_comprobante}}-{{$cat->num_comprobante}}</td>
					<td>{{ $cat->fecha_hora}}</td>
					<td><?php echo number_format($cat->total_venta, 2,',','.'); ?> </td>
					<td><?php echo number_format($cat->saldo, 2,',','.'); ?> </td>
			
					<td><a href="javascript:abrirespecial({{$cat->idventa}},{{$cat->saldo}});"><button  id="abono" class="btn btn-info">Abono</button></a>
            <a href="{{URL::action('CxcobrarController@edit',$cat->idventa)}}"><button class="btn btn-success">Detalle</button></a>

          </td>
				

				</tr>

				@endforeach
				<tr>
				<td></td><td></td><td><strong>TOTAL:</strong></td><td style="background-color: #A9D0F5"><?php echo number_format($acum2, 2,',','.'); ?> </td><td style="background-color: #A9D0F5"><?php echo number_format($acum, 2,',','.'); ?> </td><td></td>
				</tr>
			</table>
		</div>
		{{$datos->render()}}
	</div>
	</div>
	</div>
	</div>
</div>
	{!!Form::open(array('url'=>'pacientes/cobrar','method'=>'POST','autocomplete'=>'off'))!!}
            {{Form::token()}}
<div class ="row" id="divdesglose" style="display: none">
                <div class="panel panel-primary">
                <div class="panel-body">
                <div class="modal-content">
					   <div class="modal-header" align="center">
					   <input type="hidden" value="{{$empresa->tc}}" id="valortasa" name="tc" class="form-control">
		 <input type="hidden" value="{{$empresa->peso}}" id="valortasap" name="peso" class="form-control">
		  <input type="hidden" value="" id="total_venta" name="total_venta" class="form-control">
		 <input type="hidden" value="" id="venta" name="venta" class="form-control">
					   <h3 >TOTAL <input type="number" id="divtotal" value="" disabled ><span id="pasapago" title="haz click para hacer cobro total">RESTA</span> <input type="number" id="resta" disabled value="">
						<input type="hidden" name="tdeuda" id="tdeuda" value="" class="form-control"> 
			
					   </div>
                   <div class="modal-body">
					   <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
						<div class="form-group">
						<select name="pidpago" id="pidpago" class="form-control">
						<option value="5" selected="selected">Selecione...</option>
						<option value="0">Dolares</option>
						<option value="1">Transf. $</option>
						<option value="2">Pesos</option>
						<option value="3">Bolivares</option>
						</select>
						</div>
						</div>
						<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
						<div class="form-group">
						<input type="number" class="form-control" name="pmonto" id="pmonto" placeholder=""  min="1" step="0.01">
						</div>
						</div>
						<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
						<div class="form-group">
						<input type="text" name="preferencia" class="form-control" id="preferencia" onchange="conMayusculas(this);" placeholder="Referencia...">
						</div>
						</div>
						<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
						<div class="form-group">
						<button type="button" id="bt_pago" class="form-control" > <i class="fa fa-fw fa-plus-square"></i> </button>
						</div>
						</div>
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<table id="det_pago" class="table table-striped table-bordered table-condensed table-hover">
                      <thead style="background-color: #54b279">
                          <th>Supr</th>
                          <th width="15%">Tipo</th>
						   <th width="15%">Monto</th>
                          <th>Monto $</th>
                          <th>Referencia</th>

                      </thead>
                      <tfoot> 
                      <th></th>
                          <th></th>
						   <th></th>
                          <th><h3>Total $</h3></th>
                          <th><h3 id="total_abono">$.  0.00</h3></th><input type="hidden" name="totala" id="totala">
                          </tfoot>
                      <tbody></tbody>
                    </table>
	
					</div>
						</div>
					  <div class="modal-footer">
						<div class="col-lg-12 ol-md-12 col-sm-12 col-xs-12">
						<button type="button" class="btn btn-danger" id="regresar" data-dismiss="modal">Cancelar</button>
						<input name="_token" value="{{ csrf_token() }}" type="hidden" ></input>
						<button type="submit" id="procesa" class="btn btn-primary">Procesar</button>
					  
						</div>
					  </div>
				</div>
                </div>
                </div>
				</div>
    
      		{!!Form::close()!!}	
@endsection

@push ('scripts')

<script>
$(document).ready(function(){
	 document.getElementById('bt_pago').style.display="none";
		 $('#pasapago').click(function(){
   // alert();
	datosbanco=$("#pidpago").val();
	if(datosbanco<4){
	$("#pmonto").val($("#resta").val());
	document.getElementById('bt_pago').style.display=""; 
	$("#preferencia").focus();
	}else{ alert('¡Debe seleccionar un tipo de Pago!');}
    })
	 $("#pidpago").change(mediopago);
	  $('#bt_pago').click(function(){
	    agregarpago();
  });   
      $('#regresar').click(function(){	
	 pagototal=0;	 $("#resta").val($("#total_venta").val());
	   $("#total_abono").text("0.0");
	     $("#tdeuda").val($("#total_venta").val());
	  $("#total").val(0);
      $('#divdesglose').fadeOut("fast");
    $('#divarticulos').fadeIn("fast");
	for(var i=0;i<10;i++){
	 $("#filapago" + i).remove(); acumpago[i]=0; }
    })
});
// calculo pago
   function mediopago(){
	    document.getElementById('bt_pago').style.display="";		
	   var pesoresta =$("#resta").val();  
       var pesototal =$("#divtotal").val();
		  datosbanco=$("#pidpago").val();
			if (datosbanco==2){ 
			var vpeso=$("#valortasap").val();  
				$("#resta").val(pesoresta*vpeso);  
			}
			if (datosbanco==3){ 
				var vdolar=$("#valortasa").val();  
				$("#resta").val(pesoresta*vdolar);  
				}   
		t_pago=$("#pidpago").val();
    }
acumpago=[];var contp=0; var tresta=0; var pagototal=0;
	function agregarpago(){ 
	
         vresta=$("#resta").val();    
		 idpago=$("#pidpago").val();
        tpago= $("#pidpago option:selected").text();
        pmonto= $("#pmonto").val();
        pref= $("#preferencia").val();
 
		if(parseFloat(pmonto)<=parseFloat(vresta)){
			var denomina=pmonto;
			acumpago[contp]=(pmonto);
		//	alert(acumpago[contp]);
			if (idpago==2){ 
			     var pesoresta =$("#resta").val();  
				var vpeso=$("#valortasap").val();  
				$("#resta").val(pesoresta/vpeso);  
				   $("#total_abono").text(pagototal/vpeso);
				    denomina=pmonto;
					pmonto=pmonto/vpeso;		
					acumpago[contp]=(pmonto.toFixed(2)); 
			}  
				  if (idpago==3){ 
			     var pesoresta =$("#resta").val();  
				var vdolar=$("#valortasa").val();  
				$("#resta").val(pesoresta/vdolar);  

				   $("#total_abono").text(pagototal/vdolar);
				    denomina=pmonto;
					pmonto=pmonto/vdolar;		
					acumpago[contp]=(pmonto.toFixed(2)); 
			}    
		    
        pagototal=parseFloat(pagototal)+parseFloat(acumpago[contp]); 
		//salert(pagototal);
        tventa=$("#divtotal").val();
        tresta=(parseFloat(tventa)-parseFloat(pagototal));
            $("#resta").val(tresta.toFixed(2));
            $("#tdeuda").val(tresta.toFixed(2));	
            var fila='<tr  id="filapago'+contp+'"><td align="center"><span onclick="eliminarpago('+contp+');"><i class="fa fa-fw fa-eraser"></i></span></td><td><input type="hidden" name="tidpago[]" value="'+idpago+'"><input type="hidden" name="tidbanco[]" value="'+tpago+'">'+tpago+'</td><td><input type="hidden" name="denominacion[]" value="'+denomina+'">'+denomina+'</td><td><input type="hidden" name="tmonto[]" value="'+pmonto+'">'+pmonto+'</td><td><input type="hidden" name="tref[]" value="'+pref+'">'+pref+'</td></tr>';
            contp++;
            document.getElementById('bt_pago').style.display="none";
			$("#pidpago").val('5');
      $("#total_abono").text(pagototal.toFixed(2));
	  $("#totala").val(pagototal.toFixed(2));
	//  alert($("#totala").val());
           limpiarpago();		 
             $('#det_pago').append(fila);
		}else{ alert('¡El monto indicado no debe se mayor al saldo pendiente!');
 limpiarpago();		}
	}
	  function limpiarpago(){
        $("#pmonto").val("");
        $("#preferencia").val("");
    }
		    function eliminarpago(index){
        total=acumpago[index];
        resta=$("#resta").val();
        var1=$("#total_abono").text();
        nv=(parseFloat(resta)+parseFloat(total));
        nc=(parseFloat(var1)-parseFloat(total));
        $("#resta").val(nv);   
        $("#tdeuda").val(nv);  
        pagototal=(parseFloat(pagototal)-parseFloat(total));
        $("#filapago" + index).remove();
        $("#total_abono").text(nc.toFixed(2));
    }
function abrirespecial(idventa,saldo){  
      $('#divdesglose').fadeIn("fast");
      $("#divtotal").val(saldo);
      $("#resta").val(saldo);
      $("#venta").val(idventa); 
	  $("#total_venta").val(saldo); 
}

</script>
@endpush