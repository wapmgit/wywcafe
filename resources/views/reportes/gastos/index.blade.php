@extends ('layouts.admin')
@section ('contenido')
<div class="row">
	<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
		<h3>Indique la fecha para la consulta</h3>
		@include('reportes.gastos.search')
	</div>
</div>

@endsection

<?php $acum=0;$efe=0;$deb=0;$che=0;$tra=0;$ctra=0;$cche=0; $cdeb=0;
$cefe=0;?>
@section ('reporte')


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
                 
<div class="panel panel-primary">
<div class="panel-body">  
 @include('reportes.gastos.empresa')
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
 <p align="right">
    <span ><?php echo date("d-m-Y",strtotime($searchText)); ?> al <?php echo date("d-m-Y",strtotime($searchText2)); ?> </span></p>
      <table class="table table-striped table-bordered table-condensed table-hover">
        <thead style="background-color: #E6E6E6">
		  <th>Rif</th>
          <th>Proveedor</th>
		  <th>Documento</th>
          <th>Monto</th> 
	      <th>Pagado</th>		
		</thead><?php $count=0; $deuda=0; $acump=0; $tmonto=0; $tdeuda=0;$tbase=$texento=$tmiva=0; ?>
               @foreach ($datos as $q)
				<tr> <?php $count++; ?> 
				<td>{{ $q->rif}}</td>
          <td>{{ $q->nombre}}</td>
					   <td>GTO-{{$q->documento}}</td>
         <td><?php $tmonto=($tmonto+$q->monto);
            $tdeuda=($tdeuda+$q->saldo);
           echo number_format( $q->monto,2,',','.')." $"; ?></td>

          <td><?php $deuda=($q->monto-$q->saldo); echo number_format($deuda, 2,',','.')." $"; ?></td>	
				</tr>
				@endforeach
        <tr><td colspan="3"><strong>Total</strong></td><td><strong><?php echo number_format( $tmonto, 2,',','.'); ?></strong></td>

          <td><strong><?php echo "Por pagar: ".number_format( $tdeuda, 2,',','.')." $"; ?></strong></td></tr>
			</table>
		</div>
   <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="table-responsive">
      <table class="table table-striped table-bordered table-condensed table-hover">
      <thead >
        
          <tr><td colspan="3" style="background-color: #E6E6E6" align="center"><strong>DESGLOSE DE PAGOS<strong></td></tr>
          <th>Moneda</th>
          <th>Entregado</th>
          <th>Monto</th>
         
        </thead>
		 @foreach ($pagos as $q)
		<tr >
        <td>{{$q->idbanco}}</td>
		<td><?php echo number_format($q->recibido, 2,',','.'); ?></td>
		<td><?php $acump=$acump+$q->monto; echo number_format($q->monto, 2,',','.')." $"; ?></td>
        </tr>   @endforeach
		<tr><td align="center" colspan="3"> <strong> Total Pagos: <?php echo number_format($acump, 2,',','.')." $"; ?></strong></td></tr>
      </table>
    </div>
  </div>
  </div>
  </div>
  

           
 <label>Usuario: {{ Auth::user()->name }}</label>   
                  
                  	     </div>
                    </div><!-- /.row -->
                     <div class="col-lg-12 col-md-12 col-sm-6 col-xs-12">
                    <div class="form-group" align="center">
                     <button type="button" id="imprimir" class="btn btn-primary" data-dismiss="modal">Impimir</button>
            <!-- <a href="/reportes/compras/excel/"><button class="btn btn-warning">TXT</button></a> -->
                    </div>
                </div>
                   
                </div> 
              </div>
         

         @push ('scripts')
<script>
$(document).ready(function(){
    $('#imprimir').click(function(){
  //  alert ('si');
  document.getElementById('imprimir').style.display="none";
  window.print(); 
  window.location="../reportes/compras";
    });

});

</script>

@endpush
@endsection