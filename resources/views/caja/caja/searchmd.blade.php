{!! Form::open(array('url'=>'/caja/detallef','method'=>'GET','autocomplete'=>'off','role'=>'search')) !!}
<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
<div class="form-group">
	<div class="input-group">
		<label>Desde: </label><input type="date" class="form-control" name="searchText"  value="">
	</div>
</div>
</div>

	<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
	<div class="form-group">
	<div class="input-group">
<label>Hasta:</label>	 <input type="date" class="form-control" name="searchText2" value="">
	</div>
	</div>	
	</div>
	<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
	<input type="hidden" name="id" value="<?php echo $ban; ?>" >
	<div class="form-group">
	<div class="input-group"></br>
	
		<label><button type="submit" class="btn btn-primary">consultar</button></label>
	
		</div>
	</div>
	</div>

	</div>
	
{{Form::close()}}