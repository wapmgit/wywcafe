@extends ('layouts.admin')
@section ('contenido')
	<div class="row">
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
			<h3>Editar datos de: {{ $proveedor->nombre}}</h3>
			@if (count($errors)>0)
			<div class="alert alert-danger">
				<ul>
				@foreach ($errors->all() as $error)
					<li>{{$error}}</li>
				@endforeach
				</ul>
			</div>
			@endif

			{!!Form::model($proveedor,['method'=>'PATCH','id'=>'formulario','route'=>['proveedores.proveedor.update',$proveedor->idproveedor],'files'=>'true'])!!}
            {{Form::token()}}
            <div class="form-group">
            	<label for="nombre">Nombre</label>
            	<input type="text" name="nombre" class="form-control" onchange="conMayusculas(this)" value="{{$proveedor->nombre}}" placeholder="Nombre...">
            </div>
            <div class="form-group">
            	<label for="rif">Rif</label>
            	<input type="text" name="rif" class="form-control" value="{{$proveedor->rif}}" placeholder="rif...">
            </div>
             <div class="form-group">
            	<label for="telefono">Telefono</label>
            	<input type="text" name="telefono" class="form-control" value="{{$proveedor->telefono}}" placeholder="telefono...">
            </div>
              <div class="form-group">
            <label for="direccion">Direccion</label>
                <input type="text" name="direccion" class="form-control" value="{{$proveedor->direccion}}" placeholder="direccion...">
           </div>
		         <div class="form-group">
            <label for="direccion">Contacto</label>
                <input type="text" name="contacto" class="form-control" value="{{$proveedor->contacto}}" placeholder="Contacto...">
           </div>
		   		   		   		    <div class="form-group">
             <label for="imagen">Persona</label>
		<select name="tpersona" class="form-control">
            				<option value="1" <?php if($proveedor->tpersona==1){ echo "selected";}?>>Juridica Domiciliada</option>
            				<option value="2" <?php if($proveedor->tpersona==2){ echo "selected";}?>>Juridica No Domiciliada</option>
            				<option value="3" <?php if($proveedor->tpersona==3){ echo "selected";}?>>Natural Residenciada</option>
            				<option value="4" <?php if($proveedor->tpersona==4){ echo "selected";}?>>Natural No Residenciada</option>
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