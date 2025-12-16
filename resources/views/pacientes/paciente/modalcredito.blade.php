<div class="modal  modal-primary" aria-hidden="true"
role="dialog" tabindex="-1" id="modalcredito-{{$cliente->id_cliente}}">
	{!!Form::open(array('url'=>'/clientes/cliente/notasadm','method'=>'POST','autocomplete'=>'off','id'=>'formulariocredito'))!!}
            {{Form::token()}}
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" 
				aria-label="Close">
                     <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title">Crear Nota de Credito</h4>
			</div>
			<div class="modal-body">
				            <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            	 <div class="form-group">
            			<label for="codigo">Cliente</label>
            			<input type="text" name="cliente"  required  value="{{$cliente->nombre}}" class="form-control" placeholder="Descripcion...">
            						<input type="hidden" name="idcliente"  value="{{$cliente->id_cliente}}" class="form-control" >
						<input type="hidden" name="tipo"  value="2" class="form-control" >
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
            			<input type="number" name="monto"  required  class="form-control" step="0.01" placeholder="Monto...">
            		</div>
            </div>
					<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            	 <div class="form-group">
				 ¿Generar Movimiento en Caja?
						 <input type="checkbox"  name="nc" id="cheknc" />
						 		</div>
            </div>
				<div class="col-lg-3 col-sm-3 col-md-3 col-xs-3" id="divmoneda" style="display:none">
				<div class="form-group">
				<label for="codigo">Moneda</label>
						<select name="pidpago" id="pidpago" class="form-control">
					<option value="10" selected="selected">Seleccione...</option>
						@foreach ($monedas as $m)
							<option value="{{$m->tipo}}_{{$m->idmoneda}}">{{$m->nombre}}</option>
						@endforeach
						</select>
				</div>
				</div>
				<div class="col-lg-3 col-sm-3 col-md-3 col-xs-3" id="divmban" style="display:none">
				<div class="form-group">
				<label for="codigo">Monto Ingreso</label>
				<input type="number" name="montoban" class="form-control" min="0.01" step="0.01">
				</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
				<button type="submit" id="btncredito" class="btn btn-primary">Confirmar</button>
			</div>
		</div>
	</div>
	{{Form::Close()}}

</div>
