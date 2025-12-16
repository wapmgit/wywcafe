@extends ('layouts.admin')
@section ('contenido')
<?php $idret=explode("-",$retencion->fecha); 
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
@if($retencion->afiva==1)
<div class="row">
  <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
  <table>
  <tr><td width="20%"><img src="{{asset('dist/img/logoempresa.jpg')}}" width="100" height="80" title="NKS"></td>
  <td><p><b>COMPROBANTE DE RETENCION DEL IMPUESTO AL VALOR AGREGADO</b></br>
 <small> (Ley de IVA-Art. 11  La administracion tributaria podra designar como responsables</br>
  del pago de impuesto, en calidad de retencion a quienes por sus funciones publicas</br>
  o por razon de sus actrividades privadas intervengan en operaciones gravadas con</br>
  el impuesto establecido en este Decreto con Rango, Valor y fuerza de Ley.</br>
  Providencia Administrativa N° SNAT/2015/0049 DEL 10/08/2015</small></br></p></td></tr>
  </table>
   </div>
     <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4" align="right">
	  <table border="1" width="70%">
  <tr><td align="center"><b>N° Comprobante</b></td><td align="center"><b>Fecha</b></td></tr>
  <tr><td align="center"><?php echo $idret[0].$idret[1].add_ceros($retencion->correlativo,$ceros); ?></td><td align="center"><?php echo date("d/m/Y",strtotime($retencion->fecha)); ?></td></tr></table>
	 <?php if($retencion->anulada==1){ echo " *ANULADA*";} ?></div>
	   <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
  <table width="100%" border="1">
  <tr><td align="center"><b>Nombre o razon del Agente de Retencion</b></td><td align="center"><b>Registro de Informacion Fiscal del Agente de Retencion</b></td></tr>
  <tr><td align="center">{{$empresa->nombre}}</td><td align="center">{{$empresa->rif}}</td></tr>
  </table>	 </br>
  <table width="100%" border="1">
  <tr><td align="center" width="50%"><b>Direccion Fiscal del Agente de Retencion</b></td><td align="center" colspan="4"><b>Periodo Fiscal</b></td></tr>
  <tr><td align="center">{{$empresa->direccion}}</td><td align="center">AÑO:</td><td align="center"><?php echo $idret[0]; ?></td><td align="center">MES:</td><td align="center"><?php echo $idret[1]; ?></td></tr>
  </table> </br>
  <table width="100%" border="1">
  <tr><td align="center" width="50%"><b>Nombre o Razon Social del Sujeto Retenido</b></td><td align="center"><b>Registro de Informacion Fiscal del Sujeto Retenido</b></td></tr>
  <tr><td align="center">{{$retencion->nombre}}</td><td align="center">{{$retencion->rif}}</td></tr>
  </table>   
	  </div>
	  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
	    <table width="100%" border="1">
  <tr>
  <td align="center"><small>Oper.Nro.</small></td>
  <td align="center"><small>Fecha del documento</small></td>
  <td align="center"><small>Numero de control de Documento</small></td>
  <td align="center"><small>Numero de Factura</small></td>
  <td align="center"><small>Numero de N/D</small></td>
  <td align="center"><small>Numero de N/C</small></td>
  <td align="center"><small>Tipo de Transaccion</small></td>
  <td align="center"><small>Monto total con IVA</small></td>
  <td align="center"><small>Monto Exento</small></td>
  <td align="center"><small>Base Imponible</small></td>
  <td align="center"><small>% I.V.A.</small></td>
  <td align="center"><small>Monto I.V.A</small></td>
  <td align="center"><small>% I.V.A a Retener</small></td>
  <td align="center"><small>I.V.A Retenido</small></td>
  </tr>
  <tr><td>1</td>
  <td><?php echo date("d/m/Y",strtotime($retencion->fecha_hora)); ?></td>
  <td>{{$retencion->num_comprobante}}</td>
  <td>{{$retencion->serie_comprobante}}</td>
  <td></td>
  <td></td>
  <td>01</td>
  <td><?php echo number_format($retencion->mfac, 2,',','.'); ?> </td>
  <td><?php echo number_format($retencion->mexento, 2,',','.'); ?> </td>
  <td><?php echo number_format($retencion->mbase, 2,',','.'); ?> </td>
  <td>16</td>
    <td><?php echo number_format($retencion->montoiva, 2,',','.'); ?> </td>
  <td>{{$retencion->ret}}</td>
    <td><?php echo number_format($retencion->mret, 2,',','.'); ?> </td>
  </tr>
  <tr><td colspan="13" align="right">TOTAL A PAGAR: </td><td><?php echo number_format($retencion->mret, 2,',','.'); ?> </td></tr>
  </table>
	  </div>
	   <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
	  <p>Este comprobante se emite en funcion a lo establecido en el Articulo 16 de la Providencia N° SNAT/2015/0049 de fecha 10/08/2015</p>
		</br></div>
	   <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
	  <table width="100%">
	  <tr>
	  <td align="center"><img src="{{asset('dist/img/firmasellocreciven.png')}}" width="200" height="100" title="NKS"></td>
	  <td align="center"></td>
	  </tr>
	  <tr>
	  	  <td align="center">Firma de Agente de Retencion</td>
	  <td align="center">Fecha de Recibido Y Firma del Receptor</td></tr>
	  <tr style="line-height:300%"><td>&nbsp;</td><td>&nbsp;</td></tr>
	  	  <tr >
	  <td align="center">___________________</td>
	  <td align="center">___________________</td>
	  </tr>
	    <tr>
	  	  <td align="center">Fecha de Entrega</td>
	  <td align="center">Fecha de Recepcion</td></tr>
	  </table>
		</div>		
 <div class="col-lg-12 col-md-12 col-sm-6 col-xs-12">
        <div class="form-group" align="center">
        <button type="button" id="imprimir" class="btn btn-primary" data-dismiss="modal">Imprimir</button>
        </div>
  </div>
  </div> @endif
  @if($retencion->afiva==0)
<div class="row">
  <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
<img src="{{asset('dist/img/logoempresa.jpg')}}" width="100" height="80" title="NKS">
   </div>
  <div class="col-lg-10 col-md-10 col-sm-10 col-xs-10">

  <h3 align="center">{{$empresa->nombre}}</h3>
  <h3 align="center">{{$empresa->rif}}<?php if($retencion->anulada==1){ echo " *ANULADA*";} ?></h3>
  <h4 align="center">{{$empresa->direccion}} </h4>
   </div>
	   <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
  <table width="100%" border="1">
  <tr><td align="center"><b>Nombre o razon del Sujeto Retenido</b></td><td align="center"><b>Rif. Sujeto Retenido</b></td><td><b>Fecha de Emision</b></td></tr>
  <tr><td align="center">{{$retencion->nombre}}</td><td align="center">{{$retencion->rif}}</td><td align="center"><?php echo date("d/m/Y",strtotime($retencion->fecha_hora)); ?></td></tr>
  </table>	 </br> 
	  </div>
	  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
	    <table width="100%" border="1">
  <tr>
  <td align="center"><small>Codigo de la Retencion</small></td>
  <td align="center"><small>Fecha del documento</small></td>
  <td align="center"><small>Concepto de la Retencion</small></td>
  <td align="center"><small>Numero de Factura/ N/D</small></td>
  <td align="center"><small>Numero de Control</small></td>
  <td align="center">&nbsp; </td>
  <td align="center"><small>Monto Pagado o Abonado en Cuenta</small></td>
  <td align="center"><small>Monto Sujeto a Retencion</small></td>
  <td align="center"><small>% Retencion</small></td>
  <td align="center"><small>Sustraendo</small></td>
  <td align="center"><small>Monto Retenido</small></td>
  </tr>
  <tr><td>{{$retencion->codtrib}}</td>
  <td><?php echo date("d/m/Y",strtotime($retencion->fecha)); ?></td>
  <td><small>{{$retencion->descrip}}</small></td>
  <td>{{$retencion->documento}}</td>
  <td>{{$retencion->serie_comprobante}}</td>
  <td>&nbsp; </td>    
  <td>{{$retencion->mfac}}</td>
  <td>{{$retencion->mbase}}</td>
  <td>{{$retencion->ret}} %</td>
  <td>{{$retencion->sustraend}}</td>  
  <td>{{$retencion->mret}}</td>
  </tr>
  <tr><td colspan="10" align="right">TOTAL RETENCIÓN: </td><td>{{$retencion->mret}}</td></tr>
  </table>
	  </div>
	   <div class="col-lg-6 col-md-6 col-sm-12 col-xs-6">
	  <table width="100%">
	    <tr style="line-height:300%"><td>&nbsp;</td></tr>
	  <tr>
	  <td align="center"><img src="{{asset('dist/img/firmasellocreciven.png')}}" width="200" height="100" title="NKS"></td>

	  </tr>
	  <tr>
	  	  <td align="center">Firma y sello del Agente de Retencion</td></tr>
	  </table></br>
		</div>		
 <div class="col-lg-12 col-md-12 col-sm-6 col-xs-12">
        <div class="form-group" align="center">
        <button type="button" id="imprimir2" class="btn btn-primary" data-dismiss="modal">Imprimir</button>
        </div>
  </div>
  </div> @endif
  @push ('scripts')
<script>
$(document).ready(function(){
    $('#imprimir').click(function(){
  //  alert ('si');
  document.getElementById('imprimir').style.display="none";
  window.print(); 
  window.location="/cxp/listaretenciones";
    });
	    $('#imprimir2').click(function(){
  //  alert ('si');
  document.getElementById('imprimir').style.display="none";
  window.print(); 
  window.location="/cxp/listaretenciones";
    });

});

</script>

@endpush   
@endsection