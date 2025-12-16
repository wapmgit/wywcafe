@extends ('layouts.admin')
<?php $mostrar=0; ?>
  @if(Auth::user()->nivel=="A")
@section ('contenido')
<style>
.multiselect {
  width: 200px;
}

.selectBox {
  position: relative;
}

.selectBox select {
  width: 100%;
  font-weight: bold;
}

.overSelect {
  position: absolute;
  left: 0;
  right: 0;
  top: 0;
  bottom: 0;
}

#checkboxes {
  display: none;
  border: 1px #dadada solid;
}

#checkboxes label {
  display: block;
}

#checkboxes label:hover {
  background-color: #1e90ff;
}
</style>
<?php $mostrar=1; ?>
<div class="row" id="buscar" style="display: true">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<h3>Indique la fecha para la consulta</h3>
		@include('reportes.ventas.search')
	</div>
</div>

@endsection
@endif
<?php $acum=0;$efe=0;$deb=0;$che=0;$tra=0; $tingventas=0; $tingabono=0;
$cefe=0;
if($fechafiltro=="v.fechahora"){$filtro="Emision";}else{$filtro="Despacho";} 
?>
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

    @include('reportes.ventas.empresa')
 <h4 align="center">REPORTE DE VENTAS</h4>  <p align="right"> Vendedor: {{$vende}} / <?php echo $filtro; ?>
    <span ><?php echo date("d-m-Y",strtotime($searchText)); ?> al <?php echo date("d-m-Y",strtotime($searchText2)); ?> </span></p>
    <div class="table-responsive">
    <table width="100%">
        <thead style="background-color: #E6E6E6">
          <th>N°</th>
          <th>Fecha</th>
		  <th>Cliente </th>
		  <th>Telefono </th>
		  <!-- <th>Direccion </th> -->
          <th>Doc.</th>
          <th>Condicion</th>
          <th>Monto</th>
          <th>Saldo</th>
        </thead>
        <?php $ctra= 0; $cche=0; $acums=0;  $acumfac=$acumnot=0; $mret=0; $cdeb=0; $credito=0; $contado=0;  $acumdevolu=0; $count=0;?>

               @foreach ($datos as $q)
               <?php $count++;
			   $mret=$mret+$q->mret;
if($q->devolu==1){$acumdevolu=$acumdevolu+ $q->total_venta; }
if($q->estado==="Credito"){ $credito=$credito + $q->total_venta; }
if ($q->forma==0){$acumnot=($acumnot+$q->total_venta);}else{$acumfac=($acumfac+$q->total_venta);}

?> 
        <tr <?php if($mostrar==0){?> style="display:none" <?php } ?> >
          <td><small><small><?php echo $count; ?></small></small></td>
          <td><small><small> <?php echo date("d-m-Y",strtotime($q->fecha_emi)); ?> </small></small></td>
		   <td><small><small>{{ $q->nombre}}</small></small></td>
		   <td><small><small>{{ $q->telefono}}</small></small></td>
		   <!--<td><small><small>{{ $q->direccion}}</small></small></td>-->
          <td><small><?php if ($q->forma==0){ echo "NOT";}else{ echo "FAC";}?>-{{ $q->num_comprobante}} <?php if ($q->devolu>0){ echo "- Devuelta";}?></small></td>       
          <td><small>{{ $q->estado}}</small></td>       
		  <td><small><?php $acum=$acum+ $q->total_venta; echo number_format($q->total_venta, 2,',','.'); ?></small></td>
		  <td><small><?php $acums=$acums+ $q->saldo; echo number_format($q->saldo, 2,',','.'); ?></small></td>
        </tr>
       
        @endforeach
	      <tr >
        <td colspan="2"> <strong>TOTAL:</strong></td>
        <td colspan="2"> <strong>FAC: <?php echo number_format($acumfac, 2,',','.')." $"; ?></strong></td>
        <td colspan="2"> <strong>NOT: <?php echo number_format($acumnot, 2,',','.')." $"; ?></strong></td>
          <td><strong><?php echo number_format($acum, 2,',','.')." $"; ?></strong></td>
			<td><strong><?php echo number_format($acums, 2,',','.')." $"; ?></strong></td>
          <td ></td>
        
        </tr>

      </table>
</div>
  </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
    <div class="table-responsive">
      <table class="table table-striped table-bordered table-condensed table-hover">
      <thead >
        
          <tr><td colspan="3" align="center" style="background-color: #E6E6E6"><strong>DESGLOSE DE VENTAS<strong></td></tr>
          <th>Moneda</th>
          <th>Recibido</th>
          <th>Monto</th>       
        </thead>
		 @foreach ($pagos as $q)
		 <?php if($q->tiporecibo =="P"){ $tingventas=$tingventas+$q->monto;?>
		<tr >
        <td>{{$q->idbanco}}</td>
		<td><?php echo number_format($q->recibido, 2,',','.'); ?></td>
		<td><?php echo number_format($q->monto, 2,',','.')." $"; ?></td>
		 </tr> <?php } ?>  @endforeach
      </table>
    </div>
  </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
    <div class="table-responsive">
      <table class="table table-striped table-bordered table-condensed table-hover">
      <thead >
        
          <tr><td colspan="3" align="center" style="background-color: #E6E6E6"><strong>ABONOS<strong></td></tr>
          <th>Moneda</th>
          <th>Recibido</th>
          <th>Monto</th>
         
        </thead>
		 @foreach ($pagos as $q)
		 	 <?php if($q->tiporecibo == "A"){ $tingabono=$tingabono+$q->monto;?>
		<tr >
        <td>{{$q->idbanco}}</td>
		<td><?php echo number_format($q->recibido, 2,',','.'); ?></td>
		<td><?php echo number_format($q->monto, 2,',','.')." $"; ?></td>
        </tr>   <?php } ?> @endforeach
      </table>
    </div>
  </div>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="table-responsive">
       <table class="table table-striped table-bordered table-condensed table-hover" width="100%">
      <thead style="background-color: #E6E6E6">        
          <th>Ventas Contado</th>
          <th>Ventas  Credito</th>
          <th>Devoluciones</th>
          <th>Retenciones</th>
            <th>Total Venta</th>
		  
          <th></th>
        </thead>
      <tr > 
       
          <td><?php echo number_format($acum-$credito, 2,',','.')." $"; ?></td>
          <td><?php echo number_format($credito, 2,',','.')." $"; ?></td>
		   <td><?php echo number_format($acumdevolu, 2,',','.')." $"; ?></td>
		   <td><?php echo number_format($mret, 2,',','.')." $"; ?></td>
		     <td><?php echo number_format(($acum-$acumdevolu), 2,',','.')." $"; ?></td>
		    
        </tr>
      </table>
    </div></div>
      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="table-responsive">
  <table class="table table-striped table-bordered table-condensed table-hover">
      <thead style="background-color: #E6E6E6">
        
          <th>Devoluciones que Generaron N/C</th>
          <th>Total Ingreso Ventas</th>
          <th></th>
   
        </thead>
         @foreach ($devolucion as $dev)
        <tr >
          <td><?php $devolu=$dev->totaldev; echo number_format($devolu, 2,',','.')." $"; ?></td>
          <td><?php $caja=($tingventas+$tingabono); echo number_format($caja, 2,',','.')." $"; ?></td>
          <td><strong></strong></td>        
        </tr>
        @endforeach
      </table>
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
  window.location="../reportes/ventas";
    });
		$('#rutas').change(function(){
		var idruta = $('#rutas').val();
		if(idruta==1000){
		document.getElementById('divrutaund').style.display="";
		}else{
		document.getElementById('divrutaund').style.display="none";
		}
    });

});
var expanded = false;

function showCheckboxes() {
  var checkboxes = document.getElementById("checkboxes");
  if (!expanded) {
    checkboxes.style.display = "block";
    expanded = true;
  } else {
    checkboxes.style.display = "none";
    expanded = false;
  }
}
</script>

@endpush
@endsection