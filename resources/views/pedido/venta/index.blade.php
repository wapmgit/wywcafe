@extends ('layouts.admin')
@section ('contenido')
<div class="row" id="principal">
	<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
	<h3>Lista de Pedidos<a href="/pedido/pedido/create">@if($rol->crearpedido==1) <button class="btn btn-info">Nuevo</button>@endif</h3></a>
	</div>
	<div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">		
		@include('pedido.venta.search')
	</div>
<!--	<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4" align="right">
 @if($rol->importarpedido==1)<a href="/recibir-pedidos"><button class="btn btn-info" id="btn"><i class="fa fa-fw fa-cloud-upload"></i>Sincronizar</button></a>@endif
	</div> -->
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
				
					<th>fecha</th>
					<th>Cliente</th>
					<th>Tipo comp</th>
					<th>Vendedor</th>
					<th>Total</th>
					<th>opciones</th>
				</thead>
               @foreach ($ventas as $ven)
               <?php 
$newdate=date("d-m-Y H:i:s",strtotime($ven->fecha_hora));
    ?>
				<tr <?php if($ven->pweb==1){ echo "style='background-color: #D4E6F1 !important'"; }?>>
					<td><small>	<?php echo $newdate; ?></small></td>
					<td>{{ $ven->nombre}}</td>
					<td><small>	{{ $ven->tipo_comprobante.':'.$ven->serie_comprobante.'-'.$ven->num_comprobante}}</small>	</td>
					<td><small>	{{ $ven->vendedor}}</small>	</td>
					<td><small>	{{ $ven->total_venta}}</small>	</td>
				
					<td>
				
				<a href="{{URL::action('PedidoController@show',$ven->idventa)}}"><button class="btn btn-primary btn-xs">Detalles</button></a>
				@if($rol->anularpedido==1)			<?php if ( $ven->devolu == 0){?><a href="" data-target="#modal-delete-{{$ven->idventa}}" data-toggle="modal"><button class="btn btn-danger btn-xs">Anular</button></a>
<?php } else {?><button class="btn btn-danger btn-xs">Anulada</button><?php } ?>	@endif				
				</td>
				</tr>
						@include('pedido.venta.modaldevolu')
				@endforeach
			</table>
		</div>
		{{$ventas->render()}}
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