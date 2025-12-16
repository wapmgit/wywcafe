@extends ('layouts.admin')
@section ('contenido')
<?php $acum=0; $acum2=0;$cont=0;?>
<div class="row">
		
	<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
		<h3>Detalles de Comisiones Pagadas</h3>
@include('comisiones.comision.search2')
	</div>
</div>

<div class="row">
<div class="panel panel-primary">
                <div class="panel-body">
               <div class="modal-content">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="table-responsive">
		
			<table class="table table-striped table-bordered table-condensed table-hover">
				<thead style="background-color: #A9D0F5">
					<th>#comision</th>
					<th>Vendedor</th>
					<th>Telefono</th>
					<th>monto Faturado</th>
					<th>Monto Comision</th>
					<th>Fecha cierre</th>
					<th>usuario</th>
					<th>Opcion</th>

									
				</thead>
               @foreach ($vendedor as $cat)
               <?php $cont++;
			       $acum=$acum+$cat->montocomision; 
               ?>			   
				<tr>   
					<td>{{$cat->id_comision}}</td>
						<td>{{$cat->nombre}}</td>
							<td>{{$cat->telefono}}</td>
					<td><?php echo number_format($cat->montoventas, 3,',','.')." $"; ?> </td>
					<td><?php echo number_format($cat->montocomision, 3,',','.')." $"; ?> </td>
					<td><?php echo date("d-m-Y",strtotime($cat->fecha)); ?></td>
					<td>{{ $cat->usuario}}</td>
					<td>
					<a href="/comisiones/comision/detallecomision/<?php echo $cat->id_comision;?>"><button  class="btn btn-primary">Ver detalles</button></a>
	<a href="/comisiones/comision/listarecibos/<?php echo $cat->id_comision."_B";?>"><button class="btn btn-info">Ver Recibos</button></a>
	</td>		
				</tr>
				@endforeach
				<tr>
				<td><?php echo $cont." Comisiones"; ?></td><td></td><td></td><td><strong>TOTAL:</strong></td><td style="background-color: #A9D0F5"><?php echo number_format($acum, 3,',','.')." $"; ?></td><td></td><td> </td><td></td>
				</tr>
				<tr><td colspan="3">
			</td></tr>
			</table>

		</div>
		
	</div>
	</div>
	</div>
	</div>
</div>
@endsection
@push ('scripts')
<script>
</script>
@endpush