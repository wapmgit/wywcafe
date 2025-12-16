@extends ('layouts.admin')
@section ('contenido')
	<div class="row">
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
			<h3>Registro de Tostado</h3>
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
			{!!Form::open(array('url'=>'/produccion/tostado/save','method'=>'POST','autocomplete'=>'off'))!!}
            {{Form::token()}}

			<div class="row">
				<div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
            <div class="form-group">
            	<label for="nombre">Responsable</label>
            	<input type="text" name="responsable"  onchange="conMayusculas(this)" required class="form-control" placeholder="Nombre...">
            </div>
            </div>
		<div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
            <div class="form-group">
            	<label for="nombre">Tostador</label>
            	<select name="tostador" class="form-control">
            				@foreach ($tostador as $cat)
            				<option value="{{$cat->id}}">{{$cat->nombre}}</option>
            				@endforeach
            			</select>
            </div>
            </div>	
			<div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
            	 <div class="form-group">
            			<label >Materia Prima/stock</label>
            			<select name="mprima" id="mprima" class="form-control">
            				@foreach ($materia as $cat)
            				<option value="{{$cat->idarticulo}}">{{$cat->nombre}}-{{$cat->stock}}</option>
            				@endforeach
            			</select>
            			
            		</div>
            </div>
				<div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
            <div class="form-group">
            	<label for="descripcion">Cochas</label>
            	<input type="number" name="cochas" id="cochas" required class="form-control" value="1" step="1">
            </div>
            </div>

							<div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
		   <div class="form-group">
            	<label for="descripcion">Kg Total Subidos</label>
            	<input type="number" name="kgsubidos" id="kgs" required class="form-control">
            </div>
            </div>
		<div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
		   <div class="form-group">
            	<label for="descripcion">Kg Tostados</label>
            	<input type="number" name="kgtostados" id="kgt" required class="form-control" placeholder="kg">
            </div>
            </div>
	<div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
		   <div class="form-group">
            	<label for="descripcion">Reduccion</label>
            	<input type="number" name="reduccion" id="reduccion" readonly class="form-control" value="0">
            </div>
            </div>
				<div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
            	 <div class="form-group">
            			<label >Producto</label>
            			<select name="producto" class="form-control">
            				@foreach ($producto as $cat)
            				<option value="{{$cat->idarticulo}}">{{$cat->nombre}}</option>
            				@endforeach
            			</select>
            			
            		</div>
            </div>
	<div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
		   <div class="form-group">
            	<label for="descripcion">Comision Tostador</label>
            	<input type="number" name="comi" id="comi" class="form-control" value="0">
            </div>
            </div>
	<div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
		   <div class="form-group">
            	<label for="descripcion">Kg Comision</label>
            	<input type="number" name="kgcomi" id="kgcomi" readonly class="form-control" value="0">
            </div>
            </div>
		<div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
		   <div class="form-group">
            	<label for="descripcion">Comision Maquina</label>
            	<input type="number" name="comima" id="comima" class="form-control" value="0">
            </div>
            </div>
				<div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
		   <div class="form-group">
            	<label for="descripcion">Kg Comision</label>
            	<input type="number" name="kgcomima" id="kgcomima" readonly class="form-control" value="0">
            </div>
            </div>
			<div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
            <div class="form-group">
            	<button class="btn btn-primary" type="submit">Guardar</button>
            	<button class="btn btn-danger" type="reset">Cancelar</button>
            </div>
            </div>

			{!!Form::close()!!}		
            
			</div>
	
@endsection
  @push('scripts')
<script>
$(document).ready(function(){
	$("#cochas").on("change",function(){
		$("#kgs").val($("#cochas").val()*35);
		var kgs=$("#kgs").val();
			datos= $("#mprima option:selected").text();
		var dat= datos.split('-');
      var kgstock=dat[1];
		if(parseFloat(kgs) > parseFloat(kgstock)){
			alert('No Posee suficiente Stock');
			$("#kgs").val(0);
			$("#cochas").val(0);
			$("#cochas").focus();
		}
	})	
	$("#kgt").on("change",function(){		
		var kgt=$("#kgt").val();
		var kgs=$("#kgs").val();
		var ope=(100-((kgt*100)/kgs)).toFixed(2);		
		$("#reduccion").val(ope);
		if(kgs>kgt){
		var ope=(100-((kgt*100)/kgs)).toFixed(2);		
		$("#reduccion").val(ope);	
		}else{
			alert('Kg Tostados no Pueden ser mayor a Kg Materia Prima');
			$("#kgt").val(0);
			$("#reduccion").val(0);
		}
	})	
	$("#comi").on("change",function(){		
		var kgt=$("#kgt").val();
		var comi=$("#comi").val();
		
		var ope=((comi/100)*kgt).toFixed(2);			
		$("#kgcomi").val(ope);	
	})
		$("#comima").on("change",function(){		
		var kgt=$("#kgt").val();
		var kgcomi=$("#kgcomi").val();
		var comi=$("#comima").val();
		var kgnet=parseFloat(kgt)-parseFloat(kgcomi);
		var ope=((comi/100)*(kgnet)).toFixed(2);			
		$("#kgcomima").val(ope);	
	})
});
	
function conMayusculas(field) {
            field.value = field.value.toUpperCase()
}

function asignar(){	
	var valor=document.getElementById('cbox1').checked; 
	if(valor==true){
		$('#cbox1').val(1);
	}else{
		$('#cbox1').val(0);
	};
}
</script>
@endpush