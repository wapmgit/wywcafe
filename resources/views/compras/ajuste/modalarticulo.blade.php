

<div class="modal  modal-primary" aria-hidden="true"
role="dialog" tabindex="-1" id="modalarticuloid">

 	{!!Form::open(array('url'=>'/compras/articulo','method'=>'POST','autocomplete'=>'off','id'=>'formulario','files'=>'true'))!!}
            {{Form::token()}}
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" 
				aria-label="Close">
                     <span aria-hidden="true">×</span>
                </button>
                <h3 class="modal-title">Nuevo arfcticulo </h3>
			</div>
			<div class="modal-body">

        <div class="row">
            	<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            		 <div class="form-group">
            			<label for="nombre">Nombre</label>
            			<input type="text" name="nombre" id="nombre" onchange="conMayusculas(this)" required value="" class="form-control" placeholder="Nombre...">
            		</div>
            	</div>
            <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            	 <div class="form-group">
            			<label >Categoria</label>
            			<select name="idcategoria" class="form-control">
            				@foreach ($categorias as $cat)
            				<option value="{{$cat->idcategoria}}">{{$cat->nombre}}</option>
            				@endforeach
            			</select>
            		</div>
            </div>
            <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            	 <div class="form-group">
            			<label for="codigo">Codigo</label>
            			<input type="text" name="codigo" id="codigo" required value="{{old('codigo')}}" class="form-control" placeholder="Codigo...">
            		</div>
            </div>
 					<div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
            	 <div class="form-group">
            			<label for="stock">Stock</label>
            			<input type="text" name="stock" required value="0"  class="form-control" disabled >
            		</div>
            </div>
 			<div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
            	 <div class="form-group">
            			<label for="stock">unidad </label>          
                  <input type="text" name="unidad"  value="{{$articulo->unidad}}" class="form-control" placeholder="Und, Caja, Bto...">         			
            		</div>
            </div>
             <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            	 <div class="form-group">
            	
            			
            		</div>
            </div>
              <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            	 <div class="form-group">
            	
            			<input type="file" name="imagen"  class="form-control" style="display: none">
            		</div>
            </div>
                 <div class="col-lg-2 col-sm-2 col-md-2 col-xs-6">
                 <div class="form-group">
                              <label for="costo">Costo</label>
                              <input type="text" value="" name="costo"  class="form-control" id="costo" placeholder="costo">
                 </div>         </div>
                 <div class="col-lg-2 col-sm-2 col-md-2 col-xs-6">
                 <div class="form-group">
                              <label for="impuesto">Impuesto</label>
                              <input type="text" value="" placeholder="impuesto" name="impuesto" id="impuesto"  class="form-control">
                 </div>         </div>
                 
                     <div class="col-lg-2 col-sm-2 col-md-2 col-xs-6">
                   <div class="form-group">
                              <label for="utilidad">Utilidad 1</label>
                              <input type="text" name="utilidad" id="utilidad"  class="form-control" value="" placeholder="% utilidad">
                        </div>
                        </div>
            <div class="col-lg-2 col-sm-2 col-md-2 col-xs-6">
                        <div class="form-group">
                              <label for="precio1">Precio 1</label>
                              <input type="text" name="precio1" id="precio1"  class="form-control" value="" placeholder=" precio BSF">
                 </div> 
                 </div><div class="col-lg-2 col-sm-2 col-md-2 col-xs-6">
                 <div class="form-group">
                              <label for="util2">utilidad 2</label>
                              <input type="text" value="" name="util2" id="util2"  class="form-control">
                 </div>         </div>
                 <div class="col-lg-2 col-sm-2 col-md-2 col-xs-6">
                 <div class="form-group">
                              <label for="precio2">Precio 2</label>
                              <input type="text" value="" name="precio2"  id="precio2" class="form-control">
                 </div>         </div>
                        
            </div> 

	
			</div><div class="modal-footer">
			 <div class="form-group">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
				<button type="button" class="btn btn-primary" id="Nenviar">Confirmar</button>
				</div>
			</div>
			</div>
			
		</div>
	
		{!!Form::close()!!}		

</div>
   @push('scripts')
      <script>
$(document).ready(function(){
document.getElementById('Nenviar').style.display="none";
$("#costo").change(calculo); 
$("#costo").change(calculo2); 
$("#utilidad").change(calculo); 
$("#impuesto").change(calculo); 
$("#util2").change(calculo2); 
$("#precio1").change(reverso); 
$("#nombre").change(revisar); 

      $("#codigo").on("change",function(){
		  alert();
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
}    else {
	 document.getElementById('Nenviar').style.display="";
}

          });
     });
})


      function calculo(){
         
//        alert('so');
       $("#precio1").val("");
      var  p1 =0;
      var costo= $("#costo").val();
      var impuesto= $("#impuesto").val();
      var utilidad= $("#utilidad").val();
        p1=parseFloat((utilidad/100));
        p2=parseFloat(costo) + parseFloat(p1*costo);
        iva=p2*(impuesto/100);
        pt=(parseFloat(p2)+parseFloat(iva));
      $("#precio1").val(pt);
 
      }
      function calculo2(){
      $("#precio2").val("");
      var  p1 =0;
      var costo= $("#costo").val();
      var impuesto= $("#impuesto").val();
      var utilidad= $("#util2").val();
        p1=parseFloat((utilidad/100));
        p2=parseFloat(costo) + parseFloat(p1*costo);
        iva=p2*(impuesto/100);
        pt=(parseFloat(p2)+parseFloat(iva));
      $("#precio2").val(pt);
      } 
        function reverso(){
        var  p30 =0;  
       p30= $("#precio1").val();
      var costo= $("#costo").val();
      var utilidad= $("#impuesto").val();       
    var    p31=parseFloat((utilidad/100));  
    var    p32=parseFloat(costo) + parseFloat(p31*costo);     
        iva=(p30/p32);
        var util=((iva-1)*100);
        pt=(parseFloat(util));
        var nv=(new Intl.NumberFormat("de-DE", {style:  "decimal", decimal: "2"}).format(pt));
  //      alert(nv);
      $("#utilidad").val(parseFloat(nv));
      }	  
	  	  function revisar(){
	var nuevo=$("#nombre").val();
	 var pin2=nuevo.replace('-','/');
	$("#nombre").val(pin2);
	  }

	    function conMayusculas(field) {
            field.value = field.value.toUpperCase()
}
    </script>
      @endpush


      
  
