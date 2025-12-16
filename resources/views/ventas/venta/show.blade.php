@extends ('layouts.admin')
@section ('contenido')
@include('ventas.venta.empresa')
<?php $acum=0; 
  $acumnc=0;
?>
<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
	<table width="100%" BORDER="1">
	<tr><td colspan="4"><small><b>NOMBRE Y APELLIDO O RAZON SOCIAL: </b> </small>{{$venta->nombre}}</td></tr>
	<tr><td colspan="2"  width="50%"><small><b>DIRECCION: </b> </small>{{$venta->direccion}}</td><td  width="25%"><small><b>TELEFONO: </b> </small> {{$venta->telefono}}</td><td  width="25%"><small><b>CONTACTO: </b> </small> {{$venta->contacto}}</td></tr>
	<tr><td><b> <small>N° RIF, N° CEDULA O PASAPORTE N°: </small> </b></br>{{$venta->cedula}}</td>
	<td> <small><b>RUTA:</b>  </small></br>{{$venta->nruta}}</td>
	<td> <b> <small>N° lICENCIA:  </small></b> </br>{{$venta->licencia}}</td><td><small>FORMA DE PAGO:</small></td>
	</tr></table>
	</div>
</div>
       <div class ="row">                                         
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					</br>
                  <table width="100%" BORDER="1">
                      <thead style="background-color: #A9D0F5">                    
                          <th>Producto</th>
                          <th><div  align="center">Cantidad</div></th>
                          <th><div  align="center">Precio</div></th>
                          <th><div  align="center">Descto. %</div></th>
                          <th><div  align="center">Precio Venta</div></th>
                          <th><div  align="center">Subtotal</div></th>
                      </thead>
                      <tfoot>                      
                          <th colspan="5">TOTAL: <small> Cuenta Anterior</small>: -><?php echo "$ ".number_format((($cxc+$notasnd)- ($notasnc+$venta->saldo)), 2,',','.'); ?> <small> factura Actual</small>: -> <?php echo " $".number_format($venta->saldo, 2,',','.'); ?> CXC:-> <?php echo "$ ".number_format((($cxc+$notasnd)- $notasnc), 2,',','.'); ?> 
						  <?php if ($vacios!=NULL){ echo "Vacios: ->".$vacios->debe; }?></th>
                          <th><div  align="center"><b><font size="4" ><?php echo "$ ".number_format($venta->total_venta, 2,',','.'); ?> </b></font></div></th>
                          </tfoot>
                      <tbody>
                        @foreach($detalles as $det)
						<?php if($det->idarticulo != 999999){ ?>
                        <tr >
                          <td>{{$det->articulo}}</td>
                          <td align="center">{{$det->cantidad}}</td>
                          <td align="center">{{$det->precio}}</td>
                          <td align="center">{{$det->descuento}}</td>
                          <td align="center"><?php echo number_format( $det->precio_venta, 2,',','.'); ?></td>
                          <td align="center"><?php echo number_format( (($det->cantidad*$det->precio_venta)), 2,',','.'); ?></td>
                        </tr>
						<?php  } ?>
                        @endforeach
						@foreach($detalles as $det)
						<?php if($det->idarticulo == 999999){ ?>
                        <tr >
                          <td>{{$det->articulo}}</td>
                          <td align="center">{{$det->cantidad}}</td>
                          <td align="center">{{$det->precio}}</td>
                          <td align="center">{{$det->descuento}}</td>
                          <td align="center"><?php echo number_format( $det->precio_venta, 2,',','.'); ?></td>
                          <td align="center"><?php echo number_format( (($det->cantidad*$det->precio_venta)), 2,',','.'); ?></td>
                        </tr>
						<?php  } ?>
                        @endforeach
                      </tbody>
                  </table>
                </div>                   
      <?php if (count($recibos)>0) {?>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6"><h5 align="center"><b>Desglose de pago</b></h5>
                  <table width="100%">
                      <thead style="background-color: #A9D0F5">                   
                          <th>Tipo</th>
                          <th>Monto</th>
						  <th>Tasa</th>
                          <th>Monto$</th>
                          <th>Ref.</th>                          
                      </thead>                    
                      <tbody>                        
                        @foreach($recibos as $re) <?php  $acum=$acum+$re->monto;?>
                        <tr >
                          <td>{{$re->idbanco}}</td>
                          <td><?php echo number_format( $re->recibido, 2,',','.'); ?></td>
						      <td> <?php if ($re->idpago==2){echo number_format( $re->tasap, 2,',','.'); }
							  if ($re->idpago==3){echo number_format( $re->tasab, 2,',','.'); }?></td>
						   <td><?php echo number_format( $re->monto, 2,',','.'); ?></td>
                          <td>{{$re->referencia}} <?php echo date("d-m-Y",strtotime($re->fecha)); ?></td>                        
                        </tr>
                        @endforeach
                        <tfoot >                    
                          <th colspan="3">Total</th>
						  <th><?php echo "$ ".number_format( $acum, 2,',','.');?></th>
                          <th ><h4 id="total"><b></b></h4></th>
                          </tfoot>
                      </tbody>
                  </table>
                </div>
		<?php } ?>
		      <?php if (count($recibonc)>0) {?>
                 <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6"><h5 align="center"><b>Nota de Credito Aplicada</b></h5>
                  <table width="100%">
                      <thead style="background-color: #A9D0F5">
                     
                          <th>Fecha</th> 
						  <th>Referencia</th>
                          <th>Monto</th>
						 
                      </thead>
                     
                      <tbody>
                        
                        @foreach($recibonc as $renc) <?php  $acumnc=$acumnc+$renc->monto;?>
                        <tr >
                          <td>{{$renc->fecha}}</td>
                          <td>{{$renc->referencia}}</td> 
						  <td><?php echo number_format( $renc->monto, 2,',','.'); ?></td>						  
                        </tr>
                        @endforeach
                        <tfoot >                    
                          <th colspan="2">Total</th>
						  <th><?php echo "$ ".number_format( $acumnc, 2,',','.');?></th>
                          <th ><h4 id="total"><b></b></h4></th>
                          </tfoot>
                      </tbody>
                  </table></br>
                </div>
	<?php } ?>

     <div class="col-lg-12 col-md-12 col-sm-6 col-xs-12">
	                  
                  <table width="100%">
                      <thead>                   
                          <th>{{$empresa->ctapagos}}				 
                      </thead>
					  <tr><td><?php if($venta->recargo==1){?><small><b>Nota:</b> La presente Nota tiene <?php echo ($venta->diascre-2); ?> dias como plazo de Credito. Al superar este lapso sin totalizar el pago, se aplicara un Recargo del 3% sobre el monto total Facturado.</small><?php } ?></td></tr>                  </table></br>

                    <div class="form-group" align="center">	</br>
					 <button type="button" id="regresar" class="btn btn-danger" data-dismiss="modal" title="Presione Alt+flecha izq. para regresar">Regresar</button>
                     <button type="button" id="imprimir" class="btn btn-primary" data-dismiss="modal">Imprimir</button>
                    </div>
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
  window.location="/ventas/venta";
    });
$('#regresar').on("click",function(){
  window.location="/ventas/venta";
  
});
});
</script>
@endpush
@endsection