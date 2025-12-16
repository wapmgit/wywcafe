@extends ('layouts.admin')
@section ('contenido')
		<div class="row">
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
			<h3>Nuevo Paciente</h3>
			@if (count($errors)>0)
			<div class="alert alert-danger">
				<ul>
				@foreach ($errors->all() as $error)
					<li>{{$error}}</li>
				@endforeach
				</ul>
			</div>
			@endif

			{!!Form::open(array('url'=>'pacientes/paciente','method'=>'POST','autocomplete'=>'off','files'=>'true'))!!}
            {{Form::token()}}
            <div class="form-group">
            	<label for="nombre">Nombre</label>
            	<input type="text" name="nombre" class="form-control" placeholder="Nombre...">
            </div>
            <div class="form-group">
            	<label for="descripcion">cedula</label>
            	<input type="text" name="cedula" class="form-control" placeholder="cedula...">
            </div>
            <div class="form-group">
            	<label for="descripcion">Telefono</label>
            	<input type="text" name="telefono" class="form-control" placeholder="Telefono...">
            </div>
             <div class="form-group">
             <label for="direccion">direccion</label>
            <input type="text" name="direccion" class="form-control" placeholder="direccion...">
           </div>
           <div class="form-group">
             <label for="tipo_cliente">Tipo cliente</label>
          <select name="tipo_cliente" class="form-control">
                           <option value="1" selected>Contado</option>
                           <option value="0">Credito</option>
                          
                       </select>
           </div>
           <div class="form-group">
             <label for="tipo_precio">Tipo de Precio </label><br>
        <label for="precio1"> Precio 1 </label> <input name="precio" type="radio" value="1" checked="checked">
         <label for="precio2"> Precio 2 </label> <input name="precio" type="radio" value="2">
           </div>
            <div class="form-group">
            	<button class="btn btn-primary" type="submit">Guardar</button>
            	<button class="btn btn-danger" type="reset">Cancelar</button>
            </div>

			{!!Form::close()!!}		
            
		</div>
	</div>

@endsection