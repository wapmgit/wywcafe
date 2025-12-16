<div class="modal fade modal-slide-in-right" aria-hidden="true"
role="dialog" tabindex="-1" id="actstock-{{$articulo->idarticulo}}">
{!!Form::open(array('url'=>'/almacen/articulo/actstock','method'=>'POST','autocomplete'=>'off','id'=>'formula2'))!!}
            {{Form::token()}}
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" 
				aria-label="Close">
                     <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title">Recalcular</h4>
			</div>
			<div class="modal-body">
				<p> ¿ Confirma Recalcular Stock ?</p>
		<input type="hidden" name="id" value="{{$articulo->idarticulo}}" class="form-control">
		<input type="hidden" name="exis" value="{{$exis}}" class="form-control">
			</div>
			
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
				<button type="submit" class="btn btn-primary">Confirmar</button>
			</div>
		</div>
	</div>
	{{Form::Close()}}

</div>