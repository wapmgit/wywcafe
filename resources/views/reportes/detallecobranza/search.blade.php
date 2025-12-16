{!! Form::open(array('url'=>'reportes/detallecobranza','method'=>'GET','autocomplete'=>'off','role'=>'search')) !!}
<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
<div class="form-group">
	<div class="input-group">
		<input type="date" class="form-control" name="searchText"  value="{{$searchText}}">
	</div>
</div>	
</div>
<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
<div class="form-group">
	<div class="input-group">
	<input type="date" class="form-control" name="searchText2" value="{{$searchText2}}">
	</div>
	</div>	
</div>

<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12"  >
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
	</div>
	</div>

<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
		<button type="submit" class="btn btn-primary">consultar</button>
	</div>
</div>

{{Form::close()}}