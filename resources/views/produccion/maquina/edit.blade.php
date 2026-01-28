@extends ('layouts.admin')
@section ('contenido')
	<div class="row">
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
			<h3>Editar Tostador: {{ $categoria->nombre}}</h3>
			@if (count($errors)>0)
			<div class="alert alert-danger">
				<ul>
				@foreach ($errors->all() as $error)
					<li>{{$error}}</li>
				@endforeach
				</ul>
			</div>
			@endif

			{!!Form::model($categoria,['method'=>'PATCH','route'=>['produccion.maquina.update',$categoria->iddep]])!!}
            {{Form::token()}}
            <div class="form-group">
            	<label for="nombre">Nombre</label>
            	<input type="text" name="nombre" class="form-control" value="{{$categoria->nombre}}" placeholder="Nombre...">
            </div>
            <div class="form-group">
            	<label for="descripcion">Marca</label>
            	<input type="text" name="marca" class="form-control" value="{{$categoria->marca}}" placeholder="Marca...">
            </div>
			 <div class="form-group">
            	<label for="descripcion">Serie/Modelo</label>
            	<input type="text" name="serie" class="form-control" value="{{$categoria->serie}}" placeholder="Serie/Modelo...">
            </div>
			<div class="form-group">
            	<label for="nombre">Capacidad</label>
            	<input type="number" name="capacidad" value="{{$categoria->serie}}" class="form-control" placeholder="Kgs...">
            </div>
					<div class="form-group">
            	<label for="nombre">Tipo</label>
            	<select name="tipo" class="form-control">
            				<option value="1" <?php if($categoria->tipo==1){ echo "selected"; }?>>Trilladora</option>
            				<option value="2" <?php if($categoria->tipo==2){ echo "selected"; }?>>Tostadora</option>
            				<option value="3" <?php if($categoria->tipo==3){ echo "selected"; }?>>Molino</option>
            				<option value="4" <?php if($categoria->tipo==4){ echo "selected"; }?>>Empaquetadora</option>
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