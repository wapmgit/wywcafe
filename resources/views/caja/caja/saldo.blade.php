@extends ('layouts.admin')
@section ('contenido')
<?php $mingreso=$megreso=0; $bc=0;?>
<?php
$corteHoy = date("d-m-Y");
$ceros=5;
function add_ceros($numero,$ceros,$bco) {
  $numero=$numero+1;
$digitos=strlen($numero);
  $recibo=" ";
  for ($i=0;$i<8-$digitos;$i++){
    $recibo=$recibo."0";
  }
return $insertar_ceros = $bco.$recibo.$numero;
};
$idv=0;

?> 

<div class="row">             
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" align="center">
<h3>MODULO DE CAJA</h3>
<h5><?php echo $corteHoy; ?></h5>
<table  border="1" width="80%">
  <thead><th>Credito</th><th>Debito</th><th>Saldo</th></thead>
    @foreach ($monedas as $m) <?php $mingreso=$megreso=0; ?>
	<tr style="background-color: #E6E6E6">
  
    <td colspan="3" align="center"><label> {{$m->nombre}}</label> </td>

</tr>
<tr> 
<td>@foreach ($movimiento as $mov)<?php
     if ($m->idmoneda == $mov->idcaja) {
		$mingreso=$mingreso+$mov->tmonto; } ?>	 @endforeach 
<?php echo number_format($mingreso,2,'.',','); ?> {{$m->simbolo}}</td>
<td>@foreach ($debito as $mv)<?php
     if ($m->idmoneda == $mv->idcaja) {
		$megreso=$megreso+$mv->tmonto; } ?>	 @endforeach 
<?php echo number_format($megreso,2,'.',','); ?> {{$m->simbolo}}</td>
<td><?php echo number_format(($mingreso-$megreso),2,'.',','); ?> {{$m->simbolo}}</td>     </tr> 
       

                     
@endforeach
</table>
</div>
                     <div class="col-lg-12 col-md-12 col-sm-6 col-xs-12">
					   <label>Usuario: </label>  {{ Auth::user()->name }}  
                    <div class="form-group" align="center">
                     <button type="button" id="imprimir" class="btn btn-primary" data-dismiss="modal">Imprimir</button> 
                    </div>
                </div>
</div>
@push ('scripts')
<script>
$(document).ready(function(){
    $('#imprimir').click(function(){
  //  alert ('si');
  document.getElementById('imprimir').style.display="none";
  window.print(); 
  window.location="/caja/saldo";
    });

});

</script>

@endpush
@endsection
