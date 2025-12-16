{!! Form::open(array('url'=>'reportes/catalogo','method'=>'GET','autocomplete'=>'off','role'=>'search')) !!}


	<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
	
	<select name="grupo" class="form-control selectpicker" data-live-search="true">
                            <option value="0">Seleccione..</option> 
						   @foreach ($grupo as $per)
                           <option value="{{$per -> idcategoria}}">{{$per -> nombre}}</option> 
                           @endforeach
                        </select>
		
</div>
	<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
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