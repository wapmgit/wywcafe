@extends ('layouts.admin')
@section ('contenido')
  <?php $cont=0; ?>
	<div class="row">
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
			<h3>Registro de Molida de Cafe</h3>
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
			{!!Form::open(array('url'=>'/produccion/molida/save','method'=>'POST','autocomplete'=>'off'))!!}
            {{Form::token()}}

			<div class="row">
				<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <div class="form-group">
            	<label for="nombre">Responsable</label>
            	<input type="text" name="responsable"  onchange="conMayusculas(this)" required class="form-control" placeholder="Nombre...">
            </div>
            </div>
		<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <div class="form-group">
            	<label for="nombre">Encargado  Molida</label>
            <input type="text" name="encargado"  onchange="conMayusculas(this)" required class="form-control" placeholder="Nombre...">
            </div>
            </div>

	<div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
            	 <div class="form-group">
            			<label >Materia Prima</label>
            			<select name="mprima" id="mprima" class="form-control">
            				@foreach ($materia as $cat)
            				<option value="{{$cat->idarticulo}}">{{$cat->nombre}} - {{$cat->stock}}</option>
            				@endforeach
            			</select>
            			
            		</div>
            </div>
							<div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
		   <div class="form-group">
            	<label for="descripcion">Kg</label>
            	<input type="number" name="kgsubidos" id="kgs" required class="form-control">
            </div>
            </div>
		<div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
		   <div class="form-group">
            	<label for="descripcion">Kg Molidos</label>
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
            			<label >Producto Proceso</label>
            			<select name="producto" class="form-control">
            				@foreach ($producto as $cat)
            				<option value="{{$cat->idarticulo}}">{{$cat->nombre}}</option>
            				@endforeach
            			</select>
            			
            		</div>
            </div>
	<div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
            	 <div class="form-group">
            			<label >Tipo Empaquetado</label>
            			<select name="tipoemp" class="form-control">            			
            				<option value="0">Automatico</option>
            				<option value="1">Manual</option>
						</select>
            			
            		</div>
            </div>
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="table-responsive">
			<table class="table table-striped table-bordered table-condensed table-hover">
			  <caption>Registro de Produccion</caption>
				<thead>
					<th>Producto</th>
					<th>Peso Gr.</th>
					<th>Cantidad</th>
					<th>Kilos</th>
				</thead>
               @foreach ($otros as $ven)
			      <?php $cont++; ?>
				<tr>
					<td width="30">{{ $ven->nombre}}</td>
					<td width="30">{{ $ven->pesogr}}
						<input type="hidden" name="idproduccion[]" value="{{$ven->idarticulo}}"class="form-control" value="0">
					</td>
					<td width="30"><input type="number" id="cnt<?php echo $cont; ?>" onchange="javascript:abrircalc({{$cont}},{{$ven->pesogr}});" name="produccion[]"  class="form-control" value="0"></td>
					<td width="30"><input type="number" id="kg<?php echo $cont; ?>" name="kgproduccion[]" step="0.01" class="form-control" value="0"></td>
				</tr>
			@endforeach
				<tr><td>Total Kg Empaquetados</td>
				<td><input type="number" name="kgemp" id="kgemp" value="0" step="0.01" class="form-control"></td>
				<td>Total Kg Dif</td>
				<td><input type="number" name="kgdif" id="kgdif" value="0"  step="0.01"  class="form-control"></td>
				</tr>
			
			</table>
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
	$("#kgs").on("change",function(){		
	var kgs=$("#kgs").val();
		datos= $("#mprima option:selected").text();
		var dat= datos.split('-');
      var kgstock=dat[1];
		if(parseFloat(kgs) > parseFloat(kgstock)){
			alert('Kilos Registrados No puede ser mayor al Stock de la Materia Prima');
			$("#kgs").val(0);
			$("#kgs").focus();
		}
	});
	$("#kgt").on("change",function(){		
		var kgt=$("#kgt").val();
		var kgs=$("#kgs").val();
		if(parseFloat(kgs)>parseFloat(kgt)){
		var ope=(100-((kgt*100)/kgs)).toFixed(2);		
		$("#reduccion").val(ope);
		$("#kgdif").val(kgs);		
		}else{
			alert('Kg Molidos no Pueden ser mayor a Kg Materia Prima');
			$("#kgt").val(0);
			$("#reduccion").val(0);
			$("#kgdif").val(0);
		}
	})

});
	function abrircalc(id,peso){
	var kge=$('#kgemp').val();
	var kgdif=$('#kgdif').val();
	var cnt=$('#cnt'+id).val();
	var calc=(cnt*peso)/1000;	
	
		var acume=parseFloat(kge)+parseFloat(calc);
		if(calc>kgdif){
			alert('Cantidad Empaquetada no puede ser Mayor a kg Molidos');
			$('#cnt'+id).val(0);
			$('#kg'+id).val(0);
		}else{
			$('#kg'+id).val(calc);
			$('#kgemp').val(acume);
			$('#kgdif').val(kgdif-calc);
			}
}
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