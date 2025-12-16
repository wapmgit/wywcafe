@extends ('layouts.admin')
@section ('contenido')
<div class="row" id="search" style="display: true">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<h3>Indique la fecha para la consulta</h3>
		@include('reportes.utilidad.search')
	</div>
</div>

@endsection
<?php 
if($fechafiltro=="v.fechahora"){$filtro="Emision";}else{$filtro="Despacho";} 
?>
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
                  

<div class="panel panel-primary">
<div class="panel-body">
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
 
    @include('reportes.ventas.empresa')
    <h3 align="center">REPORTE DE UTILIDAD EN VENTAS</h3> <p align="right">
    <span ><?php echo $filtro." -> ".date("d-m-Y",strtotime($searchText)); ?> al <?php echo date("d-m-Y",strtotime($searchText2)); ?></span></p>
	<div class="table-responsive">
      <table class="table table-striped table-bordered table-condensed table-hover">
        <thead style="background-color: #E6E6E6" >
    
          <th>Documento</th>
          <th>Costo</th>
          <th>Precio venta</th>
          <th>Cantidad</th>
          <th>Costo Neto</th>
          <th>Venta Neta</th>
          <th>Utilidad</th>
        </thead>
        <?php $tcosto= 0; $tutil=0; $tvn=0; $tcn=0; $tcant=0; $tpv=0;?>

               @foreach ($datos as $q)
              
        <tr>
   
          <td>{{ $q->tipo_comprobante.':'.$q->serie_comprobante.'-'.$q->num_comprobante}}</td>
          <td><?php $tcosto=$tcosto+$q->costo; echo number_format($q->costo, 2,',','.'); ?></td>
          <td><?php $tpv=$tpv+$q->precio_venta; echo number_format($q->precio_venta, 2,',','.'); ?></td>
          <td>
             <?php $tcant=$tcant+$q->cantidad; echo number_format($q->cantidad, 2,',','.'); ?></td>
          <td>
             <?php $tcn=$tcn+$q->costoneto; echo number_format($q->costoneto, 2,',','.'); ?></td>
          <td>
             <?php $tvn=$tvn+$q->ventaneta;  echo number_format($q->ventaneta, 2,',','.'); ?></td>
            <td> <?php  echo number_format(($q->ventaneta-$q->costoneto), 2,',','.'); ?></td>
        
        </tr>
       
        @endforeach
   
 <tr style="background-color: #E6E6E6" >
        <td colspan=""> <strong>TOTAL:</strong></td>
          <td><strong><?php echo number_format($tcosto, 2,',','.')." $"; ?></strong></td>
          <td><strong><?php echo number_format($tpv, 2,',','.')." $"; ?></strong></td>
          <td><strong><?php echo number_format($tcant, 2,',','.')." $"; ?></strong></td>
          <td><strong><?php echo number_format($tcn, 2,',','.')." $"; ?></strong></td>
          <td><strong><?php echo number_format($tvn, 2,',','.')." $"; ?></strong></td>
          <td><strong><?php echo number_format(($tvn-$tcn), 2,',','.')." $"; ?></strong></td>
        
        </tr>
      </table>

  </div>
  </div>
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    </div>
  
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