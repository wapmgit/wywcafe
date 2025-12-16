@extends ('layouts.admin')
<?php $mostrar=0; 
			$lonORG = count($articulos);
			$cntart=0;
			foreach($articulos as $t){
			$arrayidart[]=$t->idarticulo;
			$arraynombre[]=0;
			$arraypventa[]=0;
			$arraygrupo[]=0;
			$arraymonto[]=0;
			$arrayvendido[]=0;
			}
			$longCP = count($datos);
			foreach($datos as $n){
			$idart[] = $n->idarticulo;
			$nombre[] = $n->nombre;
			$grupo[] = $n->grupo;
			$pventa[] = $n->pventa;
			$cnt[] = $n->vendido;
			} 
		for ($i=0;$i<$lonORG;$i++){
				for($j=0;$j<$longCP;$j++){
				if ($arrayidart[$i]==$idart[$j]){					
					$arrayvendido[$i]=$cnt[$j];
					$arraynombre[$i]=$nombre[$j];
					$arraypventa[$i]=$pventa[$j];
					$arraymonto[$i]=($pventa[$j]*$cnt[$j]);
					$arraygrupo[$i]=$grupo[$j];
				}
				}
			}
			$longCP = count($datosa);
			foreach($datosa as $n){
			$idart[] = $n->idarticulo;
			$nombre[] = $n->nombre;
			$grupo[] = $n->grupo;
			$pventa[] = $n->pventa;
			$cnt[] = $n->vendido;
			} 
		for ($i=0;$i<$lonORG;$i++){
				for($j=0;$j<$longCP;$j++){
				if ($arrayidart[$i]==$idart[$j]){	
					$dat=$arrayvendido[$i];				
					$arrayvendido[$i]=$dat+$cnt[$j];
					$arraynombre[$i]=$nombre[$j];
					$arraypventa[$i]=$pventa[$j];
					$arraymonto[$i]=($arraymonto[$i]+($pventa[$j]*$cnt[$j]));
					$arraygrupo[$i]=$grupo[$j];
					
				}
				}
			}
			$ruta="Ruta";
	$longitud = count($opt);		
			//dd();
					for ($i=0;$i<$longitud;$i++){
						$ruta=$ruta." ".$opt[$i];
					}
	
?>
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

<div class="row" id="search" style="display: true">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<h3>Indique la fecha para la consulta</h3>
		@include('reportes.ventasarticulo.search')
	</div>
</div>

@endsection
@endif
<?php $acum=0;$efe=0;$deb=0;$che=0;$tra=0;
$cefe=0;?>
@section('reporte')
<div class="row">
            <div class="col-md-12">
              <div class="box">
          
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

    @include('reportes.ventasarticulo.empresa')
<p align="right">
  	<?Php if($fecha=="fecha"){ echo "<b>Facturacion</b>"; }else{ echo "<b>Emision</b>"; }  ?>  <span ><?php echo date("d-m-Y",strtotime($searchText)); ?> al <?php echo date("d-m-Y",strtotime($searchText2)); ?> </span>
<?php echo $ruta; ?>
	</p>
	<div class="table-responsive">
 <!--     <table class="table table-striped table-bordered table-condensed table-hover">
        <thead style="background-color: #E6E6E6" >
       
          <th>Nombre/ Pv Promedio</th>
          <th>Grupo</th>
          <th>Precio Venta</th>
          <th>Cantidad</th>
          <th>Monto</th>
      
        </thead>
        <?php $ctra= 0; $acumcnt=0; $cdeb=0; $credito=0; $contado=0;$real=0; $count=0;$tventa=0; $auxp=$auxpv=0;

          for ($i=0;$i<$lonORG;$i++){
			  $acumcnt+=$arrayvendido[$i];
			  $tventa+=$arraymonto[$i];
			  if($arrayvendido[$i]>0){
			?>
        <tr>
         
          <td><?php echo $arraynombre[$i]; ?></td>
          <td><?php echo $arraygrupo[$i]; ?></td>
          <td><?php echo number_format($arraypventa[$i], 2,',','.'); ?></td>
          <td><?php echo number_format($arrayvendido[$i], 2,',','.'); ?></td>
          <td><?php echo number_format(($arraymonto[$i]), 2,',','.'); ?></td>
     
       </tr>
		  <?php 
		  	}
		  } ?>
      
		<tr><td colspan="3" align="right"><strong> Total Venta:</strong></td><td><strong><?php echo $acumcnt." Unds"; ?></strong></td><td><strong><?php echo number_format(($tventa), 2,',','.')." $"; ?></strong></td></tr>
      </table> -->
	  </div> 
	  	<div class="table-responsive">
      <table class="table table-striped table-bordered table-condensed table-hover">
        <thead style="background-color: #E6E6E6" >
       
          <th>Nombre/ Pv Promedio</th>
          <th>Grupo</th>
          <th>Precio Venta</th>
          <th>Cantidad</th>
          <th>Monto</th>
      
        </thead>
        <?php $ctra= 0; $acumcnt=0; $cdeb=0; $credito=0; $contado=0;$real=0; $count=0;$tventa=0; $auxp=$auxpv=0;?>

               @foreach ($articulos as $art)
			   <?php $cnt=0; $pv=0;?> 
				 @foreach ($datos as $da)
				 <?php if($art->idarticulo==$da->idarticulo){ $pv=$da->vpromedio; $cnt=$cnt+$da->vendido; } ?>
				  @endforeach
				   @foreach ($datosa as $dab)
				 <?php if($art->idarticulo==$dab->idarticulo){  $pv=$dab->vpromedio; $cnt=$cnt+$dab->vendido; } ?>
				  @endforeach
		<?php if($cnt>0) { 
		$acumcnt =$acumcnt+$cnt;  $tventa=$tventa+($pv*$cnt); ?>
        <tr>
         
          <td>{{ $art->nombre}}</td>
          <td>{{ $art->grupo}}</td>
          <td><?php echo number_format($pv, 2,',','.'); ?></td>
           <td><?php echo number_format(($cnt), 2,',','.'); ?></td>
           <td><?php echo number_format(($pv*$cnt), 2,',','.'); ?></td>       
       </tr>
	   <?php } ?>
        @endforeach
		<tr><td colspan="3" align="right"><strong> Total Venta:</strong></td><td><strong><?php echo $acumcnt." Unds"; ?></strong></td><td><strong><?php echo number_format(($tventa), 2,',','.')." $"; ?></strong></td></tr>
      </table>
	  </div>

  </div>

    </div>
     <label>  Usuario: {{ Auth::user()->name }}</label>    
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
  window.location="/reportes/ventasarticulo";
    });
	$("#filtro").on("change",function(){
		var variable=$("#filtro").val();							
		if( variable==1){
			document.getElementById('divend').style.display=""; 
			document.getElementById('divruta').style.display="none"; 
			document.getElementById('divcli').style.display="none"; 
			$("#idcliente").val(0);
		}
		if( variable==2){
			document.getElementById('divend').style.display="none"; 
			document.getElementById('divcli').style.display=""; 
			document.getElementById('divruta').style.display="none"; 
			$("#idvendedor").val(0);
		}
		if( variable==3){
			
			document.getElementById('divruta').style.display=""; 
			document.getElementById('divend').style.display="none"; 
			document.getElementById('divcli').style.display="none"; 
			$("#idvendedor").val(0);
		}
		if( variable==4){
			
			document.getElementById('divrutaund').style.display=""; 
			document.getElementById('divruta').style.display="none"; 
			document.getElementById('divend').style.display="none"; 
			document.getElementById('divcli').style.display="none"; 
			$("#idvendedor").val(0);
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