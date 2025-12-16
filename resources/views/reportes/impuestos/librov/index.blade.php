@extends ('layouts.admin')
<?php $mostrar=0; ?>
  @if(Auth::user()->nivel=="A")
@section ('contenido')
<?php $mostrar=1; 
?>
<div class="row" id="search" style="display: true">
	<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
		<h3>Seleccione Vendedor para la consulta</h3>
		@include('reportes.impuestos.librov.search')
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
  $recibo=" ";
  for ($i=0;$i<8-$digitos;$i++){
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
<h4 align="center">Libro de Ventas</h4>
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
 @include('reportes.impuestos.librov.empresa')
  </div>
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
  <div >
  <table >
	<tr><td width="5%"></td><td colspan="13"></td><td colspan="4" align="center"><font class="tama"><small>VENTAS A CONTRIBUYENTES</small></font></td>
	</tr>
	<tr><td colspan="14"></td><td colspan="2"><font class="tama1"><small>ALÍCUOTA GENERAL 16%</small></font></td>
	</tr>
  </table>
	<table width="100%" border="1" id="tabla">
		<thead>		
		<tr>					
		<th width="5%"><font class="tama"><small>Oper.Nro.</small></font> </th>
		<th><font class="tama"><small>Fecha del Documento </small></font></th>
		<th><font class="tama"><small>Tipo de Documento</small></font> </th>
		<th><font class="tama"><small>Rif</small></font></th>
		<th><font class="tama"><small>Nombre o razon Social del Cliente</small></font></th>
		<th><font class="tama"><small>Serie</small></font></th>
		<th><font class="tama"><small>Numero de Factura</small></font></th>
		<th><font class="tama"><small>Numero de Control</small></font></th>
		<th><font class="tama"><small>Numero de Nota Debito</small></font></th>
		<th><font class="tama"><small>Numero de Nota Credito</small></font></th>
		<th><font class="tama"><small>Tipo de Transaccion</small></font></th>
		<th><font class="tama"><small>Numero de Factura Afectada</small></font></th>
		<th><font class="tama"><small>Total Ventas Incluyendo el IVA</small></font></th>
		<th><font class="tama"><small>Ventas Internas no Gravadas</small></font></th>
		<th><font class="tama"><small>Base Imponible</small></font></th>
		<th><font class="tama"><small>Impuesto IVA</small></font></th>
		<th><font class="tama"><small>IVA Retenido</small></font></th>
		<th><font class="tama"><small>Nro Comprobante Retencion</small></font></th>
		<th><font class="tama"><small>Fecha de recepcion</small></font></th>
		</tr>
		</thead>
						<?php $ctra= 0; $varfecha="";$print=0; $bc=0; $acumiva=0;$acumex=0; $acumbase=0; $credito=0; $tv=$tiva=0;$contado=0; $count=0;?>
					@foreach ($datos as $q)
						<?php $count++; 
							if($count==1){
						$varfecha=$q->fecha;
					}else{ if($varfecha==$q->fecha) {$print=0; }else{  $print=1;  $varfecha=$q->fecha;} }
						if($q->formato==0){
							$mconiva=truncar(($q->total_iva*1.16),2);
							$mfac=$q->texe+$mconiva;
							$base=$q->total_iva;
							$tiva=truncar(($base*0.16),2);
						}else{
							$mconiva=truncar(($q->mivaf*1.16),2);
							$mfac=$q->texe+$mconiva;
							$base=$q->mivaf;
							$tiva=truncar(($base*0.16),2);
						}
               
							?> 
		<tr <?php if($mostrar==0){?> style="display:none" <?php } ?> >
		  <td align="center"><font class="tama2"><small><?php echo $count; ?></small></font></td>
		   <td><font class="tama2"><small><?php echo date("d-m-Y",strtotime($q->fecha)); ?></small></font></td>
		   <td align="center"><font class="tama2"><small>{{ $q->tipo}}</small></font></td>
		  <td><font class="tama2"><small><?php if($q->anulado==0){ echo $q->rif;} ?></small></font></td>       
		  <td ><font class="tama2"><small><?php if($q->anulado==0){ echo $q->nombre;}else{ echo "Anulado"; }?></small></font></td> 
		  <td><font class="tama2"><small>C</small></font></td> 
		  <td><font class="tama2"><small><?php echo add_ceros($q->factura,$ceros); ?></small></font></td> 
		  <td align="center"><font class="tama2"><small>{{$q->control}}</small></font></td>
		  <td></td>							  
		  <td></td>							  
		  <td><font class="tama2"><small><?php if($q->anulado==0){ echo "01-Reg"; }else{ echo "03-Anu"; } ?></small></font></td>							  
		  <td></td>							  
		  <td><font class="tama2"><small><?php if($q->anulado==0){ $acum=$acum+ $mfac; echo number_format($mfac, 2,',','.');  } else { echo 0; }?></small></font></td>
		  <td><font class="tama2"><small><?php  if($q->anulado==0){ $acumex=$acumex+$q->texe; echo number_format($q->texe, 2,',','.'); } else { echo 0; } ?></small></font></td>
		  <td><font class="tama2"><small><?php if($q->anulado==0){ $acumbase=($acumbase+$base); echo number_format(($base), 2,',','.'); } else { echo 0; } ?></small></font></td>
		  <td><font class="tama2"><small><?php if($q->anulado==0){ $acumiva=$acumiva+$tiva; echo number_format(($tiva), 2,',','.'); }  else { echo 0; }?></small></font></td>
		  <td></td>
		  <td></td>
		  <td></td>
		</tr>  
	@endforeach
	@foreach ($datosb as $q)
									<?php $count++; 	
							?>
		<tr>
		  <td align="center"><font class="tama2"><small><?php echo $count; ?></small></font></td>
		   <td><font class="tama2"><small><?php echo date("d-m-Y",strtotime($q->fecha)); ?></small></font></td>
		   <td align="center"><font class="tama2"><small>{{ $q->tipo}}</small></font></td>
		  <td><font class="tama2"><small>{{ $q->rif}}</small></font></td>       
		  <td ><font class="tama2"><small>{{$q->nombre}}</small></font></td> 
		  <td><font class="tama2"><small>{{$q->serie}}</small></font></td> 
		  <td><font class="tama2"><small>{{$q->factura}}</small></font></td> 
		  <td align="center"><font class="tama2"><small>{{$q->control}}</small></font></td>
		  <td></td>							  
		  <td></td>							  
		  <td><font class="tama2"><small>01-Reg</small></font></td>							  
		  <td></td>							  
		  <td><font class="tama2"><small><?php $acum=$acum+$q->totalventa; echo number_format($q->totalventa, 2,',','.'); ?></small></font></td>
		  <td><font class="tama2"><small><?php $acumex=$acumex+$q->exento; echo number_format($q->exento, 2,',','.'); ?></small></font></td>
		  <td><font class="tama2"><small><?php $acumbase=($acumbase+$q->base); echo number_format(($q->base), 2,',','.'); ?></small></font></td>
		  <td><font class="tama2"><small><?php $acumiva=$acumiva+$q->iva; echo number_format(($q->iva), 2,',','.'); ?></small></font></td>

		</tr>    	
 <td></td>
		  <td></td>
		  <td></td>		
	@endforeach	
		@foreach ($retenc as $r)
									<?php $count++; 	
							?>
		<tr>
		  <td align="center"><font class="tama2"><small><?php echo $count; ?></small></font></td>
		   <td><font class="tama2"><small><?php echo date("d-m-Y",strtotime($r->fecharegistro)); ?></small></font></td>
		   <td align="center"><font class="tama2"><small>RET</small></font></td>
		  <td><font class="tama2"><small>{{ $r->cedula}}</small></font></td>       
		  <td ><font class="tama2"><small>{{$r->nombre}}</small></font></td> 
		  <td><font class="tama2"><small></small></font></td> 
		  <td><font class="tama2"><small></small></font></td> 
		  <td align="center"><font class="tama2"><small></small></font></td>
		  <td></td>							  
		  <td></td>							  
		  <td><font class="tama2"><small>01-Reg</small></font></td>							  
		  <td><font class="tama2"><small><?php echo add_ceros($r->idForma,$ceros); ?></small></font></td>							  
		  <td><font class="tama2"><small></small></font></td>
		  <td><font class="tama2"><small></small></font></td>
		  <td><font class="tama2"><small></small></font></td>
		  <td><font class="tama2"><small></small></font></td>
	<td><font class="tama2"><small><?php $acumret=$acumret+$r->mretbs; echo number_format(($r->mretbs), 2,',','.'); ?></small></font></td>
		  <td><font class="tama2"><small>{{$r->comprobante}}</small></font></td>
		  <td><font class="tama2"><small><?php echo date("d-m-Y",strtotime($r->fecha)); ?></small></font></td>	
		</tr>    	
			
	@endforeach	

	</table>
	<table border="1" id="pie" width="90%">
	<tr>
		<td colspan="12"> <font size="1"><small><strong>TOTAL:</strong></small></font></td>
		<td><font class="tama2"><small><strong><?php echo number_format($acum, 2,',','.').""; ?></strong></small></font></td>
		<td><font class="tama2"><small><strong><?php echo number_format($acumex, 2,',','.').""; ?></strong></small></font></td>
		<td><font class="tama2"><small><strong><?php echo number_format($acumbase, 2,',','.').""; ?></strong></small></font></td>
		<td><font class="tama2"><small><strong><?php echo number_format($acumiva, 2,',','.').""; ?></strong></small></font></td>
	<td><font class="tama2"><small><strong><?php echo number_format($acumret, 2,',','.').""; ?></strong></small></font></td>
		  <td></td>
		  <td></td>
	
	</tr></table>
          
                <!-- /.col -->
              </div>
              <!-- /.row -->

              <div class="row">
                <!-- accepted payments column -->
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4"></br></br></br></br>
				<table width="50%">
				<tr><td><font size="1"><small><b>LEYENDA</b></small></font></td></tr>
				<tr><td><font size="1"><small>01-Reg: REGISTRO</small></font></td></tr>
				<tr><td><font size="1"><small>02-comp: COMPLEMENTO</small></font></td></tr>
				<tr><td><font size="1"><small>03-Anu: ANULACION</small></font></td></tr>
				<tr><td><font size="1"><small>04-Aju: AJUSTE</small></font></td></tr>
				</table>
                </div>
                <!-- /.col -->
                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                  <p align="center" ><font size="1"><small><b>RESUMEN DEL LIBRO DE VENTAS</b></small></font></p>

                  <div>
                    <table width="95%" border="1">
                      <tr>
					    <th></th>
                        <th style="width:10%"><font size="1"><small><b>Base Imponible</b></small></font></th>
                        <th style="width:10%"><font size="1"><small><b>Debito Fiscal</b></small></font></th>
                      </tr>
                      <tr>
                        <th><font size="1"><small>VENTAS INTERNAS NO GRAVADAS:</small></font></th>
                        <td></td>
                        <td></td>
                      </tr>
						<tr>
                        <th><font size="1"><small>Ventas Internas no Gravadas:</small></font></th>						 
                        <td><font size="1"><small><?php echo number_format($acumex, 2,',','.')." Bs"; ?></small></font></td>
                        <td></td>
						</tr>
                      <tr>
                        <th><font size="1"><small>Ventas Internas afectas solo Alicuota General. 16%</small></font></th>
                        <td><font size="1"><small><?php echo number_format($acumbase, 2,',','.')." Bs"; ?></small></font></td>
                        <td><font size="1"><small><?php echo number_format(($acumiva), 2,',','.')." Bs"; ?></small></font></td>
                      </tr>
					        <tr>
                        <th><font size="1"><small>Ventas Internas afectas solo Alicuota General. 31%</small></font></th>
                        <td><font size="1"><small><?php echo number_format($credito, 2,',','.')." Bs"; ?></small></font></td>
                        <td><font size="1"><small><?php echo number_format($credito, 2,',','.')." Bs"; ?></small></font></td>
                      </tr>
					        <tr>
                        <th><font size="1"><small>Ventas Internas afectas solo Alicuota General. 8%</small></font></th>
                        <td><font size="1"><small><?php echo number_format($credito, 2,',','.')." Bs"; ?></small></font></td>
                        <td><font size="1"><small><?php echo number_format($credito, 2,',','.')." Bs"; ?></small></font></td>
                      </tr>
					        <tr>
                        <th><font size="1"><small><b>TOTALES</b></th>
                        <td><font size="1"><small><?php echo number_format($acum, 2,',','.')." Bs"; ?></small></font></td>
                        <td><font size="1"><small><?php echo number_format($acumiva, 2,',','.')." Bs"; ?></small></font></td>
                      </tr>
					  <tr><td colspan="3"><font size="1"><small> <b>TOTAL RETENCIONES:</b> <?php echo number_format($acumret, 2,',','.')." Bs"; ?></small></font></td></tr>
                    </table>
                  </div>
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->

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
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
            
@push ('scripts')
<script>
$(document).ready(function(){
    $('#imprimir').click(function(){
  //  alert ('si');
  document.getElementById('imprimir').style.display="none";
  window.print(); 
  window.location="/informes/librov";
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