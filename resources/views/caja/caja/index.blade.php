@extends ('layouts.admin')
@section ('contenido')  

<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<h3>Caja <a href="caja/create">@if($rol->accesobanco==1)<button class="btn btn-info btn-sm">Nuevo</button>@endif</a></h3>

	</div>

</div>

<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="table-responsive">
			<table id="bancos" class="table table-striped table-bordered table-condensed table-hover">
				<thead>
					
					<th>Codigo</th>
					<th>Nombre</th>					
					<th>Simbolo</th>
					<th>opciones</th>

				</thead>
				<tbody>
               @foreach ($caja as $ban)
				<tr>
					<td>{{ $ban->codigo}}</td>
					<td>{{ $ban->nombre}}</td>
					<td>{{ $ban->simbolo}}</td>					
					
					<td>	
			 <a href="{{URL::action('CajaController@show',$ban->idmoneda)}}"><button class="btn btn-warning">Opcion</button></a>
			 <a href="{{URL::action('CajaController@edit',$ban->idmoneda)}}"><button class="btn btn-info">Editar</button></a>
					</td>
				</tr>@endforeach
				</tbody>
				
			<tfoot>
					<th>Codigo</th>
					<th>Nombre</th>					
					<th>Simbolo</th>
					<th>opciones</th>
			</tfoot>
			</table>
		</div>
	
	
	</div>
</div>
@push ('scripts')
<script>
$(document).ready(function(){
    $('#bancos').DataTable();	
});
</script>
@endpush
@endsection