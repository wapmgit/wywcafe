<div class="modal  modal-primary" aria-hidden="true"
role="dialog" tabindex="-1" id="modalcredito-{{$datos->idproveedor}}">
	{!!Form::open(array('url'=>'/proveedores/proveedor/notasadm','method'=>'POST','autocomplete'=>'off','id'=>'formulariocredito'))!!}
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
            			<input type="text" name="cliente" readonly  value="{{$datos->nombre}}" class="form-control" >
            						<input type="hidden" name="idcliente"  value="{{$datos->idproveedor}}" class="form-control" >
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

			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
				<button type="submit" id="btncredito" class="btn btn-primary">Confirmar</button>
			</div>
		</div>
	</div>
	{{Form::Close()}}

</div>
