@extends ('layouts.admin')
@section ('contenido')
	<div class="row">
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
			<h3>Nueva Maquinaria</h3>			
			{!!Form::open(array('url'=>'produccion/maquina','method'=>'POST','autocomplete'=>'off'))!!}
            {{Form::token()}}
            <div class="form-group">
            	<label for="nombre">Nombre</label>
            	<input type="text" name="nombre" class="form-control"required placeholder="Nombre...">
            </div>
			   <div class="form-group">
            	<label for="nombre">Marca</label>
            	<input type="text" name="marca" class="form-control" placeholder="Marca...">
            </div>
			<div class="form-group">
            	<label for="nombre">Serie/Modelo</label>
            	<input type="text" name="serie" class="form-control" placeholder="Serie/Modelo...">
            </div>
			<div class="form-group">
            	<label for="nombre">Capacidad</label>
            	<input type="number" name="capacidad" class="form-control" placeholder="Kgs...">
            </div>
		<div class="form-group">
            	<label for="nombre">Tipo</label>
            	<select name="tipo" class="form-control">
            				<option value="1">Trilladora</option>
            				<option value="2">Tostadora</option>
            				<option value="3">Molino</option>
            				<option value="4">Empaquetadora</option>
            			</select>
            </div>
            <div class="form-group">
            	<button class="btn btn-primary" type="submit">Guardar</button>
            	<button class="btn btn-danger" type="reset">Cancelar</button>
            </div>

			{!!Form::close()!!}		
            
		</div>
	</div>
@endsection