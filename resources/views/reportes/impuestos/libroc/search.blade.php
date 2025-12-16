{!! Form::open(array('url'=>'/informes/libroc','method'=>'GET','autocomplete'=>'off','role'=>'search')) !!}

			<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
				<div class="form-group">
				<div class="input-group">
					<input type="date" class="form-control" name="searchText"  value="{{$searchText}}">
				</div>
				</div>
			</div>
			<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
				<div class="form-group">
				<div class="input-group">
					<input type="date" class="form-control" name="searchText2" value="{{$searchText2}}">
				</div>
				</div>	
			</div>
				<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
<fieldset>
  <div>
    Moneda: <input type="radio" id="huey" name="moneda" value="1" checked />
    <label for="huey">Bs</label>  
	<input type="radio" id="dewey" name="moneda" value="2" />
    <label for="dewey">$</label>
  </div>
</fieldset>
</div>
			<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
				<div class="form-group">
				<div class="input-group">
					<span class="input-group-btn">
						<button type="submit" class="btn btn-primary btn-sm">consultar</button>
					</span>
				</div>
				</div>
			</div>
</div>
{{Form::close()}}