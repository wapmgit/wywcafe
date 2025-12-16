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
	<div class="col-lg-12 col-md-21 col-sm-12 col-xs-12">
		<h3>Indicar Dias para la consulta</h3>
		@include('reportes.seguimiento.search')
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
<?php 	
	$longitud = count($clientes);
			$array = array();
			foreach($clientes as $t){
			$arrayidcliente[] = $t->id_cliente;
			}
			$longitudn = count($ventas);
			$arrayn = array();
			foreach($ventas as $n){
			$arraynidcliente[] = $n->idcliente;
			} 		
			
			for ($i=0;$i<$longitudn;$i++){
				for($j=0;$j<$longitud;$j++){
				if ($arrayidcliente[$j]==$arraynidcliente[$i]){
					$arrayidcliente[$j]=0;
				};
				}
			}			
			?>
<div class="row" >
<div class="panel-body">
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    @include('reportes.seguimiento.empresa')
    <h3 align="center">Reporte de clientes Sin Ventas en los ultimos {{$query}} dias.<h3> 
	<h4 align="center"> {{$filtro}}.<h4> 
  </div>
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
  <div>
<table width="95%">
							<thead style="background-color: #E6E6E6">
								<th width="36%">Cliente</th>
								<th width="8%">Cedula</th>
								<th width="8%">Telefono</th>
								<th width="8%">Ult. Venta</th>
								<th width="10%">Licencia</th>
								<th width="30%">Direccion</th>
							</thead>
							<?php $total=0; $count=0; ?>
						   @foreach ($clientes as $cat)
						   	<?php $count++; for ($i=0;$i<$longitud;$i++){
						if ($cat->id_cliente==$arrayidcliente[$i]){?>
							<tr style="background-color: #E8f5e9">
								<td><small><small>{{$cat->nombre}}</small></small></td>
								<td><small><small>{{ $cat->cedula}}</small></small></td>
								<td><small><small>{{ $cat->telefono}}</small></small></td>
								<td><small><small><?php echo date("d-m-Y",strtotime($cat->ultventa)); ?>
							</small></small></td>
								<td><small><small>{{ $cat->licencia}}</small></small></td>
								<td><small><small>{{ $cat->direccion}}</small></small></td>

							</tr>
							<?php } 
							} ?>
							
							
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
  document.getElementById('imprimir').style.display="none";
  window.print(); 
  window.location="/reportes/seguimientoclientes";
    });
});

</script>

@endpush
@endsection