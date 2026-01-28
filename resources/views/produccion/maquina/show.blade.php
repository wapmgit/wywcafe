@extends ('layouts.admin')
@section ('contenido')
<style type="text/css">
#global {
	height: 400px;
	width: 100%;
	border: 1px solid #ddd;
	background: #f1f1f1;
	overflow-y: scroll;
}
</style>
<?php  $fecha=date("Y-m-d"); $acum=0;?>
		       <div class="row">
			   <div class="col-lg-12 col-md-12 col-sm-6 col-xs-12">
			   	<h3 align="center"> DETALLE MAQUINARIA</h3>
				</div>
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                 <div class="form-group">
                      <label for="proveedor">Nombre Deposito</label>
                   <p>{{$tosta->nombre}}</p>
                    </div>
            </div>
             <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                 <div class="form-group">
                      <label for="proveedor">Marca</label>
                   <p>{{$tosta->marca}}</p>
                    </div>
            </div>            
			<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                 <div class="form-group">
                      <label for="proveedor">Capacidad</label>
                   <p>{{$tosta->capacidad}}</p>
                    </div>
            </div>
            </div>
            <div clas ="row">
                <div class="panel panel-primary">
                <div class="panel-body">
				   <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
				<div id="global">              
                  <table id="detalles" class="table table-striped table-bordered table-condensed table-hover">
                          <thead style="background-color: #A9D0F5">                     
                          <th colspan="8">Detalle Produccion</th>
					  <thead style="background-color: #A9D0F5">
                     
                          <th>Cod.</th>
                          <th>Fecha</th>
                          <th>Materia Prima</th>
                          <th>Cochas</th>
                          <th>Kg Subidos</th>
                          <th>Kg Bajados</th>
                          <th>Comision</th>
                          <th>Kg. Comi.</th>
              </thead><?php $acumco=0; $acumkgs=0; $acumkgb=0; $kgcomi=0;?>
                      <tbody>
                        @foreach($produccion as $det)
                        <tr > <?php $acumco=($acumco+$det->cochas); $acumkgs=($acumkgs+$det->kgmprima);
						$acumkgb=($acumkgb+$det->kgtostado); $kgcomi=($kgcomi+$det->kgcomi); ?>
                          <td>{{$det->idt}}</td>
                          <td>{{$det->nombre}}</td>
                          <td><?php echo date("d-m-Y",strtotime($det->fecha)); ?></td>
                          <td>{{$det->cochas}}</td>
                          <td>{{$det->kgmprima}}</td>
                          <td>{{$det->kgtostado}}</td>
                          <td>{{$det->comision}}</td>
                          <td>{{$det->kgcomi}}</td>                         
                        </tr>
                        @endforeach
                      </tbody> 
					  <tr><td colspan="3">Total: </td><td><strong><?php echo number_format($acumco, 2,',','.');?></strong></td>
					  <td><strong><?php echo number_format($acumkgs, 2,',','.');?></strong></td>
					  <td><strong><?php echo number_format($acumkgb, 2,',','.');?></strong></td>
					  <td><strong></td>
					  <td><strong><?php echo number_format($kgcomi, 2,',','.');?></strong></td></tr>
                  </table>
                 
                    </div>

                </div> 
<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
  <div class="col-lg-12 col-md-12 col-sm-6 col-xs-12">
		<table class="table table-striped table-bordered table-condensed table-hover">
		<tr ><td colspan="2" align="center"><strong>Saldo</strong></td>
		<td> Tasa Cafe:<input type="number" value="9" style="width: 60px" id="txk" name="txk" class="form-control"></td></tr> 
		<tr>
		<td>Kg</td>
		<td>Pendiente</td>		
		<td>Opc.</td>		
		</tr>
		<tr>
		<td>{{$tosta->kg}} </td>
		<td>{{$tosta->pendiente}}</td>	
		<td><?php if($tosta->pendiente>0){?><a href="javascript:abrirespecial({{$tosta->iddep}},{{$tosta->pendiente}});"><button  id="abono" class="btn btn-info btn-xs">Abono</button></a><?php } ?></td>	
		</tr>
		</table>
</div>			
<div class="col-lg-12 col-md-12 col-sm-6 col-xs-12">
<table border="1" width="100%" >
                      <thead style="background-color: #A9D0F5">
						<th>Tipo</th>
                          <th>Monto</th>
						  <th>Tasa</th>
                          <th>Monto$</th>
                          <th>Referencia</th>
                          
                      </thead>
              
                      <tbody>
                     @foreach($pago as $re) <?php  $acum=$acum+$re->monto;?>
                        <tr >
                          <td>{{$re->idbanco}}</td>
                          <td><?php echo number_format( $re->recibido, 2,',','.'); ?></td>
						      <td> <?php if ($re->idpago==2){echo number_format( $re->tasap, 2,',','.'); }
							  if ($re->idpago==3){echo number_format( $re->tasab, 2,',','.'); }?></td>
						   <td><?php echo number_format( $re->monto, 2,',','.'); ?></td>
                          <td>{{$re->referencia}}  <?php echo date("d-m-Y",strtotime($re->fecha_comp)); ?></td>                        
                        </tr>
                        @endforeach
                        <tfoot>                    
                          <th colspan="3">Total</th>
						  <th><?php echo number_format( $acum, 2,',','.');?> $</th>
                          <th ><b> Pendiente: <?php echo number_format( ($tosta->pendiente), 2,',','.');?></b></h4></th>
                          </tfoot>
                       
                      </tbody>
                  </table>
</div>
                </div>                   
                </div>                   
                </div>
		<div class="col-lg-12 col-md-12 col-sm-6 col-xs-12">
                    <div class="form-group" align="center">
                     <button type="button" id="imprimir" class="btn btn-primary" data-dismiss="modal">Imprimir</button>
					 <button type="button" id="regresar" class="btn btn-danger" data-dismiss="modal">Regresar</button>
                    </div>
		</div>  
			{!!Form::open(array('url'=>'produccion/maquina/pagar','method'=>'POST','autocomplete'=>'off','id'=>'formulario'))!!}
            {{Form::token()}}
     <div class ="row" id="divdesglose" style="display: none">
                <div class="panel panel-primary">
                <div class="panel-body">
                <div class="modal-content">
					   <input type="hidden" value="{{$empresa->tc}}" id="valortasa" name="tc" class="form-control">
		 <input type="hidden" value="{{$empresa->peso}}" id="valortasap" name="peso" class="form-control">
		  <input type="hidden" value="" id="total_venta" name="total_venta" class="form-control">
		 <input type="hidden" value="" id="venta" name="venta" class="form-control">
		 <input type="hidden" value="" id="tipop" name="tipop" class="form-control">
		 <input type="hidden" value="{{$tosta->iddep}}"  name="proveedor" class="form-control">
						<input type="hidden" name="tdeuda" id="tdeuda" value="" class="form-control"> 					
                  <div class="modal-body">
				  	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<table  width="90%"><tr><td align="center"><font size="4"><strong>TOTAL</strong></font></td>
					<td><input type="number" id="divtotal" value="" class="form-control" disabled ></td>
					<td align="center"><span id="pasapago" title="haz click para hacer cobro total"><font size="4"><strong>RESTA</strong></font></span></td>
					<td> <input type="number" class="form-control" id="resta" disabled value=""></td></tr></table></br>
					</div>					 
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
						<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
						<div class="form-group">
						<input type="date" class="form-control" name="fechap" id="fechap" value="<?php echo $fecha; ?>" >
						</div>
						</div>
						<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
						<div class="form-group">
						<input type="text" name="preferencia" class="form-control" id="preferencia" onchange="conMayusculas(this);" placeholder="Referencia...">
						</div>
						</div>
						<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
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
                          <th>Fecha</th>
                          <th>Referencia</th>

                      </thead>
                      <tfoot> 
                      <th></th>
                          <th></th>
                          <th></th>
						   <th></th>
                          <th><h3>Total $</h3></th>
                          <th><h3 id="total_abono">$.  0.00</h3></th><input type="hidden" name="totala" id="totala" value="0.00">
                          </tfoot>
                      <tbody></tbody>
                    </table>
	
					</div>
						</div>
					  <div class="modal-footer">
						<div class="col-lg-12 ol-md-12 col-sm-12 col-xs-12">
						<button type="button" class="btn btn-danger" id="regresarp" data-dismiss="modal">Cancelar</button>
						<input name="_token" value="{{ csrf_token() }}" type="hidden" ></input>
						<button type="button" id="procesa" class="btn btn-primary">Procesar</button>
						   <div style="display: none" id="loading">  <img src="{{asset('imagenes/sistema/loading30.gif')}}"></div>
					  
						</div>
					  </div>
				</div>
                </div>
                </div>
				</div>
      		{!!Form::close()!!}	
       </div>
	@push ('scripts')
<script>
$(document).ready(function(){
    $('#imprimir').click(function(){
  //  alert ('si');
  document.getElementById('imprimir').style.display="none";
  document.getElementById('regresar').style.display="none";
  window.print(); 
  window.location="/produccion/maquina";
    });
$('#regresar').on("click",function(){
  window.location="/produccion/maquina";
  
});
	$('#bt_pago').click(function(){
	    agregarpago();
	})
	$('#pasapago').click(function(){
			datosbanco=$("#pidpago").val();
			if(datosbanco<10){
				$("#pmonto").val($("#resta").val());
				document.getElementById('bt_pago').style.display=""; 
				$("#preferencia").focus();
			}else{ alert('¡Debe seleccionar un tipo de Pago!');}
	})
	$('#regresarp').click(function(){	
			pagototal=0;	 $("#resta").val($("#total_venta").val());
			$("#total_abono").text("0.0");
			$("#tdeuda").val($("#total_venta").val());
			$("#total").val(0);
			$("#totala").val(0);
			$('#divdesglose').fadeOut("fast");
			$('#divarticulos').fadeIn("fast");
			for(var i=0;i<10;i++){
			$("#filapago" + i).remove(); acumpago[i]=0; }
		document.getElementById('imprimir').style.display="";
		document.getElementById('regresar').style.display="";
		})
		$('#procesa').click(function(){   
			document.getElementById('loading').style.display=""; 
			document.getElementById('procesa').style.display="none"; 
			document.getElementById('regresar').style.display="none"; 
			document.getElementById('formulario').submit(); 
		})
$("#pidpago").change(mediopago);
});
	function abrirespecial(idventa,saldo){  
	  document.getElementById('imprimir').style.display="none";
	document.getElementById('regresar').style.display="none";
		var txk=$("#txk").val();
		var nmonto=parseFloat(txk)*parseFloat(saldo);
      $('#divdesglose').fadeIn("fast");
      $("#divtotal").val(nmonto);
      $("#auxtotal").val(nmonto);
	   $("#tipop").val(txk);
	  $("#resta").val(nmonto);
      $("#venta").val(idventa); 
	  $("#total_venta").val(nmonto); 
	  $("#pidpago").val('10');
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
			acumpago=[];var contp=0; var tresta=0; var pagototal=0;
	function agregarpago(){ 
         vresta=$("#resta").val();    
		 idpago=$("#pidpago").val();
        tpago= $("#pidpago option:selected").text();
        pmonto= $("#pmonto").val();
		pfecha= $("#fechap").val();
        pref= $("#preferencia").val();
 
		if(parseFloat(pmonto)<=parseFloat(vresta)){
			var denomina=pmonto;
			acumpago[contp]=(pmonto);
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
			tventa=$("#divtotal").val();
			tresta=(parseFloat(tventa)-parseFloat(pagototal));
            $("#resta").val(tresta.toFixed(2));
            $("#tdeuda").val(tresta.toFixed(2));	
            var fila='<tr  id="filapago'+contp+'"><td align="center"><span onclick="eliminarpago('+contp+');"><i class="fa fa-fw fa-eraser"></i></span></td><td><input type="hidden" name="tidpago[]" value="'+idpago+'"><input type="hidden" name="tidbanco[]" value="'+tpago+'">'+tpago+'</td><td><input type="hidden" name="denominacion[]" value="'+denomina+'">'+denomina+'</td><td><input type="hidden" name="tmonto[]" value="'+pmonto+'">'+pmonto+'</td><td><input type="hidden" name="fpago[]" value="'+pfecha+'">'+pfecha+'</td><td><input type="hidden" name="tref[]" value="'+pref+'">'+pref+'</td></tr>';
            contp++;
            document.getElementById('bt_pago').style.display="none";
			$("#pidpago").val('5');
			$("#pmonto").attr('placeholder','Esperando Seleccion');
			$("#total_abono").text(pagototal.toFixed(2));
			$("#totala").val(pagototal.toFixed(2));
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
		$("#pidpago").val('10');
        total=acumpago[index];
        resta=$("#resta").val();
        var1=$("#total_abono").text();
        nv=(parseFloat(resta)+parseFloat(total));
        nc=(parseFloat(var1)-parseFloat(total));
        $("#resta").val(nv);   
        $("#tdeuda").val(nv);  
		$("#totala").val(nc);
        pagototal=(parseFloat(pagototal)-parseFloat(total));
        $("#filapago" + index).remove();
        $("#total_abono").text(nc.toFixed(2));
    }
</script>
@endpush
@endsection