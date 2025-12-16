@extends ('layouts.admin')
@section ('contenido')
<?php $acum=0; $acum2=0;$cont=0; $fecharecibo=""; $diascre=0;?>
    <?php

$fecha_actual= date("Y/m/d");
function dias_pasados($fecha_inicial,$fecha_final)
{
$dias = (strtotime($fecha_inicial)-strtotime($fecha_final))/86400;
$dias = abs($dias); $dias = floor($dias);
return $dias;
}
$pcomi=0; $comireal=0;  $comireal=0;
?>
<div class="row">
	<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
		<h3>Detalle de Documentos Incluidos en Comision  </h3>

	</div>
</div>
	<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
	<table width="100%" BORDER="1">
	<tr><td colspan="4"><small><b>VENDEDOR: </b> </small>{{$vendedor->cedula}}- >{{$vendedor->nombre}} -> {{$vendedor->telefono}}</td></tr>
	<tr><td colspan="2"  width="50%"><small><b>#COMISION: </b> </small>{{$vendedor->id_comision}}</td>
	<td  width="25%"><small><b>FECHA: </b> </small><?php echo date("d-m-Y",strtotime($vendedor->fecha)); ?></td>
	<td> <small><b>MONTO:</b>  </small></br>{{$vendedor->montocomision}} $</td>
	</tr></table>
	</div>
</div>
</br>
<div class="row">
<div class="panel panel-primary">
                <div class="panel-body">
               <div class="modal-content">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="table-responsive">
		
				<table class="table table-striped table-bordered table-condensed table-hover">
				<thead style="background-color: #A9D0F5">
					<th>Cliente</th>
						<th>Cedula</th>
					<th>N° Comprobante</th>
					<th>Fecha Emi.</th>
					<th>Ult. Rec.</th>
						<th>Dias</th>
					<th>%Comi</th>
					<th>Monto Factura</th>
					<th>Comision</th>
					<th>Monto Comision</th>
					<th>Comi-Desc.</th>
					
									
				</thead>
               @foreach ($venta as $cat)
               <?php $cont++;
               $acum2=$cat->total_venta+$acum2; 
			       $acum=$acum+$cat->montocomision; 
               ?>
			   
				<tr>   <div class="form-group">
				<input type="hidden" name="idventa[]"  value="{{$cat->idventa}}"></div>
				<td><small><small>{{$cat->nombre}}</small></small></td>
					<td><small><small>{{$cat->cedula}}</small></small></td>
					<td><small><small>{{$cat->serie_comprobante}}</td>
					<td><small><small><?php echo date("d-m-Y",strtotime($cat->fecha_emi)); ?></small></small></td>
					<td><small><small>@foreach ($recibos as $re)
					<?php if($re->idventa==$cat->idventa){ $fecharecibo=$re->fecha;}
					?>
					@endforeach
					<?php echo date("d-m-Y",strtotime($fecharecibo)); ?> </small></small></td>
							<td><?php $diascre=(dias_pasados($fecharecibo,$cat->fecha_emi)-(int)$cat->diascre);
								if($diascre<= 0){ ?>  <font style="color:#FF0000";><?php $pcomi=100; echo $diascre;?> </font> 
								<?php }else {
				?>@foreach($regla as $re)<?php if(($diascre >=$re->desde)and($diascre <= $re->hasta)){$pcomi=$re->porcentaje;}	
								?>@endforeach<?php
								echo $diascre; }

								?></td>
								<td><?php echo $pcomi ."%"; ?></td>
					<td><small><small><?php echo number_format($cat->total_venta, 2,',','.')." $"; ?> </small></small></td>
					<td>{{ $cat->comision}}</td>
					<td><?php echo number_format($cat->montocomision, 2,',','.'); ?> </td>	
					<td><?php $comireal=$comireal+(($cat->montocomision*$pcomi)/100); echo number_format((($cat->montocomision*$pcomi)/100), 2,',','.')." $"; ?> </td>							
				</tr>
				@endforeach
				<tr>
				<td colspan="4"><?php echo $cont." Documentos"; ?></td><td></td><td></td><td></td><td><strong>TOTAL:</strong></td><td style="background-color: #A9D0F5"><?php echo number_format($acum2, 3,',','.'); ?> </td><td></td><td style="background-color: #A9D0F5"><?php echo number_format($acum, 2,',','.'); ?> </td>
				</tr>
						<tr>
				<td colspan="6"></td><td  colspan="2"><strong>Descuento Regla Comi.:</strong></td>
				<td style="background-color: #A9D0F5"><?php echo number_format(($acum-$vendedor->montocomision), 2,',','.')." $"; ?> </td>
				<td>T. Pagar</td><td style="background-color: #A9D0F5"><?php echo number_format($vendedor->montocomision, 2,',','.')." $"; ?> </td>
				</tr>	
			<tr><td colspan="11" align="center"> <button type="button" id="imprimir" class="btn btn-primary" data-dismiss="modal">Imprimir</button></td></tr>
			</table>

		</div>
		
	</div>
	</div>
	</div>
	</div>
</div>

@push ('scripts')
<script>
$(document).ready(function(){
    $('#imprimir').click(function(){
  //  alert ('si');
  document.getElementById('imprimir').style.display="none";
  window.print();   
  document.getElementById('imprimir').style.display="";
    });

});

</script>

@endpush

@endsection