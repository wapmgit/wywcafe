<div class="row">
<?php  $ano = date("Y"); if($year==""){$year=$ano; };  ?>
<h6 class="box-title"><small><b>REGISTRO DETALLADO DE ENTRADAS Y SALIDAS DE INVENTARIO DE MERCANCIAS (MATERIAS PRIMAS O PRODUCTOS EN PROCESO)</b></small></h6>
		<div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
            	 <div class="form-group">
				 <table width="100%">
				 <tr><td>RAZON SOCIAL O DENOMINACION COMERCIAL</td>
				 <td>R.I.F. DEL CONTRIBUYENTE</td>
				 <td>DIA/MES</td><td>AÑO</td></tr>
				 <tr>
				 <td><b>{{$empresa->nombre}}</b></td>
				 <td><b>{{$empresa->rif}}</b></td>
				 <td>	  <?php $mes="";
	  if($searchText=="01"){$mes="Enero";} if($searchText=="02"){$mes="Febrero";} if($searchText=="03"){$mes="Marzo";} 
	  if($searchText=="04"){$mes="Abril";} if($searchText=="05"){$mes="Mayo";} if($searchText=="06"){$mes="Junio";} 
	  if($searchText=="07"){$mes="Julio";} if($searchText=="08"){$mes="Agosto";} if($searchText=="09"){$mes="Septiembre";} 
	  if($searchText=="10"){$mes="Octubre";} if($searchText=="11"){$mes="Noviembre";} if($searchText=="12"){$mes="Diciembre";} 
	   echo "<b>".$mes."</b>";
	  ?> </td>
				 <td><b><?php echo $year; ?></b></td>
				 </tr>
				 </table>
	
            	 </div>  
	    </div>
</div>