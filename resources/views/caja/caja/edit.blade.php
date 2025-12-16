
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

			{!!Form::model($banco,['method'=>'PATCH','route'=>['caja.caja.update',$banco->idcaja],'files'=>'true'])!!}
            {{Form::token()}}
           
 <div class="row">
            	<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            		 <div class="form-group">
            			<label for="nombre">Nombre</label>
            			<input type="text" name="nombre" required value="{{$banco->nombre}}" class="form-control">
            		</div>
            	</div>
        
            	<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            		 <div class="form-group">
            			<label for="nombre">Responsable</label>
            			<input type="text" name="responsable" required value="{{$banco->responsable}}" class="form-control">
            		</div>
            	</div>

            <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            	 <div class="form-group">
            			<label for="codigo">Numero de Cuenta</label>
            			<input type="text" name="cuenta" required value="{{$banco->cuentaban}}" class="form-control">
            		</div>
            </div>

               <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
                  <div class="form-group">
						<label for="saco">Moneda</label>
            			<select name="idmoneda" class="form-control">					
            				@foreach ($monedas as $cat)	
							@if($cat->idmoneda==$banco->idmoneda)
								<option value="{{$cat->idmoneda}}" selected>{{$cat->nombre}}</option>@endif
            				<option value="{{$cat->idmoneda}}">{{$cat->nombre}}</option>
            				@endforeach
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