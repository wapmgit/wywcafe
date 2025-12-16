@extends ('layouts.admin')
@section ('contenido')
<style type="text/css">
#global {
	height: 600px;
	width: 100%;
	border: 1px solid #ddd;
	background: #f1f1f1;
	overflow-y: scroll;
}
</style>
<div class="panel panel-primary">
<div class="panel-body">
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="table-responsive">
        <h4 align="center"><strong>KARDEX DE UN ARTICULO:</strong> {{$articulo->nombre}} -> Stock: {{$articulo->stock}}</h4>
<div id="global">
      <table class="table table-striped table-bordered table-condensed table-hover">
        <thead style="background-color: #E6E6E6">
					<th>Fecha</th>
					<th>Documento</th>
					<th>Entradas</th>
					<th>Salidas</th>
					<th>Stock</th>
			
					
				</thead><?php $stock=$articulo->stock; $comp=0; $vent=0; $de=0; $exis=0;$entra=0;$sale=0; $pago=0;?>
               @foreach ($datos as $compra)
				<tr>       <?php 
				$data=explode("-",$compra->documento);
				$doc=$data[0];			
				$iddoc=$data[1];					?>
				<td><?php  echo  $fecha=date_format(date_create($compra->fecha),'d-m-Y h:i:s');?></td>
				<td><?php  if($doc=="VENT"){ ?>
				<a href="/almacen/articulo/detallekardex/{{$iddoc}}_{{$articulo->idarticulo}}">{{$compra->documento}}</a>
				<?php }
				 if($doc=="AJUS"){ ?>
				<a href="/almacen/articulo/detallekardexajuste/{{$iddoc}}_{{$articulo->idarticulo}}">{{$compra->documento}}</a>
				<?php }else{ echo $compra->documento; } ?></td>
				<td> <?php  if($compra->tipo == 1){ $entra=$entra+ $compra->cantidad; ?>{{ $compra->cantidad}}<?php } ?></td>
				<td> <?php  if($compra->tipo == 2){ $sale=$sale+ $compra->cantidad;?>{{ $compra->cantidad}}<?php } ?></td>
				<td><?php $de=$entra-$sale; echo $de;?></td>
 @endforeach
				</tr>
				</table>
			<table class="table table-striped table-bordered table-condensed table-hover">
		<tr ><td colspan="5" align="center"><strong>Resumen</strong></td></tr> 
		<tr>
		<td>Entradas:<?Php echo $entra;?></td>
		<td>Salidas:<?Php echo $sale;?></td>		
		<td>Existencia:<?Php $exis=(($entra)-($sale)); echo number_format($exis, 2,',','.'); ?>
		@if ($exis != $articulo->stock)

	<a href="" data-target="#actstock-{{$articulo->idarticulo}}" data-toggle="modal"><i class="fa fa-fw fa-refresh"></i> </a>
	@endif</td>
		</tr>
		</table>
		</div>
       @include('almacen.articulo.modalactstock')    
         <a href="/almacen/articulo"><button class="btn  pull-right" id="imprimir">Imprimir</button></a>
          <a href="/almacen/articulo"><button class="btn  pull-left">Regresar</button></a>
  </div>
  </div>
  </div>


          
         @push ('scripts')
<script>
$(document).ready(function(){
    $('#imprimir').click(function(){
  document.getElementById('imprimir').style.display="none";
  window.print(); 
  window.location="../reportes/compras";
    });

});

</script>

@endpush
@endsection