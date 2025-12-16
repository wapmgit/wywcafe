@extends ('layouts.admin')
@section ('contenido')
<?php 		$longitud = count($pacientes);
			$array = array();
			foreach($pacientes as $t){
			$arrayidcliente[] = $t->id_cliente;
			}
			$longitudn = count($notasnd);
			$arrayn = array();
			foreach($notasnd as $n){
			$arraynidcliente[] = $n->id_cliente;
			} 			
			for ($i=0;$i<$longitud;$i++){
				for($j=0;$j<$longitudn;$j++){
				if ($arrayidcliente[$i]==$arraynidcliente[$j]){
					$arraynidcliente[$j]=0;
				};
				}
			}			
			?>
	<div class="row">
	<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
		<h3>Listado de Clientes con cuentas por cobrar </a>
		@include('pacientes.cobrar.search')
	</div>
	</div>
 
<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="table-responsive">
			<table class="table table-striped table-bordered table-condensed table-hover">
				<thead>				
					<th>Nombre</th>
					<th>Cedula</th>
			
					<th>Monto</th>
					<th>N/D</th>
					<th>N/C</th>
					<th>Saldo</th>
					<th>Opciones</th>
				</thead>
				<?php $total=$nd=$nc=0; $acumnd=$acumnc=0; ?>
				<tbody>
               @foreach ($pacientes as $cat)
				<tr>
				<?php $nd=$nc=0;?>
					<td><small><small> <?php echo substr( $cat->nombre, 0, 25 ); ?></small></small></td>
					<td><small><small> {{ $cat->cedula}}</small></small> </td>
		
					<td>
					 @foreach ($notas as $not) <?php if($cat->id_cliente==$not->id_cliente){ 
					 if($not->tipo==1){$acumnd=$acumnd+$not->tnotas; $nd=$not->tnotas;}if($not->tipo==2){ $acumnc=$acumnc+$not->tnotas; $nc=$not->tnotas;} }?>
					 @endforeach				
					<?php $total=$total+$cat->acumulado; echo number_format( $cat->acumulado, 2,',','.')." $";?></td>
					<td><?php echo number_format( $nd, 2,',','.')." $";?></td>
					<td><?php echo number_format( $nc, 2,',','.')." $";?></td>
					<td>
					<a href="https://api.whatsapp.com/send/?phone=<?php echo $cat->codpais.$cat->telefono; ?>&text=Hola%20,<?php echo $empresa->nombre ?>,%20te%20recuerda
%20cuenta%20pendiente%20por%20<?php echo number_format((($cat->acumulado+$nd)-$nc), 2,',','.')." $";?>%20.%20Contactanos%20para%20mas%20detalles.%20" target="_blank">
<i class="fa fa-whatsapp"></i>
   </a>
					<?php echo number_format((($cat->acumulado+$nd)-$nc), 2,',','.')." $";?></td>
					<td>
					@if($rol->abonarcxc==1)<a href="{{URL::action('CxcobrarController@show',$cat->id_cliente)}}"><button class="btn btn-info btn-xs">Abono</button></a>@endif
					@if($rol->crearventa==1)<a href="{{URL::action('VentaController@edit',$cat->id_cliente)}}"><button class="btn btn-success btn-xs">Fact.</button></a>@endif
					</td>
				</tr>
				@endforeach
				 @foreach ($notasnd as $not)
				 	<?php for ($i=0;$i<$longitudn;$i++){
						if ($not->id_cliente==$arraynidcliente[$i]){?>
				<tr>
					<td><small><small>{{$not->nombre}}</small></small></td>
					<td><small><small> {{$not->cedula}}</small></small> </td>
				
					<td>			
					</td>
					<td><?php $acumnd=$acumnd+$not->tnotas; echo number_format( $not->tnotas, 2,',','.')." $";?></td>
					<td></td>
					<td>
	<a href="https://api.whatsapp.com/send/?phone=<?php echo $not->codpais.$not->telefono; ?>&text=Hola%20,<?php echo $empresa->nombre ?>,%20te%20recuerda
%20cuenta%20pendiente%20por%20<?php echo number_format(($not->tnotas), 2,',','.')." $";?>%20.%20Contactanos%20para%20mas%20detalles.%20" target="_blank">
<i class="fa fa-whatsapp"></i>
   </a>
					<?php echo number_format(($not->tnotas), 2,',','.')." $";?></td>
					<td>
					@if($rol->abonarcxc==1)<a href="{{URL::action('CxcobrarController@show',$not->id_cliente)}}"><button class="btn btn-info btn-xs">Abono</button></a>@endif
					@if($rol->crearventa==1)<a href="{{URL::action('VentaController@edit',$not->id_cliente)}}"><button class="btn btn-success btn-xs">Fact.</button></a>@endif
					</td>
				</tr>
						<?php }
					} ?>
				@endforeach
				<tr ><td colspan="2"><button type="button" class="btn bg-olive btn-flat margin"><strong><?php echo "Cuentas por Cobrar: ".number_format( $total, 2,',','.')." $";?></strong></button></td>
				<td colspan="2"><button type="button" class="btn btn-warning btn-flat margin"><strong><?php echo "Notas de Debito: ".number_format( $acumnd, 2,',','.')." $";?></strong></button></td>
				<td colspan="2"><button type="button" class="btn btn-primary btn-flat margin"><strong><?php echo "Notas de Credito: ".number_format( $acumnc, 2,',','.')." $";?></strong></button></td>
				</tr>
				</tbody>
			</table>{{$pacientes->render()}}
		</div>
		
	</div>
</div>

@endsection
@push('scripts')
<script>
  
</script>
@endpush
