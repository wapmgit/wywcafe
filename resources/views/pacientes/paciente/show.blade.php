@extends ('layouts.admin')
@section ('contenido')
<style type="text/css">
#capa{
	height: 500px;
	width: 100%;
	border: 1px solid #ddd;
	background: #f1f1f1;
	overflow-y: scroll;
}
</style>
<div class="row"><?php $acummonto=0; ?>

	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<h3>Estado de Cuenta del Cliente</h3>
	</div> 
	<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                 <div class="form-group">
                      <label for="direccion">Cliente:</label> {{$cliente->nombre}}            
                    </div>
    </div>
	<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                 <div class="form-group">
                      <label for="direccion">Cedula:</label> {{$cliente->cedula}} <label for="direccion">Telefono:</label> {{$cliente->telefono}}
                    </div>
    </div>
	<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                 <div class="form-group">
                       <label for="direccion">Vendedor:</label> {{$cliente->vendedor}}
                    </div>
    </div>
	<div class="col-lg-8 col-md-8 col-sm-8 col-xs-4">
                 <div class="form-group">
                      <label for="direccion">Direccion:</label> {{$cliente->direccion}}
                    </div>
    </div>
			<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4" id="divbotones">
                 <div class="form-group">
				<a href="href="" data-target="#modaldebito-{{$cliente->id_cliente}}" data-toggle="modal"><button class="btn btn-warning">N. Debito</button></a>
			
					<a href="href="" data-target="#modalcredito-{{$cliente->id_cliente}}" data-toggle="modal"><button class="btn btn-primary">N. Credito</button></a>
					<a href="{{URL::action('CxcobrarController@show',$cliente->id_cliente)}}"><button class="btn btn-info">Abono</button></a>
                    <a href="href="" data-target="#modalrecibos-{{$cliente->id_cliente}}" data-toggle="modal"><button class="btn">Recibos</button></a>
					</div>
			</div>

@include('pacientes.paciente.modalcredito')
@include('pacientes.paciente.modaldebito')
@include('pacientes.paciente.modalrecibos')
</div><?php $link=1;?>
<div class="row">@include('pacientes.paciente.modaldetalle')
@include('pacientes.paciente.modaldetallenc')
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="table-responsive">
		<div>
			<table width="100%">
				<thead>
					<th>Documento</th>
					<th>Ref.</th>
					<th>Fecha</th>
					<th>Condicion</th>
					<th>Monto Doc.</th>
					<th>Ret.</th>
					<th>Des. %</th>
					<th>Monto Des.</th>
					<th>Saldo</th>						
				</thead>
				<?php $vendido=0; $acum=0; $saldo=$saldond=$saldonc=0; $cont=$contnd=$contnc=0; ?>
               @foreach ($ventas as $cat) 
			   <?php if($cat->devolu==0){ $vendido=$vendido+$cat->total_venta;  $saldo=$saldo+$cat->saldo; }
			   $cont++; 
			   ?>
				<tr style="background-color: #E8F8F5">
					<td>            
			 <a  href="{{URL::action('CxcobrarController@edit',$cat->idventa.'-'.$link)}}">{{$cat->tipo_comprobante}}-{{ $cat->serie_comprobante}}-{{ $cat->idventa}}</a>	<?php if($cat->devolu==1){echo "*DEV";}?>  

		
					</td>
					<td></td>
					<td><?php echo date("d-m-Y h:i:s a",strtotime($cat->fecha_hora)); ?></td>
					<td>{{ $cat->estado}}</td>
					<td>{{ $cat->total_venta}}</td>
					<td>{{ $cat->mret}}</td>
					<td>{{ $cat->descuento}}</td>
					<td>{{ $cat->total_pagar}}</td>
					<td>{{ $cat->saldo}}</td>				
				</tr>
								@foreach($pagos as $p)
					<?php if($cat->idventa==$p->idventa){ ?>
					<tr style="line-height:90%"><td></td><td colspan="2"><small>------------> Recibo-{{$p->idrecibo}} -> <?php echo date("d-m-Y",strtotime($p->fecha)); ?></small></td>
					<td colspan="4"><small>{{$p->idbanco}}->{{$p->recibido}}->{{$p->monto}}$</small></td><td></td><td></td></tr>
					<?php } ?>
					@endforeach
				@endforeach
				@foreach ($notas as $not)
				<tr>
					<td> <?php if ($not->tipo==1){?>
						<a href="/paciente/notasadm/{{$not->idnota}}"> N/D - {{$not->idnota}}</a>
					<?php
						 $saldond=$saldond+$not->pendiente; $contnd++;  }else{?>
					<a href="/paciente/notasadm/{{$not->idnota}}"> N/C - {{$not->idnota}}</a> <?php 
						 $saldonc=$saldonc+$not->pendiente;  $contnc++; }?> </td>
					<td>{{ $not->referencia}}</td>
					<td><?php echo date("d-m-Y",strtotime($not->fecha)); ?></td>
					<td></td>
					<td>{{ $not->monto}}			
					</td>
					<td></td>
					<td></td>
					<td></td>
					<td>{{ $not->pendiente}}</td>				
				</tr>
				@endforeach
				@foreach ($retencion as $ret)
				<tr>
					<td>
						<a href="/paciente/retencion/{{$ret->idret}}"> RET- {{$ret->idret}}</a> </td>
					<td>Comp:{{ $ret->comprobante}} Fac:{{ $ret->idfactura}}</td>
					
					<td><?php echo date("d-m-Y",strtotime($ret->fecha)); ?></td>
					<td></td>
					<td>{{ $ret->mretd}}			
					</td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>				
				</tr>
				@endforeach
				<tr><td colspan="4"><strong>Facturas: <?php echo $cont. " -> N/D: ".$contnd." -> N/C: ".$contnc; ?></strong></td><td><strong>Facturado: <?php echo$vendido; ?> $.</strong></td><td colspan="2"></td><td><strong><?php echo (($saldo+$saldond)-$saldonc); ?> $.</strong></td></tr>
			</table>
			</div>
		</div>

	</div>
	     <div class="col-lg-12 col-md-12 col-sm-6 col-xs-12">
                    <div class="form-group" align="center">
                     <button type="button" id="imprimir" class="btn btn-primary" data-dismiss="modal">Imprimir</button>
					 <button type="button" id="regresar" class="btn btn-danger" data-dismiss="modal">Regresar</button>
                    </div>
                </div>  
{!!Form::model($ventas,['method'=>'post','route'=>['pacientes.paciente.update',$cliente->id_cliente],'id'=>'formulariodetalle','files'=>'true'])!!}
            {{Form::token()}}
    <input type="hidden" name="comprobante" id="pidcomprobante" value="0">
	 <input type="hidden" name="tipo" id="pidtipo" value="0">
      {!!Form::close()!!} 
</div>
@push ('scripts')
<script>
$(document).ready(function(){

    $('#ing').DataTable();	

    $('#imprimir').click(function(){

  document.getElementById('imprimir').style.display="none";
  document.getElementById('regresar').style.display="none";
  document.getElementById('divbotones').style.display="none";
  window.print(); 
  window.location="/pacientes/paciente/<?php echo $cliente->id_cliente;?>";
    });
	    $('#imprimire').click(function(){
  document.getElementById('imprimire').style.display="none";
  document.getElementById('cerrare').style.display="none";
		var printcontenido =document.getElementById('areaimprimir').innerHTML;
		var originalcontenido = document.body.innerHTML;
		document.body.innerHTML =printcontenido;
	  	window.print(); 
  window.location="/pacientes/paciente/<?php echo $cliente->id_cliente;?>";
    });

	$('#cheknc').on("click",function(){
		var miCheckbox = document.getElementById('cheknc');
			if (miCheckbox.checked) {
			document.getElementById('divmoneda').style.display="";
			} else {
			document.getElementById('divmoneda').style.display="none";
				document.getElementById('divmban').style.display="none";
	}
	});
	$('#pidpago').on("change",function(){
  dato=document.getElementById('pidpago').value.split('_');
	if(dato[0]>0){
			document.getElementById('divmban').style.display="";
	}else{
		document.getElementById('divmban').style.display="none";
	}
});
$('#regresar').on("click",function(){
  window.location="/pacientes/cobrar/<?php echo $cliente->id_cliente;?>";
  
});
$('#btndedito').on("click",function(){
  document.getElementById('btndedito').style.display="none"; 
});
$('#btncredito').on("click",function(){
  document.getElementById('btncredito').style.display="none"; 
});
$('#btn-cerrar').on("click",function(){
  for (var m=0;m<10;m++){
  $("#fila" + m).remove(); }
});


});

</script>
@endpush
@endsection