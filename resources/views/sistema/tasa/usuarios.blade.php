@extends ('layouts.admin')
@section ('contenido')
<div class="row">
              
<div class="panel panel-primary">
<div class="panel-body">
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
 
    <h3 align="center">USUARIOS DEL SISTEMA</h3> 
      <table class="table table-striped table-bordered table-condensed table-hover">
        <thead style="background-color: #A9D0F5">
    
          <th>Nombre</th>
          <th>Login</th>
          <th>Fecha inicio</th>
          <th>nivel</th>
        </thead>
               @foreach ($empresa as $q)
              
        <tr>
   
          <td>{{ $q->name}}</td>
            <td>{{ $q->email}}</td>
			<td>{{ $q->created_at}}</td>
			<td>{{ $q->nivel}}
			  @if($rol->actroles==1) <a href="" data-target="#roles{{$q->id}}" data-toggle="modal"><button class="btn btn-success">Permisos</button></a> @endif  </td>
		</tr>
       @include('sistema.roles.modalroles')
       </td>
        </tr>
       
        @endforeach
  
      </table>

  
  </div>
  
  </div>
  
  </div>
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
 
  
	          <label>Usuario: {{ Auth::user()->name }}</label>       

              
                     <div class="col-lg-12 col-md-12 col-sm-6 col-xs-12">
                    <div class="form-group" align="center">
                     <button type="button" id="imprimir" class="btn btn-primary" data-dismiss="modal">Imprimir</button>
                    </div>
                </div>
                   
                </div><!-- /.box-body -->
              </div><!-- /.box -->
             

@push ('scripts')
<script>
$(document).ready(function(){
    $('#imprimir').click(function(){
  //  alert ('si');
  document.getElementById('imprimir').style.display="none";
  window.print(); 
  window.location="/sistema/tasa/usuarios";
    });

});

</script>

@endpush
@endsection