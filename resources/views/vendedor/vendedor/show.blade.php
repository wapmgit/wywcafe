@extends ('layouts.admin')
@section ('contenido')
<?php $cont=0; ?>
    <?php
// fecha 1
$fecha_dada= "1985/08/28";
// fecha actual
$fecha_actual= date("Y/m/d");

function dias_pasados($fecha_inicial,$fecha_final)
{
$dias = (strtotime($fecha_inicial)-strtotime($fecha_final))/86400;
$dias = abs($dias); $dias = floor($dias);
return $dias;
}
?>
	<h3 align="center"> CLIENTES ASOCIADOS AL VENDEDOR</h3>
  <hr/>
		       <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">

                 <div class="form-group">
                      <label for="proveedor">Nombre</label>
                   <p>{{$vendedores->nombre}}</p>
                    </div>
            </div>
             <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">

                 <div class="form-group">
                      <label for="proveedor">Cedula</label>
                   <p>{{$vendedores->cedula}}</p>
                    </div>
            </div>
			   <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
			<div class="form-group">
                      <label for="proveedor">Telefono</label>
                   <p>{{$vendedores->telefono}}</p>
                    </div>
            </div>
            </div>
            <div clas ="row">
                <div class="panel panel-primary">
                <div class="panel-body">
                   <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <table id="detalles" width="100%">
                      <thead style="background-color: #A9D0F5">                                        
                          <th>Nombre</th>
                          <th>Telefono</th>
                          <th>Direccion</th>                         
                          <th>Ult. Fac</th>                         
					</thead><?php $acumcosto=0; $acumprecio=0; $acum=0; $monto=0;?>
                      <tbody>
                        @foreach($clientes as $det)
						<?php $cont++;?>
                        <tr > 
                          <td><small><small>{{$det->nombre}} ->{{$det->cedula}}</small></small></td>
                          <td><small><small>{{$det->telefono}}</small></small></td>
                          <td><small><small><small>{{$det->direccion}}</small></small></small></td>                          
                          <td>
						  @foreach($ventas as $ve)
						  <?php if($ve->idcliente==$det->id_cliente){
							  echo "<small><small>".date("d-m-Y",strtotime($ve->lastfact)).", ".dias_pasados($ve->lastfact,$fecha_actual)." Dias </small></small>";
						  }?>
						  @endforeach
						  </td>                          
                        </tr>
                        @endforeach
						<tr><td colspan="3"> <strong>Clientes: </strong><?php echo $cont; ?></td></tr>
                      </tbody> 
                  </table>
                 </br>
                    </div>
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                  <table id="detalles" width="100%">
				  <thead ><th colspan="3" align="center">Clientes con Mayor Facturacion</th></thead>
                      <thead style="background-color: #A9D0F5">                                        
                          <th>Nombre</th>
                          <th>Total</th>
                          <th>Saldo</th>                                                
					</thead >
                      <tbody>
                        @foreach($maventas as $ma)	
                        <tr > 
                          <td><small><small>{{$ma->nombre}}</small></small></td>
                          <td><small><small><?php echo number_format( $ma->facturado,'2',',','.'); ?></small></small></td>
                          <td><small><small><?php echo number_format( $ma->pendiente,'2',',','.'); ?></small></small></td>                                                   
                        </tr>
                        @endforeach
                      </tbody> 
                  </table>                
                    </div>
					<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                  <table id="detalles" width="100%">
				  	  <thead ><th colspan="3" align="center">Clientes con Menos Facturacion</th></thead>
                      <thead style="background-color: #A9D0F5">                                        
                          <th>Nombre</th>
                          <th>Total</th>
                          <th>Saldo</th>                                                
					</thead>
                      <tbody>
                        @foreach($meventas as $me)	
                        <tr > 
                          <td><small><small>{{$me->nombre}}</small></small></td>
                          <td><small><small><?php echo number_format( $me->facturado,'2',',','.'); ?></small></small></td>
                          <td><small><small><?php echo number_format( $me->pendiente,'2',',','.'); ?></small></small></td>                                                   
                        </tr>
                        @endforeach
                      </tbody> 
                  </table>                
                    </div>
                </div>                   
                </div>
       </div>
	   <div class="col-lg-12 col-md-12 col-sm-6 col-xs-12" align="center">
	   <a href="/vendedor/vendedor"><button class="btn btn-danger" id="back"  >Regresar</button></a>
	     <button type="button" id="imprimir" class="btn btn-primary" data-dismiss="modal">Imprimir</button> 
		 </div>
	@push ('scripts')
<script>
$(document).ready(function(){
    $('#imprimir').click(function(){
  //  alert ('si');
  document.getElementById('imprimir').style.display="none";
  window.print(); 
  window.location="/vendedor/vendedor";
    });
});

</script>

@endpush
@endsection