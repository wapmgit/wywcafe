{!! Form::open(array('url'=>'reportes/ventas','method'=>'GET','autocomplete'=>'off','role'=>'search')) !!}
<div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
<div class="form-group">
	<div class="input-group">
		<input type="date" class="form-control" name="searchText"  value="{{$searchText}}">
	</div>
	¿Excluir Devolucion? <input type="checkbox"  name="dev" />
</div>
</div>

<div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
	<div class="form-group">
	<div class="input-group">
	<input type="date" class="form-control" name="searchText2" value="{{$searchText2}}">
	</div>
	¿Excluir Pedidos? <input type="checkbox"  name="ped" />
	</div>	
	</div>
		<div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
	<div class="form-check">
  <input class="form-check-input" type="radio" name="opcfecha" value="v.fechahora" id="flexRadioDefault1" checked>
  <label class="form-check-label" for="flexRadioDefault1">
   Emision
  </label>
</div>
<div class="form-check">
  <input class="form-check-input" type="radio" name="opcfecha" value="v.fecha_emi" id="flexRadioDefault2" >
  <label class="form-check-label" for="flexRadioDefault2">
   Despacho
  </label>
</div>
	</div>
<div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
<div class="form-group">
	<div class="input-group">
	<select name="vendedor" class="form-control selectpicker" data-live-search="true">
                            <option value="0">Seleccione..</option> 
						   @foreach ($vendedores as $per)
                           <option value="{{$per -> id_vendedor}}">{{$per -> nombre}}</option> 
                           @endforeach
                        </select>
						</div>
						</div>												
				
</div>
	<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">		
	<div class="form-group">
            	
<select  name="ruta"  id="rutas" class="form-control">
							<option value="0">Seleccione..</option> 
							<option value="1000">Unir Rutas</option> 
            				@foreach ($rutas as $cat)
            				<option value="{{$cat->idruta}}">{{$cat->nombre}}</option>
            				@endforeach
            			</select>
            			
            		</div>
						<div id="divrutaund" style="display:none">
		<div class="form-group">
			<div class="multiselect">
				<div class="selectBox" class="form-control" onclick="showCheckboxes()">
					<select>
						<option>Seleccione Rutas</option>
					</select>
				<div class="overSelect"></div>
				</div>
				<div id="checkboxes">
					@foreach ($rutas as $ru)
					<label for="one">
					<input type="checkbox" name="opt[]" value="{{$ru -> idruta}}" id="one" />{{$ru -> nombre}}</label>
					@endforeach
				</div>
			</div>		
		</div>
	</div>	
	<div class="form-group">
	<div class="input-group">
		<span class="input-group-btn">
		
			<button type="submit" class="btn btn-primary">consultar</button>
		</span>
		</div>
	</div>
	</div>
	
	</div>

{{Form::close()}}