@extends ('layouts.admin')
@section ('contenido')
<?php
  $cuentacli=$cuentapro=$cuentaar=$cuentave=0;
?>
<div class="row" id="search" style="display: true">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<h3>Indique la fecha para la consulta</h3>
		@include('reportes.articulografico.search')
	</div>
</div>
@endsection
@section('reporte')
<div class="row">
              <h3 align="center"> Compras/Ventas {{$filtro}}</h3>
              <h4 align="center">{{$vende}}</h4>
              <div class="box-tools pull-right">
            <!--    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
				-->
              </div> 
			  <div class="box-body">
              <div class="chart">
                <canvas id="barChart" style="height:400px"></canvas>
              </div>
			  </div>
			  <div class="col-lg-12 col-xs-12">
			  <div class="table-responsive">
			      <table class="table table-striped table-bordered table-condensed table-hover">
        <thead >
          <th></th>
          <th>Enero</th><th>Febrero</th><th>Marzo</th><th>Abril</th><th>Mayo</th><th>Junio</th><th>Julio</th><th>Agosto</th><th>Septiembre</th><th>Octubre</th><th>Noviembre</th><th>Diciembre</th>
        </thead>    
		<tbody>
		<tr>
          <td style="background-color: #2b92da" align="center"><strong>Compras</strong></td>
          <td><?php   echo number_format($cene->total, 2,',','.'); ?></td>
          <td><?php echo number_format($cfeb->total, 2,',','.'); ?></td>  
		  <td><?php echo number_format($cmar->total, 2,',','.'); ?></td>
		  <td><?php   echo number_format($cabr->total, 2,',','.'); ?></td>
          <td><?php echo number_format($cmay->total, 2,',','.'); ?></td>  
		  <td><?php echo number_format($cjun->total, 2,',','.'); ?></td> 
		  <td><?php   echo number_format($cjul->total, 2,',','.'); ?></td>
          <td><?php echo number_format($cago->total, 2,',','.'); ?></td>  
		  <td><?php echo number_format($csep->total, 2,',','.'); ?></td>
		  <td><?php   echo number_format($coct->total, 2,',','.'); ?></td>
          <td><?php echo number_format($cnov->total, 2,',','.'); ?></td>  
		  <td><?php echo number_format($cdic->total, 2,',','.'); ?></td>     		  
        </tr>
			<tr>
          <td style="background-color: #34bf75" align="center"><strong>Ventas</strong></td>
          <td><?php   echo number_format($vene->total, 2,',','.'); ?></td>
          <td><?php echo number_format($vfeb->total, 2,',','.'); ?></td>  
		  <td><?php echo number_format($vmar->total, 2,',','.'); ?></td>
		  <td><?php   echo number_format($vabr->total, 2,',','.'); ?></td>
          <td><?php echo number_format($vmay->total, 2,',','.'); ?></td>  
		  <td><?php echo number_format($vjun->total, 2,',','.'); ?></td> 
		  <td><?php   echo number_format($vjul->total, 2,',','.'); ?></td>
          <td><?php echo number_format($vago->total, 2,',','.'); ?></td>  
		  <td><?php echo number_format($vsep->total, 2,',','.'); ?></td>
		  <td><?php   echo number_format($voct->total, 2,',','.'); ?></td>
          <td><?php echo number_format($vnov->total, 2,',','.'); ?></td>  
		  <td><?php echo number_format($vdic->total, 2,',','.'); ?></td>     		  
        </tr>
			<tr>
          <td style="background-color: #FFDF20" align="center"><strong>%</strong></td>
          <td><?php  if($cene->total*1>0){ echo number_format((($vene->total*100)/$cene->total), 2,',','.'); }?></td>
          <td><?php if($cfeb->total*1>0){ echo number_format((($vfeb->total*100)/$cfeb->total), 2,',','.');} ?></td>  
		  <td><?php if($cmar->total*1>0){ echo number_format((($vmar->total*100)/$cmar->total), 2,',','.');} ?></td>
		  <td><?php if($cabr->total*1>0){  echo number_format((($vabr->total*100)/$cabr->total), 2,',','.');} ?></td>
          <td><?php if($cmay->total*1>0){ echo number_format((($vmay->total*100)/$cmay->total), 2,',','.');} ?></td>  
		  <td><?php if($cjun->total*1>0){ echo number_format((($vjun->total*100)/$cjun->total), 2,',','.');} ?></td> 
		  <td><?php if($cjul->total*1>0){  echo number_format((($vjul->total*100)/$cjul->total), 2,',','.');} ?></td>
          <td><?php if($cago->total*1>0){ echo number_format((($vago->total*100)/$cago->total), 2,',','.');} ?></td>  
		  <td><?php if($csep->total*1>0){ echo number_format((($vsep->total*100)/$csep->total), 2,',','.');} ?></td>
		  <td><?php if($cnov->total*1>0){  echo number_format((($vnov->total*100)/$coct->total), 2,',','.');} ?></td>
          <td><?php if($cnov->total*1>0){ echo number_format((($vnov->total*100)/$cnov->total), 2,',','.');} ?></td>  
		  <td><?php if($cdic->total*1>0){ echo number_format((($vdic->total*100)/$cdic->total), 2,',','.');} ?></td>     		  
        </tr>
		</tbody>
      </table>
	  </div>
	  </div>
</div>
           

 @push('scripts')
<script>
$(document).ready(function(){
//alert('si');
  $(function () {
    /* ChartJS
     * -------
     * Here we will create a few charts using ChartJS
     */

    //--------------
    //- AREA CHART -
    //--------------

    var areaChartData = {
      labels: ["Enero","Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"],
      datasets: [
        {
          label: "Compras",
          fillColor: "rgba(23, 125, 204, 1)",
          strokeColor: "rgba(23, 125, 204, 1)",
          pointColor: "rgba(23, 125, 204, 1)",
          pointStrokeColor: "#c1c7d1",
          pointHighlightFill: "#fff",
          pointHighlightStroke: "rgba(220,220,220,1)",
          data: [
		<?php echo $cene->total.",".$cfeb->total.",".$cmar->total.",".$cabr->total.",".$cmay->total.",".$cjun->total.",".$cjul->total.",".$cago->total.",".$csep->total.",".$coct->total.",".$cnov->total.",".$cdic->total;
		?>  ]
        },
        {
          label: "Ventas",
          fillColor: "rgba(60,141,188,0.9)",
          strokeColor: "rgba(60,141,188,0.8)",
          pointColor: "#3b8bba",
          pointStrokeColor: "rgba(60,141,188,1)",
          pointHighlightFill: "#fff",
          pointHighlightStroke: "rgba(60,141,188,1)",
  data: [
		<?php echo $vene->total.",".$vfeb->total.",".$vmar->total.",".$vabr->total.",".$vmay->total.",".$vjun->total.",".$vjul->total.",".$vago->total.",".$vsep->total.",".$voct->total.",".$vnov->total.",".$vdic->total;
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
  }); $(function () {
    /* ChartJS
     * -------
     * Here we will create a few charts using ChartJS
     */

    //--------------
    //- AREA CHART -
    //--------------

    var areaChartData = {
      labels: ["Enero","Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"],
      datasets: [
        {
          label: "Compras",
          fillColor: "rgba(23, 125, 204, 1)",
          strokeColor: "rgba(23, 125, 204, 1)",
          pointColor: "rgba(23, 125, 204, 1)",
          pointStrokeColor: "#c1c7d1",
          pointHighlightFill: "#fff",
          pointHighlightStroke: "rgba(220,220,220,1)",
          data: [
		<?php echo $cene->total.",".$cfeb->total.",".$cmar->total.",".$cabr->total.",".$cmay->total.",".$cjun->total.",".$cjul->total.",".$cago->total.",".$csep->total.",".$coct->total.",".$cnov->total.",".$cdic->total;
		?>  ]
        },
        {
          label: "Ventas",
          fillColor: "rgba(60,141,188,0.9)",
          strokeColor: "rgba(60,141,188,0.8)",
          pointColor: "#3b8bba",
          pointStrokeColor: "rgba(60,141,188,1)",
          pointHighlightFill: "#fff",
          pointHighlightStroke: "rgba(60,141,188,1)",
  data: [
		<?php echo $vene->total.",".$vfeb->total.",".$vmar->total.",".$vabr->total.",".$vmay->total.",".$vjun->total.",".$vjul->total.",".$vago->total.",".$vsep->total.",".$voct->total.",".$vnov->total.",".$vdic->total;
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
  });

  })
</script>
@endpush
@endsection