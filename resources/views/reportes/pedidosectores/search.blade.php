{!! Form::open(array('url'=>'/pedido/reporte/sector','method'=>'GET','autocomplete'=>'off','role'=>'search')) !!}
<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
<div class="form-group">
	<div class="input-group">
	<label for="tipo_precio">Filtrar por </label><br>
	<select name="filtro" id="filtro" class="form-control">
                            <option value="0">Seleccione..</option> 
                            <option value="municipios">Municipio</option> 
                            <option value="parroquias">Parroquias</option> 
						
                        </select>
	</div>
	
</div>
</div>
<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
<div class="form-group">
	<div class="input-group">
     			        <label for="tipo_precio"> </label><br>
            			<select name="idm" id="idm" class="form-control" style="display:none">            			                                 
                         @foreach ($municipios as $edo)
                            <option value="{{$edo->id_municipio}}">{{$edo->municipio}}</option>  
                          @endforeach  
            			</select>
								<select name="ids" id="ids" class="form-control" style="display:none">            			                                 
                         @foreach ($sectores as $edo2)
                            <option value="{{$edo2->id_parroquia}}">{{$edo2->parroquia}}</option>  
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