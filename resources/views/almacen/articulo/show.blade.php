@extends ('layouts.admin')
@section ('contenido')
<?php
$fserver=date('Y-m-d');
if (!empty($ultcompra->fecha_hora)){ $fecha_a=$ultcompra->fecha_hora;}
 if (!empty($ultventa->fecha_emi)){$fechaventa=$ultventa->fecha_emi;}
function dias_transcurridos($fecha_a,$fserver){
$dias = (strtotime($fecha_a)-strtotime($fserver))/86400;
return $dias;
}
?>  
	<h2 align="center">ESTADISTICAS DEL ARTICULO</h2>
  <hr/>
		       <div class="row">
                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
				<div class="table-responsive">
				<table class="table table-striped table-bordered table-condensed table-hover">
				<thead>			
					<th>Codigo</th>
					<th>Nombre</th>					
					<th>Stock</th>
			        <th>Costo$</th>		
					<th>Utilidad</th>
					<th>Iva</th>
					<th>Precio$</th>			
				</thead>
				<tr>
					<td>{{ $articulo->codigo}}</td>
					<td>{{$articulo->nombre}}</td>					
					<td>{{ $articulo->stock}}</td>
					<td><?php echo number_format($articulo->costo, 2,',','.'); ?></td>
					<td><?php echo number_format($articulo->utilidad, 2,',','.'); ?></td>
					<td><?php echo number_format($articulo->iva, 2,',','.'); ?></td>
					<td><?php echo number_format($articulo->precio1, 2,',','.'); ?></td>
				</tr>
			</table>
</div>
            </div>
			<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
			<div align="center">
			 <?php if ($articulo->imagen==""){?> <img src="{{ asset('/imagenes/articulos/ninguna.jpg')}}" alt="{{$articulo->nombre}}" height="50px" width="50px" class="img-circle"><?php }else{ ?><img src="{{ asset('/imagenes/articulos/'.$articulo->imagen)}}" alt="{{$articulo->nombre}}" height="100px" width="100px" class="img-circle"><?php } ?> 
			</div>
			</div>	
            </div></br>
            <div clas ="row">
                <div class="panel panel-primary">
                <div class="panel-body">
                   <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
					<h4  style="background-color: #E6E6E6">Ultima compra</h4>
					<?php  if (!empty($ultcompra->nombre)) {?>
						<label>Proveedor:</label> {{$ultcompra->nombre}}</br>
						<label>Documento: </label> {{$ultcompra->num_comprobante}}</br>
						<label>Fecha: </label> <?php echo date("d-m-Y",strtotime($ultcompra->fecha_hora)); ?></br>
						<label>Cantidad: </label> {{$ultcompra->cantidad}}</br>
						<label>Precio: </label> <?php echo number_format($ultcompra->precio_compra, 2,',','.'); ?> $.</br>
						<label>Desde: </label> <?php  echo dias_transcurridos($fserver,$fecha_a)." Dias."; ?>
					<?php } ?>	
                    </div>
					   <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
					<h4  style="background-color: #E6E6E6">Ultima Venta</h4>
					<?php  if (!empty($ultventa->nombre)) {?>
						<label>Cliente:</label> {{$ultventa->nombre}}</br>
						<label>Documento:</label> {{$ultventa->tipo_comprobante}}-{{$ultventa->num_comprobante}}</br>
						<label>Fecha:</label> <?php echo date("d-m-Y",strtotime($ultventa->fecha_emi)); ?></br>
						<label>Cantidad:</label> {{$ultventa->cantidad}}</br>
						<label>Precio:</label> <?php echo number_format($ultventa->precio_venta, 2,',','.'); ?> $.</br>
						<label>Desde:</label> <?php  echo dias_transcurridos($fserver,$fechaventa)." Dias."; ?>
					<?php } ?>
                    </div>
					<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
					<h4  style="background-color: #E6E6E6">Ajustes Ralizados</h4>
					<table class="table table-striped table-bordered table-condensed table-hover">
					<thead>			
					<th>Tipo ajuste</th>
					<th>Cantidad</th>					
					</thead>
						@foreach($ajustes as $aj)
					<tr>
					<td>{{ $aj->tipo_ajuste}}</td>
					<td><?php echo number_format($aj->cantidad, 2,',','.'); ?></td>					
					</tr>
						@endforeach
						</table>	
                    </div>
					      <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
					<h4  style="background-color: #E6E6E6">Datos de Interes</h4>
						<label>Ventas en Ultimos 30 dias:</label> <?php echo number_format(($analisisventa->cantidad), 2,',','.'); ?> Unds</br>
						<label>Promedio Semanal de Venta:</label> <?php echo number_format(($analisisventa->cantidad/7), 2,',','.'); ?> Unds
							<label>Compras en Ultimos 30 dias:</label> <?php echo number_format(($analisiscompra->cantidad), 2,',','.'); ?> Unds</br>
						<label>Promedio Semanal de Compras:</label> <?php echo number_format(($analisiscompra->cantidad/7), 2,',','	 
				.'); ?> Unds </br></br>
				<label>Utilidad Neta Generada:</label> <?php echo number_format(($util->precio-$util->costo), 2,',','	 
				.'); ?> $.
                    </div>
		
                </div> 
				<div class="row">
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
				<div class="table-responsive">
				<table class="table table-striped table-bordered table-condensed table-hover">
				<thead><td colspan="4" align="center"  style="background-color: #E6E6E6"><strong>Resumen Compras</strong></td></thead>
				<thead>			
					<th>Total Comprado</th>
					<th>Precio Promedio</th>					
					<th>Total Compras</th>					
					<th>Devoluciones</th>					
					</thead>
				<tr>
					<?php  if (!empty($compras->cantidad)) {?>
					<td><?php echo number_format($compras->cantidad,2,',','.');?> Unds.</td>
					<td><?php echo number_format(($compras->precio/$compras->compra), 2,',','.'); ?> $</td>
					<td>{{$compras->compra}}</td>					
					<td><?php echo number_format($devcompras->devocompras,2,',','.');?> Unds.</td>	
					<?php } ?>					
				</tr>
				</table></div>
					</div> 
					<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
					<div class="table-responsive">
				<table class="table table-striped table-bordered table-condensed table-hover">
				<thead><td colspan="4" align="center"  style="background-color: #E6E6E6"><strong>Resumen Ventas</strong></td></thead>
				<thead>			
					<th>Total Vendido</th>
					<th>Precio  venta Promedio</th>					
					<th>Total ventas</th>					
					<th>Devoluciones</th>					
					</thead>
				<tr>
				 <?php if (!empty($ventas->cantidad)){?>
					<td><?php echo number_format( $ventas->cantidad,2,',','.');?> Unds.</td>
					<td><?php echo number_format(($ventas->precio/$ventas->venta), 2,',','.'); ?> $</td>
					<td>{{$ventas->venta}}</td>					
					<td><?php echo number_format($deventas->devoventas,2,',','.');?> Unds.</td>	
				 <?php } ?>					
				</tr>
				</table></div>
					</div> 
				</div>
		               
                </div>		<div class="col-lg-12 col-md-12 col-sm-6 col-xs-12">
                    <div class="form-group" align="center">
					<button type="button" id="regresarpg" class="btn btn-danger" data-dismiss="modal">Regresar</button>
                     <button type="button" id="imprimir" class="btn btn-primary" data-dismiss="modal">Imprimir</button> 
                    </div>
                </div> 
       </div>
	
@endsection
@push ('scripts')
<script>

$(document).ready(function(){
    $('#imprimir').click(function(){
  //  alert ('si');
  document.getElementById('imprimir').style.display="none";
    document.getElementById('regresarpg').style.display="none";
  window.print(); 
  window.location="/almacen/articulo";
    });
	$('#regresarpg').on("click",function(){
		window.location="/almacen/articulo";
		});
});

</script>

@endpush