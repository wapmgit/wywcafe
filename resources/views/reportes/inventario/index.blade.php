@extends ('layouts.admin')
@section ('contenido')
<?php $corteHoy = date("Y-m-d h:i:s"); ?>
<div class="panel panel-primary">
<div class="panel-body">		
 <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            	 <div class="form-group">
            			<label >{{$empresa->nombre}}</label></br>
						<label >{{$empresa->rif}}</label></br>	
						<label >{{$empresa->direccion}}. Tel: {{$empresa->telefono}}</label>
            	 </div>  
	</div>
	 <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">  
	 <h3 align="center">REPORTE DE INVENTARIO FISICO</h3>
	 <h5 align="center"><?php  echo  $fecha=date_format(date_create($corteHoy),'d-m-Y h:i:s');?></h5>
	 </div>
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

    <div class="table-responsive">
      
      <table class="table table-striped table-bordered table-condensed table-hover">
        <thead style="background-color: #E6E6E6">

					<th>Codigo</th>
					<th>Nombre</th>
					<th>Existencia</th>
					<th>Kardex</th>
					<th>Costo</th>
          <th>Iva</th>
          <th>Utilidad</th>
          <th>Precio 1</th>
           <th>Utilidad 2</th>
          <th>Precio 2</th>
					
				</thead><?php $count=0; $costo=0;$costoacum=0; $precioacum=0;?>
               @foreach ($lista as $q)
				<tr> <?php $count++; $int=0;$outt=0;
        $costoacum=$q->stock+$costoacum;
		$costo=$costo+($q->costo*$q->stock);
        $precioacum=$q->stock*$q->precio1+$precioacum;
         ?> 

          <td>{{ $q->codigo}}</td>
					<td>{{ $q->nombre}}</td>
					<td>{{ $q->stock}}</td>
					<td>
					 @foreach ($ingreso as $in)
					 <?Php if($in->idarticulo==$q->idarticulo){$int= $in->total; }?>					
					 @endforeach
					  @foreach ($egreso as $out)
					 <?Php if($out->idarticulo==$q->idarticulo){$outt= $out->total; }?>					
					 @endforeach
					 <?php echo number_format( ($int-$outt), 2,',','.'); ?>
					</td>
          <td><?php echo number_format( $q->costo, 2,',','.'); ?></td>
          <td>{{ $q->iva}}</td>
					<td>{{$q->utilidad}} %</td>
					<td><?php echo number_format( $q->precio1, 2,',','.'); ?></td>	
          <td>{{$q->util2}} %</td>
          <td><?php echo number_format( $q->precio2, 2,',','.'); ?></td>  
				</tr>

				@endforeach
        <tr style="background-color: #E6E6E6" >
          <td colspan="2"><?php echo "<strong>Articulos: ".$count."</strong>"; ?></td>
          <td><?php echo "<strong>existencias : ".$costoacum."</strong>"; ?></td>
          <td ><?php echo "<strong>".$costo." $</strong>"; ?></td>
          <td></td>
          <td></td>
          <td><?php echo "<strong>".$precioacum." $</strong>"; ?></td>
          <td></td>     
          <td></td>     
		  <td></td></tr>
			</table>

		</div>
  
  </div>
  <div class="col-lg-12 col-md-12 csol-sm-6 col-xs-12">
                    <div class="form-group" align="center">
                     <button type="button" id="imprimir" class="btn btn-primary" data-dismiss="modal">Imprimir</button>
				<!--	  <a href="/reportes/excel/inventariofisico"><button class="btn btn-warning">TXT</button></a> -->
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
  window.location="/reportes/inventario";
    });

});

</script>

@endpush
         
@endsection