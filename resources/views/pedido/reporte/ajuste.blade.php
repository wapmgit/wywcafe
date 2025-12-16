@extends ('layouts.admin')
<?php $mostrar=0; ?>
<?php $acum=0;$tcobranza=0;$deb=0;$che=0;$tra=$tventas=$tingnd=0;$acumnc=0;
$cefe=0;?>
@section('reporte')                
<div class="row">
<div class="panel-body">
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            	 <div class="form-group">
            			<label >{{$empresa->nombre}}</label></br>
						<label >{{$empresa->rif}}</label></br>	
						<label >{{$empresa->direccion}}. Tel: {{$empresa->telefono}}</label>            			
            	 </div>  
	    </div>
			<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
		        <h3 align="center">AJUSTE PEDIDO</h3> 
					    </div>
  </div>
  
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
	    <table class="table table-striped table-bordered table-condensed table-hover">
      <thead style="background-color: #E6E6E6" >
	  <th id="campo">Cliente</th>
	  <th id="campo">Articulo</th>
	  <th>Cantidad Pedido</th>
		</thead>
         @foreach ($detalles as $cob)		 
        <tr>
		<td>{{$cob->nombre}}</td>
		<td>{{$cob->articulo}}</td>
		<td><a href="" data-target="#modaldevolu-{{$cob->iddetalle_venta}}" data-toggle="modal">{{$cob->cantidad}}</a></td>
        </tr>
		@include('pedido.reporte.modaldevolu')
		@endforeach   		
		   </table>
	  </div>       
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> 		       
                     <div class="col-lg-12 col-md-12 col-sm-6 col-xs-12">
					   <label>Usuario: </label>  {{ Auth::user()->name }}  
                    <div class="form-group" align="center">
                     <button type="button" id="imprimir" class="btn btn-primary" data-dismiss="modal">Imprimir</button> 
                    </div>
                </div>                  
</div><!-- /.box-body -->
</div><!-- /.box -->
             

@push ('scripts')
<script>
$(document).ready(function(){
    $('#imprimir').click(function(){
  //  alert ('si');
  document.getElementById('imprimir').style.display="none";
  window.print(); 
  window.location="../reportes/cobranza";
    });

});

</script>

@endpush
@endsection