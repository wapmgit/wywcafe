{!! Form::open(array('url'=>'reportes/corte','method'=>'GET','autocomplete'=>'off','role'=>'search')) !!}
<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
<div class="form-group">
	<div class="input-group">
		<input type="date" class="form-control" name="searchText"  value="{{$searchText}}">
	</div>
</div>
</div>

	<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
	<div class="form-group">
	<div class="input-group">
	<input type="date" class="form-control" name="searchText2" value="{{$searchText2}}">
	</div>
	</div>	
	</div>

	<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
	<div class="form-group">
	<div class="input-group">
	<select name="usuario" class="form-control selectpicker" data-live-search="true">
                            <option value="0">Seleccione..</option> 
						   @foreach ($usuario as $per)
                           <option value="{{$per -> name}}">{{$per -> name}}</option> 
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