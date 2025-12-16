
<div class="modal fade modal-slide-in-right" aria-hidden="true"
role="dialog" tabindex="-1" id="modaleditar{{$cat->idretencion}}_{{$cat->afiva}}">
	{!!Form::open(array('url'=>'/cxp/proveedor/ajustecorre','method'=>'POST','autocomplete'=>'off'))!!}
            {{Form::token()}}
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" 
				aria-label="Close">
                     <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title">Ajustar N° de Retencion </h4>
			</div>
			<div class="modal-body">
				<p align="center">¿Confirme si desea Ajustar numero de Retencion? -> {{$cat->correlativo}}
				<input type="hidden" value="{{$cat->idretencion}}_{{$cat->afiva}}" name="idret"></input></br></br>
				<label> Indique nuevo Numero:</label>
				<input type="number" value="" step="1" min ="1" name="ncorre"></input> </br></br>
				Desea afectar numeracion de Proxima retencion?
					<input type="checkbox" name="ajuste" >
				</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
				<button type="submit" class="btn btn-primary">Confirmar</button>
			</div>
		</div>
	</div>
	{{Form::Close()}}

</div>
