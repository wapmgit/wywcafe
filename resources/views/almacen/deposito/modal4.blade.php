<div class="modal fade modal-slide-in-right" aria-hidden="true"
role="dialog" tabindex="-1" id="rdebo-{{$det->iddetalle}}">
{!!Form::open(array('url'=>'/almacen/deposito/recepdebo','method'=>'POST','autocomplete'=>'off','id'=>'formula2'))!!}
            {{Form::token()}}
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" 
				aria-label="Close">
                     <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title">Registrar  Recepcion de Vacios b  Reg#{{$det->idregistro}}</h4>
			</div>
			<div class="modal-body">
				<p>Persona: {{$deposito->nombre}}</p>
				<div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
                   <div class="form-group">
                              <label for="utilidad">Cantidad</label>
                              <input type="number" name="cantidad" required class="form-control" min="1" value="" max="<?php echo $cntb; ?>" placeholder="<?php echo $cntb; ?>">
							  <input type="hidden" name="idreg" class="form-control" value="{{$det->idregistro}}" >
                        </div>
                </div>
<div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
            	 <div class="form-group">
            			<label >Articulo</label></br>
  	<input type="hidden" value="{{$det->idarticulo}}" class="form-control" name="idarticulo" >
							<label>{{$det->nombre}}</label>
            			
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