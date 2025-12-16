{!! Form::open(array('url'=>'reportes/listaclientes','method'=>'GET','autocomplete'=>'off','role'=>'search')) !!}
			<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
           <div class="form-group">
             <label for="categoria">Categoria Comercial</label>
				<select name="categoria" class="form-control">
						<option value="0">Seleccione</option>
            				@foreach ($catclientes as $cat)
            				<option value="{{$cat->idcategoria}}">{{$cat->nombrecategoria}}</option>
            				@endforeach
            			</select>
           </div>
		   </div>
				<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
           <div class="form-group">
             <label for="categoria">Vendedores</label>
				<select name="vendedor" class="form-control">
				<option value="0">Seleccione</option>
            				@foreach ($vendedores as $cat)
            				<option value="{{$cat->id_vendedor}}">{{$cat->nombre}}</option>
            				@endforeach
            			</select>
           </div>
		   </div>
			<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
           <div class="form-group">
             <label for="categoria">Ruta</label>
				<select name="ruta" class="form-control">
				<option value="0">Seleccione</option>
            				@foreach ($rutas as $cat)
            				<option value="{{$cat->idruta}}">{{$cat->nombre}}</option>
            				@endforeach
            			</select>
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