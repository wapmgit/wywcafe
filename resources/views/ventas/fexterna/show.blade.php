@extends ('layouts.admin')
@section ('contenido')
<?php 
$acum=0;
$ceros=5;
function add_ceros($numero,$ceros) {
  $numero=$numero+1;
$digitos=strlen($numero);
  $recibo=" ";
  for ($i=0;$i<8-$digitos;$i++){
    $recibo=$recibo."0";
  }
return $insertar_ceros = $recibo.$numero;
};
?>
@include('ventas.fexterna.empresa')  
			<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
	<h3 align="center"> Venta # {{$venta->factura}}</h3><label ><?php if($venta->estatus==1){ echo " * Anulado *"; } ?></label>
  </div>
</div><hr/>
            <div class="row">
                              <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                    <div class="form-group">

                    	<label for="proveedor">Razon: </label>
						{{$venta->nombre}}
                    </div>
                </div>
         	<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                <div class="form-group">
                    <label for="concepto">Rif: </label>
                 		{{$venta->rif}}
                </div>
            </div>
					         	<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                    <div class="form-group">
                        <label for="costo">Fecha: </label>
                     		{{$venta->fecha}}
                    </div>
                    </div>
						<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                    <div class="form-group">
                        <label for="costo">Serie: </label>
                   		{{$venta->serie}}
                    </div>
                    </div>
			 <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                    <div class="form-group">
                        <label for="costo">Tipo: </label>
                    		{{$venta->tipo}}
                    </div>
                    </div>
						<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                    <div class="form-group">
                        <label for="costo">Documento</label>
                    	{{$venta->factura}}
                    </div>
                    </div>
			 <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                    <div class="form-group">
                        <label for="costo">Nro control: </label>
                        	{{$venta->control}}
                    </div>
                    </div>
            </div>
      <div clas ="row">
                <div class="panel panel-primary">
                <div class="panel-body">
		 <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                    <div class="form-group">
                        <label for="costo">Total Venta: </label>
                     {{$venta->totalventa}}
                    </div>
                    </div>
		 <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                    <div class="form-group">
                        <label for="costo">Base Imponible:</label>
            {{$venta->base}}
                    </div>
                    </div>
		 <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                    <div class="form-group">
                        <label for="costo">Exento: </label>
                       {{$venta->exento}}
                    </div>
                    </div>
		 <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                    <div class="form-group">
                        <label for="costo">Iva: </label>
                       {{$venta->iva}}
                    </div>
                    </div>
                </div>
                    
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" align="right">
            	    <div class="form-group">
                    <input name="_token" value="{{ csrf_token() }}" type="hidden" ></input>
                        <button class="btn btn-primary" id="imprimir" type="button">Imprimir</button>
            	       <button class="btn btn-danger" type="button" id="regresar" >Regresar</button>
                    </div>
                </div>
     
        </div>          
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="form-group">
                    <label for="num_comprobante">Usuario: {{$venta->usuario}}</label>
                </div>
            </div> 

		
@push ('scripts')
<script>
$(document).ready(function(){
    $('#imprimir').click(function(){
  //  alert ('si');
  document.getElementById('imprimir').style.display="none";
  document.getElementById('regresar').style.display="none";
  window.print(); 
  window.location="/ventas/fexterna";
    });
$('#regresar').on("click",function(){
  window.location="/ventas/fexterna";
  
});
});
</script>
@endpush
@endsection