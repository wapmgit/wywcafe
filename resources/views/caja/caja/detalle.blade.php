@extends ('layouts.admin')

@section ('contenido')
<div class="row">
 <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
 <?php $ban=$banco->idcaja; ?>

 @include('caja.caja.searchmd')
 </div>
 </div>
 @endsection
 @section('reporte')
<div class="row">
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <h3 align="center">DETALLE DE MOVIMIENTOS BANCARIOS {{$banco->nombre}}</h3> 

      <table id="ing" class="table table-striped table-bordered table-condensed table-hover">
        <thead >
        <th width="3%">#mov</th>
          <th width="15%">Fecha</th>
					<th width="15%">N&uacute;mero</th>
					<th>Concepto</th>
					<th width="25%">Beneficiario</th>
          <th>Tipo</th>
          <th>Monto</th>
          <th>Usuario</th>
				</thead>
        <TBODY>
        <?php $tcompras=0; ?>
               @foreach ($movimiento as $q)
               <?php  $tcompras=($tcompras+$q->monto);?>
				<tr> 
	       <td><small>{{ $q->id_mov}}</small></td> 
          <td><small><?php  echo $fecha=date_format(date_create($q->fecha_mov),'d-m-Y h:i:s');?></small></td>
          <td> <small> <a href="/caja/recibo/{{$q->id_mov}}_{{$q->tipo_per}}_{{$banco->idcaja}}"> <strong>{{ $q->numero}}</strong></a></small></td>
					<td><small>{{ $q->concepto}}</small></td>
					<td><small>{{ $q->nombre}}</small></td>
          <td><small>{{ $q->tipo_mov}}</small></td>
          <td><small><?php echo $q->monto; ?></small></td>	
          <td><small>{{  $q->user}}</small></td>
				</tr> @endforeach
 
			</TBODY>
      <TFOOT>
           <th>#mov</th>
         <th>Fecha</th>
          <th>N&uacute;mero</th>
          <th>Concepto</th>
          <th>Beneficiario</th>
            <th>Tipo</th>
          <th>Monto</th>
          <th>Usuario</th>
      </TFOOT>
			</table>

  </div>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
  <label>Usuario: </label><span> {{ Auth::user()->name }}</span>  </br> 
    <a ><button class="btn  pull-right" id="imprimir">Imprimir</button></a>
          <a href="/caja/caja/<?php echo $banco->idcaja; ?>" id="regresar"><button class="btn  pull-left" >Regresar</button></a> 
		  </div>
 </div>
         @push ('scripts')
<script>
$(document).ready(function(){
   $('#ing').DataTable({ 
"order":[[0, "desc"]]

    }); 
    $('#imprimir').click(function(){
  //  alert ('si');
  document.getElementById('imprimir').style.display="none";
  document.getElementById('search').style.display="none";
  window.print(); 
  window.location="/caja/caja";
    });

});

</script>

@endpush
@endsection