
<div class="modal fade modal-slide-in-right" aria-hidden="true"
role="dialog" tabindex="-1" id="modalcliente">
	{!!Form::open(array('url'=>'/ventas/cliente','method'=>'POST','autocomplete'=>'off','id'=>'formulariocliente'))!!}
            {{Form::token()}}
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" 
				aria-label="Close">
                     <span aria-hidden="true">×</span>
                </button>
                <h5 class="modal-title">Nuevo Cliente </h5>
			</div>
			<div class="modal-body">

 	
				<div class="row">
	
					<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
						 <div class="form-group">
							<label for="nombre">Nombre</label>
							<input type="text" name="cnombre" id="cnombre" required value="" class="form-control" placeholder="Nombre...">
						</div>
					</div>
					<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
					<div class="form-group">
					<label for="descripcion">cedula</label>
					<input type="text" name="ccedula" class="form-control" placeholder="cedula...">
				</div>
				</div>
				<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
					  <div class="form-group">
					<label for="descripcion">Telefono</label>
					<input type="text" name="ctelefono" class="form-control" placeholder="Telefono...">
				</div>
				</div>
				<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
					 <div class="form-group">
				 <label for="direccion">direccion</label>
				<input type="text" name="cdireccion" class="form-control" placeholder="direccion...">
			   </div>
				</div>

			   
					 <div class="col-lg-6 col-sm-6 col-md-6 col-xs-6">
					  <div class="form-group">
				 <label for="tipo_cliente">Tipo cliente</label>
			  <select name="ctipo_cliente" class="form-control">
							   <option value="1" selected>Contado</option>
							   <option value="0">Credito</option>
							  
						   </select>
			   </div>       </div>
					 <div class="col-lg-6 col-sm-6 col-md-6 col-xs-6">
					  <div class="form-group">
				 <label for="tipo_precio">Tipo de Precio </label><br>
				<label for="precio1"> Precio 1 </label> <input name="cprecio" type="radio" value="1" checked="checked">
			 <label for="precio2"> Precio 2 </label> <input name="cprecio" type="radio" value="2">
			   </div>      </div>
					 
					  
							
				</div> 

	
			</div><div class="modal-footer">
			 <div class="form-group">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
				  <input name="_token" value="{{ csrf_token() }}" type="hidden" ></input>
				<button type="button" id="Cenviar" class="btn btn-primary" >Confirmar</button>
				</div>
			</div>
		</div>
			
	</div>
	
		{!!Form::close()!!}		

</div>


  
	
   