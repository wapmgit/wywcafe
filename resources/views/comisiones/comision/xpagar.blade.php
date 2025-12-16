@extends ('layouts.admin')
@section ('contenido')
<?php $acum=0; $acump=0;$cont=0;?>
<div class="row">
	<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
		<h3>Detalles de Comisiones por Pagar</h3>

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
					<th>#Doc.</th>
					<th>Vendedor</th>
					<th>Telefono</th>
					<th>monto Faturado</th>
					<th>Monto Comision</th>
					<th>Des.Meta</th>
					<th>Por Pagar</th>
					<th>Fecha cierre</th>
					<th>usuario</th>
					<th>Opcion</th>

									
				</thead>
               @foreach ($vendedor as $cat)
               <?php $cont++;
			       $acum=$acum+$cat->montocomision; 
				   $acump=$acump+$cat->pendiente; 
               ?>			   
				<tr>   
					<td>{{$cat->id_comision}}</td>
					<td>{{$cat->nombre}}</td>
					<td><small><small>{{$cat->telefono}}</small></small></td>
					<td><?php echo number_format($cat->montoventas, 3,',','.')." $"; ?> </td>
					<td><?php echo number_format($cat->montocomision, 3,',','.')." $"; ?> </td>
					<td><?php echo number_format($cat->mtometa, 3,',','.')." $"; ?> </td>
					<td><?php echo number_format($cat->pendiente, 3,',','.')." $"; ?> </td>
					<td><?php echo date("d-m-Y",strtotime($cat->fecha)); ?></td>
					<td><small><small>{{ $cat->usuario}}</small></small></td>
					<td>
	@if($rol->pcomision==1)<a href="javascript:abrirespecialpago({{$cat->id_comision}},{{$cat->pendiente}},'{{$cat->nombre}}','{{$cat->id_vendedor}}_{{$cat->cedula}}_{{$cat->nombre}}');"><button  id="abono" class="btn btn-warning btn-xs">Pagar</button></a>@endif
	<?php if($cat->pendiente<$cat->montocomision){ ?>
	<a href="/comisiones/comision/listarecibos/<?php echo $cat->id_comision."_A";?>"><button  id="" class="btn btn-info btn-xs">Recibos</button></a>
	<?php
	}?>
	</td>		
				</tr>
				@endforeach
				<tr>
				<td><?php echo $cont." Comisiones"; ?></td><td></td><td></td><td><strong>TOTAL:</strong></td><td style="background-color: #A9D0F5"><?php echo number_format($acum, 3,',','.')." $"; ?></td><td> </td><td style="background-color: #A9D0F5"><?php echo number_format($acump, 3,',','.')." $"; ?></td><td> </td><td></td>
				</tr>
				<tr><td colspan="3">
			</td></tr>
			</table>

		</div>
		
	</div>
	</div>
	</div>
	</div>
</div>
 <div clas ="row" id="divdesglose" style="display: none"> 	
 {!!Form::open(array('url'=>'comisiones/comision/pagar','method'=>'POST','autocomplete'=>'off','id'=>'otro'))!!}   
            {{Form::token()}}
				  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
<h3 align="center">ABONO/PAGO DE COMISIONES</h3>
                    </div>  
				  <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                 <div class="form-group">
                      <label for="proveedor">Vendedor</label>
                   <p><input type="text" name="nombre" readonly id="nombre" class="form-control" value=""></p>
                    </div>
            </div>
							  <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                 <div class="form-group">
                      <label for="proveedor">Documento</label>
                   <p><input type="text" name="comision"  readonly  id="comision" class="form-control" value=""></p>
                    </div>
            </div>
						  <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                 <div class="form-group">
                      <label for="proveedor">Monto Comision</label>
                   <p><input type="text" name="monto" id="monto" readonly   class="form-control" value=""></p>
                    </div>
            </div>  			  <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
			<div class="form-group">
                      <label for="proveedor">Observacion</label>
                   <p><input type="text" name="observacion"  class="form-control" value=""></p>
                    </div>
			</div>
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					 <input type="hidden" value="{{$empresa->tc}}" id="valortasa" name="tc" class="form-control">
					 <input type="hidden" value="" id="vendedor" name="vendedor" class="form-control">
					<input type="hidden" value="{{$empresa->peso}}" id="valortasap" name="peso" class="form-control">
					<input type="hidden" name="tdeuda" id="tdeuda" value="" class="form-control"> 
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
                          <th><h3 id="total_abono">$.  0.00</h3></th><input type="hidden" name="totala" id="totala" value="0.00">
                          </tfoot>
                      <tbody></tbody>
                    </table>
	
					</div>
					 <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12"></div>
					 
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><div align="right">
        <button type="button" class="btn btn-danger" id="regresar" data-dismiss="modal">Cancelar</button>
        <input name="_token" value="{{ csrf_token() }}" type="hidden" ></input>
	
        <button type="submit" id="procesa" class="btn btn-primary" style="display: none">Procesar</button>
      </div>
        </div>
				{!!Form::close()!!}	
 </div>
@endsection

@push ('scripts')

<script>
 $(document).ready(function(){
//de desglose
		$('#pasapago').click(function(){
			datosbanco=$("#pidpago").val();
			if(datosbanco<10){
				$("#pmonto").val($("#resta").val());
				document.getElementById('bt_pago').style.display=""; 
				$("#preferencia").focus();
			}else{ alert('¡Debe seleccionar un tipo de Pago!');}
		})
		$("#pidpago").change(mediopago);
				$('#bt_pago').click(function(){
	    agregarpago();
		});   
//fin desglose
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
   });
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
			var auxresta=((pesoresta*vdolar).toFixed(3));	//alert(auxresta);		
			$("#resta").val(auxresta);  
			$("#preferencia").val('Tc: '+vdolar);  
			}
			if (datosbanco==2){ 
			var vpeso=$("#valortasap").val(); 
			var auxresta=((pesoresta*vpeso).toFixed(3));	//alert(auxresta);					
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
					acumpago[contp]=(pmonto.toFixed(3)); 
			}     	    
			pagototal=parseFloat(pagototal)+parseFloat(acumpago[contp]); 	
			tventa=$("#divtotal").val();
			tresta=(parseFloat(tventa)-parseFloat(pagototal));
            $("#resta").val(tresta.toFixed(3));
            $("#tdeuda").val(tresta.toFixed(3));	
            var fila='<tr  id="filapago'+contp+'"><td align="center"><span onclick="eliminarpago('+contp+');"><i class="fa fa-fw fa-eraser"></i></span></td><td><input type="hidden" name="tidpago[]" value="'+idpago+'"><input type="hidden" name="tidbanco[]" value="'+tpago+'">'+tpago+'</td><td><input type="hidden" name="denominacion[]" value="'+denomina+'">'+denomina+'</td><td><input type="hidden" name="tmonto[]" value="'+pmonto+'">'+pmonto+'</td><td><input type="hidden" name="tref[]" value="'+pref+'">'+pref+'</td></tr>';
            contp++;
            document.getElementById('bt_pago').style.display="none";
			$("#pidpago").val('5');
			$("#pmonto").attr('placeholder','Esperando Seleccion');
			$("#total_abono").text(pagototal.toFixed(3));
			$("#totala").val(pagototal.toFixed(3));
			limpiarpago();		 
            $('#det_pago').append(fila);
			 $('#procesa').fadeIn("fast");
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
        $("#total_abono").text(nc.toFixed(3));
    }
function abrirespecialpago(idregistro,saldo,nombre,datos){
		 //
   $('#divdesglose').fadeIn("fast");
   $('#nombre').val(nombre);
   $('#vendedor').val(datos);
   $('#monto').val(saldo);
   $('#divtotal').val(saldo);
   $('#resta').val(saldo);
   $('#comision').val(idregistro);   
};
   $('#procesa').on("click",function(){
   
         var tv= $("#monto").val();
         var t1=$("#pagado").val();
		
		 if (t1==""){ alert ('Monto a pagar no pude ser vacio.'); return true;} 
		 if (t1==0){ alert ('Monto a pagar no pude ser 0.');return true; }		
       if (tv>t1){ alert ('Abono  Procesado con exito.');
		document.getElementById('otro').submit();
	   }
          if (tv==t1){ alert ('Pago Procesado con Exito.'); 
		  	document.getElementById('otro').submit();
		}
      });
</script>
@endpush