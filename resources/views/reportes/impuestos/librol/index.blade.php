@extends ('layouts.admin')
<?php $mostrar=0; ?>
  @if(Auth::user()->nivel=="A")
@section ('contenido')
<?php $mostrar=1; 
?>
<div class="row" id="search" style="display: true">
	<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
		<h3>Seleccione Fecha para la consulta</h3>
		@include('reportes.impuestos.librol.search')
	</div>
</div>

@endsection
<style>
table {
    table-layout: fixed;   
    width: 100% !important;
}
#tabla {
  width: 90%;
}
#pie {
  width: 90%;    
  margin: 0 auto;
}
#cabeza {
  width: 90%;
    margin: 0 auto;
}
.dataTables_scrollHeadInner {
  margin: 0 auto;
}
</style>
@endif
<?php $acum=0;$base=0;$deb=0;$che=0;$tra=0; $mconiva=0;
$cefe=0; $acumvacio=0; $mfac=0; $acumret=0; ?>
@section('reporte')

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
$ceros=5;
function add_ceros($numero,$ceros) {
  $numero=$numero;
$digitos=strlen($numero);
  $recibo="C";
  for ($i=0;$i<7-$digitos;$i++){
    $recibo=$recibo."0";
  }
return $insertar_ceros = $recibo.$numero;
};
function truncar($numero, $digitos)
{
    $truncar = 10**$digitos;
    return intval($numero * $truncar) / $truncar;
}
?>
<style>
.tama{
  font: 8px Verdana, sans-serif;
  font-weight: bold; 
}
.tama1{
  font: 7px Verdana, sans-serif;
  font-weight: bold; 
}
.tama2{
  font: 7px Verdana, sans-serif;

}
</style>
<div class="row">
<div class="panel-body">  
<h4 align="center">Libro de Licores</h4>
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
 @include('reportes.impuestos.librol.empresa')
  </div>
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">

			<table  border="1">
	<tbody>	<thead>	
		<tr>
			<td colspan="12" align="center"><font class="tama1">ENTRADA</font></td>
		</tr>	</thead>	
			
		<tr>
			<td colspan="3" align="center"><font class="tama">Guia</font></td>
			<td rowspan="2"><font class="tama">Expedidor</font></td>
			<td colspan="2" align="center"><font class="tama">Procedencia</font></td>
			<td rowspan="2"><font class="tama">Denominacion Comercial</font></td>
			<td rowspan="2"><font class="tama">Clase de Especie</font></td>
			<td rowspan="2"><font class="tama">Grados GL</font></td>
			<td colspan="2" align="center"><font class="tama">Unidades</font></td>
			<td rowspan="2"><font class="tama">Total Litros</font></td>
		</tr>
	
		<tr>
			<td><font class="tama">Fecha</font></td>
			<td><font class="tama">Numero</font></td>
			<td><font class="tama">Fecha de Ingreso</font></td>
			<td align="center"><font class="tama">NAC.</font></td>
			<td align="center"><font class="tama">IMP.</font></td>
			<td><font class="tama">Cant.</font></td>
			<td><font class="tama">Capac.</font></td>
		</tr>
		@foreach($datos as $dat)
			<tr>
			<td><font class="tama1"><small><?php echo date("d-m-Y",strtotime($dat->emision)); ?></small></font></td>
			<td><font class="tama1"><small>{{$dat->serie_comprobante}}</small></font></td>
			<td><font class="tama1"><?php echo date("d-m-Y",strtotime($dat->fecha_hora)); ?></small></font></td>
			<td><font class="tama1"><small>{{$dat->nombre}}</small></font></td>
			<td align="center"><font class="tama1"><?php  if($dat->origen=="N"){echo "X";}?></font></td>
			<td align="center"><font class="tama1"><?php  if($dat->origen=="I"){echo "X";}?></font></td>
			<td><font class="tama1"><small>{{$dat->articulo}}</small></font></td>
			<td><font class="tama1"><small>{{$dat->clase}}</small></font></td>
			<td><font class="tama1"><small>{{$dat->grados}}</small></font></td>
			<td><font class="tama1"><small>{{$dat->cantidad}}</small></font></td>
			<td><font class="tama1"><small>{{$dat->volumen}}</small></font></td>
			<td><font class="tama1"><?php echo $dat->volumen*$dat->cantidad; ?></font></td>
		</tr>
		@endforeach
	</tbody>
</table>
    <!-- /.col -->
    </div>
<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
<table border="1">
	<tbody><thead>
			<tr>
			<td colspan="12" align="center"><font class="tama1">SALIDAS</font></td>
		</tr>
		</thead>
				
		<tr>
			<td colspan="2" align="center"><font class="tama">Guia</font></td>
			<td rowspan="2"><font class="tama">Destinatario</font></td>
			<td rowspan="2"><font class="tama">Destino</font></td>
			<td rowspan="2"><font class="tama">Denominacion Comercial</font></td>
			<td rowspan="2"><font class="tama">Clase de Especie</font></td>
			<td colspan="2" align="center"><font class="tama">Procedencia</font></td>
			<td rowspan="2" align="center"><font class="tama">Grados °GL</font></td>
			<td colspan="2" align="center"><font class="tama">Unidades</font></td>
			<td rowspan="2"><font class="tama">Total Litros</font></td>
		</tr>
		
		<tr>
			<td><font class="tama">Fecha</font></td>
			<td><font class="tama">N° Factura.</font></td>

			<td align="center"><font class="tama">NAC.</font></td>
			<td align="center"><font class="tama">IMP.</font></td>
			<td><font class="tama">Cant.</font></td>
			<td><font class="tama">Capac.</font></td>
		</tr>
				@foreach($datosb as $da)
			<tr>
			<td align="center"><font class="tama1"><small><?php echo date("d-m-Y",strtotime($da->fecha_fac)); ?></small></font></td>
			<td align="center"><font class="tama1"><small><?php $idv=$da->venta; echo add_ceros($idv,$ceros); ?></small></font></td>
			<td><font class="tama1"><small>{{$da->nombre}}</small></font></td>
			<td><font class="tama1"><small>{{$da->direccion}}, Mérida</small></font></td>
			<td><font class="tama1"><small>{{$da->articulo}}</small></font></td>
			<td align="center"><font class="tama1"><small>{{$da->clase}}</small></font></td>
			<td align="center"><font class="tama1"><?php  if($da->origen=="N"){echo "X";}?></font></td>
			<td align="center"><font class="tama1"><?php  if($da->origen=="I"){echo "X";}?></font></td>			
			<td align="center"><font class="tama1"><small>{{$da->grados}}</small></font></td>
			<td align="center"><font class="tama1"><small>{{$da->cantidad}}</small></font></td>
			<td align="right"><font class="tama1"><small>{{$da->volumen}}</small></font></td>
			<td align="right"><font class="tama1"><?php echo $da->volumen*$da->cantidad; ?></font></td>
		</tr>
		@endforeach
	</tbody>
</table>
</div>
              <!-- this row will not appear when printing -->
              <div class="row no-print">
                <div class="col-12">
				<label></label>  
                </div>
              </div>
				<div class="col-lg-12 col-md-12 col-sm-6 col-xs-12">
                    <div class="form-group" align="center">
                     <button type="button" id="imprimir" class="btn btn-primary btn-sm" data-dismiss="modal">Imprimir</button>
                    </div>
                </div>
				
				
  </div>
            </div>
            <!-- /.invoice -->
          </div><!-- /.col -->
       
           
@push ('scripts')
<script>
$(document).ready(function(){
    $('#imprimir').click(function(){
  //  alert ('si');
  document.getElementById('imprimir').style.display="none";
  window.print(); 
  window.location="/informes/licores";
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