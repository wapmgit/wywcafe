{!! Form::open(array('url'=>'pacientes/cobrar/listacobrar','method'=>'GET','autocomplete'=>'off','role'=>'search')) !!}
<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
<div class="form-group">
	<div class="input-group">
	<select name="vendedor" class="form-control selectpicker" data-live-search="true">
                            <option value="0">Seleccione..</option> 
						   @foreach ($vendedores as $per)
                           <option value="{{$per -> id_vendedor}}">{{$per -> nombre}}</option> 
                           @endforeach
                        </select>
		<span class="input-group-btn">
			<button type="submit" class="btn btn-primary">Buscar</button>
		</span>
	</div>
	
</div>
</div>
{{Form::close()}}