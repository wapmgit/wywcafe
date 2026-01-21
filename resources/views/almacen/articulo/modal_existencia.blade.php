<div class="modal fade modal-slide-in-right" aria-hidden="true"
role="dialog" tabindex="-1" id="modal-existencia-{{$cat->idarticulo}}">

	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" 
				aria-label="Close">
                     <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title">Existencia</h4>
			</div>
			<div class="modal-body">
			<div align="center">
				<table border="0">
				<tr><td><strong>Almacen</strong></td><td></td><td><strong>Cantidad</strong></td></tr>
				 @foreach ($existencia as $ex)
				 <?php if ($cat->idarticulo==$ex->idarticulo){
					 $acumexistencia=$acumexistencia+$ex->existencia;
					 ?>
				<tr><td>{{$ex->nombre}}</td><td> -> </td><td align="center">{{$ex->existencia}}</td></tr>
				 <?php } ?>
				@endforeach<tr><td align="center"><strong>Total: <?php echo $acumexistencia; ?></strong></td></tr>
				</table>
			</div>
</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
			</div>
		</div>
	</div>
</div>