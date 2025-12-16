@extends ('layouts.admin')
<?php $mostrar=0; ?>
  @if(Auth::user()->nivel=="A")
@section ('contenido')
<?php $mostrar=1; ?>
<div class="row" id="search" style="display: true">
	<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
		<h3>Seleccione Vendedor para la consulta</h3>
		@include('pedido.reporte.search')
	</div>
</div>

@endsection
@endif
<?php $acum=0;$tcobranza=0;$deb=0;$che=0;$tra=$tventas=$tingnd=0;$acumnc=0;
$cefe=0;?>
@section('reporte')
<div class="row">
            <div class="col-md-12">
              <div class="box">
                <div class="box-header with-border">
                  <h3 class="box-title">Sistema de Ventas SysVent@s</h3>
                  <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    
                    <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                  </div>
                </div>
              </div>
            </div>
</div>
                  

<div class="row">
<div class="panel-body">
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    @include('pedido.reporte.empresa')
    <span ><strong>Vendedor -></strong> <?php echo $searchText; $acump=0;?>    </span>
  </div>
  
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
	    <table class="table table-striped table-bordered table-condensed table-hover">
      <thead style="background-color: #E6E6E6" >
	  <th id="campo">Articulo</th>
	  <th>Cantidad Pedido</th>
		<th>Stock</th>

		</thead>
         @foreach ($ventas as $cob)	 <?php $acump=$acump+$cob->cantidad; ?>	 
        <tr>
		<td>{{$cob->articulo}}</td>
		<td><?php  if($valida==1){?> <a href="/pedido/pedido/ajuste/{{$cob->idarticulo}}_{{$cob->vendedor}}"><button class="btn btn-success">{{$cob->cantidad}}</button></a></td>
		<?php } else { ?> {{$cob->cantidad}} <?php } ?>
		<td>{{$cob->stock}}</td>
        </tr>
		@endforeach  
<tr><td>Total Unidades </td><td><?php echo $acump; ?></td><td></td></tr> 		
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
  window.location="/pedido/reporte/reporte";
    });

});

</script>

@endpush
@endsection