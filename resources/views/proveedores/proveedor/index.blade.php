@extends ('layouts.admin')
@section ('contenido')
<div class="row">

		<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            	 <div class="form-group">
            			<label >{{$empresa->nombre}}</label></br>
            			<label >{{$empresa->rif}}</label>	
            	 </div>  
	    </div>
</div>
	<div class="row">
	<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
		<h3>Listado de Proveedores<a href="/proveedores/proveedor/create">@if($rol->newproveedor==1) <button class="btn btn-info">Nuevo</button>@endif</h3></a>
		@include('proveedores.proveedor.search')
	</div>
</div>
<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="table-responsive">
			<table class="table table-striped table-bordered table-condensed table-hover">
				<thead>
					<th>Id</th>
					<th>Empresa</th>
					<th>RIF</th>
					<th>Telefono</th>
					<th>Direccion</th>
					<th>Opciones</th>
				</thead>
               @foreach ($proveedor as $cat)
				<tr>
					<td>{{ $cat->idproveedor}}</td>
					<td>{{ $cat->nombre}}</td>
					<td><small>{{ $cat->rif}}</small></td>
					<td><small>{{ $cat->telefono}}</small></td>
					<td><small>{{ $cat->direccion}}</small></td>
					<td>
					@if($rol->editproveedor==1)<a href="{{URL::action('ProveedorController@edit',$cat->idproveedor)}}"><button class="btn btn-warning btn-xs">Editar</button></a>@endif
					@if($rol->crearcompra==1)<a href="{{URL::action('IngresoController@edit',$cat->idproveedor)}}"><button class="btn btn-primary btn-xs">Facturar</button></a>@endif
                   	@if($rol->edoctap==1)<a  href="/proveedores/proveedor/historico/{{$cat->idproveedor}}"><button class="btn btn-success btn-xs">Edo. Cta.</button></a>@endif		
					</td>
				</tr>
				@endforeach
			</table>
		</div>
		{{$proveedor->render()}}
	</div>
</div>

@endsection