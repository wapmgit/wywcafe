<div class="modal fade modal-slide-in-right" aria-hidden="true"
role="dialog" tabindex="-1" id="mov">
{!!Form::open(array('url'=>'/deposito/regalmacen','method'=>'post','autocomplete'=>'off','id'=>'formreg'))!!}
            {{Form::token()}}
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" 
				aria-label="Close">
                     <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title">Registrar  Movimiento en Almacen</h4>
			</div>
			<div class="modal-body">
				<div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
						<div class="form-group">
            			<label >Concepto</label></br>
                              <input type="text" name="concepto" required class="form-control" value="">
            			
						</div>
					</div>
								<div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
						<div class="form-group">
            			<label >Articulo</label></br>
						<select name="idarticulo" class="form-control">
            				@foreach ($articulo as $cat)
            				<option value="{{$cat->idarticulo}}">{{$cat->nombre}}</option>
            				@endforeach
            			</select>
            			
						</div>
					</div>
				<div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
                   <div class="form-group">
                              <label for="utilidad">Cantidad</label>
                              <input type="number" name="cantidad" required class="form-control" min="1" value="" max="">
                        </div>
                </div>
				<div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
                   <div class="form-group">
                              <label for="utilidad">Tipo</label>
							<select name="tipo" class="form-control">
            				<option value="1">Ingreso</option>
            				<option value="2">Egreso</option>
            			</select>
                        </div>
                </div>

			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
				<button type="submit" class="btn btn-primary">Confirmar</button>
			</div>
		</div>
	</div>
	{{Form::Close()}}

</div>