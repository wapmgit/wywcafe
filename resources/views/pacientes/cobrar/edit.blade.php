@extends ('layouts.admin')
@section ('contenido')
 @include('pacientes.cobrar.modalfecha')	
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
		<div align="center">   <img src="{{asset('dist/img/logoempresa.jpg')}}" width="60%" height="80%" title="NKS"></div>
		</div>	
		<div class="col-lg-4 col-sm-4 col-md-4 col-xs-4" style="line-height:72%">
		<p><small> xxx</br>
		xxxxxxxxx</br>
		xxxxxxx</br>
	xxxxxxxxx</p>
		</small>FECHA DESPACHO:  <a href="" data-target="#modalfecha" data-toggle="modal">
		<?php echo date("d-m-Y",strtotime($venta->fecha_emi)); ?></a>	  </br>      
		<small>Vendedor: {{$venta->vendedor}} </small>      
	    </div>		
		<div class="col-lg-4 col-sm-4 col-md-4 col-xs-4" style="line-height:72%">
				<p><small> xxxxxx</br>
		xxxxxx</br>
		xxxxxxxxxxxxxxxx</br>
		DE FECHA: 21/09/2022</small></p><label><strong>NOTA DE ENTREGA N° <font size="3"><?php echo add_ceros($venta->num_comprobante,$ceros); ?></font></strong></label> 
			<?php if($venta->devolu>0){ echo "**Devuelta**";} ?>
		</div>
	</div>  <?php $acum=0;?>

           <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <div class="form-group">
                      <label for="cliente">Cliente </label>
                   <p>{{$venta->nombre}}</p>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <div class="form-group">
                      <label for="direccion">Direccion</label>
                   <p>{{$venta->direccion}}</p>
                    </div>
                </div>
                
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                <div class="form-group">
                  <label for="tipo_comprobante">Tipo comprobante</label>
                     <p>{{$venta->tipo_comprobante}}</p>
                </div>
            </div>
             <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                <div class="form-group">
                    <label for="serie_comprobante">serie comprobante</label>
                    <p>{{$venta->serie_comprobante}}</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                <div class="form-group">
                    <label for="num_comprobante">Numero comprobante</label>
                    <p><?php echo add_ceros($venta->num_comprobante,$ceros); ?></p>
                </div>
            </div>
            </div>
            <div clas ="row">
                <div class="panel panel-primary">
                <div class="panel-body">
                    
                  
                    
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <table id="detalles" class="table table-striped table-bordered table-condensed table-hover">
                      <thead style="background-color: #A9D0F5">
                     
                          <th>Articulo</th>
                          <th>Cantidad</th>
                          <th>Descuento</th>
                          <th>precio venta</th>                        
                          <th>subtotal</th> 
                          <th>precio actual</th>
                            <th>subtotal Actual</th> 
                      </thead>
                  <?php $acumn=$np=0; $acumnc=0; ?>
                      <tbody>
                        @foreach($detalles as $det)
                        <tr >
                          <td>{{$det->articulo}}</td>
                          <td>{{$det->cantidad}}</td>
                          <td>{{$det->descuento}}</td>
                          <td><?php echo number_format( $det->precio_venta, 2,',','.'); ?></td>
                          <td><?php echo number_format( ($det->cantidad*$det->precio_venta), 2,',','.'); ?></td> <td> @foreach($articulos as $nprecio)<?php if ($det->idarticulo==$nprecio->idarticulo) { $np=$nprecio->precio1; echo number_format( $nprecio->precio1, 2,',','.'); }?>        
                              @endforeach </td>
                               <td><?php $acumn=($acumn+($det->cantidad*$np)); echo number_format( ($det->cantidad*$np), 2,',','.'); ?></td>
                        </tr>
                        @endforeach
                            <tfoot> 
                     
                          <th colspan="4">TOTAL:</th>
                          <th ><h4 id="total"><b><?php echo number_format($venta->total_venta, 2,',','.'); ?> $</b></h4></th>
                          <th></th>
                          <th ><h4><b><?php echo number_format($acumn, 2,',','.'); ?> $</b></h4></th>
                          </tfoot>
                      </tbody>					
                  </table>
                    </div>
 
                </div>
                    
                </div>
                 <div clas ="row">
                <div class="panel panel-primary">
                <div class="panel-body">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6"><h4 align="center">Desglose de pago</h4>
                  <table id="desglose" class="table table-striped table-bordered table-condensed table-hover">
                      <thead style="background-color: #A9D0F5">
						<th>Tipo</th>
                          <th>Monto</th>
						  <th>Tasa</th>
                          <th>Monto$</th>
                          <th>Referencia</th>
                          
                      </thead>
              
                      <tbody>
                     @foreach($abonos as $re) <?php  $acum=$acum+$re->monto;?>
                        <tr >
                          <td>{{$re->idbanco}}</td>
                          <td><?php echo number_format( $re->recibido, 2,',','.'); ?></td>
						      <td> <?php if ($re->idpago==2){echo number_format( $re->tasap, 2,',','.'); }
							  if ($re->idpago==3){echo number_format( $re->tasab, 2,',','.'); }?></td>
						   <td><?php echo number_format( $re->monto, 2,',','.'); ?></td>
                          <td>{{$re->referencia}}</td>                        
                        </tr>
                        @endforeach
                        <tfoot><?php if($venta->mret>0){?>
						<tR><td colspan="5"> <?php echo "Retencion en Venta: ".number_format($venta->mret, 2,',','.'); ?> $</td></tR>						<?php } ?>
                          <th colspan="3">Total</th>
						  <th><?php echo number_format( ($acum+$venta->mret), 2,',','.');?> $</th>
                          <th ><b> Pendiente: <?php echo number_format( ($venta->total_venta-($acum+$venta->mret)), 2,',','.');?></b></h4></th>
                          </tfoot>
                       
                      </tbody>
                  </table>
                    </div>
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
                </div></div></div>
             <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="form-group">
                    <label for="num_comprobante">Fecha:</label>
                    <p><?php echo date("d-m-Y h:i:s a",strtotime($venta->fecha_hora)); ?></p>
                </div>
            </div> 
     <div class="col-lg-12 col-md-12 col-sm-6 col-xs-12">
                    <div class="form-group" align="center">  
					<?php if ($link==1){?>
                      <a href="{{URL::action('PacientesController@show',$venta->id_cliente)}}"><button class="btn btn-info">Regresar</button></a>
					<?php } else {?>                     
					<a href="{{URL::action('CxcobrarController@show',$venta->id_cliente)}}"><button class="btn btn-info">Regresar</button></a>
					<?Php } ?>
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
  window.print(); 
  window.location="/ventas/venta";
    });

});

</script>

@endpush
@endsection