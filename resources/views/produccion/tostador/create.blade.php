@extends ('layouts.admin')
@section ('contenido')
	<div class="row">
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
			<h3>Nuevo Tostador</h3>			
			{!!Form::open(array('url'=>'produccion/tostador','method'=>'POST','autocomplete'=>'off'))!!}
            {{Form::token()}}
            <div class="form-group">
            	<label for="nombre">Nombre</label>
            	<input type="text" name="nombre" class="form-control"required placeholder="Nombre...">
            </div>
			   <div class="form-group">
            	<label for="nombre">Telefono</label>
            	<input type="text" name="telefono" class="form-control" placeholder="Telefono...">
            </div>
						   <div class="form-group">
            	<label for="nombre">Direccion</label>
            	<input type="text" name="direccion" class="form-control" placeholder="Direccion...">
            </div>
            <div class="form-group">
            	<button class="btn btn-primary" type="submit">Guardar</button>
            	<button class="btn btn-danger" type="reset">Cancelar</button>
            </div>

			{!!Form::close()!!}		
            
		</div>
	</div>
@endsection