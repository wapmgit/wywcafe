@extends ('layouts.admin')
@section ('contenido')
   @include('reportes.inventario.empresa')
<div class="row">
	<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
		<h3>Listado de Retenciones
		@include('proveedores.retenciones.search')
	</div>
</div>
           
<div class="row">
<div class="panel-body">
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
  <div class="table-responsive">
<table class="table table-striped table-bordered table-condensed table-hover">
							<thead style="background-color: #E6E6E6">
								<th>Proveedor</th>
								<th>Cedula/Rif</th>
								<th>Documento</th>
								<th>Monto Doc.</th>
								<th>N° retencion</th>
								<th>Mto.Ret. Bs</th>
								<th>Mto.Ret. $</th>
								<th>Opc.</th>
								
							</thead>
							<?php $total=0; $count=0; $tdoc=0;?>
						   @foreach ($proveedores as $cat)
						<?php if($cat->idingreso>0){$tdoc=0;}else{$tdoc=1;}?>
							<tr>
								<td><small>{{ $cat->nombre}}</small></td>
								<td>{{ $cat->rif}}</td>
								<td>{{ $cat->documento}}
								</td>
								<td><?php $count++; echo number_format( $cat->mfac, 2,',','.')." Bs"; ?></td>
								<td><?php if($cat->afiva==0){echo "islr ->";}else{echo "iva ->";}?> {{ $cat->correlativo}} 
								<a href="" data-target="#modaleditar{{$cat->idretencion}}_{{$cat->afiva}}" data-toggle="modal" ><i class="fa fa-edit" title="Editar Registro"></i></a>
								</td>
								<td>{{ $cat->mret}}</td>
								<td>{{ $cat->mretd}}</td>
								<td>
								<a href="/cxp/verretencion/{{$cat->idretencion}}_{{$tdoc}}"><button type="button" class="btn btn-primary btn-xs" data-dismiss="modal">Imprimir</button></a>
							<?php if($cat->anulada==0){?>	<a href="" data-target="#modal-delete-{{$cat->idretencion}}_{{$cat->afiva}}" data-toggle="modal"><button type="button" class="btn btn-danger btn-xs" data-dismiss="modal">Anular</button> </a></td>
							<?php }else{?><button type="button" class="btn btn-warning btn-xs" data-dismiss="modal">Anulada</button> <?php } ?>
							</tr>
							@include('proveedores.retenciones.modal')
							@include('proveedores.retenciones.modaledit')
							@endforeach
						</table>
</div>
{{$proveedores->render()}}
    </div>                  
</div><!-- /.box-body -->
</div><!-- /.box -->
             

@push ('scripts')
<script>
$(document).ready(function(){
    $('#imprimir').click(function(){
  //  alert ('si');
  document.getElementById('imprimir').style.display="none";
  window.print(); 
  window.location="../reportes/corte";
    });

});

</script>

@endpush
@endsection