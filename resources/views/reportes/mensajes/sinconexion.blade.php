@extends ('layouts.admin')
@section ('contenido')
	<div class="row">
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
			<p  align="center">
				<b>Los datos no fueron enviados</b>, detectado problema de conexion </br>
			vuelva a repetir la sincronizacion.

			</p>
		
			<p  align="center">
		<img src="{{asset('dist/img/sinconexion.jpg')}}"  width="200" height="200" alt="User Image">
			</p>
			<p align="center"><a href="<?php echo $link; ?>"><button class="btn btn-success"> Volver</button></a></p>
			<p>
			<span></br>Contacto Soporte: 04169067104- 04247163726<span>
			</p>
		
		</div>
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
			<p align="center">
		<img src="{{asset('dist/img/nks.jpg')}}"  width="350" height="200" alt="User Image">
		</p>
		</div>
	</div>
@endsection