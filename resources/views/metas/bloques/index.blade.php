@extends ('layouts.admin')
@section ('contenido')
<div class="row">
	<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
		<h3>Lista de Bloques<a href="bloques/create"> <button class="btn btn-info">Nuevo</button></a></h3>

		@include('metas.bloques.search')
	</div>
</div>

<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="table-responsive">
			<table class="table table-striped table-bordered table-condensed table-hover">
				<thead>
					<th>Id</th>
					<th>Descripción</th>
					<th>Responsable</th>
					<th>Articulos</th>				
					<th>Opciones</th>
				</thead>
               @foreach ($bloques as $cat)
				<tr>
					<td>{{ $cat->idbloque}}</td>					
					<td>{{ $cat->descripcion}}</td>
					<td>{{ $cat->responsable}}</td>
					<td>{{ $cat->articulos}}</td>
					<td>
						<a href="{{URL::action('BloquesController@edit',$cat->idbloque)}}"><button class="btn btn-warning">Editar</button></a>
                    <a href="{{URL::action('BloquesController@show',$cat->idbloque)}}"><button class="btn btn-primary">Detalles</button></a>
					</td>
				</tr>
				
				@endforeach
			</table>
		</div>
		{{$bloques->render()}}
	</div>

</div>
@endsection