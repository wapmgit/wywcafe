@extends ('layouts.admin')
@section ('contenido')
<?php $acum=0; $acum2=0;$cont=0;?>
<div class="row">
	<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
		<h3>Detalle de Documentos en Comision Aperturada  </h3>

	</div>
</div>
	
<div class="row">
	  <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">

                 <div class="form-group">
                      <label for="proveedor">Vendedor</label>
                   <p>{{$vendedor->nombre}}</p>
                    </div>   
					<div class="form-group">
                      <label for="proveedor">Cedula</label>
                   <p>{{$vendedor->cedula}}</p>
                    </div>
            </div> 
 
             <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">

                 <div class="form-group">
                      <label for="proveedor">Telefono</label>
                   <p>{{$vendedor->telefono}}</p>
                    </div>
            </div>
			 <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">

                 <div class="form-group">
                      <label for="proveedor"># Comision</label>
                   <p>{{$vendedor->id_comision}}</p>
                    </div>
            </div>
			 <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">

                 <div class="form-group">
                      <label for="proveedor">Fecha</label>
                   <p>{{$vendedor->fecha}}</p>
                    </div>
            </div>
			 <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">

                 <div class="form-group">
                      <label for="proveedor">Monto Comision</label>
                   <p>{{$vendedor->pendiente}} $</p>
                    </div>
            </div>
</div>

<div class="row">
<div class="panel panel-primary">
                <div class="panel-body">
               <div class="modal-content">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="table-responsive">
		
			<table class="table table-striped table-bordered table-condensed table-hover">
				<thead style="background-color: #A9D0F5">
					<th>Cliente</th>
						<th>Cedula</th>
					<th>N° Comprobante</th>
					<th>Fecha Fac.</th>
					<th>Fecha Emi.</th>
					<th>Monto Factura</th>
					<th>Comision</th>
					<th>Monto Comision</th>
									
				</thead>
               @foreach ($venta as $cat)
               <?php $cont++;
               $acum2=$cat->total_venta+$acum2; 
			       $acum=$acum+$cat->montocomision; 
               ?>
			   
				<tr>   <div class="form-group">
				<input type="hidden" name="idventa[]"  value="{{$cat->idventa}}"></div>
					<td><small><small>{{$cat->nombre}}</small></small></td>
					<td><small><small>{{$cat->cedula}}</small></small></td>
					<td><small><small>{{$cat->serie_comprobante}}</td>
					<td><small><small><?php echo date("d-m-Y h:i:s a",strtotime($cat->fecha_hora)); ?></small></small></td>
					<td><small><small><?php echo date("d-m-Y",strtotime($cat->fecha_emi)); ?></small></small></td>
					<td><small><small><?php echo number_format($cat->total_venta, 2,',','.')." $"; ?> </small></small></td>
					<td>{{ $cat->comision}}</td>
					<td><?php echo number_format($cat->montocomision, 2,',','.')." $"; ?> </td>		
				</tr>
				@endforeach
				<tr>
				<td><?php echo $cont." Documentos"; ?></td><td></td><td></td><td></td><td><strong>TOTAL:</strong></td><td style="background-color: #A9D0F5"><?php echo number_format($acum2, 2,',','.')." $"; ?> </td><td></td><td style="background-color: #A9D0F5"><?php echo number_format($acum, 2,',','.')." $"; ?> </td>
				</tr>
			<tr>
				<td colspan="3"></td><td  colspan="2"><strong>Descuento Regla Comi.:</strong></td>
				<td style="background-color: #A9D0F5"><?php echo number_format(($acum-$vendedor->pendiente), 2,',','.')." $"; ?> </td>
				<td>T. Pagar</td><td style="background-color: #A9D0F5"><?php echo number_format($vendedor->pendiente, 2,',','.')." $"; ?> </td>
				</tr>
			<tr><td colspan="8" align="center"> <button type="button" id="imprimir" class="btn btn-primary" data-dismiss="modal">Imprimir</button><a id="enlace" href="/comisiones/comision/pendiente/"> <button type="button" id="pagar" class="btn btn-warning" data-dismiss="modal">Pagar</button></a></td></tr>
			</table>

		</div>
		
	</div>
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
  document.getElementById('pagar').style.display="none";
  document.getElementById('enlace').style.display="none";
  window.print(); 
  document.getElementById('enlace').style.display="";
  document.getElementById('pagar').style.display="";
    });

});

</script>

@endpush

@endsection