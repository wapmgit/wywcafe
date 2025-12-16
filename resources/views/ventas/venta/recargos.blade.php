@extends ('layouts.admin')
<?php $mostrar=0; ?>
  @if(Auth::user()->nivel=="A")
@section ('contenido')
<?php $mostrar=1; ?>
@endsection
@endif
<?php $acum=0;$efe=0;$deb=0;$che=0;$tra=0; $tingventas=0; $tingabono=0;
$cefe=0;
?>
@section('reporte')               
<div class="panel panel-primary">
<div class="panel-body">
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

    @include('reportes.ventas.empresa')
 <h4 align="center">Ventas Por Recargo</h4>  <p align="right"> 
    <div class="table-responsive">
    <table width="100%">
        <thead style="background-color: #E6E6E6">
          <th>N°</th>
          <th>Documento</th>
          <th>Cliente</th>
          <th>Fecha Emision</th>
		  <th>Dias Credito </th>
		  <th>Dias Mora </th>
          <th>Monto</th>
          <th>Monto N/D</th>
        </thead>
        <?php $count=$acum=$acums=0;?>
{!!Form::open(array('url'=>'ventas/addrecargo','method'=>'POST','autocomplete'=>'off','files'=>'true'))!!}
            {{Form::token()}}
               @foreach ($datos as $q)
               <?php $count++;			?> 
        <tr <?php if($mostrar==0){?> style="display:none" <?php } ?> >
          <td><small><?php echo $count; ?></small></td>
		   <td><small>{{ $q->tipo_comprobante}}{{$q->num_comprobante}}</small>
		   <input type="hidden" name="documento[]"   value="{{ $q->tipo_comprobante}}{{$q->num_comprobante}}" class="form-control" >
		   <input type="hidden" name="iddoc[]"   value="{{$q->num_comprobante}}" class="form-control" >
		   </td>
		   <td><small>{{ $q->nombre}}</small>
		   <input type="hidden" name="cliente[]"   value="{{ $q->id_cliente}}" class="form-control" ></td>
          <td><small> <?php echo date("d-m-Y",strtotime($q->fecha_emi)); ?> </small></td>
		   <td><small>{{ $q->diascre}}</small></td>
		   <td><small>{{ $q->dias-$q->diascre}}</small></td>    
		  <td><small><?php $acum=$acum+ $q->total_venta; echo number_format($q->total_venta, 2,',','.'); ?></small>
		  <input type="hidden" name="tventa[]"   value="{{ $q->total_venta}}" class="form-control" ></td>
		  <td><small><?php $acums=$acums+ ($q->total_venta*0.03); echo number_format(($q->total_venta*0.03), 2,',','.'); ?></small>
		  <input type="hidden" name="tnota[]"   value="{{ $q->total_venta*0.03}}" class="form-control" >
		  </td>
        </tr>      
        @endforeach
			
	      <tr >
        <td colspan="2"> <strong>TOTAL:</strong></td>
        <td colspan="2"> <strong>Items: <?php echo number_format($count, 2,',','.')." $"; ?></strong></td>
        <td colspan="2"> <strong>M. Fac: <?php echo number_format($acum, 2,',','.')." $"; ?></strong></td>
			<td colspan="2"><strong>M. N/D: <?php echo number_format($acums, 2,',','.')." $"; ?></strong></td>
          <td ></td>       
        </tr>
      </table>
</div>

  </div>
     <div class="col-lg-12 col-md-12 col-sm-6 col-xs-12">
                    <div class="form-group" align="center">
                     <button type="button" id="imprimir" class="btn btn-primary" data-dismiss="modal">Imprimir</button>
                    <button class="btn btn-primary" id="enviar" type="submit">Procesar</button>
					</div>
                </div>
    </div>	
	{!!Form::close()!!}
   <label>Usuario: {{ Auth::user()->name }}</label>       


  </div>
	         
@push ('scripts')
<script>
$(document).ready(function(){
    $('#imprimir').click(function(){
  //  alert ('si');
  document.getElementById('imprimir').style.display="none";
  document.getElementById('enviar').style.display="none";
  window.print(); 
  window.location="/ventas/recargo";
    });


});

</script>

@endpush
@endsection