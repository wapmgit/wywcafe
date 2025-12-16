{!! Form::open(array('url'=>'reportes/ruta','method'=>'GET','autocomplete'=>'off','role'=>'search')) !!}
<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
<div class="form-group">
	<div class="input-group">
	<label for="tipo_precio">Vendedor </label><br>
	<select name="vendedor" class="form-control selectpicker" data-live-search="true">
                            <option value="0">Seleccione..</option> 
						   @foreach ($vendedores as $per)
                           <option value="{{$per -> id_vendedor}}">{{$per -> nombre}}</option> 
                           @endforeach
                        </select>
	</div>
	
</div>
</div>
<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
<div class="form-group">
	<div class="input-group">
     			             <label for="tipo_precio">Ruta </label><br>
            			<select  name="ruta"  class="form-control">
            				@foreach ($rutas as $cat)
            				<option value="{{$cat->idruta}}">{{$cat->nombre}}</option>
            				@endforeach
            			</select>
	</div>
	
</div>
</div>
	<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
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