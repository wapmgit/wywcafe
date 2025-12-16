@extends ('layouts.admin')
@section ('contenido')
<div class="row">
	<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
		<h3>Listado de Categorías <a href=""><button class="btn btn-success">Nuevo</button></a></h3>
		@include('tratamiento.precio.search')
	</div>
</div>

<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="table-responsive">
			<table class="table table-striped table-bordered table-condensed table-hover">
				<thead>
					<th>Id</th>
					<th>Nombre</th>
					<th>clase</th>
					<th>Precio</th>
				</thead>
               @foreach ($tratamiento as $obj)
				<tr>
					<td>{{ $obj->id_tratamiento}}</td>	
					<td>{{ $obj->tratamiento}}</td>
					<td>{{ $obj->clase}}</td>
					<td>{{ $obj->precio_base}}</td>
					<td>
						<a href="{{URL::action('PrecioController@edit',$obj->id_tratamiento)}}"><button class="btn btn-info">Editar</button></a>
                         <a href="{{URL::action('PrecioController@show',$obj->id_tratamiento)}}" data-target="" data-toggle="modal"><button class="btn btn-success">Detalles</button></a>
					</td>
				</tr>
			
				@endforeach
			</table>
		</div>
		{{$tratamiento->render()}}
	</div>
</div>

@endsection