<?php $count2=0;?>
<div class="modal fade modal-slide-in-right" aria-hidden="true"
role="dialog" tabindex="-1" id="modalm">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" 
				aria-label="Close">
                     <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title">Actualizar tasa cuentas por Pagar </h4>
			</div>
			<div class="modal-body">
			<table align="center">
				@foreach ($monedas as $cat1)	<?php $count2++;
				if($cat1->tipo>0){
				?>			
				<tr>
				<td><input id="vmn<?php echo $count2; ?>" type="hidden" value="{{$cat1->idmoneda}}" name="idmoneda" class ="form-control"></input></td>
				<td><input  type="text" readonly value="{{$cat1->nombre}}" name="nombre" class ="form-control"></input></td>
				<td><input type="number" id="valor<?php echo $count2; ?>" value="{{$cat1->valor}}" name="valor" class ="form-control"></input>
				</td>
				<td><a href="javascript:actmonedas('<?php echo $count2; ?>',{{$cat1->idmoneda}},{{$cat1->tipo}});"> <button type="submit" class="btn btn-primary">Actualizar</button><a></td></tr>
				<?php } ?>
					@endforeach
</table>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
				
			</div>
		</div>
	</div>
</div>