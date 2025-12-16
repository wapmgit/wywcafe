@extends ('layouts.admin')
@section ('contenido')
@include('pedido.venta.empresa')
<?php $aux=0; $acumgdm=0; $aux1=0; $cto=0;$fserver=date('Y-m-d'); $mcomi=0;
function add_ceros($numero,$ceros) {
  $numero=$numero+1;
$digitos=strlen($numero);
  $recibo=" ";
  for ($i=0;$i<8-$digitos;$i++){
    $recibo=$recibo."0";
  }
return $insertar_ceros = $recibo.$numero;

}; 
function truncar($numero, $digitos)
{
    $truncar = 10**$digitos;
    return intval($numero * $truncar) / $truncar;
}
$tasa=0;$acumsub=0;$acumiva=0; $acumbase=0; $auxf=0; $acumex=0; $licor=0;   $precioad=0; $costofbsad=0;
	$acumivab=$preciob=$varb=$ivab=$ctobsb=$costofbsb=$acumbib=$subivab=0;$ctob=0; $ctobsad=0;
	if($credito!=NULL){
		$diascre=$credito->diascre;
		$dias=$credito->dias;
	}else{ $diascre=0;$dias=0;}
?>
	<div class="row">
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
			<div class="form-group">
				<label for="cliente">Cliente</label>
		   <p>{{$venta->cedula}} -> {{$venta->nombre}}</p>
			</div>
		</div>
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
			<div class="form-group">
			  <label for="direccion">Direccion</label>
		   <p>{{$venta->direccion}}</p>
		   <input type="hidden" name="diascre" id="diascre" value="{{$diascre}}">
		   <input type="hidden" name="dias" id="dias" value="{{$dias}}">
			</div>
		</div>   
	</div>				
  @include('pedido.venta.aggarticulo')
            <div class ="row">
			  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="panel panel-primary">
                <div class="panel-body">
                    
                  <?php $tasa=$empresa->tc; $acumbi=$var=$acumiva=0; $miva=0;$acumexe=0; $mivaf=0; $acumivaf=$acumcto=0; $mcomiv=0;?>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <table id="detalles" class="table table-striped table-bordered table-condensed table-hover">
                      <thead style="background-color: #A9D0F5">
                     
                          <th>Articulo <a href="" data-target="#modalm" data-toggle="modal"><span class="label label-success"><i class="fa fa-fw  fa-plus"> </i></span></a></th>
                          <th>Cantidad</th>
                          <th>Stock</th>
                          <th>Descuento</th>
                          <th>precio venta</th>
                          <th>subtotal</th>
                      </thead>

                      <tbody>
                        @foreach($detalles as $det)
						<?php 	
						$ctob=$ctob+($det->cantidad*$det->costoarticulo)	;
						if($det->comi==1){
							$mcomi=$mcomi+(($det->cantidad*$det->precio_venta)*($det->pcomision/100)); 
							$mcomiv=$mcomiv+(($det->cantidad*$det->precio_venta)*($venta->comision/100)); }			
						if($det->idarticulo==999999){ $aux1=1; 
						    $precioad=$det->precio_venta; 								
							$ctobsad=($precioad*$tasa);
							$costofbsad=truncar(($ctobsad),2);
						  $acumex= $acumex+$costofbsad;
						?>
						
						  <tr><td>{{$det->articulo}}</td>  <td>{{$det->cantidad}}</td>  <td>0</td>  <td>0</td>  <td>{{$det->precio_venta}}</td>  <td>{{$det->precio_venta}}</td></tr>
						<?php } else{ 
					
						$acumgdm=($acumgdm +($det->cantidad*($det->preciof-$det->precio_venta))); ?>
                        <tr >						
                          <td>{{$det->articulo}}
							<?php if($det->iva>0){
							$precio=($det->precio_venta);	
							//$precio = truncar(($precio),2);											 
							$var=(($precio)/(($det->iva/100)+1));						
							$var = truncar(($var),2);
							$iva=(($precio-$var));
							$subiva=($iva*$det->cantidad);					
							$acumiva=$acumiva+$subiva;		
							$acumiva = number_format(($acumiva),3);
							$costofinal=$precio-$iva;
							$ctobs=($costofinal*$tasa);
							$costofbs=truncar(($ctobs),2);
							$subbs=($costofbs*$det->cantidad);
						    $acumbi=$acumbi+($costofbs*$det->cantidad);
						  echo "(G)"; 						
						  }else {   
						  $precio=$det->precio_venta; 								
							$ctobs=($precio*$tasa);
							$costofbs=truncar(($ctobs),2);
							$subbs=($costofbs*$det->cantidad);
						  $acumex=$acumex+$subbs; echo "(E)";
							}
						
							?>
						  </td>
						  <?php if($det->iva>0){
							$preciob=($det->costo*1.01);	
							$preciob=truncar($preciob,2);										 
							$varb=(($preciob)/(($det->iva/100)+1));						
							$varb = truncar(($varb),2);
							$ivab=(($preciob-$varb));
							$subivab=($ivab*$det->cantidad);					
							$acumivab=$acumivab+$subivab;		
							$acumivab = number_format(($acumivab),3);
							$costofinalb=$preciob-$ivab;
							$ctobsb=($costofinalb*$tasa);
							$costofbsb=truncar(($ctobsb),2);
							$subbsb=($costofbsb*$det->cantidad);
						    $acumbib=$acumbib+($costofbsb*$det->cantidad);
						 		
						  }?>
                          <td> 
						  <?php if ($det->cantidad>$det->stock){ $aux=1; echo "*";}
							if (($det->licor==1) and ($det->stock>0)){ $licor=1;}
						  if(($det->cantidad>0)and ($venta->devolu==0)){
						  ?>@if($rol->editpedido==1)
						    <a href="" data-target="#modaldevolucion-{{$det->idarticulo}}" data-toggle="modal">{{$det->cantidad}}</a>@else {{$det->cantidad}}@endif
						  <?php } else { echo $det->cantidad;} ?> 
						  </td> 
                          <td> {{ $det->stock}}</td>
                          <td>{{$det->descuento}}<?php echo number_format( $acumexe, 2,',','.'); ?></td>
                          <td><?php echo number_format( $det->precio_venta, 2,',','.'); ?></td>
                          <td><?php echo number_format( ($det->cantidad*$det->precio_venta), 2,',','.'); ?></td>
                        </tr>
						<?php } ?>
						@include('pedido.venta.modaldevolucion')
                        @endforeach
                      </tbody>
						<tfoot> 
                      <th><?php if($aux1==0){?><a href="javascript:aggadm();"></a>Total<?php }else {?>Total<?php  } ?> </th>
                          <th>Exe:<input type="number" style="width: 70px" readonly  name="totalexe" value="<?php echo $acumex; ?>"  id="texe"></th>
                          <th>Cto:<input type="number" style="width: 60px" readonly value="<?php echo $ctob; ?>" name="totalc" id="totalc"></th>
                          <th>Bif:<input type="number" style="width: 80px"   value="<?php echo $acumbib; ?>" readonly name="total_ivaf" id="total_ivaf"></th>
                          <th>BI:<input type="number" style="width: 80px"  value="<?php echo $acumbi; ?>" readonly name="total_iva" id="total_iva"></th>
                          <th><h4 id="total"><?php echo number_format($venta->total_venta, 2,',','.'); ?> $</h4><input type="hidden" name="total_venta" id="total_venta"></th>						 
                          </tfoot>
                  </table><table width="100%">
						<tr><td colspan="2"><?php
						if(!is_null($cxc) ){
						if($cxc->monto>0){ echo "N/C -> $ ".number_format( ($cxc->monto), 2,',','.'); }} ?></td>
						<td colspan="2"><?php if($empresa->modop==0){$mcomi=$mcomiv;}?> </td>
						<td colspan="2"><?php echo "Monto Comision -> $ ".number_format( ($mcomi), 2,',','.'); ?> </td>
						</tr>	  </table>
                    </div>
 
                </div>
                    
                </div>
 
             <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="form-group">

                    <label for="num_comprobante">Fecha:</label>
                    <p>{{$venta->fecha_hora}}</p>
                </div>
            </div> 
     <div class="col-lg-12 col-md-12 col-sm-6 col-xs-12">
                    <div class="form-group" align="center">
                     <button type="button" id="regresar" class="btn btn-success" data-dismiss="modal">Regresar</button>
					<button type="button" id="imprimir" class="btn btn-primary" data-dismiss="modal">Imprimir</button>
				@if($rol->crearventa==1)	 <?php if($venta->devolu ==0){?>
                 <?php if ($aux==0){?>    <a id="facturar" href="" data-target="#modal-{{$venta->idventa}}" data-toggle="modal"><button class="btn btn-info">Facturar</button></a><?php } else { echo " Verificar stock...";}?>
					<?php  } ?>  @endif
					@include('pedido.venta.modal')
                    </div>
                </div>
				

             <div style="display:none">
			 	{!!Form::open(array('url'=>'agregargastoadm','method'=>'POST','autocomplete'=>'off','id'=>'formularioadm'))!!}
            {{Form::token()}}
				<input type="text" name="tadm"  value="<?php echo $acumgdm; ?>"  >
				<input type="text" name="tped"  value="<?php echo $venta->total_venta; ?>"  >
				<input type="text" name="idped"  value="<?php echo $venta->idventa; ?>"  >				
							
	{!!Form::close()!!}	
				</div>


        </div>
		
@push ('scripts')
<script>
$(document).ready(function(){
    $('#imprimir').click(function(){
  //  alert ('si');
  document.getElementById('imprimir').style.display="none";
  document.getElementById('regresar').style.display="none";
  window.print(); 
  window.location="/pedido/pedido";
    });
	$("#pidarticulo").change(function(){
	 document.getElementById('pcantidad').focus();
	datosarticulo=document.getElementById('pidarticulo').value.split('_');
	
      $("#pprecio_venta").val(datosarticulo[2]);
      $("#pf").val(datosarticulo[3]);
	  $("#pcostoarticulo").val(datosarticulo[4]);
      $("#pcantidad").val("1");
      $("#idarticulo").val(datosarticulo[0]);
		  document.getElementById('btnsubmit').style.display="";
	});
	    $('#btnsubmit').click(function(){
			  document.getElementById('btnsubmit').style.display="none";
		});
		$('#regresar').click(function(){
				window.location="/pedido/pedido";
		});
		$('#btnconfirmar').click(function(){
				  document.getElementById('btnconfirmar').style.display="none";
		});
		
		$('#facturar').click(function(){
			
		var dias=$("#dias").val();
		var diascre=$("#diascre").val();
		var xd=parseFloat(dias)-parseFloat(diascre);
		if(xd > 0)
		{ alert('Limite de Credito Vencido.'); 
		}
		});

});
	function aggadm(){  
if (window.confirm("Confirma Generar Gasto Administrativo?")) {
		document.getElementById('formularioadm').submit(); 
}
		
	}
</script>

@endpush
@endsection