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
			{!!Form::open(array('url'=>'almacen/articulo','method'=>'POST','autocomplete'=>'off','files'=>'true'))!!}
            {{Form::token()}}
        <div class="row">
            	<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            		 <div class="form-group">
            			<label for="nombre">Nombre</label>
            			<input type="text" name="nombre" required value="{{old('nombre')}}" class="form-control" placeholder="Nombre...">
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
            			<input type="text" name="codigo" required value="{{old('codigo')}}" class="form-control" placeholder="Codigo...">
            		</div>
            </div>
 			<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            	 <div class="form-group">
            			<label for="stock">Stock</label>
            			<input type="text" name="stock" required value="{{old('stock')}}" class="form-control" placeholder="stock...">
            		</div>
            </div>

             <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            	 <div class="form-group">
            			<label for="descripcion">Descripcion</label>
            			<input type="text" name="descripcion" required value="{{old('descripcion')}}" class="form-control" placeholder="descripcion..">
            		</div>
            </div>
              <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            	 <div class="form-group">
            			<label for="imagen">Imagen</label>
            			<input type="file" name="imagen"  class="form-control">
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
                              <input type="text" value="{{old('impuesto')}}" placeholder="impuesto" name="impuesto" id="impuesto"  class="form-control">
                 </div>         </div>
                 
                     <div class="col-lg-2 col-sm-2 col-md-2 col-xs-6">
                   <div class="form-group">
                              <label for="utilidad">Utilidad 1</label>
                              <input type="text" name="utilidad" id="utilidad" onchange="calculo();" class="form-control" value="{{old('utilidad')}}" placeholder="% utilidad">
                        </div>
                        </div>
            <div class="col-lg-2 col-sm-2 col-md-2 col-xs-6">
                        <div class="form-group">
                              <label for="precio1">Precio 1</label>
                              <input type="text" name="precio1" id="precio1"  class="form-control" value="{{old('precio1')}}" placeholder=" precio BSF">
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
                        
            </div> <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
                   
          
 			<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            	 <div class="form-group">
            		<button class="btn btn-primary" type="submit">Guardar</button>
            	<button class="btn btn-danger" type="reset">Cancelar</button>	
            		</div>
            </div>

           
            	
            </div>
          
           

			{!!Form::close()!!}		
            @push('scripts')
			<script>
$(document).ready(function(){

      
})
$("#utilidad").change(calculo);
$("#util2").change(calculo2);
      function calculo(){
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

 		</script>
			@endpush
    

@endsection