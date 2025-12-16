@extends ('layouts.admin')
@section ('contenido')
@include('gastos.gasto.empresa')

	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<h3>Gastos Registrados <a href="/gastos/gasto/create">	@if($rol->creargasto==1)<button class="btn btn-info">Nuevo</button>@endif</h3></a>
		@include('gastos.gasto.search')
	</div>
</div>

<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="table-responsive">
			<table class="table table-striped table-bordered table-condensed table-hover">
				<thead>
				
					<th>Fecha</th>
					<th>Documento</th>
					<th>Razon</th>
					<th>Monto</th>
					<th>Por Pagar</th>
					<th>Opciones</th>
				</thead>
               @foreach ($gasto as $ing)
				<tr>
					
					<td><?php echo date("d-m-Y",strtotime($ing->fecha)); ?></td>
					<td>{{ $ing->documento}}</td>

					<td>{{ $ing->nombre}}</td>
					<td><?php echo number_format( $ing->monto, 2,',','.'); ?></td>
					<td><?php echo number_format( $ing->saldo, 2,',','.'); ?></td>
				
				
					<td>@if($rol->anulargasto==1)<?php if($ing->estatus==0){ ?>
					<a href="" data-target="#modal-delete-{{$ing->idgasto}}" data-toggle="modal" ><button class="btn btn-danger btn-sm">Anular</button></a>	<?php } else {?>
					<button class="btn btn-danger">Anulado</button> <?php } ?>@endif
				<a href="{{URL::action('GastosController@show',$ing->idgasto)}}"><button class="btn btn-primary btn-sm">Detalles</button></a>
					</td>
				</tr>
				@include('gastos.gasto.modal')
				@endforeach
			</table>
		</div>
		{{$gasto->render()}}
	</div>
</div>

@endsection