@extends ('layouts.admin')
@section ('contenido')
	<div class="row">
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
			<h3>Nueva Caja</h3>
			@if (count($errors)>0)
			<div class="alert alert-danger">
				<ul>
				@foreach ($errors->all() as $error)
					<li>{{$error}}</li>
				@endforeach
				</ul>
			</div>
			@endif

			{!!Form::open(array('url'=>'caja/caja','method'=>'POST','autocomplete'=>'off'))!!}
            {{Form::token()}}
			    <div class="form-group">
            	<label for="nombre">Codigo</label>
            	<input type="text" name="codigo" class="form-control" maxlength="4" placeholder="Codigo...">
            </div>
            <div class="form-group">
            	<label for="nombre">Nombre</label>
            	<input type="text" name="nombre" class="form-control" placeholder="Nombre...">
            </div>
             <div class="form-group">
            			<label >Tipo</label>
            			<select name="tipo" class="form-control">            			
            				<option value="1">Bs</option>
            				<option value="2">Peso</option>
            				<option value="0">$</option>           				
            			</select>
            			
            		</div>
			   <div class="form-group">
            	<label for="descripcion">Simbolo</label>
            	<input type="text" name="simbolo" class="form-control" placeholder="$,Bs,Ps,Eu...">
            </div>
            <div class="form-group">
            	<button class="btn btn-primary" type="submit">Guardar</button>
            	<button class="btn btn-danger" type="reset">Cancelar</button>
            </div>

			{!!Form::close()!!}		
            
		</div>
	</div>
@endsection