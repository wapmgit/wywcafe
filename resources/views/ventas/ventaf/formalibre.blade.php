@extends ('layouts.admin')
@section ('contenido')
<?php $acum=0; 
$ceros=5;  $acumnc=0;
function add_ceros($numero,$ceros) {
  $numero=$numero;
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

?>
	<style>
		#margen {		
		margin-top: 10px;
		margin-left: 20px;
		margin-rigth: 20px;
		margin-bottom: 20px;
		width: 95%;
		height: 50px;
		font-family: arial;
		}
	</style>
<div class="row">
		<div class="col-lg-4 col-sm-4 col-md-4 col-xs-4">
		<div align="center">   <img src="{{asset('dist/img/logoempresa.jpg')}}" width="60%" height="80%" title="NKS"></div>
		</div>	
		<div class="col-lg-4 col-sm-4 col-md-4 col-xs-4" style="line-height:72%">
		<p><small> Licencia para el expendio de especies ascoholicas</br>
		Codigo de Registro: MAPS-MY-C-C V-066</br>
		N° de Autorizacion: MY-066</br>
		Fecha de Autorizacion: MAYO 2022</p></small>       
	    </div>		
		<div class="col-lg-4 col-sm-4 col-md-4 col-xs-4" style="line-height:72%">
				<p><small> MF-SENIAT</br>
		GRTI-RLA AUTORIZACION N° 10</br>
		SNTA/INTI/GRTI/RLA/SV/AR/ALIC/2022/10</br>
		DE FECHA: 21/09/2022</small></p><label> 
			<?php if($venta->devolu>0){ echo "**Anulado**";} ?>
		</div>
	</div>  	
<div id="areaimprimir" >
<div id="margen">
<p id="encabezado" style="display:none"></br></br></br></p>
<div class="row">
<hr>
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
	<table width="100%" BORDER="0">
	<tr><td><small><b> </small></b><?php $idv=$venta->idforma; echo add_ceros($idv,$ceros); ?></td><td><small><b>LICENCIA NRO: </small></b>{{$venta->licencia}} </td><td><small><b>FECHA DE EMISION: </small></b><?php echo date("d-m-Y",strtotime($venta->fecha_emi)); ?></td><td><small><b>CONDICION: </small></b>Contado</td></tr>
	<tr><td colspan="4"><small><b>NOMBRE Y APELLIDO O RAZON SOCIAL: </b> </small>{{$venta->nombre}} <b>RIF: </b> {{$venta->cedula}}</td></tr>
	<tr><td colspan="4"  width="50%"><small><b>DOMICILIO FISCAL: </b> </small>{{$venta->direccion}} <b>TELF: </b> {{$venta->telefono}}</td></tr>
	</table>
	</div>
</div>
<?php $acumex=0; $acumbi=0; $acumiva=0; $costo=0; $var=0;$acumsub=0; $costofinal=0;$cntline=0;?>
       <div class ="row">                                   
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">				
                  <table width="100%" BORDER="0">
                      <tr>                    
                          <td><b>Codigo</b></td>
                          <td><b>Cap.</b></td>
                          <td><b>Gl.</b></td>
                          <td><b>Descripcion</b></td>
						  <td align="center"><b>Origen</b></td>
                          <td align="center"><b>Cantidad</b></td>
                          <td align="center"><b>Unidad.</b></td>
                          <td align="right"><b>Costo Unit.</b></td>                    
                          <td align="right"><b>Subtotal</b></td>
                      </tr>
                                         
                      <tbody>
                        @foreach($detalles as $det)
                        <tr > <?php $cntline++; ?>
						 <td>{{$det->codigo}}</td>
                          <td>{{$det->volumen}}</td>
                          <td>{{$det->grados}}</td>
                         
                          <td>{{$det->articulo}}<small><?php if($det->iva>0){
							$precio=($det->precio_venta);	
							//$precio = truncar(($precio),2);											 
							$var=(($precio)/(($det->iva/100)+1));						
							$var = truncar(($var),2);
							$iva=(($precio-$var));
							$subiva=($iva*$det->cantidad);					
							$acumiva=$acumiva+$subiva;		
							$acumiva = number_format(($acumiva),3);
							$costofinal=$precio-$iva;
							$ctobs=($costofinal*$venta->tasa);
							$costofbs=truncar(($ctobs),2);
							$subbs=($costofbs*$det->cantidad);
						    $acumbi=$acumbi+($costofbs*$det->cantidad);
						  echo "(G)"; 						
						  }else {   $precio=$det->precio_venta; 
						  	//$precio = truncar(($precio),2);								
							$ctobs=($precio*$venta->tasa);
							$costofbs=truncar(($ctobs),2);
							$subbs=($costofbs*$det->cantidad);
						  $acumex=$acumex+$subbs; echo "(E)";
							} ?></small></td>
                          <td align="center">{{$det->origen}}</td>
						  <td align="center">{{$det->cantidad}}</td>
                          <td align="center">{{$det->unidad}}</td>
                          <td align="right"><?php
						  echo number_format( ($costofbs), 2,',','.'); 
						
						  ?></td>
                          <td align="right"	><?php $acumsub=($acumsub+$subbs); echo number_format(($subbs), 2,',','.');
							$ivabs=($acumbi*0.16);
						  $ivabs = truncar(($ivabs),2);								  ?></td>
                        </tr>
                        @endforeach
						<?php for($i=$cntline;$i<16;$i++){ echo "<tr><td>&nbsp;</td></tr>"; }?>
                      </tbody> 
					  <tfoot>   
<tr><td colspan="7"></td><td align="right"><b>Subtotal Bs: </b></td><td align="right"><b><font size="3"  ><?php echo number_format(($acumsub), 2,',','.'); ?> </b></td></tr>					  				  
					</tfoot>
                  </table>
				  <table width="100%" border="0"><tr>
	<td align="right"><b>Exento Bs: </b></td><td><b><font size="3"  align="center"><?php echo number_format(($acumex), 2,',','.'); ?> </b></td>			  
	<td align="right"><b>Base Imponible Bs:  </b></td><td><b><font size="3"  align="center"><?php echo number_format(($acumbi), 2,',','.'); ?> </b></td>	
	<td align="right"><b>Iva(16%) Bs: </b></td><td><b><font size="3"  align="center"><?php echo number_format(($ivabs), 2,',','.'); ?> </b></td>
	<td  align="right"><b>Total Bs: </b></td><td align="right"><b><font size="3"  ><?php echo number_format((($ivabs+$acumbi+$acumex)), 2,',','.'); ?> </b></td>
	</tr>
<tr><td colspan="8"><small>Pedido Nro: {{$venta->pedido}}</small></td></tr>
	<tr><td colspan="8"><small>El pago total o parcial de esta Factura en Moneda distinta a la de curso legal, estará sujeto al pago de un 3% adicional por Concepto de IGTF.</small></td></tr>
	</table>
                </div>                   

     <div class="col-lg-12 col-md-12 col-sm-6 col-xs-12">

                    <div class="form-group" align="center">	</br>
					 <button type="button" id="regresar" class="btn btn-danger" data-dismiss="modal" title="Presione Alt+flecha izq. para regresar">Regresar</button>
                     <button type="button" id="imprimir" class="btn btn-primary" data-dismiss="modal" onclick="printdiv('areaimprimir');">Imprimir</button>
                    </div>
                </div>  
        </div>
	</div>

	</div>
@push ('scripts')
<script>
$(document).ready(function(){
	$('#regresar').on("click",function(){
	window.location="/ventas/ventaf"; 
	});

});	
		  function printdiv(divname){
		document.getElementById('imprimir').style.display="none";
		document.getElementById('regresar').style.display="none";
		document.getElementById('encabezado').style.display="";
	 	var printcontenido =document.getElementById(divname).innerHTML;
		var originalcontenido = document.body.innerHTML;
		document.body.innerHTML =printcontenido;
	  	window.print();
		  window.location="/ventasf/formalibre/<?php echo $venta->idventa."_0"; ?>";
	  	document.body.innerHTML=originalcontenido;
  }

</script>
@endpush
@endsection