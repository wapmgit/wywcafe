@extends ('layouts.admin')
@section ('contenido')
	<div class="row">
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
			<h3>Editar articulo: {{ $articulo->nombre}}</h3>
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
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12"> @if (($articulo->imagen)!="")
                      <img src="{{asset('imagenes/articulos/'.$articulo->imagen)}}" width="100" height="80">
                  @endif </div>
	</div>

			{!!Form::model($articulo,['method'=>'PATCH','id'=>'formulario','route'=>['almacen.articulo.update',$articulo->idarticulo],'files'=>'true'])!!}
            {{Form::token()}}
           
 <div class="row">
            <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            		 <div class="form-group">
            			<label for="nombre">Nombre</label>
            			<input type="text" name="nombre" onchange="conMayusculas(this)"  required value="{{$articulo->nombre}}" class="form-control" placeholder="Nombre...">
						<input type="hidden" name="mutil" id="mutil" required value="{{$empresa->calc_util}}" class="form-control">
            		</div>
            	</div>
   <div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
            	 <div class="form-group">
            			<label >Categoria</label>
            			<select name="idcategoria" class="form-control">
            				@foreach ($categorias as $cat)
            				@if ($cat->idcategoria == $articulo->idcategoria)
            				<option value="{{$cat->idcategoria}}"selected >{{$cat->nombre}}</option>
            				@else
            				<option value="{{$cat->idcategoria}}">{{$cat->nombre}}</option>
            				@endif
            				@endforeach
            			</select>
            			
            		</div>
            </div> <!--
						   <div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
            	 <div class="form-group">
            			<label >Clase</label>
            			<select name="clase" class="form-control">           				
            				<option value="N/D" <?php if ($articulo->clase=="N/A"){ echo "selected"; }?>>No Aplica</option>
            				<option value="Cerveza" <?php if ($articulo->clase=="Cerveza"){ echo "selected"; }?>>Cerveza</option>
            				<option value="Licor" <?php if ($articulo->clase=="Licor"){ echo "selected"; }?>>Licor</option>
            				
            			</select>
            			
            		</div>
            </div>
<div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
            	 <div class="form-group">
            			<label >Procedencia</label>
            			<select name="origen" class="form-control">           				
            				<option value="N" <?php if ($articulo->origen=="N"){ echo "selected"; }?>>Nacional</option>
            				<option value="I" <?php if ($articulo->origen=="I"){ echo "selected"; }?>>importado</option>
            				
            			</select>
            			
            		</div>
            </div> -->
          <div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
            	 <div class="form-group">
            			<label for="codigo">Codigo</label>
            			<input type="text" name="codigo" required value="{{$articulo->codigo}}" class="form-control" placeholder="Codigo...">
            		</div>
            </div>
						 <div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
                 <div class="form-group">
               	<label for="productor">¿M. Prima?</label></br>
	<input type="checkbox" name="mprima" id="cbx2" <?php if ($articulo->mprima ==1){?> checked value="1" <?php } ?>>
		   </div>
            </div>
						<div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
                 <div class="form-group">
               	<label for="productor">¿Produccion?</label>
				<input type="checkbox" name="produ" id="cbx3" <?php if ($articulo->nivelp >0 ){?> checked value="1" <?php } ?>>
			</div>
            </div>
		<div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
            	 <div class="form-group">
            			<label for="nivelp">Nivel Produccion </label>          
                 <select name="nivelp" id="nivelp" class="form-control" <?php if($articulo->nivelp == 0){ echo "disabled"; } ?>>          			            			
            				<option <?php if($articulo->nivelp==1){ echo "selected"; } ?> value="1">Tostado</option>
            				<option <?php if($articulo->nivelp==2){ echo "selected"; } ?>value="2">Molido</option>
            				<option <?php if($articulo->nivelp==3){ echo "selected"; } ?>value="3">Empaquetado</option>  							
            			</select>        			
            		</div>
            </div>
 				<div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
            	 <div class="form-group">
            			<label for="stock">Stock </label>
           
                  <input type="text" name="stock1" disabled value="{{$articulo->stock}}" class="form-control" placeholder="stock...">
            			<input type="hidden" name="stock" required value="{{$articulo->stock}}" class="form-control" placeholder="stock...">
            		</div>
            </div>
 				<div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
            	 <div class="form-group">
            			<label for="stock">Unidad </label>          
                 	<select name="unidad" class="form-control">          			            			
            				<option <?php if($articulo->unid=="UND"){ echo "selected"; } ?> value="UND">Unidad</option>
            				<option <?php if($articulo->unid=="BTO"){ echo "selected"; } ?> value="BTO">Bulto</option>
            				<option <?php if($articulo->unid=="SCO"){ echo "Selected"; } ?> value="SCO">Saco</option>
            				<option <?php if($articulo->unid=="CJA"){ echo "Selected"; } ?> value="CJA">Caja</option>
            				<option <?php if($articulo->unid=="KG"){ echo "selected"; } ?>  value="kG">Kg</option>
            				<option <?php if($articulo->unid=="DISP"){ echo "selected"; } ?> value="DISP">Display</option>
            				<option <?php if($articulo->unid=="PR"){ echo "selected"; } ?> value="PR">Par</option>
            				<option <?php if($articulo->unid=="LTR"){ echo "selected"; } ?>  value="LTR">Litros</option>
							<option <?php if($articulo->unid=="MNGA"){ echo "selected"; } ?> value="MNGA">Manga</option>          <option <?php if($articulo->unid=="PAQ"){ echo "selected"; } ?> value="PAQ">Paquete</option>   							
            			</select>      			
            		</div>
            </div>
									<div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
            	 <div class="form-group">
            			<label for="codigo">Peso (Gms)</label>
            			<input type="number" name="peso"  min="0.1" required value="{{$articulo->peso}}" class="form-control">
            		</div>
            </div>
						  <!--			<div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
            	 <div class="form-group">
            			<label for="stock">Volumen</label>
            			<input type="text" name="volumen"    value="{{$articulo->volumen}}" class="form-control" placeholder="volumen...">
            		</div>
            </div>
 				<div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
            	 <div class="form-group">
            			<label for="stock">Grados </label>          
                  <input type="text" name="grados"  value="{{$articulo->grados}}" class="form-control" placeholder="grados...">         			
            		</div>
            </div> -->
			<div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
            	 <div class="form-group">
            			<label for="codigo">Fraccion</label>
            			<input type="number" name="fraccion"  min="0.1" required value="{{$articulo->fraccion}}" class="form-control" placeholder="1,0.25,0.5">
            		</div>
            </div>
             <div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
            	 <div class="form-group">
            			<label for="descripcion">Descripcion</label>
            			<input type="text" name="descripcion" required value="{{$articulo->descripcion}}" class="form-control" placeholder="descripcion..">
            		</div>
            </div>
         <div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
            	 <div class="form-group">
            			<label for="imagen">Imagen</label>
            			<input type="file" name="imagen"  class="form-control">
            		</div>
            </div> <!--
<div class="col-lg-2 col-sm-2 col-md-2 col-xs-12" align="center">
			           <div class="form-group">
             <label for="tipo_precio">Usa Vacio: </label></br>
        <label for="precio1"> Si </label> <input name="vacio" type="radio" value="1" <?php if($articulo->vacio==1){echo "checked='checked'"; }?> >
         <label for="precio2"> No </label> <input name="vacio" type="radio" value="0" <?php if($articulo->vacio==0){echo "checked='checked'"; }?>>

		   </div>
		   </div> -->
		<div class="col-lg-2 col-sm-2 col-md-2 col-xs-12" align="center">
			<div class="form-group">
               	<label for="productor">¿ Comision ?</label></br>
			<input type="checkbox" name="comi" id="cbx1" <?php if ($articulo->comi ==1){?> checked value="1" <?php }else{ ?>value="0"<?php } ?> >
		   </div>
		   </div>
		   <div class="col-lg-2 col-sm-2 col-md-2 col-xs-4">
                 <div class="form-group">
                              <label for="costo">%</label>
                              <input type="number" min="0.01" step="0.01"<?php if ($articulo->comi ==1){?> value="{{$articulo->pcomision}}" <?php }else{ ?>value="0" disabled <?php } ?>  id="porcentaje"  name="porcentaje"  class="form-control" placeholder="%">
                 </div>      
		 </div>
		 	<div class="col-lg-2 col-sm-2 col-md-2 col-xs-12" align="center">
			           <div class="form-group">
               	<label for="productor">¿Disponible Venta?</label></br>
	<input type="checkbox" name="sevende" id="cbxv" <?php if ($articulo->sevende ==1){?> checked value="1" <?php } ?>>
		   </div>
		   </div>
               <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                <div class="col-lg-2 col-sm-2 col-md-2 col-xs-6">
                 <div class="form-group">
                              <label for="costo">Costo</label>
                              <input type="number"  name="costo"  class="form-control" id="costo" value="{{$articulo->costo}}" placeholder="costo">
                 </div>         </div>
                 <div class="col-lg-2 col-sm-2 col-md-2 col-xs-6">
                 <div class="form-group">
                              <label for="impuesto">Impuesto</label>
                              <input type="text" value="{{$articulo->iva}}" placeholder="impuesto" name="impuesto" id="impuesto"  class="form-control">
                 </div>         </div>
                 
                     <div class="col-lg-2 col-sm-2 col-md-2 col-xs-6">
                   <div class="form-group">
                              <label for="utilidad">Utilidad 1</label>
                              <input type="number" name="utilidad" id="utilidad" class="form-control" step="0.01" value="{{$articulo->utilidad}}" placeholder="% utilidad">
                        </div>
                        </div>
            <div class="col-lg-2 col-sm-2 col-md-2 col-xs-6">
                        <div class="form-group">
                              <label for="precio1">Precio 1</label>
                              <input type="text" name="precio1" id="precio1"   class="form-control" value="{{$articulo->precio1}}" placeholder=" precio BSF">
                 </div> 
                 </div><div class="col-lg-2 col-sm-2 col-md-2 col-xs-6">
                 <div class="form-group">
                              <label for="util2">utilidad 2</label>
                              <input type="number" value="{{$articulo->util2}}"  name="util2" id="util2" step="0.01" class="form-control">
                 </div>         </div>
                 <div class="col-lg-2 col-sm-2 col-md-2 col-xs-6">
                 <div class="form-group">
                              <label for="precio2">Precio 2</label>
                              <input type="text" value="{{$articulo->precio2}}" name="precio2"  id="precio2" class="form-control">
                 </div>         </div>
 			<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            	 <div class="form-group">
            		<button class="btn btn-primary" type="button" id="btnguardar">Guardar</button>
            	       <button class="btn btn-danger" type="reset" id="btncancelar">Cancelar</button>
					   <div style="display: none" id="loading">  <img src="{{asset('imagenes/sistema/loading30.gif')}}"></div>
            		</div>
            </div>
           
            </div>	
            </div>
          
			{!!Form::close()!!}		
            
        @push('scripts')
      <script>
$(document).ready(function(){

$("#costo").change(calculo); 
$("#costo").change(calculo2); 
$("#utilidad").change(calculo); 
$("#impuesto").change(calculo); 
$("#util2").change(calculo2); 
$("#precio1").change(reverso); 
$("#precio2").change(reverso2); 
		 $('#btnguardar').click(function(){   
		document.getElementById('loading').style.display=""; 
		document.getElementById('btnguardar').style.display="none"; 
		document.getElementById('btncancelar').style.display="none"; 
		document.getElementById('formulario').submit(); 
		})
	$("#cbx1").click(function() {
       if ($(this).is(":checked")){
        $("#cbx1").val(1);
		$("#porcentaje").attr("disabled",false);
		$("#porcentaje").focus();
       } else {
         $("#cbx1").val(0);
		$("#porcentaje").val(0);
		 $("#porcentaje").attr("disabled",true);
		 $("#costo").focus();
       }
   });
      	$("#cbx2").click(function() {
       if ($(this).is(":checked")){
        $("#cbx2").val(1);

       } else {
         $("#cbx2").val(0);
       }
   });
   	$("#cbxv").click(function() {
       if ($(this).is(":checked")){
        $("#cbxv").val(1);

       } else {
         $("#cbxv").val(0);
       }
   });
   	$("#cbx3").click(function() {
       if ($(this).is(":checked")){
       const element = document.getElementById('nivelp'); 
		element.disabled = false;

       } else {
       const element = document.getElementById('nivelp'); 
		element.disabled = true;
		  $("#nivelp").val(0);
       }
   });
})


      function calculo(){
		var mutil= $("#mutil").val();
       $("#precio1").val("");
      var  p1 =0;
      var costo= $("#costo").val();
      var impuesto= $("#impuesto").val();
      var utilidad= $("#utilidad").val();
        p1=parseFloat((utilidad/100));
		if(mutil==1){
        p2=parseFloat(costo) + parseFloat(p1*costo);
		}else{
		p2=(costo/((100-utilidad)/100));
		}
        iva=p2*(impuesto/100);
        pt=(parseFloat(p2)+parseFloat(iva));
		pt=trunc(pt,2);
      $("#precio1").val(pt);
 
      }
      function calculo2(){
		var mutil= $("#mutil").val();
      $("#precio2").val("");
      var  p1 =0;
      var costo= $("#costo").val();
      var impuesto= $("#impuesto").val();
      var utilidad= $("#util2").val();
        p1=parseFloat((utilidad/100));
		if(mutil==1){
        p2=parseFloat(costo) + parseFloat(p1*costo);
		}else{
		p2=(costo/((100-utilidad)/100));
		}
        iva=p2*(impuesto/100);
        pt=(parseFloat(p2)+parseFloat(iva));
		pt=trunc(pt,2);
		$("#precio2").val(pt);
      }
          function reverso(){
        var  p30 =0;  
       p30= $("#precio1").val();
	   var mutil= $("#mutil").val();
      var costo= $("#costo").val();
      var utilidad= $("#impuesto").val();       
    var    p31=parseFloat((utilidad/100));  
		if(mutil==1){
		var    p32=parseFloat(costo) + parseFloat(p31*costo);     
        iva=(p30/p32);
        var util=((iva-1)*100);
        pt=(parseFloat(util));
		}else{
		var  p32=parseFloat(costo) + parseFloat(p31*costo);    
		util=(100-((p32*100)/p30));
		 pt=(parseFloat(util));
		}
        var nv=(new Intl.NumberFormat("de-DE", {style:  "decimal", decimal: "2"}).format(pt));
		nv=trunc(nv,2);
      $("#utilidad").val(parseFloat(nv));
      }
        function reverso2(){
        var  p302 =0;  
       p302= $("#precio2").val();
	    var mutil= $("#mutil").val();
      var costo= $("#costo").val();
      var utilidad= $("#impuesto").val();       
    var    p312=parseFloat((utilidad/100));  
	if(mutil==1){		
    var    p322=parseFloat(costo) + parseFloat(p312*costo);     
        iva=(p302/p322);
        var util2=((iva-1)*100);
        pt2=(parseFloat(util2));
		}else{
		var  p322=parseFloat(costo) + parseFloat(p312*costo);    
		util2=(100-((p322*100)/p302));
		 pt2=(parseFloat(util2));
		}
        var nv2=(new Intl.NumberFormat("de-DE", {style:  "decimal", decimal: "2"}).format(pt2));
		nv2=trunc(nv2,2);
      $("#util2").val(parseFloat(nv2));
      }
	function conMayusculas(field) {
            field.value = field.value.toUpperCase()
	}
		function trunc (x, posiciones = 0) {
  var s = x.toString()
  var l = s.length
  var decimalLength = s.indexOf('.') + 1
  var numStr = s.substr(0, decimalLength + posiciones)
  return Number(numStr)
}
    </script>
      @endpush
@endsection