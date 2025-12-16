{!! Form::open(array('url'=>'ventas/venta','method'=>'GET','autocomplete'=>'off','role'=>'search')) !!}

<div class="form-group">
	<div class="input-group">
		<input type="text" class="form-control" name="searchText" placeholder="Indique nombre de cliente o numero de documento..." value="{{$searchText}}">
		<span class="input-group-btn">
			<button type="submit" class="btn btn-primary ">Buscar</button>
		</span>
	</div>
	<input type="radio" id="huey" name="busca" value="p.nombre" checked />
    <label for="huey">Nombre Cliente</label>
	  <input type="radio" id="dewey" name="busca" value="v.num_comprobante" />
    <label for="dewey">Documento</label>
</div>

{{Form::close()}}
