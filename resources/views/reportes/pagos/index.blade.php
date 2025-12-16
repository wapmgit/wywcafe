@extends ('layouts.admin')
<?php $mostrar=0; ?>
  @if(Auth::user()->nivel=="A")
@section ('contenido')
<?php $mostrar=1; ?>
<div class="row" id="search" style="display: true">
	<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
		<h3>Indique fecha  para la consulta</h3>
		@include('reportes.pagos.search')
	</div>
</div>

@endsection
@endif
<?php $acum=0;$tcobranza=0;$deb=0;$che=0;$tra=0;
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
    @include('reportes.pagos.empresa')
   
    <span >Del <?php echo date("d-m-Y",strtotime($searchText)); ?>  al <?php echo date("d-m-Y",strtotime($searchText2)); ?>  </span>
  </div>
  
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="table-responsive">
	    <table class="table table-striped table-bordered table-condensed table-hover">
      <thead style="background-color: #E6E6E6" >
	  <th id="campo">Recibo</th>
	  <th>Usuario</th>
		<th>Proveedor</th>
		<th>Documento</th>
		<th>Moneda</th>
		<th>Recibido</th>
		<th>Monto</th>
		<th>Referencia</th>
		<th>Fecha Rec.</th>
		</thead>
         @foreach ($pagos as $cob)
		 <?php  $tcobranza=$tcobranza+$cob->monto; ?> 
        <tr>
		<td><?php if ($cob->monto>0){?>
<a href="" data-target="#modal-delete-{{$cob->idrecibo}}" data-toggle="modal" ><button class="btn btn-warning btn-xs" >X</button></a>	
		<?php } ?>
		{{$cob->idrecibo}}</td>
		<td>{{$cob->vendedor}}</td>
		<td>{{$cob->nombre}}</td>
		<td>{{$cob->tipo_comprobante}}-{{$cob->num_comprobante}}</td>
          <td><?php  echo$cob->idbanco; ?></td>
          <td><?php echo number_format($cob->recibido, 2,',','.'); ?></td>
             <td><?php  echo number_format($cob->monto, 2,',','.')." $"; ?></td>
			 <td>{{$cob->referencia}}</td>
			 <td><?php echo date("d-m-Y h:i:s a",strtotime($cob->fecha)); ?></td>
        </tr>
			@include('reportes.pagos.modal')
        @endforeach
		   @foreach ($gastos as $cob)
		 <?php  $tcobranza=$tcobranza+$cob->monto; ?> 
        <tr>
		<td><?php if ($cob->monto>0){?>
<a href="" data-target="#modal-delete-{{$cob->idrecibo}}" data-toggle="modal" ><button class="btn btn-warning btn-xs" >X</button></a>	
		<?php } ?>
		{{$cob->idrecibo}}</td>
		<td>{{$cob->vendedor}}</td>
		<td>{{$cob->nombre}}</td>
		<td>G:{{$cob->documento}}</td>
          <td><?php  echo$cob->idbanco; ?></td>
          <td><?php echo number_format($cob->recibido, 2,',','.'); ?></td>
             <td><?php  echo number_format($cob->monto, 2,',','.')." $"; ?></td>
			 <td>{{$cob->referencia}}</td>
			 <td><?php echo date("d-m-Y h:i:s a",strtotime($cob->fecha)); ?></td>
        </tr>
			@include('reportes.pagos.modalg')
        @endforeach
		<tr><td colspan="6"><strong>Total Ingresos</strong></td><td colspan="3"><strong><?php  echo number_format($tcobranza, 2,',','.'); ?> $</strong></td></tr>
      </table>
	  </div>
	  </div>

	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
	    <table class="table table-striped table-bordered table-condensed table-hover">
      <thead style="background-color: #E6E6E6" >
	  <th>Moneda</th>
		<th>Entregado</th>
		<th>Monto</th>
		</thead>
         @foreach ($comprobante as $co)
        <tr>
		<td>{{$co->idbanco}}</td>
		<td><?php echo number_format($co->recibido, 2,',','.'); ?></td>
    <td><?php  echo number_format($co->monto, 2,',','.')." $"; ?></td>
        </tr>
        @endforeach
      </table>
	  </div>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
  		       
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
  window.location="../reportes/cobranza";
    });

});

</script>

@endpush
@endsection