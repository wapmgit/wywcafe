<div class="modal modal-warning" aria-hidden="true"
role="dialog" tabindex="-1" id="modaldebito-{{$cliente->id_cliente}}">
	{!!Form::open(array('url'=>'/clientes/cliente/notasadm','method'=>'POST','autocomplete'=>'off','id'=>'formularidebito'))!!}
            {{Form::token()}}
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" 
				aria-label="Close">
                     <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title">Crear Nota de Debito</h4>
			</div>
			<div class="modal-body">
				            <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            	 <div class="form-group">
            			<label for="codigo">Cliente</label>
            			<input type="text" name="cliente"  required  value="{{$cliente->nombre}}" class="form-control" placeholder="Descripcion...">
						<input type="hidden" name="idcliente"  value="{{$cliente->id_cliente}}" class="form-control" >
						<input type="hidden" name="tipo"  value="1" class="form-control" >
            		</div>
            </div>
	            <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            	 <div class="form-group">
            			<label for="codigo">Descripcion</label>
            			<input type="text" name="descripcion"  required  class="form-control" placeholder="Descripcion...">
            		</div>
            </div>
			<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            	 <div class="form-group">
            			<label for="codigo">Referencia</label>
            			<input type="text" name="referencia"  required  class="form-control" placeholder="Referencia...">
            		</div>
            </div>
				<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            	 <div class="form-group">
            			<label for="codigo">Monto</label>
            			<input type="number" name="monto"  required step="0.01" class="form-control" placeholder="Monto...">
            		</div>
            </div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
				<button type="submit" id="btndedito" class="btn btn-primary">Confirmar</button>
			</div>
		</div>
	</div>
	{{Form::Close()}}

</div>
