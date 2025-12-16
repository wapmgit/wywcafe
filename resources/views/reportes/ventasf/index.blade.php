@extends ('layouts.admin')
<?php $mostrar=0; ?>
  @if(Auth::user()->nivel=="A")
@section ('contenido')
<?php $mostrar=1; ?>
<?php $acum=0; $idv=0;
$ceros=5;  $acumnc=0;
function add_ceros($numero,$ceros) {
  $numero=$numero;
$digitos=strlen($numero);
  $recibo=" ";
  for ($i=0;$i<8-$digitos;$i++){
    $recibo=$recibo."0";
  }
return $insertar_ceros = $recibo.$numero;
};
function truncar($numero, $digitos)
{
    $truncar = 10**$digitos;
    return intval($numero * $truncar) / $truncar;
}

?>
<div class="row" id="buscar" style="display: true">
	<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
		<h3>Indique la fecha para la consulta</h3>
		@include('reportes.ventasf.search')
	</div>
</div>

@endsection
@endif
<?php $acum=0;$efe=0;$deb=0;$che=0;$tra=0; $tv=$tiva=$texe=0;
$cefe=0;?>
@section('reporte')
<div class="row">
            <div class="col-md-12">
              <div class="box">
                <div class="box-header with-border">
                  <h3 class="box-title">Sistema de Ventas SysVent@s</h3>
                  <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    
                    <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                  </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body" style="background-color: #fff">
                  

<div class="panel panel-primary">
<div class="panel-body">
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

    @include('reportes.ventasf.empresa')
    <h3 align="center">REPORTE DE VENTAS FORMA LIBRE</h3> <p align="right">
    <span ><?php echo date("d-m-Y",strtotime($searchText)); ?> al <?php echo date("d-m-Y",strtotime($searchText2)); ?> </span></p>
    <div class="table-responsive">
    <table width="100%">
        <thead style="background-color: #E6E6E6">
          <th>Item </th>
		  <th>Cliente </th>
		  <th>Nro Factura </th>
		  <th>Fecha </th>
		  <th>Nro control </th>
          <th>Doc.</th>
          <th>Monto</th>
   
        </thead>
        <?php $mconiva= 0; $mfac=0; $acums=0; $cdeb=0; $credito=0; $contado=0; $count=0;?>

               @foreach ($datos as $q)
               <?php $count++; $credito=$credito + $q->saldo;
			if($q->formato==0){
				$mconiva=truncar(($q->total_iva*1.16),2);
				$mfac=$q->texe+$mconiva;
			}else{
					$mconiva=truncar(($q->mivaf*1.16),2);
				$mfac=$q->texe+$mconiva;
			}
                 
			   ?> 
        <tr <?php if($mostrar==0){?> style="display:none" <?php } ?> >
          <td><?php echo $count; ?></td>
		   <td><small><small>{{ $q->nombre}}</small></small></td>
		   <td><small><small><?php $idv=$q->idForma; echo add_ceros($idv,$ceros); ?></small></small></td>
		     <td><small><small><?php echo date("d-m-Y",strtotime($q->fecha_hora)); ?></small></small></td>
		   <td><small><small>{{ $q->nrocontrol}}<?php if($q->anulado==1){ echo " Anulada";} ?></small></small></td>
          <td><small>{{ $q->tipo_comprobante}}-{{ $q->num_comprobante}} <?php if ($q->devolu>0){ echo "- Devuelta";}?></small></td>       
		  	  <td><small><?php  echo number_format($mfac, 2,',','.')." Bs"; ?></small></td>

        </tr>
       
        @endforeach

      </table>
</div>
  </div>

  </div>


    </div>
  
  </div>
  </div>
  </div>
	          <label>Usuario: {{ Auth::user()->name }}</label>       

                  
                  		</div>
                  	</div><!-- /.row -->
                     <div class="col-lg-12 col-md-12 col-sm-6 col-xs-12">
                    <div class="form-group" align="center">
                     <button type="button" id="imprimir" class="btn btn-primary" data-dismiss="modal">Imprimir</button>
                    </div>
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
  window.location="../reportes/ventasf";
    });

});

</script>

@endpush
@endsection