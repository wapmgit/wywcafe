@extends ('layouts.admin')
@section ('contenido')
<?php 		$longitud = count($proveedores);
			$array = array();
			foreach($proveedores as $t){
			$arrayidcliente[] = $t->idproveedor;
			}
			$longitudn = count($gastos);
			$arrayn = array();
			foreach($gastos as $n){
			$arraynidcliente[] = $n->idproveedor;
			} 			
			for ($i=0;$i<$longitud;$i++){
				for($j=0;$j<$longitudn;$j++){
				if ($arrayidcliente[$i]==$arraynidcliente[$j]){
					$arraynidcliente[$j]=0;
				};
				}
			}			
			?>
<?php $acumnd=$tmonto=$acumnc=0;?>
	<div class="row">
	<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
		<h3>Listado de Proveedores con cuentas por Pagar </a>
		@include('proveedores.pagar.search')
	</div>
</div>
<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="table-responsive">
			<table class="table table-striped table-bordered table-condensed table-hover">
				<thead>
					
					<th>Nombre</th>
					<th>Rif</th>
					<th>Telefono</th>
					<th>Monto</th>
					<th>Opciones</th>
				</thead>
               @foreach ($proveedores as $cat)
			   <?php $tmonto=($tmonto+$cat->acumulado);$acumnc=0;?>
				<tr>
					
					<td>{{ $cat->nombre}}</td>
					<td>{{ $cat->rif}}</td>
					<td>{{ $cat->telefono}}</td>
					 @foreach ($gastos as $not) <?php if($cat->idproveedor==$not->idproveedor){ 
					 $acumnd=$acumnd+$not->tpendiente; $acumnc=$not->tpendiente; }?>
					 @endforeach	
					<td><?php echo number_format(($cat->acumulado+$acumnc), 2,',','.')." $"; ?></td>
					<td>
				<a href="{{URL::action('CxpagarController@show',$cat->idproveedor)}}"><button class="btn btn-info">Abono</button></a>
				<a href="{{URL::action('IngresoController@edit',$cat->idproveedor)}}"><button class="btn btn-success">Facturar</button></a>
                  
					</td>
				</tr>
				@endforeach
				@foreach ($gastos as $not)
				 	<?php for ($i=0;$i<$longitudn;$i++){
						if ($not->idproveedor==$arraynidcliente[$i]){?>
				<tr>
					<td>{{$not->nombre}}</td>
					<td>{{$not->rif}}</td>
					<td>{{$not->telefono}}</td>
					<td><?php $acumnd=$acumnd+$not->tpendiente; echo number_format( $not->tpendiente, 2,',','.')." $";?></td>
					<td>
					<a href="{{URL::action('CxpagarController@show',$not->idproveedor)}}"><button class="btn btn-info">Abono</button></a>
					<a href="{{URL::action('IngresoController@edit',$not->idproveedor)}}"><button class="btn btn-success">Facturar</button></a>
					</td>
				</tr>
						<?php }
					} ?>
				@endforeach
				<tr><td colspan="2"> <button class="btn bg-olive btn-flat margin"><strong>Cuentas por Pagar: <?php echo number_format($tmonto,2,',','.')." $"; ?> </strong></button></td>
				<td colspan="2"><button type="button" class="btn btn-primary btn-flat margin"><strong><?php echo "Gastos: ".number_format( $acumnd, 2,',','.')." $";?></strong></button></td>
				<td><button type="button" class="btn btn-warning btn-flat margin"><strong><?php echo "Total: ".number_format( ($acumnd+$tmonto), 2,',','.')." $";?></strong></button></td>
				</tr>
			
			</table>
		</div>
		{{$proveedores->render()}}
	</div>
</div>

@endsection