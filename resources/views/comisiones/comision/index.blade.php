@extends ('layouts.admin')
@section ('contenido')
	<div class="row">
	<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
		<h3>Listado de Comisiones por Vendedor </a>
		@include('comisiones.comision.search')
	</div>
</div>
<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="table-responsive">
			<table class="table table-striped table-bordered table-condensed table-hover">
				<thead>
				
					<th>Vendedor</th>
					<th>Telefono</th>
					<th>Monto facturado</th>
					<th>Monto Aprox. Comision</th>
					<th>Opciones</th>
				</thead>
				<?php $total=0; $totalc=0; ?>
               @foreach ($ventas as $cat)
				<tr>
				
					<td>{{ $cat->nombre}}</td>
					<td>{{ $cat->telefono}}</td>
					<td><?php $total=$total+$cat->monto; echo number_format( $cat->monto, 2,',','.')." $"; ?></td>
					<td><?php $totalc=$totalc+$cat->montocomision; echo number_format( $cat->montocomision, 2,',','.')." $"; ?></td>
					<td>
				<a href="{{URL::action('ComisionesController@show',$cat->id_vendedor)}}"><button class="btn btn-info">Detalles</button></a>
                  
					</td>
				</tr>
				@endforeach
				<tr ><td colspan="5"><button type="button" class="btn bg-olive btn-flat margin"><strong><?php echo "Comisiones por Pagar: ".number_format( $totalc, 2,',','.')." $";?></strong></button></td></tr>
			</table>
		</div>
		{{$ventas->render()}}
	</div>
</div>

@endsection