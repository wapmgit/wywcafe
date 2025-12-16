
<div class="modal  modal-primary" aria-hidden="true"
role="dialog" tabindex="-1" id="modalload">
	{!!Form::open(array('url'=>'compras/ajuste/loadcsv','method'=>'POST','autocomplete'=>'off','id'=>'formcsv','files'=>'true'))!!}
            {{Form::token()}}
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" 
				aria-label="Close">
                     <span aria-hidden="true">×</span>
                </button>
                <h3 class="modal-title">Importar archivo CSV </h3>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
						 <div class="form-group">
							<label for="nombre">Importar Archivo</label>
						<input type="file"  class="form-control" name="sel_file" id="capcsv" size="20">
						 <input type="hidden" value="" id="responsablemodal" name="responsablemodal" class="form-control">
						 <input type="hidden" value="" id="conceptomodal" name="conceptomodal" class="form-control">
						</div>
					</div>            
				</div> 
			</div>
			<div class="modal-footer">
				<div class="form-group">
					<button type="button" class="btn btn-default" id="cancelarcsv" data-dismiss="modal">Cerrar</button>
					<button type="submit" class="btn btn-primary" id="Nenviarcsv">Confirmar</button>
					<div style="display: none" id="loadingcsv">  <img src="{{asset('imagenes/sistema/loading30.gif')}}"></div>
				</div>
			</div>
		</div>
			
	</div>
		{!!Form::close()!!}		
</div>

      
  
