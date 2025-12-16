{!! Form::open(array('url'=>'reportes/utilidad','method'=>'GET','autocomplete'=>'off','role'=>'search')) !!}
<div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
<div class="form-group">
	<div class="input-group">
		<input type="date" class="form-control" name="searchText"  value="{{$searchText}}">
	</div>
</div>
</div>

	<div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
	<div class="form-group">
	<div class="input-group">
	<input type="date" class="form-control" name="searchText2" value="{{$searchText2}}">
	</div>
	</div>	
	</div>
	<div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
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
	<div class="input-group">	<input type="checkbox" name="check">Resumido</input>
		<span class="input-group-btn">

		<button type="submit" class="btn btn-primary">consultar</button>
		</span>
		</div>
	</div>
	</div>


		

</div>

{{Form::close()}}