<div class="modal fade modal-slide-in-right" aria-hidden="true"
role="dialog" tabindex="-1" id="modalrecibos-{{$cliente->id_cliente}}">

	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" 
				aria-label="Close">
                     <span aria-hidden="true">×</span>
                </button>
                
			</div>
			<div class="modal-body">
			<div id="areaimprimir" >
			<h4 class="modal-title">Detalle Recibos </h4>
				  	<table id="ing" class="table table-striped table-bordered table-condensed table-hover">
				<thead>
						<th width="15%">Documento</th>
                          <th>Moneda</th>
						  <th>Recibido</th>
                          <th>Monto</th>
                          <th>Fecha</th>
				</thead>
				<tbody>
               @foreach ($pagos as $p) <?php $acummonto=$acummonto+$p->monto;?>
				<tr>
					<td >{{ $p->tipo_comprobante}} {{ $p->num_comprobante}}</td>
					<td>{{ $p->idbanco}}</td>					
					<td><?php echo number_format($p->recibido, 2,',','.'); ?></td>
					<td><?php echo number_format($p->monto, 2,',','.'); ?></td>		
					<td>{{$p->fecha}}</td>
				</tr>
				@endforeach
			</tbody>
			<tfoot>
						<th>Documento</th>
                          <th>Moneda</th>
						  <th>Recibido</th>
                          <th>Monto</th>
                          <th>Fecha</th>
						  </tfoot>
			</table>
			<label> <button type="button" class="btn bg-navy btn-flat margin"><?php echo "Total Monto: ".$acummonto." $";?></button></label>
			</div>
			<div class="modal-footer">
			<button type="button" id="imprimire" onclick="printdiv('areaimprimir');" class="btn btn-primary" data-dismiss="modal">Imprimir</button>
				<button type="button" id="cerrare"  class="btn btn-default" data-dismiss="modal">Cerrar</button>
			</div>
		</div>
		</div>
	</div>


</div>