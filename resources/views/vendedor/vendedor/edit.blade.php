@extends ('layouts.admin')
@section ('contenido')
	<div class="row">
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
			<h3>Editar Vendedor: {{ $vendedores->nombre}}</h3>
			@if (count($errors)>0)
			<div class="alert alert-danger">
				<ul>
				@foreach ($errors->all() as $error)
					<li>{{$error}}</li>
				@endforeach
				</ul>
			</div>
			@endif

			{!!Form::model($vendedores,['method'=>'PATCH','id'=>'formulario','route'=>['vendedor.vendedor.update',$vendedores->id_vendedor]])!!}
            {{Form::token()}}
            <div class="form-group">
            	<label for="nombre">Nombre</label>
            	<input type="text" name="nombre" class="form-control" onchange="conMayusculas(this)"  value="{{$vendedores->nombre}}" placeholder="Nombre...">
            </div>
            <div class="form-group">
            	<label for="descripcion">Cedula</label>
            	<input type="text" name="cedula" class="form-control" value="{{$vendedores->cedula}}" placeholder="Descripción...">
            </div>
			
            <div class="form-group">
            	<label for="descripcion">Telefono</label>
            	<input type="text" name="telefono" class="form-control" value="{{$vendedores->telefono}}" placeholder="Descripción...">
            </div>
			
            <div class="form-group">
            	<label for="descripcion">Direccion</label>
            	<input type="text" name="direccion" class="form-control" value="{{$vendedores->direccion}}" placeholder="Descripción...">
            </div>
			<div class="form-group">
            	<label for="nombre">Comision</label>
            	<input type="number" min="0" name="comision" value="{{$vendedores->comision}}" class="form-control" placeholder="%">
            </div>
			 <div class="form-group">
				<label for="tipo_precio">Deposito </label><br>
            			<select name="deposito" class="form-control" >						
            				@foreach ($deposito as $cat)
            				<option value="{{$cat->id_deposito}}" <?php if($vendedores->id_vendedor==$cat->idvendedor){ echo "selected";}?>>{{$cat->nombre}}</option>
            				@endforeach
            			</select>
            			
            </div>
            <div class="form-group">
					<button class="btn btn-primary" type="button" id="btnguardar">Guardar</button>
            	       <button class="btn btn-danger" type="reset" id="btncancelar">Cancelar</button>
					   <div style="display: none" id="loading">  <img src="{{asset('imagenes/sistema/loading30.gif')}}"></div>
            </div>

			{!!Form::close()!!}		
            
		</div>
	</div>
@endsection
 @push('scripts')
 <script>
	$(document).ready(function(){
		 $('#btnguardar').click(function(){   
		document.getElementById('loading').style.display=""; 
		document.getElementById('btnguardar').style.display="none"; 
		document.getElementById('btncancelar').style.display="none"; 
		document.getElementById('formulario').submit(); 
		})
	});
	function conMayusculas(field) {
            field.value = field.value.toUpperCase()
	}
				</script>
			@endpush