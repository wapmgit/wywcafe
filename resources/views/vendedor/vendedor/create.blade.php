@extends ('layouts.admin')
@section ('contenido')
	<div class="row">
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
			<h3>Nuevo Vendedor</h3>
			@if (count($errors)>0)
			<div class="alert alert-danger">
				<ul>
				@foreach ($errors->all() as $error)
					<li>{{$error}}</li>
				@endforeach
				</ul>
			</div>
			@endif

			{!!Form::open(array('url'=>'vendedor/vendedor','method'=>'POST','autocomplete'=>'off','id'=>'formulario'))!!}
            {{Form::token()}}
            <div class="form-group">
            	<label for="nombre">Nombre</label>
            	<input type="text" name="nombre" onchange="conMayusculas(this)" class="form-control" placeholder="Nombre...">
            </div>
			<div class="form-group">
            	<label for="nombre">Cedula</label>
            	<input type="text" name="cedula" class="form-control" placeholder="V00000000">
            </div>
			<div class="form-group">
            	<label for="nombre">Telefono</label>
            	<input type="text" name="telefono" class="form-control" placeholder="0000-0000000">
            </div>
			
            <div class="form-group">
            	<label for="descripcion">Direccion</label>
            	<input type="text" name="direccion" class="form-control" placeholder="Direccion...">
            </div>
			<div class="form-group">
            	<label for="nombre">Comision</label>
            	<input type="number" min="0" name="comision" class="form-control" placeholder="%">
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