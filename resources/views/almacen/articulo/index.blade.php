@extends ('layouts.admin')
@section ('contenido')
@include('almacen.articulo.empresa')
<?php $acumexistencia=0; ?>
<div class="row" id="principal">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<h3>Listado de Articulos <a href="articulo/create">@if($rol->newarticulo==1)<button class="btn btn-info">Nuevo</button>@endif</a></h3>

	</div>
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-8">
		@include('almacen.articulo.search')
	</div>
	<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4" align="right">
  @if($rol->web==1)<a href="/enviar-articulos"><button class="btn btn-info"  id="btn"><i class="fa fa-fw fa-cloud-upload"></i>Sincronizar</button></a>@endif
	</div>
</div>
<div class="row"  id="imgcarga"  style="display:none">
<div  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" align="center">  
<img src="{{asset('imagenes/sistema/loading51.gif')}}"></div>
</div>
<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="table-responsive">
			<table class="table table-striped table-bordered table-condensed table-hover">
				<thead>
			
					<th>Codigo</th>
					<th>Nombre</th>					
					<th>Grupo</th>
					<th>stock</th>
					<th>Imagen</th>
					<th>Estado</th>
					<th>Precio $</th>
					<th>P. BS.</th>
					<th>Opciones</th>
				</thead>
               @foreach ($articulos as $cat)
				<tr>
					
					<td>{{ $cat->codigo}}</td>
					<td><a href="{{URL::action('ArticuloController@show',$cat->idarticulo)}}"><i class="fa fa-fw fa-bar-chart-o"></i> </a>{{$cat->nombre}}</td>					
					<td>{{ $cat->categoria}}</td>
					<td  ><a href="" data-target="#modal-existencia-{{$cat->idarticulo}}" data-toggle="modal">{{ $cat->stock}}</a>@include('almacen.articulo.modal_existencia')</td>
						<td  > <?php if ($cat->imagen==""){?> <img src="{{ asset('/imagenes/articulos/ninguna.jpg')}}" alt="{{$cat->nombre}}" height="20px" width="20px" class="img-thumbnail"><?php }else{ ?><img src="{{ asset('/imagenes/articulos/'.$cat->imagen)}}" alt="{{$cat->nombre}}" height="15px" width="30px" class="img-thumbnail"><?php } ?> </td>
					<td>{{ $cat->estado}}</td>
					<td><?php echo number_format($cat->precio1, 2,',','.'); ?></td>
					<td><?php echo number_format(($cat->precio1*$empresa->tc), 2,',','.'); ?></td>
					<td>
@if($rol->editarticulo==1)					
					<a href="{{URL::action('ArticuloController@edit',$cat->idarticulo)}}"><button class="btn btn-warning btn-sm">Editar</button></a>@endif
	<?php if($cat->estado=="Activo"){ ?><a href="" data-target="#modal-delete-{{$cat->idarticulo}}" data-toggle="modal"><button class="btn btn-danger btn-sm">Alta</button></a>
	<?php }else{ ?><a href="" data-target="#modal-act-{{$cat->idarticulo}}" data-toggle="modal"><button class="btn btn-default btn-sm">Acti.</button></a> <?php } ?>
						<a href="/reportes/kardex/{{$cat->idarticulo}}"><button class="btn btn-success btn-sm"> kardex</button></a>
                      
                     
					</td>
				</tr>
				@include('almacen.articulo.modal')
				@include('almacen.articulo.modalact')
				@endforeach
			</table>
		</div>
		{{$articulos->render()}}
	</div>
</div>
@push ('scripts')
<script>

$(document).ready(function() {    
const cuerpoDelDocumento = document.body;
cuerpoDelDocumento.onload = miFuncion;
function miFuncion() {
 // alert('La página terminó de cargar');
  	document.getElementById('imgcarga').style.display="none"; 
	document.getElementById('principal').style.display=""; 
} 

	$("#btn").click(function(){
		document.getElementById('imgcarga').style.display=""; 
		document.getElementById('principal').style.display="none"; 
	})

});

</script>
@endpush
@endsection