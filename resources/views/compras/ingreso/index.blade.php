@extends ('layouts.admin')
@section ('contenido')

	<div class="row">
	<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
		<h3>Listado de Ingresos <a href="/compras/ingreso/create">	@if($rol->crearcompra==1)<button class="btn btn-info">Nuevo</button>@endif</h3></a>
		@include('compras.ingreso.search')
	</div>
</div>

<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="table-responsive">
			<table class="table table-striped table-bordered table-condensed table-hover">
				<thead>
				
					<th>Fecha</th>
					<th>Proveedor</th>
					<th>Documento</th>
					<th>Monto</th>
					<th>Estado</th>
					<th>Opciones</th>
				</thead>
               @foreach ($ingresos as $ing)
				<?php $status=$ing->estatus;
				
$newdate=date("d-m-Y",strtotime($ing->fecha_hora));
				 ?>
				<tr>
					<td><?php echo $newdate; ?></td>
					<td>{{ $ing->nombre}}</td>
					<td> <?php if(($ing->tipo_comprobante=="N/E")and ($status=="0")){?>
					@if($rol->importarne==1)<a href="/compras/ingreso/notas/{{$ing->idingreso}}"><b> {{ $ing->tipo_comprobante}}</b></a>@else  {{ $ing->tipo_comprobante}} @endif
					:{{$ing->serie_comprobante}}-{{$ing->num_comprobante}}<?php }else{ ?>
					{{ $ing->tipo_comprobante.':'.$ing->serie_comprobante.'-'.$ing->num_comprobante}}<?php } ?></td>
					<td><?php echo number_format( $ing->total, 2,',','.'); ?></td>
					<td>{{ $ing->estado}}</td>
				
					<td>
					
				  <a href="{{URL::action('IngresoController@show',$ing->idingreso)}}"><button class="btn btn-primary">Detalles</button></a>	
				  <a href="/compras/ingreso/etiquetas/{{$ing->idingreso}}"><button class="btn btn-succes"> Etiquetas</button></a>
					@if($rol->anularcompra==1)<?php if($status=="0"){?>                 
				 <a href="" data-target="#modal-delete-{{$ing->idingreso}}" data-toggle="modal" ><button class="btn btn-danger">anular</button></a>	
					<?php } else {?> <button class="btn btn-danger">anulada</button><?php } ?>  @endif
					</td>
				</tr>
				@include('compras.ingreso.modal')
				@endforeach
			</table>
		</div>
		{{$ingresos->render()}}
	</div>
</div>

@endsection