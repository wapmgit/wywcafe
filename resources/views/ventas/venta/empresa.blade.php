<?php  
$ceros=5; 
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
<div class="row">
		<div class="col-lg-4 col-sm-4 col-md-4 col-xs-4">
		<div align="center">   <img src="{{ asset('dist/img/'.$empresa->logo)}}" width="60%" height="80%" title="NKS"></div>
		</div>	
		<div class="col-lg-4 col-sm-4 col-md-4 col-xs-4" style="line-height:72%">
		<p><small> xxxxxxx</br>
		xxxxxxx</br>
		xxxxxx</br>
		xxxxx</p>
		</small>FECHA DESPACHO: <?php echo date("d-m-Y",strtotime($venta->fecha_emi)); ?>  </br>      
		<small>Vendedor: {{$venta->vendedor}}  </small>      
	    </div>		
		<div class="col-lg-4 col-sm-4 col-md-4 col-xs-4" style="line-height:72%">
				<p><small> xxxxxx</br>
		xxxxxxxx</br>
		xxxxxxxx</br>
		DE FECHA: 21/09/2022</small></p><label><strong>NOTA DE ENTREGA N° <font size="3"><?php echo add_ceros($venta->num_comprobante,$ceros); ?></font></strong></label> 
			<?php if($venta->devolu>0){ echo "**Devuelta**";} ?>
		</div>
	</div>  