@extends ('layouts.admin')
@section ('contenido')
	<div class="row">
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
			<h3>Editar Moneda: {{ $moneda->nombre}}</h3>
			@if (count($errors)>0)
			<div class="alert alert-danger">
				<ul>
				@foreach ($errors->all() as $error)
					<li>{{$error}}</li>
				@endforeach
				</ul>
			</div>
			@endif

			{!!Form::model($moneda,['method'=>'PATCH','route'=>['caja.monedas.update',$moneda->idmoneda]])!!}
            {{Form::token()}}
            <div class="form-group">
            	<label for="nombre">Nombre</label>
            	<input type="text" name="nombre" class="form-control"  onchange="conMayusculas(this)"  value="{{$moneda->nombre}}" placeholder="Nombre...">
            </div>
            <div class="form-group">
            	<label for="descripcion">Modo Valor</label>
            	<select name="tipo" class="form-control">
				
							<option <?php if($moneda->tipo==0){?> selected <?php } ?> value="0">Igual</option>
            				<option <?php if($moneda->tipo==1){?> selected <?php } ?> value="1">Multiplica</option>
            				<option <?php if($moneda->tipo==2){?> selected <?php } ?> value="2">Divide</option>
            			
            			</select>
            </div>
			<div class="form-group">
            	<label for="descripcion">Simbolo</label>
            	<input type="text" name="simbolo"  class="form-control" value="{{$moneda->simbolo}}" placeholder="Descripción...">
            </div>
			<div class="form-group">
            	<label for="descripcion">Valor</label>
            	<input type="number" name="valor" class="form-control" value="{{$moneda->valor}}" placeholder="Descripción...">
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