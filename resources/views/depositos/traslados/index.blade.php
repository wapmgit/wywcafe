@extends ('layouts.admin')
@section ('contenido')
	<div class="row">
	<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
		<h3>Listado de Traslados<a href="/deposito/traslado/create"> <button class="btn btn-info">Nuevo</button></h3></a>
		@include('depositos.traslados.search')
	</div>
</div>
<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="table-responsive">
			<table class="table table-striped table-bordered table-condensed table-hover">
				<thead>
				
					<th>Fecha</th>
					<th>Concepto</th>
					<th>Responsable</th>
					<th>Dep. Origen</th>
					<th>Dep. Destino</th>
					<th>Total Pedido</th>
					<th>User</th>
					<th>Opciones</th>
				</thead>
               @foreach ($ventas as $ven)
               <?php 
$newdate=date("d-m-Y",strtotime($ven->fecha));
    ?>
				<tr>
					<td><?php echo $newdate; ?></td>
					<td>{{ $ven->concepto}}</td>
					<td>{{ $ven->responsable}}</td>
					<td>{{ $ven->origen}}</td>
					<td>{{ $ven->destino}}</td>
					<td>{{ $ven->total_traslado}}</td>
					<td>{{ $ven->user}}</td>
				
					<td>
				
				<a href="{{URL::action('TrasladoController@show',$ven->idtraslado)}}"><button class="btn btn-primary">Detalles</button></a>
					</td>
				</tr>
		
				@endforeach
			</table>
		</div>
		{{$ventas->render()}}
	</div>
</div>

@endsection