@extends ('layouts.admin')
@section ('contenido')
@include('pacientes.paciente.empresa')
	<div class="row">
	<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
		<h3>Listado de Vendedores con cuentas por cobrar </a>
	</div>
</div>
<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="table-responsive">
			<table class="table table-striped table-bordered table-condensed table-hover">
				<thead>
				
					<th>Nombre</th>
					<th>Cedula</th>
					<th>Telefono</th>
					<th>Vendedor</th>
					<th>Monto</th>
					
				</thead>
				<?php $total=0; ?>
               @foreach ($vendedores as $cat)
				<?php $saldor=0;?>
				<tr>				
					<td>{{ $cat->vendedor}}</td>
					<td>{{ $cat->cedula}}</td>
					<td>{{ $cat->telefono}}</td>
					<td>{{ $cat->vendedor}}</td>
						@foreach($notas as $n)
								<?php if($n->vendedor==$cat->idvendedor){ $saldor=$n->tnotas;}?>
								@endforeach
					<td><?php $total=$total+ ($cat->acumulado+$saldor); echo number_format( ($cat->acumulado+$saldor), 2,',','.')." $"; ?></td>
					
				</tr>
				@endforeach
				<tr ><td colspan="5"><button type="button" class="btn bg-olive btn-flat margin"><strong><?php echo "Cuentas por Cobrar: ".number_format( $total, 2,',','.')." $";?></strong></button></td></tr>
			</table>
		</div>
		{{$vendedores->render()}}
	<div class="col-lg-12 col-md-12 col-sm-6 col-xs-12">
					   <label>Usuario: </label>  {{ Auth::user()->name }}  
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
  window.location="/vendedor/cobrar";
    });

});

</script>

@endpush
@endsection