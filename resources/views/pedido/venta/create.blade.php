@extends ('layouts.admin')
@section ('contenido')
<?php
$fserver=date('Y-m-d');
$nivel=Auth::user()->nivel;
$fecha_a=$empresa->fechasistema;
function dias_transcurridos($fecha_a,$fserver)
{
$dias = (strtotime($fecha_a)-strtotime($fserver))/86400;
//$dias = abs($dias); $dias = floor($dias);
return $dias;
}
$vencida=0;
if (dias_transcurridos($fecha_a,$fserver) < 0){
  $vencida=1;
  echo "<div class='alert alert-danger'>
      <H2>LICENCIA DE USO DE SOFTWARE VENCIDA!!!</H2> contacte su Tecnico de soporte.
      </div>";
};

$ceros=5;
function add_ceros($numero,$ceros) {
  $numero=$numero+1;
$digitos=strlen($numero);
  $recibo=" ";
  for ($i=0;$i<8-$digitos;$i++){
    $recibo=$recibo."0";
  }
return $insertar_ceros = $recibo.$numero;
};
$idv=0;

?>     @foreach ($contador as $p)
              <?php  $idv=$p -> idventa; ?>
              <option style="display: none">{{$p -> idventa}} </option> 
          @endforeach
		
	<div class="row" style="background-color:#c4c6c6"> 
		<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
			<h3>Nuevo Pedido</h3>
			@if (count($errors)>0)
			<div class="alert alert-danger">
				<ul>
				@foreach ($errors->all() as $error)
					<li>{{$error}}</li>
				@endforeach
				</ul>  
			</div>
			@endif			
			@include('pedido.venta.modalcliente')
			<input type="hidden" value="{{$empresa->tc}}" id="valortasa" name="tc"></input>
		  <input type="hidden" value="{{$empresa->peso}}" id="valortasap" name="peso"></input>
        </div>
		<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
		<h4 id="nombrevendedor"></h4>
							    <div class="form-group">
            			             <label for="tipo_precio">Vendedor </label><br>
            			<select name="vpedido" id="vpedido"  class="form-control">
            				@foreach ($vendedores as $cat)
            				<option value="{{$cat->id_vendedor}}">{{$cat->nombre}} -> {{$cat->comision}}%</option>
            				@endforeach
            			</select>
            				<div align="center"><font color="blue"><label id="notnc"></label></font>
						<font color="red"><label id="cxc"  ></label></font>
						</div>
            		</div>
		</div>
		
		<div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
		<div class="small-box bg-green">
		<div class="inner">
           <h1 id="muestramonto" align="center"><sup style="font-size: 25px"><?php ?>$   0.00</sup></h1>
            </div>
             
            </div>
		</div>
				<div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
		<div class="small-box bg-blue">
		<div class="inner">
           <h1 id="muestramontobs" align="center"><sup style="font-size: 25px"><?php ?>Bs   0.00</sup></h1>
            </div>
             
            </div>
		</div>
    </div>
			{!!Form::open(array('url'=>'pedido/pedido','method'=>'POST','id'=>'form','autocomplete'=>'off'))!!}
            {{Form::token()}}
            <div class="row" style="background-color:#c4c6c6">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <div class="form-group">
		<input type="hidden" value="{{$empresa->tc}}" id="valortasa" name="tc" class="form-control">
		 <input type="hidden" value="" id="nvendedor" name="nvendedor" class="form-control">
		 <input type="hidden" value="{{$empresa->peso}}" id="valortasap" name="peso" class="form-control">
                    	<label for="cliente">Cliente <a href="" data-target="#modalcliente" data-toggle="modal"><span class="label label-success">Nuevo <i class="fa fa-fw  fa-user "> </i></span></a></label>
                    	<select name="id_cliente" id="id_cliente" class="form-control selectpicker" data-live-search="true">
						
                           @foreach ($personas as $per)
                           <option value="{{$per -> id_cliente}}_{{$per -> tipo_precio}}_{{$per -> comision}}_{{$per -> nombrev}}_{{$per -> tipo_cliente}}_{{$per -> cedula}}_{{$per -> nombre}}_{{$per->diascre}}">{{$per -> cedula}}-{{$per -> nombre}}</option> 
                           @endforeach
                        </select>
						<input type="hidden" value="" id="tipocli" name="tipocli">
                    </div>
                </div>
                
				<div  class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
				<table><tr><td>	<div class="form-group">
					<label for="serie_comprobante">Fecha Emision</label>
							<input type="date" name="fecha_emi" <?php if ($nivel=="L"){?> readonly <?php }  ?>  id="fecha_emi" value="<?php echo $fserver;?>" class="form-control">
						   <input type="hidden" name="tipo_comprobante" class="form-control" value="PED">
					</div></td><td><div class="form-group">
						<label for="serie_comprobante">Serie</label>
						<input type="text" style="background-color:#edefef" style="width: 100px" name="serie_comprobante" value="NE00" size="5" class="form-control"placeholder="serie del comprobante" > 
					</div>	</td><td>	<div class="form-group">
						<label for="num_comprobante">Numero</label>
					 <input type="text" name="num_comprobante" style="width: 100px" style="background-color:#edefef"value="<?php echo add_ceros($idv,$ceros); ?>" class="form-control" placeholder="numero del comprobante" > 
					</div></td><td><div class="form-group">
						<label for="comision">Comision</label>
					 <input type="number" name="comision" style="width: 70px" style="background-color:#edefef" id="comision"  value="" class="form-control" placeholder="%" >
					</div></td>
						<td><div class="form-group">
					<label for="comision">Credito</label>
					<input type="number" value="" id="credito"  style="width: 70px" name="diascre" class="form-control">
					</div>
					</td></tr></table>
				
			
			</div>	
            </div>
            <div class ="row" id="divarticulos" style="display: true">
                <div class="panel panel-primary">
                <div class="panel-body">
                    
                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                        <div class="form-group">
                             <label>Articulo</label><i class="fa fa-fw fa-refresh" id="refresh"></i></br>
                             <select name="pidarticulo" id="pidarticulo" class="form-control selectpicker" data-live-search="true" >
                              <option value="1000" selected="selected">Seleccione..</option>
                             @foreach ($articulos as $articulo)
                              <option value="{{$articulo -> idarticulo}}_{{$articulo -> stock}}_{{$articulo -> precio_promedio}}_{{$articulo -> precio2}}_{{$articulo -> costo}}_{{$articulo->iva}}_{{$articulo->licor}}">{{$articulo -> articulo}}</option>
                             @endforeach
                              </select>
                        </div>
					</div>
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                    <div class="form-group">
                        <label for="cantidad">Cantidad</label>
                        <input type="number" name="pcantidad" id="pcantidad" class ="form-control" placeholder="Cantidad">
                    </div>
                    </div>
                    <div class="col-lg-1 col-md-1 col-sm-1 col-xs-12">
                    <div class="form-group">
                        <label for="stock">Stock</label>
                        <input type="text"  name="pstock" id="pstock"  class ="form-control" disabled placeholder="Stock">
                    </div>
                    </div>

                      <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                    <div class="form-group">
                        <label for="precio_venta">Precio venta</label>
                        <input type="number" name="pprecio_venta" id="pprecio_venta"  class ="form-control" placeholder="Precio de Venta" <?php if ($nivel=="L"){?> disabled <?php }  ?> >
                    </div>
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                    <div class="form-group">
                        <label for="descuento">Descuento</label>
                        <input type="number" value="0" name="pdescuento" id="pdescuento" class ="form-control" placeholder="Descuento" min="0">
                        <input type="hidden" value="0" name="pcostoarticulo" id="pcostoarticulo"  class ="form-control" >
                    </div>
                    </div>

                       <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                    <div class="form-group">
						<label></label>					
					 	<button type="button" onmouseover="this.style.color='blue';" onmouseout="this.style.color='grey';"  id="bt_add" class="form-control" <?php if($vencida==1){?>style="display: none"<?php }?> > <i tabindex="1" class="fa fa-fw fa-plus-square"></i> </button>
                    </div>
                    </div>

                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="table-responsive">
                  <table id="detalles" class="table table-striped table-bordered table-condensed table-hover">
                      <thead style="background-color: #A9D0F5">
                          <th>Supr</th>
                          <th>Articulo</th>
                          <th>Cantidad</th>
                          <th>Precio venta</th>
                           <th>Descuento</th>
                          <th>Subtotal</th>
						
                      </thead>
                      <tfoot> 
                      <th><a href="javascript:aggadm();"></a>Total</th>
                          <th>Exe:<input type="number" style="width: 70px" readonly name="totalexe" id="texe"></th>
                          <th>Cto:<input type="number" style="width: 60px" readonly name="totalc" id="totalc"></th>
                          <th>Bif:<input type="number" style="width: 80px" readonly name="total_ivaf" id="total_ivaf"></th>
                          <th>BI:<input type="number" style="width: 80px" readonly name="total_iva" id="total_iva"></th>
                          <th><h4 id="total">$.  0.00</h4><input type="hidden" name="total_venta" id="total_venta"></th>
						 
                          </tfoot>
                      <tbody></tbody>
                  </table>
				  </div>
                    </div>
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" id="botones"  align="right">
						  <div class="form-group">
						  <button class="btn btn-danger" type="button"  id="btncancelar">Cancelar</button>
								<button class="btn btn-primary" id="procesa" type="submit"  accesskey="l">Guardar</button>

					  <div style="display: none" id="loading">  <img src="{{asset('imagenes/sistema/loading30.gif')}}"></div>

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
						<input type="number" class="form-control" name="pmonto" id="pmonto" placeholder="Esperando Seleccion"  min="1" step="0.01">
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
							<div class="table-responsive">
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
					</div>
	
	
						</div>
					  <div class="modal-footer">
						<div class="col-lg-12 ol-md-12 col-sm-12 col-xs-12">
						<button type="button" class="btn btn-danger" id="regresarn" data-dismiss="modal">Cancelar</button>
						<input name="_token" value="{{ csrf_token() }}" type="hidden" ></input>
						<button type="button" id="procesan" class="btn btn-primary" ><u>P</u>rocesar</button>
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
			document.getElementById('Cenviar').style.display="none";
	$("#cnombre").change(activar); 
		function activar(){
		document.getElementById('Cenviar').style.display="";
		}; 
		//registrocliente nuevo
		$("#Cenviar").on("click",function(){ 
		document.getElementById('Cenviar').style.display="none";	
         var form1= $('#formulariocliente');
         var url1 = form1.attr('action');
         var data1 = form1.serialize();
		$.post(url1,data1,function(result){  
	    var resultado=result;
          console.log(resultado);	
        var id=resultado[0].id_cliente;  
        var nombre=resultado[0].nombre; 
		var ced=resultado[0].cedula; 		
        var tp=resultado[0].tipo_precio; 
		var idve=resultado[0].comision; 
		var nv=resultado[0].nombrev; 
		var diascre=resultado[0].diascre; 
		var tpc=resultado[0].tipo_cliente; 		
			$("#id_cliente")
			.append( '<option selected value="'+id+'_'+tp+'_'+idve+'_'+nv+'_'+tpc+'_'+ced+'_'+nombre+'_'+diascre+'">'+ced+'-'+nombre+'</option>')
			.selectpicker('refresh');
			mostrarcomision();
			 alert('Cliente Registrado con exito');
			 $("#formulariocliente")[0].reset();
        });
    });
	
	  //alido cedula cliente nuevo
	$("#vidcedula").on("change",function(){
			var form2= $('#formulariocliente');
			var url2 = '/clientes/cliente/validar';
			var data2 = form2.serialize();
			$.post(url2,data2,function(result2){  
				var resultado2=result2;
				console.log(resultado2); 
				rows=resultado2.length; 
				if (rows > 0){
				var nombre=resultado2[0].nombre;
				var cedula=resultado2[0].cedula; 
				var rif=resultado2[0].telefono;  
				alert ('Numero de identificacion ya existe, Nombre: '+nombre+' Cedula: '+cedula+' telefono: '+rif);   
				$("#vidcedula").val("");
				}    
			});
		});
		//
		document.getElementById('pcantidad').addEventListener('keypress',function(e){ validar(e); });	
	document.getElementById('pprecio_venta').addEventListener('keypress',function(e){ validarno(e); });	
	document.getElementById('pdescuento').addEventListener('keypress',function(e){ validarno(e); });
var count =document.getElementById('id_cliente').options.length;
	if(count ==1 ){
		dato=document.getElementById('id_cliente').value.split('_');
		var comi= dato[2];
		var vendedor= dato[3];
		$("#tipocli").val(dato[4]);
		$("#credito").val(dato[7]);
		$("#comision").val(comi);
		$("#nvendedor").html("<strong>Vendedor:</strong> "+ vendedor);
				if ($("#tipocli").val()==1){		
		document.getElementById('procesa').style.display="none"; } 
	}else{
		$("#id_cliente")
	.append( '<option value="0" selected>Seleccione...</option>')
	.selectpicker('refresh');
	}
	 document.getElementById('bt_pago').style.display="none";	
	document.getElementById('bt_add').tabIndex="1";
	
	    $('#bt_add').click(function(){
		if($("#id_cliente").val()==0){
			alert('¡Debe seleccionar un cliente para el Documento!.')
		}else{
			agregar();
		} 
	});
	 $('#procesa').click(function(){		   
		document.getElementById('loading').style.display=""; 
		document.getElementById('procesa').style.display="none"; 
		document.getElementById('btncancelar').style.display="none"; 
    });
	$('#pasapago').click(function(){
	datosbanco=$("#pidpago").val();
	if(datosbanco<10){
	$("#pmonto").val($("#resta").val());
	document.getElementById('bt_pago').style.display=""; 
	$("#preferencia").focus();
	}else{ alert('¡Debe seleccionar un tipo de Pago!');}
    });

	//$("#pidpago").change(mediopago);
	$('#bt_pago').click(function(){		
			agregarpago();
	});	
	
    $('#guardar').click(function(){
		//var auxmonto=$("#divtotal").val();
		auxmonto=parseFloat(auxmonto.replace(/,/g, ""))
                    .toFixed(2);
		$("#resta").val(auxmonto);
		$("#divtotal").val(auxmonto);
		$('#divarticulos').fadeOut("fast");
		if ($("#tipocli").val()==1){		
		document.getElementById('procesa').style.display="none"; } 
		$('#divdesglose').fadeIn("fast");
    })
	$('#calculo').click(function(){
	var tventa=$("#total_venta").val(); 	//alert(tventa);
			auxtventa=parseFloat(tventa.replace(/,/g, ""))
                    .toFixed(2);
                   // .toString()
                    //.replace(/\B(?=(\d{3})+(?!\d))/g, ",");	
					//alert(auxtventa); 
					//alert(auxtventa);
	var mon_tasa=($("#valortasa").val()*auxtventa);
	var mon_tasap=($("#valortasap").val()*auxtventa);
	$("#dvb").html(auxtventa.toLocaleString('de-DE', { style: 'decimal',  decimal: '2' }));
	$("#dvd").html(mon_tasa.toLocaleString('de-DE', { style: 'decimal',  decimal: '2' }));
	$("#dvp").html(mon_tasap.toLocaleString('de-DE', { style: 'decimal',  decimal: '2' }));
		})
    $('#regresar').click(function(){	
		pagototal=0;	 $("#resta").val($("#total_venta").val());
	   $("#total_abono").text("0.0");
	   $("#tdeuda").val($("#total_venta").val());
	   $("#total").val(0);
	   $("#totala").val(0);
       $('#divdesglose').fadeOut("fast");
       $('#divarticulos').fadeIn("fast");
		for(var i=0;i<10;i++){
		$("#filapago" + i).remove(); acumpago[i]=0; subiva=[0];  subexe=[0];subtotalc=[0]; subivaf=[0];}
	})
   $('#btncancelar').click(function(){	
		total=0; 
		difadm=0;
		acumad=0;
		acumadm=0;
		$("#total").html(" $  : " + total.toLocaleString('de-DE', { style: 'decimal',  decimal: '3' }));			  
	    $("#muestramonto").html(" $  : " + total.toLocaleString('de-DE', { style: 'decimal',  decimal: '3' }));
		$("#muestramontobs").html(" Bs  : " + total.toLocaleString('de-DE', { style: 'decimal',  decimal: '2' }));       
	   $("#divtotal").val(total);
	    $("#resta").val(total);
		$("#tdeuda").val(total);
        $("#total_venta").val(total);
				  $("#total_iva").val(0);
		  $("#texe").val(0);
	   $("#total_ivaf").val(0);
	   $("#totalc").val(0);
		for(var i=0;i<cont;i++){
		$("#fila" + i).remove(); subtotal[i]=0; subiva=[0]; subexe=[0]; subtotalc=[0];subivaf=[0]; }
		 $("#fila1000").remove();
    })
	// registro el cliente nuevo
	$('#vpedido').change(function(){
	 // alert();
	datov= $("#vpedido option:selected").text(); 
	var optv=datov.split('->');
	var vcomi=optv[1].substr(1, 1);
		 $("#nvendedor").val($("#vpedido").val());	
		 $("#comision").val(vcomi);	
	   
});	
});
	function validar(e){
		let tecla = (document.all) ? e.keyCode : e.which;
			if(tecla==13) { 
				agregar();
				event.preventDefault();
			} }
	function validarno(e){
		let tecla = (document.all) ? e.keyCode : e.which;
			if(tecla==13) { 
				event.preventDefault();
				} }	
	var pagototal=0;
	var cont=0;
	total=0;
	totalc=0;
	totalexe=0;
	subtotal=[];
	subtotalc=[];
	subdif=[];
	subiva=[];
	subivaf=[];
	subexe=[];
	totaliva=0;
	totalivaf=0;
	var difadm=0;
	var acumadm=0;

	$("#botones").hide();
	$("#pidarticulo").change(mostrarvalores);
	$("#id_cliente").change(mostrarcomision);

    function mostrarvalores(){      
      tipo_precio=document.getElementById('id_cliente').value.split('_');
      var tpcc= tipo_precio[1];
      if (tpcc==1){ tpc=2;} if ( tpcc==2 ){ tpc=3; } if ( tpcc==3 ){ tpc=4; }
      //de los articulos
	    document.getElementById('pcantidad').focus();
      datosarticulo=document.getElementById('pidarticulo').value.split('_');
      $("#pprecio_venta").val(datosarticulo[tpc]);
      $("#pstock").val(datosarticulo[1]);
	  $("#pcostoarticulo").val(datosarticulo[4]);
      $("#pcantidad").val("1");
      $("#pdescuento").val("0");
    }
	function mostrarcomision(){  
      dato=document.getElementById('id_cliente').value.split('_');
	  
      var comi= dato[2]; 
	  var vendedor= dato[3];  
      $("#comision").val(comi);
      $("#vpedido").val(vendedor);
      $("#nvendedor").val(vendedor);
	  $("#tipocli").val(dato[4]);
	  $("#credito").val(dato[7]);
	  if ($("#tipocli").val()==1){		
		document.getElementById('procesa').style.display="none"; }else{document.getElementById('procesa').style.display=""; }
			
			var form3= $('#form');
			var url3 = '/clientes/cliente/nc';
			var data3 = form3.serialize();
			$.post(url3,data3,function(result3){  
				var resultado3=result3;
				console.log(resultado3); 
				rows=resultado3[0].length; 			
				rowscxc=resultado3[1].length; 
				rowscredito=resultado3[2].length;
				
			//	alert(rowscxc);
					if (rows > 0){
						var montncr=resultado3[0][0].saldo;
					//	alert(montncr);
						$("#notnc").html('N/C -> '+montncr.toFixed(2)+ ' $');
						//$("#montonc").val(montncr);
						//alert($("#montonc").val());
					}
					if (rowscxc > 0){   
						var montocxp=resultado3[1][0].monto;
						$("#cxc").html("CXC -> " + montocxp.toFixed(2)+' $');
					}		
				if(rowscredito > 0){
							if(resultado3[2][0].dias > resultado3[2][0].diascre){
								alert( 'Limite de Credito Vencido' );
							}
					}					
			});
    }
    function agregar(){
		
		vdolar=$("#valortasa").val();
		var cantidad=0; var stock=0;
        datosarticulo=document.getElementById('pidarticulo').value.split('_');
        idarticulo=datosarticulo[0];
		var tp2= datosarticulo[3];
		var tps= $("#pprecio_venta").val();
        articulo= $("#pidarticulo option:selected").text();
        cantidad= $("#pcantidad").val();
        descuento=$("#pdescuento").val();
        precio_venta=$("#pprecio_venta").val();
        stock=$("#pstock").val();
		costoarticulo=datosarticulo[4];
		alicuota=datosarticulo[5];
		cantidad=cantidad*1;
		difadm=cantidad*(tp2-tps);
        if (idarticulo!="" && cantidad != "" &&  precio_venta!=""){
				
			if(alicuota>0){ 
						subiva[cont]=trunc(((precio_venta)/((alicuota/100)+1)), 2);
					subiva[cont]=(cantidad*trunc((subiva[cont]*vdolar),2));
				
					var ctofl=trunc((costoarticulo*1.01),2);
					subivaf[cont]=trunc(((ctofl)/((alicuota/100)+1)), 2);
					subivaf[cont]=(cantidad*trunc((subivaf[cont]*vdolar),2));
				
					//subivaf[cont]=trunc((cantidad*subivaf[cont]),2);					
					subexe[cont]=0;
					}else{
						subexe[cont]=trunc((precio_venta*vdolar),2);
						subexe[cont]=(cantidad*subexe[cont]);
						subivaf[cont]=0; subiva[cont]=0;}
						
					totaliva=totaliva+subiva[cont];
					totalexe=parseFloat(totalexe)+parseFloat(subexe[cont]);
					//alert(totalexe);
						
					totalivaf=totalivaf+subivaf[cont];
					subdif[cont]=difadm;
					acumadm=acumadm+difadm;
					
                subtotal[cont]=((cantidad*precio_venta)-descuento);//alert( subtotal[cont]);
						
                subtotalc[cont]=(cantidad*costoarticulo);//alert( subtotalc[cont]);
                total=parseFloat(total)+parseFloat(subtotal[cont].toFixed(2));//alert( total);
                totalc=parseFloat(totalc)+parseFloat(subtotalc[cont].toFixed(2));//alert( totalc);
		
              var fila='<tr class="selected" id="fila'+cont+'" ><td><button class="btn btn-warning btn-xs"  onclick="eliminar('+cont+');">X</button></td><td><input type="hidden" name="idarticulo[]" value="'+idarticulo+'">'+articulo+'</td><td><input type="number" name="cantidad[]" readonly="true" style="width: 60px" value="'+cantidad+'"></td><td><input type="number" readonly="true" style="width: 80px" name="precio_venta[]" value="'+precio_venta+'"></td><td><input type="number"  name="descuento[]" readonly="true" style="width: 80px" value="'+descuento+'"></td><td>'+subtotal[cont].toFixed(2)+'<input type="hidden" name="costoarticulo[]" readonly="true" value="'+costoarticulo+'"></td></tr>';
              cont++;
              limpiar();
	
			  var auxmbs=(parseFloat(total)*parseFloat(vdolar));
              $("#total").html(" $  : " + total.toFixed(2));			  
			  $("#muestramonto").html(" $  : " + total.toFixed(2));
			  $("#muestramontobs").html(" Bs  : " + auxmbs.toFixed(2));
               $("#divtotal").val(total);
				$("#totalc").val(totalc);
			   $("#tdeuda").val(total);
			   $("#resta").val(total);
			    $("#total_iva").val(totaliva.toFixed(2));
			    $("#total_ivaf").val(totalivaf.toFixed(2));
			    $("#texe").val(totalexe.toFixed(2));
              $("#total_venta").val(total);   
              evaluar();
              $('#detalles').append(fila);
				$("#pidarticulo").selectpicker('toggle');

        }
        else{
            alert("Error al ingresar el detalle de la venta, revisar datos")
        }
    }
    function eliminar(index){
		vdolar=$("#valortasa").val();
		totaliva=(parseFloat(totaliva) - parseFloat(subiva[index]));
		totalivaf=(parseFloat(totalivaf) - parseFloat(subivaf[index]));
		totalexe=(parseFloat(totalexe) - parseFloat(subexe[index]));
        total=(total-subtotal[index]).toFixed(2);
		 totalc=(totalc-subtotalc[index]).toFixed(2);
		  $("#texe").val(totalexe.toFixed(2));
        $("#total").html(total);
        $("#divtotal").val(total);
		$("#resta").val(total);
		var mon_tasad=(total);
		$("#muestramonto").html("$  : " + mon_tasad.toLocaleString('de-DE', { style: 'decimal',  decimal: '3' }));
		$("#muestramontobs").html("Bs  : " + (mon_tasad*vdolar).toLocaleString('de-DE', { style: 'decimal',  decimal: '2' }));
		if(total<0){total=0; acumadm=0;}
		    $("#totalc").val(total);
        $("#total_venta").val(total);
			$("#total_iva").val(totaliva.toFixed(2));
		$("#total_ivaf").val(totalivaf.toFixed(2));
		$("#tdeuda").val(total);
        $("#fila" + index).remove();
        evaluar();

    }
    function limpiar(){
		$("#pidarticulo").val('1000');
		$("#pidarticulo").selectpicker('refresh');
        $("#pcantidad").val("");
        $("#pdescuento").val("");
        $("#pstock").val("");
        $("#pprecio_venta").val("");
    }

    function evaluar(){
        if(total>0){
            $("#botones").show();
        }
        else
        {
            $("#botones").hide();
        }
    }

	function conMayusculas(field) {
            field.value = field.value.toUpperCase()
	}
	function trunc (x, posiciones = 0) {
  var s = x.toString()
  var l = s.length
  var decimalLength = s.indexOf('.') + 1
  var numStr = s.substr(0, decimalLength + posiciones)
  return Number(numStr)
}
	function round(num){
	 var n=Number((Math.abs(num)*100).toPrecision(3));
	 return Math.round(n)/100*Math.sign(num);
	}
 	$("#refresh").on("click",function(){
			$("#pidarticulo").empty();
			var form3= $('#formulariocliente');
			var url3 = '/ventas/ventas/refrescar';
			var data3 = form3.serialize();
			$.post(url3,data3,function(result3){  
				var r3=result3;
				console.log(r3); 
				rows=r3.length; 
				   $("#pidarticulo")
				.append('<option value="1000" selected="selected">Seleccione..</option>');
				for (j=0;j<rows;j++){
				$("#pidarticulo")
				.append( '<option value="'+r3[j].idarticulo+'_'+r3[j].stock+'_'+r3[j].precio_promedio+'_'+r3[j].precio2+'_'+r3[j].costo+'">'+r3[j].articulo+'</option>');
				}
				$("#pidarticulo").selectpicker('refresh');
				$("#pidarticulo").selectpicker('toggle');
			});
	});
				function aggadm(){  
		var fila='<tr class="selected" id="fila1000" ><td><button class="btn btn-warning btn-xs"  onclick="eliminaradm(1000);">X</button></td><td><input type="hidden" name="idarticulo[]" value="999999">RECUPERACION DE GASTOS</td><td><input type="number" name="cantidad[]" readonly="true" style="width: 60px" value="1"></td><td><input type="number" readonly="true" style="width: 80px" name="precio_venta[]" value="'+acumadm+'"></td><td><input type="number"  name="descuento[]" readonly="true" style="width: 80px" value="0"></td><td>'+acumadm.toFixed(2)+'<input type="hidden" name="costoarticulo[]" readonly="true" value="0"></td></tr>';
		$('#detalles').append(fila);
		var vdolar=$("#valortasa").val();
		totalexe=(totalexe+(acumadm*vdolar));
	
		 $("#texe").val(totalexe.toFixed(2));
		var nm=$("#divtotal").val();
		var nmdif=parseFloat(acumadm)+parseFloat(nm);
		//alert(nmdif);
		var auxmbs=(parseFloat(nmdif)*parseFloat(vdolar));
		$("#total").html(" $  : " + nmdif.toFixed(2));			  
		$("#muestramonto").html(" $  : " + nmdif.toFixed(2));
		$("#muestramontobs").html(" Bs  : " + auxmbs.toFixed(2));
		$("#divtotal").val(nmdif);
		$("#tdeuda").val(nmdif);
		$("#resta").val(nmdif);
		$("#total_venta").val(nmdif);
		//document.getElementById('fila1000').style.display="";
	}
	    function eliminaradm(index){
		//alert(index);
		var nm=$("#divtotal").val();
		var total=parseFloat(nm)-parseFloat(acumadm);
		vdolar=$("#valortasa").val();
        total=(total).toFixed(2);
        $("#total").html(total);
        $("#divtotal").val(total);
		$("#resta").val(total);
		var mon_tasad=(total);
		$("#muestramonto").html("$  : " + mon_tasad.toLocaleString('de-DE', { style: 'decimal',  decimal: '3' }));
		$("#muestramontobs").html("Bs  : " + (mon_tasad*vdolar).toLocaleString('de-DE', { style: 'decimal',  decimal: '2' }));
		if(total<0){total=0;}
        $("#total_venta").val(total);
        $("#fila1000").remove();

    }
</script>
@endpush
@endsection