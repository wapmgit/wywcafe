@extends ('layouts.admin')
@section ('contenido')
<?php
$fserver=date('Y-m-d');
$fecha_a=$empresa -> fechasistema;
function dias_transcurridos($fecha_a,$fserver)
{
$dias = (strtotime($fecha_a)-strtotime($fserver))/86400;
//$dias = abs($dias); $dias = floor($dias);
return $dias;
} 
$vencida=0;
if (dias_transcurridos($fecha_a,$fserver) < 0){
  $vencida=1;
  echo "<div class='alert alert-danger'>
      <H2>LICENCIA DE USO DE SOFTWARE VENCIDA!!!</H2> contacte su Tecnico de soporte.
      </div>";
};
  
?>
		<div class="row">

		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
			<h3>Nueva Venta Externa</h3>
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
			{!!Form::open(array('url'=>'ventas/fexterna','method'=>'POST','autocomplete'=>'off','id'=>'formajuste'))!!}
            {{Form::token()}}
            <div class="row">
                              <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <div class="form-group">
						<input type="hidden" value="{{$empresa->tc}}" id="valortasa" name="tc" class="form-control">
			<input type="hidden" value="{{$empresa->peso}}" id="valortasap" name="peso" class="form-control">
                    	<label for="proveedor">Razon </label>
				<select name="id_cliente" id="id_cliente" class="form-control selectpicker" data-live-search="true">						
                           @foreach ($personas as $per)
                           <option value="{{$per -> id_cliente}}_{{$per -> cedula}}">{{$per -> cedula}}-{{$per -> nombre}}</option> 
                           @endforeach
                        </select> 
						 <input type="hidden" name="cliente" id="cliente" value="" required class="form-control" > 
                    </div>
                </div>
         	<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                <div class="form-group">
                    <label for="concepto">Rif</label>
                    <input type="text" name="rif" id="rif" value="" required class="form-control"placeholder="Nro Rif" > 
                </div>
            </div>
					         	<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                    <div class="form-group">
                        <label for="costo">Fecha</label>
                        <input type="date" name="fecha"  class ="form-control" placeholder="FAC">
                    </div>
                    </div>
						<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                    <div class="form-group">
                        <label for="costo">Serie</label>
                        <input type="text" name="serie"  required value="B"  class ="form-control" placeholder="B">
                    </div>
                    </div>
			 <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                    <div class="form-group">
                        <label for="costo">Tipo</label>
                        <input type="text" name="tipo" value="FAC" required class ="form-control" placeholder="FAC">
                    </div>
                    </div>
						<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                    <div class="form-group">
                        <label for="costo">Documento</label>
                        <input type="text" name="documento"  required  class ="form-control" placeholder="0000000">
                    </div>
                    </div>
			 <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                    <div class="form-group">
                        <label for="costo">Nro control</label>
                        <input type="text" name="control"  required class ="form-control" placeholder="00-00000">
                    </div>
                    </div>
            </div>
            <div clas ="row">
                <div class="panel panel-primary">
                <div class="panel-body">
		 <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                    <div class="form-group">
                        <label for="costo">Total Venta</label>
                        <input type="number" name="tventa" step="0.01" required class ="form-control" placeholder="0.00">
                    </div>
                    </div>
		 <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                    <div class="form-group">
                        <label for="costo">Base Imponible</label>
                        <input type="number" name="base" step="0.01" required class ="form-control" placeholder="0.00">
                    </div>
                    </div>
		 <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                    <div class="form-group">
                        <label for="costo">Exento</label>
                        <input type="number" name="exe" step="0.01" required class ="form-control" placeholder="0.00">
                    </div>
                    </div>
		 <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                    <div class="form-group">
                        <label for="costo">Iva</label>
                        <input type="number" name="iva" step="0.01" required class ="form-control" placeholder="0.00">
                    </div>
                    </div>
                </div>
                    
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" align="right">
            	    <div class="form-group">
                    <input name="_token" value="{{ csrf_token() }}" type="hidden" ></input>
                        <button class="btn btn-primary" type="submit">Procesar</button>
            	       <button class="btn btn-danger" type="reset" >Cancelar</button>
                    </div>
                </div>
     
        </div>
       
@push ('scripts')
<script>
$(document).ready(function(){
	$("#id_cliente").change(mostrarif);
	
});
	function mostrarif(){  
      dato=document.getElementById('id_cliente').value.split('_');
      $("#cliente").val(dato[0]);
	  $("#rif").val(dato[1]);
    }
function conMayusculas(field) {
	field.value = field.value.toUpperCase()
}
</script>
@endpush
@endsection