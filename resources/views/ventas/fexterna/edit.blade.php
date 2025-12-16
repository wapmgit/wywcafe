@extends ('layouts.admin')
@section ('contenido')
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<h3>Editar Factura: {{ $factura->factura}}</h3>
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
			{!!Form::model($factura,['method'=>'PATCH','id'=>'formulario','route'=>['ventas.fexterna.update',$factura->idventa],'files'=>'true'])!!}
            {{Form::token()}}
         <div class="form-group">
						<input type="hidden" value="{{$empresa->tc}}" id="valortasa" name="tc" class="form-control">
			<input type="hidden" value="{{$empresa->peso}}" id="valortasap" name="peso" class="form-control">
                    	<label for="proveedor">Razon </label>
				<select name="id_cliente" id="id_cliente" class="form-control selectpicker" data-live-search="true">						
                           @foreach ($personas as $per)
						  
                           <option value="{{$per -> id_cliente}}_{{$per -> cedula}}" <?php if($factura->cliente==$per ->id_cliente){ echo "selected"; }?>>{{$per -> cedula}}-{{$per -> nombre}}</option> 
                           @endforeach
                        </select> 
						 <input type="hidden" name="cliente" id="cliente" value="{{$factura -> cliente}}" required class="form-control" > 
                    </div>
                </div>
         	<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                <div class="form-group">
                    <label for="concepto">Rif</label>
                    <input type="text" name="rif" id="rif" value="{{$factura -> rif}}" required class="form-control"placeholder="Nro Rif" > 
                </div>
            </div>
					         	<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                    <div class="form-group">
                        <label for="costo">Fecha</label>
                        <input type="date" name="fecha" value="{{$factura -> fecha}}" class ="form-control" placeholder="FAC">
                    </div>
                    </div>
						<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                    <div class="form-group">
                        <label for="costo">Serie</label>
                        <input type="text" name="serie"  required value="{{$factura -> serie}}"  class ="form-control" placeholder="B">
                    </div>
                    </div>
			 <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                    <div class="form-group">
                        <label for="costo">Tipo</label>
                        <input type="text" name="tipo" value="{{$factura -> tipo}}" required class ="form-control" placeholder="FAC">
                    </div>
                    </div>
						<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                    <div class="form-group">
                        <label for="costo">Documento</label>
                        <input type="text" name="documento"  required value="{{$factura -> factura}}" class ="form-control" placeholder="0000000">
                    </div>
                    </div>
			 <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                    <div class="form-group">
                        <label for="costo">Nro control</label>
                        <input type="text" name="control"  required value="{{$factura -> control}}" class ="form-control" placeholder="00-00000">
                    </div>
                    </div>
            </div>
		
            
	
		          <div class ="row">
                <div class="panel panel-primary">
                <div class="panel-body">
		 <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                    <div class="form-group">
                        <label for="costo">Total Venta</label>
                        <input type="number" name="tventa" step="0.01" value="{{$factura -> totalventa}}" required class ="form-control" placeholder="0.00">
                    </div>
                    </div>
		 <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                    <div class="form-group">
                        <label for="costo">Base Imponible</label>
                        <input type="number" name="base" step="0.01" value="{{$factura -> base}}" required class ="form-control" placeholder="0.00">
                    </div>
                    </div>
		 <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                    <div class="form-group">
                        <label for="costo">Exento</label>
                        <input type="number" name="exe" step="0.01" required value="{{$factura -> exento}}" class ="form-control" placeholder="0.00">
                    </div>
                    </div>
		 <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                    <div class="form-group">
                        <label for="costo">Iva</label>
                        <input type="number" name="iva" step="0.01" required value="{{$factura -> iva}}" class ="form-control" placeholder="0.00">
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
			{!!Form::close()!!}		
	</div>
@endsection
  @push('scripts')
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