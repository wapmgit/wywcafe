@extends ('layouts.admin')
@section ('contenido')
	<div class="row">
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
			<h3>Nueva Categoría</h3>
			@if (count($errors)>0)
			<div class="alert alert-danger">
				<ul>
				@foreach ($errors->all() as $error)
					<li>{{$error}}</li>
				@endforeach
				</ul>
			</div>
			@endif

			{!!Form::open(array('url'=>'almacen/categoria','method'=>'POST','autocomplete'=>'off'))!!}
            {{Form::token()}}
            <div class="form-group">
            	<label for="nombre">Nombre</label>
            	<input type="text" name="nombre"  onchange="conMayusculas(this)"  class="form-control" placeholder="Nombre...">
            </div>
            <div class="form-group">
            	<label for="descripcion">Descripción</label>
            	<input type="text" name="descripcion" class="form-control" placeholder="Descripción...">
            </div>
				 <div class="form-group">
            	<label for="descripcion">¿Es Licores?</label>
            <input type="checkbox" name="licores" id="cbox1" onclick="javascript:asignar();" value="0" />
            </div>
            <div class="form-group">
            	<button class="btn btn-primary" type="submit">Guardar</button>
            	<button class="btn btn-danger" type="reset">Cancelar</button>
            </div>

			{!!Form::close()!!}		
            
		</div>
	</div>
@endsection
  @push('scripts')
<script>
	    function conMayusculas(field) {
            field.value = field.value.toUpperCase()
}
function asignar(){	
	var valor=document.getElementById('cbox1').checked; 
	if(valor==true){
		$('#cbox1').val(1);
	}else{
		$('#cbox1').val(0);
	};
}
</script>
@endpush