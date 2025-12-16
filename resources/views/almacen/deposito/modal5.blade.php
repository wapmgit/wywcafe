<div class="modal fade modal-slide-in-right" aria-hidden="true"
role="dialog" tabindex="-1" id="edo-{{$cat->id_deposito}}">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" 
				aria-label="Close">
                     <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title">Saldo de vacios #{{$cat->id_deposito}}</h4>
			</div>
			<div class="modal-body">
				<p>Persona: {{$cat->nombre}}</p>
			<div class="col-lg-6 col-sm-6 col-md-6 col-xs-6">
            	 <div class="form-group">
            			<label >Registros</label></br>
            				@foreach ($edovacios as $ed)
							<?php if(($ed->idregistro==$cat->id_deposito)and($ed->tipo==1)and($ed->tiporeg==1)) {?>
            				<label>{{$ed->nombre}}  {{$ed->cntagg}}</label>
							<?php } ?>
            				@endforeach            			
            		</div>
                </div>
							<div class="col-lg-6 col-sm-6 col-md-6 col-xs-6">
            	 <div class="form-group">
            			<label >Recepciones</label></br>
            				@foreach ($edovacios as $ed)
							<?php if(($ed->idregistro==$cat->id_deposito)and($ed->tipo==1)and($ed->tiporeg==2)) {?>
            				<label>{{$ed->nombre}}  {{$ed->cntagg}}</label>
							<?php } ?>
            				@endforeach            			
            		</div>
                </div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
				<button type="submit" class="btn btn-primary">Confirmar</button>
			</div>
		</div>
	</div>
</div>