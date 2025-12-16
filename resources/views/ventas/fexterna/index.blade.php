@extends ('layouts.admin')
@section ('contenido')
@include('ventas.fexterna.empresa')

	<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
		<h3>Ventas Externas <a href="/ventas/fexterna/create">	@if($rol->crearfe==1)<button class="btn btn-info">Nuevo</button>@endif</h3></a>
		@include('ventas.fexterna.search')
	</div>
</div>

<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="table-responsive">
			<table class="table table-striped table-bordered table-condensed table-hover">
				<thead>
				
					<th>Fecha</th>
					<th>Serie</th>
					<th>Documento</th>
					<th>Nro. Control</th>
					<th>Razon</th>
					<th>Monto Venta</th>
					<th>Opciones</th>
				</thead>    
               @foreach ($ventas as $ing)
				<tr>
					
					<td><?php echo date("d-m-Y",strtotime($ing->fecha)); ?></td>
					<td>{{ $ing->serie}}</td>
					<td>{{ $ing->factura}}</td>
					<td>{{ $ing->control}}</td>
					<td><small>{{ $ing->nombre}}</small></td>
					<td><?php echo number_format( $ing->totalventa, 2,',','.'); ?></td>					   		
					<td>	<?php if($ing->estatus==0){ ?>
					<a href="" data-target="#modal-delete-{{$ing->idventa}}" data-toggle="modal" >@if($rol->anularfe==1)<button class="btn btn-danger btn-sm">Anular</button>@endif</a>
					<a href="{{URL::action('FexternaController@edit',$ing->idventa)}}" >@if($rol->editarfe==1)<button class="btn btn-warning btn-sm">Editar</button>@endif</a>					<?php } else {?>
					<button class="btn btn-danger btn-sm">Anulado</button> <?php } ?>
				<a href="{{URL::action('FexternaController@show',$ing->idventa)}}"><button class="btn btn-primary btn-sm">Detalles</button></a>
					</td>
				</tr>
				@include('ventas.fexterna.modal')
				@endforeach
			</table>
		</div>
		{{$ventas->render()}}
	</div>
</div>

@endsection