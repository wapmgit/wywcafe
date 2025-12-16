{!! Form::open(array('url'=>'reportes/compras','method'=>'GET','autocomplete'=>'off','role'=>'search')) !!}

<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
<div class="form-group">
	<div class="input-group">
		<input type="date" class="form-control" name="searchText"  value="{{$searchText}}">
	</div>
</div>
</div>

	<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 col-xs-12">
	<div class="form-group">
	<div class="input-group">
	<input type="date" class="form-control" name="searchText2" value="{{$searchText2}}">
	</div>
	</div>	
	</div>
<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
<div class="form-group">
	<div class="input-group">
	<select name="tipodoc" class="form-control selectpicker" data-live-search="true">
                        <option value="">Tipo Documento:</option> 
                        <option value="FAC">Facturas</option>
						<option value="N/E">Notas de Entrega</option>						   
                          
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