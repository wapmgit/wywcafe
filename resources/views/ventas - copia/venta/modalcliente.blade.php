
<div class="modal  modal-primary" aria-hidden="true"
role="dialog" tabindex="-1" id="modalcliente" >
	{!!Form::open(array('url'=>'/ventas/cliente','method'=>'POST','autocomplete'=>'off','id'=>'formulariocliente'))!!}
            {{Form::token()}}

	<div class="modal-dialog" >	
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" 
				aria-label="Close">
                     <span aria-hidden="true">×</span>
                </button>
                <h3 class="modal-title">Nuevo Cliente </h3>
			</div>
			<div class="modal-body">

 	
				<div class="row">
	
					<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
						 <div class="form-group">
							<label for="nombre">Nombre</label>
							<input type="text" name="cnombre" id="cnombre" onchange="conMayusculas(this)" required value="" class="form-control" placeholder="Nombre...">
						</div>
					</div>
					<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
					<div class="form-group">
					<label for="descripcion">Cedula</label>
					<input type="text" name="ccedula" onchange="conMayusculas(this)"  id="vidcedula" class="form-control"  maxlength="15" placeholder="V000000">
				</div>
				</div>
				<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
					  <div class="form-group">
					<label for="descripcion">Telefono</label>
					<input type="text" name="ctelefono" class="form-control" placeholder="0000-0000000">
				</div>
				</div>
								<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
		               <div class="form-group">
            	<label for="descripcion">Licencia</label>
            	<input type="text" name="licencia" id="licencia" class="form-control" maxlength="15" placeholder="00-000">
            </div>
				</div>
				<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
					 <div class="form-group">
				 <label for="direccion">Direccion</label>
				<input type="text" name="cdireccion" class="form-control" placeholder="Direccion...">
			   </div>
				</div>

			   
					 <div class="col-lg-6 col-sm-6 col-md-6 col-xs-6">
					  <div class="form-group">
				 <label for="tipo_cliente">Tipo Cliente</label>
			  <select name="ctipo_cliente" class="form-control">
							   <option value="1" selected>Contado</option>
							   <option value="0">Credito</option>
							  
						   </select>
			   </div>       </div>
			   	 <div class="col-lg-6 col-sm-6 col-md-6 col-xs-6">
			   		              <div class="form-group">
					  <label>Dias Credito</label>
<input type="number" name="diascre" id="diascre" class="form-control"value="1" >
           </div>
			   </div>
			   
					 <div class="col-lg-6 col-sm-6 col-md-6 col-xs-6">
					    <div class="form-group">
            			             <label for="tipo_precio">Vendedor </label><br>
            			<select name="idvendedor" class="form-control">
            				@foreach ($vendedores as $cat)
            				<option value="{{$cat->id_vendedor}}">{{$cat->nombre}}</option>
            				@endforeach
            			</select>
            			
            		</div>
					</div>
					 <div class="col-lg-6 col-sm-6 col-md-6 col-xs-6">
					  <div class="form-group">
				 <label for="tipo_precio">Tipo de Precio </label><br>
				<label for="precio1"> Precio 1 </label> <input name="cprecio" type="radio" value="1" checked="checked">
			 <label for="precio2"> Precio 2 </label> <input name="cprecio" type="radio" value="2">
			   </div>     
									  							
				</div> 
				 <div class="col-lg-6 col-sm-6 col-md-6 col-xs-6">
					<div class="form-group">
            			             <label for="tipo_precio">Ruta </label><br>
            			<select name="ruta" class="form-control">
            				<option value="1">Ruta1</option>
            				<option value="2">Ruta2</option>
            				<option value="3">Ruta3</option>
            				<option value="4">Ruta4</option>
            				<option value="5">Ruta5</option>
            				<option value="6">Ruta6</option>
            				<option value="7">Ruta7</option>
            			</select>
            			
            		</div>
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
			

	</div>
		{!!Form::close()!!}		

</div>


  
	
   