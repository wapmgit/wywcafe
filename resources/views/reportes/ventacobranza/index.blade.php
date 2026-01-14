@extends ('layouts.admin')
@section ('contenido')
<div class="row" id="search" style="display: true">
	<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
		<h3>Indique la fecha para la consulta</h3>
		@include('reportes.ventacobranza.search')
	</div>
</div>

@endsection

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
                <!-- /.box-header -->
                <div class="box-body" style="background-color: #fff">                  
    @include('reportes.ventacobranza.empresa')
   <p align="right">
    <span ><?php echo date("d-m-Y",strtotime($searchText)); ?> al <?php echo date("d-m-Y",strtotime($searchText2)); ?></span></p>
	</div><?php $saldovend=$saldovendant=0; ?>
	<div class="panel panel-primary">
	<div class="panel-body">
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
	  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
	<div class="table-responsive">
      <table class="table table-striped table-bordered table-condensed table-hover">
	  		<tr><td colspan="3" align="center">Relacion Ventas Anteriores </td></tr>
		<tr><td>Monto Ventas</td><td>Cxc</td><td>% cxc</td></tr>
		<?php if($cxcante->tventa != NULL){?>
		<tr><td><?php  echo number_format($cxcante->tventa, 2,',','.')." $"; ?></td><td><?php  echo number_format($cxcante->saldoc, 2,',','.')." $"; ?></td>
		<td><?php echo number_format((($cxcante->saldoc*100)/$cxcante->tventa),2,',','.')." %"; ?></td>
		</tr>
		<?php } ?>
      </table>
	  <table class="table table-striped table-bordered table-condensed table-hover">
	  <tr><td colspan="2" align="center">Relacion por Vendedor </td></tr>
	  <tr><td>Vendedor</td><td>Saldo</td></tr>
	   @foreach ($cxcvende as $q)<?php $saldovendant=$saldovendant+$q->saldoc;?>
	   <tr><td>{{$q->nombre}}</td>
	   <td><?php  echo number_format($q->saldoc, 2,',','.')." $"; ?></td>
	   </tr>
	   @endforeach
	      <tr><td>Total</td><td><?php  echo number_format($saldovendant, 2,',','.')." $"; ?></td></tr>
	  </table>
  </div>
  </div>
	  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
	<div class="table-responsive">
      <table class="table table-striped table-bordered table-condensed table-hover">
	    		<tr><td colspan="3" align="center">Relacion Ventas Periodo </td></tr>
		<tr><td>Monto Ventas</td><td>Cxc</td><td>% cxc</td></tr>
		<tr><td><?php  echo number_format($cxcperiodo->tventa, 2,',','.')." $"; ?></td><td><?php  echo number_format($cxcperiodo->saldoc, 2,',','.')." $"; ?></td>
		<td><?php echo number_format((($cxcperiodo->saldoc*100)/$cxcperiodo->tventa),2,',','.')." %"; ?></td>
		</tr>
      </table>
	  	  <table class="table table-striped table-bordered table-condensed table-hover">
		  	<tr><td colspan="3" align="center">Relacion por Vendedor </td></tr>
		  <tr><td>Vendedor</td><td>Ventas</td><td>Saldo</td></tr>
	   @foreach ($cxcpervend as $cv)<?php $saldovend=$saldovend+$cv->saldoc;?>
	   <tr><td>{{$cv->nombre}}</td>
	   <td><?php  echo number_format($cv->tventa, 2,',','.')." $"; ?></td>
	   <td><?php  echo number_format($cv->saldoc, 2,',','.')." $"; ?></td>
	   </tr>
	   @endforeach
	   <tr><td colspan="2">Total</td><td><?php  echo number_format($saldovend, 2,',','.')." $"; ?></td></tr>
	  </table>
  </div>
  </div>
  
  </div>
  </div>
  </div><?php $acumcobro=$acumvc=$acumind=0; ?>
  	<div class="panel panel-primary">
	<div class="panel-body">
  <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
  	  	  <table class="table table-striped table-bordered table-condensed table-hover">
		  	   <tr><td colspan="3" align="center"> Ingreso Venta Contado</td></tr>
		  <tr><td>Moneda</td><td>Recibido</td><td>Monto $</td></tr>
	   @foreach ($cobranza as $c)
	   <?php if($c->tiporecibo=="P"){ $acumvc=$acumvc+$c->rmonto;?>
	   <tr><td>{{$c->idbanco}}</td>
	   <td><?php  echo number_format($c->rrecibido, 2,',','.')." $"; ?></td>
	   <td><?php  echo number_format($c->rmonto, 2,',','.')." $"; ?></td>
	   </tr>
	   <?php } ?>
	   @endforeach
	   <tr><td colspan="2">Total</td><td><?php  echo number_format($acumvc, 2,',','.')." $"; ?></td></tr>
	  </table>
    </div>
	  <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
  	  	  <table class="table table-striped table-bordered table-condensed table-hover">
		   <tr><td colspan="3" align="center"> Ingreso Cobranza</td></tr>
		  <tr><td>Moneda</td><td>Recibido</td><td>Monto $</td></tr>	  
	   @foreach ($cobranza as $c)
	   <?php if($c->tiporecibo=="A"){  $acumcobro= $acumcobro+$c->rmonto;?>
	   <tr><td>{{$c->idbanco}}</td>
	   <td><?php  echo number_format($c->rrecibido, 2,',','.')." $"; ?></td>
	   <td><?php  echo number_format($c->rmonto, 2,',','.')." $"; ?></td>
	   </tr>
	   <?php } ?>
	   @endforeach
	   <tr><td colspan="2">Total</td><td><?php  echo number_format($acumcobro, 2,',','.')." $"; ?></td></tr>
	  </table>
    </div>
	  <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
  	  	  <table class="table table-striped table-bordered table-condensed table-hover">
		     <tr><td colspan="3" align="center"> Ingreso Notas de Debito</td></tr>
		  <tr><td>Moneda</td><td>Recibido</td><td>Monto $</td></tr>
	   @foreach ($cobranzand as $n)<?php $acumind=$acumind+$n->rmonto;?>
	   <tr><td>{{$n->idbanco}}</td>
	   <td><?php  echo number_format($n->rrecibido, 2,',','.')." $"; ?></td>
	   <td><?php  echo number_format($n->rmonto, 2,',','.')." $"; ?></td>
	   </tr>
	   @endforeach   
	    <tr><td colspan="2">Total</td><td><?php  echo number_format($acumind, 2,',','.')." $"; ?></td></tr>
	  </table>
	 <label> <?php  if ($ingresosnc <> NULL){ echo "Monto Notas de Creditos Aplicadas: ".number_format($ingresosnc->recibido, 2,',','.'). " $ "; }?></label>
    </div>
		  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		  <table width="100%"><tr><td>
	<label> Total Ingresos: <?php echo number_format(($acumind+$acumcobro+$acumvc), 2,',','.'). " $ "; ?></label></td>
	<td><label> Total Cxc Acumulada(fin periodo de Consulta): <?php echo number_format(($cxcante->saldoc+$cxcperiodo->saldoc), 2,',','.'). " $ "; ?></label></td>
	<td><label> Total Cxc por N/D Acumulada(fin periodo de Consulta): <?php  if ($notas <> NULL){  echo number_format(($notas->deuda), 2,',','.'). " $ "; } else { echo "0,00";} ?></label></td></tr>
</table> 
 </div>
  </div>
  </div>
  
	          <label>Usuario: {{ Auth::user()->name }}</label>       

                  
                  		</div>
                  	</div><!-- /.row -->
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
  window.location="../reportes/ventas";
    });

});

</script>

@endpush
@endsection