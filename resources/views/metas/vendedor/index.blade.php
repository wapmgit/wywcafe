@extends ('layouts.admin')
@section ('contenido')
@include('metas.metas.empresa')

	<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
		<h3>Metas Registradas a Vendedores <a href="/metas/vendedor/create"><button class="btn btn-info">Nuevo</button></h3></a>
		@include('metas.vendedor.search')
	</div>
</div>

<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="table-responsive">
			<table class="table table-striped table-bordered table-condensed table-hover">
				<thead>
				
					<th>Fecha</th>
					<th>Vendedor</th>
					<th>Descripcion</th>
					<th>Inicio</th>
					<th>Fin</th>
					<th>Cumplimient</th>
					<th>Opciones</th>
				</thead>
               @foreach ($metas as $ing)
				<tr>
					
					<td><?php echo date("d-m-Y",strtotime($ing->creado)); ?></td>
					<td>{{ $ing->nombre}}</td>
					<td>{{ $ing->descripcion}}</td>

					<td><?php echo date("d-m-Y",strtotime($ing->inicio)); ?></td>
					<td><?php echo date("d-m-Y",strtotime($ing->fin)); ?></td>
					<td><?php echo  number_format( $ing->cumplimiento, 2,',','.')."%"; ?></td>
				
				
					<td>
						<?php if($ing->metodo==0){?>	<a href="{{URL::action('MetasVendedorController@show',$ing->idmeta)}}"><button class="btn btn-primary">Detalles</button></a>
				<?php }else {?>	<a href="/detallemeta/bloque/{{$ing->idmeta}}"><button class="btn btn-success"> Detalles</button></a>
				<?php } ?>
				<a href="/detallemeta/obsmetavendedor/{{$ing->idmeta}}"><button class="btn btn-info">Obs</button></a>
					<?php if($ing->estatus==0){ ?>
					<a href="" data-target="#modal-delete-{{$ing->idmeta}}" data-toggle="modal" ><button class="btn btn-danger">Anular</button></a>	<?php } 
					 if($ing->estatus==2){?><button class="btn btn-danger">Anulado</button> <?php } ?>				
					</td>
				</tr>
				@include('metas.vendedor.modal')
				@endforeach
			</table>
		</div>
		{{$metas->render()}}
	</div>
</div>

@endsection