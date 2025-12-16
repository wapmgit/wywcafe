{!! Form::open(array('url'=>'/almacen/articulo/grafico/','method'=>'GET','autocomplete'=>'off','role'=>'search')) !!}
<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12"  >
	<div class="form-group">
	<div class="input-group">
		<span class="input-group-btn">
		<select name="articulo" id="idcliente" class="form-control selectpicker" data-live-search="true">
                            <option value="0">Seleccione..</option> 
						   @foreach ($articulo as $cli)
                           <option value="{{$cli -> idarticulo}}">{{$cli -> nombre}}</option> 
                           @endforeach
                        </select>
		</span>
		</div>
	</div>
</div><div class="col-lg-3 col-md-3 col-sm-3 col-xs-12"  >
		<select name="vendedor" id="idvendedor" class="form-control selectpicker" data-live-search="true">
                            <option value="0">Seleccione..</option> 
						   @foreach ($vendedores as $per)
                           <option value="{{$per -> id_vendedor}}">{{$per -> nombre}}</option> 
                           @endforeach
                        </select>
	</div>

	<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12"  >
		<button type="submit" class="btn btn-primary">consultar</button>
	</div>
</div>

{{Form::close()}}