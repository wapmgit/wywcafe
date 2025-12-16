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

		<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            	 <div class="form-group">
            			<label >{{$empresa->nombre}}</label></br>
						<label >{{$empresa->rif}}</label></br>	
						<label >{{$empresa->direccion}}. Tel: {{$empresa->telefono}}</label>
            	 </div>  
	    </div>
				<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            	 <div class="form-group"><h2 align="center"> NOTA DE <?php if($tipo==1){ echo "DEBITO"; }else{ echo "CREDITO";}?></h2>
<h4 align="center">#<?php echo add_ceros($nota->numnota,$ceros); ?></h5>            		
		
            	 </div>  
	    </div>
</div>

		       <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">

                 <div class="form-group">
                      <label for="proveedor">Cliente</label>
                   <p>{{$nota->nombre}}</p>
                    </div>
            </div>
             <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">

                 <div class="form-group">
                      <label for="proveedor">Cedula</label>
                   <p>{{$nota->cedula}}</p>
                    </div>
            </div>
			   <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                 <div class="form-group">
                      <label for="proveedor">Direccion</label>
                   <p>{{$nota->direccion}}</p>
                    </div>
            </div>			
            </div>	
  <hr/>
					       <div class="row">
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">

                 <div class="form-group">
                      <label for="proveedor">Fecha</label>
                   <p>{{$nota->fecha}}</p>
                    </div>
            </div>
           <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">

                 <div class="form-group">
                      <label for="proveedor">Descripcion</label>
                   <p>{{$nota->descripcion}}</p>
                    </div>
            </div>
			      <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
                 <div class="form-group">
                      <label for="proveedor">Referencia</label>
                   <p>{{$nota->referencia}}</p>
                    </div>
            </div>
						      <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
                 <div class="form-group">
                      <label for="proveedor">Monto</label>
                   <p>{{$nota->monto}}</p>
                    </div>
            </div>
            </div>
            <div clas ="row">
                <div class="panel panel-primary">
                <div class="panel-body">
                   <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				   <?php if($tipo==1){ ?>
                  <table id="detalles" class="table table-striped table-bordered table-condensed table-hover">
                      <thead style="background-color: #E6E6E6">
                     
                          <th>Moneda</th>
						  <th>fecha</th>
						  <th>Referencia</th>
                          <th>Recibido</th>
                          <th>Monto $</th>                      
                          
              </thead><?php $acum=0; $acumprecio=0; $acum=0; $monto=0;?>
                      <tbody>
                        @foreach($pagos as $det)
                        <tr > <?php $acum=($acum+$det->monto);  ?>
                          <td>{{$det->idbanco}}</td>
						   <td>{{$det->fecha}}</td>
						     <td>{{$det->referencia}}</td>    
                          <td>{{$det->recibido}}</td>
                          <td>{{$det->monto}}</td>                                                                   
                        </tr>
                        @endforeach
						@foreach($datond as $d)
                        <tr > <?php $acum=($acum+$d->monto);  ?>
                          <td>Nota de Credito</td>
						   <td>{{$d->fecha}}</td>
						     <td>{{$d->referencia}}</td>    
                          <td></td>
                          <td>{{$d->monto}}</td>                                                                   
                        </tr>
                        @endforeach
						
                      </tbody> 
					  <tr><td colspan="4">Total: </td>
					  <td><strong><?php echo number_format($acum, 2,',','.');?></strong></td></tr>
                  </table>
				   <?php } else{ ?>
				<table id="detalles" class="table table-striped table-bordered table-condensed table-hover">
                      <thead style="background-color: #E6E6E6">
                     
                          <th>Tipo</th>
                          <th>Documento</th>
                          <th>Monto</th>
                          <th>Fecha</th>
                          <th>Referencia</th>
                          <th>Usuario</th>
              </thead><?php $acump=0; $acumprecio=0; $acum=0; $monto=0;?>
                      <tbody>
                        @foreach($pagos as $det)
                        <tr > <?php $acump=$acump+$det->monto; 
						 ?>
                          <td>{{$det->tipodoc}}</td>
                          <td>{{$det->iddoc}}</td>
                          <td>{{$det->monto}}</td>
                          <td>{{$det->fecha}}</td>
                          <td>{{$det->referencia}}</td>
                          <td>{{$det->user}}</td>
                          
                        </tr>
                        @endforeach
                      </tbody>   
					  <tr><td colspan="5">Total: </td>
					  <td><strong><?php echo number_format($acump, 2,',','.');?></strong></td></tr>
                  </table>
				   <?php } ?>
                    </div>
                </div>   
  <div class="col-lg-12 col-md-12 col-sm-6 col-xs-12">
                    <div class="form-group" align="center"></br>
				<?php 
				if($nota->monto==$nota->pendiente){?>
				<button type="button" id="anular" class="btn btn-warning" data-dismiss="modal">Anular</button> 
				<?php }?>
					<button type="button" id="regresarpg" class="btn btn-danger" data-dismiss="modal">Regresar</button>
                     <button type="button" id="imprimir" class="btn btn-primary" data-dismiss="modal">Imprimir</button> 
                    </div>
                </div>                
                </div>
       </div>
	
@endsection
@push ('scripts')
<script>

$(document).ready(function(){
    $('#imprimir').click(function(){
  document.getElementById('imprimir').style.display="none";
    document.getElementById('regresarpg').style.display="none";
    document.getElementById('anular').style.display="none";
  window.print(); 
   window.location="/pacientes/paciente/<?php echo $nota->idcliente;?>";
    });
	    $('#regresarpg').click(function(){
   window.location="/pacientes/paciente/<?php echo $nota->idcliente;?>";
    });
		    $('#anular').click(function(){
   window.location="/pacientes/anular/<?php echo $nota->idnota;?>";
    });

});

</script>

@endpush