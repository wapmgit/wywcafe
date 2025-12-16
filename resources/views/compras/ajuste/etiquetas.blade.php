@extends ('layouts.admin')
@section ('contenido')

			@foreach($detalles as $det)
				<div class="col-lg-2 col-md-3 col-sm-2 col-xs-" >
                    <div class="form-group" align="center">
						<label for="proveedor" align="center">{{$det->codigo}}</label> </br>
					    <label for="proveedor"> {{$det->articulo}} </label></br>
						<label for="proveedor"> {{$det->precio1}} $</label>
                    </div>
                </div>  
            @endforeach	

         	<div class="col-lg-12 col-md-12 col-sm-6 col-xs-12">
                    <div class="form-group" align="center">
                     <button type="button" id="imprimir" class="btn btn-primary" data-dismiss="modal">Imprimir</button>
					 <button type="button" id="regresar" class="btn btn-danger" data-dismiss="modal">Regresar</button>
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
  window.location="/compras/ajuste";
    });
$('#regresar').on("click",function(){
  window.location="/compras/ajuste";
  
});
});
</script>
@endpush
@endsection