@extends ('layouts.admin')
@section ('contenido')
	<h2 align="center"> ARTICULOS REGISTRADOS EN EL BLOQUE</h2>
  <hr/>
		       <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">

                 <div class="form-group">
                      <label for="proveedor">Nombre</label>
                   <p>{{$bloque->descripcion}}</p>
                    </div>
            </div>
             <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">

                 <div class="form-group">
                      <label for="proveedor">Responsable</label>
                   <p>{{$bloque->responsable}}</p>
                    </div>
            </div>
			   <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">

                 <div class="form-group">
                      <label for="proveedor">Creacion</label>
                   <p>{{$bloque->fecha}}</p>
                    </div>
               
            </div>
            <div clas ="row">
                <div class="panel panel-primary">
                <div class="panel-body">
                   <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <table id="detalles" class="table table-striped table-bordered table-condensed table-hover">
                      <thead style="background-color: #E6E6E6">
                     
                          <th>Codigo</th>
                          <th>Nombre</th>
                         
              </thead>
                      <tbody>
                        @foreach($detalles as $det)
                        <tr >
                          <td>{{$det->codigo}}</td>
                          <td>{{$det->articulo}}</td>
                                                  
                        </tr>
                        @endforeach
                      </tbody>  				 
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
  window.location="/metas/bloques";
    });

});

</script>

@endpush