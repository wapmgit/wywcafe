@extends ('layouts.admin')
@section ('contenido')
	<div class="row">
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
			<h3>Editar Tratamiento: {{ $tratamiento->nombre}}</h3>
			@if (count($errors)>0)
			<div class="alert alert-danger">
				<ul>
				@foreach ($errors->all() as $error)
					<li>{{$error}}</li>
				@endforeach
				</ul>
			</div>
			@endif

			{!!Form::model($tratamiento,['method'=>'PATCH','route'=>['tratamiento.precio.update',$tratamiento->id_tratamiento]])!!}
            {{Form::token()}}
            <div class="form-group">
            	<label for="nombre">Nombre</label>
            	<input type="text" name="tratamiento" class="form-control" value="{{$tratamiento->tratamiento}}" placeholder="Nombre...">
            </div>
            <div class="form-group">
            	<label for="descripcion">Clase</label>
            	<input type="text" name="clase" class="form-control" value="{{$tratamiento->clase}}" placeholder="clase...">
            </div>
            <div class="form-group">
            	<label for="descripcion">Precio</label>
            	<input type="text" name="precio" class="form-control" value="{{$tratamiento->precio_base}}" placeholder="precio...">
            </div>
            <div class="form-group">
            	<button class="btn btn-primary" type="submit">Guardar</button>
            	<button class="btn btn-danger" type="reset">Cancelar</button>
            </div>

			{!!Form::close()!!}		
            
		</div>
	</div>
@endsection