@extends ('layouts.admin')
<?php $mostrar=0; ?>
  @if(Auth::user()->nivel=="A")
@section ('contenido')
<?php $mostrar=1; $cont=0;
?>
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>
<div class="row" id="search" style="display: true">
	<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
		<h3>Seleccione Sector para la consulta</h3>
		@include('reportes.pedidosectores.search')
	</div>
</div>

@endsection
@endif
<?php $acum=0;$efe=0;$deb=0;$che=0;$tra=0;
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
<div class="row">
<div class="panel-body">
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    @include('reportes.pedidosectores.empresa')
    <h3 align="center">Reporte de Pedidos por Sectores <h3> 
	<h4 align="center"> 
	<?php $saldor=0;  
	if($filtro==0){ echo "Todos los Sectores"; }
	if(($filtro==1)and ($clientes != NULL)){  echo $clientes[0]->nsector; }
	if(($filtro==2) and ($clientes != NULL)){  echo $clientes[0]->nsector; }

	?>
<h4>
  </div>
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
  <div>
<table width="95%">
							<thead style="background-color: #E6E6E6">
								<th width="36%">Cliente</th>
								<th width="8%">Cedula</th>
								<th width="8%">Telefono</th>
								<th width="8%">Documento</th>
								<th width="8%">Monto</th>
								<th width="30%">Direccion</th>
							</thead>
							<?php $total=0; $count=0; ?>
						   @foreach ($clientes as $cat)
						<?php $count++; $agg=0; $rece=0; $saldor=$saldor+$cat->saldoc;?>
							<tr style="background-color: #E8f5e9">
								<td><small><small>{{$cat->nombre}}</small></small></td>
								<td><small><small>{{ $cat->cedula}}</small></small></td>
								<td><small><small>{{ $cat->telefono}}</small></small></td>
								<td><small><small>{{ $cat->tipo_comprobante}}:{{ $cat->serie_comprobante}}-{{ $cat->num_comprobante}}</small></small></td>
								<td><small><small>
								<?php echo number_format( $cat->saldoc,'2',',','.'); ?></small></small></td>
								<td><small><small>{{ $cat->direccion}}</small></small></td>

							</tr>
							@endforeach
							<tr>
							<td colspan="3"><strong>Clientes: </strong><?php echo $count; ?></td>
							<td colspan="3"><strong>Monto Pedido: </strong><?php echo number_format( $saldor,'2',',','.'); ?></td>
							
							</tr>
						</table>
</div>
    </div>

		       
                     <div class="col-lg-12 col-md-12 col-sm-6 col-xs-12">
                    <div class="form-group" align="center"></br>
                     <button type="button" id="imprimir" class="btn btn-primary" data-dismiss="modal">Imprimir</button> 
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
  window.location="/reportes/ruta";
    });
	 	    $("#filtro").on("change",function(){
				
				var variable=$("#filtro").val();					
				if(variable=="municipios"){
			document.getElementById('ids').style.display="none";
			document.getElementById('idm').style.display="";
			
				}
								if(variable=="parroquias"){
			document.getElementById('ids').style.display="";
			document.getElementById('idm').style.display="none";
				}
				 });
});

</script>

@endpush
@endsection