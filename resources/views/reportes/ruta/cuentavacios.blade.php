@extends ('layouts.admin')
<?php $mostrar=0; ?>
@section ('contenido')
<?php $mostrar=1; 
?>
<?php $acum=0;$efe=0;$deb=0;$che=0;$tra=0;
$cefe=0;?>
@include('reportes.ruta.empresa')
<div class="row">    
<div class="panel-body">
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

    <h3 align="center">REPORTE DE VACIOS </h3> 
  </div>
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
  <div class="table-responsive">
<table width="95%">
							<thead style="background-color: #E6E6E6">
								<th>Articulo</th>
								<th>Debe</th>
								<th>Debo</th>
							</thead>
							<?php $total=0;$agg=0; $rece=0; $count=0; ?>
						   @foreach ($mov as $cat)
						<?php $count++; $agg=$cat->debe+$agg; $rece=$cat->debo+$rece;?>
							<tr <?php if($count%2==0){ echo "style='background-color: #E6E6F6'"; } ?>>
								<td><small>{{$cat->nombre}}</small></td>
								<td><small>{{ $cat->debe}}</small></td>
								<td><small>{{ $cat->debo}}</small></td>
							</tr>
							@endforeach
							<tr><td><strong>Total: <?php echo $count; ?></strong></td>
							<td><?php echo $agg;?></td><td><?php echo $rece;?></td>
							
							</tr>
						</table>
</div>
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
  window.location="/reportes/vacios";
    });

});

</script>

@endpush
@endsection