@extends ('layouts.admin')
@section ('contenido')
<div class="row">
	<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
		<h3>Maquinaria <a href="maquina/create"><button class="btn btn-info">Nuevo</button></a></h3>
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
					<th>Tipo</th>
					<th>Marca</th>
					<th>Capacidad</th>
					<th>Opciones</th>
				</thead>
               @foreach ($data as $cat)
				<tr>
					<td>{{ $cat->iddep}}</td>
					<td>{{ $cat->nombre}}</td>
					<td>
					<?php if($cat->tipo==1){ echo "Trilladora";} ?>
					<?php if($cat->tipo==2){ echo "Tostadora";} ?>
					<?php if($cat->tipo==3){ echo "Molino";} ?>
					<?php if($cat->tipo==4){ echo "Empaquetadora";} ?>
					</td>
					<td>{{ $cat->marca}}</td>
					<td>{{ $cat->capacidad}}</td>
					<td>
						<a href="{{URL::action('MaquinariaController@edit',$cat->iddep)}}"><button class="btn btn-warning">Editar</button></a>
                        <a href="{{URL::action('MaquinariaController@show',$cat->iddep)}}"><button class="btn btn-primary">Ver Info.</button></a>
					</td>
				</tr>
				
				@endforeach
			</table>
		</div>
		{{$data->render()}}
	</div>

</div>
@endsection