@extends ('layouts.admin')
<?php $mostrar=0; ?>
  @if(Auth::user()->nivel=="A")
@section ('contenido')
<?php $mostrar=1; ?>
<div class="row" id="search" style="display: true">
	<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
		<h3>Indique la fecha para la consulta</h3>
		@include('reportes.corte.search')
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
		<div class="col-lg-6 col-sm-6 col-md-6 col-xs-6">
            	 <div class="form-group">
            			<label >{{$empresa->nombre}}</label></br>
						<label >{{$empresa->rif}}</label></br>	
						<label >{{$empresa->direccion}}. Tel: {{$empresa->telefono}}</label>
            	 </div>  
	    </div>
					<div class="col-lg-3 col-sm-3 col-md-3 col-xs-3">
     <h3 align="center">CORTE DE CAJA </h3> 
	    </div>
				<div class="col-lg-3 col-sm-3 col-md-3 col-xs-3">
		<div align="center">   <img src="{{ asset('dist/img/'.$empresa->logo)}}" width="40%" height="80%" title="NKS"></div>
		</div>
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <span ><?php echo date("d-m-Y",strtotime($searchText)); ?> al <?php echo date("d-m-Y",strtotime($searchText2)); ?>  </span>
  </div>
  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
      <table class="table table-striped table-bordered table-condensed table-hover">
        <thead style="background-color: #E6E6E6">
          
          <th>Facturas</th>
          <th>Contado</th>
          <th>Credito</th>
          <th>Devoluciones</th>
          <th>Total Venta</th>
        </thead>
        <?php $ctra= 0; $cche=0; $cdeb=0; $tdevolu=0; $tcobranza=0; $tmdevolu=0; $tcobro=0; $credito=0; $acumc=0;$contado=0; $count=0; $vcredito=0; $tingreso=0; $vcontado=0; ?>
               @foreach ($datos as $q)
               <?php $count++;
			   if($q->estado=="Credito"){ $vcredito=$vcredito+$q->total_venta; }else{
				   $vcontado=$vcontado+ $q->total_venta;}
				   if($q->devolu==1){ $tdevolu=$tdevolu+1; $tmdevolu=$tmdevolu+$q->total_venta;}
			     $acum=$acum+ $q->total_venta; 			  
          if($q->estado=="Contado"){ $acumc=$acumc+ $q->total_venta; }?> 
        @endforeach	 
		<tbody>
		<tr>
          <td><?php echo $count; ?></td>
          <td><?php   echo number_format($vcontado, 2,',','.')." $"; ?></td>
          <td><?php echo number_format($vcredito, 2,',','.')." $"; ?></td>
          <td><?php echo number_format(($tmdevolu), 2,',','.')." $"; ?></td>                             
          <td><?php echo number_format((($vcredito+$vcontado)-$tmdevolu), 2,',','.')." $"; ?></td>                             
        </tr>

		</tbody>			
      </table>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
  <table class="table table-striped table-bordered table-condensed table-hover">
      <thead style="background-color: #E6E6E6">
        
          <th>Alicuota</th>
          <th>Venta</th>
          <th>BIVA</th>
          <th>IVA</th>
        </thead> <?php $ivaventa=0; $sumaiva=0; $acumgravado=0; $ivasale=0;?>
		  @foreach ($impuestos as $imp)
      <tr >
          <td> @if ($imp->iva==0) Exento @else {{$imp->iva}} @endif </td>
          <td><?php $sumaiva=($imp->montoventa-$imp->gravado);$ivaventa=($ivaventa+$imp->montoventa); echo number_format($imp->montoventa, 2,',','.')." $"; ?></td>
          <td><?php 
            if ($imp->iva == 0 ){ echo 0;}else{ $acumgravado=($acumgravado+$imp->gravado);
			echo number_format($imp->gravado, 2,',','.')." $"; }?></td>
          <td><?php 
		   if ($imp->iva == 0 ){ echo 0;}else{ $ivasale=$ivasale+$sumaiva; 
		   echo number_format(($imp->montoventa-$imp->gravado), 2,',','.')." $"; }?></td>
        @endforeach
        </tr>
		<tr >
		  <td ><strong>Total</strong></td>
          <td><strong><?php  echo number_format($ivaventa, 2,',','.')." $"; ?></strong></td>
          <td><strong><?php echo number_format($acumgravado, 2,',','.')." $"; ?></strong></td>
          <td><strong><?php echo number_format(($ivasale), 2,',','.')." $"; ?></strong></td>
		</tr>
      </table>
    </div>
  

  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
      <table class="table table-striped table-bordered table-condensed table-hover">
      <thead >
        
          <tr><td colspan="3" align="center" style="background-color: #E6E6E6"> <strong>Desglose de Ventas</strong></td></tr>
          <th>Moneda</th>
          <th>Recibido</th>
          <th>monto</th>
          
        </thead>
         @foreach ($pagos as $cob)
		   <?php $tingreso=$tingreso+$cob->monto; ?>
      <tr >
          <td><?php  echo $cob->idbanco; ?></td>
          <td><?php echo number_format($cob->recibido, 2,',','.'); ?></td>
          <td><?php  echo number_format($cob->monto, 2,',','.')." $"; ?></td>
        </tr>
        @endforeach
        <tr><td colspan="2" align="center"><strong>Total Desglose de ventas</strong></td><td><strong><?php echo number_format($tingreso, 2,',','.')." $"; ?></strong></td></tr>
      </table>
    </div>
	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
	    <table class="table table-striped table-bordered table-condensed table-hover">
      <thead>
          <tr><td colspan="3" align="center" style="background-color: #E6E6E6"> <strong>Desglose de Cobranza</strong></td></tr>
		<th>Moneda</th>
		<th>Recibido</th>
		<th>Monto</th> </thead>
         @foreach ($cobranza as $cob)
		 <?php  $tcobranza=$tcobranza+$cob->monto; ?> 
        <tr>
          <td><?php  echo$cob->idbanco; ?></td>
          <td><?php echo number_format($cob->recibido, 2,',','.'); ?></td>
             <td><?php  echo number_format($cob->monto, 2,',','.')." $"; ?></td>
        </tr>
        @endforeach
		    <tr><td colspan="2" align="center"><strong>Total Desglose de Cobranza</strong></td><td><strong><?php echo number_format($tcobranza, 2,',','.')." $"; ?></strong></td></tr>
      </table>
      </table>
	  </div>
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
	    <table class="table table-striped table-bordered table-condensed table-hover">
      <thead>
          <tr><td colspan="3" align="center" style="background-color: #E6E6E6"> <strong>Distribucion de Ingresos</strong></td></tr>
		<th>Moneda</th>
		<th>Recibido</th>
		<th>Monto</th> </thead>
         @foreach ($ingresos as $cob) <?php $tcobro=$tcobro+$cob->monto;?>	
        <tr>
          <td><?php  echo$cob->idbanco; ?></td>
          <td><?php echo number_format($cob->recibido, 2,',','.'); ?></td>
          <td><?php  echo number_format($cob->monto, 2,',','.')." $"; ?></td>
        </tr>
        @endforeach
		    <tr><td colspan="2" align="center"><strong>Total Ingresos</strong></td><td><strong><?php echo number_format($tcobro, 2,',','.')." $"; ?></strong></td></tr>
      </table>
      </table>
	  </div>
    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
  <table class="table table-striped table-bordered table-condensed table-hover">
        <thead style="background-color: #E6E6E6">
          <th>Monto Devoluciones( {{$tdevolu}})</th>
		  <th>Monto Comisiones</th>
          <th>Total Caja</th>
       
        </thead>
         @foreach ($devolucion as $dev)
        <tr >       
          <td><strong><?php $devolu=$dev->totaldev; echo number_format($devolu, 2,',','.')." $"; ?></strong></td>
		    <td><strong><?php  echo number_format($comision->monto, 2,',','.')." $"; ?></strong></td>
          <td><strong><?php $caja=($tingreso+$tcobranza)-($devolu+$comision->monto); echo "$ ".number_format($caja, 2,',','.'); ?></strong></td>
        
        </tr>
        @endforeach
    </table>
    </div>	
<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
	    <table class="table table-striped table-bordered table-condensed table-hover">
      <thead>
          <tr><td align="center" style="background-color: #E6E6E6"> <strong>N/C Aplicadas</strong></td>
		  <td align="center" style="background-color: #E6E6E6"> <strong>N/C Creadas</strong></td></tr>
		<th><?php  if ($ingresosnd <> NULL){ echo number_format($ingresosnd->recibido, 2,',','.'). " $ "; }?></th>
<th><?php  if ($creditos <> NULL){ echo number_format($creditos->recibido, 2,',','.'). " $ "; }?></th>
		</thead>
         
      </table>
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
  window.location="../reportes/corte";
    });

});

</script>

@endpush
@endsection