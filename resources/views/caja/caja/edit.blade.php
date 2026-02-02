
@extends ('layouts.admin')
@section ('contenido')
	<div class="row">
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
			<h3>Editar Banco: {{ $banco->nombre}}</h3>
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
	</div>

			{!!Form::model($banco,['method'=>'PATCH','route'=>['caja.caja.update',$banco->idmoneda],'files'=>'true'])!!}
            {{Form::token()}}
           
 <div class="row">
             	<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            		 <div class="form-group">
            			<label for="nombre">Codigo</label>
            			<input type="text" name="codigo" required value="{{$banco->codigo}}" class="form-control">
            		</div>
            	</div>
            	<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            		 <div class="form-group">
            			<label for="nombre">Nombre</label>
            			<input type="text" name="nombre" required value="{{$banco->nombre}}" class="form-control">
            		</div>
            	</div>
        
            	<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            		 <div class="form-group">
            			<label for="nombre">Simbolo {{$banco->Simbolo}}</label>
            			<input type="text" name="simbolo" required value="{{$banco->simbolo}}" class="form-control">
            		</div>
            	</div>
               <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
                  <div class="form-group">
						<label for="saco">Tipo</label>
            			<select name="tipo" class="form-control">					
							<option value="0" selected>=</option>
            				<option value="1">Bs</option>
            				<option value="2">Ps</option>

            			</select>
						</div>         </div>

    
     
 			<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            	 <div class="form-group">
            		<button class="btn btn-primary" type="submit">Guardar</button>
            	<button class="btn btn-danger" type="reset">Cancelar</button>	
            		</div>
            </div>
           
            	
         </div>
          
			{!!Form::close()!!}		
@endsection