@extends ('layouts.admin')
@section ('contenido')
@include('almacen.articulo.empresa')
	<div class="row">
	<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
		<h3>Listado de Ventas<a href="/ventas/venta/create"> <button class="btn btn-info">Nuevo</button></h3></a>
		@include('ventas.venta.search')
	</div>
</div>
<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="table-responsive">
			<table class="table table-striped table-bordered table-condensed table-hover">
				<thead>
					<th>Fecha</th>
					<th>Cliente</th>
					<th>Tipo comp</th>
					<th>Total</th>
					<th>Condicion</th>
					<th>Opciones</th>
				</thead>
               @foreach ($ventas as $ven)
               <?php 
$newdate=date("d-m-Y h:i:s a",strtotime($ven->fecha_hora));
    ?>
				<tr>
					<td><?php echo $newdate; ?></td>
					<td>{{ $ven->nombre}}</td>
					<td>{{ $ven->tipo_comprobante.':'.$ven->serie_comprobante.'-'.$ven->num_comprobante}}</td>
					<td>{{ $ven->total_venta}}</td>
					<td>{{ $ven->estado}}</td>
				
					<td>
				
				<a href="{{URL::action('VentaController@show',$ven->idventa)}}"><button class="btn btn-primary">Detalles</button></a>
					
                  <?php if ( $ven->devolu == 0){?><a href="{{URL::action('ReportesController@show',$ven->idventa)}}"   ><button class="btn btn-danger">Devolucion</button></a><?php } else {?><button class="btn btn-danger">Fac. Devuelta</button><?php } ?>
					</td>
				</tr>
		
				@endforeach
			</table>
		</div>
		{{$ventas->render()}}
	</div>
</div>

@endsection