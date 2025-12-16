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
?>
	<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            	 <div class="form-group">
            			<label >{{$empresa->nombre}}</label></br>
						<label >{{$empresa->rif}}</label></br>	
						<label >{{$empresa->direccion}}. Tel: {{$empresa->telefono}}</label>
            	 </div>  
	    </div>
		<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
		<h3 align="center"> PRODUCCION <?php echo add_ceros($det->idt,$ceros); ?></h3>
		<h4 align="center"> Tostado</h4>
		</div>
		<div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
		        <table id="detalles" width="90%">
                      <tr>
                     
                          <th>Tostador</th>
                          <th>Kg Subidos</th>
                          <th>Materia Prima</th>
						  </tr>
						   <tr > 
                          <td>{{$det->nombre}}</td>
                          <td>{{$det->kgmprima}} ({{$det->cochas}} cochas)</td>
                          <td>{{$det->psalida}}</td>
						  </tr><tr>
                          <th>Responsable</th>
                          <th>Kg Bajados</th>
                          <th>Producto</th>
						  <tr>
						    <td>{{$det->responsable}}</td>
                          <td>{{$det->kgtostado}}</td>
                          <td>{{$det->psalida}}</td></tr>
						  <tr>
                          <th>Fecha: {{$det->fecha}}</th>
                          <th>Reduccion: {{$det->reduccion}}</th>
                          <th>comision: {{$det->comision}}</th>
              </tr><?php $acumcosto=0; $acumprecio=0; $acum=0; $monto=0;?>
                      <tbody>
          
                       
                        
                        
                          
                        </tr>
                  
                      </tbody>   
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
  window.location="/produccion/tostado";
    });
    $('#regresar').click(function(){
  window.location="/produccion/tostado";
    });
});

</script>

@endpush