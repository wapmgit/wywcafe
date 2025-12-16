@extends ('layouts.admin')
@section ('contenido')
<?php
$fserver=date('Y-m-d');
$fecha_a=$empresa -> fechasistema;
function dias_transcurridos($fecha_a,$fserver)
{
$dias = (strtotime($fecha_a)-strtotime($fserver))/86400;
//$dias = abs($dias); $dias = floor($dias);
return $dias;
} 
$vencida=0;
 $vali=count($personas);
if (dias_transcurridos($fecha_a,$fserver) < 0){
  $vencida=1;
  echo "<div class='alert alert-danger'>
      <H2>LICENCIA DE USO DE SOFTWARE VENCIDA!!!</H2> contacte su Tecnico de soporte.
      </div>";
};
  
?>
	    @include('compras.ingreso.modalproveedor')
		<div class="row">

		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
			<h3>Nuevo Gasto</h3>
			@if (count($errors)>0)
			<div class="alert alert-danger">
				<ul>
				@foreach ($errors->all() as $error)
					<li>{{$error}}</li>
				@endforeach
				</ul>
			</div>
			@endif
        </div>
        </div>
			{!!Form::open(array('url'=>'gastos/gasto','method'=>'POST','autocomplete'=>'off','id'=>'formajuste'))!!}
            {{Form::token()}}
	<div class="row">
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <div class="form-group">
						<input type="hidden" value="{{$empresa->tc}}" id="valortasa" name="tc" class="form-control">
			<input type="hidden" value="{{$empresa->peso}}" id="valortasap" name="peso" class="form-control">
                    	<label for="proveedor">Razon </label> <a href="" data-target="#modalproveedor" data-toggle="modal"><span class="label label-success">Nuevo <i class="fa fa-fw  fa-user "> </i></span></a>
                    	<select name="idproveedor" id="idproveedor" class="form-control selectpicker" data-live-search="true">
                           @foreach ($personas as $per)
                           <option value="{{$per -> idproveedor}}_{{$per->rif}}_{{$per->nombre}}">{{$per -> nombre}}</option> 
                           @endforeach
                        </select>
                    </div>
                </div>
				             <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                <div class="form-group">
                    <label for="concepto">Factura</label>
                    <input type="text" name="documento" id="concepto" value="{{old('concepto')}}" class="form-control"placeholder="Documento Fac" > 
                </div>
            </div> 
			<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                <div class="form-group">
                    <label for="concepto">Nro Control</label>
                    <input type="text" name="control"  value="{{old('control')}}" class="form-control"placeholder="Nro Control" > 
                </div>
            </div>
						<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                <div class="form-group">
                    <label for="concepto">Tasa</label>
                    <input type="number" name="tasa" step="0.0001" value="{{$empresa->tc}}" class="form-control" > 
                </div>
            </div>
            </div>
            <div class ="row" <?php if ($vali==0){?>  style="display: none" <?php } ?> id="cgasto">
    	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="form-group">
			<label for="responsable">Descripcion</label>
			<input type="text"  name="descripcion"  id="descripcion" value="" class="form-control" placeholder="Descripcion Gasto">
		</div>
	</div>
	<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                    <div class="form-group">
                        <label for="costo">Base Imponible</label>
                        <input type="number" name="base" id="bi" step="0.001" class ="form-control" min="0" value="0">
                    </div>
     </div>
	<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                    <div class="form-group">
                        <label for="costo">Impuesto</label>
                        <input type="number" name="iva" id="iva" step="0.001" class ="form-control"  min="0" value="0" >
                    </div>
	</div>
	<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                    <div class="form-group">
                        <label for="costo">Exento</label>
                        <input type="number" name="exento" id="exe" step="0.001" class ="form-control" min="0" value="0">
                    </div>
	</div>
	<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                    <div class="form-group">
                        <label for="costo">Total</label>
                        <input type="number" name="monto" id="pcosto"  step="0.001" class ="form-control"  placeholder="Total">
                    </div>
	</div>

                    
           
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" id="guardar" align="right">
            	    <div class="form-group">
                    <input name="_token" value="{{ csrf_token() }}" type="hidden" ></input>
                        <button class="btn btn-primary" type="button" id="btnguardar">Procesar</button>
            	       <button class="btn btn-danger" type="reset" id="btncancelar">Cancelar</button>
                    </div>
                </div>
     
        </div>
		<div class ="row" id="divdesglose" style="display: none">
                <div class="panel panel-primary">
                <div class="panel-body">
                <div class="modal-content">
					   <div class="modal-header" align="center">
					   <h3 >TOTAL <input type="number" id="divtotal" value="" disabled ><span id="pasapago" title="haz click para hacer cobro total">RESTA</span> <input type="number" id="resta" disabled value="">
						<input type="hidden" name="tdeuda" id="tdeuda" value=""  >
			
					   </div>
                   <div class="modal-body">
					   <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
						<div class="form-group">
						<select name="pidpago" id="pidpago" class="form-control">
							<option value="10" selected="selected">Selecione...</option>
						@foreach ($monedas as $m)
							<option value="{{$m->tipo}}">{{$m->idmoneda}}-{{$m->nombre}}</option>
						@endforeach
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
										  <th><h3 id="total_abono">$.  0.00</h3></th><input type="hidden" value="0" name="totala" id="totala">
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
								  <div style="display: none" id="loading">  <img src="{{asset('imagenes/sistema/loading30.gif')}}"></div>
					  
						</div>
					</div>
				</div>
                </div>
                </div>{!!Form::close()!!}
        </div>	
       
@push ('scripts')
<script>

 
$(document).ready(function(){
$("#guardar").hide();
$("#bi").change(sumtotal); 
$("#iva").change(sumtotal); 
$("#exe").change(sumtotal); 
$("#pcosto").change(validar); 
 $('#btnguardar').click(function(){   
 if($("#concepto").val() == "" ){alert('Debe indicar Documento y Decripcion.'); } else{
 if($("#pcosto").val() == "" ){alert('Debe Monto.');}else{ 
 $('#guardar').fadeOut("fast"); 
$('#divdesglose').fadeIn("fast"); }	 }
    })
				 $('#regresar').click(function(){
			  $('#divdesglose').fadeOut("fast");
			})
				$('#pasapago').click(function(){
			datosbanco=$("#pidpago").val();
			if(datosbanco<10){
			$("#pmonto").val($("#resta").val());
			document.getElementById('bt_pago').style.display=""; 
			$("#preferencia").focus();
			}else{ alert('¡Debe seleccionar un tipo de Pago!');}
			})
		$("#pidpago").change(mediopago);
		$('#procesa').click(function(){

				document.getElementById('loading').style.display=""; 
				document.getElementById('procesa').style.display="none"; 
				document.getElementById('regresar').style.display="none"; 
			// alert('Gasto Procesado con exito.');

			});
		$('#bt_pago').click(function(){		
			 agregarpago();
			});
							// registrar nuevo proveedor	  
			   $("#Nenviar2").on("click",function(){
				   if ($("#cnombre").val()==""){ alert ('Debe indicar Nombre de Provedor'
				   );}else{
				   document.getElementById('Nenviar2').style.display="none";
					 var form2= $('#formularioproveedor');
					var url2 = form2.attr('action');
					var data2 = form2.serialize();
			  
					$.post(url2,data2,function(result){  
						var resultado2=result;
						console.log(resultado2);	
						var nombre2=resultado2[0].nombre;  
						var id2=resultado2[0].idproveedor;  		  
						$("#idproveedor")
						.append( '<option value="'+id2+'">'+nombre2+'</option>')
						.selectpicker('refresh');
						alert('Proveedor Registrado con exito');
						 $("#formularioproveedor")[0].reset();
					});
			  document.getElementById('Nenviar2').style.display="";
				   }
				 });
          });

 function validar(){  
	var total=$("#pcosto").val();  	
	$("#guardar").show();
	$("#divtotal").val(total);
	 $("#resta").val(total);
    }
	//agrego tipo pago
	acumpago=[];var contp=0; var pagototal=0; var tresta=0;
function agregarpago(){ 
	 	//	alert();
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
				if (idpago==1){ 
			    var pesoresta =$("#resta").val();  
				var vdolar=$("#valortasa").val();  
				$("#resta").val(pesoresta/vdolar);  
				$("#total_abono").text(pagototal/vdolar);
				    denomina=pmonto;
					pmonto=pmonto/vdolar;		
					acumpago[contp]=(pmonto.toFixed(2)); 
			}             
			pagototal=parseFloat(pagototal)+parseFloat(acumpago[contp]); 
			//alert(pagototal);
			tventa=$("#divtotal").val();
			tresta=(parseFloat(tventa)-parseFloat(pagototal));
            $("#resta").val(tresta.toFixed(2));
            $("#tdeuda").val(tresta.toFixed(2));	
            var fila='<tr  id="filapago'+contp+'"><td align="center"><span onclick="eliminarpago('+contp+');"><i class="fa fa-fw fa-eraser"></i></span></td><td><input type="hidden" name="tidpago[]" value="'+idpago+'"><input type="hidden" name="tidbanco[]" value="'+tpago+'">'+tpago+'</td><td><input type="hidden" name="denominacion[]" value="'+denomina+'">'+denomina+'</td><td><input type="hidden" name="tmonto[]" value="'+pmonto+'">'+pmonto+'</td><td><input type="hidden" name="tref[]" value="'+pref+'">'+pref+'</td></tr>';
            contp++;
            document.getElementById('bt_pago').style.display="none";
			$("#pidpago").val('10');
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
		$("#totala").val(nv);		
        pagototal=(parseFloat(pagototal)-parseFloat(total));
        $("#filapago" + index).remove();
        $("#total_abono").text(nc.toFixed(2));
    }
	   function mediopago(){
	   	var totala=$("#totala").val();
		//alert(totala);
	    document.getElementById('bt_pago').style.display="";	
		var pesototal =$("#divtotal").val();		
		var pesoresta =pesototal-parseFloat(totala); 
		datosbanco=$("#pidpago").val();
		nbanco=$("#pidpago option:selected").text();
			if (datosbanco==1){ 
			var vdolar=$("#valortasa").val();  
			var auxresta=((pesoresta*vdolar).toFixed(2));	//alert(auxresta);		
			$("#resta").val(auxresta);  
			$("#preferencia").val('Tc: '+vdolar);  
			}
			if (datosbanco==2){ 
			var vpeso=$("#valortasap").val(); 
			var auxresta=((pesoresta*vpeso).toFixed(2));	//alert(auxresta);					
			$("#resta").val(auxresta); 
			$("#preferencia").val('Tc: '+vpeso);  			
			}   
			if (datosbanco==0){ 			
				$("#resta").val(pesoresta);  
			}
		$("#pmonto").attr('placeholder','Monto en '+nbanco);
		t_pago=$("#pidpago").val();
    }
		 function sumtotal(){  
	var total=$("#bi").val();  	
	var total2=$("#iva").val();  	
	var total3=$("#exe").val();
	var ttp=parseFloat(total)+parseFloat(total2)+parseFloat(total3);
	 $("#pcosto").val(ttp);
	 var total=$("#pcosto").val();  	
	$("#guardar").show();
	$("#divtotal").val(total);
	 $("#resta").val(total);
	 $("#tdeuda").val(total);
    }
</script>
@endpush
@endsection