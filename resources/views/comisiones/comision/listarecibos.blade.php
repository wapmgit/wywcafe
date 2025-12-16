@extends ('layouts.admin')
@section ('contenido')

<div class="panel panel-primary">
<div class="panel-body">
 @include('reportes.cobranza.empresa') 
 <h4 align="center">REPORTE DE RECIBOS EMITIDOS</h4>
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
  <tr><td><strong>Comision: </strong> {{$comision->id_comision}}</td>
  <td><strong>Vendedor: </strong>{{$comision->cedula}} - {{$comision->nombre}}</td>
  <td><strong>Monto Ventas: </strong>{{$comision->montoventas}}</td>
  <td><strong>Monto Comision: </strong>{{$comision->montocomision}}</td>
  <td><strong>Fecha Comision: </strong><?php echo date("d-m-Y",strtotime($comision->fecha)); ?></td>
  </tr>
  </div>
 <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="table-responsive">     
      <table class="table table-striped table-bordered table-condensed table-hover">
        <thead style="background-color: #A9D0F5">
					<th>#Recibo</th>
					<th>Fecha</th>
					<th>Recibido</th>
					<th>Monto $.</th>
					<th>Referencia</th>
					<th>Observacion</th>
					<th>Usuario</th>			
				</thead><?php $count=0; $acum=0; ?>
               @foreach ($lista as $q)
				<tr> <?php $count++; $acum=$acum+$q->monto;
         ?> 
					<td>{{ $q->id_recibo}}</td>
					<td><?php echo date("d-m-Y",strtotime($q->fecha)); ?></td>
					<td>{{ $q->recibido}} {{ $q->simbolo}}</td>
					<td>{{ $q->monto}}</td>
					<td>{{ $q->referencia}}</td>
					<td>{{ $q->observacion}}</td>
					<td>{{$q->user}}</td>
				</tr>

				@endforeach
        <tr style="background-color: #A9D0F5"><td><?php echo "<strong>Total:".$count."</strong>"; ?></td><td></td><td></td><td><?php echo "<strong>".number_format( $acum, 3,',','.')." $</strong>";  ?></td><td></td><td></td><td></td></tr>
			</table>
      
		</div>
  
  </div>
  <div class="col-lg-12 col-md-12 col-sm-6 col-xs-12">
                    <div class="form-group" align="center">
                     <button type="button" id="imprimir" class="btn btn-primary" data-dismiss="modal">Imprimir</button>
					<input type="hidden" id="enlace" value="<?php echo $link; ?>"/>
					 <button type="button" id="regresar" class="btn btn-danger" data-dismiss="modal">Regresar</button>
                    </div>
                </div>

  </div>
  </div>


      @push ('scripts')
<script>
$(document).ready(function(){
    $('#imprimir').on("click",function(){
  //  alert ('si');
  document.getElementById('imprimir').style.display="none";
  document.getElementById('regresar').style.display="none";
  window.print(); 
  window.location="/comisiones/comision/pendiente/";
    });
$('#regresar').on("click",function(){
	var enlace=$("#enlace").val();
	if(enlace=="B"){
  window.location="/comisiones/comision/pagadas/";
	}else{
  window.location="/comisiones/comision/pendiente/";		
	}
});
});
</script>

@endpush   
@endsection