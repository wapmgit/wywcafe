@extends ('layouts.admin')
@section ('contenido')
	<div class="row">
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
			<h3>Nueva Moneda</h3>
			@if (count($errors)>0)
			<div class="alert alert-danger">
				<ul>
				@foreach ($errors->all() as $error)
					<li>{{$error}}</li>
				@endforeach
				</ul>
			</div>
			@endif

			{!!Form::open(array('url'=>'caja/monedas','method'=>'POST','autocomplete'=>'off'))!!}
            {{Form::token()}}
	
            <div class="form-group">
            	<label for="nombre">Nombre</label>
            	<input type="text" name="nombre" class="form-control"  onchange="conMayusculas(this)"  value="" placeholder="Nombre...">
            </div>
            <div class="form-group">
            	<label for="descripcion">Modo Valor</label>
            	<select name="tipo" class="form-control">					
							<option value="0">Igual</option>
            				<option value="1">Multiplica</option>
            				<option value="2">Divide</option>
            			
            			</select>
            </div>
			<div class="form-group">
            	<label for="descripcion">Simbolo</label>
            	<input type="text" name="simbolo"  class="form-control" value="" placeholder="Simbolo...">
            </div>
			<div class="form-group">
            	<label for="descripcion">Valor</label>
            	<input type="number" name="valor" class="form-control" step="0.01" value="" placeholder="Valor...">
            </div>
						<div class="form-group">
<p>Nota: El registro de una nueva Moneda Generara de forma automatica una caja para relacion de la moneda registrada </p>
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
</script>
@endpush