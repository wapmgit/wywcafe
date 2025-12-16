{!! Form::open(array('url'=>'/detallemeta/obsmetavendedors/','method'=>'GET','autocomplete'=>'off','role'=>'search')) !!}
<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
<div class="form-group">
	<div class="input-group">
		<input type="date" class="form-control" name="searchText"  value="{{$meta->inicio}}">
		<input type="hidden" class="form-control" name="id"  value="{{$meta->idmeta}}">
	</div>
</div>
</div>

	<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
	<div class="form-group">
	<div class="input-group">
	<input type="date" class="form-control" name="searchText2" value="{{$meta->fin}}">
	</div>
	</div>	
	</div>

	<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
	<div class="form-group">
	<div class="input-group">
	<select name="ruta" class="form-control selectpicker" data-live-search="true">
                            <option value="0">Seleccione..</option> 
						   @foreach ($rutas as $per)
                           <option value="{{$per -> idruta}}">{{$per -> nombre}}</option> 
                           @endforeach
                        </select>
						</div>
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