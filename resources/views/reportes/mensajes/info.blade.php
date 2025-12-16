@extends ('layouts.admin')
@section ('contenido')
<?php
 $fserver=date('Y-m-d');
$fecha_a=$empresa -> fechasistema;
function dias_transcurridos($fecha_a,$fserver)
{
$dias = (strtotime($fecha_a)-strtotime($fserver))/86400;
//$dias = abs($dias); $dias = floor($dias);
return $dias;
}
$vencida=0;
if (dias_transcurridos($fecha_a,$fserver) < 0){
  $vencida=1;
  echo "<div class='alert alert-danger'>
      <H2>LICENCIA DE USO DE SOFTWARE VENCIDA!!!</H2> contacte su Tecnico de soporte.
      </div>";
};
?>
	<div class="row">
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
			<p>
				SysVent@s es un sistema desarrollado por la empresa W&W SISTEMAS, con el fin de brindar una </br>
				herramienta de ayuda para el control de entrada y salida de inventario en tu negocio.
				<span></br>Empresa:{{$empresa->rif}} - {{$empresa->nombre}}</span>
				<span></br>Telefono: {{$empresa->telefono}}<span>

			</p>
			<p>
				<span> fecha de inicio de servicio: </span>{{$empresa -> inicio}} </br>
				<span> fecha de vencimiento: </span>{{$empresa -> fechasistema}} </br>
				<span> Dias para vencer: </span><?php echo dias_transcurridos($fecha_a,$fserver); ?></br>
<span></br>Contacto Soporte: 04169067104- 04247163726<span>
		</p>
		
		</div>
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
			<p align="center">
		<img src="{{asset('dist/img/wsistemas.jpg')}}"  width="350" height="200" alt="User Image">
		</p>
		</div>
	</div>
@endsection