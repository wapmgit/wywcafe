@extends ('layouts.admin')
@section ('contenido')
<?php $acum=0; $mnc=0; $acum2=$aux=0;$auxn=0;$acumn=0;$acumf=0; $link=2; $fecha=date("Y-m-d");?>
<div class="row">
	<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
		<h3>Detalles de Cuentas por Cobrar</h3>

	</div>
</div>
		<?php
				function truncar($numero, $digitos){
					$truncar = 10**$digitos;
					return intval($numero * $truncar) / $truncar;
				} 
				$pret=0;?>
<div class="row">
	  <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                 <div class="form-group">
                      <label for="proveedor">Nombre</label>
                   <p>{{$cliente->nombre}}</p>
				   <input type="hidden" id="lic" name="lic" value="{{$cliente->licencia	}}" >
                    </div>
            </div>
             <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                 <div class="form-group">
                      <label for="proveedor">Cedula</label>
                   <p>{{$cliente->cedula}}</p>
                    </div>
            </div>
             <div class="col-lg-2 col-md-2 col-sm- col-xs-12">
                 <div class="form-group">
                      <label for="proveedor">Telefono</label>
                   <p>{{$cliente->telefono}}</p>
                    </div>
            </div>
			           <div class="col-lg-2 col-md-2 col-sm- col-xs-12">
                 <div class="form-group">
                      <label for="proveedor">Contacto</label>
                   <p>{{$cliente->contacto}}</p>
                    </div>
					
            </div>
			 <div style="background-color: #A9D0F5" class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                 <div class="form-group" align="center">
				 <table width="80%" ><tr><td align="center"><label for="proveedor">Tasa Bs</label></td><td align="center"> <label for="proveedor">Tasa Peso</label></td></tr>
				<tr> <td align="center"><input name="ntasabs" id="ntbs" style="width: 70px"  type="number" value="{{$empresa->tc}}"></td>		 
				 <td align="center"><input name="ntasaps" id="ntps"  style="width: 70px"  type="number" value="{{$empresa->peso}}"></td>
				 </tr>
				 </table>
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
					<th>Fecha Emi.</th>
					<th>Fecha Desp.</th>
					<th>Monto</th>
					<th>RET.</th>
					<th>Por Cobrar</th>
					<th>Opciones</th>
				</thead> 
			@foreach ($notas as $not)<?php $auxn=1; ?>
               <?php 
			   $aux=0;
               $acum=$not->monto+$acum; 
			    $acumn=$not->pendiente+$acumn; 
               $acum2=$not->monto+$acum2; 
               ?>
					<tr>
					<td>N/D- {{$not->idnota}}</td>
					<td>{{$not->referencia}}</td>
					<td><?php echo date("d-m-Y",strtotime($not->fecha)); ?></td>
					<td><?php echo date("d-m-Y",strtotime($not->fecha)); ?></td>
					<td><?php echo number_format($not->monto, 2,',','.')." $"; ?> </td>
					<td> </td>
					<td><?php echo number_format($not->pendiente, 2,',','.')." $";?></td>
					<td><?php if ($notasc->montonc<> NULL){ ?>
				<?php $mnc=number_format($notasc->montonc, 2,'.','');?>
					<a href="javascript:abrirdivnc('N/D',{{$not->idnota}},{{$not->pendiente}},{{$mnc}},0);"><button  id="abono" class="btn btn-primary btn-xs">N/C: {{$mnc}} $</button></a><?php } ?>
					<a href="javascript:abrirespecial2({{$not->idnota}},{{$not->pendiente}});"><button  id="abono" class="btn btn-info btn-xs">Abono</button></a>
            <a href="/paciente/notasadm/{{$not->idnota}}"><button id="botondetalle" class="btn btn-success btn-xs">Detalle</button></a>
          </td>
				</tr>
				@endforeach 
               @foreach ($datos as $cat)
               <?php 
               $acum=$cat->saldo+$acum; 
               $acumf=$cat->saldo+$acumf; 
			   $acum2=$cat->total_venta+$acum2; 
               ?>
		  
          @include('pacientes.cobrar.modal')	
          @include('pacientes.cobrar.modalfl')	
			<tr>
					<td>{{$cat->tipo_comprobante}} <?php if(($cliente->retencion > 0)and ($cat->tipo_comprobante=="FAC") and ($cat->forma==0)){?>
				 <a href="" data-target="#modalfl{{$cat->idventa}}" data-toggle="modal"><i class="fa fa-fw fa-paste" title="Conertir Forma Libre"></i></a>	<?php
					}?></td>
					
					<td>{{$cat->serie_comprobante}}-{{$cat->num_comprobante}}</td>
					<td><?php echo date("d-m-Y h:i:s a",strtotime($cat->fecha_hora)); ?></td>
					<td><?php echo date("d-m-Y",strtotime($cat->fecha_emi)); ?></td>
					<td><?php echo number_format($cat->total_venta, 2,',','.')." $"; ?> </td>
					<td> <?php echo number_format($cat->mret, 2,',','.')." $"; ?> </td>
					<td><?php echo number_format($cat->saldo, 2,'.','.')." $"; ?> </td>
					<td>
					<?php if ($notasc->montonc<> NULL){ 
			 $mnc=number_format($notasc->montonc, 2,'.',''); }?>
<a href="javascript:abrirdivnc('FAC',{{$cat->idventa}},{{$cat->saldo}},{{$mnc}},{{$cat->licor}});"><button  id="abono" class="btn btn-primary btn-xs">N/C: {{$mnc}} $</button></a>
				
					<a <?php if($aux==1){echo "href='#'";}else { echo "href='javascript:abrirespecial($cat->idventa,$cat->saldo,$cat->licor,$cat->forma);'";}?>><button  id="abono" class="btn btn-info btn-xs">Abono</button></a>
            <a href="{{URL::action('CxcobrarController@edit',$cat->idventa.'-'.$link)}}"><button id="botondetalle" class="btn btn-success btn-xs">Detalle</button></a>
		 <?php if(($cliente->retencion>0) and ($cat->forma==1) and ($cat-> mret==0)){?>
		 <a href="" data-target="#retencion{{$cat->idventa}}" data-toggle="modal"><button  class="btn btn-warning btn-xs">RET</button></a>	
	
		 <?php } ?>
		
          </td>
				</tr>
			 @include('pacientes.cobrar.modalret')
				@endforeach
				
				@include('pacientes.cobrar.modal')
				@include('pacientes.cobrar.modaln')
				<tr>		
				<td></td><td></td><td><strong>TOTAL:</strong></td><td></td><td style="background-color: #A9D0F5"><?php echo number_format($acum2, 2,',','.')." $"; ?> 
				</td>	
				<td></td>
				<td style="background-color: #A9D0F5"><?php echo number_format(($acumn+$acumf), 2,',','.'); ?></td><td>
				FAC:<a href="#" data-target="#modal" data-toggle="modal" title="Abono total por Facturas">
				<input type="button" id="pago" name="pago" value="<?php echo number_format($acumf, 2,',','.'); ?>"></input> </a>
				N/D:<a href="#" data-target="#modaln" data-toggle="modal" title="Abono total por N/D">
				<input type="button" id="pagon" name="pagon" value="<?php echo number_format($acumn, 2,',','.'); ?>"></input> </a>
				</td>
				</tr>
			</table>
		</div>
	</div>
         <div class="col-lg-12 col-md-12 col-sm-6 col-xs-12">
                    <div class="form-group" align="center">
					 <button type="button" id="regresarpg" class="btn btn-danger" data-dismiss="modal">Regresar</button>
					 <a href="{{URL::action('PacientesController@show',$cliente->id_cliente)}}"><button class="btn btn-success">Edo. Cta.</button></a>
                    </div>
						 <input type="hidden"   name="flicor" id="flicor" value="" class="form-control">
                </div>  		
	</div>
	</div>
	</div>
</div>
	{!!Form::open(array('url'=>'pacientes/cobrar','method'=>'POST','autocomplete'=>'off','id'=>'formulario'))!!}
            {{Form::token()}}
		<div class ="row" id="divdesglose" style="display: none">
                <div class="panel panel-primary">
                <div class="panel-body">
                <div class="modal-content">
					   <div class="modal-header" align="center">
					   <input type="hidden" value="{{$empresa->tc}}" id="valortasa" name="tc" class="form-control">
		 <input type="hidden" value="{{$empresa->peso}}" id="valortasap" name="peso" class="form-control">
		  <input type="hidden" value="" id="total_venta" name="total_venta" class="form-control">
		  <input type="hidden" value="" id="tipodoc" name="tipodoc" class="form-control">
		  <input type="hidden"  id="lic" name="lic" value="{{$cliente->id_cliente}}" class="form-control">
		 <input type="hidden" value="" id="venta" name="venta" class="form-control">
		 <input type="hidden"   name="cliente" value="{{$cliente->id_cliente}}_{{$cliente->cedula}}_{{$cliente->nombre}}" class="form-control">
					   <h3 >TOTAL <input type="number" id="divtotal" value="" disabled ><span id="pasapago" title="haz click para hacer cobro total">RESTA</span> <input type="number" id="resta" disabled value="">
						<input type="hidden" name="tdeuda" id="tdeuda" value="" class="form-control"> 
			
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
                          <th>fecha</th>
                          <th>Referencia</th>

                      </thead>
                      <tfoot> 
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
					  
					  		<div class="col-lg-6 ol-md-6 col-sm-6 col-xs-6" style="display: none" id="cfl"><div id="retfl">
							¿ Convertir en Factura ? <input type="checkbox"  name="convertir" />
								
								</div>
							</div>
						<div class="col-lg-6 ol-md-6 col-sm-6 col-xs-6">
						<button type="button" class="btn btn-danger" id="regresar" data-dismiss="modal">Cancelar</button>
						<input name="_token" value="{{ csrf_token() }}" type="hidden" ></input>
						<button type="button" id="procesa" class="btn btn-primary">Procesar</button>
						<div style="display: none" id="loading">  <img src="{{asset('imagenes/sistema/loading30.gif')}}"></div>
					  
						</div>
					  </div>
				</div>
                </div>
                </div>
				</div>	{!!Form::close()!!}	
			<div class ="row" id="divnc" style="display: none">
				{!!Form::open(array('url'=>'pacientes/cobrar/nc','method'=>'POST','autocomplete'=>'off','id'=>'formulario2'))!!}
            {{Form::token()}}
             <div class="panel panel-primary">
              <div class="panel-body">
                   <div class="modal-content">
                   <div class="modal-header">
                    <h6 id="divtotal" style="display: none" class="modal-title" align="center">BsF.</h6>
                    <h3 align="center">APLICAR NOTA DE CREDITO</h3>				
                   </div>
                <div class="modal-body">
						<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
						<div class="form-group"><label>Monto Nota de Credito</label>
						<input type="number" id="total_nc" class="form-control" id="total_nc" value="" disabled >
						</div>
						</div>							
							<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
						<div class="form-group"><label>Monto Documento</label>
						<input type="number" name="total_doc" id="total_doc" class="form-control" value="" disabled >
						</div>
						</div>
						<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
						<div class="form-group"><label>Abonar </label>
						<input type="number" id="total_abn" name="total_abn" class="form-control" min="0.01" step="0.01" value="">
						</div>
						</div>		<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
						<div class="form-group"><label>Referencia</label>
						<input type="text" id="ref" name="ref" class="form-control" value="" >
						<input type="hidden" id="iddoc" name="iddoc" class="form-control" value="" >
						<input type="hidden" id="tipo" name="tipo" class="form-control" value="" >
						<input type="hidden"  name="idcliente" class="form-control" value="{{$cliente->id_cliente}}" >
						 <input type="hidden"   name="cliente" value="{{$cliente->id_cliente}}_{{$cliente->cedula}}_{{$cliente->nombre}}" class="form-control">
						</div>
						</div>
					</div>
       <div class="modal-footer">
	   		<div class="col-lg-6 ol-md-6 col-sm-6 col-xs-6"  id="cflnc" style="display:none">
			<div class="form-group">
		
							¿ Convertir en Factura ? <input type="checkbox"    name="convertirnc" />
								¿ formato 1% ? <input type="checkbox"   name="formatonc" />
								
							</div>
							</div>
        <div class="col-lg-6 ol-md-6 col-sm-6 col-xs-6">
        <button type="button" class="btn btn-danger" id="cerrardivnc" data-dismiss="modal">Cancelar</button>
        <input name="_token" value="{{ csrf_token() }}" type="hidden" ></input>
        <button type="submit" id="procesac" class="btn btn-primary" style="display: none">Procesar</button>
		<div style="display: none" id="loading2">  <img src="{{asset('imagenes/sistema/loading30.gif')}}"></div>
      
        </div>
      </div>
      </div>
      </div>
	
      </div>
	  {!!Form::close()!!}	
	  </div>
    
      	
@endsection
@push ('scripts')
<script>
	$(document).ready(function(){
		document.getElementById('bt_pago').style.display="none";
		$('#pasapago').click(function(){
			datosbanco=$("#pidpago").val();
			if(datosbanco<10){
			$("#pmonto").val($("#resta").val());
			document.getElementById('bt_pago').style.display=""; 
			$("#preferencia").focus();
			}else{ alert('¡Debe seleccionar un tipo de Pago!');}
		})
		$("#pidpago").change(mediopago);
			$('#total_abn').on("change",function(){
			var mnc=$("#total_nc").val();
			var abn=$("#total_abn").val();
			var pen=$("#total_doc").val();	
			var restanc=(abn-pen);
			//alert(restanc);
				if(parseFloat(mnc)>parseFloat(pen)){
						if(parseFloat(abn)>parseFloat(pen)){ alert('ERROR EN MONTO DE ABONO!!');
						document.getElementById('procesac').style.display="none";
						$('#total_abn').val("");
						$('#total_abn').focus();}else{
						document.getElementById('procesac').style.display=""; 
						}
				} else { 	
				if(parseFloat(abn)>parseFloat(mnc)){ alert('ERROR EN MONTO DE ABONO!!'); 
				document.getElementById('procesac').style.display="none";				
				$('#total_abn').val("");
				$('#total_abn').focus();} else{
						document.getElementById('procesac').style.display="";}
				}
				var flicor=$("#flicor").val();
				var lic=$("#lic").val();
				if(restanc==0 && lic!=""){
					document.getElementById('cflnc').style.display="";
				}
				if( (flicor==0)  && (restanc==0)){
					document.getElementById('cflnc').style.display="";
				}
	});

		$('#bt_pago').click(function(){
			agregarpago();
			});   
			$('#regresar').click(function(){	
			pagototal=0;	 $("#resta").val($("#total_venta").val());
			$("#total_abono").text("0.0");
			$("#tdeuda").val($("#total_venta").val());
			$("#total").val(0);
			$("#totala").val(0);
			$('#divdesglose').fadeOut("fast");
			$('#divarticulos').fadeIn("fast");
				for(var i=0;i<10;i++){
				$("#filapago" + i).remove(); acumpago[i]=0; }
		})
		$('#cerrardivnc').on("click",function(){
			document.getElementById('divnc').style.display="none"; 
			$("#total_abn").val(0);
			$("#ref").val("");
			$("#pidpago").val('10');
		})
		$('#regresarpg').on("click",function(){
		window.location="/pacientes/cobrar";
		});
	$('#procesac').click(function(){   
			document.getElementById('loading2').style.display=""; 
			document.getElementById('procesac').style.display="none"; 
			document.getElementById('cerrardivnc').style.display="none"; 
			document.getElementById('formulario2').submit(); 
		})
		$('#procesa').click(function(){   
			document.getElementById('loading').style.display=""; 
			document.getElementById('procesa').style.display="none"; 
			document.getElementById('regresar').style.display="none"; 
			document.getElementById('formulario').submit(); 
		})
		
			$('#ntbs').on("change",function(){
			var nva=$("#ntbs").val();
			$("#valortasa").val(nva);
			})
			$('#ntps').on("change",function(){
			var nvap=$("#ntps").val();
			$("#valortasap").val(nvap);
			})
	});
// calculo pago
	function mediopago(){
	   var totala=$("#totala").val();
	   document.getElementById('bt_pago').style.display="";		
       var pesototal =$("#divtotal").val();
	   var pesoresta =pesototal-parseFloat(totala);
		  datosbanco=$("#pidpago").val();
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
				$("#preferencia").val("");	
			}							
		t_pago=$("#pidpago").val();
    }
	acumpago=[];var contp=0; var tresta=0; var pagototal=0;
	
	function agregarpago(){ 
		vlicor=$("#flicor").val();
        vresta=$("#resta").val();    
		idpago=$("#pidpago").val();
        tpago= $("#pidpago option:selected").text();
        pmonto= $("#pmonto").val();
		pfecha= $("#fechap").val();
        pref= $("#preferencia").val();
		if(parseFloat(pmonto)<=parseFloat(vresta)){
			var denomina=pmonto;
			acumpago[contp]=(pmonto);
			if (datosbanco==1){ 
				var pesoresta =$("#resta").val();  
				var vdolar=$("#valortasa").val();  
				$("#resta").val(pesoresta/vdolar);  
				$("#total_abono").text(pagototal/vdolar);
			    denomina=pmonto;
			    pmonto=pmonto/vdolar;		
				acumpago[contp]=(pmonto.toFixed(2)); 
			}
			if (idpago==2){ 
			    var pesoresta =$("#resta").val();  
				var vpeso=$("#valortasap").val();  
				$("#resta").val(pesoresta/vpeso);  
				$("#total_abono").text(pagototal/vpeso);
				denomina=pmonto;
				pmonto=pmonto/vpeso;		
				acumpago[contp]=(pmonto.toFixed(2)); 
			} 
		    
        pagototal=parseFloat(pagototal)+parseFloat(acumpago[contp]); 
		//salert(pagototal);
        tventa=$("#divtotal").val();
        tresta=(parseFloat(tventa)-parseFloat(pagototal));
            $("#resta").val(tresta.toFixed(2));
            $("#tdeuda").val(tresta.toFixed(2));	
            var fila='<tr  id="filapago'+contp+'"><td align="center"><span onclick="eliminarpago('+contp+');"><i class="fa fa-fw fa-eraser"></i></span></td><td><input type="hidden" name="tidpago[]" value="'+idpago+'"><input type="hidden" name="tidbanco[]" value="'+tpago+'">'+tpago+'</td><td><input type="hidden" name="denominacion[]" value="'+denomina+'">'+denomina+'</td><td><input type="hidden" name="tmonto[]" value="'+pmonto+'">'+pmonto+'</td><td><input type="hidden" name="fpago[]" value="'+pfecha+'">'+pfecha+'</td><td><input type="hidden" name="tref[]" value="'+pref+'">'+pref+'</td></tr>';
            contp++;
            document.getElementById('bt_pago').style.display="none";
			$("#pidpago").val('10');
			$("#total_abono").text(pagototal.toFixed(2));
			$("#totala").val(pagototal.toFixed(2));
			if($("#tdeuda").val()==0){
				if($("#lic").val()!=""){
				document.getElementById('cfl').style.display="";
				}
				if(($("#lic").val() == "") && (vlicor==0)){
					document.getElementById('cfl').style.display="";
				}
				}
			limpiarpago();		 
             $('#det_pago').append(fila);
		}else{ alert('¡El monto indicado no debe se mayor al saldo pendiente!');
		limpiarpago();		}
	}
	function limpiarpago(){
        $("#pmonto").val("");
        $("#preferencia").val("");
	//	$("#fechap").val("");
    }
	function eliminarpago(index){
		$("#pidpago").val('5');
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
			if($("#tdeuda").val()==0){
				document.getElementById('cfl').style.display="";
				}else{ document.getElementById('cfl').style.display="none"; } 
    }
	function abrirespecial(idventa,saldo,licor,forma){
;		//alert();
	$('#divnc').fadeOut("fast");
      $('#divdesglose').fadeIn("fast");
	  if(forma==1){
		  document.getElementById('retfl').style.display="none"; 
	  }
      $("#divtotal").val(saldo);
     $("#flicor").val(licor);
      $("#resta").val(saldo);
	   $("#tipodoc").val(1);
      $("#venta").val(idventa); 
	  $("#total_venta").val(saldo);
		$("#pidpago").val('10');	  
	}
		function abrirespecial2(idventa,saldo){  
		$('#divnc').fadeOut("fast");
      $('#divdesglose').fadeIn("fast");
      $("#divtotal").val(saldo);
      $("#resta").val(saldo);
	   $("#tipodoc").val(2);
      $("#venta").val(idventa); 
	  $("#total_venta").val(saldo); 
	}
function abrirdivnc(tipo,iddoc,pendiente,mnc,licor){
	//alert();
	if (mnc>0){
		  $("#flicor").val(licor);
	$('#divdesglose').fadeOut("fast");
	var auxmnc=mnc; var auxpen=pendiente;
	$("#iddoc").val(iddoc);
	$("#tipo").val(tipo);
	$("#total_nc").val(mnc);
	$("#total_doc").val(pendiente);	
	if(parseFloat(auxmnc)>parseFloat(auxpen)){ 
	$("#total_abn").attr('max',auxpen);
	$("#total_abn").val(auxpen);
	 } else { 	
	 $("#total_abn").attr('max',auxmnc);
	$("#total_abn").val(auxmnc); }
      $('#divnc').fadeIn("fast");
	  document.getElementById('procesac').style.display="";
}
}

</script>
@endpush