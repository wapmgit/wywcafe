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


<div id="areaimprimir" class="col-lg-3 col-md-3 col-sm-3 col-xs-3" >
			<div style="line-height:70%" width="90%">
			<label><small><small><b>{{$empresa->nombre}}</b></small></small></br>
			<small><small>{{$empresa->rif}}</small></small></br>
			<small><small><small>{{$empresa->direccion}}</small></small></small></br>
			<small><small>Telf:{{$empresa->telefono}}</small></small></br>
					 
			<small><small> <small>  {{$venta->cedula}} -> {{$venta->nombre}}</br>
				{{$venta->direccion}}</small></small></small> </br>
			<small><small>	Documento:  <?php $idv=$venta->num_comprobante; echo add_ceros($idv,$ceros); ?></small></small> </label>  
			</div>    
                  <table style="line-height:60%" id="detalles" border="0" width="95%">
                      <thead>                 
                          <th width="5%"><font size="1"><small>Cant.</small></font></th>
                          <th width="60%" align="center"><small><small>Descrip.</small></small></th>
                          <th width="15%"><font size="1"><small><small>Precio</small></small></font></th>
                          <th width="15%"><font size="1"><small><small>Subt.</small></small></font></th>
                      </thead>
                      <tfoot>                      
                          <th colspan="2" align="center"><small><small>Bs: <?php echo number_format(($venta->total_venta*$empresa->tc), 2,',','.'); ?> </small></small></th>
                          <th colspan="2" align="center"><small><small>$: <?php echo number_format($venta->total_venta, 2,',','.'); ?> </small></small></th>
                          </tfoot>
                      <tbody>
                        @foreach($detalles as $det)
                        <tr height="10px"> 
						  <td><font size="1"><small><small>{{$det->cantidad}}</small></small></font></td>
                          <td><font size="1"><small><small><small><?php echo strtolower($det->articulo);?></small></small></small></font></td>                       
                          <td><font size="1"><small><small><?php echo number_format( $det->precio_venta, 2,',','.'); ?></small></small></font></td>
                          <td><font size="1"><small><small><?php echo number_format( (($det->cantidad*$det->precio_venta)-$det->descuento), 2,',','.'); ?></small></small></font></td>
                        </tr>
                        @endforeach
                      </tbody>
                  </table>
                  <table id="desglose" style="line-height:80%" border="0"  width="100%">
                      <thead>                  
                          <td><font size="1"><small>Tipo</small></font></td>
                          <td><font size="1"><small>Monto</small></font></td>
                          <td><font size="1"><small>Monto$</small></font></td>                        
                      </thead>                     
                      <tbody>                       
                        @foreach($recibos as $re) <?php  $acum=$acum+$re->monto;?>
                        <tr >
                          <td><font size="1"><small>{{$re->idbanco}}</small></font></td>
                          <td><font size="1"><small><?php echo number_format( $re->recibido, 2,',','.'); ?></small></font></td>
						  <td><font size="1"><small><?php echo number_format( $re->monto, 2,',','.'); ?></small></font></td>                       
                        </tr>
                        @endforeach
                        <tfoot >                    
                          </tfoot>
                      </tbody>
                  </table>
           
                <div ><small><font size="1">
                    <p><?php echo date("d-m-Y h:i:s a",strtotime($venta->fecha_emi)); ?></p></font></small>
                </div>
</div>
     <div class="col-lg-12 col-md-12 col-sm-6 col-xs-12">
                    <div class="form-group" align="center">
					 <button type="button" id="regresar" class="btn btn-danger" data-dismiss="modal">Regresar</button>
                     <button type="button" id="imprimir" class="btn btn-primary" onclick="printdiv('areaimprimir');" >Imprimir</button>
                    </div>
                </div>  
			
@push ('scripts')
<script>
$(document).ready(function(){

});
  function printdiv(divname){
		document.getElementById('imprimir').style.display="none";
		document.getElementById('regresar').style.display="none";
	 	var printcontenido =document.getElementById(divname).innerHTML;
		var originalcontenido = document.body.innerHTML;
		document.body.innerHTML =printcontenido;
	  	window.print();
	  	window.location="/ventas/venta/create";
	  	document.body.innerHTML=originalcontenido;
  }
  $('#regresar').on("click",function(){
  window.location="/ventas/venta/create";
  
});

</script>
@endpush
@endsection