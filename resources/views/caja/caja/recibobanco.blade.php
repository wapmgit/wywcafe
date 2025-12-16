@extends ('layouts.admin')
<?php $mostrar=0; ?>
  @if(Auth::user()->nivel=="1")
@section ('contenido')
<?php $mostrar=1; ?>

@endsection
@endif
<?php $acum=0;$efe=0;$deb=0;$che=0;$tra=0;
$cefe=0;?>
@section('reporte')

<?php if($movimiento->tipo_mov == "N/D"){ ?> 
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

 @include('reportes.compras.empresa')
    <h3 align="center">COMPROBANTE DE EGRESO </h3>
<label ></label>
      <table width="80%" align="center" border="0">         
        <tr><td>Numero: <strong>{{$movimiento->numero }}</strong></td><td colspan="2" align="right">Fecha: <?php  echo "<strong>".$fecha=date_format(date_create($movimiento->fecha_mov),'d-m-Y h:i:s')."</strong>";?></td></tr>
        <tr><td>He Recibido de</td><td colspan="2">{{ $empresa->nombre }} </td></tr>
        <tr><td>la cantidad de</td><td colspan="2"><strong><?php   echo number_format($movimiento->monto, 3,',','.'); ?> {{$caja->simbolo}}</strong></td></tr>
         <tr><td>por concepto de</td><td colspan="2">{{ $movimiento->concepto }}</td></tr>
          <tr><td>Beneficiario</td><td colspan="2"><strong>CI:{{ $movimiento->cedula }}, {{$movimiento->nombre}}</strong></td></tr>

       </table>
         <table width="80%" align="center">
          <tr height="80px"><td align="center"></td><td align="center"></td></tr>
<tr height="80px"><td align="center"><strong>{{ $movimiento->user }}</strong></td><td align="center">recibi conforme</td></tr>
 </table> </div>

<?php } ?>
<?php if($movimiento->tipo_mov == "N/C"){ ?> 
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

 @include('reportes.compras.empresa')
    <h3 align="center">COMPROBANTE DE INGRESO</h3>
<label ></label>
      <table width="80%" align="center" border="0">         
        <tr><td>Numero: <strong>{{$movimiento->numero }}</strong></td><td colspan="2" align="right">Fecha: <?php  echo "<strong>".$fecha=date_format(date_create($movimiento->fecha_mov),'d-m-Y h:i:s')."</strong>";?></td></tr>
        <tr><td>He Recibido de</td><td colspan="2">CI:{{ $movimiento->cedula }}, {{$movimiento->nombre}}</td></tr>
        <tr><td>la cantidad de</td><td colspan="2"><strong><?php   echo number_format($movimiento->monto, 3,',','.'); ?> $</strong></td></tr>
         <tr><td>por concepto de</td><td colspan="2">{{ $movimiento->concepto }}</td></tr>
          <tr><td>Beneficiario</td><td colspan="2"><strong>{{ $empresa->nombre }} </strong></td></tr>

       </table>
         <table width="80%" align="center">
          <tr height="80px"><td align="center"></td><td align="center"></td></tr>
<tr height="80px"><td align="center"><strong>{{ $movimiento->user }}</strong></td><td align="center">recibi conforme</td></tr>
 </table> </div>

<?php } ?>          
                     <div class="col-lg-12 col-md-12 col-sm-6 col-xs-12">
                    <div class="form-group" align="center">
					<a href="/caja/caja/<?php echo $movimiento->idcaja; ?>" id="regresar"><button class="btn  pull-left" >Regresar</button></a> 
                     <button type="button" id="imprimir" class="btn btn-primary" data-dismiss="modal">Imprimir</button>
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
  window.location="/caja/caja/<?php echo $movimiento->idcaja; ?>";
    });

});

</script>

@endpush
@endsection