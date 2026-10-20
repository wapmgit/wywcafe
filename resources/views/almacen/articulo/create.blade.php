@extends ('layouts.admin')
@section ('contenido')
	<div class="row">
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
			<h3>Nuevo Articulo</h3>
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
			{!!Form::open(array('url'=>'almacen/articulo','method'=>'POST','autocomplete'=>'off','files'=>'true','id'=>'formulario'))!!}
            {{Form::token()}}
        <div class="row">
            	<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            		 <div class="form-group">
            			<label for="nombre">Nombre</label>
            			<input type="text" name="nombre" id="nombre" required value="{{old('nombre')}}" onchange="conMayusculas(this)" class="form-control" placeholder="Nombre...">
            		<input type="hidden" name="mutil" id="mutil" required value="{{$empresa->calc_util}}" class="form-control">
					</div>
            	</div>
				<div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
            	 <div class="form-group">
            			<label >Categoria</label>
            			<select name="idcategoria" class="form-control">
            				@foreach ($categorias as $cat)
            				<option value="{{$cat->idcategoria}}">{{$cat->nombre}}</option>
            				@endforeach
            			</select>
            			
            		</div>
				</div>
				<div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
            	 <div class="form-group">
            			<label for="codigo">Codigo</label>
            			<input type="text" name="codigo" id="codigo" required value="{{old('codigo')}}" class="form-control" placeholder="Codigo...">
            		</div>
				</div>

				 <div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
					 <div class="form-group">
					<label for="productor">¿M. Prima?</label>
					<input type="checkbox" name="mprima" id="cbx2" value="0">
					</div>
				</div>
			<div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
                 <div class="form-group">
               	<label for="productor">¿Produccion?</label>
				<input type="checkbox" name="produ" id="cbx3" value="0">
			</div>
            </div>
		<div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
            	 <div class="form-group">
            			<label for="nivelp">Nivel Produccion </label>          
                 <select name="nivelp" id="nivelp" class="form-control" disabled>          			            			
            				<option value="1">Tostado</option>
            				<option value="2">Molido</option>
            				<option value="3">Empaquetado</option>  							
            			</select>        			
            		</div>
            </div>
 				<div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
            	 <div class="form-group">
            			<label for="stock">Unidad </label>          
                 <select name="unidad" class="form-control">          			            			
            				<option value="UND">Unidad</option>
            				<option value="BTO">Bulto</option>
            				<option value="SCO">Saco</option>
            				<option value="CJA">Caja</option>
            				<option value="kg">Kg</option>
            				<option value="DISP">Display</option>
            				<option value="PR">Par</option>
            				<option value="LTR">Litros</option> 
							<option value="MNGA">Manga</option>           				
            				<option value="PAQ">Paquete</option>   							
            			</select>        			
            		</div>
            </div>
						<div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
            	 <div class="form-group">
            			<label for="codigo">Peso (Gms)</label>
            			<input type="number" name="peso"  min="0.1" required value="{{old('peso')}}" class="form-control">
            		</div>
            </div>

			<div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
            	 <div class="form-group">
            			<label for="codigo">Fraccion</label>
            			<input type="number" name="fraccion"  min="0.1" required value="{{old('fraccion')}}" class="form-control" placeholder="1,0.25,0.5">
            		</div>
            </div>
             <div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
            	 <div class="form-group">
            			<label for="descripcion">Descripcion</label>
            			<input type="text" name="descripcion" required value="{{old('descripcion')}}" class="form-control" placeholder="Descripcion..">
            		</div>
            </div>
             <div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
            	 <div class="form-group">
            			<label for="imagen">Imagen</label>
            			<input type="file" name="imagen"  class="form-control">
            		</div>
            </div> 
		   <div class="col-lg-2 col-sm-2 col-md-2 col-xs-12" align="center">
			           <div class="form-group">
               	<label for="productor">¿ Comision ?</label></br>
	<input type="checkbox" name="comi" id="cbx1" value="0">
		   </div>
		   </div>
  
           <div class="col-lg-2 col-sm-2 col-md-2 col-xs-4">
                 <div class="form-group">
                              <label for="costo">%</label>
                              <input type="number" min="0.01" step="0.01" disabled value="0" id="porcentaje"  name="porcentaje"  class="form-control" placeholder="%">
                 </div>         
				 </div>
	<div class="col-lg-2 col-sm-2 col-md-2 col-xs-12" align="center">
			           <div class="form-group">
               	<label for="productor">¿Disponible Venta?</label></br>
	<input type="checkbox" name="sevende" id="cbxv" checked value="1">
		   </div>
		   </div>
		           <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                 <div class="col-lg-2 col-sm-2 col-md-2 col-xs-4">
                 <div class="form-group">
                              <label for="costo">Costo</label>
                              <input type="number" min="0.01" step="0.01" value="" name="costo"  class="form-control" id="costo" placeholder="costo">
                 </div>     
				 </div>
                 <div class="col-lg-2 col-sm-2 col-md-2 col-xs-4">
                 <div class="form-group">
                              <label for="impuesto">Impuesto</label>
                              <input type="text" value="{{old('impuesto')}}" placeholder="impuesto" name="impuesto" id="impuesto"  class="form-control">
                 </div>        
				 </div>
                 
					<div class="col-lg-2 col-sm-2 col-md-2 col-xs-4">
						<div class="form-group">
                              <label for="utilidad">Utilidad 1</label>
                              <input type="text" name="utilidad" id="utilidad" onchange="calculo();" class="form-control" value="{{old('utilidad')}}" placeholder="% utilidad">
                        </div>
					</div>
					<div class="col-lg-2 col-sm-2 col-md-2 col-xs-4">
                        <div class="form-group">
                              <label for="precio1">Precio 1</label>
                              <input type="text" name="precio1" id="precio1"  class="form-control" value="{{old('precio1')}}" placeholder=" precio">
                 </div> 
                 </div>
				 <div class="col-lg-2 col-sm-2 col-md-2 col-xs-4">
                 <div class="form-group">
                              <label for="util2">Utilidad 2</label>
                              <input type="text" value="" name="util2" id="util2"  class="form-control">
                 </div>        
				 </div>
                 <div class="col-lg-2 col-sm-2 col-md-2 col-xs-4">
                 <div class="form-group">
                              <label for="precio2">Precio 2</label>
                              <input type="text" value="" name="precio2"  id="precio2" class="form-control">
                 </div>         
				 </div>
				 </div>
				
                              <!-- Productos Agrupados -->
            <div class="card card-info card-outline">
                <div class="card-header">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="usap" id="cbx4" value="0" >
                        <label class="form-check-label font-weight-bold" for="cbx4">¿Es un Producto Agrupado / Presentaciones?</label>
                    </div>
                </div>
                <div class="card-body" id="tagrupado" style="display:none">
                    <div class="row align-items-end mb-3 bg-light p-2 rounded">
                        <div class="col-md-3 form-group mb-0">
                            <label>Nombre Presentación</label>
                            <input type="text" id="ngrupo" class="form-control form-control-sm" placeholder="Ej: Pack x 6">
                        </div>
                        <div class="col-md-2 form-group mb-0">
                            <label>Cantidad</label>
                            <input type="number" id="cantidadg" min="0" class="form-control form-control-sm" placeholder="Cant.">
                        </div>
                        <div class="col-md-2 form-group mb-0">
                            <label>Utilidad (%)</label>
                            <input type="number" id="utilg" min="0" class="form-control form-control-sm" placeholder="%">
                        </div>
                        <div class="col-md-3 form-group mb-0">
                            <label>Precio</label>
                            <input type="number" id="preciog" min="0" class="form-control form-control-sm" placeholder="Precio">
                        </div>
                        <div class="col-md-2 form-group mb-0">
                            <button type="button" id="bt_grp" class="btn btn-info btn-sm btn-block">
                                <i class="fa fa-plus-circle"></i> Agregar
                            </button>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover text-center" id="detalles_out">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Presentación</th>
                                    <th>Cantidad</th>
                                    <th>Utilidad (%)</th>
                                    <th>Precio Venta</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>      
                        
          
 			 <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
            	 <div class="form-group">
            		<button class="btn btn-primary" type="button" id="btnguardar">Guardar</button>
            	<button class="btn btn-danger" type="reset" id="btncancelar">Cancelar</button>
			    <div style="display: none" id="loading">  <img src="{{asset('imagenes/sistema/loading30.gif')}}"></div>	
            		</div>
            </div>

           </div>   
           

			{!!Form::close()!!}		
            @push('scripts')
			<script>
$(document).ready(function(){
	    $('#bt_grp').click(function(){   
        agregar();  
    });
	 $("#utilg").change(calculog); 
	 $("#nivelp").val(0);
      $("#codigo").on("change",function(){
		  	var nuevo=$("#codigo").val();
			var pin2=nuevo.replace('-','/');
			$("#codigo").val(pin2);
         var form2= $('#formulario');
        var url2 = '/almacen/articulo/validar';
        var data2 = form2.serialize();
    $.post(url2,data2,function(result2){  
      var resultado2=result2;
         console.log(resultado2); 
         rows=resultado2.length; 
      if (rows > 0){
            var nombre=resultado2[0].nombre;
          var codigo=resultado2[0].codigo; 
          var descripcion=resultado2[0].descripcion;   
          alert ('Codigo ya existe!!, Nombre: '+nombre+' Codigo: '+codigo+' descripcion: '+descripcion);   
           $("#codigo").val("");
}    
          });
     });
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
       $("#cbx4").click(function() {
        if ($(this).is(":checked")){
            $("#cbx4").val(1);
            $('#tagrupado').slideDown(); 
        } else {
            $("#cbx4").val(0);
            $('#tagrupado').slideUp();
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
var cont = 0;

function agregar(){
    var gnombre = $("#ngrupo").val();
    var gcantidad = $("#cantidadg").val();
    var gutil = $("#utilg").val();
    var gprecio = $("#preciog").val();

    if (gnombre !== "" && gcantidad !== "" && gprecio !== "" && gutil !== ""){          
        var fila = '<tr class="selected">' +
            '<td><input type="hidden" name="vidgrupo[]" value="0"><input type="text" class="form-control form-control-sm" name="vngrupo[]" value="'+gnombre+'"></td>' +
            '<td><input type="number" class="form-control form-control-sm text-center" name="vgcant[]" value="'+gcantidad+'"></td>' +
            '<td><input type="number" class="form-control form-control-sm text-center" name="vgutil[]" value="'+gutil+'"></td>' +
            '<td><input type="number" class="form-control form-control-sm text-center" name="vgpre[]" value="'+gprecio+'"></td>' +
            '</tr>';
        cont++;
        limpiar();
        $('#detalles_out').append(fila);
    } else {
        alert("Error al ingresar los datos de la presentación");
    }
}

function limpiar(){
    $("#cantidadg").val("");
    $("#utilg").val("");
    $("#ngrupo").val("");
    $("#preciog").val("");
}
$("#utilidad").change(calculo);
$("#util2").change(calculo2);
$("#precio1").change(reverso); 
$("#nombre").change(revisar); 
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
    	$("#precio1").val(pt.toFixed(2));
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
      $("#precio2").val(pt.toFixed(2));
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
  //      alert(nv);
      $("#utilidad").val(parseFloat(nv));
      }
	  function calculog(){
    var mutil = $("#mutil").val();
    $("#preciog").val("");
    var costo = $("#costo").val() * $("#cantidadg").val();
    var impuesto = $("#impuesto").val();
    var utilidad = $("#utilg").val();  alert(costo);
    var p1 = parseFloat(utilidad / 100);
    var p2 = (mutil == 1) ? (parseFloat(costo) + parseFloat(p1 * costo)) : (costo / ((100 - utilidad) / 100));
    var iva = p2 * (impuesto / 100);
    var pt = trunc(parseFloat(p2) + parseFloat(iva), 2);
    $("#preciog").val(pt);
}
	  function revisar(){
	var nuevo=$("#nombre").val();
	 var pin2=nuevo.replace('-','/');
	$("#nombre").val(pin2);
	  }
  function conMayusculas(field) {
            field.value = field.value.toUpperCase()
}

function trunc(x, posiciones = 0) {
    var s = x.toString();
    var decimalLength = s.indexOf('.') + 1;
    if (decimalLength === 0) return Number(s);
    var numStr = s.substr(0, decimalLength + posiciones);
    return Number(numStr);
}
 		</script>
			@endpush
    

@endsection