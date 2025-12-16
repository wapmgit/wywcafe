@extends ('layouts.admin')
@section ('contenido')
<?php 
$acum=0; $acumc=0;
$ceros=5;
function add_ceros($numero,$ceros) {
  $numero=$numero+1;
$digitos=strlen($numero);
  $recibo=" ";
  for ($i=0;$i<8-$digitos;$i++){
    $recibo=$recibo."0";
  }
return $insertar_ceros = $recibo.$numero;
};
?>
@include('gastos.gasto.empresa')  
			<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
	<h3 align="center"> GASTO # <?php echo add_ceros($gasto-> numgasto,$ceros); ?></h3><label ><?php if($gasto->estatus==1){ echo " * Anulado *"; } ?></label>
  </div>
</div><hr/>
		       <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <div class="form-group">
                    	<label for="concepto">Razon: </label> {{$gasto->nombre}} {{$gasto->rif}}
                    </div>
                </div>
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <div class="form-group">
                    	<label for="concepto">Direccion: </label> {{$gasto->direccion}} <b>Telefono: </b> {{$gasto->telefono}}
                    </div>
                </div>
          
            </div>
		 <div clas ="row">
                <div class="panel panel-primary">
                <div class="panel-body">
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                    <div class="form-group">
                    	<label for="concepto">Documento: </label> {{$gasto->documento}}
                    </div>
                </div>
				          <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                <div class="form-group">
                	<label for="monto">Monto: </label> <?php echo number_format( $gasto->monto, 2,',','.'); ?><b> Fecha: </b> <?php echo date("d-m-Y h:i:s a",strtotime($gasto->fecha)); ?>
                     <p></p>
                </div>
            </div>

							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="form-group">
                    	<label for="concepto">Descripcion: </label> {{$gasto->descripcion}}
                    </div>
                </div>
												<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
	<table width="100%"><tr><td><label for="costo">Base Imponible:</label>  {{$gasto->base}}</td>
	<td><label for="costo">Impuesto:</label>  {{$gasto->iva}}</td>
	<td><label for="costo">Exento:</label> {{$gasto->exento}}</td>
	<td> <label for="costo">Total:</label> <?php echo number_format( $gasto->monto, 2,',','.'); ?></td>
	</tr></table>

	</div>
               <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6"><h4 align="center">Desglose de pago</h4>
					<div class="table-responsive">
                  <table id="desglose" class="table table-striped table-bordered table-condensed table-hover">
                      <thead style="background-color: #A9D0F5">
						<th>Tipo</th>
                          <th>Monto</th>
						  <th>Tasa</th>
                          <th>Monto$</th>
                          <th>Referencia</th>
                          
                      </thead>
              
                      <tbody>
                     @foreach($comprobante as $re) <?php  $acum=$acum+$re->monto;?>
                        <tr >
                          <td>{{$re->idbanco}}</td>
                          <td><?php echo number_format( $re->recibido, 2,',','.'); ?></td>
						      <td> <?php if ($re->idpago==2){echo number_format( $re->tasap, 2,',','.'); }
							  if ($re->idpago==3){echo number_format( $re->tasab, 2,',','.'); }?></td>
						   <td><?php echo number_format( $re->monto, 2,',','.'); ?></td>
                          <td>{{$re->referencia}}</td>                        
                        </tr>
                        @endforeach
                        <tfoot>                    
                          <th colspan="3">Total</th>
						  <th><?php echo number_format( $acum, 2,',','.');?> $</th>
                          <th ><b> Pendiente: <?php echo number_format( ($gasto->saldo), 2,',','.');?></b></h4></th>
                          </tfoot>
                       
                      </tbody>
                  </table>
				  </div>
                    </div>
					            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6"><h4 align="center">N/C Aplicadas</h4>
                  <table id="desglose" class="table table-striped table-bordered table-condensed table-hover">
                      <thead style="background-color: #A9D0F5">
                          <th>Monto$</th>
                          <th>Referencia</th>
                          <th>Fecha</th>
                          
                      </thead>
              
                      <tbody>
                     @foreach($recibonc as $rec) <?php  $acumc=$acumc+$rec->monto;?>
                        <tr >
						   <td><?php echo number_format( $rec->monto, 2,',','.'); ?></td>
                          <td>{{$rec->referencia}} </td>
						  <td><?php echo date("d-m-Y",strtotime($rec->fecha)); ?></td>                        
                        </tr>
                        @endforeach
                        <tfoot>                    
                          <th colspan="2">Total</th>
						  <th><?php echo number_format( $acumc, 2,',','.');?> $</th>
                         
                          </tfoot>
                       
                      </tbody>
                  </table>
                    </div>
                </div></div></div>            
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="form-group">
                    <label for="num_comprobante">Usuario: {{$gasto->usuario}}</label>
                </div>
            </div> 
								<div class="col-lg-12 col-md-12 col-sm-6 col-xs-12">
                    <div class="form-group" align="center">
					 <button type="button" id="regresar" class="btn btn-danger" data-dismiss="modal" title="Presione Alt+flecha izq. para regresar">Regresar</button>
                     <button type="button" id="imprimir" class="btn btn-primary" data-dismiss="modal">Imprimir</button>
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
  window.location="/gastos/gasto";
    });
$('#regresar').on("click",function(){
  window.location="/gastos/gasto";
  
});
});
</script>
@endpush
@endsection