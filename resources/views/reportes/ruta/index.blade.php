@extends ('layouts.admin')
<?php $mostrar=0; ?>
  @if(Auth::user()->nivel=="A")
@section ('contenido')
<?php $mostrar=1; 
?>
<div class="row" id="search" style="display: true">
	<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
		<h3>Seleccione Vendedor para la consulta</h3>
		@include('reportes.ruta.search')
	</div>
</div>

@endsection
@endif
<?php $acum=0;$efe=0;$deb=0;$che=0;$tra=0;
$cefe=0; $acumvacio=0;?>
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
    @include('reportes.ruta.empresa')
    <h3 align="center">Clientes Ruta {{$ruta}}</h3> 
    <h5 align="center"> {{$fecha_actual}}</h5> 
  </div>
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
  <div>
<table width="95%">
							<thead style="background-color: #E6E6E6">
								<th>Cliente</th>
								<th>Cedula</th>
								<th>Telefono</th>
								<th>Direccion</th>

								<th>Visita</th>
							</thead>
							<?php $total=0; $count=0; ?>
						   @foreach ($datos as $cat)
						<?php $count++; $agg=0; $rece=0;?>
							<tr style="background-color: #E8f5e9">
								<td><small><small>{{$cat->nombre}}</small></small></td>
								<td><small><small>{{ $cat->cedula}}</small></small></td>
								<td><small><small>{{ $cat->telefono}}</small></small></td>
								<td><small><small>{{ $cat->direccion}}</small></small></td>
								<td>___________</td>
							</tr>
		@foreach	($mov as $m)
									<?php if($cat->id_cliente == $m->id_persona){ $acumvacio= $acumvacio+ $m->debe; ?>						
							<tr border="0" style="line-height:70%"><td>-- <small><small>{{$m->nombre}}</small></small></td>
							<td align="center"><small>Debe: {{$m->debe}}</small></td>
							<td align="center"><small>Debo: {{$m->debo}}</small></td>
							<td align="center"><small>Rec:  ___  </small></td>
							<td align="center"><small>Ent: ___  </small></td></tr><?php } ?> @endforeach							
					@endforeach
							<tr>
							<td colspan="3"><strong>Clientes: </strong><?php echo $count; ?></td>
							<td ></td>
							
							</tr>
						</table>
</div>
    </div>

		       
                     <div class="col-lg-12 col-md-12 col-sm-6 col-xs-12">
					   <label>Usuario: </label>  {{ Auth::user()->name }}  
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

});

</script>

@endpush
@endsection