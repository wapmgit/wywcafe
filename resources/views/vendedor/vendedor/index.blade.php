@extends ('layouts.admin')
@section ('contenido')
@include('pacientes.paciente.empresa')
<div class="row">
	<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
		<h3>Listado de Vendedores <a href="vendedor/create">@if($rol->newvendedor==1)<button class="btn btn-info">Nuevo</button>@endif</a></h3>
		@include('vendedor.vendedor.search')
	</div>
</div>

<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="table-responsive">
			<table class="table table-striped table-bordered table-condensed table-hover">
				<thead>
					<th></th>
					<th>Nombre</th>
					<th>Cedula</th>
					<th>Telefono</th>
					<th>Comision</th>
					<th>Direccion</th>
					<th>Opciones</th>
				</thead>
               @foreach ($vendedores as $cat)
				<tr>
					<td>@if($rol->editvendedor==1)
						<?php if($cat->estatus == 1 ){?><a href="" data-target="#modal-delete-{{$cat->id_vendedor}}" data-toggle="modal" title="Suspender Vendedor"><i class="fa fa-fw fa-user-times" style="color:red"></i></a>
					<?php }else{?><a href="" data-target="#modal-act-{{$cat->id_vendedor}}" data-toggle="modal" title="Activar Vendedor"><i class="fa fa-fw fa-user-plus" style="color:blue"></i></a><?php } ?>@endif </td>
					<td><i class=""></i>{{ $cat->nombre}}</td>
					<td>{{ $cat->cedula}}</td>
					<td>{{ $cat->telefono}}</td>
					<td>{{ $cat->comision}} %</td>
					<td>{{ $cat->direccion}}</td>
					<td>
							@if($rol->editvendedor==1)<a href="{{URL::action('VendedoresController@edit',$cat->id_vendedor)}}"><button class="btn btn-warning">Editar</button></a>@endif
                        <a href="{{URL::action('VendedoresController@show',$cat->id_vendedor)}}"><button class="btn btn-primary">Ver Clientes</button></a>
						<a href="/vendedor/clientes/{{$cat->id_vendedor}}"><button class="btn btn-success"> Analisis Clientes</button></a>
					</td>
				</tr>
					@include('vendedor.vendedor.modalalta')
					@include('vendedor.vendedor.modalact')
				@endforeach
			</table>
		</div>
		{{$vendedores->render()}}
	</div>

</div>
@endsection