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
}<
  </style> 
@section('reporte')              
<div class="row">
<div class="panel-body">

  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 cabecera">
    @include('reportes.catalogo.empresa')
    <h3 align="center"><B>CATALOGO DE VENTAS</B></h3> 


  </div>
  			@foreach($datos as $det)
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12" >
                    <div class="form-group" align="center">
						<label for="proveedor" align="center">COD#{{$det->codigo}}</label> </br>
					    <label for="proveedor"> {{$det->nombre}} </label></br>
							<label for="proveedor"><u> {{$det->precio1}} $ </u></label></br>
					    <label for="proveedor"> <?php if ($det->imagen==""){?> <img src="{{ asset('/imagenes/articulos/ninguna.jpg')}}" alt="{{$det->nombre}}" height="100px" width="100px" class="img-circle sombra"><?php }else{ ?><img src="{{ asset('/imagenes/articulos/'.$det->imagen)}}" alt="{{$det->nombre}}" height="250px" width="250px" class="img-circle bordeimagen"><?php } ?> </label></br>
					
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