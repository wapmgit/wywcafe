@extends ('layouts.admin')
@section ('contenido')
		<div class="row">
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
			<h3>Nuevo Proveedor</h3>
			@if (count($errors)>0)
			<div class="alert alert-danger">
				<ul>
				@foreach ($errors->all() as $error)
					<li>{{$error}}</li>
				@endforeach
				</ul>
			</div>
			@endif

			{!!Form::open(array('url'=>'proveedores/proveedor','method'=>'POST','autocomplete'=>'off','id'=>'formulario'))!!}
            {{Form::token()}}
            <div class="form-group">
            	<label for="nombre">Nombre o Razon Social</label>
            	<input type="text" name="nombre" onchange="conMayusculas(this)" class="form-control" placeholder="Nombre...">
            </div>
            <div class="form-group">
            	<label for="descripcion">Rif</label>
            	<input type="text" name="rif" class="form-control" id="rif" placeholder="V00000000-0">
            </div>
            <div class="form-group">
            	<label for="descripcion">Telefono</label>
            	<input type="text" name="telefono" class="form-control" placeholder="0000-0000000">
            </div>
             <div class="form-group">
             <label for="imagen">Direccion</label>
            <input type="text" name="direccion" class="form-control" placeholder="Direccion...">
           </div>
		    <div class="form-group">
             <label for="imagen">Contacto</label>
            <input type="text" name="contacto" class="form-control" placeholder="Contacto...">
           </div>
		   		   		    <div class="form-group">
             <label for="imagen">Persona</label>
		<select name="tpersona" class="form-control">
            				<option value="1">Juridica Domiciliada</option>
            				<option value="2">Juridica No Domiciliada</option>
            				<option value="3">Natural Residenciada</option>
            				<option value="4">Natural No Residenciada</option>
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
		      $("#rif").on("change",function(){
         var form2= $('#formulario');
        var url2 = '/proveedores/proveedor/validar';
        var data2 = form2.serialize();
    $.post(url2,data2,function(result2){  
      var resultado2=result2;
         console.log(resultado2); 
         rows=resultado2.length; 
      if (rows > 0){
            var nombre=resultado2[0].nombre;
          var rif=resultado2[0].rif; 
          var telefono=resultado2[0].telefono;   
          alert ('Rif ya existe!!, Nombre: '+nombre+' Rif: '+rif+' Telefono: '+telefono);   
           $("#rif").val("");
}    
          });
     });
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
    