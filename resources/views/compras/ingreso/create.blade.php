@extends ('layouts.admin')
@section ('contenido')
@include('pacientes.paciente.empresa')
<?php 
$fserver=date('Y-m-d');
?>
		<div class="row">
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
			<h3>Nuevo Ingreso</h3> 
       @include('compras.ingreso.modalarticulo')
	    @include('compras.ingreso.modalproveedor')
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
			{!!Form::open(array('url'=>'compras/ingreso','method'=>'POST','id'=>'otro'))!!}
            {{Form::token()}}
            <div class="row" id="proveedor" >
                <div class="col-lg-12 col-md-12 col-sm-6 col-xs-12">
                    <div class="form-group">
						<input type="hidden" value="{{$empresa->tc}}" id="valortasa" name="tc" class="form-control">
		 <input type="hidden" value="{{$empresa->peso}}" id="valortasap" name="peso" class="form-control">
                    	<label for="proveedor">Proveedor </label> <a href="" data-target="#modalproveedor" data-toggle="modal"><span class="label label-success">Nuevo <i class="fa fa-fw  fa-user "> </i></span></a>
                    	<select name="idproveedor" id="idproveedor" class="form-control selectpicker" data-live-search="true">
                           @foreach ($personas as $per)
                           <option value="{{$per -> idproveedor}}_{{$per->rif}}_{{$per->nombre}}">{{$per -> nombre}}</option> 
                           @endforeach
                        </select>
                    </div>
                </div>
                
            		<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                <div class="form-group">
                	<label for="tipo_comprobante">Tipo comprobante</label>
                       <select name="tipo_comprobante" class="form-control">
                           <option value="FAC">Factura</option>
                           <option value="N/E">Nota de Entrega</option>
                       </select>
                         <input type="hidden" name="vtasa" id="vtasa" value="{{$empresa->tc}}">
                </div>
            </div>
				<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                <div class="form-group">
                	<label for="tipo_comprobante">Emision</label>
                         <input type="date" name="emision" class="form-control" value="<?php echo $fserver;?>">
                </div>
				</div>
          		<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                <div class="form-group">
                    <label for="serie_comprobante">Serie-Documento</label>
                    <input type="text" name="serie_comprobante" value="{{old('serie_comprobante')}}" class="form-control"placeholder="Numero del Documento" > 
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                <div class="form-group">
                    <label for="num_comprobante">Numero Control</label>
                    <input type="text" required name="num_comprobante" id="num_comprobante" value="{{old('num_comprobante')}}" class="form-control" placeholder="Numero de Control">
                </div>
            </div>
			     <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                <div class="form-group">
                    <label for="num_comprobante">Ingreso Compra: 
					<input name="precio" type="radio" id="cbs" value="2">Bs
					<input name="precio" type="radio" id="dls" value="1" checked="checked">$ 
					Tasa Cambio</label>
                    <input type="number" name="tasacompra" step="any" id="tasacompra" readonly value="{{$empresa->tc}}"  class="form-control">
                </div>
            </div>
            </div>  
            <div clas ="row" id="divarticulos">
                <div class="panel panel-primary">
                <div class="panel-body">
                    
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                     <label>  Articulo  </label> <a href="" data-target="#modalarticuloid" data-toggle="modal"><span class="label label-success">Nuevo <i class="fa fa-fw  fa-pencil"> </i></span></a>
						 <div class="form-group"	>				                         
                             <select name="pidarticulo" size="30" id="pidarticulo" class="form-control selectpicker" data-live-search="true">
                             @foreach ($articulos as $articulo)
                              <option value="{{$articulo -> idarticulo}}">{{$articulo -> articulo}}</option> 
                             @endforeach
                              </select>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                    <div class="form-group">
                        <label for="cantidad">Cantidad</label>
                        <input type="number" name="pcantidad" min="0.1" id="pcantidad" class ="form-control" placeholder="Cantidad">
                    </div>
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                    <div class="form-group">
                        <label for="precio_compra">Precio compra</label>
                        <input type="text" step="any" name="pprecio_compra"  id="pprecio_compra" class ="form-control" placeholder="Precio de Compra">
                    </div>
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                    <div class="form-group">
                        <label for="precio_venta">Descuento</label>
                        <input type="number" value="0" name="pprecio_venta" id="pprecio_venta" class ="form-control" placeholder="Descuento">
                    </div>
                    </div>
                      <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                    <div class="form-group">
					<label></label></br>
                     <button type="button" id="bt_add"   onmouseover="this.style.color='blue';" onmouseout="this.style.color='grey';" class="form-control"  > <i class="fa fa-fw fa-plus-square"></i> </button>
                    </div>
                    </div>

                  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				                      <div class="table-responsive">
                    <table id="detalles" class="table table-striped table-bordered table-condensed table-hover">
                      <thead style="background-color: #A9D0F5">
                          <th  width="4%">Supr</th>
                          <th >Articulo</th>
                          <th width="5%">Cantidad</th>
                          <th>Precio compra</th>
                          <th>Precio Bs</th>
                          <th>Descuento</th>
                          <th>Neto</th>
                          <th>Subtotal</th>
                      </thead>
                      <tfoot style="background-color: #A9D0F5"> 
                      <th colspan="7" align="center">Total</th>
                          <th  align="center"><h4 id="total">$.  0.00</h4></th><input type="hidden" name="total_venta" id="total_venta">
                          </tfoot>
                      <tbody></tbody>
                    </table>
					</div>
                  </div>
           <div id="resumen">
  <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12" >
                  <div class="form-group">
            <strong>Base Imponible: </strong><input type="text" style="width: 100px" name="base" id="pbase" value="0" placeholder="Base imponible" readonly >
                    </div>
                </div>
                   <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12" >
                  <div class="form-group">
      <strong>    IVA:  </strong><input type="text" style="width: 100px" name="iva" id="piva" value="0" placeholder="Iva" readonly>
                    </div>
                </div>
                   <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12" >
                  <div class="form-group">
      <strong>    Exento: </strong><input type="text" style="width: 100px" name="exento" id="pexento" value="0" placeholder="Exento" readonly>
                    </div>
                </div>
	<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12" >
                  <div class="form-group">
      <strong>    Isaea: </strong><input type="number" style="width: 100px" step="0.01" name="lisaea" id="lisaea" value="0">
                    </div>
                </div>
               </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" id="guardar" align="right">
            	    <div class="form-group">
                     <button class="btn btn-primary" id="bguardar" type="button">Totalizar</button>
                     <button class="btn btn-danger" type="button" id="btncancelar" data-dismiss="modal">Cancelar</button>
                    </div>
                </div>
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
					<div class="col-lg-8 ol-md-8 col-sm-8 col-xs-12">
						<div class="form-group">
						<label for="productor">¿ Recalcular Precios ?</label>
						<input type="checkbox" name="recalcular" >
						</div>
					</div>
					<div class="col-lg-4 ol-md-4 col-sm-4 col-xs-4">
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

   // oncontextmenu=new Function("return false");
		function abrir(url) {
			open(url,'','top=300,left=500,width=500,height=650') ;
		}
		$("#pcantidad").change(validar); 
		$("#pprecio_compra").change(validartexto);   
		$(document).ready(function(){
			var auxcompra=0;
		document.getElementById('pprecio_compra').addEventListener('keypress',function(e){ validarenter(e); });		
		document.getElementById('pcantidad').addEventListener('keypress',function(e){ validarno(e); });			
		document.getElementById('pprecio_venta').addEventListener('keypress',function(e){ validarno(e); });			
			$('#bt_add').click(function(){   
			if (auxcompra==0){			
			agregar();}
			if (auxcompra==1){	
			agregarbs();}
			});
			$("#pidarticulo").change(function(){
				$("#pcantidad").focus();
				$("#pprecio_compra").val(0);  		
			})
				$("#lisaea").change(function(){
				var lisa= $("#lisaea").val();
				var divt= $("#divtotal").val();					
				var  nmf=parseFloat(lisa)+parseFloat(divt);
				$("#tdeusa").val(nmf);	
				$("#divtotal").val(nmf);	
				$("#resta").val(nmf);	
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
			$('#bt_pago').click(function(){		
			 agregarpago();
			});
	
			$('#procesa').click(function(){
				abono= $("#totala").val();
				tv= $("#total_venta").val();
			 var t1=parseFloat(abono);
			 if (t1==tv){
				document.getElementById('loading').style.display=""; 
				document.getElementById('procesa').style.display="none"; 
				document.getElementById('regresar').style.display="none"; 
			 alert('Compra Procesada con exito.');
			// venta a contado
			 }else{ 
				document.getElementById('loading').style.display=""; 
				document.getElementById('procesa').style.display="none"; 
				document.getElementById('regresar').style.display="none"; 
				alert ('Compra Procesada con exito.');
			// venta a credito
			}
			});
			$('#bguardar').click(function(){		
			var auxmonto=$("#divtotal").val();		
			auxmonto=parseFloat(auxmonto.replace(/,/g, ""))
                    .toFixed(2);
			$("#resta").val(auxmonto);
			$("#divtotal").val(auxmonto);
			var nc=$("#num_comprobante").val();
			if(nc==""){ alert('Indique Numero de Documento y Numero de Control');}else{
			$('#divarticulos').fadeOut("fast");
			$('#divdesglose').fadeIn("fast");
				}
			})
	
			 $('#regresar').click(function(){
			  $('#divdesglose').fadeOut("fast");
			$('#divarticulos').fadeIn("fast");
			$("#totala").val(0);
			})
			$('#cbs').click(function(){
			 auxcompra=1;
			//	alert(auxcompra);
				$('#tasacompra').attr("readonly",false);
			})
				$('#dls').click(function(){
			 auxcompra=0;
				//alert(auxcompra);
				$('#tasacompra').attr("readonly",true);
			})
		
		  $('#btncancelar').click(function(){	
				var total=0; 
				$("#total").html("$ : " +total);
				 $("#total_venta").val(total);
				 $("#divtotal").val(total);
				 $("#resta").val(total);
				$("#piva").val(total);
				$("#pbase").val(total);
				 $("#pexento").val(total);
				for(var i=0;i<cont;i++){
				$("#fila" + i).remove(); subtotal[i]=0; }
				})
			// registrar nuevo articulo		
			   $("#Nenviar").on("click",function(){				
				  if ($("#codigo").val()==""){ alert ('Debe indicar Codigo de Articulo'
				   );}else{
				 var form1= $('#formulario');
				var url1 = form1.attr('action');
				var data1 = form1.serialize();
				$.post(url1,data1,function(result){  
				var resultado=result;
				console.log(resultado);	
				var nombre=resultado[0].articulo;  
				var id=resultado[0].idarticulo;  		  
				$("#pidarticulo")
				.append( '<option value="'+id+'">'+nombre+'</option>')
				.selectpicker('refresh');
				alert('Articulo Registrado con exito');
				$("#formulario")[0].reset();
				});
				   }
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
							function validarno(e){
								let tecla = (document.all) ? e.keyCode : e.which;
								if(tecla==13) { 
								event.preventDefault();
								} }	
								function validarenter(e){
								let tecla = (document.all) ? e.keyCode : e.which;
								if(tecla==13) { 
								if(auxcompra == 0 ){agregar(); }
								if(auxcompra == 1 ){agregarbs(); }
								event.preventDefault();		 												
								} }

})
						
								
var cont=0;
total=0;tmiva=0;tneto=0; texe=0;precio_tasa=0;
subtotal=[];
arrayiva=[];
arraybase=[];
arrayexento=[];
$("#guardar").hide();
$("#resumen").hide();
    function agregar(){ 
        idarticulo=$("#pidarticulo").val();
        articulo= $("#pidarticulo option:selected").text();
        cantidad= $("#pcantidad").val();
        precio_compra=$("#pprecio_compra").val();
        precio_venta=$("#pprecio_venta").val();
        precio_tasa=(precio_compra*$("#vtasa").val());
		precio_tasa=precio_tasa.toFixed(2);
        artiva=articulo.split('-');
        viva=artiva[4];
        narticulo=artiva[1];
        if (idarticulo!="" && cantidad > 0 &&  precio_compra!=""){         
            neto=(cantidad*precio_compra)-precio_venta;
			//neto=neto.toLocaleString('de-DE', { style: 'decimal',  decimal: '3' });      
            if (viva==0){ subtotal[cont]=neto; miva=0; arrayiva[cont]=0;  
			arraybase[cont]=0; texe=texe+neto;  arrayexento[cont]=neto; }
              else
              { subtotal[cont]=(neto*(viva/100))+neto;
				arrayexento[cont]=0;
				miva=(neto*(viva/100));	
				arrayiva[cont]=miva;
				arraybase[cont]=neto;
				tneto=tneto+neto; }
				tmiva=tmiva+miva;
				total=total+subtotal[cont];
            var fila='<tr class="selected" id="fila'+cont+'"><td><button class="btn btn-warning btn-xs" onclick="eliminar('+cont+');">X</button></td><td><input type="hidden" name="idarticulo[]" value="'+idarticulo+'">'+narticulo+'</td><td><input type="text" style="width: 50px" name="cantidad[]" readonly="true" value="'+cantidad+'"></td><td><input type="text" name="precio_compra[]" readonly="true"  style="width: 100px" value="'+precio_compra+'"></td><td><input type="text" name="ptasa[]" readonly="true" style="width: 100px" value="'+precio_tasa+'"></td><td><input type="number" readonly="true" name="precio_venta[]" style="width: 100px" value="'+precio_venta+'"></td><td>'+neto.toFixed(2)+'</td><td><input type="hidden" name="iva[]" value="'+arrayiva[cont]+'"><input type="hidden" name="exento[]" value="'+arrayexento[cont]+'"><input type="hidden" name="base[]" value="'+arraybase[cont]+'"><input type="number" name="stotal[]" style="width: 100px" readonly="true" value="'+subtotal[cont].toFixed(2)+'"></td></tr>';
            cont++;
            limpiar();
			//alert(total);
            $("#total").html("$ : " + total.toFixed(2));
             $("#total_venta").val(total.toFixed(2));
			 $("#divtotal").val(total.toFixed(2));
			 $("#resta").val(total.toFixed(2));
			 $("#pidarticulo").selectpicker('toggle');

            evaluar();
            $('#detalles').append(fila);
            $("#piva").val(tmiva.toFixed(2));
            $("#pbase").val(tneto.toFixed(2));
             $("#pexento").val(texe.toFixed(2));
        }
        else{
            alert("Error al ingresar el articulo")
        }
    }
	    function agregarbs(){ 
		tasacompra=$('#tasacompra').val();
        idarticulo=$("#pidarticulo").val();
        articulo= $("#pidarticulo option:selected").text();
        cantidad= $("#pcantidad").val();
        precio_compra=($("#pprecio_compra").val()/tasacompra);
        precio_venta=($("#pprecio_venta").val()/tasacompra);
        precio_tasa=(precio_compra*$("#vtasa").val());
		precio_tasa=precio_tasa.toFixed(2);
        artiva=articulo.split('-');
        viva=artiva[4];
        narticulo=artiva[1];
        if (idarticulo!="" && cantidad > 0 &&  precio_compra!=""){         
            neto=((cantidad*precio_compra)-precio_venta);
			//neto=neto.toLocaleString('de-DE', { style: 'decimal',  decimal: '3' });      
            if (viva==0){ subtotal[cont]=neto; miva=0; arrayiva[cont]=0;  
			arraybase[cont]=0; texe=texe+neto;  arrayexento[cont]=neto; }
              else
              { subtotal[cont]=(neto*(viva/100))+neto;
				arrayexento[cont]=0;
				miva=(neto*(viva/100));	
				arrayiva[cont]=miva;
				arraybase[cont]=neto;
				tneto=tneto+neto; }
				tmiva=tmiva+miva;
				total=total+subtotal[cont];
            var fila='<tr class="selected" id="fila'+cont+'"><td><button class="btn btn-warning btn-xs" onclick="eliminar('+cont+');">X</button></td><td><input type="hidden" name="idarticulo[]" value="'+idarticulo+'">'+narticulo+'</td><td><input type="text" name="cantidad[]" readonly="true" value="'+cantidad+'"></td><td><input type="text" name="precio_compra[]" readonly="true" value="'+precio_compra.toFixed(2)+'"></td><td><input type="text" name="ptasa[]" readonly="true" value="'+precio_tasa+'"></td><td><input type="number" readonly="true" name="precio_venta[]" value="'+precio_venta+'"></td><td>'+neto.toFixed(2)+'</td><td><input type="hidden" name="iva[]" value="'+arrayiva[cont].toFixed(2)+'"><input type="hidden" name="exento[]" value="'+arrayexento[cont]+'"><input type="hidden" name="base[]" value="'+arraybase[cont].toFixed(2)+'"><input type="number" name="stotal[]" readonly="true" value="'+subtotal[cont].toFixed(2)+'"></td></tr>';
            cont++;
            limpiar();
			//alert(total);
            $("#total").html("$ : " + (total).toFixed(2));
             $("#total_venta").val((total));
			 $("#divtotal").val(total.toFixed(2));
			 $("#resta").val((total));
		$("#pidarticulo").selectpicker('toggle');
            evaluar();
            $('#detalles').append(fila);
            $("#piva").val(tmiva.toFixed(2));
            $("#pbase").val(tneto.toFixed(2));
             $("#pexento").val(texe.toFixed(2));
        }
        else{
            alert("Error al ingresar el articulo")
        }
    }
    function eliminar(index){
        total=subtotal[index];
		iva=arrayiva[index];
		base=arraybase[index];
		exe=arrayexento[index]
		auxexe=$("#pexento").val();
		auxbase=$("#pbase").val();
		resta=$("#total_venta").val();
		auxiva=$("#piva").val();
		  nbase=(auxbase-base); if(nbase<=0){tneto=0; nbase=0;}
		  niva=(auxiva-iva.toFixed(2)); if(niva<=0){ tmiva=0; niva=0;}
		  nexe=(auxexe-exe); if(nexe<=0){texe=0; nexe=0;}
		  nv=(resta-total);
		 //$("#totala").val(0);
        $("#total").html("$" + nv.toFixed(2));
        $("#divtotal").html("$ : " + nv.toFixed(2));
		$("#piva").val(niva.toFixed(2));
		$("#pexento").val(nexe.toFixed(2));
		$("#pbase").val(nbase.toFixed(2));
		$("#total_venta").val(nv.toFixed(2));			
        $("#fila" + index).remove();
         subtotal[index]=(nv);	
		 total=subtotal[index];	
		 evaluar();
    }
    function limpiar(){
        $("#pcantidad").val("");
        $("#pprecio_compra").val("");
        $("#total_venta").val(total);
        $("#pprecio_venta").val("");
    }

// calculo pago
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
	
    function evaluar(){
        if(total>0){
            $("#guardar").show();
            $("#resumen").show();
        }
        else
        {
            $("#guardar").hide();
            $("#resumen").hide();
        }
    }
    function validar(){   
      datosarticulo= $("#pidarticulo option:selected").text();
      arti=datosarticulo.split('-');
          st=arti[3];
         $("#pprecio_compra").val(""+st); 
    }

    function validartexto(){
         datosarticulo= $("#pidarticulo option:selected").text();
      arti=datosarticulo.split('-');
          st=arti[3];
          st=st*1;
		var dato =  $("#pprecio_compra").val();
		if (dato==""){
			  alert("EL CAMPO NO PUDEDE SER VACIO");
		}else
		if (isNaN(dato)==true){
		alert("DATO NO VALIDO");
		}
		if (dato<st){
		alert("costo indicado por debajo de costo anterior!!");
		document.getElementById('pprecio_compra').focus();
		  }
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
		$("#totala").val(nc);
        pagototal=(parseFloat(pagototal)-parseFloat(total));
        $("#filapago" + index).remove();
        $("#total_abono").text(nc.toFixed(2));
    }
	
</script>
@endpush
@endsection