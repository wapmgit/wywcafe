<div class="modal modal-default" aria-hidden="true"
role="dialog" tabindex="-1" id="modal-ajuste-{{$re->idarticulo}}">
{!!Form::open(array('url'=>'/metas/vendedor/ajustar','method'=>'POST','autocomplete'=>'off'))!!}
            {{Form::token()}}
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" 
				aria-label="Close">
                     <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title">Ajustar Cantidad en Meta</h4>
			</div>
			<div class="modal-body">
				<p>Indique nueva Cantidad para: {{$re->nombre}}</p>
					<input type="number" name="ncantidad" value="{{$re->cantidad}}" step="0.01" min ="0" class="form-control">
						<input type="hidden" name="iddetalle" value="{{$re->id}}" class="form-control">
						<input type="hidden" name="idmeta" value="{{$re->idmeta}}" class="form-control">
						<input type="hidden" name="cntold" value="{{$re->cantidad}}" class="form-control">
						<input type="hidden" name="valorold" value="{{$re->valor}}" class="form-control">
						<input type="hidden" name="tipo" value="0" class="form-control">
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
				<button type="submit" class="btn btn-primary">Confirmar</button>
			</div>
		</div>
	</div>
	{{Form::Close()}}

</div>