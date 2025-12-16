@extends ('layouts.admin')
<?php $mostrar=0; ?>
  @if(Auth::user()->nivel=="A")
@section ('contenido')
<?php $mostrar=1; ?>

<div class="row" id="search" style="display: true">
	<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
		<h3>Seleccione Vendedor para la consulta</h3>
		@include('reportes.cobrar.search')
	</div>
</div>

@endsection
@endif
<?php $acum=0;$efe=0;$deb=0;$che=0;$tra=0; $acummn=0;
$cefe=0;?>
@section('reporte')
<div class="row">
            <div class="col-md-12">
              <div class="box">
                <div class="box-header with-border">
                  <h3 class="box-title">Sistema de Ventas SysVent@s</h3>
                  <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    
                    <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                  </div>
                </div>
              </div>
            </div>
</div>
    <?php
// fecha 1
$fecha_dada= "1985/08/28";
// fecha actual
$fecha_actual= date("Y/m/d");

function dias_pasados($fecha_inicial,$fecha_final)
{
$dias = (strtotime($fecha_inicial)-strtotime($fecha_final))/86400;
$dias = abs($dias); $dias = floor($dias);
return $dias;
}
?>
<div class="row">
<div class="panel-body">
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    @include('reportes.cobrar.empresa')
    <h3 align="center">Reporte de Clientes con cuentas por cobrar <?php if ($auxiliar==1){ echo "Resumen"; }?>  </h3> 
  </div>
  <?php if ($auxiliar==1){?>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
  <div class="table-responsive">
<table class="table table-striped table-bordered table-condensed table-hover">
							<thead style="background-color: #E6E6E6">
								<th>Cliente</th>
								<th>Rif</th>
								<th>Telefono</th>
								<th>Vendedor</th>
								<th>Monto</th>
								
							</thead>
							<?php $total=0; $count=0; $n=0; $diascre=0;?>
						   @foreach ($cuenta as $cat)	
							<?php $n=0;?>						   
							<tr>
								<td>{{ $cat->nombre}}</td>
								<td>{{ $cat->cedula}}</td>
								<td>{{ $cat->telefono}}</td>
								<td>{{ $cat->vendedor}}</td>		
								<td>
								@foreach ($notasnd as $nd)
								<?php if($nd->id_cliente==$cat->id_cliente){
								 $total=$total+$nd->tnotas;	$n=$nd->tnotas;}?> 
								@endforeach
								<?php $count++; $total=$total+$cat->acumulado; 				
								echo number_format( ($cat->acumulado+$n), 2,',','.')." $"; ?></td>
							</tr>
							@endforeach
							<tr><td>Documentos: <?php echo $count; ?></td>
							<td colspan="2"></td><td><strong>Total:</strong></td><td><strong><?php echo number_format( $total, 2,',','.')." $"; ?></strong></td>
							</tr>
						</table>
</div>
    </div>
  <?php } else { ?>
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
  <div class="table-responsive">
<table class="table table-striped table-bordered table-condensed table-hover" id="tabla">
							<thead style="background-color: #E6E6E6">
								<th>Documento</th>
								<th>Cliente</th>
								<th>Rif</th>
								<th>Telefono</th>
								<th>Vendedor</th>
								<th>Fecha Emi.</th>
								<th>dias.Venc.</th>
								<th>Monto</th>
								
							</thead>
							<?php $total=0; $count=0;  $diascre=0; $p=0; ?>	
						   @foreach ($pacientes as $cat)<?php $p++; $cntnc=0; ?>
						
							<tr>
								<td>{{$cat->serie_comprobante}}-{{$cat->num_comprobante}}</td>
								<td>{{ $cat->nombre}}
								@foreach ($nc as $c)							
								<?php if (($c->id_cliente==$cat->id_cliente)and ($cntnc==0)){																						
								echo " <strong>* N/C: ".number_format($c->tnc,2,',','.')." *</strong>";							
								 } ?>		
								 @endforeach	
								</td>
								<td>{{ $cat->cedula}}</td>
								<td>{{ $cat->telefono}}</td>
								<td>{{ $cat->vendedor}}</td>
								<td><?php echo date("d-m-Y",strtotime($cat->fecha_hora)); ?></td>
								<td><?php $diascre=((int)$cat->diascre-dias_pasados($fecha_actual,$cat->fecha_hora));
								if($diascre <= 0){ ?>  <font style="color:#FF0000";><?php echo $diascre;?> </font> 
								<?php }else { echo $diascre; }

								?></td>
								<td><?php $count++; $total=$total+$cat->acumulado; echo number_format( $cat->acumulado, 2,',','.')." $"; ?></td>
							</tr>
							
							@endforeach
						@foreach ($notasnd as $nd)
						<tr>
						<?php $acummn=$acummn+$nd->tnotas; ?>
						<td>N/D-{{$nd->idnota}}</td>
						<td>{{$nd->nombre}}</td>
						<td>{{$nd->cedula}}</td>
						<td></td>
						<td></td>
						<td><?php echo date("d-m-Y",strtotime($nd->fecha)); ?></td>
						<td></td>
						<td><?php echo number_format($nd->tnotas, 2,',','.'); ?></td>
						</tr> 
								@endforeach
						</table>

						
</div>
    </div>
	  <div class="col-lg-12 col-md-12 col-sm-6 col-xs-12" align="center">
	<tr><td>Documentos: <?php echo $count; ?></td>	 <td colspan="5"></td><td><strong>Total:</strong></td><td><strong><?php echo number_format( ($total+$acummn), 2,',','.')." $"; ?></strong></td>
							</tr>
	  </div>
<?php } ?>
		       
                     <div class="col-lg-12 col-md-12 col-sm-6 col-xs-12">
					   <label>Usuario: </label>  {{ Auth::user()->name }}  
                    <div class="form-group" align="center">
                     <button type="button" id="imprimir" class="btn btn-primary" data-dismiss="modal">Imprimir</button> 
										 <?php if ($vende<>0){?>
					 <a href="/cxc/excel/<?php echo $vende; ?>"><buton class="btn btn-success"> EXCEL</bunton></a> <?php } ?>
                    </div>
                </div>
                   
</div><!-- /.box-body -->
</div><!-- /.box -->
             

@push ('scripts')
<script>
$(document).ready(function(){
    $('#imprimir').click(function(){
  //  alert ('si');
  document.getElementById('imprimir').style.display="none";
  window.print(); 
  window.location="../reportes/cobrar";
    });
	  $('#tabla').DataTable({
		searching: false,
		   bInfo: false,
	     paging: false,
		 scrollCollapse: false

  });	
	  var table = $('#tabla').DataTable();
  $(window).on('resize', function() {
    $('#tabla').css('width', '90%');
  });
});

</script>

@endpush
@endsection