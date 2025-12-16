@extends ('layouts.admin')
@section ('reporte')
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <h3 align="center">DETALLE DE {{$detalle}}:  {{$banco->nombre}}</h3> 

      <table id="ing" class="table table-striped table-bordered table-condensed table-hover">
        <thead >
          <th>Fecha</th>
          <th>N&uacute;mero</th>
          <th>Concepto</th>
          <th>Beneficiario</th>
          <th>Tipo</th>
          <th>Monto</th>
          <th>Usuario</th>
        </thead>
        <TBODY>
        <?php $tcompras=0; ?>
               @foreach ($movimiento as $q)
               <?php  $tcompras=($tcompras+$q->monto);?>
        <tr> 
          <td><?php  echo $fecha=date_format(date_create($q->fecha_mov),'d-m-Y h:i:s');?></td>
         <td>  <a href="/caja/recibo/{{$q->id_mov}}_{{$q->tipo_per}}_{{$banco->idmoneda}}"> <strong>{{ $q->numero}}</strong></a></td>
          <td>{{ $q->concepto}}</td>
          <td>{{ $q->nombre}}</td>
          <td>{{ $q->tipo_mov}}</td>
          <td>{{ $q->monto }}</td>  
          <td>{{ $q->user}}</td>
        </tr> @endforeach
 
      </TBODY>
      <TFOOT>
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
  <label>Usuario: </label><span> {{ Auth::user()->name }}</span>  </br> 
    <a ><button class="btn  pull-right" id="imprimir">Imprimir</button></a>
          <a href="/caja/caja/{{$banco->idmoneda}}" id="regresar"><button class="btn  pull-left" >Regresar</button></a> 

           

                  
                </div>

         
  
 
         @push ('scripts')
<script>
$(document).ready(function(){
   $('#ing').DataTable({ 
"pageLength": -1,
"order":[[0, "desc"]]

    }); 
    $('#imprimir').click(function(){
  //  alert ('si');
  document.getElementById('imprimir').style.display="none";
  window.print(); 
  window.location="/caja/caja/<?php echo $banco->idmoneda;?>";
    });

});

</script>

@endpush
@endsection