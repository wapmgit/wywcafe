@extends ('layouts.admin')
@section ('contenido')
<div class="row">
	<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
		<h3>Lista de Rutas <a href="rutas/create"><button class="btn btn-info">Nuevo</button></a></h3>

		@include('rutas.rutas.search')
	</div>
</div>

<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="table-responsive">
			<table class="table table-striped table-bordered table-condensed table-hover">
				<thead>
					<th>Id</th>
					<th>Nombre</th>
					<th>Descripción</th>
					<th>Opciones</th>
				</thead>
               @foreach ($rutas as $cat)
				<tr>
					<td>{{ $cat->idruta}}</td>
					<td>{{ $cat->nombre}}</td>
					<td>{{ $cat->descripcion}}</td>
					<td>
						<a href="{{URL::action('RutasController@edit',$cat->idruta)}}"><button class="btn btn-warning">Editar</button></a>
                        <a href="{{URL::action('RutasController@show',$cat->idruta)}}"><button class="btn btn-primary">Ver Clientes</button></a>
					</td>
				</tr>
				
				@endforeach
			</table>
		</div>
	
	</div>

</div>
@endsection