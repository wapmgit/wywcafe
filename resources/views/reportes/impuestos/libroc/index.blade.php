@extends ('layouts.admin')
<?php $mostrar=0; ?>
 @if(Auth::user()->nivel=="A")
@section ('contenido')
<?php $mostrar=1; ?>
<div class="row" id="search" style="display: true">
	<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
		<h3>Seleccione Vendedor para la consulta</h3>
		@include('reportes.impuestos.libroc.search')
	</div>
</div>
@endsection
@endif
<?php $acum=0;$efe=0;$deb=0;$che=0;$tra=0;

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
$cefe=0;?>
@section('reporte')
<div class="row">
<div class="panel-body">  
<h4 align="center">Libro de Compras</h4>
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
 @include('reportes.impuestos.libroc.empresa')
  </div>
  <?php if($moneda==1){?>
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

					<table width="100%">
					<thead style="background-color: #E6E6E6">
					<th><font size="1"><small>Oper. Nro.</small></font> </th>
					<th><font size="1"><small>Fecha del Documento </small></font></th>
					<th><font size="1"><small>Fecha Recepcion</small></font> </th>
					<th><font size="1"><small>Tipo de Documento</small></font> </th>
					<th><font size="1"><small>Rif</small></font></th>
					<th><font size="1"><small>Nombre o razon Social</small></font></th>
					<th><font size="1"><small>Tipo de Proveedor</small></font></th>
					<th><font size="1"><small>Tipo de Doc. y Numero</small></font></th>
					<th><font size="1"><small>Numero de Control</small></font></th>
					<th><font size="1"><small>Numero de Nota de Debito</small></font></th>
					<th><font size="1"><small>Numero de Nota de Credito</small></font></th>
					<th><font size="1"><small>Numero de Fact. Afect.</small></font></th>
					<th><font size="1"><small>Tipo de Transaccion</small></font></th>
					<th><font size="1"><small>Total Compras incluyendo IVA</small></font></th>
					<th><font size="1"><small>Compras Internas no Gravadas</small></font></th>
					<th><font size="1"><small>Base Imponible</small></font></th>
					<th><font size="1"><small>% Alicuota</small></font></th>
					<th><font size="1"><small>Impuesto I.V.A.</small></font></th>
					<th><font size="1"><small>Nro. Comprobante de Retencion</small></font></th>
					<th><font size="1"><small>Fecha Retencion</small></font></th>
					<th><font size="1"><small>% Retencion</small></font></th>
					<th><font size="1"><small>IVA Retenido(al Vendedor)</small></font></th>
					</thead>
						<?php $ctra= 0; $acumiva=0; $acumret=0; $acumbase=0; $credito=0; $contado=$acumex=0; $count=0;?>
					@foreach ($datos as $q)
						<?php $count++;?> 
							<tr <?php if($mostrar==0){?> style="display:none" <?php } ?> >
							  <td><font size="1"><small><?php echo $count; ?></small></font></td>
							   <td width="5%"><font size="1"><small><?php echo date("d-m-Y",strtotime($q->fecha)); ?></small></font></td>
							   <td width="5%"><font size="1"><small><?php echo date("d-m-Y",strtotime($q->recepcion)); ?></small></font></td>
							   <td><font size="1"><small>{{ $q->tipo}}</small></font></td>
							   <td><font size="1"><small>{{ $q->rif}}</small></font></td>
							  <td width="10%"><font size="1"><small>{{ $q->nombre}}</small></font></td>       
							  <td><font size="1"><small>NAC</small></font></td>       
							  <td><font size="1"><small>{{$q->factura}}</small></font></td> 
							  <td><font size="1"><small>{{$q->control}}</small></font></td> 
							  <td><font size="1"><small></small></font></td> 
							  <td><font size="1"><small></small></font></td> 
							  <td><font size="1"><small></small></font></td> 
							    <td><font size="1"><small>01-Reg</small></font></td>

								<td><font size="1"><small><?php $acum=$acum+ ($q->total*$q->tasa); echo number_format(($q->total*$q->tasa), 2,',','.'); ?></small></font></td>								
								<td><font size="1"><small><?php $acumex=$acumex+ ($q->exento*$q->tasa); echo number_format(($q->exento*$q->tasa), 2,',','.'); ?></small></font></td>
								<td><font size="1"><small><?php $acumbase=$acumbase+($q->base*$q->tasa); echo number_format(($q->base*$q->tasa), 2,',','.'); ?></small></font></td>								
									  <td><font size="1"><small>16 %</small></font></td> 
								<td><font size="1"><small><?php $acumiva=$acumiva+($q->iva*$q->tasa); echo number_format(($q->iva*$q->tasa), 2,',','.'); ?></small></font></td>														  
							  <td colspan="4"><table width="100%" border="0"> @foreach($retenc as $ret)
							  <?php if($q->idingreso == $ret->idcompra){ $acumret=$acumret+($ret->mretd*$q->tasa); $idret=explode("-",$ret->fecha); ?>
							  <tr>
							  <td><font size="1"><small><?php if($ret->afiva==1) { echo $idret[0].$idret[1].add_ceros($ret->correlativo,$ceros); }else { echo add_ceros($ret->correlativo,$ceros); }; ?></small></font></td>
							  <td><font size="1"><small><?php echo date("d-m-Y",strtotime($ret->fecha)); ?></small></font></td>
							  <td><font size="1"><small>{{$ret->ret}}%</small></font></td>
							  <td><font size="1"><small>{{$ret->mretd * $q->tasa}}</small></font></td>
							  </tr>
							  <?php } ?>
							  @endforeach
							  </table></td>							  						
							</tr>    
					@endforeach
							<tr>
								<td colspan="13"> <font size="1"><small><strong>TOTAL TRANSACCIONES: <?php echo $count; ?></strong></small></font></td>
								<td><font size="1"><small><strong><?php echo number_format($acum, 2,',','.')." Bs"; ?></strong></small></font></td>
								<td><font size="1"><small><strong><?php echo number_format($acumex, 2,',','.')." Bs"; ?></strong></small></font></td>
								<td><font size="1"><small><strong><?php echo number_format($acumbase, 2,',','.')." Bs"; ?></strong></small></font></td>
								<td></td>
								<td><font size="1"><small><strong><?php echo number_format($acumiva, 2,',','.')." Bs"; ?></strong></small></font></td>
								<td></td>	<td></td>	<td></td>
								<td><font size="1"><small><strong><?php echo number_format($acumret, 2,',','.')." Bs"; ?></strong></small></font></td>
							</tr>
					</table>
                </div>
                <!-- /.col -->
        
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
                  <p align="center" ><font size="1"><small><b>RESUMEN DEL LIBRO DE COMPRAS</b></small></font></p>

                  <div>
                    <table border="1" width="100%">
                      <tr>
					    <th></th>
                        <th style="width:10%"><font size="1"><small><b>Base Imponible</b></small></font></th>
                        <th style="width:10%"><font size="1"><small><b>Credito Fiscal</b></small></font></th>
                        <th style="width:10%"><font size="1"><small><b>Iva Retenido</b></small></font></th>
                      </tr>
                      <tr>
                        <th><font size="1"><small>Compras exentas y/o sin derecho a crédito fiscal:</small></font></th>
                        <td><font size="1"><small><?php echo number_format($acumex, 2,',','.')." Bs"; ?></small></font></td>
                        <td></td>
                        <td></td>
                      </tr>
						<tr>
                        <th><font size="1"><small>Compras importación afectas solo Alicuota General. 16%:</small></font></th>						 
                        <td></td>
                        <td></td>
                        <td></td>
						</tr>
                      <tr>
                        <th><font size="1"><small>Compras importación afectas en Alicuota General + Adicional. 31%</small></font></th>
                        <td></td>
                        <td></td>
                        <td></td>                       
                      </tr>
					        <tr>
                        <th><font size="1"><small>Compras importación afectas en Alicuota Reducida. 8%</small></font></th>
						<td></td>
                        <td></td>
                        <td></td>
                      </tr>
					        <tr>
                        <th><font size="1"><small>Compras Internas afectas solo Alicuota General. 16% </small></font></th>
                        <td><font size="1"><small><?php echo number_format($acumbase, 2,',','.')." Bs"; ?></small></font></td>
                        <td><font size="1"><small><?php echo number_format($acumiva, 2,',','.')." Bs"; ?></small></font></td>
                        <td><font size="1"><small><?php echo number_format("0", 2,',','.')." Bs"; ?></small></font></td>
                      </tr>
						<tr>
                        <th><font size="1"><small>Compras Internas en Alicuota General + Adicional. 31% </small></font></th>
						<td></td>
                        <td></td>
                        <td></td>
                      </tr>
						<tr>
                        <th><font size="1"><small>Compras Internas en Alicuota Reducida. 8% </small></font></th>
						<td></td>
                        <td></td>
                        <td></td>
                      </tr>					  
					        <tr>
                        <th><font size="1"><small><b>TOTALES</b></th>
                        <td><font size="1"><small><?php echo number_format(($acumbase+$acumex), 2,',','.')." Bs"; ?></small></font></td>
                        <td><font size="1"><small><?php echo number_format($acumiva, 2,',','.')." Bs"; ?></small></font></td>
                        <td><font size="1"><small><?php echo number_format("0", 2,',','.')." Bs"; ?></small></font></td>
                      </tr>
                    </table>
                  </div>
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->
  <?php } else{ ?>
	  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

					<table width="100%">
					<thead style="background-color: #E6E6E6">
					<th><font size="1"><small>Oper. Nro.</small></font> </th>
					<th><font size="1"><small>Fecha del Documento </small></font></th>
					<th><font size="1"><small>Fecha Recepcion</small></font> </th>
					<th><font size="1"><small>Tipo de Documento</small></font> </th>
					<th><font size="1"><small>Rif</small></font></th>
					<th><font size="1"><small>Nombre o razon Social</small></font></th>
					<th><font size="1"><small>Tipo de Proveedor</small></font></th>
					<th><font size="1"><small>Tipo de Doc. y Numero</small></font></th>
					<th><font size="1"><small>Numero de Control</small></font></th>
					<th><font size="1"><small>Numero de Nota de Debito</small></font></th>
					<th><font size="1"><small>Numero de Nota de Credito</small></font></th>
					<th><font size="1"><small>Numero de Fact. Afect.</small></font></th>
					<th><font size="1"><small>Tipo de Transaccion</small></font></th>
					<th><font size="1"><small>Total Compras incluyendo IVA</small></font></th>
					<th><font size="1"><small>Compras Internas no Gravadas</small></font></th>
					<th><font size="1"><small>Base Imponible</small></font></th>
					<th><font size="1"><small>% Alicuota</small></font></th>
					<th><font size="1"><small>Impuesto I.V.A.</small></font></th>
					<th><font size="1"><small>Nro. Comprobante de Retencion</small></font></th>
					<th><font size="1"><small>Fecha Retencion</small></font></th>
					<th><font size="1"><small>% Retencion</small></font></th>
					<th><font size="1"><small>IVA Retenido(al Vendedor)</small></font></th>
					</thead>
						<?php $ctra= 0; $acumiva=0; $acumret=0; $acumbase=0; $credito=0; $contado=$acumex=0; $count=0;?>
					@foreach ($datos as $q)
						<?php $count++;?> 
							<tr <?php if($mostrar==0){?> style="display:none" <?php } ?> >
							  <td><font size="1"><small><?php echo $count; ?></small></font></td>
							   <td width="5%"><font size="1"><small><?php echo date("d-m-Y",strtotime($q->fecha)); ?></small></font></td>
							   <td width="5%"><font size="1"><small><?php echo date("d-m-Y",strtotime($q->recepcion)); ?></small></font></td>
							   <td><font size="1"><small>{{ $q->tipo}}</small></font></td>
							   <td><font size="1"><small>{{ $q->rif}}</small></font></td>
							  <td width="10%"><font size="1"><small>{{ $q->nombre}}</small></font></td>       
							  <td><font size="1"><small>NAC</small></font></td>       
							  <td><font size="1"><small>{{$q->factura}}</small></font></td> 
							  <td><font size="1"><small>{{$q->control}}</small></font></td> 
							  <td><font size="1"><small></small></font></td> 
							  <td><font size="1"><small></small></font></td> 
							  <td><font size="1"><small></small></font></td> 
							    <td><font size="1"><small>01-Reg</small></font></td>

								<td><font size="1"><small><?php $acum=$acum+ ($q->total); echo number_format(($q->total), 2,',','.'); ?></small></font></td>								
								<td><font size="1"><small><?php $acumex=$acumex+ ($q->exento); echo number_format(($q->exento), 2,',','.'); ?></small></font></td>
								<td><font size="1"><small><?php $acumbase=$acumbase+($q->base); echo number_format(($q->base), 2,',','.'); ?></small></font></td>								
									  <td><font size="1"><small>16 %</small></font></td> 
								<td><font size="1"><small><?php $acumiva=$acumiva+($q->iva); echo number_format(($q->iva), 2,',','.'); ?></small></font></td>														  
							  <td colspan="4"><table width="100%" border="0"> @foreach($retenc as $ret)
							  <?php if($q->idcompra == $ret->idcompra){ $acumret=$acumret+($ret->mretd); $idret=explode("-",$ret->fecha); ?>
							  <tr>
							  <td><font size="1"><small><?php if($ret->afiva==1) { echo $idret[0].$idret[1].add_ceros($ret->correlativo,$ceros); }else { echo add_ceros($ret->correlativo,$ceros); }; ?></small></font></td>
							  <td><font size="1"><small><?php echo date("d-m-Y",strtotime($ret->fecha)); ?></small></font></td>
							  <td><font size="1"><small>{{$ret->ret}}%</small></font></td>
							  <td><font size="1"><small>{{$ret->mretd}}</small></font></td>
							  </tr>
							  <?php } ?>
							  @endforeach
							  </table></td>							  						
							</tr>    
					@endforeach
							<tr>
								<td colspan="13"> <font size="1"><small><strong>TOTAL TRANSACCIONES: <?php echo $count; ?></strong></small></font></td>
								<td><font size="1"><small><strong><?php echo number_format($acum, 2,',','.')." $"; ?></strong></small></font></td>
								<td><font size="1"><small><strong><?php echo number_format($acumex, 2,',','.')." $"; ?></strong></small></font></td>
								<td><font size="1"><small><strong><?php echo number_format($acumbase, 2,',','.')." $"; ?></strong></small></font></td>
								<td></td>
								<td><font size="1"><small><strong><?php echo number_format($acumiva, 2,',','.')." $"; ?></strong></small></font></td>
								<td></td>	<td></td>	<td></td>
								<td><font size="1"><small><strong><?php echo number_format($acumret, 2,',','.')." $"; ?></strong></small></font></td>
							</tr>
					</table>
                </div>
                <!-- /.col -->
        
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
                  <p align="center" ><font size="1"><small><b>RESUMEN DEL LIBRO DE COMPRAS</b></small></font></p>

                  <div>
                    <table border="1" width="100%">
                      <tr>
					    <th></th>
                        <th style="width:10%"><font size="1"><small><b>Base Imponible</b></small></font></th>
                        <th style="width:10%"><font size="1"><small><b>Credito Fiscal</b></small></font></th>
                        <th style="width:10%"><font size="1"><small><b>Iva Retenido</b></small></font></th>
                      </tr>
                      <tr>
                        <th><font size="1"><small>Compras exentas y/o sin derecho a crédito fiscal:</small></font></th>
                        <td><font size="1"><small><?php echo number_format($acumex, 2,',','.')." $"; ?></small></font></td>
                        <td></td>
                        <td></td>
                      </tr>
						<tr>
                        <th><font size="1"><small>Compras importación afectas solo Alicuota General. 16%:</small></font></th>						 
                        <td></td>
                        <td></td>
                        <td></td>
						</tr>
                      <tr>
                        <th><font size="1"><small>Compras importación afectas en Alicuota General + Adicional. 31%</small></font></th>
                        <td></td>
                        <td></td>
                        <td></td>                       
                      </tr>
					        <tr>
                        <th><font size="1"><small>Compras importación afectas en Alicuota Reducida. 8%</small></font></th>
						<td></td>
                        <td></td>
                        <td></td>
                      </tr>
					        <tr>
                        <th><font size="1"><small>Compras Internas afectas solo Alicuota General. 16% </small></font></th>
                        <td><font size="1"><small><?php echo number_format($acumbase, 2,',','.')." $"; ?></small></font></td>
                        <td><font size="1"><small><?php echo number_format($acumiva, 2,',','.')." $"; ?></small></font></td>
                        <td><font size="1"><small><?php echo number_format("0", 2,',','.')." $"; ?></small></font></td>
                      </tr>
						<tr>
                        <th><font size="1"><small>Compras Internas en Alicuota General + Adicional. 31% </small></font></th>
						<td></td>
                        <td></td>
                        <td></td>
                      </tr>
						<tr>
                        <th><font size="1"><small>Compras Internas en Alicuota Reducida. 8% </small></font></th>
						<td></td>
                        <td></td>
                        <td></td>
                      </tr>					  
					        <tr>
                        <th><font size="1"><small><b>TOTALES</b></th>
                        <td><font size="1"><small><?php echo number_format(($acumbase+$acumex), 2,',','.')." $"; ?></small></font></td>
                        <td><font size="1"><small><?php echo number_format($acumiva, 2,',','.')." $"; ?></small></font></td>
                        <td><font size="1"><small><?php echo number_format("0", 2,',','.')." $"; ?></small></font></td>
                      </tr>
                    </table>
                  </div>
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->
	
  <?php } ?>
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
  window.location="/informes/libroc";
    });

});

</script>

@endpush
@endsection