@extends ('layouts.admin')
@section ('contenido')
<?php $acum=0; $acum2=0;$cont=0; $diascre=0;?>
<div class="row">
	<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
		<h3>Detalle de Documentos activos para Comision</h3>

	</div>
</div>
	
<div class="row">
	  <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">

                 <div class="form-group">
                      <label for="proveedor">Vendedor</label>
                   <p>{{$vendedor->nombre}}</p>
                    </div>
            </div>
             <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">

                 <div class="form-group">
                      <label for="proveedor">Cedula</label>
                   <p>{{$vendedor->cedula}}</p>
                    </div>
            </div>
             <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">

                 <div class="form-group">
                      <label for="proveedor">Telefono</label>
                   <p>{{$vendedor->telefono}}</p>
                    </div>
            </div>
</div>
    <?php

$fecha_actual= date("Y/m/d");
function dias_pasados($fecha_inicial,$fecha_final)
{
$dias = (strtotime($fecha_inicial)-strtotime($fecha_final))/86400;
$dias = abs($dias); $dias = floor($dias);
return $dias;
}
$fecharecibo="";$pcomi=0; $comireal=0;
?>
<div class="row">
<div class="panel panel-primary">
                <div class="panel-body">
               <div class="modal-content">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="table-responsive">
		{!!Form::model($venta,['method'=>'PATCH','route'=>['comisiones.comision.update',$vendedor->nombre],'files'=>'true'])!!}
            {{Form::token()}}
			<table class="table table-striped table-bordered table-condensed table-hover">
				<thead style="background-color: #A9D0F5">
					<th>Cliente</th>
						<th>Cedula</th>
					<th>Comprobante</th>
					<th>Fecha Emi.</th>
					<th>Ult. Rec.</th>
					<th>Dias</th>
					<th>%Comi</th>
					<th>Monto Fact.</th>
					<th>Comision</th>
					<th>Comi. Fac</th>
					<th>M. Comi.</th>
									
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
					<td><small><small>{{$cat->serie_comprobante}}{{$cat->idventa}}</small></small></td>
					<td><?php echo date("d-m-Y",strtotime($cat->fecha_emi)); ?></td>
					<td>@foreach ($recibos as $re)
					<?php if($re->idventa==$cat->idventa){ $fecharecibo=$re->fecha;}
					?>
					@endforeach
					<?php echo date("d-m-Y",strtotime($fecharecibo)); ?> 
					</td>
					<td><?php $diascre=(dias_pasados($fecharecibo,$cat->fecha_emi)-(int)$cat->diascre);
								if($diascre<= 0){ ?>  <font style="color:#FF0000";><?php $pcomi=100; echo $diascre;?> </font> 
								<?php }else {
				?>@foreach($regla as $re)<?php if(($diascre >=$re->desde)and($diascre <= $re->hasta)){$pcomi=$re->porcentaje;}	
								?>@endforeach<?php
								echo $diascre; }

								?></td>
								<td><?php echo $pcomi ."%"; ?></td>
					<td><?php echo number_format($cat->total_venta, 2,',','.')." $"; ?> </td>
					<td>{{ $cat->comision}}</td>
					<td><?php echo number_format($cat->montocomision, 2,',','.')." $"; ?> </td>		
					<td><?php $comireal=$comireal+(($cat->montocomision*$pcomi)/100); echo number_format((($cat->montocomision*$pcomi)/100), 2,',','.')." $"; ?> </td>		
				</tr>
				@endforeach
				<tr>
				<td colspan="3"><?php echo $cont." Documentos"; ?></td><td></td><td></td><td></td><td><strong>TOTAL:</strong></td>
				<td style="background-color: #A9D0F5"><?php echo number_format($acum2, 2,',','.')." $"; ?> </td><td></td>
				<td style="background-color: #A9D0F5"><?php echo number_format($acum, 2,',','.')." $"; ?> </td><td style="background-color: #A9D0F5"><?php echo number_format($comireal, 2,',','.')." $"; ?></td>
				</tr>
				<tr><td colspan="3">
				<div class="form-group">
				
				<input type="hidden" name="vendedor"  value="{{$vendedor->id_vendedor}}">
				<input type="hidden" name="mventas"  value="<?php echo $acum2; ?>">
				<input type="hidden" name="mcomision"  value="<?php echo $comireal; ?>">
            	@if($rol->comision==1)<button class="btn btn-primary" id="senddoc" type="submit">Generar Comision</button> @endif
            	<a href="/comisiones/comision"><button  class="btn btn-danger" type="button">Regresar</button></a>
            </div></td></tr>
			</table>
			{!!Form::close()!!}	
		</div>
		
	</div>
	</div>
	</div>
	</div>
</div>

@endsection

@push ('scripts')

<script>
$(document).ready(function(){
	 $('#senddoc').click(function(){
	document.getElementById('senddoc').style.display="none"; 
    })
})
	
</script>
@endpush