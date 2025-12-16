{!! Form::open(array('url'=>'reportes/ventasarticulo','method'=>'GET','autocomplete'=>'off','role'=>'search')) !!}
<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12"  >
<div class="form-group">
	<div class="input-group">
		<input type="date" class="form-control" name="searchText"  value="{{$searchText}}">
	</div>
</div>	
</div>
<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12"  >
<div class="form-group">
	<div class="input-group">
	<input type="date" class="form-control" name="searchText2" value="{{$searchText2}}">
	</div>
	</div>	
</div>
		<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12"  >
	<input type="radio" name="fecha" value="fecha_emi" checked >Fecha Despacho<br>
    <input type="radio" name="fecha" value="fechahora"> Fecha Emision<br>
	</div>
<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12"  >
	<div class="form-group">
           <div class="form-group">
		<select name="opcion" id="filtro" class="form-control">
                            <option value="0">Filtrar por:</option> 
                            <option value="1">Vendedor</option> 
                            <option value="2">Cliente</option> 
							<option value="3">Ruta</option> 
							<option value="4">Rutas Unidas</option> 
                        </select>						
           </div>

	</div>	
	</div>
<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12"  >
<div id="divcli" style="display:none">
	<div class="form-group">
	<div class="input-group">
		<span class="input-group-btn">
		<select name="cliente" id="idcliente" class="form-control selectpicker" data-live-search="true">
                            <option value="0">Seleccione..</option> 
						   @foreach ($clientes as $cli)
                           <option value="{{$cli -> id_cliente}}">{{$cli -> nombre}}</option> 
                           @endforeach
                        </select>
		</span>
		</div>
	</div>
	</div>
	<div id="divend" style="display:none">
		<div class="form-group">
	<div class="input-group">
		<span class="input-group-btn">
		<select name="vendedor" id="idvendedor" class="form-control selectpicker" data-live-search="true">
                            <option value="0">Seleccione..</option> 
						   @foreach ($vendedor as $per)
                           <option value="{{$per -> id_vendedor}}">{{$per -> nombre}}</option> 
                           @endforeach
                        </select>
		
		</span>
		</div>
					<select  name="ruta"  class="form-control">
					<option value="0">Todas las Rutas</option>
            				@foreach ($rutas as $cat)
            				<option value="{{$cat->idruta}}">{{$cat->nombre}}</option>
            				@endforeach
            			</select>
	</div>
	</div>	
	<div id="divruta" style="display:none">
	<div class="form-group">
	<div class="input-group">
		<span class="input-group-btn">
	<select  name="rutafiltro"  class="form-control">
            				@foreach ($rutas as $cat)
            				<option value="{{$cat->idruta}}">{{$cat->nombre}}</option>
            				@endforeach
            			</select>
		</span>
		</div>
	</div>
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
	</div>

	<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12"  >
		<button type="submit" class="btn btn-primary">consultar</button>
	</div>
</div>

{{Form::close()}}