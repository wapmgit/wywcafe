@extends ('layouts.admin')
<?php $mostrar=0; ?>
  @if(Auth::user()->nivel=="A")
@section ('contenido')
<?php $mostrar=1; ?>
<div class="row" id="search" style="display: true">
	<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
		<h3>Indique Grupo</h3>
		@include('reportes.catalogo.search')
	</div>
</div>

@endsection 

@endif 
<style> 
   .cabecera { background: linear-gradient(to bottom, #67CD18, #FAFAFA); padding: 2px;}
   .pie { background: linear-gradient(to bottom,  #FAFAFA, #67CD18); padding: 2px;}
.bordeimagen{
border:2px solid #489B07;
padding:5px;
}

.card {
  box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
  max-width: 300px;
  margin: auto;
  text-align: center;
  font-family: arial;
}

.price {
  color: grey;
  font-size: 22px;
}

.card button {
  border: none;
  outline: 0;
  padding: 12px;
  color: white;
  background-color: #000;
  text-align: center;
  cursor: pointer;
  width: 100%;
  font-size: 18px;
}

.card button:hover {
  opacity: 0.7;
}
  </style> 
@section('reporte')              
<div class="row">
<div class="panel-body">

  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 cabecera">
    @include('reportes.catalogo.empresa')
    <h3 align="center"><B>CATALOGO DE VENTAS</B></h3> 
<?php
$numero = 123;
$longitud = 35; // La longitud deseada, incluyendo los ceros a la izquierda
$relleno = "-"; // El carácter con el que se rellenará

//$numero_con_ceros = str_pad($numero, $longitud, $relleno, STR_PAD_LEFT);

//echo $numero_con_ceros; // Salida: 00123
?>

  </div>
	@foreach($datos as $det)
	<?php $cnt=strlen($det->nombre);if($cnt < 25){$ajuste="</br>"; }else{$ajuste="";} ?>
		<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12" >
<div class="card">
  <img src="{{ asset('/imagenes/articulos/'.$det->imagen)}}" alt="{{$det->nombre}}" height="250px" width="250px">
  <h3>{{str_pad($det->nombre, $longitud, $relleno, STR_PAD_RIGHT)}}</h3>
  <p class="price">  {{$det->codigo}}</p>
  <p></p>
  <p><button>${{$det->precio1}} {{$det->unidad}}</button></p>
</div>
                </div>  
            @endforeach	
        
                <div class="col-lg-12 col-md-12 col-sm-6 col-xs-12">
				<div class="pie">
					   <label>Usuario: </label>  {{ Auth::user()->name }}  
                    <div class="form-group" align="center">
                     <button type="button" id="imprimir" class="btn btn-primary" data-dismiss="modal">Imprimir</button> 
                    </div>
                 </div>
                </div>
                   
</div><!-- /.box-body -->
</div><!-- /.box -->
             

@push ('scripts')
<script>
$(document).ready(function(){
    $('#imprimir').click(function(){
  document.getElementById('imprimir').style.display="none";
  window.print(); 
  window.location="../reportes/catalogo";
    });

});

</script>

@endpush
@endsection