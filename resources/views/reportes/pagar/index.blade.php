@extends ('layouts.admin')
<?php $mostrar=0; ?>
  @if(Auth::user()->nivel=="A")
@section ('contenido')
<?php $mostrar=1; ?>
@endsection
@endif
<?php $acum=0;$efe=0;$deb=0;$che=0;$tra=0;
$cefe=0;?>
@section('reporte') 
@include('reportes.pagar.empresa')
<div class="row">
<div class="panel-body">   

  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
  	<div class="table-responsive">
<table class="table table-striped table-bordered table-condensed table-hover">
							<thead style="background-color: #E6E6E6">
								<th>Documento</th>
								<th>Proveedor</th>
								<th>Contacto</th>
								<th>Cedula</th>
								<th>Telefono</th>
								<th>Direccion</th>
								<th>Fecha Fac.</th>
								<th>Usuario</th>
								<th>Monto</th>
								
							</thead>
							<?php $total=0; $count2=$count=0; ?>
						   @foreach ($pacientes as $cat)						
							<tr>
								<td>{{ $cat->tipo_comprobante}}-{{$cat->num_comprobante}}</td>
								<td>{{ $cat->nombre}}</td>
								<td>{{ $cat->contacto}}</td>
								<td>{{ $cat->rif}}</td>
								<td>{{ $cat->telefono}}</td>
								<td>{{ $cat->direccion}}</td>
								<td><?php echo date("d-m-Y h:i:s s",strtotime($cat->fecha_hora)); ?></td>
								<td>{{$cat->user}}</td>
								<td><?php $count++; $total=$total+$cat->acumulado; echo number_format( $cat->acumulado, 2,',','.')." $"; ?></td>
							</tr>
							@endforeach
							@foreach ($gastos as $cat)						
							<tr>
								<td>GTO-{{$cat->documento}}</td>
								<td>{{ $cat->nombre}}</td>
								<td>{{ $cat->contacto}}</td>
								<td>{{ $cat->rif}}</td>
								<td>{{ $cat->telefono}}</td>
								<td>{{ $cat->direccion}}</td>
								<td><?php echo date("d-m-Y h:i:s s",strtotime($cat->fecha)); ?></td>
								<td>{{$cat->usuario}}</td>
								<td><?php $count2++; $total=$total+$cat->saldo; echo number_format( $cat->saldo, 2,',','.')." $"; ?></td>
							</tr>
							@endforeach
							<tr><td>Documentos: <?php echo $count+$count2; ?></td>
							<td colspan="6"></td><td><strong>Total:</strong></td><td><strong><?php echo number_format( $total, 2,',','.')." $"; ?></strong></td>
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
  window.location="../reportes/pagar";
    });

});

</script>

@endpush
@endsection