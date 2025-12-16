@extends ('layouts.admin')
@section ('contenido')
@include('compras.ajuste.empresa')
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
?>	<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
	<h3 align="center"> AJUSTE DE INVENTARIO # <?php echo add_ceros($ajuste-> numajuste,$ceros); ?></h3>
	</div>
	</div>
  <hr/>
		       <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">

                    <div class="form-group">
                    	<label for="concepto">Concepto: </label> {{$ajuste->concepto}} <b>Responsable: </b> {{$ajuste->responsable}}
                    </div>
                </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <div class="form-group">
                	<label for="monto">Monto: </label> <?php echo number_format( $ajuste->monto, 2,',','.'); ?><b> Fecha: </b> <?php echo date("d-m-Y h:i:s a",strtotime($ajuste->fecha_hora)); ?>
                     <p></p>
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
                          <th>Tipo</th>
                          <th>Costo</th>
                          <th>Valorizado</th>
                      </thead>
                     
                      
                        @foreach($detalles as $det)
                        <tr >
                          <td>{{$det->articulo}}</td>
                          <td>{{$det->cantidad}}</td>
                          <td>{{$det->tipo_ajuste}}</td>
                          <td><?php echo number_format( $det->costo, 2,',','.'); ?></td>
                          <td><?php echo number_format( ($det->cantidad*$det->costo), 2,',','.'); ?></td>
                        </tr>
                        @endforeach
                      </tbody> <tfoot> 
                     
                          <th colspan="4">TOTAL:</th>
                          <th ><h4 id="total"><b><?php echo number_format( $ajuste->monto, 2,',','.')." $"; ?> </b></h4></th>
                          </tfoot>
                  </table>
                    </div>

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
  document.getElementById('regresar').style.display="none";
  window.print(); 
  window.location="/compras/ajuste";
    });
$('#regresar').on("click",function(){
  window.location="/compras/ajuste";
  
});
});
</script>
@endpush
@endsection