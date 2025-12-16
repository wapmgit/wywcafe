@extends ('layouts.admin')
@section ('contenido')
<?php $acum=0; $idv=0;
$ceros=5;  $acumnc=0;
function add_ceros($numero,$ceros) {
  $numero=$numero;
$digitos=strlen($numero);
  $recibo=" ";
  for ($i=0;$i<8-$digitos;$i++){
    $recibo=$recibo."0";
  }
return $insertar_ceros = $recibo.$numero;
};
?>
@include('almacen.articulo.empresa')
	<div class="row">
	<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
		<h3>Ventas Forma Libre<a href="/ventas/ventaf/create"> 	@if($rol->crearfl==1)<button class="btn btn-info">Nuevo</button>@endif</h3></a>
		@include('ventas.ventaf.search')
	</div>
	<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12"></br><div align="right">
	@if($rol->importarfl==1)<a href="/ventasf/indeximportar"> <button class="btn btn-success btn-xs">Importar</button></h3></a>@endif</div>
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
					<th>Control</th>
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
					<td><small>{{$ven->tipo_comprobante}}-{{ $ven->serie_comprobante.'-'.$ven->num_comprobante}} </small></td>
					<td><small><?php $idv=$ven->control; echo add_ceros($idv,$ceros); ?></small></td>
					<td>{{ $ven->total_venta}}</td>
					<td><small>{{ $ven->vendedor}}</small></td>
				
					<td>
                 <?php if (($ven->forma==1)and($ven->formato==1)){?>  <a href="/ventasf/formalibre/{{$ven->idventa}}_1"><button type="button" class="btn btn-primary btn-xs">Detalle</button> </a><?php }  ?>
                 <?php if (($ven->forma==1)and($ven->formato==0)){?>   <a href="/ventasf/formalibre/{{$ven->idventa}}_0"><button type="button" class="btn btn-primary btn-xs">Detalle</button></a> <?php }  ?>
              			
                	@if($rol->anularfl==1)      <?php if ( $ven->devolu == 0){?><a href="/ventasf/anular/{{$ven->idventa}}"   ><button class="btn btn-danger btn-xs">Anular</button></a><?php } else {?><button class="btn btn-warning btn-xs">Anulado</button><?php } ?>@endif
					</td>
				</tr>
		
				@endforeach
			</table>
		</div>
		{{$ventas->render()}}
	</div>
</div>

@endsection