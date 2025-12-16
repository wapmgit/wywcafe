{!! Form::open(array('url'=>'/pedido/reporte/reporte','method'=>'GET','autocomplete'=>'off','role'=>'search')) !!}

<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
<div class="form-group">
	<div class="input-group">            	
            			<select name="idvendedor" class="form-control">
						<option value="0">Seleccione</option>
            				@foreach ($vendedor as $cat)
            				<option value="{{$cat->id_vendedor}}">{{$cat->nombre}}</option>
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