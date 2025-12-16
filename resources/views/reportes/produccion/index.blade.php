@extends ('layouts.admin')
@section ('contenido')
<div class="row">
	<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
		<h3>Indique la fecha para la consulta</h3>
		@include('reportes.produccion.search')
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
 @include('reportes.produccion.empresa')
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
 <p align="right">
    <span ><?php echo date("d-m-Y",strtotime($searchText)); ?> al <?php echo date("d-m-Y",strtotime($searchText2)); ?> </span></p>
      <table class="table table-striped table-bordered table-condensed table-hover">
        <thead style="background-color: #E6E6E6">
		  <th>Item</th>
		  <th>Fecha</th>
          <th>Tostador</th>
		  <th>Cochas</th>
          <th>Kg</th> 
	      <th>kg Tostado</th>		
	      <th>kg Comision</th>		
	      <th>kg Maquina</th>		
	      <th>kg Reduccion</th>		
		</thead><?php $count=0; $acummprima=0; $acumredu=0; $acumcomit=0; $acumcomim=0;$acumcocha=$acumt=$tmiva=0; ?>
               @foreach ($datos as $q)
				<tr> <?php $count++; ?> 
				<td>{{ $q->idt}}</td>
				<td>{{ $q->fecha}}</td>
				<td>{{$q->nombre}}</td>
				<td><?php $acumcocha=($acumcocha+$q->cochas); ?>{{$q->cochas}}</td>
				 <td><?php $acummprima=($acummprima+$q->kgmprima); echo number_format($q->kgmprima, 2,',','.'); ?></td>
				 <td><?php $acumt=($acumt+$q->kgtostado); echo number_format($q->kgtostado, 2,',','.'); ?></td>
				<td><?php  $acumcomit=($acumcomit+$q->kgcomi);   echo number_format( $q->kgcomi,2,',','.'); ?></td>
				<td><?php $acumcomim=($acumcomim+$q->kgcomima); echo number_format($q->kgcomima, 2,',','.'); ?></td>	
				<td><?php $acumredu=($acumredu+$q->reduccion); echo number_format($q->reduccion, 2,',','.'); ?></td>	
				</tr>
				@endforeach
        <tr><td colspan="3"><strong>Total</strong></td>
		<td><strong><?php echo number_format( $acumcocha, 2,',','.'); ?></strong></td>
		<td><strong><?php echo number_format( $acummprima, 2,',','.'); ?></strong></td>
		<td><strong><?php echo number_format( $acumt, 2,',','.'); ?></strong></td>
		<td><strong><?php echo number_format( $acumcomit, 2,',','.'); ?></strong></td>
		<td><strong><?php echo number_format( $acumcomim, 2,',','.'); ?></strong></td>
		<td><strong><?php echo number_format( $acumredu, 2,',','.'); ?></strong></td>
			</table>
		</div>
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
 <p align="right">
    <span > Produccion </span></p>
      <table class="table table-striped table-bordered table-condensed table-hover">
        <thead style="background-color: #E6E6E6">
		  <th>Item</th>
		  <th>Fecha</th>
          <th>Encargado</th>
          <th>Kg Materia Prima</th> 
	      <th>kg Molidos</th>		
	      <th>Metodo</th>		
	      <th>kg Empaquetados</th>		
	      <th>kg Reduccion</th>		
		</thead><?php $count=0; $acumsub=0; $acumoli=0; $acumredu=0; $acumemp=0; ?>
               @foreach ($datosp as $q)
				<tr> <?php $count++; ?> 
				<td>{{ $q->idproduccion}}</td>
				<td>{{ $q->fecha}}</td>
				<td>{{$q->encargado}}</td>
				 <td><?php $acumsub=($acumsub+$q->kgsubido); echo number_format($q->kgsubido, 2,',','.'); ?></td>
				 <td><?php $acumoli=($acumoli+$q->kgmolidos); echo number_format($q->kgmolidos, 2,',','.'); ?></td>
				<td><?php if($q->tipoemp==0){ echo "Mecanico";}else{ echo "Manual";} ?></td>
				<td><?php $acumemp=($acumemp+$q->kgempa); echo number_format($q->kgempa, 2,',','.'); ?></td>	
				<td><?php $acumredu=($acumredu+$q->reduccion); echo number_format($q->reduccion, 2,',','.'); ?></td>	
				</tr>
				@endforeach
        <tr><td colspan="3"><strong>Total</strong></td>
		<td><strong><?php echo number_format( $acumsub, 2,',','.'); ?></strong></td>
		<td><strong><?php echo number_format( $acumoli, 2,',','.'); ?></strong></td>
		<td></td>
		<td><strong><?php echo number_format( $acumemp, 2,',','.'); ?></strong></td>
		<td><strong><?php echo number_format( $acumredu, 2,',','.'); ?></strong></td>
			</table>
		</div>
		  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
 <p align="right">
    <span > Detalle Produccion </span></p>
      <table class="table table-striped table-bordered table-condensed table-hover">
        <thead style="background-color: #E6E6E6">
		  <th>Produccion</th>
		  <th>Producto</th>
          <th>Cantidad Unidades</th>
          <th>Kg </th> 	
		</thead><?php $count=0; $acumuni=0; $acump=0; $acumredu=0; $acumemp=0; ?>
               @foreach ($detalle as $q)
				<tr> <?php $count++; ?> 
				<td>{{ $q->idproduccion}}</td>
				<td>{{ $q->nombre}}</td>
				<td><?php $acumuni=($acumuni+$q->cantidad); echo number_format($q->cantidad, 2,',','.'); ?></td>
				 <td><?php $acump=($acump+$q->kgproduccion); echo number_format($q->kgproduccion, 2,',','.'); ?></td>
				</tr>
				@endforeach
        <tr><td colspan="2"><strong>Total</strong></td>
		<td><strong><?php echo number_format( $acumuni, 2,',','.'); ?></strong></td>
		<td><strong><?php echo number_format( $acump, 2,',','.'); ?></strong></td>
			</table>
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
  window.location="../reportes/produccion";
    });

});

</script>

@endpush
@endsection