@extends ('layouts.admin')
@section ('contenido')
<div class="row">
<div class="panel-body">
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    @include('pedido.descargados.empresa')
    <span ><?php $k=0;$acump=0;?>    </span>
  </div>
  
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
	    <table id="tablepedidos" class="table table-striped table-bordered table-condensed table-hover">
      <thead style="background-color: #E6E6E6" >
	  <th id="campo">Id</th>
	  <th>Cliente</th>
		<th>Monto Pedido</th>

		</thead>
		<tbody>
         @foreach ($datos3 as $cob)	 <?php $k++; ?>	 
        <tr>
		<td><a href="/recibir-pedidos">
		@if($rol->importarpedido==1)<a href="/pedido/bajar/{{$cob->id_pedido}}" onclick="return confirm('¿ Confirma descargar el pedido ?')"><i class="fa fa-fw fa-cloud-download"> </i></a>@endif
		{{$cob->id_pedido}} </td>
		
		<td><?php echo $nombresc[$k-1];	?></td>
		<td>{{$cob->total_pedido}}</td>
        </tr>
		@endforeach  
		</tbody>
		<tfoot>
	  <th >Id</th>
	  <th>Cliente</th>
		<th>Monto Pedido</th>	
</tfoot>
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
	
	   $('#tablepedidos').DataTable({ 
"order":[[0, "desc"]]

    }); 
	
    $('#imprimir').click(function(){
  //  alert ('si');
  document.getElementById('imprimir').style.display="none";
  window.print(); 
  window.location="/pedido/pedido";
    });

});

</script>

@endpush
@endsection