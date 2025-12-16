@extends ('layouts.admin')
@section ('contenido')

<div class="panel panel-primary">
<div class="panel-body">
 @include('reportes.valorizado.empresa')
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="table-responsive">
      <table class="table table-striped table-bordered table-condensed table-hover">
        <thead style="background-color: #E6E6E6" >
					<th>Codigo</th>
					<th>Nombre</th>
					<th>Existencia</th>
					<th>costo</th>
          <th>Valorizado costo</th>
          <th>Precio</th>
          <th>Valorizado precio</th>
					
				</thead><?php $count=0; $costoacum=0; $precioacum=0;?>
               @foreach ($lista as $q)
				<tr> <?php $count++; 
        $costoacum=$q->costo*$q->stock+$costoacum;
        $precioacum=$q->stock*$q->precio1+$precioacum;
         ?> 

          <td>{{ $q->codigo}}</td>
					<td>{{ $q->nombre}}</td>
					<td>{{ $q->stock}}</td>
          <td><?php echo number_format( $q->costo, 2,',','.'); ?></td>
          <td><?php echo number_format( ($q->costo*$q->stock), 2,',','.'); ?></td>
					<td><?php echo number_format( $q->precio1, 2,',','.'); ?></td>
					<td><?php echo number_format( ($q->stock*$q->precio1), 2,',','.'); ?></td>	
				</tr>

				@endforeach
        <tr style="background-color: #E6E6E6" ><td><?php echo "<strong>total: ".$count."</strong>"; ?></td><td></td><td></td><td></td><td><?php echo "<strong>".number_format( $costoacum, 2,',','.')."</strong> $";  ?></td><td></td><td><?php echo "<strong>".number_format( $precioacum, 2,',','.')."</strong> $"; ?></td></tr>
			</table>
      
		</div>
  
  </div>
  <div class="col-lg-12 col-md-12 col-sm-6 col-xs-12">
                    <div class="form-group" align="center">
                     <button type="button" id="imprimir" class="btn btn-primary" data-dismiss="modal">Imprimir</button>
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
  window.location="/reportes/valorizado";
    });

});

</script>

@endpush   
@endsection