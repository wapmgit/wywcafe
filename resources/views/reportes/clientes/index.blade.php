@extends ('layouts.admin')
@section ('contenido')
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>
<div class="row">
	<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
		<h3>Indique la fecha para la consulta</h3>
		@include('reportes.clientes.search')
	</div>
</div>
@endsection
<?php $acum=0;$tventasf=0;$deb=0;$nvnew=0;$newpendiente=0;$newvendido=0;$repre2=0; $posi2=0;
$cefe=0; $reg=0;?>
@section ('reporte')
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
 @include('reportes.clientes.empresa')                
<div class="panel panel-primary">
<div class="panel-body">   
 <p align="right">
    <span ><?php echo date("d-m-Y",strtotime($searchText)); ?> al <?php echo date("d-m-Y",strtotime($searchText2)); ?> </span></p>

	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
      <table class="table table-striped table-bordered table-condensed table-hover">
	  <thead style="background-color: #E6E6E6"> <th colspan="7">Estadisticas por Ventas</th></thead>
        <thead style="background-color: #E6E6E6">
		  <th>Cliente</th>
          <th>Ventas</th>
		  <th>Promedio</th>
          <th>Total</th> 
	      <th>Pagado</th>		
	      <th>Saldo</th>		
	      <th>% V.</th>	
@foreach ($datos as $m)
<?php $reg++; $tventasf=$tventasf+$m->vendido; ?>
@endforeach		  
		</thead><?php $count=0; $deuda=0; $acump=0; $tmonto=0; $tdeuda=0;$tpendiente=$tventas=$tmiva=0; ?>
               @foreach ($datos as $q)
				<tr> <?php $count++; $tmonto=$tmonto+$q->vendido; $tdeuda=$tdeuda+($q->vendido-$q->pendiente);
				$tpendiente=$tpendiente+$q->pendiente; $tventas=$tventas+$q->nventas;
				if($datosm[0]->nombre==$q->nombre){ $posi2=$count; $repre2=$q->vendido;}
				?> 
				<td>{{ $q->nombre}}</td>
			<td>{{ $q->nventas}}</td>
			<td><?php echo number_format( $q->vpromedio,2,',','.'); ?></td>
			<td><?php echo number_format( $q->vendido,2,',','.'); ?></td>
			<td><?php echo number_format( ($q->vendido-$q->pendiente),2,',','.'); ?></td>
			<td><?php  echo number_format($q->pendiente, 2,',','.'); ?></td>	
			<td><?php  echo number_format((($q->vendido*100)/$tventasf), 2,',','.'); ?></td>	
			
				</tr>
				@endforeach
        <tr><td colspan="3"><strong>Total:<?php echo $count; ?></strong></td>
		<td><strong><?php echo number_format( $tmonto, 2,',','.'); ?></strong></td>
          <td><strong><?php echo number_format( $tdeuda, 2,',','.'); ?></strong></td>
          <td><strong><?php echo number_format( $tpendiente, 2,',','.'); ?></strong></td>	<td></td></tr>
			</table>
		</div>
			<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
      <table class="table table-striped table-bordered table-condensed table-hover">
	   <thead style="background-color: #E6E6E6"> <th colspan="6">Estadisticas por Monto Facturado</th></thead>
        <thead style="background-color: #E6E6E6">
		  <th>Cliente</th>
          <th>Ventas</th>
		  <th>Promedio</th>
          <th>Total</th> 
	      <th>Pagado</th>		
	      <th>Pendiente</th>		
		</thead><?php $count=0; $deuda=0; $acump=0; $tmonto=0; $tdeuda=0;$tpendiente=$repre=$posi=0; ?>
               @foreach ($datosm as $q)
				<tr> <?php $count++; $tmonto=$tmonto+$q->vendido; $tdeuda=$tdeuda+($q->vendido-$q->pendiente);
				$tpendiente=$tpendiente+$q->pendiente;
				if($datos[0]->nombre==$q->nombre){ $posi=$count; $repre=$q->vendido;}
				?> 
				<td>{{ $q->nombre}}</td>
			<td>{{ $q->nventas}}</td>
			<td><?php echo number_format( $q->vpromedio,2,',','.'); ?></td>
			<td><?php echo number_format( $q->vendido,2,',','.'); ?></td>
			<td><?php echo number_format( ($q->vendido-$q->pendiente),2,',','.'); ?></td>
			<td><?php  echo number_format($q->pendiente, 2,',','.'); ?></td>	
				</tr>
				@endforeach
        <tr><td colspan="3"><strong>Total:<?php echo $count; ?></strong></td>
		<td><strong><?php echo number_format( $tmonto, 2,',','.'); ?></strong></td>
          <td><strong><?php echo number_format( $tdeuda, 2,',','.'); ?></strong></td>
          <td><strong><?php echo number_format( $tpendiente, 2,',','.'); ?></strong></td></tr>
			</table>
		</div>
   <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
   <?php if($reg>0) {?>
   
    <div class="table-responsive">
<p> Total clientes registrados {{$nclientes}}, las ventas estan representadas por <?php echo $count; ?> clientes, esto equivale el 
<?php echo number_format( ((100*$count)/$nclientes), 2,',','.')."%"; ?> de la poblacion de clientes, para un total de <?php echo $tventas; ?> ventas,
 <?php echo $datos[0]->nombre; ?> es el cliente con mas ventas registradas y el <?php echo $posi; ?>° en cuanto a monto facturado lo que representa el
<?php echo number_format( ((100*$repre)/$tventasf), 2,',','.')."%"; ?> del total facturado en este periodo. </p>
<p>Basado en el Monto facturado,  <?php echo $datosm[0]->nombre; ?> es el cliente con mayor facturacion, sus Compras equivalen al
<?php echo number_format( ((100*$datosm[0]->vendido)/$tventasf), 2,',','.')."%"; ?>, para un total de <?php echo number_format($datosm[0]->vendido, 2,',','.'); ?> $,
posee un saldo pendiente de <?php echo number_format( (($datosm[0]->pendiente)), 2,',','.')."$"; ?> es el
<?php echo $posi2; ?>° cliente en cuanto a cantidad de facturas emitidas. </br>El porcentaje de pagos por el total de facturas emitidas del <?php echo date("d-m-Y",strtotime($searchText)); ?> al <?php echo date("d-m-Y",strtotime($searchText2)); ?> es de
<?php echo number_format( (($tdeuda*100/$tventasf)), 2,',','.')."%"; ?> </p>
@foreach ($vclientes as $m)
<?php $nvnew=$nvnew+$m->nventas; $newvendido=$newvendido+$m->vendido; $newpendiente=$newpendiente+$m->pendiente;?>
@endforeach	
<p> En este periodo se registraron <?php echo $newclientes; ?> clientes nuevos, lo que genero un total de <?php echo $nvnew; ?> ventas por un monto de <?php echo number_format($newvendido, 2,',','.')." $"; ?>, de las cuales se encuentra pendiente por cancelar <?php echo number_format($newpendiente, 2,',','.'); ?>
. Los nuevos clientes registraron el <?php echo number_format( (($newvendido*100)/($tventasf)), 2,',','.')."%";  ?> de las ventas del periodo.
(Clientes Nuevos: 
@foreach ($clientes2 as $m)
<?php echo $m->nombre.", ";?>
@endforeach	)</p>

   </div><?php } ?>
  </div>
  <div>

         <section class="content">
      <div class="row">
        <div class="col-md-6">
		          <div>
            <div class="box-header with-border">
              <h3 class="box-title">Ventas</h3>       
			  <span class="pull-right-container">
              <small class="label pull-right bg-yellow">Credito</small>
              <small class="label pull-right bg-green">Cobros</small>
              <small class="label pull-right bg-red">Ventas</small>
            </span>
              <div class="box-tools pull-right">
              </div>
            </div>
            <div class="box-body">
              <canvas id="pieChart" style="height:250px"></canvas>
            </div>
            <!-- /.box-body -->
          </div>
        </div>
		   <div class="col-md-6">
		               <div class="box-header with-border">
              <h3 class="box-title">Ventas</h3>       
			  <span class="pull-right-container">
			         <small class="label pull-right bg-green">Pendiente</small>
              <small class="label pull-right bg-blue">Ventas</small>
       
            </span>
              <div class="box-tools pull-right">
              </div>
            </div>
    <div class="box-tools pull-right">

              </div> 
			
			  <div class="box-body">
              <div class="chart">
                <canvas id="barChart" style="height:450px"></canvas>
              </div>
			  </div>
		
        <!-- /.col (RIGHT) -->
      </div>
	  </div>
      <!-- /.row -->

    </section>

  </div>
  </div>
  

           
 <label>Usuario: {{ Auth::user()->name }}</label>   
                  
                  	     </div>
                    </div><!-- /.row -->
                     <div class="col-lg-12 col-md-12 col-sm-6 col-xs-12">
                    <div class="form-group" align="center">
                     <button type="button" id="imprimir" class="btn btn-primary" data-dismiss="modal">Impimir</button>
            <!-- <a href="/reportes/compras/excel/"><button class="btn btn-warning">TXT</button></a> -->
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
  window.location="../reportes/clientes";
    });

});
</script>
  <?php if($reg>=5){?>
<script>
  $(function () {
 var areaChartData = {
      labels: [<?php echo "'".$datosm[0]->nombre."','".$datosm[1]->nombre."','".$datosm[2]->nombre."','".$datosm[3]->nombre."','".$datosm[4]->nombre."'";
		?> ],
      datasets: [
        {
          label: "Ventas",
          fillColor: "rgba(23, 125, 204, 1)",
          strokeColor: "rgba(23, 125, 204, 1)",
          pointColor: "rgba(23, 125, 204, 1)",
          pointStrokeColor: "#c1c7d1",
          pointHighlightFill: "#fff",
          pointHighlightStroke: "rgba(220,220,220,1)",
          data: [
		<?php echo $datosm[0]->vendido.",".$datosm[1]->vendido.",".$datosm[2]->vendido.",".$datosm[3]->vendido.",".$datosm[4]->vendido;
		?>  ]
        },
        {
          label: "Pendiente",
          fillColor: "rgba(60,141,188,0.9)",
          strokeColor: "rgba(60,141,188,0.8)",
          pointColor: "#3b8bba",
          pointStrokeColor: "rgba(60,141,188,1)",
          pointHighlightFill: "#fff",
          pointHighlightStroke: "rgba(60,141,188,1)",
  data: [
		<?php echo $datosm[0]->pendiente.",".$datosm[1]->pendiente.",".$datosm[2]->pendiente.",".$datosm[3]->pendiente.",".$datosm[4]->pendiente;
		?>  ]
        }
      ]
    };

    var areaChartOptions = {
      //Boolean - If we should show the scale at all
      showScale: true,
      //Boolean - Whether grid lines are shown across the chart
      scaleShowGridLines: false,
      //String - Colour of the grid lines
      scaleGridLineColor: "rgba(0,0,0,.05)",
      //Number - Width of the grid lines
      scaleGridLineWidth: 1,
      //Boolean - Whether to show horizontal lines (except X axis)
      scaleShowHorizontalLines: true,
      //Boolean - Whether to show vertical lines (except Y axis)
      scaleShowVerticalLines: true,
      //Boolean - Whether the line is curved between points
      bezierCurve: true,
      //Number - Tension of the bezier curve between points
      bezierCurveTension: 0.3,
      //Boolean - Whether to show a dot for each point
      pointDot: false,
      //Number - Radius of each point dot in pixels
      pointDotRadius: 4,
      //Number - Pixel width of point dot stroke
      pointDotStrokeWidth: 1,
      //Number - amount extra to add to the radius to cater for hit detection outside the drawn point
      pointHitDetectionRadius: 20,
      //Boolean - Whether to show a stroke for datasets
      datasetStroke: true,
      //Number - Pixel width of dataset stroke
      datasetStrokeWidth: 2,
      //Boolean - Whether to fill the dataset with a color
      datasetFill: true,
      //String - A legend template
      legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].lineColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>",
      //Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
      maintainAspectRatio: true,
      //Boolean - whether to make the chart responsive to window resizing
      responsive: true
    };

    
    var pieOptions = {
      //Boolean - Whether we should show a stroke on each segment
      segmentShowStroke: true,
      //String - The colour of each segment stroke
      segmentStrokeColor: "#fff",
      //Number - The width of each segment stroke
      segmentStrokeWidth: 2,
      //Number - The percentage of the chart that we cut out of the middle
      percentageInnerCutout: 50, // This is 0 for Pie charts
      //Number - Amount of animation steps
      animationSteps: 100,
      //String - Animation easing effect
      animationEasing: "easeOutBounce",
      //Boolean - Whether we animate the rotation of the Doughnut
      animateRotate: true,
      //Boolean - Whether we animate scaling the Doughnut from the centre
      animateScale: false,
      //Boolean - whether to make the chart responsive to window resizing
      responsive: true,
      // Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
      maintainAspectRatio: true,
      //String - A legend template
      legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<segments.length; i++){%><li><span style=\"background-color:<%=segments[i].fillColor%>\"></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>"
    };
  

    //-------------
    //- BAR CHART -
    //-------------
    var barChartCanvas = $("#barChart").get(0).getContext("2d");
    var barChart = new Chart(barChartCanvas);
    var barChartData = areaChartData;
    barChartData.datasets[1].fillColor = "#00a65a";
    barChartData.datasets[1].strokeColor = "#00a65a";
    barChartData.datasets[1].pointColor = "#00a65a";
    var barChartOptions = {
      //Boolean - Whether the scale should start at zero, or an order of magnitude down from the lowest value
      scaleBeginAtZero: true,
      //Boolean - Whether grid lines are shown across the chart
      scaleShowGridLines: true,
      //String - Colour of the grid lines
      scaleGridLineColor: "rgba(0,0,0,.05)",
      //Number - Width of the grid lines
      scaleGridLineWidth: 1,
      //Boolean - Whether to show horizontal lines (except X axis)
      scaleShowHorizontalLines: true,
      //Boolean - Whether to show vertical lines (except Y axis)
      scaleShowVerticalLines: true,
      //Boolean - If there is a stroke on each bar
      barShowStroke: true,
      //Number - Pixel width of the bar stroke
      barStrokeWidth: 2,
      //Number - Spacing between each of the X value sets
      barValueSpacing: 5,
      //Number - Spacing between data sets within X values
      barDatasetSpacing: 1,
      //String - A legend template
      legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].fillColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>",
      //Boolean - whether to make the chart responsive
      responsive: true,
      maintainAspectRatio: true
    };

    barChartOptions.datasetFill = false;
    barChart.Bar(barChartData, barChartOptions);
    //-------------
    //- PIE CHART -
    //-------------
    // Get context with jQuery - using jQuery's .get() method.
    var pieChartCanvas = $("#pieChart").get(0).getContext("2d");
    var pieChart = new Chart(pieChartCanvas);
    var PieData = [
      {
        value: <?php echo $tventasf; ?>,
        color: "#f56954",
        highlight: "#f56954",
        label: "Ventas"
      },
      {
        value: <?php echo $tdeuda; ?>,
        color: "#00a65a",
        highlight: "#00a65a",
        label: "Cobros"
      },
      {
        value:  <?php echo $tpendiente; ?>,
        color: "#f39c12",
        highlight: "#f39c12",
        label: "Pendiente"
      }
    ];
    var pieOptions = {
      //Boolean - Whether we should show a stroke on each segment
      segmentShowStroke: true,
      //String - The colour of each segment stroke
      segmentStrokeColor: "#fff",
      //Number - The width of each segment stroke
      segmentStrokeWidth: 2,
      //Number - The percentage of the chart that we cut out of the middle
      percentageInnerCutout: 50, // This is 0 for Pie charts
      //Number - Amount of animation steps
      animationSteps: 100,
      //String - Animation easing effect
      animationEasing: "easeOutBounce",
      //Boolean - Whether we animate the rotation of the Doughnut
      animateRotate: true,
      //Boolean - Whether we animate scaling the Doughnut from the centre
      animateScale: false,
      //Boolean - whether to make the chart responsive to window resizing
      responsive: true,
      // Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
      maintainAspectRatio: true,
      //String - A legend template
      legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<segments.length; i++){%><li><span style=\"background-color:<%=segments[i].fillColor%>\"></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>"
    };
    //Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    pieChart.Doughnut(PieData, pieOptions);

  });
</script>
	  <?php } ?>
@endpush
@endsection