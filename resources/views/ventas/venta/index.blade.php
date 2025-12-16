@extends ('layouts.admin')
@section ('contenido')
@include('almacen.articulo.empresa')
	<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<h3>Listado de Ventas<a href="/ventas/venta/create">	@if($rol->crearventa==1) <button class="btn btn-info ">Nuevo</button>@endif</h3></a>
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
					<th>Vendedor</th>
					<th>Opciones</th>
				</thead>
               @foreach ($ventas as $ven)
               <?php 
$newdate=date("d-m-Y",strtotime($ven->fecha_hora));
    ?>
				<tr>
					<td><small><?php echo $newdate; ?></small></td>
					<td><small>{{ $ven->nombre}}</small></td>
					<td><small><?php if ($ven->forma==0){ echo "NOT";}else{ echo "FAC";}?>-{{ $ven->serie_comprobante.'-'.$ven->num_comprobante}}<?php if ($ven->forma==1){ echo " *";} ?> </small></td>
					<td>{{ $ven->total_venta}}</td>
					<td><small>{{ $ven->vendedor}}</small></td>
				
					<td>
				   <div class="btn-group">
                  <button type="button" class="btn btn-primary btn-xs">Detalles</button>
                  <button type="button" class="btn btn-primary dropdown-toggle btn-xs" data-toggle="dropdown">
                    <span class="caret"></span>
                  </button>
                  <ul class="dropdown-menu" role="menu">
                    <li><a href="{{URL::action('VentaController@show',$ven->idventa)}}">Diseño Carta</a></li>
                    <li><a href="/ventas/recibo/{{$ven->idventa}}">Modo Tikect</a></li>
                 <?php if (($ven->forma==1)and($ven->formato==1)){?>   <li><a href="/ventas/formalibre/{{$ven->idventa}}_1">Forma Libre 1%</a></li> <?php }  ?>
                 <?php if (($ven->forma==1)and($ven->formato==0)){?>   <li><a href="/ventas/formalibre/{{$ven->idventa}}_0">Forma Libre</a></li> <?php }  ?>
                  </ul>
                </div>					
              	@if($rol->anularventa==1)    <?php if ( $ven->devolu == 0){?><a href="{{URL::action('ReportesController@show',$ven->idventa)}}"   ><button class="btn btn-danger btn-xs">Devolu.</button></a><?php } else {?><button class="btn btn-warning btn-xs">Devuelta</button><?php } ?>
							@endif
					</td>
				</tr>
		
				@endforeach
			</table>
		</div>
		{{$ventas->render()}}
	</div>
</div>

@endsection