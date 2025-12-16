@extends ('layouts.admin')
@section ('contenido')
 @include('compras.ingreso.empresa')
	
	<h3 align="center"> INGRESOS POR COMPRAS</h3>
		<?php if ($ingreso->estatus=="Anulada"){?><h3 align="center">* ANULADA * </h3><?php } ?>
  <hr/>
		       <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">

                    <div class="form-group">
                    	<label for="proveedor">Rif -> Proveedor</label>
                   <p>{{$ingreso->rif}} -> {{$ingreso->nombre}}</p>
                    </div>
                </div>
          <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                    <div class="form-group">
                      <label for="proveedor">Direccion</label>
                   <p>{{$ingreso->direccion}}</p>
                    </div>
                </div>
				  <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                    <div class="form-group">
                      <label for="proveedor">Telefono</label>
                   <p>{{$ingreso->telefono}}</p>
                    </div>
                </div>
                
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                <div class="form-group">
                	<label for="tipo_comprobante">Tipo comprobante</label>
                     <p>{{$ingreso->tipo_comprobante}}</p>
                </div>
            </div>
             <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                <div class="form-group">
                    <label for="serie_comprobante">Serie Comprobante</label>
                    <p >{{$ingreso->serie_comprobante}}</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                <div class="form-group">
                    <label for="num_comprobante">Numero comprobante</label>
                    <p>{{$ingreso->num_comprobante}}</p>
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
                          <th>Precio Compra</th>
                          <th>Descuento</th>
                          <th>Neto</th>
                          <th>Subtotal</th>
                      </thead>
                          <?php  $mo=0; $abono=0;  $acum=0;?>
                      <tbody>
                        @foreach($detalles as $det)
                        <?php  $mo=$mo+($det->subtotal); ?>
                        <tr >
                          <td>{{$det->articulo}}</td>
                          <td>{{$det->cantidad}}</td>
                          <td><?php echo number_format( $det->precio_compra, 2,',','.'); ?></td>
                          <td><?php echo number_format( $det->precio_venta, 2,',','.'); ?></td>
                           <td><?php echo number_format( $det->cantidad*$det->precio_compra, 2,',','.'); ?></td>
                          <td><?php echo number_format( $det->subtotal, 2,',','.'); ?></td>
                        </tr>
                        @endforeach
                      </tbody> 
                      <tfoot > 
                     
                          <th colspan="5">Total:</th>
                          <th ><h4 id="total"><b> <?php  echo number_format( $mo, 2,',','.'); ?> $</b></h4></th>
                          </tfoot>
                  </table>
                  <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <label >Base Imponible: </label>  <?php echo number_format( $ingreso->base, 2,',','.'); ?>
                    </div>
                     <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <label >Iva: </label>  <?php echo number_format( $ingreso->miva, 2,',','.'); ?>
                    </div>
                     <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <label >Exento: </label>  <?php echo number_format( $ingreso->exento, 2,',','.'); ?>
                    </div>
                    </div>

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
                     @foreach($pago as $re) <?php  $acum=$acum+$re->monto;?>
                        <tr >
                          <td>{{$re->idbanco}}</td>
                          <td><?php echo number_format( $re->recibido, 2,',','.'); ?></td>
						      <td> <?php if ($re->idpago==2){echo number_format( $re->tasap, 2,',','.'); }
							  if ($re->idpago==3){echo number_format( $re->tasab, 2,',','.'); }?></td>
						   <td><?php echo number_format( $re->monto, 2,',','.'); ?></td>
                          <td>{{$re->referencia}} <?php echo date("d-m-Y",strtotime($re->fecha_comp)); ?></td>                        
                        </tr>
                        @endforeach
                        <tfoot>                    
                          <th colspan="3">Total</th>
						  <th><?php echo number_format( $acum, 2,',','.');?> $</th>
                          <th ><b> Pendiente: <?php echo number_format( ($ingreso->total-$acum), 2,',','.');?></b></h4></th>
                          </tfoot>
                       
                      </tbody>
                  </table>
                    </div>
					          <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6"><h4 align="center">N/C Aplicadas</h4>
                  <table id="desglose" class="table table-striped table-bordered table-condensed table-hover">
                      <thead style="background-color: #A9D0F5">
                          <th>Monto$</th>
                          <th>Referencia</th>
                          <th>Fecha</th>
                          
                      </thead>
              
                      <tbody>
                     @foreach($recibonc as $rec) <?php  $acum=$acum+$rec->monto;?>
                        <tr >
						   <td><?php echo number_format( $rec->monto, 2,',','.'); ?></td>
                          <td>{{$rec->referencia}} </td>
						  <td><?php echo date("d-m-Y",strtotime($rec->fecha)); ?></td>                        
                        </tr>
                        @endforeach
                        <tfoot>                    
                          <th colspan="2">Total</th>
						  <th><?php echo number_format( $acum, 2,',','.');?> $</th>
                         
                          </tfoot>
                       
                      </tbody>
                  </table>
                    </div>
                </div></div></div>
				<a ><button class="btn  pull-right" id="imprimir">Imprimir</button></a>
          <a href="{{URL::action('CxpagarController@show',$ingreso->idproveedor)}}" id="regresar"><button class="btn  pull-left" >Regresar</button></a> 
             <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="form-group">
                    <label for="num_comprobante">Fecha:</label>
                    <p>{{$ingreso->fecha_hora}}</p>
                </div>
            </div> 
			
         @push ('scripts')
<script>
$(document).ready(function(){
    $('#imprimir').click(function(){
  //  alert ('si');
  document.getElementById('imprimir').style.display="none";
  window.print(); 
  window.location="{{URL::action('CxpagarController@show',$ingreso->idproveedor)}}";
    });

});

</script>

@endpush
@endsection