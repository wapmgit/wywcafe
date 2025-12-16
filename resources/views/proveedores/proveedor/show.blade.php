@extends ('layouts.admin')
@section ('contenido')
<style type="text/css">
#capa{
	height: 700px;
	width: 100%;
	border: 1px solid #ddd;
	background: #f1f1f1;
	overflow-y: scroll;
}
</style>
<?php  $acummonto=0; $contnc=0; $saldonc=0; ?>
<div class="row">

	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<h3>Estado de Cuenta del Proveedor</h3>
	</div> 
	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                 <div class="form-group">
                      <label for="direccion">Cliente:</label> {{$datos->rif}} - {{$datos->nombre}}            
                    </div>
    </div>

				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                 <div class="form-group">
                      <label for="direccion">Contacto:</label> {{$datos->contacto}} - {{$datos->telefono}}
                    </div>
    </div>
		<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                 <div class="form-group">
                      <label for="direccion">Direccion:</label> {{$datos->direccion}}
                    </div>
    </div>
<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4" id="divbotones">
                 <div class="form-group">
				 <a href="href="" data-target="#modalcredito-{{$datos->idproveedor}}" data-toggle="modal"><button class="btn btn-primary">N. Credito</button></a>
					<a href="{{URL::action('CxpagarController@show',$datos->idproveedor)}}"><button class="btn btn-info">Abono</button></a>
                    <a href="href="" data-target="#modalrecibos-{{$datos->idproveedor}}" data-toggle="modal"><button class="btn">Recibos</button></a>
					</div>
			</div>

</div>
@include('proveedores.proveedor.modalcredito')
@include('proveedores.proveedor.modalrecibos')
<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="table-responsive">
		<div id="capa">
			<table class="table table-striped table-bordered table-condensed table-hover">
				<thead>
					<th>Documento</th>
					<th>Fecha</th>
					<th>Monto Fac.</th>
					<th>Base Imponible</th>
					<th>IVA</th>
					<th>exento</th>
					<th>Por Pagar</th>

							
				</thead>
				<?php $comprado=0; $acum=0; $base=$exento=$iva=$pagar=0; $saldo=0; $cont=0;?>
               @foreach ($compras as $cat)
			   <?php $comprado=$comprado+$cat->total;  
			   $saldo=$saldo+$cat->saldo; 
			   $base=$base+$cat->base;
			   $exento=$exento+$cat->exento; 
			   $iva=$iva+$cat->miva;
			   $cont++; 
			   ?>
				<tr>
					<td>{{ $cat->tipo_comprobante}}-{{ $cat->serie_comprobante}} {{ $cat->num_comprobante}}</td>
					<td>{{ $cat->fecha_hora}}</td>
					<td>{{ $cat->total}}</td>
					<td>{{ $cat->base}}</td>
					<td>{{ $cat->miva}}</td>
					<td>{{ $cat->exento}}</td>
					<td>{{ $cat->saldo}}</td>				
				</tr>
				@endforeach
				<tr>
				@foreach ($gastos as $go)
			   <?php 
			   $saldo=$saldo+$go->saldo; 
			   $cont++; 
			   ?>
				<tr>
					<td>GTO-{{$go->documento}}</td>
					<td>{{ $go->fecha}}</td>
					<td>{{ $go->monto}}</td>
					<td>{{ $go->monto}}</td>
					<td></td>
					<td></td>
					<td>{{ $go->saldo}}</td>				
				</tr>
				@endforeach
					@foreach ($notas as $not)
				<tr>
					<td> N/C - {{$not->idnota}} {{ $not->referencia}} <?php 
						 $saldonc=$saldonc+$not->pendiente;  
						   
						 $contnc++; ?> </td>
					
					<td><?php echo date("d-m-Y",strtotime($not->fecha)); ?></td>
				
					<td>{{ $not->monto}}			
					</td>
					<td></td>
					<td></td>
					<td></td>
					<td>{{ $not->pendiente}}</td>				
				</tr>
				@endforeach
				<tr><td><strong>Facturas: <?php echo $cont." -> N/C: ".$contnc;  ?></strong></td><td></td>
				<td><strong><?php echo $comprado; ?> $.</strong></td>
				<td><strong><?php echo $base; ?> $.</strong></td>
				<td><strong><?php echo $iva; ?> $.</strong></td>
				<td><strong><?php echo $exento; ?> $.</strong>
				</td><td><strong><?php echo $saldo; ?> $.</strong></td></tr>
			</table>
			</div>
		</div>

	</div>
	     <div class="col-lg-12 col-md-12 col-sm-6 col-xs-12">
                    <div class="form-group" align="center">
                     <button type="button" id="imprimir" class="btn btn-primary" data-dismiss="modal">Imprimir</button>
					 <button type="button" id="regresar" class="btn btn-danger" data-dismiss="modal">Regresar</button>
                    </div>
                </div>  
</div>
@push ('scripts')
<script>
$(document).ready(function(){
	  $('#ing').DataTable();	
	  
    $('#imprimir').click(function(){
  //  alert ('si');   
  document.getElementById('divbotones').style.display="none";
  document.getElementById('imprimir').style.display="none";
  document.getElementById('regresar').style.display="none";

  window.print(); 
  window.location="/proveedores/proveedor";
    });
$('#regresar').on("click",function(){
  window.location="/proveedores/proveedor";
  
});
});
</script>
@endpush
@endsection