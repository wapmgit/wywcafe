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
$cntl=0;
?>   	 

            <div  id="areaimprimir" >

              <div class="row invoice-info">
			</br>
			<div  class="col-12 table-responsive">
                  <table id="detalles" border="0" >
				  <tR><td align="center"><font size="10"><b> {{ $empresa->rif}} {{$empresa->nombre}} </b></font></td></tR>
			 <tR><td align="center"><font size="8"><b>Tel.: {{$empresa->telefono}}</b></font></td></tR>
				 <tR><td align="center"><font size="8"><b>{{$empresa->direccion}}</b></font></td></tR>
				  <tR><td align="center"><font size="8"><b>{{$venta->cedula}} -> <b>{{$venta->nombre}}</b></br>
				  {{$venta->direccion}} </br>
				  				Documento:  <b>  <?php $idv=$venta->num_comprobante; echo add_ceros($idv,$ceros); ?> </b> Fecha: <b><?php echo date("d-m-Y",strtotime($venta->fecha_emi)); ?></b></font></td></tR>
				  </table>
              </div>
			<div class="col-12 table-responsive"> 
					   <div  align="center"> <font size="8"> <b>NOTA DE ENTREGA</b></font>  <hr class="class2"></div> 
                  <table width="100%" >
                      <thead>                 
                          <th ><font size="8">Cant.</font></th>
                          <th align="center"><font size="8">Descrip.</font></th>
                          <th ><font size="8">Precio.</font></th>
                          <th ><font size="8">Subt.</font></th>
                      </thead>
                      <tfoot>  
				<?Php if($venta->descuento>0){ ?>	<tr > <td colspan="3"><div align="right"><font size="7">Descto.</font></div></td><td><div align="left"><font size="8">-{{$venta->descuento}}</font></div></tD>  </tr >	<?php } ?>				  
							  <tr >
                          <th colspan="4"> <hr class="class1"> </th>  </tr >
						  		  <tr >
                          <th colspan="4"><div align="right"><font size="8" >Total $: <?php echo number_format($venta->total_venta, 2,',','.'); ?> </font></div></th>  </tr >
                          </tfoot>
                      <tbody>
                        @foreach($detalles as $det)
						 <?php $cntl++; ?> 
                        <tr height="10px"> 
						  <td><font size="8">{{$det->cantidad}}</font></td>
                          <td><font size="7"><?php echo strtolower($det->articulo);?></font></td>                       
                          <td><font size="8"><?php echo number_format( $det->precio_venta, 2,',','.'); ?></font></td>
                          <td><font size="8"><?php echo number_format( (($det->cantidad*$det->precio_venta)), 2,',','.'); ?></font></td>
                        </tr>
                     @endforeach
                      </tbody>
                  </table>
			   </div>

		<div class="row">

			<div  class="col-lg-12 col-md-12 col-sm-12 col-xs-12" >												 
			<table  width="100%">
                      <thead>                  
                          <td><font size="6"><small>Tipo</small></font></td>
                          <td><font size="6"><small>Monto</small></font></td>
                          <td><font size="6"><small>Monto$</small></font></td>                        
                      </thead>                     
                      <tbody>                       
                        @foreach($recibos as $re) <?php  $acum=$acum+$re->monto;?>
                        <tr >
                          <td><font size="6"><small>{{$re->idbanco}}</small></font></td>
                          <td><font size="6"><small><?php echo number_format( $re->recibido, 2,',','.'); ?></small></font></td>
						  <td><font size="6"><small><?php echo number_format( $re->monto, 2,',','.'); ?></small></font></td>                       
                        </tr>
                        @endforeach
                        <tfoot >                    
                          </tfoot>
                      </tbody>
                  </table>
				  <?php for ( $i=0;$i<3;$i++){
							 echo "</br>";
							 
							 } ?> 
				  <div><P> <font size="8">Gracias por su compra..</font></p>
</div>
			
</div>

                
				
</div>  
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