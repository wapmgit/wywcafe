@extends ('layouts.admin')
@section ('contenido')
	<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<h3>Nuevo Registro</h3>
			@if (count($errors)>0)
			<div class="alert alert-danger">
				<ul>
				@foreach ($errors->all() as $error)
					<li>{{$error}}</li>
				@endforeach
				</ul>
			</div>
			@endif
		</div>
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		
			{!!Form::open(array('url'=>'almacen/deposito','method'=>'POST','autocomplete'=>'off'))!!}
            {{Form::token()}}
		
				 <div class="form-group">
							   <label for="nombre">Persona</label>
							   <select name="nombre"  class="form-control selectpicker" data-live-search="true">
				                      @foreach ($clientes as $cli)
				                              <option value="{{$cli->cedula}}_{{$cli->nombre}}_{{$cli->tipoc}}_{{$cli->id}}">{{$cli->tipoc}} -> {{$cli->cedula}} - {{$cli->nombre}}</option> 
				                              @endforeach
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