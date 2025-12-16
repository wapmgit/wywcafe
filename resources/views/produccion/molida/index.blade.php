@extends ('layouts.admin')
@section ('contenido')
<div class="row">
	<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
		<h3>Produccion -> Molida <a href="/molida/create"><button class="btn btn-info">Nuevo</button></a></h3>

		@include('produccion.molida.search')
	</div>
</div>

<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="table-responsive">
			<table class="table table-striped table-bordered table-condensed table-hover">
				<thead>
					<th>fecha</th>
					<th>Responsable</th>
					<th>Encargado</th>
					<th>Kg Subidos</th>
					<th>Kg Molidos</th>
					<th>Kg Empaquetados</th>
					<th>Opciones</th>
				</thead>
               @foreach ($data as $cat)
				<tr>
					<td>{{ $cat->fecha}}</td>
					<td>{{ $cat->responsable}}</td>
					<td>{{ $cat->encargado}}</td>
					<td>{{ $cat->kgsubido}}</td>
					<td>{{ $cat->kgmolidos}}</td>
					<td>{{ $cat->kgempa}}</td>
					<td>
						
                        <a href="/molida/detalle/{{$cat->idproduccion}}"><button class="btn btn-primary">Detalle</button></a>
					</td>
				</tr>
				
				@endforeach
			</table>
		</div>
		{{$data->render()}}
	</div>

</div>
@endsection