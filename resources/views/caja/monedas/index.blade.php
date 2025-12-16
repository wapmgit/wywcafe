@extends ('layouts.admin')
@section ('contenido')
<div class="row">
	<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
		<h3>Listado de Monedas @if($rol->crearmoneda==1)<a href="monedas/create"><button class="btn btn-info">Nuevo</button></a>@endif</h3>

		@include('caja.monedas.search')
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
					<th>Simbolo</th>
					<th>Valor</th>
					<th>Opciones</th>
				</thead>
               @foreach ($monedas as $cat)
				<tr>
					<td>{{ $cat->idmoneda}}</td>
					<td>{{ $cat->nombre}}</td>
					<td>@if($cat->tipo==0) Mismo Valor @endif
					@if($cat->tipo==1)Multiplica @endif
					@if($cat->tipo==2)Divide @endif
					</td>
					<td>{{ $cat->simbolo}}</td>
					<td>{{ $cat->valor}}</td>
					<td>
				@if($rol->editmoneda==1)		<a href="{{URL::action('MonedasController@edit',$cat->idmoneda)}}"><button class="btn btn-warning">Editar</button></a>@endif
                
					</td>
				</tr>
				
				@endforeach
			</table>
		</div>
		{{$monedas->render()}}
	</div>

</div>
@endsection