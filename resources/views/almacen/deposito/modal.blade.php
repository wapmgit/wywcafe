<div class="modal fade modal-slide-in-right" aria-hidden="true"
role="dialog" tabindex="-1" id="modal-agg-{{$deposito->id_deposito}}">
{!!Form::open(array('url'=>'/almacen/deposito/aggdebe','method'=>'POST','autocomplete'=>'off','id'=>'formula'))!!}
            {{Form::token()}}
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" 
				aria-label="Close">
                     <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title">Registrar entrega de Vacios  Reg#{{$deposito->id_deposito}}</h4>
			</div>
			<div class="modal-body">
				<p>Persona: {{$deposito->nombre}}</p>
				<div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
                   <div class="form-group">
                              <label for="utilidad">Cantidad</label>
                              <input type="number" name="cantidad" required class="form-control" min="1" value="">
							  <input type="hidden" name="idreg" class="form-control" value="{{$deposito->id_deposito}}" >
                        </div>
                </div>
								<div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
            	 <div class="form-group">
            			<label >Articulo</label>
            			<select name="idarticulo" class="form-control">
            				@foreach ($articulov as $cat)
            				<option value="{{$cat->idarticulo}}">{{$cat->nombre}}</option>
            				@endforeach
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