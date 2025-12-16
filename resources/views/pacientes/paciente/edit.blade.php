@extends ('layouts.admin')
@section ('contenido')
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<h3>Editar datos de: {{ $paciente->nombre}}</h3>
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
			{!!Form::model($paciente,['method'=>'PATCH','id'=>'formulario','route'=>['pacientes.paciente.update',$paciente->id_cliente],'files'=>'true'])!!}
            {{Form::token()}}
            <div class="form-group">
            	<label for="nombre">Nombre</label>
            	<input type="text" name="nombre" class="form-control" onchange="conMayusculas(this)" value="{{$paciente->nombre}}" placeholder="Nombre...">
            </div>
			</div>
			<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
            	<label for="cedula">Cedula</label>
            	<input type="text" name="ccedula" class="form-control" value="{{$paciente->cedula}}" placeholder="cedula...">
            </div>
			</div>
				<div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
            <div class="form-group">
            	<label for="descripcion">Codigo Pais</label>
            	<input type="text" name="codpais" class="form-control" required value="{{$paciente->codpais}}">
            </div>
			</div>
			<div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
             <div class="form-group">
            	<label for="telefono">Telefono</label>
            	<input type="text" name="telefono" class="form-control" value="{{$paciente->telefono}}" placeholder="telefono...">
            </div>
            </div>

		  <!-- <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
		   		   		               <div class="form-group">
            	<label for="descripcion">Licencia</label>
            	<input type="text" name="licencia" id="licencia" value="{{$paciente->licencia}}" class="form-control" maxlength="20" placeholder="00-000">
            </div>
		   </div> -->
		   			<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
           <div class="form-group">
             <label for="categoria">Categoria Comercial</label>
				<select name="categoria" class="form-control">
            				@foreach ($categoria as $cat)
            				<option value="{{$cat->idcategoria}}" <?php if($cat->idcategoria==$paciente->categoria){ echo "selected";}?>>{{$cat->nombrecategoria}}</option>
            				@endforeach
            			</select>
           </div>
		   </div>
	<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">

              <div class="form-group">
             <label for="tipo_cliente">Tipo cliente: <?php if($paciente->tipo_cliente==1){ echo "Contado";} else{ echo "Credito";}?></label>
          <select name="tipo_cliente" class="form-control">
                            
                           <option value="1"<?php if($paciente->tipo_cliente==1){ echo "selected";}?>> Contado</option>
                           <option value="0" <?php if($paciente->tipo_cliente==0){ echo "selected";}?> >Credito</option>
                          
                       </select>
           </div></div>
		   <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
		   		    <div class="form-group">
             <label for="direccion">Contacto</label>
            <input type="text" name="contacto" class="form-control" value="{{$paciente->contacto}}">
           </div>
		   </div><	<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
           <div class="form-group">
             <label for="tipo_precio">Aplicar Recargo por Mora</label><br>
			<label for="precio1"> Si </label> <input name="recargo" <?php if ($paciente->recargo>0){ echo "checked='checked'"; } ?> type="radio" value="1">
		    <label for="precio1"> No </label> <input name="recargo" <?php if ($paciente->recargo==0){ echo "checked='checked'"; } ?>  type="radio" value="0" >
           </div>
		   </div>
		   <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
		              <div class="form-group">
             <label for="tipo_precio">Dias Credito </label><br>
			<input type="number" class="form-control" name="diascre" value="{{$paciente->diascre}}">
           </div></div>
		   <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
           <div class="form-group">
             <label for="tipo_precio">Tipo de Precio </label><br>
        <label for="precio1"> P 1 </label> <input name="precio" type="radio" value="1" <?php if($paciente->tipo_precio==1){ echo "checked='checked'";} ?> >
        <label for="precio1"> P 2 </label> <input name="precio" type="radio" value="2" <?php if($paciente->tipo_precio==2){ echo "checked='checked'";} ?> >
        <label for="precio1"> Costo </label> <input name="precio" type="radio" value="3" <?php if($paciente->tipo_precio==3){ echo "checked='checked'";} ?> >
           </div>
		   </div>
		   		   <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
           <div class="form-group">
             <label for="tipo_precio">Agente Retencion</label><br>
			<label for="precio1"> Si </label> <input name="agente" <?php if ($paciente->retencion>0){ echo "checked='checked'"; } ?> id="arsi" type="radio" value="1">
		    <label for="precio1"> No </label> <input name="agente" id="arno" <?php if ($paciente->retencion==0){ echo "checked='checked'"; } ?>  type="radio" value="0" >
           </div>
		   </div>
		   		   		   <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
           <div class="form-group">
             <label for="tipo_precio">% Retencion</label><br>
      <input type="number"  step="1" class="form-control"  <?php if ($paciente->retencion>0){ echo  "value='$paciente->retencion'"; }else{ echo "disabled"; } ?> id="retencion" name="retencion" >
           </div>
		   </div>
		   <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
		   <div class="form-group">
            			<label >Vendedor: {{$datos->vendedor}}</label>
            			<select name="idvendedor" class="form-control">
            				@foreach ($vendedores as $cat)
            				<option value="{{$cat->id_vendedor}}" <?php if($paciente->vendedor==$cat->id_vendedor) { echo "selected";} ?>>{{$cat->nombre}}</option>
            				@endforeach
            			</select>
            			
            		</div>
</div>
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
              <div class="form-group">
            <label for="telefono">Direccion</label>
                <input type="text" name="direccion" class="form-control" value="{{$paciente->direccion}}" placeholder="direccion...">
           </div>
		   </div>
		   <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                <div class="form-group">
                     <label for="estado">Municipio: {{$paciente->idmunicipio}}</label>
                             <select name="municipio" id="municipio"  class="form-control" data-live-search="true">  
                                  
                                   <option value="1" selected>Seleccione...</option>
                               @foreach ($municipios as $edo)
							   
                                  <option value="{{$edo->id_municipio}}" <?php if($paciente->id_municipio==$edo->id_municipio){echo "selected"; } ?>>{{$edo->municipio}}</option>  
                              @endforeach                          
                                </select>
                </div>
				</div>
<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
             <div class="form-group">
                  <label for="sector">Parroquia:  {{$paciente->idsector}}</label>
                     <select name="idsector" id="sector" class="form-control">
					 @foreach ($parroquias as $p)
                       <option value="{{$paciente->id_parroquia}}" <?php if($paciente->id_parroquia==$p->id_parroquia){echo "selected"; } ?>>{{$p->parroquia}}</option>
                     
@endforeach					 </select>
					  <input type="hidden" class="form-control" name="idparro" id="idparro" value="{{$paciente->id_parroquia}}">
             </div> </div>
			 		   <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">

					<div class="form-group">
						<label for="tipo_precio">Ruta </label><br>
            			<select name="ruta" class="form-control" data-live-search="true">                                                        
                            @foreach ($rutas as $ru)		
                            <option <?php if($paciente->ruta==$ru->idruta){?>selected<?php } ?> value="{{$ru->idruta}}">{{$ru->nombre}}</option>  
                            @endforeach                          
                        </select>
            			
            		</div>
					</div>
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="form-group">
						<button class="btn btn-primary" type="button" id="btnguardar">Guardar</button>
            	       <button class="btn btn-danger" type="reset" id="btncancelar">Cancelar</button>
					   <div style="display: none" id="loading">  <img src="{{asset('imagenes/sistema/loading30.gif')}}"></div>
            </div>
</div>
			{!!Form::close()!!}		
  		
     
	{!!Form::model($paciente,['method'=>'POST','id'=>'formulariodireccion','route'=>['pacientes.paciente.update',$paciente->id_cliente],'files'=>'true'])!!}		</div>
            {{Form::token()}}
<input type="hidden" name="pidmunicipio" id="pidmunicipio" value="0">
			{!!Form::close()!!}	 
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
	$("#municipio").on("change",function(){
		$("#pidmunicipio").val($("#municipio").val());
		var vmuni=$("#municipio").val();
		$("#sector")
		.empty() 
		.selectpicker('refresh');
         var j=0;
		var form= $('#formulariodireccion');
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
	$("#sector").on("change",function(){
		var variable=$("#sector").val();							
		$("#idparro").val(variable);
	});
	$("#arsi").on("click",function(){	
		$("#retencion").attr("disabled",false); 
	});
		$("#arno").on("click",function(){	
		$("#retencion").val(""); 
		$("#retencion").attr("disabled",true); 
	});
	});
			 function conMayusculas(field) {
            field.value = field.value.toUpperCase()
}
				</script>
			@endpush