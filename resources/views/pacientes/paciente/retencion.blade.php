@extends ('layouts.admin')
@section ('contenido')
<?php $idret=explode("-",$ret->fecha); 
$ceros=5;
function add_ceros($numero,$ceros) {
$digitos=strlen($numero);
  $recibo="";
  for ($i=0;$i<8-$digitos;$i++){
    $recibo=$recibo."0";
  }
return $insertar_ceros = $recibo.$numero;
};
?>
<div class="row">
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
  <table>
  <tr><td><p><b>COMPROBANTE DE RETENCION DEL IMPUESTO AL VALOR AGREGADO</b></br>
 <small> (Ley IVA-Art. 11:" Seran responsable del pago del impuesto en calidad ed agentes de  retencion, los compradores  </br>
o adquirientes de determinados bienes muebles y los receptores de ciertos servicios a quienes la Administracion Tributaria designe como tal"</br>
</small></br></p></td></tr>
  </table>
   </div>
   <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
	  <table border="1" width="100%">
  <tr><td align="center"><b>NRO Comprobante</b></td><td align="center"><b>Fecha</b></td><td align="center"><b>Periodo Fiscal</b></td></tr>
  <tr><td align="center"><?php echo $ret->comprobante ?></td><td align="center"><?php echo date("d/m/Y",strtotime($ret->fecha)); ?></td><td align="center"><?php echo "AÑO: ".$ret->periodo."     MES: ".$ret->mes; ?></td></tr></table>
	 </div>
	   <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
  <table width="100%" border="1">
  <tr><td align="center"><b>Nombre o razon del Agente de Retencion</b></td><td align="center"><b>Registro de Informacion Fiscal del Agente de Retencion</b></td></tr>
  <tr><td align="center">{{$ret->nombre}}</td><td align="center">{{$ret->cedula}}</td></tr>
    <tr><td align="center" colspan="2" ><b>Direccion Fiscal del Agente de Retencion</b></td></tr>
    <tr><td align="center" colspan="2" >{{$ret->direccion}}</td></tr>
  </table>	 </br>
  <table width="100%" border="1">
  <tr><td align="center" width="50%"><b>Nombre o Razon Social del Sujeto Retenido</b></td><td align="center"><b>Registro de Informacion Fiscal del Sujeto Retenido</b></td></tr>
  <tr><td align="center">{{$empresa->nombre}}</td><td align="center">{{$empresa->rif}}</td></tr>
  </table>   
	  </div>
	  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
	    <table width="100%" border="1">
  <tr>
  <td align="center"><small>Oper.Nro.</small></td>
  <td align="center"><small>Fecha de la Factura</small></td>
  <td align="center"><small>Numero de Factura</small></td>
  <td align="center"><small>Numero de control</small></td>
  <td align="center"><small>Numero de N/D</small></td>
  <td align="center"><small>Numero de N/C</small></td>
  <td align="center"><small>Tipo de Transaccion</small></td>
  <td align="center"><small>Total Compra incluyendo Impuesto</small></td>
  <td align="center"><small>Compra sin derecho a Credito Fiscal</small></td>
  <td align="center"><small>Base Imponible</small></td>
  <td align="center"><small>% Alicuota.</small></td>
  <td align="center"><small>Impuesto</small></td>
  <td align="center"><small>Impuesto Retenido</small></td>
  </tr>
  <tr><td>1</td>
  <td><?php echo date("d/m/Y",strtotime($ret->fecha_fac)); ?></td>
  <td>{{$ret->idventa}}</td>
  <td>{{$ret->nrocontrol}}</td>
  <td></td>
  <td></td>
  <td>01</td>
  <td>{{$ret->mfactura}}</td>
  <td>{{$ret->texe}}</td>
  <td>{{$ret->total_iva}}</td>
  <td>16</td>
  <td>{{$ret->impuesto}}</td>
  <td>{{$ret->mretbs}}</td>
  </tr>
  </table>
	  </div>
	   <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

	   <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
	  <table width="100%">
	  <tr>
	  <td align="center">Agente de Retencion:</td>
		<td align="center">Sujeto Rtenido:</td>
	  </tr>
	  <tr>  	
	  <td align="center">{{$ret->nombre}}</br>{{$ret->cedula}}</td>
	  <td align="center">{{$empresa->nombre}}</br>{{$empresa->rif}}</td>
	  </tr>
	  </table>
		</div>		
 <div class="col-lg-12 col-md-12 col-sm-6 col-xs-12">
        <div class="form-group" align="center">
        <button type="button" id="imprimir" class="btn btn-primary" data-dismiss="modal">Imprimir</button>
        </div>
  </div>
  </div>

  <hr/>

	
@endsection
@push ('scripts')
<script>

$(document).ready(function(){
    $('#imprimir').click(function(){
  document.getElementById('imprimir').style.display="none";
    document.getElementById('regresarpg').style.display="none";
  window.print(); 
   window.location="/pacientes/paciente/<?php echo $ret->idcliente;?>";
    });
	    $('#regresarpg').click(function(){
   window.location="/pacientes/paciente/<?php echo $ret->idcliente;?>";
    });

});

</script>

@endpush