@extends ('layouts.admin')
@section ('contenido')
<?php
echo $fserver=date('Y-m-d');
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
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<p>
				SysVent@s es un sistema desarrollado por la empresa CORPORACION DE SISTEMAS NKS, con el fin de brindar una </br>
				herramienta para el control de entrada y salida de inventario de tu negocio.	</p>
			</br><p>
				<span> fecha de inicio de servicio 00 </span>{{$empresa -> fechasistema}}

		</p>
		
		</div>
	</div>
@endsection