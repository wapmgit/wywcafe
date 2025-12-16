@extends ('layouts.admin')
@section ('contenido')
		<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<h3>Nuevo Cliente</h3>
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
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
			{!!Form::open(array('url'=>'pacientes/paciente','method'=>'POST','autocomplete'=>'off','files'=>'true','id'=>'formulario'))!!}
            {{Form::token()}}
            <div class="form-group">
            	<label for="nombre">Nombre</label>
            	<input type="text" name="nombre" class="form-control" onchange="conMayusculas(this)" placeholder="Nombre...">
            </div>
			</div>
			<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
            	<label for="descripcion">Cedula</label>
            	<input type="text" name="ccedula" id="vidcedula" class="form-control" maxlength="10" placeholder="V000000">
            </div>
			</div>
			<div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
            <div class="form-group">
            	<label for="descripcion">Codigo Pais</label>
            	<input type="text" name="codpais" class="form-control" required value="+58">
            </div>
			</div>
			<div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
            <div class="form-group">
            	<label for="descripcion">Telefono</label>
            	<input type="tel" name="telefono" id="telefono" class="form-control" maxlength="10" placeholder="9999999999">
            </div>
			</div>

		   	<!--	<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
		               <div class="form-group">
            	<label for="descripcion">Licencia</label>
            	<input type="text" name="licencia" id="licencia" class="form-control" maxlength="20" placeholder="00-000">
            </div></div> -->
		<div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
           <div class="form-group">
             <label for="categoria">Categoria Comercial</label>
				<select name="categoria" class="form-control">
            				@foreach ($categoria as $cat)
            				<option value="{{$cat->idcategoria}}">{{$cat->nombrecategoria}}</option>
            				@endforeach
            			</select>
           </div>
		   </div>
					<div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
           <div class="form-group">
             <label for="tipo_cliente">Tipo cliente</label>
          <select name="tipo_cliente" id="tipo_cliente" class="form-control">
                           <option value="1" selected>Contado</option>
                           <option value="0">Credito</option>
                          
                       </select>
           </div>
		   </div>
		   		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
		    <div class="form-group">
             <label for="direccion">Contacto</label>
            <input type="text" name="contacto" class="form-control" placeholder="Contacto...">
           </div></div>
		   	<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
           <div class="form-group">
             <label for="tipo_precio">Aplicar Recargo por Mora</label><br>
			<label for="precio1"> Si </label> <input name="recargo"  checked="checked" type="radio" value="1">
		    <label for="precio1"> No </label> <input name="recargo"  type="radio" value="0" >
           </div>
		   </div>
		   		   	<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
		              <div class="form-group">
					  <label>Dias Credito</label>
<input type="number" name="diascre" id="diascre" readonly class="form-control"value="1" >
           </div></div>
		   	  <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
           <div class="form-group">
             <label for="tipo_precio">Tipo de Precio </label><br>
        <label for="precio1"> P 1 </label> <input name="precio" type="radio" value="1" checked="checked">
         <label for="precio2"> P 2 </label> <input name="precio" type="radio" value="2">
		 <label for="precio3"> Costo </label> <input name="precio" type="radio" value="3">
           </div>
		   </div>
		   		   		   <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
           <div class="form-group">
             <label for="tipo_precio">Agente Retencion</label><br>
			<label for="precio1"> Si </label> <input name="agente" id="arsi" type="radio" value="1">
		    <label for="precio1"> No </label> <input name="agente" checked="checked" id="arno"  type="radio" value="0" >
           </div>
		   </div>
		   		   		   <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
           <div class="form-group">
             <label for="tipo_precio">% Retencion</label><br>
      <input type="number"  step="1" class="form-control" disabled id="retencion" name="retencion" >
           </div>
		   </div>
		   		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
		   	   <div class="form-group">
            			             <label for="tipo_precio">Vendedor </label><br>
            			<select name="idvendedor" class="form-control">
            				@foreach ($vendedores as $cat)
            				<option value="{{$cat->id_vendedor}}">{{$cat->nombre}}</option>
            				@endforeach
            			</select>
            			
            		</div>
					</div>
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
             <div class="form-group">
             <label for="direccion">Direccion</label>
            <input type="text" name="direccion" class="form-control" placeholder="Direccion...">
           </div></div>
				<div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
                <div class="form-group">
                     <label for="estado">Municipio</label>
                             <select name="municipio" id="municipio"  class="form-control" data-live-search="true">  
                                  
                                   <option value="1" selected>Seleccione...</option>
                               @foreach ($municipios as $edo)
                                  <option value="{{$edo->id_municipio}}">{{$edo->municipio}}</option>  
                              @endforeach                          
                                </select>
                </div>
					</div>
									<div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
             <div class="form-group">
                  <label for="sector">Parroquia</label>
                     <select name="idsector" id="sector" class="form-control">
                       <option value="0">esperando seleccion</option>
                      </select>
					  <input type="hidden" class="form-control" name="idparro" id="idparro" value="">
             </div> 
					</div>
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
	<div class="form-group">
            			             <label for="tipo_precio">Ruta </label><br>
            			<select name="ruta" class="form-control" data-live-search="true">                                    
                            <option value="1" selected>Seleccione...</option>
                            @foreach ($rutas as $ru)
                            <option value="{{$ru->idruta}}">{{$ru->nombre}}</option>  
                            @endforeach                          
                        </select>
            			
            		</div>
					</div>
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
            	<button class="btn btn-primary" type="button" id="btnguardar">Guardar</button>
            	<button class="btn btn-danger" type="reset" id="btncancelar">Cancelar</button>
			    <div style="display: none" id="loading">  <img src="{{asset('imagenes/sistema/loading30.gif')}}"></div>
            </div>
</div>
			{!!Form::close()!!}		
            
		</div>
	</div>

@endsection

 @push('scripts')
			<script>
			 $(document).ready(function(){
    $("#vidcedula").on("change",function(){
         var form2= $('#formulario');
        var url2 = '/clientes/cliente/validar';
        var data2 = form2.serialize();
    $.post(url2,data2,function(result2){  
      var resultado2=result2;
         console.log(resultado2); 
         rows=resultado2.length; 
      if (rows > 0){
            var nombre=resultado2[0].nombre;
          var cedula=resultado2[0].cedula; 
          var rif=resultado2[0].telefono;  
          alert ('Numero de identificacion ya existe, Nombre: '+nombre+' Cedula: '+cedula+' telefono: '+rif);   
           $("#vidcedula").val("");
}    
          });
     });
	    $("#tipo_cliente").on("change",function(){			
			  var valor= $("#tipo_cliente").val();
			  if(valor==0){$("#diascre").attr("readonly",false); 
			  $("#diascre").val(5);}
			  else { $("#diascre").attr("readonly",true);
				$("#diascre").val(0);
			  }
				 });
				 	    $("#sector").on("change",function(){
							var variable=$("#sector").val();							
						$("#idparro").val(variable);
				 });
		
	  $('#btnguardar').click(function(){   
		document.getElementById('loading').style.display=""; 
		document.getElementById('btnguardar').style.display="none"; 
		document.getElementById('btncancelar').style.display="none"; 
		document.getElementById('formulario').submit(); 
    })
	$("#arsi").on("click",function(){	
		$("#retencion").attr("disabled",false); 
	});
	$("#arno").on("click",function(){	
		$("#retencion").val(""); 
		$("#retencion").attr("disabled",true); 
	});
	  $("#municipio").on("change",function(){
    var vmuni=$("#municipio").val();
     $("#sector")
  .empty() 
  .selectpicker('refresh');
          var j=0;
         var form= $('#formulario');
        var url = '/clientes/cliente/municipio';
        var data = form.serialize();
    $.post(url,data,function(result1){  
      var resultado1=result1;
          console.log(resultado1); 
          parada1=10;                 
  for(j=0;j<=parada1;j++){
if(j==0){ $("#idparro").val(resultado1[0].idsector);}	  
  $("#sector")
  .append( 
    '<option value="'+resultado1[j].idsector+'">'+resultado1[j].nombre+'</option>' )
  .selectpicker('refresh');
        }
          });
     });
			 });
			 function conMayusculas(field) {
            field.value = field.value.toUpperCase()
}
				</script>
			@endpush