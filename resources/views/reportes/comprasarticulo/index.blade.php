@extends ('layouts.admin')
<?php $mostrar=0; ?>
  @if(Auth::user()->nivel=="A")
@section ('contenido')
<?php $mostrar=1; ?>
<div class="row" id="search" style="display: true">
	<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
		<h3>Indique la fecha para la consulta</h3>
		@include('reportes.comprasarticulo.search')
	</div>
</div>

@endsection
@endif
<?php $acum=0;$efe=0;$deb=0;$che=0;$tra=0;
$cefe=0;?>
@section('reporte')
<div class="row">
            <div class="col-md-12">
      
                <!-- /.box-header -->
                                  

<div class="panel panel-primary">
<div class="panel-body">
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
@include('reportes.compras.empresa')
    <h3 align="center">REPORTE DE COMPRAS POR ARTICULO</h3> <p align="right">
     <?php  echo $fecha=date_format(date_create($searchText),'d-m-Y');?> al
       <?php  echo $fecha2=date_format(date_create($searchText2),'d-m-Y');?></p>
      <table class="table table-striped table-bordered table-condensed table-hover">
        <thead >
       
          <th>Nombre </th>
          <th>Grupo</th>
          <th>P. compra Promedio</th>
          <th>Cantidad</th>
          <th>Monto</th>
      
        </thead>
        <?php $ctra= 0; $acumventas=0; $smonto=0;$cche=0; $cdeb=0; $credito=0; $contado=0;$real=0; $count=0;$tventa=0;?>

               @foreach ($datos as $q)
            <?php $tventa=$tventa +($q->vendido*$q->pventa); ?>
        <tr>
         
          <td>{{ $q->nombre}}</td>
          <td>{{ $q->grupo}} </td>
          <td><?php 
$vp=number_format(($q->vpromedio), 2,',','.');
$pv=number_format(($q->pventa), 2,',','.');

          if ($vp == $pv) {$real=$q->pventa; echo number_format($q->vpromedio, 2,',','.'); }
		  else { $real=($q->subtotal/$q->vendido); echo number_format(($q->vpromedio), 2,',','.');}
		  ?></td>
                    <td>{{ $q->vendido}}</td>
                              <td><?php
                            $smonto=($q->vendido*$real);
                               echo number_format(($smonto), 2,',','.'); $acumventas=$acumventas+$smonto;?></td>       
       </tr>
        @endforeach
		<tr><td colspan="3" ><td align="left"> Total Compras:</td><td><strong><?php echo number_format(($acumventas), 2,',','.'); ?></strong></td></tr>
      </table>
  </div>

    </div>
  
  </div>
<label>Usuario: {{ Auth::user()->name }}</label>    
  </div>
	             

                  
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
  window.location="../reportes/comprasarticulo/";
    });

});

</script>

@endpush
@endsection