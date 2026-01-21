@extends ('layouts.admin')
@section ('contenido')
<div class="row">
	<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
		<h3>Lista de Depositos <a href="deposito/create"><button class="btn btn-info">Nuevo</button></a></h3>
		@include('depositos.deposito.search')
	</div>
</div>

<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="table-responsive">
			<table class="table table-striped table-bordered table-condensed table-hover">
				<thead>
					<th>Id</th>
					<th>Nombre</th>
					<th>Descripcion</th>
					<th>Opciones</th>
				</thead>
               @foreach ($deposito as $cat)
				<tr>
					<td>{{ $cat->id_deposito}}</td>
					<td>{{ $cat->nombre}}</td>
					<td>{{ $cat->descripcion}}</td>
					<td>
						<a href="{{URL::action('DepvendedorController@edit',$cat->id_deposito)}}"><button class="btn btn-warning">Editar</button></a>
                        <a href="{{URL::action('DepvendedorController@show',$cat->id_deposito)}}"><button class="btn btn-primary">Ver articulos</button></a>
					</td>
				</tr>
				
				@endforeach
			</table>
		</div>
		{{$deposito->render()}}
	</div>

</div>
@endsection