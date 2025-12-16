@extends ('layouts.admin')
@section ('contenido')
	<h2 align="center"> CLIENTES VINCULADOS A RUTA</h2>
  <hr/>
		       <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">

                 <div class="form-group">
                      <label for="proveedor">Nombre</label>
                   <p>{{$ruta->nombre}}</p>
                    </div>
            </div>
             <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">

                 <div class="form-group">
                      <label for="proveedor">Descripcion</label>
                   <p>{{$ruta->descripcion}}</p>
                    </div>
            </div>
            </div>
            <div clas ="row">
                <div class="panel panel-primary">
                <div class="panel-body">
                   <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <table id="detalles" class="table table-striped table-bordered table-condensed table-hover">
                      <thead style="background-color: #E6E6E6">
                     
                          <th>Cedula</th>
                          <th>Nombre</th>
                          <th>Telefono</th>
                          <th>Direccion</th>
                          <th>Contacto</th>
                          <th>Ult. Venta</th>

              </thead><?php $acumcosto=0; $count=0; $acum=0; $monto=0;?>
                      <tbody>
                        @foreach($clientes as $det)
                        <tr > <?php $count++; ?>
                          <td>{{$det->cedula}}</td>
                          <td>{{$det->nombre}}</td>
                          <td>{{$det->telefono}}</td>
                          <td>{{$det->direccion}}</td>
                          <td>{{$det->contacto}}</td>
                          <td>{{$det->ultventa}}</td>
                          
                        </tr>
                        @endforeach
                      </tbody> 
					  <tr><td colspan="4">Total: </td>
					  <td colspan="2"><strong><?php echo $count." Clientes";?></strong></td>
					 </tr>
                  </table>
                 
                    </div>
                </div>   
  <div class="col-lg-12 col-md-12 col-sm-6 col-xs-12">
                    <div class="form-group" align="center"></br>
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
  //  alert ('si');
  document.getElementById('imprimir').style.display="none";
    document.getElementById('repreciar').style.display="none";
  window.print(); 
  window.location="/rutas/rutas";
    });

});

</script>

@endpush