@extends ('layouts.admin')
@section ('contenido')
<?php
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
$acummn=0;
$acumund=0;
?>
	<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            	 <div class="form-group">
            			<label >{{$empresa->nombre}}</label></br>
						<label >{{$empresa->rif}}</label></br>	
						<label >{{$empresa->direccion}}. Tel: {{$empresa->telefono}}</label>
            	 </div>  
	    </div>
		<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
		<h3 align="center"> PRODUCCION <?php echo add_ceros($data->idproduccion,$ceros); ?></h3>
		<h4 align="center"> Molida/Empaquetado</h4>
		</div>
		<div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
		        <table id="detalles" align="center" width="95%">
                      <tr>
                     
                          <th>Responsable</th>
                          <th>Encargado</th>
                          <th>Materia Prima</th>
						  </tr>
						   <tr > 
                          <td>{{$data->responsable}}</td>
                          <td>{{$data->encargado}}</td>
                          <td>{{$data->materiaprima}}</td>
						  </tr>
						  <tr>
                          <th>Kg Subidos</th>
                          <th>Kg Molidos</th>
                          <th>Producto</th>
						  </tr>
						  <tr>
						    <td>{{$data->kgsubido}}</td>
                          <td>{{$data->kgmolidos}}</td>
                          <td>{{$data->pfinal}}</td>
						  </tr>
                  </table></br>
				  <table align="center" width="95%">
				  <thead><th colspan="3" align="center"> Produccion</th></thead>
				  <tr><td><b>Producto</b></td><td><b>Cantidad</b></td><td><b>Kg</b></td></tr>
					@foreach ($det as $nd)
						<tr>
						<?php 
						$acummn=$acummn+$nd->kgproduccion;
						$acumund=$acumund+$nd->cantidad;
						?>
						<td>{{$nd->nombre}}</td>
						<td>{{$nd->cantidad}}</td>
						<td>{{$nd->kgproduccion}}</td>
						</tr> 
					@endforeach
					<tr><td><b>Total</b></td><td><b><?php echo $acumund; ?></b></td><td><b><?php echo $acummn; ?></b></td></tr>			
						  <tr>
                          <th>Fecha: {{$data->fecha}}</th>
                          <th>Reduccion: {{$data->reduccion}} %</th>
                          <th>Kg Dif: {{$data->kgdif}}</th>
						</tr>  				 
				 </table>
                 
		</div>
		    <div class="col-lg-12 col-md-12 col-sm-6 col-xs-12">
	           
                    <div class="form-group" align="center">	</br>
					 <button type="button" id="regresar" class="btn btn-danger" data-dismiss="modal" title="Presione Alt+flecha izq. para regresar">Regresar</button>
                     <button type="button" id="imprimir" class="btn btn-primary" data-dismiss="modal">Imprimir</button>
                    </div>
                </div>  

@endsection
@push ('scripts')
<script>

$(document).ready(function(){
    $('#imprimir').click(function(){
  document.getElementById('imprimir').style.display="none";
    document.getElementById('repreciar').style.display="none";
  window.print(); 
  window.location="/produccion/molida";
    });
    $('#regresar').click(function(){
  window.location="/produccion/molida";
    });
});

</script>

@endpush