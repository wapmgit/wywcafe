@extends ('layouts.admin')
<?php $mostrar=0; ?>
  @if(Auth::user()->nivel=="A")
@section ('contenido')
<?php $mostrar=1; ?>
<div class="row" id="search" style="display: true">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<h3>Indique la fecha para la consulta</h3>
		@include('reportes.detallecobranza.search')
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
          
                  <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    
                    <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                  </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body" style="background-color: #fff">
                  

<div class="panel panel-primary">
<div class="panel-body">
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

    @include('reportes.detallecobranza.empresa')
<p align="right">
   <span ><?php echo date("d-m-Y",strtotime($searchText)); ?> al <?php echo date("d-m-Y",strtotime($searchText2)); ?> </span>

	</p>
	<div class="table-responsive">
      <table class="table table-striped table-bordered table-condensed table-hover">
        <thead style="background-color: #E6E6E6" >
       
          <th>Venta</th>
          <th>Fecha</th>
          <th>Cliente</th>
          <th>Monto Venta</th>      
          <th>10 dias</th>      
          <th>15 dias</th>      
          <th>22 dias</th>      
          <th>30 dias</th>      
          <th>Mas 30 dias</th>      
          <th>Saldo</th>      
        </thead>
        <?php $acumsaldo=0; $cntv=0;  $contado=0;$acum10=$acum15=$acum22=$acum30=$acummas=0; $count=0; $tventa=0; $auxp=$auxpv=0;?>

         @foreach ($datos as $q)
            <?php $tventa=$tventa +$q->total_venta; $montodiez=$mas=0;  $montoquince=$montoveinte=$treinta=0; 
			$acumsaldo=$acumsaldo+$q->saldo; $cntv++; ?>
        <tr>         
         <td>{{ $q->idventa}}</td>
         <td><?php echo date("d-m-Y",strtotime($q->fecha_emi)); ?></td>
         <td><small>{{ $q->nombre}}</small></td>
         <td><?php echo number_format(($q->total_venta), 2,',','.'); ?></td>      
         <td>  
		 @foreach ($recibosdiez as $diez)
		 <?php if(($q->idventa==$diez->idventa)and ($diez->dias <= 10))
		 {$montodiez=$montodiez+$diez->monto; $acum10=$acum10+$diez->monto; }
		 if(($q->idventa==$diez->idventa)and ($diez->dias > 10) and($diez->dias <= 15) )
		 {$montoquince=$montoquince+$diez->monto;  $acum15=$acum15+$diez->monto;}
		if(($q->idventa==$diez->idventa)and ($diez->dias > 15) and($diez->dias <= 22) )
		 {$montoveinte=$montoveinte+$diez->monto;  $acum22=$acum22+$diez->monto;}
		if(($q->idventa==$diez->idventa)and ($diez->dias > 22) and ($diez->dias <= 30) )
		 {$treinta=$treinta+$diez->monto;  $acum30=$acum30+$diez->monto;}	 
		if(($q->idventa==$diez->idventa)and ($diez->dias > 30) )
		 {$mas=$mas+$diez->monto; $acummas=$acummas+$diez->monto;}	 ?> 
		 @endforeach
		 	<?php  echo number_format(($montodiez), 2,',','.');  ?>
		 </td>  
         <td> <?php  echo number_format(($montoquince), 2,',','.');  ?> </td>		 
		 <td>  <?php  echo number_format(($montoveinte), 2,',','.'); ?></td>	
		 <td> <?php  echo number_format(($treinta), 2,',','.');  ?> </td> 
		 <td> <?php  echo number_format(($mas), 2,',','.');  ?></td>	
		 <td> <?php  echo number_format(($q->saldo), 2,',','.');  ?></td>	
       </tr>
        @endforeach
		<tr>
		<td colspan="3"> Total: Ventas {{$cntv}}</tD>
		<td > <?php  echo number_format(($tventa), 2,',','.');  ?></td>
		<td > <?php  echo number_format(($acum10), 2,',','.');  ?></td>
		<td > <?php  echo number_format(($acum15), 2,',','.');  ?></td>
		<td > <?php  echo number_format(($acum22), 2,',','.');  ?></td>
		<td > <?php  echo number_format(($acum30), 2,',','.');  ?></td>
		<td > <?php  echo number_format(($acummas), 2,',','.');  ?></td>
		<td > <?php  echo number_format(($acumsaldo), 2,',','.');  ?></td>
		</tr>
      </table>
	  </div>
  </div>

    </div>
     <label>  Usuario: {{ Auth::user()->name }}</label>    
  </div>
  </div>
  </div>
	          

                  
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
  window.location="/reportes/detallecobranza";
    });

});

</script>

@endpush
@endsection