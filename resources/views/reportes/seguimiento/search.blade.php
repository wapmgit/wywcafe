{!! Form::open(array('url'=>'reportes/seguimientoclientes','method'=>'GET','autocomplete'=>'off','role'=>'search')) !!}
	<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">	
<div class="form-group">
	<div class="input-group">
	<input type="number" class="form-control" name="dias" value="0">
	</div>
	
</div>
</div>
	<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">	
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
            				@foreach ($rutas as $cat)
            				<option value="{{$cat->idruta}}">{{$cat->nombre}}</option>
            				@endforeach
		</select>
	</div>
	</div>
	<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">	
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