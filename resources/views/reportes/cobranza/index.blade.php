@extends ('layouts.admin')
<?php $mostrar=0; ?>
  @if(Auth::user()->nivel=="A")
@section ('contenido')
<?php $mostrar=1; $tipo="";?>
<div class="row" id="search" style="display: true">
	<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
		<h3>Indique fecha y Vendedor para la consulta</h3>
		@include('reportes.cobranza.search')
	</div>
</div>

@endsection
@endif
<?php $acum=0;$tcobranza=0;$deb=0;$che=0;$tra=$tventas=$tingnd=0;$acumnc=0;
$cefe=0; $x=0;?>
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
    @include('reportes.ventas.empresa')
    <h3 align="center">DETALLE DE INGRESOS </h3> 
    <span ><?php echo date("d-m-Y",strtotime($searchText)); ?>  al <?php echo date("d-m-Y",strtotime($searchText2)); ?>  </span>
  </div>
  
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
	<?php $x=count($cobranza); if ($x>0){?>
	    <table class="table table-striped table-bordered table-condensed table-hover">		
		<thead><th colspan="9">Cobranza </th></thead>
      <thead style="background-color: #E6E6E6" >
	  <th id="campo">Recibo</th>
	  <th>Vendedor</th>
		<th>Cliente</th>
		<th>Documento</th>
		<th>Moneda</th>
		<th>Recibido</th>
		<th>Monto</th>
		<th>Referencia</th>
		<th>Fecha Rec.</th>
		</thead>
         @foreach ($cobranza as $cob)
		 <?php   if($cob->tiporecibo=="A") { $tcobranza=$tcobranza+$cob->monto;?> 
		 
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
			@include('reportes.cobranza.modal')
        
		<tr>  <?php  } ?>
		@endforeach
		<tr>    
		<td colspan="6"><strong>Total Ingresos Cobranza</strong></td><td colspan="3"><strong><?php  echo number_format($tcobranza, 2,',','.'); ?> $</strong></td></tr>
		   </table>
	<?php } ?>
		       <table class="table table-striped table-bordered table-condensed table-hover">
			   	<thead><th colspan="9" >Ventas</th></thead>
      <thead style="background-color: #E6E6E6" >
	  <th id="campo">Recibo</th>
	  <th>Vendedor</th>
		<th>Cliente</th>
		<th>Documento</th>
		<th>Moneda</th>
		<th>Recibido</th>
		<th>Monto</th>
		<th>Referencia</th>
		<th>Fecha Rec.</th>
		</thead>

		         @foreach ($cobranza as $cob)
		 <?php   if($cob->tiporecibo=="P") { $tventas=$tventas+$cob->monto;?> 
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
			@include('reportes.cobranza.modal')
		<?php  } ?>
		@endforeach
		<tr>    
		<td colspan="6"><strong>Total Ingresos Ventas</strong></td><td colspan="3"><strong><?php  echo number_format($tventas, 2,',','.'); ?> $</strong></td></tr>
      </table>
	  		<table class="table table-striped table-bordered table-condensed table-hover">
			   	<thead><th colspan="9" >Ingresos por Notas de Debito</th></thead>
      <thead style="background-color: #E6E6E6" >
	  <th id="campo">Recibo</th>
	  <th>Usuario</th>
		<th>Cliente</th>
		<th>Documento</th>
		<th>Moneda</th>
		<th>Recibido</th>
		<th>Monto</th>
		<th>Referencia</th>
		<th>Fecha Rec.</th>
		</thead>

		         @foreach ($ingresosnd as $ing)
		 <?php $tingnd=$tingnd+$ing->monto;  ?> 
        <tr>
		<td>
		{{$ing->idrecibo}}</td>
		<td>{{$ing->vendedor}}</td>
		<td>{{$ing->nombre}}</td>
		<td>{{$ing->tipo_comprobante}}-{{$ing->num_comprobante}}</td>
          <td><?php  echo $ing->idbanco; ?></td>
          <td><?php echo number_format($ing->recibido, 2,',','.'); ?></td>
             <td><?php  echo number_format($ing->monto, 2,',','.')." $"; ?></td>
			 <td>{{$ing->referencia}}</td>
			 <td><?php echo date("d-m-Y h:i:s a",strtotime($ing->fecha)); ?></td>
        </tr>
			@include('reportes.cobranza.modal')
		@endforeach
		<tr>    
		<td colspan="6"><strong>Total Ingresos Ventas</strong></td><td colspan="3"><strong><?php  echo number_format($tingnd, 2,',','.'); ?> $</strong></td></tr>
      </table>
	  </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12"><h4 align="center">Desglose de Ingresos</h4>
	    <table class="table table-striped table-bordered table-condensed table-hover">
      <thead style="background-color: #E6E6E6" >
	  <th>Moneda</th>
		<th>Recibido</th>
		<th>Monto</th>
		</thead>
		<tr><td colspan="3"><strong> Cobranza </strong></td></tr>
         @foreach ($comprobante as $co)
		  <?php   if($co->tiporecibo=="A") {?>
        <tr>
		<td>{{$co->idbanco}}</td>
		<td><?php echo number_format($co->mrecibido, 2,',','.'); ?></td>
		<td><?php  echo number_format($co->mmonto, 2,',','.')." $"; ?></td>
        </tr><?php } ?>
        @endforeach
		  
		  		<tr><td colspan="3"><strong> Ventas </strong></td></tr>
				@foreach ($comprobante as $co)
					<?php   if($co->tiporecibo=="P") {?>
				<tr>
				<td>{{$co->idbanco}}</td>
				<td><?php echo number_format($co->mrecibido, 2,',','.'); ?></td>
				<td><?php  echo number_format($co->mmonto, 2,',','.')." $"; ?></td>
				</tr>		 <?php } ?>
				@endforeach

      </table> 
	  </div>
	                      
						  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12"><h4 align="center">Nota de Credito Aplicada</h4>
						<table id="desglose" class="table table-striped table-bordered table-condensed table-hover">
                      <thead style="background-color: #E6E6E6" >
						
                          <th>#</th> 
                          <th>fecha</th> 
						  <th>Referencia</th>
                          <th>Monto</th>
						 
                      </thead>
                     
                      <tbody>
                        
                        @foreach($recibonc as $renc) <?php  $acumnc=$acumnc+$renc->monto;?>
                        <tr>
						<td><?php if($renc->monto>0){?><a href="" data-target="#modal-delete-{{$renc->id_mov}}" data-toggle="modal" ><button class="btn btn-warning btn-xs" >X</button></a><?php } ?>{{$renc->id_mov}}	</td>
                          <td>			  
						  <?php echo date("d-m-Y",strtotime($renc->fecha)); ?></td>
                          <td>{{$renc->tipodoc}}{{$renc->iddoc}}-{{$renc->referencia}}</td> 
						<td><?php echo number_format( $renc->monto, 2,',','.'); ?></td>						  
                        </tr>
								@include('reportes.cobranza.anularnc')
                        @endforeach
                        <tfoot >                    
                          <th colspan="2">Total</th>
						  <th><?php echo "$ ".number_format( $acumnc, 2,',','.');?></th>
                          <th ><h4 id="total"><b></b></h4></th>
                          </tfoot>
                      </tbody>
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