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
		<h3>Seleccione Vendedor para la consulta</h3>
		@include('reportes.clientesectores.search')
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
    @include('reportes.clientesectores.empresa')
    <h3 align="center">Reporte de clientes por Sectores <h3> 
	<h4 align="center"> @foreach ($clientes as $cat) 
	<?php $saldor=0;  if($cont==0){echo $cat->nsector; } $cont++;?>
	@endforeach<h4>
  </div>
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
  <div>
<table width="95%">
							<thead style="background-color: #E6E6E6">
								<th width="36%">Cliente</th>
								<th width="8%">Cedula</th>
								<th width="8%">Telefono</th>
								<th width="8%">Saldo</th>
								<th width="10%">Licencia</th>
								<th width="30%">Direccion</th>
							</thead>
							<?php $total=0; $count=0; ?>
						   @foreach ($clientes as $cat)
						<?php $count++; $agg=0; $rece=0; $saldor=$cat->saldoc;?>
							<tr style="background-color: #E8f5e9">
								<td><small><small>{{$cat->nombre}}</small></small></td>
								<td><small><small>{{ $cat->cedula}}</small></small></td>
								<td><small><small>{{ $cat->telefono}}</small></small></td>
								<td><small><small>
								@foreach($notas as $n)
								<?php if($n->idcliente==$cat->id_cliente){ $saldor=$saldor+$n->deuda;}?>
								@endforeach
								<?php echo number_format( $saldor,'2',',','.'); ?></small></small></td>
								<td><small><small>{{ $cat->licencia}}</small></small></td>
								<td><small><small>{{ $cat->direccion}}</small></small></td>

							</tr>
							@endforeach
							<tr><td colspan="6"><strong>Clientes: </strong><?php echo $count; ?></td>
							
							</tr>
						</table>
</div>
    </div>

		       
                     <div class="col-lg-12 col-md-12 col-sm-6 col-xs-12">
                    <div class="form-group" align="center">
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