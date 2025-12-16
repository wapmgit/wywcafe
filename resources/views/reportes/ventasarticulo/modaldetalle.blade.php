<div class="modal fade modal-slide-in-right" aria-hidden="true"
role="dialog" tabindex="-1" id="modaldetalle{{$q->idarticulo}}">

	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" 
				aria-label="Close">
                     <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title">Detalle de Clientes </h4>			
				
			</div>				
			<div class="modal-body"><div class="col-lg-8 col-md-8 col-sm-8 col-xs-8"> <strong>Cliente</strong> </div>		
			<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4" align="center"><strong> Cantidad</strong></div>	
			@foreach ($datoscli as $dt)
			<?php if($q->idarticulo==$dt->idarticulo){?>
			<div class="col-lg-8 col-md-8 col-sm-8 col-xs-8"> {{$dt->nombre}} </div>		
			<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4" align="center"> {{$dt->cantidad}}</div>		
			<?php } ?>
			@endforeach
			</div>
			<br>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
			
			</div>
		</div>
	</div>


</div>
