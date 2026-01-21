@extends ('layouts.admin')
@section ('contenido')
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
		<p><small> {{$empresa->nombre}}</br>
			{{$empresa->rif}}</br>
				{{$empresa->telefono}}</br>
		{{$empresa->direccion}}</p>
		</small>fecha Traslado: <?php echo date("d-m-Y",strtotime($venta->fecha)); ?>  </br>      		  
	    </div>		
		<div class="col-lg-4 col-sm-4 col-md-4 col-xs-4" style="line-height:72%">
			<label><strong>TRASLADO DE INVENTARIO # <font size="3"><?php echo add_ceros($venta->idtraslado,$ceros); ?></font></strong></label> 
		</div>
	</div>  

			<div class="row"></br>
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
	<table width="100%" BORDER="1">
	<tr><td colspan="2"><small><b>Concepto: </b> </small>{{$venta->concepto}}</td>
	<td colspan="2"><small><b>Responsable: </b> </small>{{$venta->concepto}}</td>
	<td><small><b>Fecha: </b> </small><?php echo date("d-m-Y h:i:s a",strtotime($venta->fecha)); ?></td></tr>
	
	<tr><td colspan="2"><b> <small>Dep. Origen: </small> </b>{{$venta->origen}}</td>
	<td colspan="2"> <small><b>Dep. Destino:</b>  </small></br>{{$venta->destino}}</td>
	<td> <b> <small>Monto de Traslado:  </small></b> </br>{{$venta->total_traslado}}</td>
	</tr></table>
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
                          <th>precio</th>
						  <th>SubTotal</th>
                      </thead>
                      <tfoot bgcolor="#A9D0F5">                     
                          <th colspan="3">TOTAL:</th>
                          <th ><h4 id="total"><b><?php echo number_format($venta->total_traslado, 2,',','.'); ?> $</b></h4></th>
                          </tfoot>
                      <tbody>
                        @foreach($detalles as $det)
                        <tr >
                          <td>{{$det->articulo}}</td>
                          <td>{{$det->cantidad}}</td>
                          <td><?php echo number_format( $det->precio, 2,',','.'); ?></td>
                          <td><?php echo number_format( ($det->cantidad*$det->precio), 2,',','.'); ?></td>
                        </tr>
                        @endforeach
                      </tbody>
                  </table>
                    </div>
 
                </div>
                    
                </div>
             <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="form-group">
                    <label for="num_comprobante">Usuario:</label>
                    <p>{{$venta->user}}</p>
                </div>
            </div> 
     <div class="col-lg-12 col-md-12 col-sm-6 col-xs-12">
                    <div class="form-group" align="center">
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
  window.print(); 
  window.location="/deposito/traslado";
    });
$('#regresar').on("click",function(){
  window.location="/deposito/traslado";
  
});
});

</script>

@endpush
@endsection