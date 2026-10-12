@extends ('layouts.admin')
@section ('contenido')
<div class="row">
	<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
		<h3>Produccion -> Tostado <a href="/tostado/create"><button class="btn btn-info">Nuevo</button></a></h3>

		@include('produccion.tostado.search')
	</div>
</div>

<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="table-responsive">
			<table class="table table-striped table-bordered table-condensed table-hover">
				<thead>
					<th>Documento</th>
					<th>fecha</th>
					<th>Tostador</th>
					<th>Cochas</th>
					<th>Tostado</th>
					<th>Opciones</th>
				</thead>
               @foreach ($data as $cat)
				<tr>
					<td>00{{ $cat->idt}}</td>
					<td>{{ $cat->fecha}}</td>
					<td>{{ $cat->nombre}}</td>
					<td>{{ $cat->cochas}}</td>
					<td>{{ $cat->kgtostado}}</td>
					<td>
						
                        <a href="/tostado/detalle/{{$cat->idt}}"><button class="btn btn-primary">Detalle</button></a>
				<?php if($cat->devolu=="0"){?>                 
				 <a href="" data-target="#modal-anular{{$cat->idt}}" data-toggle="modal" ><button class="btn btn-danger">anular</button></a>	
					<?php } else {?> <button class="btn btn-danger">anulada</button><?php } ?> 
					</td>
				</tr>
				@include('produccion.tostado.modal')
				@endforeach
			</table>
		</div>
		{{$data->render()}}
	</div>

</div>
@endsection