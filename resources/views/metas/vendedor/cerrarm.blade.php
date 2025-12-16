<div class="modal modal-default" aria-hidden="true"
role="dialog" tabindex="-1" id="cerrarm-{{$meta->idmeta}}">
	{!!Form::open(array('url'=>'/metas/vendedor/cerrar','method'=>'POST','autocomplete'=>'off','id'=>'formularidebito'))!!}
            {{Form::token()}}
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" 
				aria-label="Close">
                     <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title">Cerrar Meta de Vendedor</h4>
			</div>
			<div class="modal-body">
			            <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            	 <div class="form-group">
            			<label >Vincular Comision</label>
            			<select name="pcomision" class="form-control">	
						<option value="0">Seleccione...</option>
            				@foreach ($comision as $cat)
            				<option value="{{$cat->id_comision}}">Monto -> {{$cat->montocomision}}</option>
            				@endforeach
            			</select>
            				<input type="hidden" name="cumplimiento" value="<?php echo $pmeta; ?>" class="form-control" >
						<input type="hidden" name="meta" value="{{$meta->idmeta}}" class="form-control" >
            		</div>
            </div>
			<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            	 <div class="form-group">
            			<label >Metodo de aplicacion de meta</label>
            			<select name="metodo" class="form-control">						
            				<option value="0">% Cumplimiento</option>
            				<option value="1">Total Cumplimiento</option>           			
            			</select>
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
