
@extends ('layouts.admin')
@section ('contenido')
<?php
$cntcat=0;
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
 $concat=0;
 $concatv=0;
 
 $cntcat=count($categorias);
?>     @foreach ($contador as $p)
              <?php  $idv=$p -> idventa; ?>
              <option style="display: none">{{$p -> idventa}} </option> 
          @endforeach
	<style> 
   .cabecera { background: linear-gradient(to bottom, #67CD18, #FAFAFA); padding: 2px;}
   .pie { background: linear-gradient(to bottom,  #FAFAFA, #67CD18); padding: 2px;}
.bordeimagen{
border:2px solid #489B07;
padding:5px;
}

.card {
  box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
  max-width: 300px;
  margin: auto;
  text-align: center;
  font-family: arial;
}

.price {
  color: grey;
  font-size: 22px;
}

.buttonplus {
  border: none;
  outline: 0;
  padding: 6px;
  color: white;
  background-color: #008000;
  text-align: center;
  cursor: pointer;
  width: 60%;
  font-size: 18px;
}
.buttonless {
  border: none;
  outline: 0;
  padding: 6px;
  color: white;
  background-color: #FF0000;
  text-align: center;
  cursor: pointer;
  width: 60%;
  font-size: 18px;
}

.card button:hover {
  opacity: 0.7;
}
  </style> 	
	<div class="row" style="background-color:#f3f4f4"> 
		<div class="col-lg-12 col-md-21 col-sm-12 col-xs-12">
			<h3 align="center">Venta 
			<a href="/ventas/venta/create"><i class="fa fa-fw fa-television"></i> </a>
			</h3>
			<input type="hidden" value="{{$empresa->tc}}" id="valortasa" name="tc"></input>
		  <input type="hidden" value="{{$empresa->peso}}" id="valortasap" name="peso"></input>
		  <input type="hidden" value="{{$cntcat}}" id="cntcat"></input>
		  <input type="hidden" value="0" name="total_venta" id="totala"></input>
        </div>		
	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
			<div class="small-box bg-green">
			<div class="inner">
			   <h1 id="muestramonto" align="center"><sup style="font-size: 25px"><?php ?>$   0.00</sup></h1>
				</div>
				 
				</div>
	</div>
	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
			<div class="small-box bg-blue">
			<div class="inner">
			   <h1 id="muestramontobs" align="center"><sup style="font-size: 25px"><?php ?>Bs   0.00</sup></h1>
				</div>
				 
				</div>
	</div>
	 @foreach ($categorias as $cat) <?php $concat++; ?>
		<div class="col-lg-4 col-md-4 col-sm-4 col-xs-6" >
				<p> <button type="button" onclick="javascript:optcat({{$concat}});" class="btn btn-block btn-default btn-lg">{{$cat->nombre}}</button></p>
		</div>  
	@endforeach

		 </div>
			{!!Form::open(array('url'=>'ventas/venta/save','method'=>'POST','id'=>'form','autocomplete'=>'off'))!!}
            {{Form::token()}}
            <div class="row" style="background-color:#edefef">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <div class="form-group">
		<input type="hidden" value="{{$empresa->tc}}" id="valortasa" name="tc" class="form-control">
		<input type="hidden" value="{{$vendedores->id_vendedor}}" id="vpedido" name="vpedido" class="form-control">
				 <input type="hidden" value="" id="nvendedor" name="nvendedor" class="form-control">
				 <input type="hidden" value="" id="almacen" name="almacen" class="form-control">
				<input type="hidden" value="{{$empresa->peso}}" id="valortasap" name="peso" class="form-control">                    
				<input type="hidden" name="id_cliente" id="id_cliente" value="{{$personas -> id_cliente}}_{{$personas -> tipo_precio}}_{{$personas -> comision}}_{{$personas -> nombrev}}_{{$personas -> tipo_cliente}}_{{$personas -> cedula}}_{{$personas -> nombre}}_{{$personas->diascre}}_{{$personas->licencia}}"></input>                                         
						<input type="hidden" value="0" id="tipocli" name="tipocli">
						<input type="hidden" value="FAC"  name="tipo_comprobante" class="form-control">
                    </div>
                </div>
                
				<div  class="col-lg-6 col-md-6 col-sm-6 col-xs-12" style="display:none">
				  <div class="table-responsive">
				<table width="100%"><tr><td>	<div class="form-group">
					<label for="serie_comprobante">Fecha Emision</label>
							<input type="date"  style="width: 100px" name="fecha_emi" <?php if ($nivel=="L"){?> readonly <?php }  ?>  id="fecha_emi" value="<?php echo $fserver;?>" class="form-control">
					</div></td><td><div class="form-group">
						<label for="serie_comprobante">Serie</label>
						<input type="text" style="background-color:#edefef" <?php if ($nivel=="L"){?> readonly <?php }  ?>  style="width: 100px" name="serie_comprobante" value="NE00" size="5" class="form-control"placeholder="serie del comprobante" > 
					</div>	</td><td>	<div class="form-group">
						<label for="num_comprobante">Numero</label>
					 <input type="text" name="num_comprobante"  <?php if ($nivel=="L"){?> readonly <?php }  ?>  style="width:  100px" style="background-color:#edefef"value="<?php echo add_ceros($idv,$ceros); ?>" class="form-control" placeholder="numero del comprobante" > 
					</div></td><td><div class="form-group">
						<label for="comision">Comision</label>
					 <input type="number" name="comision"  <?php if ($nivel=="L"){?> readonly <?php }  ?>  style="width: 70px" style="background-color:#edefef" id="comision"  value="{{$vendedores->comision}}" class="form-control" placeholder="%" >
					</div>
					</td>
					<td><div class="form-group">
					<label for="comision">Credito</label>
					<input type="number" value="" id="credito" <?php if ($nivel=="L"){?> readonly <?php }  ?>  style="width: 70px" name="diascre" value="$personas -> diascre" class="form-control">
					</div>
					</td>		
					</tr></table>

			
			</div>	
			</div>	
            </div>
            <div class ="row" id="optventa">
		@foreach ($categorias as $cat) <?php $concatv++; ?>
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" id="<?php echo $concatv; ?>" style="display:none">
				@foreach($articulos as $det)
				<?php if($cat->idcategoria==$det->idcategoria){?>
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-6" >
					<div class="card">
					  <h3> {{$det->nombre}} {{$cat->idcategoria}}</h3>
					  <p class="price"> $ {{$det->precio_promedio}}</p>
					  <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4" >
						<button class="buttonplus"  onclick="javascript:addcnt({{$det->idarticulo}},{{$det->precio_promedio}});" type="button">+</button>
					  </div>
					   <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4" >
						<label class="price"id="cntlabel{{$det->idarticulo}}">0</label>
						<input type="hidden" value="0" id="cnt{{$det->idarticulo}}"></input>
					  </div>
					  <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4" >
					  <button class="buttonless"  id="btnless{{$det->idarticulo}}"  disabled onclick="javascript:lesscnt({{$det->idarticulo}},{{$det->precio_promedio}});" type="button">-</button>
					  </div>
					<label  id="mntlabel{{$det->idarticulo}}">$</label>
						  <input type="hidden" value="0" id="mnt{{$det->idarticulo}}"></input>
					</div>
                </div>  
				<?php } ?>
				@endforeach	
			</div>			
		@endforeach
		
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" id="opt-btn" style="display:none">		</br>
			<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6" >
					<button type="button" id="detventa"  class="btn btn-block btn-default btn-lg">Detalle Venta</button>
			</div>  
			<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6" >
					<button type="button" id="btnprocesar" class="btn btn-block btn-default btn-lg">Procesar</button>
			</div>
		</div>
	</div>
	<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" id="detarticulos" style="display:none">
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
					<div class="table-responsive">
                  <table id="detalles" width="90%" >
                      <thead>
                          <th>Articulo</th>
                          <th>Cantidad</th>
                          <th>Precio</th>
                          <th>SubTotal</th>						
                      </thead>
                      <tbody>
					  </tbody> 
                  </table>
				  </div>
			</div>
			<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6"></br>
				<button type="button" id="backventa" class="btn btn-block btn-default btn-lg">Regresar</button>
				<button type="button" id="btntotalizar" class="btn btn-block btn-default btn-lg">Totalizar</button>
			</div>
			</div>
			
	</div>

        <div class ="row" id="divdesglose" style="display: none">
                <div class="panel panel-primary">
                <div class="panel-body">
                <div class="modal-content">
					   <div class="modal-header" align="center">
					   <h3 >TOTAL <input type="number" id="divtotal" value="" disabled ><span id="pasapago" title="haz click para hacer cobro total">RESTA</span> <input type="number" id="resta" disabled value="">
						<input type="hidden" name="tdeuda" id="tdeuda" value=""  ></h3>
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
                          <th><h3 id="total_abono">$.  0.00</h3></th><input type="hidden" name="totalab" id="totalab" value="0.00">
                          </tfoot>
                      <tbody></tbody>
                    </table>
					</div>
					</div>
	
	
						</div>
					  <div class="modal-footer">
						<div class="col-lg-12 ol-md-12 col-sm-12 col-xs-12" >
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6" >
							<button type="button" class="btn btn-block btn-danger btn-lg" id="regresar" data-dismiss="modal">Cancelar</button>
							</div>
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6" >
							<input name="_token" value="{{ csrf_token() }}" type="hidden" ></input>
							<button type="submit" id="procesa" disabled class="btn btn-block btn-primary btn-lg" ><u>P</u>rocesar</button>
						  <div style="display: none" id="loading">  <img src="{{asset('imagenes/sistema/loading30.gif')}}"></div>
							</div>
					  </div>
					  </div>
				</div>
              </div>
            </div>{!!Form::close()!!}
        </div>
					  
@push ('scripts')
<script>
$(document).ready(function(){	
	
	total=0;
	vdolar=$("#valortasa").val();
	 document.getElementById('bt_pago').style.display="none";
	$("#detventa").on("click",function(){ 
		document.getElementById('optventa').style.display="none";	
		document.getElementById('detarticulos').style.display="";		
	});
		$("#backventa").on("click",function(){ 
		document.getElementById('optventa').style.display="";	
		document.getElementById('detarticulos').style.display="none";		
	});
	$("#btntotalizar").on("click",function(){ 
		document.getElementById('optventa').style.display="none";	
		document.getElementById('detarticulos').style.display="none";		
		document.getElementById('divdesglose').style.display="";		
	});
		$("#btnprocesar").on("click",function(){ 
		document.getElementById('optventa').style.display="none";	
		document.getElementById('detarticulos').style.display="none";		
		document.getElementById('divdesglose').style.display="";		
	});
	$('#pasapago').click(function(){
		datosbanco=$("#pidpago").val();
			if(datosbanco<10){
				$("#pmonto").val($("#resta").val());
				document.getElementById('bt_pago').style.display=""; 
				$("#preferencia").focus();
			}else{ alert('¡Debe seleccionar un tipo de Pago!');}
    });
	$('#bt_pago').click(function(){		
			agregarpago();
	});
	$("#pidpago").change(mediopago);
	
	$('#regresar').click(function(){	
		pagototal=0;	 $("#resta").val($("#divtotal").val());
	   $("#total_abono").text("0.0");
	   $("#tdeuda").val($("#divtotal").val());
	   $("#totalab").val(0);
	   $("#pidpago").val('10');
	   $("#procesa").attr('disabled',true);
	   document.getElementById('optventa').style.display="";	
	   document.getElementById('divdesglose').style.display="none";	
		document.getElementById('detarticulos').style.display="none";	
		for(var i=0;i<10;i++){
		$("#filapago" + i).remove(); acumpago[i]=0;}
	})
});
   function mediopago(){
	   	var totala=$("#totalab").val();		
		var pesototal =$("#divtotal").val();		
		var pesoresta =pesototal-parseFloat(totala); 
		datosbanco=$("#pidpago").val();
		nbanco=$("#pidpago option:selected").text();
			if (datosbanco==1){ 
			var vdolar=$("#valortasa").val();  
			var auxresta=((pesoresta*vdolar).toFixed(2));		
			$("#resta").val(auxresta);  
			$("#preferencia").val('Tc: '+vdolar);  
			}
			if (datosbanco==2){ 
			var vpeso=$("#valortasap").val(); 
			var auxresta=((pesoresta*vpeso).toFixed(2));					
			$("#resta").val(auxresta); 
			$("#preferencia").val('Tc: '+vpeso);  			
			}   
			if (datosbanco==0){ 			
				$("#resta").val(pesoresta);  
			}
		$("#pmonto").attr('placeholder','Monto en '+nbanco);
		t_pago=$("#pidpago").val();
    }
		//agrego tipo pago
	acumpago=[];var contp=0; var tresta=0; var pagototal=0;
	function agregarpago(){
 
        vresta=$("#resta").val();    
		idpago=$("#pidpago").val();
        tpago= $("#pidpago option:selected").text();
        pmonto= $("#pmonto").val();
        pref= $("#preferencia").val();
		if(pmonto > 0){
		if(parseFloat(pmonto)<=parseFloat(vresta)){
			var denomina=pmonto;
			acumpago[contp]=(pmonto);
			//	alert(acumpago[contp]);
			if (idpago==1){ 
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
			//alert(pagototal);
			tventa=$("#divtotal").val();
			tresta=(parseFloat(tventa)-parseFloat(pagototal));
            $("#resta").val(tresta.toFixed(2));
            $("#tdeuda").val(tresta.toFixed(2));	
            var fila='<tr  id="filapago'+contp+'"><td align="center"><span onclick="eliminarpago('+contp+');"><i class="fa fa-fw fa-eraser"></i></span></td><td><input type="hidden" name="tidpago[]" value="'+idpago+'"><input type="hidden" name="tidbanco[]" value="'+tpago+'">'+tpago+'</td><td><input type="hidden" name="denominacion[]" value="'+denomina+'">'+denomina+'</td><td><input type="hidden" name="tmonto[]" value="'+pmonto+'">'+pmonto+'</td><td><input type="hidden" name="tref[]" value="'+pref+'">'+pref+'</td></tr>';
            contp++;
            document.getElementById('bt_pago').style.display="none";
			$("#pidpago").val('10');
			$("#pmonto").attr('placeholder','Esperando Seleccion');
			$("#total_abono").text(pagototal.toFixed(2));
			$("#totalab").val(pagototal.toFixed(2));
			if($("#resta").val()== 0){ 		document.getElementById('procesa').style.display=""; $("#procesa").attr("accesskey","p"); }
			//  alert($("#totala").val());
           limpiarpago();		 
             $('#det_pago').append(fila);
			 	$("#procesa").attr('disabled',false);
		}else { alert('¡El monto indicado no debe se mayor al saldo pendiente!');
			limpiarpago();		
			}
		}
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
		$("#totalab").val(nc);
        pagototal=(parseFloat(pagototal)-parseFloat(total));
        $("#filapago" + index).remove();
        $("#total_abono").text(nc.toFixed(2));
		document.getElementById('procesa').style.display="none"; 
    }
	subtotal=[];
	namearray=[];
	idartarray=[];
	cntarray=[];
 var jsArray = <?php echo json_encode($articulos); ?>;
  //console.log(jsArray);
for (i = 0; i < jsArray.length; i++) {
 const todosLosIds = jsArray.map(p => p.idarticulo);
 const todosName = jsArray.map(n => n.nombre);
idartarray[i]=todosLosIds[i];
subtotal[i]=0;
cntarray[i]=0;
namearray[i]=todosName[i];


}
function optcat(cont){
	var cl=$("#cntcat").val();
	for(var i=1;i<=cl;i++){
	document.getElementById(i).style.display="none"; }
document.getElementById(cont).style.display=""; 
}
function addcnt(id,price){
	totalventa=$("#totala").val();
	cntart=$("#cnt"+id).val();
	cntart++;
		$("#cnt"+id).val(cntart);
		$("#cntlabel"+id).html(cntart);
		var mntf=parseFloat(price)*parseFloat(cntart);
		$("#mntlabel"+id).html("$ " +mntf.toFixed(2));
		$("#mnt"+id).val(mntf);
		$("#btnless"+id).attr('disabled',false);
		total=parseFloat(totalventa)+price;
			  var auxmbs=(parseFloat(total)*parseFloat(vdolar));		  
			  $("#muestramonto").html(" $  : " + total.toFixed(2));
			  $("#muestramontobs").html(" Bs  : " + auxmbs.toFixed(2));
	const index = idartarray.indexOf(id); 
	subtotal[index]=mntf;
	cntarray[index]=cntart;
	idartarray[index]=id;
	$("#totala").val(total);
		if (existeFila(index)) {
			$("#cantidad"+index).val(cntart);
			$("#precio_venta"+index).val(mntf);
		} else {
		  var fila='<tr id="fila'+index+'"><td><input type="hidden" name="idarticulo[]" value="'+idartarray[index]+'">'+namearray[index]+'</td><td><input type="number" name="cantidad[]" id="cantidad'+index+'" readonly="true" style="width: 60px" value="'+cntarray[index]+'"></td><td><input type="number" name="precio[]" readonly="true" style="width: 60px" value="'+price+'"></td><td><input type="number" readonly="true" style="width: 80px" name="precio_venta[]" id="precio_venta'+index+'" value="'+subtotal[index]+'"></td></tr>'; 
			$('#detalles').append(fila);
		}
		document.getElementById('opt-btn').style.display=""; 
		$("#divtotal").val(total);
		$("#resta").val(total);
	}
	function lesscnt(id,price){
	totalventa=$("#totala").val();
	cntart=$("#cnt"+id).val();
	cntart--;
		$("#cnt"+id).val(cntart);
		$("#cntlabel"+id).html(cntart);
		var mntf=parseFloat(price)*parseFloat(cntart);
		$("#mntlabel"+id).html("$ " +mntf.toFixed(2));
		$("#mnt"+id).val(mntf);
		if(cntart==0){ 
			$("#btnless"+id).attr('disabled',true);
			mntf=price; 
			const index = idartarray.indexOf(id); 
		     $("#fila"+index).remove();
			 }
			
				
		total=parseFloat(totalventa)-parseFloat(price);
			var auxmbs=(parseFloat(total)*parseFloat(vdolar));		  
			  $("#muestramonto").html(" $  : " + total.toFixed(2));
			  $("#muestramontobs").html(" Bs  : " + auxmbs.toFixed(2));
			const index = idartarray.indexOf(id); 
			subtotal[index]=mntf;
			cntarray[index]=cntart;
			$("#totala").val(total.toFixed(2));
		if (existeFila(index)) {
			$("#cantidad"+index).val(cntart);
			$("#precio_venta"+index).val(mntf);
		} 
			$("#divtotal").val(total);
			$("#resta").val(total);
	  }		
	function existeFila(idArticulo) {
    // Buscamos si existe un elemento con ese ID específico en la página
		const fila = document.getElementById('fila'+idArticulo);   
		return fila !== null; // true si existe, false si no
	}
</script>
@endpush
@endsection
