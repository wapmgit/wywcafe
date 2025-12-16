@extends ('layouts.admin')
@section ('contenido')
@include('pacientes.paciente.empresa')
	<div class="row" id="principal">
	<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
		<h3>Listado de Clientes <a href="/pacientes/paciente/create">@if($rol->newcliente==1)<button class="btn btn-info">Nuevo</button>@endif</h3></a>
	 
	</div>
			<div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
			@include('pacientes.paciente.search')
	</div>
	<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4" align="right">
 @if($rol->web==1) <a href="/enviar-clientes"><button class="btn btn-info" id="btn"><i class="fa fa-fw fa-cloud-upload"></i>Sincronizar</button></a>@endif
	</div>
</div>
<div class="row"  id="imgcarga"  style="display:none">
<div  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" align="center">  
<img src="{{asset('imagenes/sistema/loading51.gif')}}"></div>
</div>

<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="table-responsive">
			<table class="table table-striped table-bordered table-condensed table-hover">
				<thead>
					<th>Nombre</th>
					<th>Cedula</th>
					<th>Direccion</th>
					<th>Vendedor</th>
					<th>Opciones</th>
				</thead>
               @foreach ($pacientes as $cat)
				<tr>
					<td>@if($rol->actcliente==1)
					<?php if($cat->status == "A"){?><a href="" data-target="#modal-delete-{{$cat->id_cliente}}" data-toggle="modal" title="Suspender Cliente"><i class="fa fa-fw fa-user-times" style="color:red"></i></a>
					<?php }else{?><a href="" data-target="#modal-act-{{$cat->id_cliente}}" data-toggle="modal" title="Activar Cliente"><i class="fa fa-fw fa-user-plus" style="color:blue"></i></a><?php } ?>@endif {{ $cat->nombre}}</td>
					<td><small>{{ $cat->cedula}}</small></td>
					<td><small><small> <?php echo substr( $cat->direccion, 0, 20 ); ?></small></small></td>
					<td><small><small>{{ $cat->vendedor}}</small></small></td>
					<td>
				@if($rol->editcliente==1)	<a href="{{URL::action('PacientesController@edit',$cat->id_cliente)}}"><button class="btn btn-warning btn-xs">Edit.</button></a>@endif		
				@if($rol->crearventa==1)	<a href="{{URL::action('VentaController@edit',$cat->id_cliente)}}"><button class="btn btn-primary btn-xs">Fact.</button></a>@endif
                @if($rol->edocta==1) 	<a href="{{URL::action('PacientesController@show',$cat->id_cliente)}}"><button class="btn btn-success btn-xs">Edo. Cta.</button></a>@endif
					
					</td>
				</tr>
					@include('pacientes.paciente.modalalta')
					@include('pacientes.paciente.modalact')
				@endforeach
			</table>
		</div>
		{{$pacientes->render()}}
	</div>
</div>
@push ('scripts')
<script>

$(document).ready(function() {    
const cuerpoDelDocumento = document.body;
cuerpoDelDocumento.onload = miFuncion;
function miFuncion() {
 // alert('La página terminó de cargar');
  	document.getElementById('imgcarga').style.display="none"; 
	document.getElementById('principal').style.display=""; 
} 

	$("#btn").click(function(){
		document.getElementById('imgcarga').style.display=""; 
		document.getElementById('principal').style.display="none"; 
	})

});

</script>
@endpush
@endsection