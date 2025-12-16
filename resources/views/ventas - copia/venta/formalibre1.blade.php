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
			<?php if($venta->devolu>0){ echo "**Devuelta**";} ?>
		</div>
	</div>  	
<div id="areaimprimir" >
<div id="margen">
<p id="encabezado" style="display:none"></br></br></br></p>
<div class="row">
<hr>
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
	<table width="100%" BORDER="0">
	<tr><td><small><b>FACTURA N° : </small></b><?php $idv=$venta->idforma; echo add_ceros($idv,$ceros); ?></td><td><small><b>LICENCIA: </small></b>{{$venta->licencia}} </td><td><small><b>FECHA DE EMISION: </small></b><?php echo date("d-m-Y",strtotime($venta->fecha_emi)); ?></td><td><small><b>CONDICION: </small></b>Contado</td></tr>
	<tr><td colspan="4"><small><b>NOMBRE Y APELLIDO O RAZON SOCIAL: </b> </small>{{$venta->nombre}} <b>RIF: </b> {{$venta->cedula}}</td></tr>
	<tr><td colspan="4"  width="50%"><small><b>DOMICILIO FISCAL: </b> </small>{{$venta->direccion}} <b>TELF: </b> {{$venta->telefono}}</td></tr>
	</table>
	</div>
</div>
<?php $acumex=0; $acumbi=0; $acumiva=0; $costo=0;$var=0; $acumsub=0; $cntline=0;?>
       <div class ="row">                                   
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					</br>
                  <table width="100%" BORDER="0">
                      <thead >                    
                          <th>Codigo</th>
                          <th>Descripcion</th>
                          <th>Cantidad</th>
                          <th>Unidad.</th>
                          <th>Costo Unit.</th>                    
                          <th>Subtotal</th>
                      </thead>
                     
                      <tbody>
                        @foreach($detalles as $det)
                        <tr > <?php $cntline++; ?>
                          <td>{{$det->codigo}}</td>
                          <td>{{$det->articulo}}<small><?php if($det->iva>0){
							$costo=($det->costo*1.01);	
							$costo = number_format(($costo),2);								
						  $acumbi=$acumbi+($costo*$det->cantidad);
						$var=(($costo*$det->cantidad)-(($costo*$det->cantidad)/(($det->iva/100)+1)));
						 $var = number_format(($var),2);
						  $acumiva=$acumiva+$var;
						   $acumiva = number_format(($acumiva),2);
						  echo "(G)"; 						
						  }else {   $costo=$det->precio_venta; $acumex=$acumex+$det->precio_venta; echo "(E)"; } ?></small></td>
                          <td>{{$det->cantidad}}</td>
                          <td>{{$det->unidad}}</td>
                          <td><?php echo number_format( ($costo*$venta->tasa), 2,',','.'); ?></td>
                          <td><?php $acumsub=$acumsub+(($det->cantidad*$costo)-$det->descuento); echo number_format( ((($det->cantidad*$costo)-$det->descuento)*$venta->tasa), 2,',','.'); ?></td>
                        </tr>
                        @endforeach
						<?php for($i=$cntline;$i<10;$i++){ echo "<tr><td>&nbsp;</td></tr>"; }?>
                      </tbody> 
					  <tfoot>   
<tr><td colspan="4" align="center"></td><td><b>Subtotal Bs: </b></td><td><b><font size="3"  align="center"><?php echo number_format(($acumsub*$venta->tasa), 2,',','.'); ?> </b></td></tr>					  				  
					</tfoot>
                  </table>
				  <table width="100%"><tr>
	<td align="right"><b>Exento Bs: </b></td><td><b><font size="3"  align="center"><?php echo number_format(($acumex*$venta->tasa), 2,',','.'); ?> </b></td>			  
	<td align="right"><b>Base Imponible Bs:  </b></td><td><b><font size="3"  align="center"><?php echo number_format(($acumbi*$venta->tasa), 2,',','.'); ?> </b></td>	
	<td align="right"><b>Iva(16%) Bs: </b></td><td><b><font size="3"  align="center"><?php echo number_format(($acumiva*$venta->tasa), 2,',','.'); ?> </b></td>
	<td  align="right"><b>Total Bs: </b></td><td><b><font size="3"  align="center"><?php echo number_format((($acumiva+$acumbi+$acumex)*$venta->tasa), 2,',','.'); ?> </b></td>
	</tr>
	<tr><td colspan="4"><small>Relacionado con Pedido: {{$venta->idventa}}</small></td></tr>
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
	window.location="/ventas/venta"; 
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
		  window.location="/ventas/formalibre/<?php echo $venta->idventa."_1"; ?>";
	  	document.body.innerHTML=originalcontenido;
  }

</script>
@endpush
@endsection