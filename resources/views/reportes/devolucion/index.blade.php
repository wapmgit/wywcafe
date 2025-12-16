@extends ('layouts.admin')
@section ('contenido')
@include('almacen.articulo.empresa')
<?php $acum=0; ?>
    <h3 align="center"> DEVOLUCION EN VENTAS</h3>
    {!!Form::open(array('url'=>'reportes/devolucion','method'=>'POST','autocomplete'=>'off'))!!}
            {{Form::token()}}
               <div class="row">
               <input type="hidden" name="idventa" value="{{$venta->idventa}}"><input type="hidden" name="comprobante" value="{{$venta->num_comprobante}}">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <div class="form-group">
                        <label for="cliente">Cliente</label>
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
                    <label for="serie_comprobante">Serie comprobante</label>
                    <p>{{$venta->serie_comprobante}}</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                <div class="form-group">
                    <label for="num_comprobante">Numero comprobante</label>
                    <p>{{$venta->num_comprobante}}</p>
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
                          <th>Precio venta</th>
                          <th>Subtotal</th>
                      </thead>
                      <tfoot> 
                     
                          <th colspan="4">TOTAL:</th>
                          <th ><h4 id="total"><b><?php echo "$ ".number_format($venta->total_venta, 2,',','.'); ?> </b></h4></th>
                          </tfoot>
                      <tbody>
                        @foreach($detalles as $det)
                        <tr >
                          <td><input type="hidden" name="idarticulo[]" value="{{$det->idarticulo}}">{{$det->articulo}}</td>
                          <td><?php 
						    if(($det->cantidad>0)and ($venta->devolu==0) and ($venta->saldo>0)){
						  ?>
						  <button type="button" onclick="javascript:abrirdiv({{$det->idarticulo}},{{$det->iddetalle_venta}},{{$det->precio_venta}},{{$det->cantidad}},'{{$det->articulo}}');">  <a href="" data-target="#modaldevolucion" data-toggle="modal">{{$det->cantidad}}</a></button>
						  <?php } else { echo $det->cantidad;} ?> 
						  <input type="hidden" name="cantidad[]" value="{{$det->cantidad}}"></td>
                          <td><input type="hidden" name="descuento[]" value="{{$det->descuento}}">{{$det->descuento}}</td>
                          <td><input type="hidden" name="precio_venta[]" value="{{$det->precio_venta}}"><?php echo number_format( $det->precio_venta, 2,',','.'); ?></td>
                          <td><?php echo number_format( ($det->cantidad*$det->precio_venta), 2,',','.'); ?></td>
                        </tr>

                        @endforeach
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
                   @foreach($recibo as $re) <?php  $acum=$acum+$re->monto;?>
                        <tr >
                          <td>{{$re->idbanco}}</td>
                          <td><?php echo number_format( $re->recibido, 2,',','.'); ?></td>
						      <td> <?php if ($re->idpago==2){echo number_format( $re->tasap, 2,',','.'); }
							  if ($re->idpago==3){echo number_format( $re->tasab, 2,',','.'); }?></td>
						   <td><?php echo number_format( $re->monto, 2,',','.'); ?></td>
                          <td>{{$re->referencia}}</td>                        
                        </tr>
                        @endforeach
                   
                       
                      </tbody>
							<tfoot >                    
                          <th colspan="3">Total</th>
						  <th><?php echo "$ ".number_format( $acum, 2,',','.');?></th>
                          <th ></th>
						 <?php if($acum>0){?> <tr><td colspan="2">¿Generar N/C Por Devolucion?
						 <input type="checkbox"  name="nc" />
						 <input type="hidden"  name="monnc" value="<?php echo $acum; ?>" />

						 </td></tr>
						 <?php } ?>
						</tfoot>
                  </table>
                    </div>
							 <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6"><h4 align="center">N/C Aplicada</h4>
                  <table id="desglose" class="table table-striped table-bordered table-condensed table-hover">
                      <thead style="background-color: #A9D0F5">                     
                          <th>Monto$</th>
                          <th>Referencia</th>                         
                      </thead>
                    
                      <tbody>
                   @foreach($recibonc as $ren)
                        <tr >                   
                          <td><?php echo number_format( $ren->monto, 2,',','.'); ?></td>
                          <td>{{$ren->referencia}}</td>                        
                        </tr>
                        @endforeach                                         
                      </tbody>
                  </table>
                </div>
                </div></div></div>
             <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="form-group">
                    <label for="num_comprobante">Fecha:</label>
                    <p><?php echo date("d-m-Y h:i:s a",strtotime($venta->fecha_hora)); ?></p>
                </div>
            </div> 
     
        </div>
        <div class="modal-footer">
<div class="col-lg-12 ol-md-12 col-sm-12 col-xs-12">
       <a href="/ventas/venta"> <button type="button" class="btn btn-danger" id="regresar" data-dismiss="modal" title="Presione Alt+flecha izq. para regresar">Cancelar</button></a>
        <input name="_token" value="{{ csrf_token() }}" type="hidden" ></input>
        <button type="submit" id="procesa" class="btn btn-primary">Procesar</button>
      
        </div>
      </div>
        
     
			{!!Form::close()!!}	
@include('reportes.devolucion.modaldevolucion')
@push ('scripts')
<script> 
$(document).ready(function(){			

})
function abrirdiv(ida,iddet,precio,cnt,na){
//alert(na);
$("#idarticulo").val(ida);
$("#iddetalle").val(iddet);
$("#idprecio").val(precio);
$("#idcantidad").val(cnt);
$("#art").text(na);
}
	</script>
@endpush
@endsection