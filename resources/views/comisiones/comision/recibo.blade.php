@extends ('layouts.admin')
@section ('contenido')
@include('pacientes.paciente.empresa')
		<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<h3 align="center">RECIBO DE PAGO</h3>            
		</div>
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div align="center">
		<table widht="100%" border="0">
		<tr><td>
        </td>
		<td></td>
		</tr>
		<tr><td colspan="2"> <b>Recibi de: </b> {{$empresa->rif}}, {{$empresa->nombre}}</td><tr>
		<tr><td>Recibido</td><td>$</td><td>Referencia</td></tr>
		@foreach($datos as $dat)
		<tr><td>{{$dat->recibido}} {{$dat->simbolo}}</td><td>{{$dat->monto}}</td><td>{{$dat->referencia}}</td></tr>
		@endforeach
		<tr><td colspan="2"> <b>Por Concepto de:</b> comision N° {{$dat->id_comision}}, de fecha <?Php echo date("d/m/Y",strtotime($dat->fechacomision)); ?>, por un monto de {{$dat->montocomision}} $<tr>
		<tr><td colspan="2"><b>Emitido por:</b> {{$dat->user}} </td><tr>
		<tr><td colspan="2"><b>Fecha:</b> <?Php echo date("d/m/Y",strtotime($dat->fecha)); ?></td><tr>
		<tr><td colspan="2"></br> </td><tr>
		<tr><td colspan="2"> </td><tr>
		<tr><td colspan="2" align="center">{{$dat->cedula}}-{{$dat->nombre}}</br>Recibi de Conformidad <tr>
		<tr><td colspan="2"></br> </td><tr>
		<tr><td colspan="2" align="center"> ________________________<tr>
		</table></div>
		<div class="col-lg-12 col-md-12 col-sm-6 col-xs-12">
                    <div class="form-group" align="center">
                     <button type="button" id="imprimir" class="btn btn-primary" data-dismiss="modal">Imprimir</button>
                    </div>
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
  window.location="/comisiones/comision/pendiente/";
    });

});

</script>

@endpush
@endsection