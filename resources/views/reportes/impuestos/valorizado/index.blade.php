@extends ('layouts.admin')
<?php $mostrar=0; ?>
 @if(Auth::user()->nivel=="A")
@section ('contenido')
<?php $mostrar=1; ?>
<div class="row">
		@include('reportes.impuestos.valorizado.search')
</div>

<?php $acum=0;$efe=0;$deb=0;$che=0;$tra=0;
$cefe=0;?>
@endsection
@endif
@section('reporte')
<div class="row">
	<div class="col-md-12">
		<div class="box">
			<div class="box-body" style="background-color: #fff">
	  <?php $mes="";
	  if($searchText=="01"){$mes="Enero";} if($searchText=="02"){$mes="Febrero";} if($searchText=="03"){$mes="Marzo";} 
	  if($searchText=="04"){$mes="Abril";} if($searchText=="05"){$mes="Mayo";} if($searchText=="06"){$mes="Junio";} 
	  if($searchText=="07"){$mes="Julio";} if($searchText=="08"){$mes="Agosto";} if($searchText=="09"){$mes="Septiembre";} 
	  if($searchText=="10"){$mes="Octubre";} if($searchText=="11"){$mes="Noviembre";} if($searchText=="12"){$mes="Diciembre";} 
	  
	  ?> @include('reportes.impuestos.valorizado.empresa')		
		 <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<table style="line-height:65%" border="0" width="98%" >
				<thead>
					<tr><td></td><td></td><td></td><td colspan="6" align="center" style="background-color: #E6E6E6" ><small>Unidades Mes</small></td><td colspan="6" align="center" style="background-color: #E6E6E6"><small>Bolivares Mes</samll></td></tr>
					<th><small>N°</small></th>
					<th><small>Codigo</small></th>
				  <th><small>Descripcion</small></th>
				  <th><small>Exis. Ant.</small></th>
				  <th><small><small>Entradas</small></small></th>
				  <th><small><small>Salidas</small></small></th>
				  <th><small><small>Retiros</small></small></th>
				  <th><small><small>Auto</br>Consumo</small></small></th>
				  <th><small>Exist.</small></th>
				  <th><small>Valor ant</small></th>
				  <th><small><small>Entradas</small></small></th>
				  <th><small><small>Salidas</small></small></th>
				  <th><small><small>Retiros</small></small></th>
				  <th><small><small>Auto</br>Consumo</small></small></th>
				  <th><small>Exist.</small></th>		  
				</thead>
				<?php $ctra=$vcr=0; $num=0; $costo=0; $aux=0; $reg=0; $invalor=0;$contado=0;$outvalor=0; $acumctra=$counta=0; $acum_eant=0; $acum_vante=0;$acum_in=0; $acum_out=0;?>
				@foreach ($articulo as $a)
				<?php $num++;  $aux=0; $egresocosto=$ingresoscosto=$contingreso=$contegreso=$in_ant=$out=0;$promcemes=$promcmes=0; $ctant=$cost=0; $aux2=$aux=0; $ctin=$ctout=0;$counta++; ?>     
				@foreach ($anteriorin as $in) <?php  if($a->idarticulo==$in->idarticulo){ $ctin=$in->costop;$in_ant=$in->cantidad;} ?> 
				@endforeach
				@foreach ($anteriorout as $ou) <?php if($a->idarticulo==$ou->idarticulo){$ctout=$ou->costop; $out=$ou->cantidad;} ?> 
				@endforeach			
					<tr height="10px">
				  <td><?php echo "<font size='1'>".$num."</font>";?></font></td>
				  <td><font size="1">{{$a->codigo}}</font></td>
				  <td width="30%"><font size="1"><small>{{$a->nombre}}</small></font></td>
				  <td><font size="1"><?php if($ctin>0){$ctant=$ctin;}else{$ctant=$ctout;} echo number_format(($in_ant-$out), 2,',','.'); $acum_eant=$acum_eant+($in_ant-$out); ?></font></td>
				 <td>@foreach ($entrada as $m)  
				 <?php  if(($a->idarticulo==$m->idarticulo)) { $contingreso++; $ingresoscosto=$ingresoscosto+$m->costop; $aux=$m->cantidad;  }  ?>
					@endforeach 
				 <?php  if($contingreso>0){$promcmes=$ingresoscosto/$contingreso;}else{$promcmes=$ctant;} echo "<font size='1'>".number_format($aux, 2,',','.')."</font>"; $acum_in=$acum_in+$aux; ?></td>
				 <td>@foreach ($salida as $s)  
				 <?php if(($a->idarticulo==$s->idarticulo)) {$contegreso++;  $egresocosto=$egresocosto+$s->costop; $aux2=$aux2+$s->cantidad;}
				if($contegreso>0){ $promcemes=$egresocosto/$contegreso;}else{$promcemes=$ctant;}   ?>
				 @endforeach <?php   echo "<font size='1'>".number_format(($aux2), 2,',','.')."</font>"; $acum_out=$acum_out+$aux2; ?></td>
				 <td><?php echo "<font size='1'>0.00</font>"; ?></td>
				  <td><?php echo "<font size='1'>0.00</font>"; ?></td>
				 <td><?php $ctra=($aux-$aux2)+($in_ant-$out); echo "<font size='1'>".number_format(($ctra), 2,',','.')."</font>";  $acumctra=$acumctra+$ctra; ?></td>
				 <td><?php echo "<font size='1'>".number_format(((($in_ant-$out)*$ctant)*$tasa), 2,',','.')."</font>";  $acum_vante=($acum_vante+(($in_ant-$out)*$ctant)); ?></td>
				<td><?php if($promcmes>0){$cost=$promcmes;}else{$cost=$promcemes;} $contado=$contado+($ctra*$cost); 
				$invalor=$invalor+(($ctra*$cost)-(($in_ant-$out)*$ctant));
				 echo "<font size='1'>".number_format((($aux*$cost)*$tasa), 2,',','.')."</font>";  ?> </td>
				 <td><?php  echo "<font size='1'>".number_format((($aux2*$cost)*$tasa), 2,',','.')."</font>"; $outvalor=($outvalor+($aux2*$cost)); ?></td>
				  <td><?php echo "<font size='1'>0.00</font>"; ?></td>
				  <td><?php echo "<font size='1'>0.00</font>"; ?></td>
				 <td><?php  
				 echo "<font size='1'>".number_format((($ctra*$cost)*$tasa), 2,',','.')."</font>";  ?></td>
				</tr>    
			@endforeach
			<tr><td><?php echo "<ssmal>".$counta."</small>"; ?></td><td></td><td></td>
			<td><?php echo "<font size='1'><b>".number_format(($acum_eant), 2,',','.')."</b></font>"; ?></td>
			<td><?php echo "<font size='1'><b>".number_format(($acum_in), 2,',','.')."</b></font>"; ?></td>
			<td><?php echo "<font size='1'><b>".number_format(($acum_out), 2,',','.')."</b></font>"; ?></td>
			<td><?php echo "<font size='1'><b>0.00</b></font>"; ?></td>
			<td><?php echo "<font size='1'><b>0.00</b></font>"; ?></td>
			<td><?php echo "<font size='1'><b>".number_format(($acumctra*$tasa), 2,',','.')."</b></font>"; ?></td>
			<td><?php echo "<font size='1'><b>".number_format(($acum_vante*$tasa), 2,',','.')."</b></font>"; ?></td>
			<td><?php echo "<font size='1'><b>".number_format(($invalor*$tasa), 2,',','.')."</b></font>"; ?></td>
			<td><?php echo "<font size='1'><b>".number_format(($outvalor*$tasa), 2,',','.')."</b></font>"; ?></td>
			<td><?php echo "<font size='1'><b>0.00</b></font>"; ?></td>
			<td><?php echo "<font size='1'><b>0.00</b></font>"; ?></td>
			<td><?php echo "<font size='1'><b>".number_format(($contado*$tasa), 2,',','.')."</b></font>"; ?></td>
			</tr>
			<tr><td colspan="14"></br><small>Nota: Este resumen debe presentarse mensualmente. Los costos finales deben presentarse a valores promediados por el método de los costos promedios.</small></td></tr>
		</table>
	  </div>
  </div>
  </div>                
</div>
</div><!-- /.row -->
		<div class="col-lg-12 col-md-12 col-sm-6 col-xs-12">
                    <div class="form-group" align="center"></br>
                     <button type="button" id="imprimir" class="btn btn-primary btn-sm" data-dismiss="modal">Imprimir</button>
                    </div>
		</div>

             

@push ('scripts')
<script>
$(document).ready(function(){
    $('#imprimir').click(function(){
  //  alert ('si');
  document.getElementById('imprimir').style.display="none";
  window.print(); 
  window.location="/informes/valorizado";
    });

});

</script>

@endpush
@endsection