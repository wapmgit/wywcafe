@extends ('layouts.admin')
@section ('contenido')
<div class="row">
	<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
		<h3>Detalles de Tratamiento </h3>

	</div>
</div>

<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="table-responsive">
			<table class="table table-striped table-bordered table-condensed table-hover">
              
				<tr>
					<td><label>Id</label></td><td>{{ $tratamiento->id_tratamiento}}</td>
				</tr>
				<tr>	
					<td><label>Nombre</label></td><td>{{ $tratamiento->tratamiento}}</td>
				</tr>
				<tr>
					<td><label>Clase</label></td><td>{{ $tratamiento->clase}}</td>
				</tr>
				<tr>
					<td><label>Precio</label></td><td>{{ $tratamiento->precio_base}}</td>
				</tr>
					<tr>
					<td colspan="2"><a href="/tratamiento/precio/"><button class="btn btn-succes">Regresar</button></h3></a></td>
				</tr>
			</table>

		</div>
	</div>
</div>

@endsection