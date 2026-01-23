@extends ('layouts.admin')
@section ('contenido')
<div class="row">
	<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
		<h3>Tostadores <a href="tostador/create"><button class="btn btn-info">Nuevo</button></a></h3>
		@include('produccion.tostador.search')
	</div>
</div>

<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="table-responsive">
			<table class="table table-striped table-bordered table-condensed table-hover">
				<thead>
					<th>Id</th>
					<th>Nombre</th>
					<th>Telefono</th>
					<th>Direccion</th>
					<th>Opciones</th>
				</thead>
               @foreach ($personas as $cat)
				<tr>
					<td>{{ $cat->id}}</td>
					<td>{{ $cat->nombre}}</td>
					<td>{{ $cat->telefono}}</td>
					<td>{{ $cat->direccion}}</td>
					<td>
						<a href="{{URL::action('TostadorController@edit',$cat->id)}}"><button class="btn btn-warning">Editar</button></a>
                        <a href="{{URL::action('TostadorController@show',$cat->id)}}"><button class="btn btn-primary">Ver Info.</button></a>
					</td>
				</tr>
				
				@endforeach
			</table>
		</div>
		{{$personas->render()}}
	</div>

</div>
@endsection